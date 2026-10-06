<?php
/**
 * Category badge: icon and name, links to the category archive.
 *
 * @package Finsweet
 *
 * @var array $args {
 *     @type WP_Term|int $term  Category term or ID.
 *     @type bool        $large Larger size, used in the article header.
 * }
 */

defined( 'ABSPATH' ) || exit;

$finsweet_term = isset( $args['term'] ) ? get_term( $args['term'], 'category' ) : null;

if ( ! $finsweet_term || is_wp_error( $finsweet_term ) ) {
	return;
}

$finsweet_icon_id = finsweet_get_category_icon_id( $finsweet_term );
?>
<a class="category-badge<?php echo ! empty( $args['large'] ) ? ' category-badge--large' : ''; ?>" href="<?php echo esc_url( get_term_link( $finsweet_term ) ); ?>">
	<?php if ( $finsweet_icon_id ) : ?>
		<?php
		echo wp_get_attachment_image(
			$finsweet_icon_id,
			'full',
			false,
			array(
				'class'   => 'category-badge__icon',
				'alt'     => '',
				'loading' => 'lazy',
			)
		);
		?>
	<?php endif; ?>
	<span class="category-badge__name"><?php echo esc_html( $finsweet_term->name ); ?></span>
</a>
