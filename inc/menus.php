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
			'secondary' => __( 'Secondary Menu', 'tiempo-noticias' ),
			'footer'    => __( 'Footer Menu', 'tiempo-noticias' ),
			'legal'     => __( 'Legal Menu', 'tiempo-noticias' ),
		)
	);
}
add_action( 'init', 'tiempo_noticias_register_menus' );

/**
 * Fallback menu renderer.
 */
function tiempo_noticias_menu_fallback() {
	echo wp_kses_post(
		wp_page_menu(
			array(
				'echo'       => false,
				'menu_class' => 'tn-fallback-menu',
			)
		)
	);
}
