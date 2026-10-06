<?php
/**
 * Field-based blocks: registration, category, styles and field helpers.
 *
 * Every folder in theme/blocks/ with a block.json is registered on its own.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

/**
 * Adds the "Finsweet" block category at the top of the inserter.
 *
 * @param array[] $categories Block categories.
 * @return array[]
 */
function finsweet_block_categories( $categories ) {
	array_unshift(
		$categories,
		array(
			'slug'  => 'finsweet',
			'title' => __( 'Finsweet', 'finsweet' ),
		)
	);

	return $categories;
}
add_filter( 'block_categories_all', 'finsweet_block_categories' );

/**
 * Registers every block found in theme/blocks/.
 *
 * Runs on acf/init, so nothing is registered while Secure Custom Fields is inactive.
 * A block's compiled CSS is registered as the style handle "finsweet-block-<name>"
 * (set as "style" in its block.json), so WordPress prints it only where the block is used.
 */
function finsweet_register_blocks() {
	$block_files = glob( get_theme_file_path( 'blocks/*/block.json' ) );

	if ( empty( $block_files ) ) {
		return;
	}

	foreach ( $block_files as $block_file ) {
		$dir  = dirname( $block_file );
		$name = basename( $dir );

		$css_path = get_theme_file_path( "assets/build/blocks/style-{$name}.css" );

		if ( file_exists( $css_path ) ) {
			wp_register_style(
				"finsweet-block-{$name}",
				get_theme_file_uri( "assets/build/blocks/style-{$name}.css" ),
				array(),
				(string) filemtime( $css_path )
			);
		}

		register_block_type( $dir );
	}
}
add_action( 'acf/init', 'finsweet_register_blocks' );

/**
 * Loads the compiled theme styles in the block editor so block previews match the site.
 */
function finsweet_editor_styles() {
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/build/main.css' );
}
add_action( 'after_setup_theme', 'finsweet_editor_styles' );

/**
 * Returns a text field of the block being rendered.
 *
 * @param string $name Field name.
 * @return string Field value, empty string when Secure Custom Fields is inactive or the field is empty.
 */
function finsweet_block_field( $name ) {
	if ( ! function_exists( 'get_field' ) ) {
		return '';
	}

	$value = get_field( $name );

	return is_string( $value ) ? $value : '';
}

/**
 * Returns a link field of the block being rendered.
 *
 * @param string $name Field name.
 * @return array|null Array with url, title and target, or null when the link is empty.
 */
function finsweet_block_link( $name ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}

	return finsweet_format_link( get_field( $name ) );
}

/**
 * Normalizes the value of a link field.
 *
 * @param mixed $value Link field value (array return format).
 * @return array|null Array with url, title and target, or null when the link is empty.
 */
function finsweet_format_link( $value ) {
	if ( ! is_array( $value ) || empty( $value['url'] ) ) {
		return null;
	}

	return array(
		'url'    => (string) $value['url'],
		'title'  => isset( $value['title'] ) && '' !== $value['title'] ? (string) $value['title'] : (string) $value['url'],
		'target' => isset( $value['target'] ) ? (string) $value['target'] : '',
	);
}
