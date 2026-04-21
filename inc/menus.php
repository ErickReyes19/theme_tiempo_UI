<?php
/**
 * Navigation menus.
 *
 * @package TiempoNoticias
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register menus.
 */
function tiempo_noticias_register_menus() {
	register_nav_menus(
		array(
			'primary'   => __( 'Primary Menu', 'tiempo-noticias' ),
			'top'       => __( 'Top Bar Menu', 'tiempo-noticias' ),
			'footer'    => __( 'Footer Menu', 'tiempo-noticias' ),
			'legal'     => __( 'Legal Menu', 'tiempo-noticias' ),
			'categories'=> __( 'Categories Menu', 'tiempo-noticias' ),
		)
	);
}
add_action( 'init', 'tiempo_noticias_register_menus' );
