<?php
/**
 * About and mission block.
 *
 * @package Finsweet
 *
 * @var array $block      Block settings and attributes.
 * @var bool  $is_preview True in the editor preview.
 */

defined( 'ABSPATH' ) || exit;

$finsweet_about_label   = finsweet_block_field( 'about_label' );
$finsweet_about_title   = finsweet_block_field( 'about_title' );
$finsweet_about_text    = finsweet_block_field( 'about_text' );
$finsweet_about_link    = finsweet_block_link( 'about_link' );
$finsweet_mission_label = finsweet_block_field( 'mission_label' );
$finsweet_mission_title = finsweet_block_field( 'mission_title' );
$finsweet_mission_text  = finsweet_block_field( 'mission_text' );

$finsweet_has_about   = '' !== $finsweet_about_title || '' !== $finsweet_about_text;
$finsweet_has_mission = '' !== $finsweet_mission_title || '' !== $finsweet_mission_text;

if ( ! $finsweet_has_about && ! $finsweet_has_mission ) {
	if ( $is_preview ) {
		echo '<p>' . esc_html__( 'About and mission: fill in the block fields.', 'finsweet' ) . '</p>';
	}
	return;
}
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => 'about-mission' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by WordPress. ?>>
	<?php get_template_part( 'template-parts/stripe' ); ?>
	<div class="container about-mission__inner">
		<?php if ( $finsweet_has_about ) : ?>
			<div class="about-mission__col about-mission__col--about">
				<?php if ( '' !== $finsweet_about_label ) : ?>
					<p class="about-mission__label"><?php echo esc_html( $finsweet_about_label ); ?></p>
				<?php endif; ?>
				<?php if ( '' !== $finsweet_about_title ) : ?>
					<h2 class="about-mission__title"><?php echo esc_html( $finsweet_about_title ); ?></h2>
				<?php endif; ?>
				<?php if ( '' !== $finsweet_about_text ) : ?>
					<p class="about-mission__text"><?php echo esc_html( $finsweet_about_text ); ?></p>
				<?php endif; ?>
				<?php if ( null !== $finsweet_about_link ) : ?>
					<a class="text-link about-mission__link" href="<?php echo esc_url( $finsweet_about_link['url'] ); ?>"<?php echo '_blank' === $finsweet_about_link['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $finsweet_about_link['title'] ); ?> &gt;</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $finsweet_has_mission ) : ?>
			<div class="about-mission__col about-mission__col--mission">
				<?php if ( '' !== $finsweet_mission_label ) : ?>
					<p class="about-mission__label"><?php echo esc_html( $finsweet_mission_label ); ?></p>
				<?php endif; ?>
				<?php if ( '' !== $finsweet_mission_title ) : ?>
					<h2 class="about-mission__title about-mission__title--small"><?php echo esc_html( $finsweet_mission_title ); ?></h2>
				<?php endif; ?>
				<?php if ( '' !== $finsweet_mission_text ) : ?>
					<p class="about-mission__text"><?php echo esc_html( $finsweet_mission_text ); ?></p>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
