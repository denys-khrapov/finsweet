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
		<a class="site-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
			<?php bloginfo( 'name' ); ?>
		</a>

		<?php
		wp_nav_menu(
			array(
				'theme_location'  => 'primary',
				'container'       => 'nav',
				'container_class' => 'site-header__nav',
				'menu_class'      => 'site-header__menu',
				'depth'           => 1,
				'fallback_cb'     => false,
			)
		);
		?>
	</div>
</header>

<main id="main" class="site-main">
