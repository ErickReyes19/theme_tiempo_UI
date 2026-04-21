<?php
/**
 * Trending section pattern.
 *
 * @package TiempoNoticias
 */

return array(
	'title'      => __( 'Sección Tendencias', 'tiempo-noticias' ),
	'categories' => array( 'query' ),
	'content'    => '<!-- wp:group {"align":"wide","style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} -->
<div class="wp-block-group alignwide"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Tendencias</h3><!-- /wp:heading --><!-- wp:query {"query":{"perPage":4,"postType":"post","order":"desc","orderBy":"comment_count"}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":4}} --><!-- wp:template-part {"slug":"post-card","theme":"tiempo-noticias"} /--><!-- /wp:post-template --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->',
);
