<?php
/**
 * Why we started block.
 *
 * @package Finsweet
 *
 * @var array $block      Block settings and attributes.
 * @var bool  $is_preview True in the editor preview.
 */

defined( 'ABSPATH' ) || exit;

$finsweet_image  = finsweet_block_image_id( 'image' );
$finsweet_label  = finsweet_block_field( 'label' );
$finsweet_title  = finsweet_block_field( 'title' );
$finsweet_text   = finsweet_block_field( 'text' );
$finsweet_button = finsweet_block_link( 'button' );

if ( '' === $finsweet_title && '' === $finsweet_text && 0 === $finsweet_image ) {
	if ( $is_preview ) {
		echo '<p>' . esc_html__( 'Why we started: fill in the block fields.', 'finsweet' ) . '</p>';
	}
	return;
}
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => 'section why-started' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by WordPress. ?>>
	<div class="container">
		<div class="why-started__inner">
			<?php if ( $finsweet_image ) : ?>
				<?php
				echo wp_get_attachment_image(
					$finsweet_image,
					'finsweet-cover',
					false,
					array(
						'class' => 'why-started__image',
						'sizes' => '(min-width: 1024px) 949px, 100vw',
					)
				);
				?>
			<?php endif; ?>
			<div class="why-started__card">
				<?php if ( '' !== $finsweet_label ) : ?>
					<p class="why-started__label"><?php echo esc_html( $finsweet_label ); ?></p>
				<?php endif; ?>
				<?php if ( '' !== $finsweet_title ) : ?>
					<h2 class="why-started__title"><?php echo esc_html( $finsweet_title ); ?></h2>
				<?php endif; ?>
				<?php if ( '' !== $finsweet_text ) : ?>
					<p class="why-started__text"><?php echo esc_html( $finsweet_text ); ?></p>
				<?php endif; ?>
				<?php if ( null !== $finsweet_button ) : ?>
					<a class="button" href="<?php echo esc_url( $finsweet_button['url'] ); ?>"<?php echo '_blank' === $finsweet_button['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $finsweet_button['title'] ); ?> &gt;</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
