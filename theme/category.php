<?php
/**
 * Template for category archives.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

get_header();

$finsweet_description = term_description();
$finsweet_posts_page  = (int) get_option( 'page_for_posts' );
?>

<header class="page-header">
	<div class="container">
		<h1 class="page-header__title"><?php single_cat_title(); ?></h1>
		<?php if ( '' !== $finsweet_description ) : ?>
			<div class="page-header__text"><?php echo wp_kses_post( $finsweet_description ); ?></div>
		<?php endif; ?>
		<?php
		get_template_part(
			'template-parts/breadcrumbs',
			null,
			array(
				'items' => array(
					array(
						'label' => __( 'Blog', 'finsweet' ),
						'url'   => $finsweet_posts_page ? get_permalink( $finsweet_posts_page ) : home_url( '/' ),
					),
					array( 'label' => single_cat_title( '', false ) ),
				),
			)
		);
		?>
	</div>
</header>

<section class="section">
	<div class="container">
		<div class="archive-layout">
			<div class="archive-layout__main">
				<?php if ( have_posts() ) : ?>
					<div class="post-list post-list--compact">
						<?php
						while ( have_posts() ) {
							the_post();
							get_template_part( 'template-parts/post-card-horizontal', null, array( 'post' => get_post() ) );
						}
						?>
					</div>

					<?php finsweet_pagination(); ?>
				<?php else : ?>
					<p><?php esc_html_e( 'No posts in this category yet.', 'finsweet' ); ?></p>
				<?php endif; ?>
			</div>

			<?php get_template_part( 'template-parts/sidebar' ); ?>
		</div>
	</div>
</section>

<?php
get_template_part( 'template-parts/join-our-team' );

get_footer();
