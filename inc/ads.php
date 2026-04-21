<?php
/**
 * Flexible Ads system.
 *
 * @package TiempoNoticias
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slot registry.
 *
 * @return array
 */
function tiempo_noticias_ad_slots() {
	return array(
		'header'             => __( 'Header', 'tiempo-noticias' ),
		'below_header'       => __( 'Debajo del header', 'tiempo-noticias' ),
		'before_title'       => __( 'Antes del título', 'tiempo-noticias' ),
		'after_title'        => __( 'Después del título', 'tiempo-noticias' ),
		'in_content'         => __( 'Dentro del contenido', 'tiempo-noticias' ),
		'between_paragraphs' => __( 'Entre párrafos', 'tiempo-noticias' ),
		'before_content'     => __( 'Antes del contenido', 'tiempo-noticias' ),
		'after_content'      => __( 'Después del contenido', 'tiempo-noticias' ),
		'home_between_blocks'=> __( 'Entre bloques Home', 'tiempo-noticias' ),
		'sidebar'            => __( 'Sidebar', 'tiempo-noticias' ),
		'footer'             => __( 'Footer', 'tiempo-noticias' ),
	);
}

/**
 * Register ad settings and page.
 */
function tiempo_noticias_register_ads_settings() {
	register_setting( 'tn_ads_manager', 'tn_ads_manager_slots', 'tiempo_noticias_sanitize_ads_slots' );

	add_theme_page(
		__( 'Ads Manager', 'tiempo-noticias' ),
		__( 'Ads Manager', 'tiempo-noticias' ),
		'manage_options',
		'tn-ads-manager',
		'tiempo_noticias_ads_manager_page'
	);
}
add_action( 'admin_menu', 'tiempo_noticias_register_ads_settings' );

/**
 * Defaults.
 *
 * @return array
 */
function tiempo_noticias_get_ads_slots_options() {
	$defaults = array();
	foreach ( tiempo_noticias_ad_slots() as $key => $label ) {
		$defaults[ $key ] = array(
			'enabled'   => false,
			'code'      => '',
			'desktop'   => true,
			'tablet'    => true,
			'mobile'    => true,
			'behavior'  => 'responsive',
			'paragraph' => 3,
		);
	}

	return wp_parse_args( get_option( 'tn_ads_manager_slots', array() ), $defaults );
}

/**
 * Sanitize.
 *
 * @param array $input raw input.
 * @return array
 */
function tiempo_noticias_sanitize_ads_slots( $input ) {
	$allowed = wp_kses_allowed_html( 'post' );
	$allowed['script'] = array(
		'type'        => true,
		'async'       => true,
		'src'         => true,
		'id'          => true,
		'data-ad-slot'=> true,
	);

	$sanitized = array();
	foreach ( tiempo_noticias_ad_slots() as $slot => $label ) {
		$item = $input[ $slot ] ?? array();
		$sanitized[ $slot ] = array(
			'enabled'   => ! empty( $item['enabled'] ),
			'code'      => wp_kses( (string) ( $item['code'] ?? '' ), $allowed ),
			'desktop'   => ! empty( $item['desktop'] ),
			'tablet'    => ! empty( $item['tablet'] ),
			'mobile'    => ! empty( $item['mobile'] ),
			'behavior'  => in_array( ( $item['behavior'] ?? 'responsive' ), array( 'fixed', 'responsive', 'sticky', 'inline' ), true ) ? $item['behavior'] : 'responsive',
			'paragraph' => max( 1, absint( $item['paragraph'] ?? 3 ) ),
		);
	}
	return $sanitized;
}

/**
 * Admin page.
 */
