<?php
/**
 * Testimonials block.
 *
 * @package Finsweet
 *
 * @var array $block      Block settings and attributes.
 * @var bool  $is_preview True in the editor preview.
 */

defined( 'ABSPATH' ) || exit;

$finsweet_testimonials = finsweet_get_testimonials( finsweet_block_number( 'count', 4 ) );

if ( empty( $finsweet_testimonials ) ) {
	if ( $is_preview ) {
		echo '<p>' . esc_html__( 'Testimonials: there are no testimonials yet.', 'finsweet' ) . '</p>';
	}
	return;
}

$finsweet_label = finsweet_block_field( 'label' );
$finsweet_title = finsweet_block_field( 'title' );
$finsweet_text  = finsweet_block_field( 'text' );
$finsweet_multi = count( $finsweet_testimonials ) > 1;
?>
<section <?php echo get_block_wrapper_attributes( array( 'class' => 'section testimonials' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by WordPress. ?>>
	<div class="container testimonials__inner">
		<div class="testimonials__intro">
			<?php if ( '' !== $finsweet_label ) : ?>
				<p class="testimonials__label"><?php echo esc_html( $finsweet_label ); ?></p>
			<?php endif; ?>
			<?php if ( '' !== $finsweet_title ) : ?>
				<h2 class="testimonials__title"><?php echo esc_html( $finsweet_title ); ?></h2>
			<?php endif; ?>
			<?php if ( '' !== $finsweet_text ) : ?>
				<p class="testimonials__text"><?php echo esc_html( $finsweet_text ); ?></p>
			<?php endif; ?>
		</div>

		<div class="testimonials__slider-wrap">
			<div class="testimonials__slider swiper" aria-roledescription="carousel" aria-label="<?php esc_attr_e( 'Testimonials', 'finsweet' ); ?>">
				<div class="swiper-wrapper">
					<?php foreach ( $finsweet_testimonials as $finsweet_testimonial ) : ?>
						<?php
						$finsweet_quote    = function_exists( 'get_field' ) ? (string) get_field( 'quote', $finsweet_testimonial->ID ) : '';
						$finsweet_location = function_exists( 'get_field' ) ? (string) get_field( 'location', $finsweet_testimonial->ID ) : '';
						?>
						<figure class="testimonials__slide swiper-slide">
							<blockquote class="testimonials__quote"><?php echo esc_html( $finsweet_quote ); ?></blockquote>
							<figcaption class="testimonials__author">
								<?php
								echo get_the_post_thumbnail(
									$finsweet_testimonial,
									'finsweet-avatar',
									array(
										'class' => 'testimonials__photo',
										'alt'   => '',
									)
								);
								?>
								<span class="testimonials__name"><?php echo esc_html( get_the_title( $finsweet_testimonial ) ); ?></span>
								<?php if ( '' !== $finsweet_location ) : ?>
									<span class="testimonials__location"><?php echo esc_html( $finsweet_location ); ?></span>
								<?php endif; ?>
							</figcaption>
						</figure>
					<?php endforeach; ?>
				</div>
			</div>

			<?php if ( $finsweet_multi ) : ?>
				<div class="testimonials__nav">
					<button class="testimonials__arrow testimonials__arrow--prev" type="button" aria-label="<?php esc_attr_e( 'Previous testimonial', 'finsweet' ); ?>">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 12H3m0 0 7-7m-7 7 7 7"/></svg>
					</button>
					<button class="testimonials__arrow testimonials__arrow--next" type="button" aria-label="<?php esc_attr_e( 'Next testimonial', 'finsweet' ); ?>">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 12h18m0 0-7-7m7 7-7 7"/></svg>
					</button>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
