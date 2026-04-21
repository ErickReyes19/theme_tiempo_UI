<?php
/**
 * Hero home pattern.
 *
 * @package TiempoNoticias
 */

return array(
	'title'       => __( 'Hero Home', 'tiempo-noticias' ),
	'categories'  => array( 'featured' ),
	'blockTypes'  => array( 'core/template-part/front-page' ),
	'content'     => '<!-- wp:group {"align":"wide","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignwide"><!-- wp:group {"className":"tn-section-title","layout":{"type":"flex","justifyContent":"space-between"}} --><div class="wp-block-group tn-section-title"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Portada principal</h3><!-- /wp:heading --><!-- wp:paragraph {"fontSize":"sm"} --><p class="has-sm-font-size">Actualizado minuto a minuto</p><!-- /wp:paragraph --></div><!-- /wp:group --><!-- wp:columns {"verticalAlignment":"top"} -->
<div class="wp-block-columns are-vertically-aligned-top"><!-- wp:column {"width":"65%"} -->
<div class="wp-block-column" style="flex-basis:65%"><!-- wp:query {"query":{"perPage":1,"postType":"post","order":"desc","orderBy":"date"}} -->
<div class="wp-block-query"><!-- wp:post-template --><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"16/9","sizeSlug":"tiempo-hero"} /--><!-- wp:post-terms {"term":"category"} /--><!-- wp:post-title {"isLink":true,"level":2,"fontSize":"3xl"} /--><!-- wp:post-excerpt {"excerptLength":34} /--><!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:column --><!-- wp:column {"width":"35%"} -->
<div class="wp-block-column" style="flex-basis:35%"><!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Titulares clave</h4><!-- /wp:heading --><!-- wp:query {"query":{"perPage":6,"offset":1,"postType":"post","order":"desc","orderBy":"date"}} -->
<div class="wp-block-query"><!-- wp:post-template --><!-- wp:group {"style":{"spacing":{"blockGap":"0.4rem","padding":{"bottom":"var:preset|spacing|30"}},"border":{"bottom":{"color":"var:preset|color|stroke","width":"1px"}}}} --><div class="wp-block-group" style="border-bottom-color:var(--wp--preset--color--stroke);border-bottom-width:1px;padding-bottom:var(--wp--preset--spacing--30)"><!-- wp:post-terms {"term":"category"} /--><!-- wp:post-title {"isLink":true,"level":5} /--><!-- /wp:group --><!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->',
);
