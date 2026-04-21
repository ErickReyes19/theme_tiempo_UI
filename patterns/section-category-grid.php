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
<div class="wp-block-group alignwide"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Cobertura por secciones</h3><!-- /wp:heading --><!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":5} --><h5 class="wp-block-heading">Política</h5><!-- /wp:heading --><!-- wp:query {"query":{"perPage":3,"postType":"post","categoryIds":[1]}} --><div class="wp-block-query"><!-- wp:post-template --><!-- wp:post-title {"isLink":true,"level":6} /--><!-- /wp:post-template --></div><!-- /wp:query --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":5} --><h5 class="wp-block-heading">Economía</h5><!-- /wp:heading --><!-- wp:query {"query":{"perPage":3,"postType":"post","categoryIds":[1]}} --><div class="wp-block-query"><!-- wp:post-template --><!-- wp:post-title {"isLink":true,"level":6} /--><!-- /wp:post-template --></div><!-- /wp:query --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":5} --><h5 class="wp-block-heading">Deportes</h5><!-- /wp:heading --><!-- wp:query {"query":{"perPage":3,"postType":"post","categoryIds":[1]}} --><div class="wp-block-query"><!-- wp:post-template --><!-- wp:post-title {"isLink":true,"level":6} /--><!-- /wp:post-template --></div><!-- /wp:query --></div><!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
);
