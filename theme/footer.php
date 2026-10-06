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
		<div class="site-footer__top">
			<div class="site-footer__logo">
				<?php finsweet_the_logo(); ?>
			</div>

			<?php
			wp_nav_menu(
				array(
					'theme_location'       => 'footer',
					'container'            => 'nav',
					'container_class'      => 'site-footer__nav',
					'container_aria_label' => __( 'Footer menu', 'finsweet' ),
					'menu_class'           => 'site-footer__menu',
					'depth'                => 1,
					'fallback_cb'          => false,
				)
			);
			?>
		</div>

		<?php get_template_part( 'template-parts/newsletter' ); ?>

		<?php
		$finsweet_address = finsweet_option( 'address' );
		$finsweet_email   = finsweet_option( 'email' );
		$finsweet_phone   = finsweet_option( 'phone' );
		?>
		<div class="site-footer__bottom">
			<address class="site-footer__contacts">
				<?php if ( '' !== $finsweet_address ) : ?>
					<span><?php echo esc_html( $finsweet_address ); ?></span>
				<?php endif; ?>
				<?php if ( '' !== $finsweet_email || '' !== $finsweet_phone ) : ?>
					<span>
						<?php if ( '' !== $finsweet_email ) : ?>
							<a href="mailto:<?php echo esc_attr( antispambot( $finsweet_email ) ); ?>"><?php echo esc_html( antispambot( $finsweet_email ) ); ?></a>
						<?php endif; ?>
						<?php if ( '' !== $finsweet_phone ) : ?>
							<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $finsweet_phone ) ); ?>"><?php echo esc_html( $finsweet_phone ); ?></a>
						<?php endif; ?>
					</span>
				<?php endif; ?>
			</address>

			<?php get_template_part( 'template-parts/social-links' ); ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
