<?php
/**
 * Dynamic template renderer.
 *
 * @package TiempoNoticias
 */

$template_id = (int) get_query_var( 'tn_dynamic_template_id' );
get_header();

if ( $template_id ) {
	$template_post = get_post( $template_id );
	if ( $template_post ) {
		echo '<article class="tn-dynamic-template">';
		echo apply_filters( 'the_content', $template_post->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</article>';
	}
}

get_footer();
