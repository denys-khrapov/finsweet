<?php
/**
 * Join our team block.
 *
 * @package Finsweet
 *
 * @var array $block      Block settings and attributes.
 * @var bool  $is_preview True in the editor preview.
 */

defined( 'ABSPATH' ) || exit;

$finsweet_title  = finsweet_block_field( 'title' );
$finsweet_text   = finsweet_block_field( 'text' );
$finsweet_button = finsweet_block_link( 'button' );

if ( '' === $finsweet_title && '' === $finsweet_text && null === $finsweet_button ) {
	if ( $is_preview ) {
		echo '<p>' . esc_html__( 'Join our team: fill in the block fields.', 'finsweet' ) . '</p>';
	}
	return;
}
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => 'section join-team' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by core. ?>>
	<div class="container">
		<div class="join-team__inner">
			<?php if ( '' !== $finsweet_title ) : ?>
				<h2 class="join-team__title"><?php echo esc_html( $finsweet_title ); ?></h2>
			<?php endif; ?>

			<?php if ( '' !== $finsweet_text ) : ?>
				<p class="join-team__text"><?php echo esc_html( $finsweet_text ); ?></p>
			<?php endif; ?>

			<?php if ( null !== $finsweet_button ) : ?>
				<a class="button join-team__button" href="<?php echo esc_url( $finsweet_button['url'] ); ?>"<?php echo '_blank' === $finsweet_button['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $finsweet_button['title'] ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
