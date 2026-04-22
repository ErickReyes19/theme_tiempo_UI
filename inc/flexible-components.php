<?php
/**
 * Flexible components: widget areas, widgets and shortcodes.
 *
 * @package TiempoNoticias
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register flexible widget areas.
 */
function tiempo_noticias_register_flexible_sidebars() {
	$areas = array(
		'tn-flex-home-top'    => __( 'Home Flexible - Arriba', 'tiempo-noticias' ),
		'tn-flex-home-middle' => __( 'Home Flexible - Medio', 'tiempo-noticias' ),
		'tn-flex-home-bottom' => __( 'Home Flexible - Abajo', 'tiempo-noticias' ),
		'tn-flex-page-top'    => __( 'Page Flexible - Arriba', 'tiempo-noticias' ),
		'tn-flex-page-middle' => __( 'Page Flexible - Medio', 'tiempo-noticias' ),
		'tn-flex-page-bottom' => __( 'Page Flexible - Abajo', 'tiempo-noticias' ),
	);

	foreach ( $areas as $id => $name ) {
		register_sidebar(
			array(
				'name'          => $name,
				'id'            => $id,
				'description'   => __( 'Zona flexible para colocar widgets de posts, banners o cualquier bloque dinámico.', 'tiempo-noticias' ),
				'before_widget' => '<section id="%1$s" class="widget tn-flex-widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title tn-flex-widget__title">',
				'after_title'   => '</h3>',
			)
		);
	}
}
add_action( 'widgets_init', 'tiempo_noticias_register_flexible_sidebars' );

/**
 * Posts feed widget.
 */
class Tiempo_Noticias_Posts_Widget extends WP_Widget {
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct(
			'tn_posts_widget',
			__( 'TN: Posts por categoría', 'tiempo-noticias' ),
			array( 'description' => __( 'Muestra últimas publicaciones filtrando por categoría o tag.', 'tiempo-noticias' ) )
		);
	}

	/**
	 * Render frontend.
	 *
	 * @param array $args Widget args.
	 * @param array $instance Widget values.
	 */
	public function widget( $args, $instance ) {
		$title       = $instance['title'] ?? '';
		$category_id = absint( $instance['category_id'] ?? 0 );
		$tag_id      = absint( $instance['tag_id'] ?? 0 );
		$posts_count = min( 20, max( 1, absint( $instance['posts_count'] ?? 5 ) ) );

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		$query_args = array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => $posts_count,
			'ignore_sticky_posts' => true,
		);

		if ( $category_id ) {
			$query_args['cat'] = $category_id;
		}

		if ( $tag_id ) {
			$query_args['tag_id'] = $tag_id;
		}

		$posts = new WP_Query( $query_args );
		if ( $posts->have_posts() ) {
			echo '<ul class="tn-flex-post-list">';
			while ( $posts->have_posts() ) {
				$posts->the_post();
				echo '<li class="tn-flex-post-list__item"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></li>';
			}
			echo '</ul>';
			wp_reset_postdata();
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Render admin form.
	 *
	 * @param array $instance values.
	 */
	public function form( $instance ) {
		$title       = $instance['title'] ?? __( 'Últimas publicaciones', 'tiempo-noticias' );
		$category_id = absint( $instance['category_id'] ?? 0 );
		$tag_id      = absint( $instance['tag_id'] ?? 0 );
		$posts_count = min( 20, max( 1, absint( $instance['posts_count'] ?? 5 ) ) );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Título', 'tiempo-noticias' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'category_id' ) ); ?>"><?php esc_html_e( 'Categoría', 'tiempo-noticias' ); ?></label>
			<?php wp_dropdown_categories( array( 'show_option_all' => __( 'Todas', 'tiempo-noticias' ), 'name' => $this->get_field_name( 'category_id' ), 'id' => $this->get_field_id( 'category_id' ), 'selected' => $category_id, 'hide_empty' => false ) ); ?>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'tag_id' ) ); ?>"><?php esc_html_e( 'Tag', 'tiempo-noticias' ); ?></label>
			<?php wp_dropdown_categories( array( 'taxonomy' => 'post_tag', 'show_option_all' => __( 'Todos', 'tiempo-noticias' ), 'name' => $this->get_field_name( 'tag_id' ), 'id' => $this->get_field_id( 'tag_id' ), 'selected' => $tag_id, 'hide_empty' => false ) ); ?>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts_count' ) ); ?>"><?php esc_html_e( 'Cantidad de posts (1-20)', 'tiempo-noticias' ); ?></label>
			<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'posts_count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_count' ) ); ?>" type="number" min="1" max="20" value="<?php echo esc_attr( $posts_count ); ?>" />
		</p>
		<?php
	}

	/**
	 * Save widget values.
	 *
	 * @param array $new_instance values.
	 * @param array $old_instance old values.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		return array(
			'title'       => sanitize_text_field( $new_instance['title'] ?? '' ),
			'category_id' => absint( $new_instance['category_id'] ?? 0 ),
			'tag_id'      => absint( $new_instance['tag_id'] ?? 0 ),
			'posts_count' => min( 20, max( 1, absint( $new_instance['posts_count'] ?? 5 ) ) ),
		);
	}
}

/**
 * Ad widget.
 */
