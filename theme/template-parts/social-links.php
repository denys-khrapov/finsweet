<?php
/**
 * Social links from the Finsweet settings page.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

$finsweet_networks = array(
	'facebook'  => __( 'Facebook', 'finsweet' ),
	'twitter'   => __( 'Twitter', 'finsweet' ),
	'instagram' => __( 'Instagram', 'finsweet' ),
	'linkedin'  => __( 'LinkedIn', 'finsweet' ),
);

$finsweet_links = array();

foreach ( $finsweet_networks as $finsweet_slug => $finsweet_label ) {
	$finsweet_url = finsweet_option( $finsweet_slug . '_url' );

	if ( '' !== $finsweet_url ) {
		$finsweet_links[ $finsweet_slug ] = array(
			'url'   => $finsweet_url,
			'label' => $finsweet_label,
		);
	}
}

if ( empty( $finsweet_links ) ) {
	return;
}
?>
<ul class="social-links">
	<?php foreach ( $finsweet_links as $finsweet_slug => $finsweet_link ) : ?>
		<li>
			<a class="social-links__link" style="--icon: url(<?php echo esc_url( get_theme_file_uri( 'assets/images/' . $finsweet_slug . '.svg' ) ); ?>)" href="<?php echo esc_url( $finsweet_link['url'] ); ?>" target="_blank" rel="noopener noreferrer">
				<span class="screen-reader-text"><?php echo esc_html( $finsweet_link['label'] ); ?></span>
			</a>
		</li>
	<?php endforeach; ?>
</ul>
