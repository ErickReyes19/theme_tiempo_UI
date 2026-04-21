<?php
/**
 * Header/Footer builder options and rendering.
 *
 * @package TiempoNoticias
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register layout settings.
 */
function tiempo_noticias_register_layout_settings() {
	register_setting( 'tn_layout_builder', 'tn_layout_builder_options', 'tiempo_noticias_sanitize_layout_options' );

	add_options_page(
		__( 'Layout Builder', 'tiempo-noticias' ),
		__( 'Layout Builder', 'tiempo-noticias' ),
		'manage_options',
		'tn-layout-builder',
		'tiempo_noticias_layout_builder_page'
	);
}
add_action( 'admin_menu', 'tiempo_noticias_register_layout_settings' );

/**
 * Sanitize layout options.
 *
 * @param array $input Incoming options.
 * @return array
 */
function tiempo_noticias_sanitize_layout_options( $input ) {
	$defaults = tiempo_noticias_get_layout_options();
	$allowed  = wp_kses_allowed_html( 'post' );

	return array(
		'header_top_html'    => wp_kses( (string) ( $input['header_top_html'] ?? '' ), $allowed ),
		'footer_disclaimer'  => wp_kses_post( (string) ( $input['footer_disclaimer'] ?? '' ) ),
		'footer_copyright'   => sanitize_text_field( $input['footer_copyright'] ?? '' ),
		'header_show_search' => ! empty( $input['header_show_search'] ),
		'header_cta_text'    => sanitize_text_field( $input['header_cta_text'] ?? '' ),
		'header_cta_url'     => esc_url_raw( $input['header_cta_url'] ?? '' ),
		'footer_show_ads'    => ! empty( $input['footer_show_ads'] ),
		'header_show_ads'    => ! empty( $input['header_show_ads'] ),
	) + $defaults;
}

/**
 * Get layout options with defaults.
 *
 * @return array
 */
function tiempo_noticias_get_layout_options() {
	$defaults = array(
		'header_top_html'    => '',
		'footer_disclaimer'  => '',
		'footer_copyright'   => '© ' . gmdate( 'Y' ) . ' ' . get_bloginfo( 'name' ),
		'header_show_search' => true,
		'header_cta_text'    => __( 'Suscríbete', 'tiempo-noticias' ),
		'header_cta_url'     => '#',
		'footer_show_ads'    => true,
		'header_show_ads'    => false,
	);

	return wp_parse_args( get_option( 'tn_layout_builder_options', array() ), $defaults );
}

/**
 * Layout builder page.
 */
function tiempo_noticias_layout_builder_page() {
	$options = tiempo_noticias_get_layout_options();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Layout Builder', 'tiempo-noticias' ); ?></h1>
		<p><?php esc_html_e( 'Configura Header, Navigation y Footer globales del theme editorial.', 'tiempo-noticias' ); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'tn_layout_builder' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="tn-header-top"><?php esc_html_e( 'Header: bloque superior HTML', 'tiempo-noticias' ); ?></label></th>
					<td><textarea id="tn-header-top" name="tn_layout_builder_options[header_top_html]" rows="6" class="large-text code"><?php echo esc_textarea( $options['header_top_html'] ); ?></textarea></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Mostrar buscador en header', 'tiempo-noticias' ); ?></th>
					<td><label><input type="checkbox" name="tn_layout_builder_options[header_show_search]" value="1" <?php checked( $options['header_show_search'] ); ?> /> <?php esc_html_e( 'Activado', 'tiempo-noticias' ); ?></label></td>
				</tr>
				<tr>
					<th scope="row"><label for="tn-header-cta-text"><?php esc_html_e( 'Texto botón header', 'tiempo-noticias' ); ?></label></th>
					<td><input id="tn-header-cta-text" type="text" name="tn_layout_builder_options[header_cta_text]" class="regular-text" value="<?php echo esc_attr( $options['header_cta_text'] ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><label for="tn-header-cta-url"><?php esc_html_e( 'URL botón header', 'tiempo-noticias' ); ?></label></th>
					<td><input id="tn-header-cta-url" type="url" name="tn_layout_builder_options[header_cta_url]" class="regular-text" value="<?php echo esc_attr( $options['header_cta_url'] ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Header con anuncio', 'tiempo-noticias' ); ?></th>
					<td><label><input type="checkbox" name="tn_layout_builder_options[header_show_ads]" value="1" <?php checked( $options['header_show_ads'] ); ?> /> <?php esc_html_e( 'Mostrar slot header', 'tiempo-noticias' ); ?></label></td>
				</tr>
				<tr>
					<th scope="row"><label for="tn-footer-disclaimer"><?php esc_html_e( 'Disclaimer legal', 'tiempo-noticias' ); ?></label></th>
					<td><?php wp_editor( $options['footer_disclaimer'], 'tn-footer-disclaimer', array( 'textarea_name' => 'tn_layout_builder_options[footer_disclaimer]', 'textarea_rows' => 4 ) ); ?></td>
				</tr>
				<tr>
					<th scope="row"><label for="tn-footer-copy"><?php esc_html_e( 'Copyright', 'tiempo-noticias' ); ?></label></th>
					<td><input id="tn-footer-copy" type="text" name="tn_layout_builder_options[footer_copyright]" class="regular-text" value="<?php echo esc_attr( $options['footer_copyright'] ); ?>" /></td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Footer con anuncio', 'tiempo-noticias' ); ?></th>
					<td><label><input type="checkbox" name="tn_layout_builder_options[footer_show_ads]" value="1" <?php checked( $options['footer_show_ads'] ); ?> /> <?php esc_html_e( 'Mostrar slot footer', 'tiempo-noticias' ); ?></label></td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