class Tiempo_Noticias_Ad_Widget extends WP_Widget {
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct(
			'tn_ad_widget',
			__( 'TN: Banner / Ads', 'tiempo-noticias' ),
			array( 'description' => __( 'Inserta un slot del Ads Manager o código banner personalizado.', 'tiempo-noticias' ) )
		);
	}

	/**
	 * Render frontend.
	 *
	 * @param array $args args.
	 * @param array $instance values.
	 */
	public function widget( $args, $instance ) {
		$title       = $instance['title'] ?? '';
		$slot        = sanitize_key( $instance['slot'] ?? '' );
		$custom_code = wp_kses_post( $instance['custom_code'] ?? '' );

		echo $args['before_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		if ( $title ) {
			echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		if ( $slot ) {
			echo tiempo_noticias_render_ad_slot( $slot ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} elseif ( $custom_code ) {
			echo '<div class="tn-ad-slot tn-ad-slot--custom">' . $custom_code . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}

		echo $args['after_widget']; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Render admin form.
	 *
	 * @param array $instance values.
	 */
	public function form( $instance ) {
		$title       = $instance['title'] ?? __( 'Publicidad', 'tiempo-noticias' );
		$slot        = sanitize_key( $instance['slot'] ?? 'in_content' );
		$custom_code = $instance['custom_code'] ?? '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Título', 'tiempo-noticias' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'slot' ) ); ?>"><?php esc_html_e( 'Slot Ads Manager', 'tiempo-noticias' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slot' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slot' ) ); ?>">
				<option value=""><?php esc_html_e( 'Sin slot (usar código personalizado)', 'tiempo-noticias' ); ?></option>
				<?php foreach ( tiempo_noticias_ad_slots() as $slot_key => $slot_label ) : ?>
					<option value="<?php echo esc_attr( $slot_key ); ?>" <?php selected( $slot, $slot_key ); ?>><?php echo esc_html( $slot_label ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'custom_code' ) ); ?>"><?php esc_html_e( 'Código banner personalizado (opcional)', 'tiempo-noticias' ); ?></label>
			<textarea class="widefat code" rows="5" id="<?php echo esc_attr( $this->get_field_id( 'custom_code' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'custom_code' ) ); ?>"><?php echo esc_textarea( $custom_code ); ?></textarea>
		</p>
		<?php
	}

	/**
	 * Save widget values.
	 *
	 * @param array $new_instance values.
	 * @param array $old_instance old values.
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		return array(
			'title'       => sanitize_text_field( $new_instance['title'] ?? '' ),
			'slot'        => sanitize_key( $new_instance['slot'] ?? '' ),
			'custom_code' => wp_kses_post( $new_instance['custom_code'] ?? '' ),
		);
	}
}

/**
 * Register widgets.
 */
function tiempo_noticias_register_flexible_widgets() {
	register_widget( 'Tiempo_Noticias_Posts_Widget' );
	register_widget( 'Tiempo_Noticias_Ad_Widget' );
}
add_action( 'widgets_init', 'tiempo_noticias_register_flexible_widgets' );

/**
 * Render a widget area by shortcode to place it anywhere.
 *
 * Usage: [tn_widget_area id="tn-flex-home-top"]
 *
 * @param array $atts attrs.
 * @return string
 */
function tiempo_noticias_widget_area_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'id'    => 'tn-flex-home-top',
			'class' => '',
		),
		$atts,
		'tn_widget_area'
	);

	$sidebar_id = sanitize_key( $atts['id'] );
	$extra      = sanitize_html_class( $atts['class'] );
	if ( ! is_active_sidebar( $sidebar_id ) ) {
		return '';
	}

	ob_start();
	echo '<div class="tn-flex-area ' . esc_attr( $extra ) . '" data-flex-area="' . esc_attr( $sidebar_id ) . '">';
	dynamic_sidebar( $sidebar_id );
	echo '</div>';
	return ob_get_clean();
}
add_shortcode( 'tn_widget_area', 'tiempo_noticias_widget_area_shortcode' );

