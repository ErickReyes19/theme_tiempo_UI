<?php
/**
 * Advertising slots and admin controls.
 *
 * @package TiempoNoticias
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registered slot keys.
 *
 * @return array<string,string>
 */
function tiempo_noticias_ad_slots() {
	return array(
		'header_top_banner' => __( 'Header Top Banner', 'tiempo-noticias' ),
		'below_hero'        => __( 'Below Hero', 'tiempo-noticias' ),
		'sidebar_ad'        => __( 'Sidebar Ad', 'tiempo-noticias' ),
		'in_article_ad'     => __( 'In-Article Ad', 'tiempo-noticias' ),
		'after_first_post'  => __( 'After First Post (Archives)', 'tiempo-noticias' ),
		'footer_banner'     => __( 'Footer Banner', 'tiempo-noticias' ),
	);
}

/**
 * Register ad options.
 */
function tiempo_noticias_register_ad_settings() {
	register_setting( 'reading', 'tiempo_noticias_ads_enabled', array( 'type' => 'boolean', 'sanitize_callback' => 'rest_sanitize_boolean' ) );
	register_setting( 'reading', 'tiempo_noticias_ad_markup', array( 'type' => 'array', 'sanitize_callback' => 'tiempo_noticias_sanitize_ad_markup' ) );

	add_settings_section( 'tiempo_noticias_ads', __( 'Tiempo Noticias Ads', 'tiempo-noticias' ), '__return_false', 'reading' );

	add_settings_field(
		'tiempo_noticias_ads_enabled',
		__( 'Enable ad slots', 'tiempo-noticias' ),
		'tiempo_noticias_ads_enabled_field',
		'reading',
		'tiempo_noticias_ads'
	);

	foreach ( tiempo_noticias_ad_slots() as $slot => $label ) {
		add_settings_field(
			'tiempo_noticias_ad_' . $slot,
			$label,
			'tiempo_noticias_ad_markup_field',
			'reading',
			'tiempo_noticias_ads',
			array( 'slot' => $slot )
		);
	}
}
add_action( 'admin_init', 'tiempo_noticias_register_ad_settings' );

/**
 * Sanitize ad array.
 *
 * @param mixed $value Raw value.
 * @return array
 */
function tiempo_noticias_sanitize_ad_markup( $value ) {
	$sanitized = array();
	$allowed   = wp_kses_allowed_html( 'post' );
	$allowed['script'] = array(
		'type'  => true,
		'async' => true,
		'src'   => true,
		'id'    => true,
	);

	foreach ( tiempo_noticias_ad_slots() as $slot => $label ) {
		if ( isset( $value[ $slot ] ) ) {
			$sanitized[ $slot ] = wp_kses( (string) $value[ $slot ], $allowed );
		}
	}

	return $sanitized;
}

/**
 * Render checkbox.
 */
function tiempo_noticias_ads_enabled_field() {
	$enabled = (bool) get_option( 'tiempo_noticias_ads_enabled', true );
	?>
	<label>
		<input type="checkbox" name="tiempo_noticias_ads_enabled" value="1" <?php checked( $enabled ); ?> />
		<?php esc_html_e( 'Show ad slots across theme templates', 'tiempo-noticias' ); ?>
	</label>
	<?php
}

/**
 * Render textarea.
 *
 * @param array $args Field args.
 */
function tiempo_noticias_ad_markup_field( $args ) {
	$slot   = $args['slot'];
	$values = get_option( 'tiempo_noticias_ad_markup', array() );
	$value  = isset( $values[ $slot ] ) ? $values[ $slot ] : '';
	?>
	<textarea name="tiempo_noticias_ad_markup[<?php echo esc_attr( $slot ); ?>]" rows="4" cols="60" class="large-text code"><?php echo esc_textarea( $value ); ?></textarea>
	<p class="description"><?php esc_html_e( 'Paste Google Ad Manager snippet or custom HTML for this slot.', 'tiempo-noticias' ); ?></p>
	<?php
}

/**
 * Print ad slot content.
 *
 * @param string $slot Slot key.
 * @param string $extra_class Additional class.
 * @return string
 */
function tiempo_noticias_render_ad_slot( $slot, $extra_class = '' ) {
	if ( ! get_option( 'tiempo_noticias_ads_enabled', true ) ) {
		return '';
	}

	$slots = get_option( 'tiempo_noticias_ad_markup', array() );
	$html  = isset( $slots[ $slot ] ) ? $slots[ $slot ] : '';
	$class = trim( 'tn-ad-slot tn-ad-slot--' . sanitize_html_class( $slot ) . ' ' . $extra_class );

	if ( ! empty( $html ) ) {
		return '<div class="' . esc_attr( $class ) . '" data-slot="' . esc_attr( $slot ) . '">' . $html . '</div>';
	}

	return '<div class="' . esc_attr( $class ) . '" data-slot="' . esc_attr( $slot ) . '"><small>' . esc_html( strtoupper( str_replace( '_', ' ', $slot ) ) ) . '</small></div>';
}

/**
 * Shortcode for ad slots.
 *
 * @param array $atts Shortcode atts.
 * @return string
 */
function tiempo_noticias_ad_slot_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'slot'  => 'below_hero',
			'class' => '',
		),
		$atts,
		'tiempo_ad'
	);

	return tiempo_noticias_render_ad_slot( $atts['slot'], $atts['class'] );
}
add_shortcode( 'tiempo_ad', 'tiempo_noticias_ad_slot_shortcode' );

/**
 * Add in-article ad after second paragraph.
 *
 * @param string $content Post content.
 * @return string
 */
function tiempo_noticias_insert_in_article_ad( $content ) {
	if ( ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	$ad_html = tiempo_noticias_render_ad_slot( 'in_article_ad', 'alignwide' );
	if ( '' === $ad_html ) {
		return $content;
	}

	$paragraphs = explode( '</p>', $content );
	if ( count( $paragraphs ) > 2 ) {
		$paragraphs[1] .= '</p>' . $ad_html;
		return implode( '</p>', $paragraphs );
	}

	return $content . $ad_html;
}
add_filter( 'the_content', 'tiempo_noticias_insert_in_article_ad', 20 );
