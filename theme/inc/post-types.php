<?php
/**
 * Custom post types.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the "blog_author" post type.
 *
 * Authors are separate from WordPress users. The base is "authors" so it does
 * not clash with the core "/author/<user>/" archives.
 */
function finsweet_register_author_post_type() {
	register_post_type(
		'blog_author',
		array(
			'labels'        => array(
				'name'               => __( 'Authors', 'finsweet' ),
				'singular_name'      => __( 'Author', 'finsweet' ),
				'add_new_item'       => __( 'Add new author', 'finsweet' ),
				'edit_item'          => __( 'Edit author', 'finsweet' ),
				'new_item'           => __( 'New author', 'finsweet' ),
				'view_item'          => __( 'View author', 'finsweet' ),
				'search_items'       => __( 'Search authors', 'finsweet' ),
				'not_found'          => __( 'No authors found.', 'finsweet' ),
				'not_found_in_trash' => __( 'No authors found in Trash.', 'finsweet' ),
				'all_items'          => __( 'All authors', 'finsweet' ),
				'featured_image'     => __( 'Photo', 'finsweet' ),
				'set_featured_image' => __( 'Set photo', 'finsweet' ),
			),
			'public'        => true,
			'has_archive'   => false,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-businessperson',
			'menu_position' => 6,
			'rewrite'       => array(
				'slug'       => 'authors',
				'with_front' => false,
			),
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
		)
	);
}
add_action( 'init', 'finsweet_register_author_post_type' );

/**
 * Registers the "testimonial" post type.
 *
 * Testimonials only feed the slider block, so they have no public pages.
 * The name is the post title, the photo is the featured image.
 */
function finsweet_register_testimonial_post_type() {
	register_post_type(
		'testimonial',
		array(
			'labels'        => array(
				'name'               => __( 'Testimonials', 'finsweet' ),
				'singular_name'      => __( 'Testimonial', 'finsweet' ),
				'add_new_item'       => __( 'Add new testimonial', 'finsweet' ),
				'edit_item'          => __( 'Edit testimonial', 'finsweet' ),
				'new_item'           => __( 'New testimonial', 'finsweet' ),
				'search_items'       => __( 'Search testimonials', 'finsweet' ),
				'not_found'          => __( 'No testimonials found.', 'finsweet' ),
				'not_found_in_trash' => __( 'No testimonials found in Trash.', 'finsweet' ),
				'all_items'          => __( 'All testimonials', 'finsweet' ),
				'featured_image'     => __( 'Photo', 'finsweet' ),
				'set_featured_image' => __( 'Set photo', 'finsweet' ),
			),
			'public'        => false,
			'show_ui'       => true,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-format-quote',
			'menu_position' => 7,
			'supports'      => array( 'title', 'thumbnail' ),
		)
	);
}
add_action( 'init', 'finsweet_register_testimonial_post_type' );