/**
 * Posts list shortcode.
 *
 * Usage: [tn_posts_list category="politica" posts="5" title="Últimas noticias"]
 *
 * @param array $atts attrs.
 * @return string
 */
function tiempo_noticias_posts_list_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'category' => '',
			'tag'      => '',
			'posts'    => 5,
			'title'    => '',
		),
		$atts,
		'tn_posts_list'
	);

	$posts_count = min( 20, max( 1, absint( $atts['posts'] ) ) );
	$query_args  = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => $posts_count,
		'ignore_sticky_posts' => true,
	);

	if ( $atts['category'] ) {
		if ( is_numeric( $atts['category'] ) ) {
			$query_args['cat'] = absint( $atts['category'] );
		} else {
			$query_args['category_name'] = sanitize_title( $atts['category'] );
		}
	}

	if ( $atts['tag'] ) {
		if ( is_numeric( $atts['tag'] ) ) {
			$query_args['tag_id'] = absint( $atts['tag'] );
		} else {
			$query_args['tag'] = sanitize_title( $atts['tag'] );
		}
	}

	$posts = new WP_Query( $query_args );
	if ( ! $posts->have_posts() ) {
		return '';
	}

	ob_start();
	echo '<section class="tn-shortcode-posts-list">';
	if ( $atts['title'] ) {
		echo '<h3 class="tn-shortcode-posts-list__title">' . esc_html( $atts['title'] ) . '</h3>';
	}
	echo '<ul class="tn-flex-post-list">';
	while ( $posts->have_posts() ) {
		$posts->the_post();
		echo '<li class="tn-flex-post-list__item"><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></li>';
	}
	echo '</ul></section>';
	wp_reset_postdata();

	return ob_get_clean();
}
add_shortcode( 'tn_posts_list', 'tiempo_noticias_posts_list_shortcode' );

/**
 * Admin helper page to document flexible components.
 */
function tiempo_noticias_register_flexible_components_page() {
	add_theme_page(
		__( 'Componentes Flexibles', 'tiempo-noticias' ),
		__( 'Componentes Flexibles', 'tiempo-noticias' ),
		'manage_options',
		'tn-flex-components',
		'tiempo_noticias_flexible_components_page'
	);
}
add_action( 'admin_menu', 'tiempo_noticias_register_flexible_components_page' );

/**
 * Render helper page.
 */
function tiempo_noticias_flexible_components_page() {
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Componentes Flexibles', 'tiempo-noticias' ); ?></h1>
		<p><?php esc_html_e( 'Ahora puedes decidir en qué parte de la página se muestran tus módulos usando Widgets + Shortcodes.', 'tiempo-noticias' ); ?></p>
		<ol>
			<li><?php esc_html_e( 'Ve a Apariencia > Widgets y configura módulos en cualquiera de las zonas "Flexible".', 'tiempo-noticias' ); ?></li>
			<li><?php esc_html_e( 'En el editor de páginas, agrega un bloque "Shortcode" y coloca una zona donde quieras.', 'tiempo-noticias' ); ?></li>
			<li><?php esc_html_e( 'Para posts por categoría/tag, usa el shortcode de lista de posts.', 'tiempo-noticias' ); ?></li>
		</ol>
		<h2><?php esc_html_e( 'Shortcodes disponibles', 'tiempo-noticias' ); ?></h2>
		<table class="widefat striped">
			<thead><tr><th><?php esc_html_e( 'Shortcode', 'tiempo-noticias' ); ?></th><th><?php esc_html_e( 'Ejemplo', 'tiempo-noticias' ); ?></th></tr></thead>
			<tbody>
			<tr>
				<td><code>[tn_widget_area id="tn-flex-home-top"]</code></td>
				<td><?php esc_html_e( 'Pinta una zona de widgets donde la insertes.', 'tiempo-noticias' ); ?></td>
			</tr>
			<tr>
				<td><code>[tn_posts_list category="deportes" posts="10" title="Deportes"]</code></td>
				<td><?php esc_html_e( 'Lista últimas publicaciones de una categoría o tag.', 'tiempo-noticias' ); ?></td>
			</tr>
			<tr>
				<td><code>[tiempo_ad slot="in_content"]</code></td>
				<td><?php esc_html_e( 'Inserta un slot que hayas configurado en Ads Manager.', 'tiempo-noticias' ); ?></td>
			</tr>
			</tbody>
		</table>
	</div>
	<?php
}
