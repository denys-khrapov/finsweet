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

/**
 * Returns the job title of an author.
 *
 * @param int|WP_Post $author Post of the "blog_author" type or its ID.
 * @return string Job title, empty when not set or Secure Custom Fields is inactive.
 */
function finsweet_get_author_job_title( $author ) {
	$author = get_post( $author );

	if ( ! $author || ! function_exists( 'get_field' ) ) {
		return '';
	}

	$value = get_field( 'job_title', $author->ID );

	return is_string( $value ) ? $value : '';
}

/**
 * Returns the filled-in social links of an author.
 *
 * @param int|WP_Post $author Post of the "blog_author" type or its ID.
 * @return string[] Network slug => URL, only for the networks that have a link.
 */
function finsweet_get_author_links( $author ) {
	$author = get_post( $author );
	$links  = array();

	if ( ! $author || ! function_exists( 'get_field' ) ) {
		return $links;
	}

	foreach ( array( 'facebook', 'twitter', 'instagram', 'linkedin' ) as $network ) {
		$url = get_field( $network . '_url', $author->ID );

		if ( is_string( $url ) && '' !== $url ) {
			$links[ $network ] = $url;
		}
	}

	return $links;
}

/**
 * Returns the posts written by an author.
 *
 * The author is stored in the post relationship field as a serialized list of IDs.
 *
 * @param int|WP_Post $author Post of the "blog_author" type or its ID.
 * @param int         $paged  Page number.
 * @return WP_Query
 */
function finsweet_get_author_posts_query( $author, $paged = 1 ) {
	$author = get_post( $author );

	return new WP_Query(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => absint( get_option( 'posts_per_page' ) ),
			'paged'               => max( 1, absint( $paged ) ),
			'ignore_sticky_posts' => true,
			'meta_query'          => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- the author is a post meta value.
				array(
					'key'     => 'author',
					'value'   => '"' . ( $author ? $author->ID : 0 ) . '"',
					'compare' => 'LIKE',
				),
			),
		)
	);
}

/**
 * Keeps the page numbers of the "My posts" list on the author page.
 *
 * Without it WordPress answers `/authors/<name>/2/` with a 404, because the author text has one page.
 *
 * @param bool     $preempt  Whether to short-circuit the default 404 handling.
 * @param WP_Query $wp_query Main query.
 * @return bool
 */
function finsweet_allow_author_pages( $preempt, $wp_query ) {
	if ( $wp_query->is_singular( 'blog_author' ) && $wp_query->get( 'page' ) > 1 && $wp_query->have_posts() ) {
		return true;
	}

	return $preempt;
}
add_filter( 'pre_handle_404', 'finsweet_allow_author_pages', 10, 2 );
