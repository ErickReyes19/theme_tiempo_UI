<?php
/**
 * Theme setup and supports.
 *
 * @package TiempoNoticias
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register core theme supports.
 */
function tiempo_noticias_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 72,
			'width'       => 300,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	add_image_size( 'tiempo-hero', 1200, 675, true );
	add_image_size( 'tiempo-card', 720, 405, true );
	add_image_size( 'tiempo-thumb', 400, 260, true );
}
add_action( 'after_setup_theme', 'tiempo_noticias_setup' );

/**
 * Register block patterns.
 */
function tiempo_noticias_register_patterns() {
	$patterns = array(
		'hero-home',
		'section-trending',
		'section-latest',
		'section-category-grid',
		'section-ad-banner',
	);

	foreach ( $patterns as $pattern ) {
		register_block_pattern(
			'tiempo-noticias/' . $pattern,
			require TIEMPO_NOTICIAS_PATH . '/patterns/' . $pattern . '.php'
		);
	}
}
add_action( 'init', 'tiempo_noticias_register_patterns' );
