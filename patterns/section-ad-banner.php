<?php
/**
 * Ad banner section.
 *
 * @package TiempoNoticias
 */

return array(
	'title'      => __( 'Banner de Publicidad', 'tiempo-noticias' ),
	'categories' => array( 'banner' ),
	'content'    => '<!-- wp:group {"align":"wide"} -->
<div class="wp-block-group alignwide"><!-- wp:shortcode -->[tiempo_ad slot="below_hero"]<!-- /wp:shortcode --></div>
<!-- /wp:group -->',
);
