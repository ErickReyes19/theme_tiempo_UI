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
	add_theme_support( 'block-templates' );
	add_theme_support( 'block-template-parts' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array( 'height' => 72, 'width' => 320, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'customize-selective-refresh-widgets' );

	add_image_size( 'tiempo-hero', 1200, 675, true );
	add_image_size( 'tiempo-card', 720, 405, true );
	add_image_size( 'tiempo-thumb', 400, 260, true );
}
add_action( 'after_setup_theme', 'tiempo_noticias_setup' );

/**
 * Register sidebars.
 */
function tiempo_noticias_register_sidebars() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'tiempo-noticias' ),
			'id'            => 'sidebar-1',
			'before_widget' => '<section class="tn-widget">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="tn-widget-title">',
			'after_title'   => '</h3>',
		)
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		register_sidebar(
			array(
				'name'          => sprintf( __( 'Footer Column %d', 'tiempo-noticias' ), $i ),
				'id'            => 'footer-' . $i,
				'before_widget' => '<section class="tn-widget">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="tn-widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}
}
add_action( 'widgets_init', 'tiempo_noticias_register_sidebars' );
