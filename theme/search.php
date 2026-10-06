<?php
/**
 * Template for search results.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="section">
	<div class="container">
		<?php
		get_template_part(
			'template-parts/section-heading',
			null,
			array(
				'tag'     => 'h1',
				'divider' => true,
				'title'   => sprintf(
					/* translators: %s: search query. */
					__( 'Search results for: %s', 'finsweet' ),
					get_search_query()
				),
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
			<div class="search-empty">
				<p class="search-empty__text"><?php esc_html_e( 'Nothing found. Try different keywords.', 'finsweet' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
get_footer();
