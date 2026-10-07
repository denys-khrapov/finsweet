<?php
/**
 * Featured in block.
 *
 * @package Finsweet
 *
 * @var array $block      Block settings and attributes.
 * @var bool  $is_preview True in the editor preview.
 */

defined( 'ABSPATH' ) || exit;

$finsweet_title = finsweet_block_field( 'title' );
$finsweet_logos = array();

for ( $finsweet_i = 1; $finsweet_i <= 5; $finsweet_i++ ) {
	$finsweet_logo_id = finsweet_block_image_id( 'logo_' . $finsweet_i );

	if ( $finsweet_logo_id ) {
		$finsweet_logos[] = $finsweet_logo_id;
	}
}

if ( empty( $finsweet_logos ) ) {
	if ( $is_preview ) {
		echo '<p>' . esc_html__( 'Featured in: add at least one logo.', 'finsweet' ) . '</p>';
	}
	return;
}
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => 'section featured-in' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by WordPress. ?>>
	<div class="container featured-in__inner">
		<?php if ( '' !== $finsweet_title ) : ?>
			<h2 class="featured-in__title"><?php echo esc_html( $finsweet_title ); ?></h2>
		<?php endif; ?>
		<ul class="featured-in__logos">
			<?php foreach ( $finsweet_logos as $finsweet_logo_id ) : ?>
				<li><?php echo wp_get_attachment_image( $finsweet_logo_id, 'medium', false, array( 'class' => 'featured-in__logo' ) ); ?></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
