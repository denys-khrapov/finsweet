<?php
/**
 * Site header.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'finsweet' ); ?></a>

<header class="site-header">
	<div class="container site-header__inner">
		<div class="site-header__logo">
			<?php finsweet_the_logo(); ?>
		</div>

		<button class="site-header__toggle" type="button" aria-expanded="false" aria-controls="site-navigation">
			<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'finsweet' ); ?></span>
			<span class="site-header__burger" aria-hidden="true"></span>
		</button>

		<div class="site-header__panel" id="site-navigation">
			<?php
			wp_nav_menu(
				array(
					'theme_location'       => 'primary',
					'container'            => 'nav',
					'container_class'      => 'site-header__nav',
					'container_aria_label' => __( 'Main menu', 'finsweet' ),
					'menu_class'           => 'site-header__menu',
					'depth'                => 1,
					'fallback_cb'          => false,
				)
			);
			?>
			<a class="button button--light" href="#newsletter"><?php esc_html_e( 'Subscribe', 'finsweet' ); ?></a>
		</div>
	</div>
</header>

<main id="main" class="site-main">
