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
}
add_action( 'wp_enqueue_scripts', 'tiempo_noticias_enqueue_assets' );
