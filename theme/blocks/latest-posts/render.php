<?php
/**
 * Featured and latest posts block.
 *
 * @package Finsweet
 *
 * @var array $block      Block settings and attributes.
 * @var bool  $is_preview True in the editor preview.
 */

defined( 'ABSPATH' ) || exit;

$finsweet_featured = finsweet_get_featured_post();

if ( ! $finsweet_featured ) {
	if ( $is_preview ) {
		echo '<p>' . esc_html__( 'Featured and latest posts: there are no published posts yet.', 'finsweet' ) . '</p>';
	}
	return;
}

$finsweet_posts = finsweet_get_latest_posts( finsweet_block_number( 'count', 4 ), array( $finsweet_featured->ID ) );
$finsweet_link  = finsweet_block_link( 'link' );
$finsweet_url   = $finsweet_link ? $finsweet_link['url'] : finsweet_get_blog_url();
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => 'section latest-posts' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by WordPress. ?>>
	<div class="container">
		<div class="latest-posts__grid">
			<div class="latest-posts__featured">
				<?php
				get_template_part(
					'template-parts/section-heading',
					null,
					array( 'title' => finsweet_block_field( 'featured_title' ) )
				);
				?>
				<article class="latest-posts__card">
					<a class="latest-posts__image" href="<?php echo esc_url( get_permalink( $finsweet_featured ) ); ?>" tabindex="-1" aria-hidden="true">
						<?php echo get_the_post_thumbnail( $finsweet_featured, 'finsweet-card', array( 'alt' => '' ) ); ?>
					</a>
					<?php get_template_part( 'template-parts/post-meta', null, array( 'post' => $finsweet_featured ) ); ?>
					<h3 class="latest-posts__title">
						<a href="<?php echo esc_url( get_permalink( $finsweet_featured ) ); ?>"><?php echo esc_html( get_the_title( $finsweet_featured ) ); ?></a>
					</h3>
					<p class="latest-posts__excerpt"><?php echo esc_html( finsweet_get_card_excerpt( $finsweet_featured, 30 ) ); ?></p>
					<a class="button" href="<?php echo esc_url( get_permalink( $finsweet_featured ) ); ?>">
						<?php esc_html_e( 'Read More', 'finsweet' ); ?> &gt;
					</a>
				</article>
			</div>

			<div class="latest-posts__list">
				<?php
				get_template_part(
					'template-parts/section-heading',
					null,
					array(
						'title' => finsweet_block_field( 'list_title' ),
						'link'  => $finsweet_url,
					)
				);
				?>
				<div class="post-rows">
					<?php
					foreach ( $finsweet_posts as $finsweet_post ) {
						get_template_part( 'template-parts/post-row', null, array( 'post' => $finsweet_post ) );
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>
