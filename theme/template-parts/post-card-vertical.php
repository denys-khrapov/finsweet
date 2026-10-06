<?php
/**
 * Vertical post card: image, author and date, title and excerpt.
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
<article class="post-card post-card--vertical">
	<a class="post-card__image" href="<?php echo esc_url( get_permalink( $finsweet_post ) ); ?>" tabindex="-1" aria-hidden="true">
		<?php echo get_the_post_thumbnail( $finsweet_post, 'finsweet-card', array( 'alt' => '' ) ); ?>
	</a>
	<div class="post-card__body">
		<p class="post-card__meta">
			<?php if ( $finsweet_author ) : ?>
				<?php esc_html_e( 'By', 'finsweet' ); ?>
				<a class="post-card__author" href="<?php echo esc_url( get_permalink( $finsweet_author ) ); ?>"><?php echo esc_html( get_the_title( $finsweet_author ) ); ?></a>
				<span class="post-card__separator" aria-hidden="true">|</span>
			<?php endif; ?>
			<time datetime="<?php echo esc_attr( get_the_date( 'c', $finsweet_post ) ); ?>"><?php echo esc_html( get_the_date( 'M j, Y', $finsweet_post ) ); ?></time>
		</p>
		<h3 class="post-card__title">
			<a href="<?php echo esc_url( get_permalink( $finsweet_post ) ); ?>"><?php echo esc_html( get_the_title( $finsweet_post ) ); ?></a>
		</h3>
		<p class="post-card__excerpt"><?php echo esc_html( finsweet_get_card_excerpt( $finsweet_post ) ); ?></p>
	</div>
</article>
