<?php
/**
 * Blog sidebar: categories and all tags.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

$finsweet_categories = get_categories(
	array(
		'exclude' => array( absint( get_option( 'default_category' ) ) ),
	)
);
$finsweet_tags       = get_tags();
$finsweet_current    = is_category() ? get_queried_object_id() : 0;
?>
<aside class="sidebar">
	<?php if ( ! empty( $finsweet_categories ) ) : ?>
		<section class="sidebar__section">
			<h2 class="sidebar__title"><?php esc_html_e( 'Categories', 'finsweet' ); ?></h2>
			<div class="sidebar__categories">
				<?php
				foreach ( $finsweet_categories as $finsweet_category ) {
					get_template_part(
						'template-parts/category-card',
						null,
						array(
							'term'    => $finsweet_category,
							'compact' => true,
							'active'  => $finsweet_current === $finsweet_category->term_id,
						)
					);
				}
				?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( ! empty( $finsweet_tags ) ) : ?>
		<section class="sidebar__section">
			<h2 class="sidebar__title"><?php esc_html_e( 'All Tags', 'finsweet' ); ?></h2>
			<ul class="tag-list">
				<?php foreach ( $finsweet_tags as $finsweet_tag ) : ?>
					<li>
						<a class="tag-list__link" href="<?php echo esc_url( get_tag_link( $finsweet_tag ) ); ?>"><?php echo esc_html( $finsweet_tag->name ); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endif; ?>
</aside>
