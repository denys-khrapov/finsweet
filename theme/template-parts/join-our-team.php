<?php
/**
 * Join our team call to action.
 *
 * Without arguments it reads the texts from the Finsweet settings page.
 *
 * @package Finsweet
 *
 * @var array $args {
 *     @type string     $title      Heading.
 *     @type string     $text       Short text.
 *     @type array|null $button     Link with url, title and target.
 *     @type string     $attributes Escaped attributes of the section, used by the block.
 * }
 */

defined( 'ABSPATH' ) || exit;

$finsweet_title  = isset( $args['title'] ) ? (string) $args['title'] : finsweet_option( 'join_title' );
$finsweet_text   = isset( $args['text'] ) ? (string) $args['text'] : finsweet_option( 'join_text' );
$finsweet_button = array_key_exists( 'button', $args ) ? $args['button'] : finsweet_option_link( 'join_button' );

if ( '' === $finsweet_title && '' === $finsweet_text && empty( $finsweet_button ) ) {
	return;
}

wp_enqueue_style( 'finsweet-block-join-our-team' );

$finsweet_attributes = isset( $args['attributes'] ) ? (string) $args['attributes'] : 'class="section join-team"';
?>
<section <?php echo $finsweet_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped by the caller. ?>>
	<div class="container">
		<div class="join-team__inner">
			<?php if ( '' !== $finsweet_title ) : ?>
				<h2 class="join-team__title"><?php echo esc_html( $finsweet_title ); ?></h2>
			<?php endif; ?>

			<?php if ( '' !== $finsweet_text ) : ?>
				<p class="join-team__text"><?php echo esc_html( $finsweet_text ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $finsweet_button ) ) : ?>
				<a class="button join-team__button" href="<?php echo esc_url( $finsweet_button['url'] ); ?>"<?php echo '_blank' === $finsweet_button['target'] ? ' target="_blank" rel="noopener"' : ''; ?>><?php echo esc_html( $finsweet_button['title'] ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
