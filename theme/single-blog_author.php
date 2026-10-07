<?php
/**
 * Template for a single author.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

$finsweet_paged = max( 1, (int) get_query_var( 'page' ) );
$finsweet_posts = finsweet_get_author_posts_query( get_queried_object(), $finsweet_paged );

if ( $finsweet_paged > 1 && ! $finsweet_posts->have_posts() ) {
	global $wp_query;

	$wp_query->set_404();
	status_header( 404 );
	nocache_headers();
	require get_theme_file_path( '404.php' );
	return;
}

get_header();

while ( have_posts() ) :
	the_post();

	$finsweet_links  = finsweet_get_author_links( get_post() );
	$finsweet_base   = get_option( 'permalink_structure' ) ? trailingslashit( get_permalink() ) . '%#%/' : add_query_arg( 'page', '%#%', get_permalink() );
	$finsweet_social = array(
		'facebook'  => __( 'Facebook', 'finsweet' ),
		'twitter'   => __( 'Twitter', 'finsweet' ),
		'instagram' => __( 'Instagram', 'finsweet' ),
		'linkedin'  => __( 'LinkedIn', 'finsweet' ),
	);
	?>
	<header class="author-hero">
		<div class="container">
			<div class="author-hero__inner">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="author-hero__photo">
						<?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
					</div>
				<?php endif; ?>
				<div class="author-hero__body">
					<h1 class="author-hero__title">
						<?php
						printf(
							/* translators: %s: author name. */
							esc_html__( 'Hey there, I’m %s and welcome to my Blog', 'finsweet' ),
							esc_html( get_the_title() )
						);
						?>
					</h1>
					<div class="author-hero__bio entry-content"><?php the_content(); ?></div>
					<?php if ( ! empty( $finsweet_links ) ) : ?>
						<ul class="social-links social-links--dark">
							<?php foreach ( $finsweet_links as $finsweet_slug => $finsweet_url ) : ?>
								<li>
									<a class="social-links__link" style="--icon: url(<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $finsweet_slug . '.svg' ) ); ?>)" href="<?php echo esc_url( $finsweet_url ); ?>" target="_blank" rel="noopener noreferrer">
										<span class="screen-reader-text"><?php echo esc_html( $finsweet_social[ $finsweet_slug ] ); ?></span>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
			<?php get_template_part( 'template-parts/stripe' ); ?>
		</div>
	</header>

	<section class="section">
		<div class="container">
			<?php get_template_part( 'template-parts/section-heading', null, array( 'title' => __( 'My Posts', 'finsweet' ) ) ); ?>

			<?php if ( $finsweet_posts->have_posts() ) : ?>
				<div class="post-list">
					<?php
					while ( $finsweet_posts->have_posts() ) {
						$finsweet_posts->the_post();
						get_template_part( 'template-parts/post-card-horizontal', null, array( 'post' => get_post() ) );
					}
					wp_reset_postdata();
					?>
				</div>

				<?php
				finsweet_pagination(
					$finsweet_posts,
					array(
						'current' => $finsweet_paged,
						'base'    => $finsweet_base,
					)
				);
				?>
			<?php else : ?>
				<p><?php esc_html_e( 'No posts yet.', 'finsweet' ); ?></p>
			<?php endif; ?>
		</div>
	</section>
	<?php
endwhile;

get_template_part( 'template-parts/join-our-team' );

get_footer();
