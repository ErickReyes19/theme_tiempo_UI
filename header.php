<?php
/**
 * Theme header.
 *
 * @package TiempoNoticias
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$options = function_exists( 'tiempo_noticias_get_layout_options' ) ? tiempo_noticias_get_layout_options() : array();
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="tn-site-header" role="banner">
	<?php if ( ! empty( $options['header_top_html'] ) ) : ?>
		<div class="tn-header-top"><?php echo wp_kses_post( $options['header_top_html'] ); ?></div>
	<?php endif; ?>
	<div class="tn-header-main">
		<div class="tn-container tn-header-main__inner">
			<div class="tn-branding">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tn-site-title"><?php bloginfo( 'name' ); ?></a>
				<?php endif; ?>
			</div>
			<nav class="tn-main-nav" aria-label="<?php esc_attr_e( 'Menú principal', 'tiempo-noticias' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_class'     => 'tn-main-nav__list',
						'container'      => false,
						'fallback_cb'    => 'tiempo_noticias_menu_fallback',
					)
				);
				?>
			</nav>
			<button class="tn-drawer-toggle" aria-expanded="false" aria-controls="tn-mobile-drawer">☰</button>
			<div class="tn-header-actions">
				<?php if ( ! empty( $options['header_show_search'] ) ) : get_search_form(); endif; ?>
				<?php if ( ! empty( $options['header_cta_text'] ) ) : ?>
					<a class="tn-header-cta" href="<?php echo esc_url( $options['header_cta_url'] ?? '#' ); ?>"><?php echo esc_html( $options['header_cta_text'] ); ?></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php if ( ! empty( $options['header_show_ads'] ) ) : ?>
		<?php echo tiempo_noticias_render_ad_slot( 'header', 'tn-container' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php endif; ?>
	<?php echo tiempo_noticias_render_ad_slot( 'below_header', 'tn-container' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div id="tn-mobile-drawer" class="tn-mobile-drawer" hidden>
		<nav aria-label="<?php esc_attr_e( 'Menú móvil', 'tiempo-noticias' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_class'     => 'tn-mobile-drawer__list',
					'container'      => false,
					'fallback_cb'    => 'tiempo_noticias_menu_fallback',
				)
			);
			?>
		</nav>
	</div>
</header>
<main id="primary" class="tn-site-main tn-container">
