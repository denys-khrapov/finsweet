<?php
/**
 * Horizontal post card: image on the left, category, title and excerpt on the right.
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

$finsweet_category = finsweet_get_primary_category( $finsweet_post );
?>
<article class="post-card post-card--horizontal">
	<a class="post-card__image" href="<?php echo esc_url( get_permalink( $finsweet_post ) ); ?>" tabindex="-1" aria-hidden="true">
		<?php echo get_the_post_thumbnail( $finsweet_post, 'finsweet-card', array( 'alt' => '' ) ); ?>
	</a>
	<div class="post-card__body">
		<?php if ( $finsweet_category ) : ?>
			<p class="post-card__category"><?php echo esc_html( $finsweet_category->name ); ?></p>
		<?php endif; ?>
		<h3 class="post-card__title">
			<a href="<?php echo esc_url( get_permalink( $finsweet_post ) ); ?>"><?php echo esc_html( get_the_title( $finsweet_post ) ); ?></a>
		</h3>
		<p class="post-card__excerpt"><?php echo esc_html( finsweet_get_card_excerpt( $finsweet_post ) ); ?></p>
	</div>
</article>
