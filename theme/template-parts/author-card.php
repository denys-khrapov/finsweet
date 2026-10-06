<?php
/**
 * Author card: photo, name, job title and social links.
 *
 * @package Finsweet
 *
 * @var array $args {
 *     @type WP_Post|int $author Post of the "blog_author" type or its ID.
 * }
 */

defined( 'ABSPATH' ) || exit;

$finsweet_author = isset( $args['author'] ) ? get_post( $args['author'] ) : null;

if ( ! $finsweet_author || 'blog_author' !== $finsweet_author->post_type ) {
	return;
}

$finsweet_networks = array(
	'facebook'  => __( 'Facebook', 'finsweet' ),
	'twitter'   => __( 'Twitter', 'finsweet' ),
	'instagram' => __( 'Instagram', 'finsweet' ),
	'linkedin'  => __( 'LinkedIn', 'finsweet' ),
);

$finsweet_links = finsweet_get_author_links( $finsweet_author );
?>
<article class="author-card">
	<a class="author-card__photo" href="<?php echo esc_url( get_permalink( $finsweet_author ) ); ?>" tabindex="-1" aria-hidden="true">
		<?php echo get_the_post_thumbnail( $finsweet_author, 'medium', array( 'alt' => '' ) ); ?>
	</a>
	<h3 class="author-card__name">
		<a href="<?php echo esc_url( get_permalink( $finsweet_author ) ); ?>"><?php echo esc_html( get_the_title( $finsweet_author ) ); ?></a>
	</h3>
	<?php if ( '' !== finsweet_get_author_job_title( $finsweet_author ) ) : ?>
		<p class="author-card__job"><?php echo esc_html( finsweet_get_author_job_title( $finsweet_author ) ); ?></p>
	<?php endif; ?>
	<?php if ( ! empty( $finsweet_links ) ) : ?>
		<ul class="social-links social-links--dark">
			<?php foreach ( $finsweet_links as $finsweet_slug => $finsweet_url ) : ?>
				<li>
					<a class="social-links__link" style="--icon: url(<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $finsweet_slug . '.svg' ) ); ?>)" href="<?php echo esc_url( $finsweet_url ); ?>" target="_blank" rel="noopener noreferrer">
						<span class="screen-reader-text"><?php echo esc_html( $finsweet_networks[ $finsweet_slug ] ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</article>
