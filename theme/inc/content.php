<?php
/**
 * Helpers for reading content model fields.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns the author (the "blog_author" post type) linked to a post.
 *
 * @param int|WP_Post|null $post Post ID or object, defaults to the current post.
 * @return WP_Post|null Author post, null when none is set or Secure Custom Fields is inactive.
 */
function finsweet_get_post_author( $post = null ) {
	$post = get_post( $post );

	if ( ! $post || ! function_exists( 'get_field' ) ) {
		return null;
	}

	$author_id = get_field( 'author', $post->ID, false );

	if ( is_array( $author_id ) ) {
		$author_id = reset( $author_id );
	}

	$author = $author_id ? get_post( absint( $author_id ) ) : null;

	if ( ! $author || 'blog_author' !== $author->post_type || 'publish' !== $author->post_status ) {
		return null;
	}

	return $author;
}

/**
 * Returns the icon attachment ID of a category.
 *
 * @param int|WP_Term $term Category term ID or object.
 * @return int Attachment ID, 0 when there is no icon or Secure Custom Fields is inactive.
 */
function finsweet_get_category_icon_id( $term ) {
	$term = get_term( $term, 'category' );

	if ( ! $term || is_wp_error( $term ) || ! function_exists( 'get_field' ) ) {
		return 0;
	}

	return absint( get_field( 'icon', $term, false ) );
}
