<?php
/**
 * Category card: icon, name and description.
 *
 * @package Finsweet
 *
 * @var array $args {
 *     @type WP_Term|int $term   Category term or ID.
 *     @type bool        $active  Highlight the card as the current category.
 *     @type bool        $compact Short card for the sidebar: icon and name in a row, no description.
 * }
 */

defined( 'ABSPATH' ) || exit;

$finsweet_term = isset( $args['term'] ) ? get_term( $args['term'], 'category' ) : null;

if ( ! $finsweet_term || is_wp_error( $finsweet_term ) ) {
	return;
}

$finsweet_icon_id = finsweet_get_category_icon_id( $finsweet_term );
$finsweet_active  = ! empty( $args['active'] );
$finsweet_compact = ! empty( $args['compact'] );
?>
<a class="category-card<?php echo $finsweet_compact ? ' category-card--compact' : ''; ?><?php echo $finsweet_active ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $finsweet_term ) ); ?>"<?php echo $finsweet_active ? ' aria-current="true"' : ''; ?>>
	<span class="category-card__icon">
		<?php
		if ( $finsweet_icon_id ) {
			echo wp_get_attachment_image(
				$finsweet_icon_id,
				'full',
				false,
				array(
					'alt'     => '',
					'loading' => 'lazy',
				)
			);
		}
		?>
	</span>
	<span class="category-card__name"><?php echo esc_html( $finsweet_term->name ); ?></span>
	<?php if ( ! $finsweet_compact && '' !== $finsweet_term->description ) : ?>
		<span class="category-card__text"><?php echo esc_html( $finsweet_term->description ); ?></span>
	<?php endif; ?>
</a>
