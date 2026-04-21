<?php
/**
 * Post card.
 *
 * @package TiempoNoticias
 */
?>
<article <?php post_class( 'tn-post-card' ); ?>>
	<a href="<?php the_permalink(); ?>" class="tn-post-card__thumb"><?php the_post_thumbnail( 'tiempo-card' ); ?></a>
	<div class="tn-post-card__body">
		<?php echo wp_kses_post( tiempo_noticias_get_category_badge() ); ?>
		<h2 class="tn-post-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		<div class="tn-post-card__meta"><?php echo wp_kses_post( tiempo_noticias_get_post_meta() ); ?></div>
	</div>
</article>
