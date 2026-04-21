<?php
/**
 * Theme footer.
 *
 * @package TiempoNoticias
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$options = function_exists( 'tiempo_noticias_get_layout_options' ) ? tiempo_noticias_get_layout_options() : array();
?>
</main>
<footer class="tn-site-footer" role="contentinfo">
	<div class="tn-container">
		<div class="tn-footer-grid">
			<div><?php dynamic_sidebar( 'footer-1' ); ?></div>
			<div><?php dynamic_sidebar( 'footer-2' ); ?></div>
			<div><?php dynamic_sidebar( 'footer-3' ); ?></div>
		</div>
		<nav class="tn-footer-menu" aria-label="<?php esc_attr_e( 'Menú footer', 'tiempo-noticias' ); ?>">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'menu_class'     => 'tn-footer-menu__list',
					'container'      => false,
					'fallback_cb'    => 'tiempo_noticias_menu_fallback',
				)
			);
			?>
		</nav>
		<?php if ( ! empty( $options['footer_disclaimer'] ) ) : ?>
			<div class="tn-footer-disclaimer"><?php echo wp_kses_post( $options['footer_disclaimer'] ); ?></div>
		<?php endif; ?>
		<p class="tn-footer-copy"><?php echo esc_html( $options['footer_copyright'] ?? '' ); ?></p>
		<?php if ( ! empty( $options['footer_show_ads'] ) ) : ?>
			<?php echo tiempo_noticias_render_ad_slot( 'footer' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php endif; ?>
	</div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
