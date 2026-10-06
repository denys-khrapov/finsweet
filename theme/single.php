<?php
/**
 * Template for a single post.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$finsweet_author   = finsweet_get_post_author();
	$finsweet_category = finsweet_get_primary_category();
	$finsweet_related  = finsweet_get_related_posts();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'article' ); ?>>
		<header class="article__header container">
			<div class="article__inner">
				<div class="article__byline">
					<?php if ( $finsweet_author && has_post_thumbnail( $finsweet_author ) ) : ?>
						<span class="article__avatar">
							<?php echo get_the_post_thumbnail( $finsweet_author, 'finsweet-avatar', array( 'alt' => '' ) ); ?>
						</span>
					<?php endif; ?>
					<div>
						<?php if ( $finsweet_author ) : ?>
							<a class="article__author" href="<?php echo esc_url( get_permalink( $finsweet_author ) ); ?>"><?php echo esc_html( get_the_title( $finsweet_author ) ); ?></a>
						<?php endif; ?>
						<p class="article__date">
							<?php
							printf(
								/* translators: %s: publication date. */
								esc_html__( 'Posted on %s', 'finsweet' ),
								'<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date( 'jS F Y' ) ) . '</time>'
							);
							?>
						</p>
					</div>
				</div>

				<h1 class="article__title"><?php the_title(); ?></h1>

				<?php if ( $finsweet_category ) : ?>
					<?php
					get_template_part(
						'template-parts/category-badge',
						null,
						array(
							'term'  => $finsweet_category,
							'large' => true,
						)
					);
					?>
				<?php endif; ?>
			</div>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="article__cover container">
				<?php the_post_thumbnail( 'finsweet-cover' ); ?>
			</figure>
		<?php endif; ?>

		<div class="container">
			<div class="article__inner entry-content">
				<?php the_content(); ?>
			</div>
		</div>
	</article>

	<?php if ( ! empty( $finsweet_related ) ) : ?>
		<section class="section">
			<div class="container">
				<?php get_template_part( 'template-parts/section-heading', null, array( 'title' => __( 'What to read next', 'finsweet' ) ) ); ?>
				<div class="post-grid">
					<?php
					foreach ( $finsweet_related as $finsweet_related_post ) {
						get_template_part( 'template-parts/post-card-vertical', null, array( 'post' => $finsweet_related_post ) );
					}
					?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/join-our-team' ); ?>
	<?php
endwhile;

get_footer();
