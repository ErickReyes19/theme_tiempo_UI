<?php
/**
 * Template helpers.
 *
 * @package TiempoNoticias
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return compact post meta markup.
 *
 * @param int|null $post_id Post ID.
 * @return string
 */
function tiempo_noticias_get_post_meta( $post_id = null ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();

	if ( ! $post_id ) {
		return '';
	}

	$author = get_the_author_meta( 'display_name', (int) get_post_field( 'post_author', $post_id ) );
	$date   = get_the_date( 'j M Y', $post_id );
	$terms  = get_the_category( $post_id );
	$cat    = ! empty( $terms ) ? $terms[0]->name : __( 'General', 'tiempo-noticias' );

	return sprintf(
		'<span class="tn-meta tn-meta--cat">%1$s</span><span aria-hidden="true">•</span><span class="tn-meta tn-meta--author">%2$s</span><span aria-hidden="true">•</span><time class="tn-meta tn-meta--date" datetime="%3$s">%4$s</time>',
		esc_html( $cat ),
		esc_html( $author ),
		esc_attr( get_the_date( DATE_W3C, $post_id ) ),
		esc_html( $date )
	);
}

/**
 * Render category badge for current post.
 *
 * @param int|null $post_id Post ID.
 * @return string
 */
function tiempo_noticias_get_category_badge( $post_id = null ) {
	$post_id = $post_id ? (int) $post_id : get_the_ID();
	$terms   = get_the_category( $post_id );

	if ( empty( $terms ) ) {
		return '';
	}

	$url = get_category_link( $terms[0]->term_id );

	return sprintf(
		'<a href="%1$s" class="tn-category-badge">%2$s</a>',
		esc_url( $url ),
		esc_html( $terms[0]->name )
	);
}
