<?php
/**
 * Authors block.
 *
 * @package Finsweet
 *
 * @var array $block      Block settings and attributes.
 * @var bool  $is_preview True in the editor preview.
 */

defined( 'ABSPATH' ) || exit;

$finsweet_authors = finsweet_get_grid_authors( finsweet_block_number( 'count', 4 ) );

if ( empty( $finsweet_authors ) ) {
	if ( $is_preview ) {
		echo '<p>' . esc_html__( 'Authors: there are no authors yet.', 'finsweet' ) . '</p>';
	}
	return;
}
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => 'section authors' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by WordPress. ?>>
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
		<div class="author-grid">
			<?php
			foreach ( $finsweet_authors as $finsweet_author ) {
				get_template_part( 'template-parts/author-card', null, array( 'author' => $finsweet_author ) );
			}
			?>
		</div>
	</div>
</section>
