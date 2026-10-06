<?php
/**
 * Template for pages: the content is assembled from blocks.
 *
 * @package Finsweet
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) {
	the_post();
	the_content();
}

get_footer();
