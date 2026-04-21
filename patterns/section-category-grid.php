<?php
/**
 * Category grid section.
 *
 * @package TiempoNoticias
 */

return array(
	'title'      => __( 'Sección por Categoría', 'tiempo-noticias' ),
	'categories' => array( 'query' ),
	'content'    => '<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"className":"tn-section-title","layout":{"type":"flex","justifyContent":"space-between"}} --><div class="wp-block-group tn-section-title"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Explora más noticias</h3><!-- /wp:heading --><!-- wp:buttons --><div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"accent-2","textColor":"dark","style":{"border":{"radius":"999px"}}} --><div class="wp-block-button"><a class="wp-block-button__link has-dark-color has-accent-2-background-color has-text-color has-background wp-element-button" href="/category">Ver todas las secciones</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group --><!-- wp:query {"query":{"perPage":6,"postType":"post","order":"desc","orderBy":"date"}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} --><!-- wp:template-part {"slug":"post-card","theme":"tiempo-noticias"} /--><!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->',
);