function tiempo_noticias_ads_manager_page() {
	$slots = tiempo_noticias_get_ads_slots_options();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Ads Manager', 'tiempo-noticias' ); ?></h1>
		<p><?php esc_html_e( 'Define slots manuales y comportamiento por dispositivo para Google Ad Manager / AdSense.', 'tiempo-noticias' ); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'tn_ads_manager' ); ?>
			<table class="widefat striped">
				<thead>
				<tr><th><?php esc_html_e( 'Slot', 'tiempo-noticias' ); ?></th><th><?php esc_html_e( 'Control', 'tiempo-noticias' ); ?></th></tr>
				</thead>
				<tbody>
				<?php foreach ( tiempo_noticias_ad_slots() as $slot_key => $slot_label ) : ?>
					<tr>
						<td><strong><?php echo esc_html( $slot_label ); ?></strong><br><code><?php echo esc_html( $slot_key ); ?></code></td>
						<td>
							<p><label><input type="checkbox" name="tn_ads_manager_slots[<?php echo esc_attr( $slot_key ); ?>][enabled]" value="1" <?php checked( $slots[ $slot_key ]['enabled'] ); ?> /> <?php esc_html_e( 'Activo', 'tiempo-noticias' ); ?></label></p>
							<p><textarea class="large-text code" rows="4" name="tn_ads_manager_slots[<?php echo esc_attr( $slot_key ); ?>][code]" placeholder="Google Ad Manager / AdSense code"><?php echo esc_textarea( $slots[ $slot_key ]['code'] ); ?></textarea></p>
							<p>
								<label><input type="checkbox" name="tn_ads_manager_slots[<?php echo esc_attr( $slot_key ); ?>][desktop]" value="1" <?php checked( $slots[ $slot_key ]['desktop'] ); ?> /> Desktop</label>
								<label><input type="checkbox" name="tn_ads_manager_slots[<?php echo esc_attr( $slot_key ); ?>][tablet]" value="1" <?php checked( $slots[ $slot_key ]['tablet'] ); ?> /> Tablet</label>
								<label><input type="checkbox" name="tn_ads_manager_slots[<?php echo esc_attr( $slot_key ); ?>][mobile]" value="1" <?php checked( $slots[ $slot_key ]['mobile'] ); ?> /> Mobile</label>
							</p>
							<p>
								<select name="tn_ads_manager_slots[<?php echo esc_attr( $slot_key ); ?>][behavior]">
									<?php foreach ( array( 'responsive', 'fixed', 'sticky', 'inline' ) as $behavior ) : ?>
										<option value="<?php echo esc_attr( $behavior ); ?>" <?php selected( $slots[ $slot_key ]['behavior'], $behavior ); ?>><?php echo esc_html( ucfirst( $behavior ) ); ?></option>
									<?php endforeach; ?>
								</select>
								<?php if ( 'between_paragraphs' === $slot_key ) : ?>
									<input type="number" min="1" style="width:72px" name="tn_ads_manager_slots[<?php echo esc_attr( $slot_key ); ?>][paragraph]" value="<?php echo esc_attr( $slots[ $slot_key ]['paragraph'] ); ?>" />
								<?php endif; ?>
							</p>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * Render slot by id.
 *
 * @param string $slot slot key.
 * @param string $class optional class.
 * @return string
 */
function tiempo_noticias_render_ad_slot( $slot, $class = '' ) {
	$slots = tiempo_noticias_get_ads_slots_options();
	if ( empty( $slots[ $slot ] ) || empty( $slots[ $slot ]['enabled'] ) ) {
		return '';
	}

	$config = $slots[ $slot ];
	$code   = trim( $config['code'] );
	if ( '' === $code ) {
		return '';
	}

	$classes = array( 'tn-ad-slot', 'tn-ad-slot--' . sanitize_html_class( $slot ), 'tn-ad--' . sanitize_html_class( $config['behavior'] ) );
	if ( ! empty( $class ) ) {
		$classes[] = $class;
	}
	if ( empty( $config['desktop'] ) ) {
		$classes[] = 'tn-hide-desktop';
	}
	if ( empty( $config['tablet'] ) ) {
		$classes[] = 'tn-hide-tablet';
	}
	if ( empty( $config['mobile'] ) ) {
		$classes[] = 'tn-hide-mobile';
	}

	return '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" data-slot="' . esc_attr( $slot ) . '">' . $code . '</div>';
}

/**
 * Slot shortcode.
 *
 * @param array $atts attrs.
 * @return string
 */
function tiempo_noticias_ad_slot_shortcode( $atts ) {
	$atts = shortcode_atts( array( 'slot' => 'in_content', 'class' => '' ), $atts, 'tiempo_ad' );
	return tiempo_noticias_render_ad_slot( sanitize_key( $atts['slot'] ), sanitize_html_class( $atts['class'] ) );
}
add_shortcode( 'tiempo_ad', 'tiempo_noticias_ad_slot_shortcode' );

/**
 * Insert ad between paragraphs based on slot config.
 *
 * @param string $content content.
 * @return string
 */
function tiempo_noticias_insert_between_paragraph_ads( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	$slots = tiempo_noticias_get_ads_slots_options();
	if ( empty( $slots['between_paragraphs']['enabled'] ) ) {
		return $content;
	}

	$ad_html = tiempo_noticias_render_ad_slot( 'between_paragraphs' );
	if ( '' === $ad_html ) {
		return $content;
	}

	$target_paragraph = max( 1, absint( $slots['between_paragraphs']['paragraph'] ) );
	$paragraphs       = explode( '</p>', $content );

	if ( count( $paragraphs ) >= $target_paragraph ) {
		$paragraphs[ $target_paragraph - 1 ] .= '</p>' . $ad_html;
		return implode( '</p>', $paragraphs );
	}

	return $content . $ad_html;
}
add_filter( 'the_content', 'tiempo_noticias_insert_between_paragraph_ads', 19 );
