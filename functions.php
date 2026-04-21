<?php
/**
 * Tiempo Noticias theme bootstrap.
 *
 * @package TiempoNoticias
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TIEMPO_NOTICIAS_VERSION', '2.0.0' );
define( 'TIEMPO_NOTICIAS_PATH', get_template_directory() );
define( 'TIEMPO_NOTICIAS_URI', get_template_directory_uri() );

require_once TIEMPO_NOTICIAS_PATH . '/inc/setup.php';
require_once TIEMPO_NOTICIAS_PATH . '/inc/enqueue.php';
require_once TIEMPO_NOTICIAS_PATH . '/inc/menus.php';
require_once TIEMPO_NOTICIAS_PATH . '/inc/helpers.php';
require_once TIEMPO_NOTICIAS_PATH . '/inc/layout-builder.php';
require_once TIEMPO_NOTICIAS_PATH . '/inc/template-builder.php';
require_once TIEMPO_NOTICIAS_PATH . '/inc/ads.php';
