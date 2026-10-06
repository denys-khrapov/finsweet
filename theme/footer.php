<?php
/**
 * Site footer.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;
?>
</main>

<footer class="site-footer">
	<div class="container site-footer__inner">
		<a class="site-footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php bloginfo( 'name' ); ?>
		</a>

		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'footer',
				'container'       => 'nav',
				'container_class' => 'site-footer__nav',
				'menu_class'      => 'site-footer__menu',
				'depth'           => 1,
				'fallback_cb'     => false,
			)
		);
		?>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
