<?php
/**
 * Newsletter subscribe block (markup only, the handler comes with the forms step).
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

$finsweet_title = finsweet_option( 'newsletter_title' );

if ( '' === $finsweet_title ) {
	$finsweet_title = __( 'Subscribe to our news letter to get latest updates and news', 'finsweet' );
}
?>
<section id="newsletter" class="newsletter" aria-labelledby="newsletter-title">
	<h2 id="newsletter-title" class="newsletter__title"><?php echo esc_html( $finsweet_title ); ?></h2>

	<form class="newsletter__form" method="post">
		<label class="screen-reader-text" for="newsletter-email"><?php esc_html_e( 'Email', 'finsweet' ); ?></label>
		<input class="newsletter__input" type="email" id="newsletter-email" name="email" placeholder="<?php esc_attr_e( 'Enter Your Email', 'finsweet' ); ?>" autocomplete="email" required>
		<button class="button" type="submit"><?php esc_html_e( 'Subscribe', 'finsweet' ); ?></button>
	</form>
</section>
