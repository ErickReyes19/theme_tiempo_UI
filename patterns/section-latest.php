<?php
/**
 * Latest/breaking section.
 *
 * @package TiempoNoticias
 */

return array(
	'title'      => __( 'Sección Última Hora', 'tiempo-noticias' ),
	'categories' => array( 'query' ),
	'content'    => '<!-- wp:group {"align":"wide","className":"tn-breaking-news","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|40","right":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-group alignwide tn-breaking-news has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Última hora</h3><!-- /wp:heading --><!-- wp:query {"query":{"perPage":5,"postType":"post","order":"desc","orderBy":"date"}} -->
<div class="wp-block-query"><!-- wp:post-template --><!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between"},"style":{"border":{"bottom":{"color":"var:preset|color|stroke","width":"1px"}},"spacing":{"padding":{"bottom":"var:preset|spacing|20"}}}} --><div class="wp-block-group" style="border-bottom-color:var(--wp--preset--color--stroke);border-bottom-width:1px;padding-bottom:var(--wp--preset--spacing--20)"><!-- wp:post-title {"isLink":true,"level":5} /--><!-- wp:post-date /--></div><!-- /wp:group --><!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->',
);
