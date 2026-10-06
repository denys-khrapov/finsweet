<?php
/**
 * Site logo from the Customizer (Site Identity).
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers custom logo support.
 */
function finsweet_logo_setup() {
	add_theme_support(
		'custom-logo',
		array(
			'width'       => 140,
			'height'      => 28,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'finsweet_logo_setup' );

/**
 * Allows administrators to upload SVG files (the logo is an SVG).
 *
 * @param array $mimes Allowed mime types.
 * @return array
 */
function finsweet_allow_svg_upload( $mimes ) {
	if ( current_user_can( 'manage_options' ) ) {
		$mimes['svg'] = 'image/svg+xml';
	}

	return $mimes;
}
add_filter( 'upload_mimes', 'finsweet_allow_svg_upload' );

/**
 * Prints the site logo, or the site name when no logo is set.
 */
function finsweet_the_logo() {
	if ( has_custom_logo() ) {
		the_custom_logo();
		return;
	}

	printf(
		'<a class="custom-logo-link custom-logo-link--text" href="%1$s" rel="home">%2$s</a>',
		esc_url( home_url( '/' ) ),
		esc_html( get_bloginfo( 'name' ) )
	);
}
