<?php
/**
 * Site settings options page.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the "Finsweet settings" options page (fields live in acf-json).
 */
function finsweet_register_options_page() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title' => __( 'Finsweet settings', 'finsweet' ),
			'menu_title' => __( 'Finsweet', 'finsweet' ),
			'menu_slug'  => 'finsweet-settings',
			'capability' => 'manage_options',
			'icon_url'   => 'dashicons-admin-generic',
			'position'   => 59,
			'redirect'   => false,
		)
	);
}
add_action( 'acf/init', 'finsweet_register_options_page' );

/**
 * Returns a value from the Finsweet settings options page.
 *
 * @param string $name Field name.
 * @return string Field value, empty string when Secure Custom Fields is inactive or the field is empty.
 */
function finsweet_option( $name ) {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	$value = get_field( $name, 'option' );

	return is_string( $value ) ? $value : '';
}

/**
 * Returns a link field from the Finsweet settings options page.
 *
 * @param string $name Field name.
 * @return array|null Array with url, title and target, or null when the link is empty or Secure Custom Fields is inactive.
 */
function finsweet_option_link( $name ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}

	return finsweet_format_link( get_field( $name, 'option' ) );
}
