<?php
/**
 * Template Builder system.
 *
 * @package TiempoNoticias
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Template Builder post type.
 */
function tiempo_noticias_register_template_builder_cpt() {
	register_post_type(
		'tn_template',
		array(
			'labels' => array(
				'name'          => __( 'Template Builder', 'tiempo-noticias' ),
				'singular_name' => __( 'Template', 'tiempo-noticias' ),
				'add_new_item'  => __( 'Crear template', 'tiempo-noticias' ),
				'edit_item'     => __( 'Editar template', 'tiempo-noticias' ),
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => 'dashicons-layout',
			'supports'            => array( 'title', 'editor', 'revisions' ),
			'show_in_rest'        => true,
			'capability_type'     => 'post',
			'publicly_queryable'  => false,
		)
	);
}
add_action( 'init', 'tiempo_noticias_register_template_builder_cpt' );

/**
 * Register template meta boxes.
 */
function tiempo_noticias_template_builder_meta_boxes() {
	add_meta_box(
		'tn-template-rules',
		__( 'Reglas de asignación', 'tiempo-noticias' ),
		'tiempo_noticias_template_rules_metabox',
		'tn_template',
		'side'
	);
}
add_action( 'add_meta_boxes', 'tiempo_noticias_template_builder_meta_boxes' );

/**
 * Rules metabox.
 *
 * @param WP_Post $post Template post.
 */
function tiempo_noticias_template_rules_metabox( $post ) {
	$view_type  = get_post_meta( $post->ID, '_tn_view_type', true );
	$target_pt  = get_post_meta( $post->ID, '_tn_target_post_type', true );
	$target_cat = (int) get_post_meta( $post->ID, '_tn_target_category', true );
	$target_tag = (int) get_post_meta( $post->ID, '_tn_target_tag', true );
	$priority   = (int) get_post_meta( $post->ID, '_tn_priority', true );

	wp_nonce_field( 'tn_template_rules', 'tn_template_rules_nonce' );
	?>
	<p>
		<label for="tn-view-type"><strong><?php esc_html_e( 'Vista', 'tiempo-noticias' ); ?></strong></label>
		<select id="tn-view-type" name="tn_view_type" class="widefat">
			<?php
			$views = array(
				'front_page' => __( 'Homepage', 'tiempo-noticias' ),
				'home'       => __( 'Blog / Home posts', 'tiempo-noticias' ),
				'single'     => __( 'Single Post', 'tiempo-noticias' ),
				'page'       => __( 'Page', 'tiempo-noticias' ),
				'category'   => __( 'Category archive', 'tiempo-noticias' ),
				'tag'        => __( 'Tag archive', 'tiempo-noticias' ),
				'archive'    => __( 'General archive', 'tiempo-noticias' ),
				'search'     => __( 'Search', 'tiempo-noticias' ),
				'404'        => __( '404', 'tiempo-noticias' ),
			);
			foreach ( $views as $value => $label ) {
				printf( '<option value="%1$s" %2$s>%3$s</option>', esc_attr( $value ), selected( $view_type, $value, false ), esc_html( $label ) );
			}
			?>
		</select>
	</p>
	<p>
		<label for="tn-target-post-type"><strong><?php esc_html_e( 'Post type objetivo (opcional)', 'tiempo-noticias' ); ?></strong></label>
		<input id="tn-target-post-type" name="tn_target_post_type" value="<?php echo esc_attr( $target_pt ); ?>" class="widefat" placeholder="post" />
	</p>
	<p>
		<label for="tn-target-category"><strong><?php esc_html_e( 'Categoría objetivo (opcional)', 'tiempo-noticias' ); ?></strong></label>
		<?php wp_dropdown_categories( array( 'show_option_all' => __( 'Cualquiera', 'tiempo-noticias' ), 'name' => 'tn_target_category', 'selected' => $target_cat, 'id' => 'tn-target-category', 'hide_empty' => false ) ); ?>
	</p>
	<p>
		<label for="tn-target-tag"><strong><?php esc_html_e( 'Tag objetivo (opcional)', 'tiempo-noticias' ); ?></strong></label>
		<?php wp_dropdown_categories( array( 'taxonomy' => 'post_tag', 'show_option_all' => __( 'Cualquiera', 'tiempo-noticias' ), 'name' => 'tn_target_tag', 'selected' => $target_tag, 'id' => 'tn-target-tag', 'hide_empty' => false ) ); ?>
	</p>
	<p>
		<label for="tn-priority"><strong><?php esc_html_e( 'Prioridad', 'tiempo-noticias' ); ?></strong></label>
		<input id="tn-priority" type="number" min="0" name="tn_priority" value="<?php echo esc_attr( $priority ); ?>" class="widefat" />
		<small><?php esc_html_e( 'Mayor número = mayor prioridad.', 'tiempo-noticias' ); ?></small>
	</p>
	<?php
}

/**
 * Save template rules.
 *
 * @param int $post_id Post ID.
 */
function tiempo_noticias_save_template_rules( $post_id ) {
	if ( ! isset( $_POST['tn_template_rules_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tn_template_rules_nonce'] ) ), 'tn_template_rules' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, '_tn_view_type', sanitize_key( wp_unslash( $_POST['tn_view_type'] ?? '' ) ) );
	update_post_meta( $post_id, '_tn_target_post_type', sanitize_key( wp_unslash( $_POST['tn_target_post_type'] ?? '' ) ) );
	update_post_meta( $post_id, '_tn_target_category', absint( $_POST['tn_target_category'] ?? 0 ) );
	update_post_meta( $post_id, '_tn_target_tag', absint( $_POST['tn_target_tag'] ?? 0 ) );
	update_post_meta( $post_id, '_tn_priority', absint( $_POST['tn_priority'] ?? 0 ) );
}
add_action( 'save_post_tn_template', 'tiempo_noticias_save_template_rules' );

