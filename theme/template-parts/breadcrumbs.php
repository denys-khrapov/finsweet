<?php
/**
 * Breadcrumbs: a list of links ending with the current page.
 *
 * @package Finsweet
 *
 * @var array $args {
 *     @type array[] $items List of items: `label` and optional `url`; the last item is the current page.
 * }
 */

defined( 'ABSPATH' ) || exit;

$finsweet_items = isset( $args['items'] ) && is_array( $args['items'] ) ? $args['items'] : array();

if ( empty( $finsweet_items ) ) {
	return;
}

$finsweet_last = count( $finsweet_items ) - 1;
?>
<nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumbs', 'finsweet' ); ?>">
	<ol class="breadcrumbs__list">
		<?php foreach ( $finsweet_items as $finsweet_index => $finsweet_item ) : ?>
			<li class="breadcrumbs__item">
				<?php if ( ! empty( $finsweet_item['url'] ) && $finsweet_index < $finsweet_last ) : ?>
					<a class="breadcrumbs__link" href="<?php echo esc_url( $finsweet_item['url'] ); ?>"><?php echo esc_html( $finsweet_item['label'] ); ?></a>
				<?php else : ?>
					<span aria-current="page"><?php echo esc_html( $finsweet_item['label'] ); ?></span>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
	</ol>
</nav>
