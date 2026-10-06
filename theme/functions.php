<?php
/**
 * Theme setup.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

require_once get_theme_file_path( 'inc/logo.php' );
require_once get_theme_file_path( 'inc/options.php' );
require_once get_theme_file_path( 'inc/post-types.php' );
require_once get_theme_file_path( 'inc/content.php' );
require_once get_theme_file_path( 'inc/blocks.php' );
require_once get_theme_file_path( 'inc/components.php' );

/**
 * Registers theme supports and menu locations.
 */
function finsweet_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support(
		'html5',
		array( 'search-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' )
	);

	register_nav_menus(
		array(
			'primary' => __( 'Header menu', 'finsweet' ),
			'footer'  => __( 'Footer menu', 'finsweet' ),
		)
	);
}
add_action( 'after_setup_theme', 'finsweet_setup' );

/**
 * Removes core default font size and spacing presets.
 *
 * Core still prints their CSS variables (in rem) even when theme.json
 * disables them; the theme uses only its own px-based presets.
 *
 * @param WP_Theme_JSON_Data $theme_json Core default theme.json data.
 * @return WP_Theme_JSON_Data
 */
function finsweet_remove_default_presets( $theme_json ) {
	$data = $theme_json->get_data();

	unset(
		$data['settings']['typography']['fontSizes'],
		$data['settings']['spacing']['spacingSizes'],
		$data['settings']['spacing']['spacingScale']
	);

	return new WP_Theme_JSON_Data( $data, 'default' );
}
add_filter( 'wp_theme_json_data_default', 'finsweet_remove_default_presets' );

/**
 * Enqueues the compiled front-end styles (run `npm run build` first).
 */
function finsweet_enqueue_assets() {
	$asset_file = get_theme_file_path( 'assets/build/main.asset.php' );

	if ( ! file_exists( $asset_file ) ) {
		return;
	}

	$asset = require $asset_file;

	wp_enqueue_style(
		'finsweet-main',
		get_theme_file_uri( 'assets/build/main.css' ),
		array(),
		$asset['version']
	);
	wp_style_add_data( 'finsweet-main', 'rtl', 'replace' );

	wp_enqueue_script(
		'finsweet-main',
		get_theme_file_uri( 'assets/build/main.js' ),
		$asset['dependencies'],
		$asset['version'],
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'finsweet_enqueue_assets' );