/**
 * Find matching dynamic template.
 *
 * @return WP_Post|null
 */
function tiempo_noticias_get_matching_template() {
	$templates = get_posts(
		array(
			'post_type'      => 'tn_template',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'meta_value_num',
			'meta_key'       => '_tn_priority',
			'order'          => 'DESC',
		)
	);

	foreach ( $templates as $template ) {
		$view_type  = get_post_meta( $template->ID, '_tn_view_type', true );
		$target_pt  = get_post_meta( $template->ID, '_tn_target_post_type', true );
		$target_cat = (int) get_post_meta( $template->ID, '_tn_target_category', true );
		$target_tag = (int) get_post_meta( $template->ID, '_tn_target_tag', true );

		$matches_view = (
			( 'front_page' === $view_type && is_front_page() ) ||
			( 'home' === $view_type && is_home() ) ||
			( 'single' === $view_type && is_single() ) ||
			( 'page' === $view_type && is_page() ) ||
			( 'category' === $view_type && is_category() ) ||
			( 'tag' === $view_type && is_tag() ) ||
			( 'archive' === $view_type && is_archive() && ! is_category() && ! is_tag() ) ||
			( 'search' === $view_type && is_search() ) ||
			( '404' === $view_type && is_404() )
		);

		if ( ! $matches_view ) {
			continue;
		}

		if ( $target_pt && is_singular() && $target_pt !== get_post_type() ) {
			continue;
		}

		if ( $target_cat && ( ! is_category( $target_cat ) && ! has_category( $target_cat ) ) ) {
			continue;
		}

		if ( $target_tag && ( ! is_tag( $target_tag ) && ! has_tag( $target_tag ) ) ) {
			continue;
		}

		return $template;
	}

	return null;
}

/**
 * Route output to dynamic template renderer.
 *
 * @param string $template Current template path.
 * @return string
 */
function tiempo_noticias_template_include_router( $template ) {
	$dynamic_template = tiempo_noticias_get_matching_template();

	if ( $dynamic_template ) {
		set_query_var( 'tn_dynamic_template_id', $dynamic_template->ID );
		$render_template = locate_template( 'template-parts/dynamic-template-render.php' );
		if ( $render_template ) {
			return $render_template;
		}
	}

	return $template;
}
add_filter( 'template_include', 'tiempo_noticias_template_include_router', 99 );

/**
 * Add duplicate row action.
 *
 * @param array   $actions Actions.
 * @param WP_Post $post Post object.
 * @return array
 */
function tiempo_noticias_template_builder_duplicate_action( $actions, $post ) {
	if ( 'tn_template' !== $post->post_type ) {
		return $actions;
	}

	$url = wp_nonce_url( admin_url( 'admin.php?action=tn_duplicate_template&post=' . $post->ID ), 'tn_duplicate_template_' . $post->ID );
	$actions['tn_duplicate'] = '<a href="' . esc_url( $url ) . '">' . esc_html__( 'Duplicar', 'tiempo-noticias' ) . '</a>';
	return $actions;
}
add_filter( 'post_row_actions', 'tiempo_noticias_template_builder_duplicate_action', 10, 2 );

/**
 * Duplicate template action callback.
 */
function tiempo_noticias_handle_duplicate_template() {
	if ( ! current_user_can( 'edit_posts' ) ) {
		wp_die( esc_html__( 'No autorizado.', 'tiempo-noticias' ) );
	}

	$post_id = absint( $_GET['post'] ?? 0 );
	if ( ! $post_id || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ?? '' ) ), 'tn_duplicate_template_' . $post_id ) ) {
		wp_die( esc_html__( 'Solicitud inválida.', 'tiempo-noticias' ) );
	}

	$original = get_post( $post_id );
	if ( ! $original || 'tn_template' !== $original->post_type ) {
		wp_die( esc_html__( 'Template no encontrado.', 'tiempo-noticias' ) );
	}

	$new_id = wp_insert_post(
		array(
			'post_type'    => 'tn_template',
			'post_status'  => 'draft',
			'post_title'   => $original->post_title . ' (Copia)',
			'post_content' => $original->post_content,
		)
	);

	if ( $new_id ) {
		$meta_keys = array( '_tn_view_type', '_tn_target_post_type', '_tn_target_category', '_tn_target_tag', '_tn_priority' );
		foreach ( $meta_keys as $meta_key ) {
			update_post_meta( $new_id, $meta_key, get_post_meta( $post_id, $meta_key, true ) );
		}
	}

	wp_safe_redirect( admin_url( 'post.php?post=' . $new_id . '&action=edit' ) );
	exit;
}
add_action( 'admin_action_tn_duplicate_template', 'tiempo_noticias_handle_duplicate_template' );
