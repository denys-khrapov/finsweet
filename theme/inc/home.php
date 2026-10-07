<?php
/**
 * Queries for the blocks of the home page.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns the post shown in the hero block.
 *
 * The post chosen in the block, or the newest post that is not the featured one.
 *
 * @param int $post_id Post ID chosen in the block, 0 for the default.
 * @return WP_Post|null
 */
function finsweet_get_hero_post( $post_id = 0 ) {
	$post = $post_id ? get_post( $post_id ) : null;

	if ( $post && 'post' === $post->post_type && 'publish' === $post->post_status ) {
		return $post;
	}

	$posts = finsweet_get_latest_posts( 1, finsweet_get_featured_post_ids() );

	return ! empty( $posts ) ? $posts[0] : null;
}

/**
 * Returns the ID of the featured post as an array for exclusion lists.
 *
 * @return int[]
 */
function finsweet_get_featured_post_ids() {
	$featured = finsweet_get_featured_post();

	return $featured ? array( $featured->ID ) : array();
}

/**
 * Returns the newest posts.
 *
 * @param int   $count   Number of posts.
 * @param int[] $exclude Post IDs to skip.
 * @return WP_Post[]
 */
function finsweet_get_latest_posts( $count, $exclude = array() ) {
	return get_posts(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => $count,
			'post__not_in'        => $exclude,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);
}

/**
 * Returns the categories for a grid, without the default "Uncategorized".
 *
 * @param int $count Number of categories.
 * @return WP_Term[]
 */
function finsweet_get_grid_categories( $count ) {
	$terms = get_categories(
		array(
			'exclude' => array( absint( get_option( 'default_category' ) ) ),
			'number'  => $count,
		)
	);

	return is_array( $terms ) ? $terms : array();
}

/**
 * Returns the authors for a grid in the order they were added.
 *
 * @param int $count Number of authors.
 * @return WP_Post[]
 */
function finsweet_get_grid_authors( $count ) {
	return get_posts(
		array(
			'post_type'      => 'blog_author',
			'post_status'    => 'publish',
			'posts_per_page' => $count,
			'orderby'        => 'date',
			'order'          => 'ASC',
			'no_found_rows'  => true,
		)
	);
}

/**
 * Returns the URL of the Blog page (the posts page), empty when it is not set.
 *
 * @return string
 */
function finsweet_get_blog_url() {
	$page_id = absint( get_option( 'page_for_posts' ) );

	return $page_id ? (string) get_permalink( $page_id ) : '';
}
