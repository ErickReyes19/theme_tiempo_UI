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
			'primary'    => __( 'Primary Menu', 'tiempo-noticias' ),
			'top'        => __( 'Top Bar Menu', 'tiempo-noticias' ),
			'footer'     => __( 'Footer Menu', 'tiempo-noticias' ),
			'legal'      => __( 'Legal Menu', 'tiempo-noticias' ),
			'categories' => __( 'Categories Menu', 'tiempo-noticias' ),
		)
	);
}
add_action( 'init', 'tiempo_noticias_register_menus' );

/**
 * Render a menu from a location via shortcode.
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function tiempo_noticias_menu_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'location' => 'primary',
			'class'    => '',
			'depth'    => 2,
		),
		$atts,
		'tiempo_menu'
	);

	$location = sanitize_key( $atts['location'] );
	$class    = sanitize_html_class( $atts['class'] );
	$depth    = max( 1, absint( $atts['depth'] ) );
	$locations = get_nav_menu_locations();

	if ( isset( $locations[ $location ] ) ) {
		return wp_nav_menu(
			array(
				'theme_location' => $location,
				'container'      => 'nav',
				'container_class'=> trim( 'tn-menu tn-menu--' . $location . ' ' . $class ),
				'menu_class'     => 'tn-menu__items',
				'echo'           => false,
				'depth'          => $depth,
			)
		);
	}

	return wp_page_menu(
		array(
			'echo'      => false,
			'menu_id'   => '',
			'menu_class'=> trim( 'tn-menu__items tn-menu__items--fallback' ),
			'before'    => '<nav class="tn-menu tn-menu--' . esc_attr( $location ) . ' ' . esc_attr( $class ) . '">',
			'after'     => '</nav>',
		)
	);
}
add_shortcode( 'tiempo_menu', 'tiempo_noticias_menu_shortcode' );
