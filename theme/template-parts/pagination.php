<?php
/**
 * Pagination: Prev, page numbers, Next.
 *
 * @package Finsweet
 *
 * @var array $args {
 *     @type string[] $pages    Page links from paginate_links().
 *     @type string   $prev_url Previous page URL, empty on the first page.
 *     @type string   $next_url Next page URL, empty on the last page.
 * }
 */

defined( 'ABSPATH' ) || exit;

if ( empty( $args['pages'] ) ) {
	return;
}
?>
<nav class="pagination" aria-label="<?php esc_attr_e( 'Pagination', 'finsweet' ); ?>">
	<?php if ( ! empty( $args['prev_url'] ) ) : ?>
		<a class="pagination__nav" href="<?php echo esc_url( $args['prev_url'] ); ?>" rel="prev">&lsaquo; <?php esc_html_e( 'Prev', 'finsweet' ); ?></a>
	<?php else : ?>
		<span class="pagination__nav is-disabled" aria-disabled="true">&lsaquo; <?php esc_html_e( 'Prev', 'finsweet' ); ?></span>
	<?php endif; ?>

	<ul class="pagination__pages">
		<?php foreach ( $args['pages'] as $finsweet_page ) : ?>
			<li><?php echo wp_kses_post( $finsweet_page ); ?></li>
		<?php endforeach; ?>
	</ul>

	<?php if ( ! empty( $args['next_url'] ) ) : ?>
		<a class="pagination__nav" href="<?php echo esc_url( $args['next_url'] ); ?>" rel="next"><?php esc_html_e( 'Next', 'finsweet' ); ?> &rsaquo;</a>
	<?php else : ?>
		<span class="pagination__nav is-disabled" aria-disabled="true"><?php esc_html_e( 'Next', 'finsweet' ); ?> &rsaquo;</span>
	<?php endif; ?>
</nav>
