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
 * Prints the pagination of a posts query: Prev, page numbers, Next.
 *
 * @param WP_Query|null $query Query to paginate, defaults to the main query.
 */
function finsweet_pagination( $query = null ) {
	global $wp_query;

	$query   = $query ? $query : $wp_query;
	$total   = (int) $query->max_num_pages;
	$current = max( 1, (int) get_query_var( 'paged' ) );

	if ( $total < 2 ) {
		return;
	}

	$pages = paginate_links(
		array(
			'total'     => $total,
			'current'   => $current,
			'type'      => 'array',
			'prev_next' => false,
			'end_size'  => 1,
			'mid_size'  => 1,
		)
	);

	get_template_part(
		'template-parts/pagination',
		null,
		array(
			'pages'    => $pages,
			'prev_url' => $current > 1 ? get_pagenum_link( $current - 1 ) : '',
			'next_url' => $current < $total ? get_pagenum_link( $current + 1 ) : '',
		)
	);
}
