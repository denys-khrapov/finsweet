<?php
/**
 * Join our team block.
 *
 * @package Finsweet
 *
 * @var array $block      Block settings and attributes.
 * @var bool  $is_preview True in the editor preview.
 */

defined( 'ABSPATH' ) || exit;

$finsweet_title  = finsweet_block_field( 'title' );
$finsweet_text   = finsweet_block_field( 'text' );
$finsweet_button = finsweet_block_link( 'button' );

if ( '' === $finsweet_title && '' === $finsweet_text && null === $finsweet_button ) {
	if ( $is_preview ) {
		echo '<p>' . esc_html__( 'Join our team: fill in the block fields.', 'finsweet' ) . '</p>';
	}
	return;
}

get_template_part(
	'template-parts/join-our-team',
	null,
	array(
		'title'      => $finsweet_title,
		'text'       => $finsweet_text,
		'button'     => $finsweet_button,
		'attributes' => get_block_wrapper_attributes( array( 'class' => 'section join-team' ) ),
	)
);
