<?php
require_once('inc/class-assets.php');
require_once('inc/class-admin.php');
require_once('inc/class-media.php');
require_once('inc/class-layout-modules.php');

function starterkit_setup(): void {
    new Starterkit_Classic\Starterkit_Assets();
    new Starterkit_Classic\Starterkit_Admin();
    new Starterkit_Classic\Starterkit_Media();
    new Starterkit_Classic\Starterkit_Layout_Modules();
}
add_action('after_setup_theme', 'starterkit_setup', 10);


/**
 * Define constants
 * See https://stackoverflow.com/questions/1290318/php-constants-containing-arrays if using PHP < 7
 */
function starterkit_register_constants(): void {
	define('THEME_STARTERKIT_VERSION', '3.0.0');
	define('MODULES_FIELD_NAME', 'content_modules');
	define('MODULES_POST_TYPES', array('page'));
	define('MODULES_PARTIAL_PATH', 'modules/');
	//define('MODULES_TAXONOMIES', array('category'));
	//define('MODULES_OPTIONS_PAGES', array()); // TODO
	define('PAGE_FOR_POSTS', get_option('page_for_posts'));

	if(class_exists('ACF')) {
		// Get it from options table instead of using ACF get_field()
		// due to loading order of ACF and theme
		$acf_gmaps_key = get_option('options_google_maps_api_key');
	}
	if(isset($acf_gmaps_key)) {
		define('GMAPS_KEY', $acf_gmaps_key);
	}
	else {
		define('GMAPS_KEY', '');
	}
}
add_action('after_setup_theme', 'starterkit_register_constants');


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 * Priority 0 to make it available to lower priority callbacks.
 * @wp-hook
 * @global int $content_width
 */
function starterkit_content_width(): void {
	$GLOBALS['content_width'] = apply_filters('starterkit_content_width', 640);
}
add_action('after_setup_theme', 'starterkit_content_width', 0);
