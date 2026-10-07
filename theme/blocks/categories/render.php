<?php
/**
 * Categories block.
 *
 * @package Finsweet
 *
 * @var array $block      Block settings and attributes.
 * @var bool  $is_preview True in the editor preview.
 */

defined( 'ABSPATH' ) || exit;

$finsweet_categories = finsweet_get_grid_categories( finsweet_block_number( 'count', 4 ) );

if ( empty( $finsweet_categories ) ) {
	if ( $is_preview ) {
		echo '<p>' . esc_html__( 'Categories: there are no categories yet.', 'finsweet' ) . '</p>';
	}
	return;
}
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => 'section categories' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by WordPress. ?>>
	<div class="container">
		<?php
		get_template_part(
			'template-parts/section-heading',
			null,
			array(
				'title'  => finsweet_block_field( 'title' ),
				'center' => true,
			)
		);
		?>
		<div class="category-grid">
			<?php
			foreach ( $finsweet_categories as $finsweet_category ) {
				get_template_part( 'template-parts/category-card', null, array( 'term' => $finsweet_category ) );
			}
			?>
		</div>
	</div>
</section>
