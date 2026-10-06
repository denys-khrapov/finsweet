<?php
/**
 * Search form.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'finsweet' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search…', 'finsweet' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
	</label>
	<button type="submit" class="button search-submit"><?php esc_html_e( 'Search', 'finsweet' ); ?></button>
</form>
