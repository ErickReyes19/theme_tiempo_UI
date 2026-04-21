<?php
/**
 * Trending section pattern.
 *
 * @package TiempoNoticias
 */

return array(
	'title'      => __( 'Sección Tendencias', 'tiempo-noticias' ),
	'categories' => array( 'query' ),
	'content'    => '<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-group"><!-- wp:group {"className":"tn-section-title","layout":{"type":"flex","justifyContent":"space-between"}} --><div class="wp-block-group tn-section-title"><!-- wp:heading {"level":4} --><h4 class="wp-block-heading">Tendencias</h4><!-- /wp:heading --><!-- wp:paragraph {"fontSize":"xs"} --><p class="has-xs-font-size">Lo más leído</p><!-- /wp:paragraph --></div><!-- /wp:group --><!-- wp:query {"query":{"perPage":5,"postType":"post","order":"desc","orderBy":"comment_count"}} -->
<div class="wp-block-query"><!-- wp:post-template --><!-- wp:group {"style":{"spacing":{"blockGap":"0.3rem","padding":{"bottom":"var:preset|spacing|20"}},"border":{"bottom":{"color":"var:preset|color|stroke","width":"1px"}}}} --><div class="wp-block-group" style="border-bottom-color:var(--wp--preset--color--stroke);border-bottom-width:1px;padding-bottom:var(--wp--preset--spacing--20)"><!-- wp:post-title {"isLink":true,"level":6} /--><!-- wp:post-date {"fontSize":"xs"} /--></div><!-- /wp:group --><!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->',
);
