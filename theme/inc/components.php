<?php
/**
 * Helpers for the shared template components (cards, badges, pagination).
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the image size used by post cards.
 */
function finsweet_register_image_sizes() {
	add_image_size( 'finsweet-card', 980, 636, true );
	add_image_size( 'finsweet-cover', 1920, 873, true );
	add_image_size( 'finsweet-avatar', 96, 96, true );
}
add_action( 'after_setup_theme', 'finsweet_register_image_sizes' );

/**
 * Returns the first category of a post.
 *
 * Uncategorized is skipped when the post has other categories.
 *
 * @param int|WP_Post|null $post Post ID or object, defaults to the current post.
 * @return WP_Term|null Category term, null when the post has none.
 */
function finsweet_get_primary_category( $post = null ) {
	$terms = get_the_category( $post ? get_post( $post )->ID : 0 );

	if ( empty( $terms ) ) {
		return null;
	}

	$default_id = absint( get_option( 'default_category' ) );

	foreach ( $terms as $term ) {
		if ( $term->term_id !== $default_id ) {
			return $term;
		}
	}

	return $terms[0];
}

/**
 * Returns the excerpt of a post trimmed to a number of words.
 *
 * @param int|WP_Post|null $post  Post ID or object, defaults to the current post.
 * @param int              $words Maximum number of words.
 * @return string Plain text excerpt.
 */
function finsweet_get_card_excerpt( $post = null, $words = 24 ) {
	return wp_trim_words( get_the_excerpt( $post ), $words );
}

/**
 * Returns the posts shown under an article ("What to read next").
 *
 * Posts of the same category come first; the rest is filled with the latest posts.
 *
 * @param int|WP_Post|null $post  Post ID or object, defaults to the current post.
 * @param int              $count Number of posts.
 * @return WP_Post[]
 */
function finsweet_get_related_posts( $post = null, $count = 3 ) {
	$post = get_post( $post );

	if ( ! $post ) {
		return array();
	}

	$posts = array();
	$base  = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $count,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	$category = finsweet_get_primary_category( $post );

	if ( $category ) {
		$posts = get_posts(
			array_merge(
				$base,
				array(
					'cat'          => $category->term_id,
					'post__not_in' => array( $post->ID ),
				)
			)
		);
	}

	if ( count( $posts ) < $count ) {
		$exclude   = wp_list_pluck( $posts, 'ID' );
		$exclude[] = $post->ID;

		$posts = array_merge(
			$posts,
			get_posts(
				array_merge(
					$base,
					array(
						'posts_per_page' => $count - count( $posts ),
						'post__not_in'   => $exclude,
					)
				)
			)
		);
	}

	return $posts;
}

/**
 * Returns the featured post of the blog: the newest sticky post, or the newest post.
 *
 * @return WP_Post|null
 */
function finsweet_get_featured_post() {
	$sticky = get_option( 'sticky_posts' );
	$args   = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => 1,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	);

	if ( ! empty( $sticky ) ) {
		$posts = get_posts( array_merge( $args, array( 'post__in' => $sticky ) ) );

		if ( ! empty( $posts ) ) {
			return $posts[0];
		}
	}

	$posts = get_posts( $args );

	return ! empty( $posts ) ? $posts[0] : null;
}

/**
 * Keeps the featured post out of the posts list on the blog page.
 *
 * @param WP_Query $query Query being prepared.
 */
function finsweet_exclude_featured_post( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_home() ) {
		return;
	}

	$featured = finsweet_get_featured_post();

	if ( $featured ) {
		$query->set( 'post__not_in', array( $featured->ID ) );
		$query->set( 'ignore_sticky_posts', true );
	}
}
add_action( 'pre_get_posts', 'finsweet_exclude_featured_post' );

/**
 * Prints the pagination of a posts query: Prev, page numbers, Next.
 *
 * @param WP_Query|null $query Query to paginate, defaults to the main query.
 * @param array         $args  {
 *     Optional. For lists inside a singular page, where the page number is in the `page` query var.
 *
 *     @type int    $current Current page number.
 *     @type string $base    URL pattern with the `%#%` placeholder for the page number.
 * }
 */
function finsweet_pagination( $query = null, $args = array() ) {
	global $wp_query;

	$query   = $query ? $query : $wp_query;
	$total   = (int) $query->max_num_pages;
	$current = isset( $args['current'] ) ? max( 1, (int) $args['current'] ) : max( 1, (int) get_query_var( 'paged' ) );
	$base    = isset( $args['base'] ) ? (string) $args['base'] : '';

	if ( $total < 2 ) {
		return;
	}

	$links = array(
		'total'     => $total,
		'current'   => $current,
		'type'      => 'array',
		'prev_next' => false,
		'end_size'  => 1,
		'mid_size'  => 1,
	);

	if ( '' !== $base ) {
		$links['base']   = $base;
		$links['format'] = '';
	}

	get_template_part(
		'template-parts/pagination',
		null,
		array(
			'pages'    => paginate_links( $links ),
			'prev_url' => $current > 1 ? finsweet_page_url( $current - 1, $base ) : '',
			'next_url' => $current < $total ? finsweet_page_url( $current + 1, $base ) : '',
		)
	);
}

/**
 * Returns the URL of a page of a list.
 *
 * @param int    $number Page number.
 * @param string $base   URL pattern with the `%#%` placeholder, empty for the main query pages.
 * @return string
 */
function finsweet_page_url( $number, $base = '' ) {
	if ( '' === $base ) {
		return get_pagenum_link( $number );
	}

	return 1 === $number ? str_replace( array( '%#%/', '?page=%#%' ), '', $base ) : str_replace( '%#%', (string) $number, $base );
}
