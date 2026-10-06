<?php
/**
 * Template for the "page not found" screen.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="section not-found">
	<div class="container">
		<div class="not-found__inner">
			<p class="not-found__code">404</p>
			<h1 class="not-found__title"><?php esc_html_e( 'Page not found', 'finsweet' ); ?></h1>
			<p class="not-found__text"><?php esc_html_e( 'The page you are looking for does not exist or has been moved.', 'finsweet' ); ?></p>
			<?php get_search_form(); ?>
			<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'finsweet' ); ?></a>
		</div>
	</div>
</section>

<?php
get_footer();
