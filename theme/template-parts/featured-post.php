<?php
/**
 * Featured post: label, title, meta, excerpt and button on the left, image on the right.
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
?>
<section class="featured-post">
	<div class="container">
		<article class="featured-post__inner">
			<div class="featured-post__body">
				<p class="featured-post__label"><?php esc_html_e( 'Featured post', 'finsweet' ); ?></p>
				<h2 class="featured-post__title">
					<a href="<?php echo esc_url( get_permalink( $finsweet_post ) ); ?>"><?php echo esc_html( get_the_title( $finsweet_post ) ); ?></a>
				</h2>
				<?php get_template_part( 'template-parts/post-meta', null, array( 'post' => $finsweet_post ) ); ?>
				<p class="featured-post__excerpt"><?php echo esc_html( finsweet_get_card_excerpt( $finsweet_post, 30 ) ); ?></p>
				<a class="button" href="<?php echo esc_url( get_permalink( $finsweet_post ) ); ?>">
					<?php esc_html_e( 'Read More', 'finsweet' ); ?> &gt;
				</a>
			</div>
			<a class="featured-post__image" href="<?php echo esc_url( get_permalink( $finsweet_post ) ); ?>" tabindex="-1" aria-hidden="true">
				<?php echo get_the_post_thumbnail( $finsweet_post, 'finsweet-card', array( 'alt' => '' ) ); ?>
			</a>
		</article>
	</div>
</section>
