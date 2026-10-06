<?php
/**
 * Post meta line: "By <author> | <date>".
 *
 * @package Finsweet
 *
 * @var array $args {
 *     @type WP_Post|int $post Post, defaults to the current post.
 * }
 */

defined( 'ABSPATH' ) || exit;

$finsweet_post = get_post( isset( $args['post'] ) ? $args['post'] : null );

if ( ! $finsweet_post ) {
	return;
}

$finsweet_author = finsweet_get_post_author( $finsweet_post );
?>
<p class="post-meta">
	<?php if ( $finsweet_author ) : ?>
		<?php esc_html_e( 'By', 'finsweet' ); ?>
		<a class="post-meta__author" href="<?php echo esc_url( get_permalink( $finsweet_author ) ); ?>"><?php echo esc_html( get_the_title( $finsweet_author ) ); ?></a>
		<span class="post-meta__separator" aria-hidden="true">|</span>
	<?php endif; ?>
	<time datetime="<?php echo esc_attr( get_the_date( 'c', $finsweet_post ) ); ?>"><?php echo esc_html( get_the_date( 'M j, Y', $finsweet_post ) ); ?></time>
</p>
