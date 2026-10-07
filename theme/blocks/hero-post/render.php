<?php
/**
 * Hero post block.
 *
 * @package Finsweet
 *
 * @var array $block      Block settings and attributes.
 * @var bool  $is_preview True in the editor preview.
 */

defined( 'ABSPATH' ) || exit;

$finsweet_post = finsweet_get_hero_post( finsweet_block_post_id( 'post' ) );

if ( ! $finsweet_post ) {
	if ( $is_preview ) {
		echo '<p>' . esc_html__( 'Hero post: there are no published posts yet.', 'finsweet' ) . '</p>';
	}
	return;
}

$finsweet_category = finsweet_get_primary_category( $finsweet_post );
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => 'hero-post' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by WordPress. ?>>
	<?php
	echo get_the_post_thumbnail(
		$finsweet_post,
		'finsweet-cover',
		array(
			'class'         => 'hero-post__image',
			'alt'           => '',
			'loading'       => 'eager',
			'fetchpriority' => 'high',
			'sizes'         => '100vw',
		)
	);
	?>
	<div class="container">
		<div class="hero-post__body">
			<?php if ( $finsweet_category ) : ?>
				<p class="hero-post__label">
					<?php esc_html_e( 'Posted on', 'finsweet' ); ?>
					<strong><?php echo esc_html( $finsweet_category->name ); ?></strong>
				</p>
			<?php endif; ?>
			<h1 class="hero-post__title">
				<a href="<?php echo esc_url( get_permalink( $finsweet_post ) ); ?>"><?php echo esc_html( get_the_title( $finsweet_post ) ); ?></a>
			</h1>
			<?php get_template_part( 'template-parts/post-meta', null, array( 'post' => $finsweet_post ) ); ?>
			<p class="hero-post__excerpt"><?php echo esc_html( finsweet_get_card_excerpt( $finsweet_post, 30 ) ); ?></p>
			<a class="button" href="<?php echo esc_url( get_permalink( $finsweet_post ) ); ?>">
				<?php esc_html_e( 'Read More', 'finsweet' ); ?> &gt;
			</a>
		</div>
	</div>
</section>
