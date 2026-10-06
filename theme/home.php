<?php
/**
 * Template for the blog (posts page).
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

get_header();

$finsweet_featured   = finsweet_get_featured_post();
$finsweet_categories = get_categories(
	array(
		'exclude' => array( absint( get_option( 'default_category' ) ) ),
	)
);

if ( $finsweet_featured && ! is_paged() ) {
	get_template_part( 'template-parts/featured-post', null, array( 'post' => $finsweet_featured ) );
}
?>

<section class="section">
	<div class="container">
		<?php
		get_template_part(
			'template-parts/section-heading',
			null,
			array(
				'title'   => __( 'All posts', 'finsweet' ),
				'divider' => true,
			)
		);
		?>

		<?php if ( have_posts() ) : ?>
			<div class="post-list">
				<?php
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/post-card-horizontal', null, array( 'post' => get_post() ) );
				}
				?>
			</div>

			<?php finsweet_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'No posts yet.', 'finsweet' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php if ( ! empty( $finsweet_categories ) ) : ?>
	<section class="section">
		<div class="container">
			<?php get_template_part( 'template-parts/section-heading', null, array( 'title' => __( 'All Categories', 'finsweet' ) ) ); ?>
			<div class="category-grid">
				<?php
				foreach ( $finsweet_categories as $finsweet_category ) {
					get_template_part( 'template-parts/category-card', null, array( 'term' => $finsweet_category ) );
				}
				?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php
get_template_part( 'template-parts/join-our-team' );

get_footer();
