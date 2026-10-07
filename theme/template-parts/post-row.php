<?php
/**
 * Post row: meta line and title, for compact lists.
 *
 * @package Finsweet
 *
 * @var array $args {
 *     @type WP_Post|int $post Post, defaults to the current post.
 * }
 */

defined( 'ABSPATH' ) || exit;

$finsweet_post = get_post( isset( $args['post'] ) ? $args['post'] : null );

if ( ! $finsweet_post ) {
	return;
}
?>
<article class="post-row">
	<?php get_template_part( 'template-parts/post-meta', null, array( 'post' => $finsweet_post ) ); ?>
	<h3 class="post-row__title">
		<a href="<?php echo esc_url( get_permalink( $finsweet_post ) ); ?>"><?php echo esc_html( get_the_title( $finsweet_post ) ); ?></a>
	</h3>
</article>
