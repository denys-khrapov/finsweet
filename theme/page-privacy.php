<?php
/**
 * Template Name: Privacy Policy
 *
 * Text page with a header showing the date of the last update.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<header class="page-header">
		<div class="container">
			<h1 class="page-header__title"><?php the_title(); ?></h1>
			<p class="page-header__meta">
				<?php
				printf(
					/* translators: %s: date of the last update. */
					esc_html__( 'Last Updated on %s', 'finsweet' ),
					'<time datetime="' . esc_attr( get_the_modified_date( 'c' ) ) . '">' . esc_html( get_the_modified_date( 'jS F Y' ) ) . '</time>'
				);
				?>
			</p>
		</div>
	</header>

	<div class="section">
		<div class="container">
			<div class="article__inner entry-content">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
	<?php
endwhile;

get_footer();
