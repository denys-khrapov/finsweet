<?php
/**
 * Section heading with an optional divider line.
 *
 * @package Finsweet
 *
 * @var array $args {
 *     @type string $title   Heading text.
 *     @type string $tag     Heading tag, default h2.
 *     @type bool   $divider Show the line under the heading.
 *     @type string $link    Optional "View all" link URL.
 * }
 */

defined( 'ABSPATH' ) || exit;

$finsweet_title = isset( $args['title'] ) ? (string) $args['title'] : '';

if ( '' === $finsweet_title ) {
	return;
}

$finsweet_tag = isset( $args['tag'] ) && in_array( $args['tag'], array( 'h1', 'h2', 'h3' ), true ) ? $args['tag'] : 'h2';
$finsweet_url = isset( $args['link'] ) ? (string) $args['link'] : '';
?>
<div class="section-heading<?php echo ! empty( $args['divider'] ) ? ' section-heading--divider' : ''; ?>">
	<<?php echo esc_html( $finsweet_tag ); ?> class="section-heading__title"><?php echo esc_html( $finsweet_title ); ?></<?php echo esc_html( $finsweet_tag ); ?>>
	<?php if ( '' !== $finsweet_url ) : ?>
		<a class="text-link" href="<?php echo esc_url( $finsweet_url ); ?>"><?php esc_html_e( 'View all', 'finsweet' ); ?></a>
	<?php endif; ?>
</div>
