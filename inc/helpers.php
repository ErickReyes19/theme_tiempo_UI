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

/**
 * Breaking ticker shortcode.
 * Usage: [tiempo_breaking limit="5"]
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function tiempo_noticias_breaking_ticker_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'limit' => 5,
		),
		$atts,
		'tiempo_breaking'
	);

	$query = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => (int) $atts['limit'],
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		)
	);

	if ( ! $query->have_posts() ) {
		return '';
	}

	$output = '<div class="tn-breaking-ticker" role="region" aria-label="' . esc_attr__( 'Última hora', 'tiempo-noticias' ) . '">';
	$output .= '<span class="tn-breaking-ticker__label">' . esc_html__( 'Última hora', 'tiempo-noticias' ) . '</span><ul class="tn-breaking-ticker__list">';

	while ( $query->have_posts() ) {
		$query->the_post();
		$output .= '<li><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></li>';
	}
	wp_reset_postdata();

	$output .= '</ul></div>';

	return $output;
}
add_shortcode( 'tiempo_breaking', 'tiempo_noticias_breaking_ticker_shortcode' );

/**
 * Related posts shortcode based on shared categories.
 * Usage: [tiempo_related count="3" title="Notas relacionadas"]
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function tiempo_noticias_related_posts_shortcode( $atts ) {
	if ( ! is_singular( 'post' ) ) {
		return '';
	}

	$atts = shortcode_atts(
		array(
			'count' => 3,
			'title' => __( 'Notas relacionadas', 'tiempo-noticias' ),
		),
		$atts,
		'tiempo_related'
	);

	$cats = wp_get_post_categories( get_the_ID() );
	if ( empty( $cats ) ) {
		return '';
	}

	$query = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => (int) $atts['count'],
			'post__not_in'        => array( get_the_ID() ),
			'category__in'        => $cats,
			'ignore_sticky_posts' => true,
		)
	);

	if ( ! $query->have_posts() ) {
		return '';
	}

	$output = '<section class="tn-related-posts"><h3>' . esc_html( $atts['title'] ) . '</h3><div class="tn-related-posts__grid">';

	while ( $query->have_posts() ) {
		$query->the_post();
		$output .= '<article class="tn-related-posts__item">';
		$output .= get_the_post_thumbnail( get_the_ID(), 'tiempo-thumb', array( 'loading' => 'lazy' ) );
		$output .= '<h4><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h4>';
		$output .= '</article>';
	}
	wp_reset_postdata();

	$output .= '</div></section>';

	return $output;
}
add_shortcode( 'tiempo_related', 'tiempo_noticias_related_posts_shortcode' );
