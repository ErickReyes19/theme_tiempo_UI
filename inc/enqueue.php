<?php
/**
 * Enqueue assets.
 *
 * @package TiempoNoticias
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue frontend styles.
 */
function tiempo_noticias_enqueue_assets() {
	wp_enqueue_style( 'tiempo-noticias-style', get_stylesheet_uri(), array(), TIEMPO_NOTICIAS_VERSION );
	wp_enqueue_style( 'tiempo-noticias-ui', TIEMPO_NOTICIAS_URI . '/assets/css/ui.css', array( 'tiempo-noticias-style' ), TIEMPO_NOTICIAS_VERSION );
	wp_enqueue_script( 'tiempo-noticias-ui', TIEMPO_NOTICIAS_URI . '/assets/js/theme.js', array(), TIEMPO_NOTICIAS_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'tiempo_noticias_enqueue_assets' );
