<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<article <?php post_class( 'tn-single' ); ?>>
	<?php echo tiempo_noticias_render_ad_slot( 'before_title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<h1><?php the_title(); ?></h1>
	<?php echo tiempo_noticias_render_ad_slot( 'after_title' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div class="tn-post-card__meta"><?php echo wp_kses_post( tiempo_noticias_get_post_meta() ); ?></div>
	<?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'tiempo-hero' ); } ?>
	<?php echo tiempo_noticias_render_ad_slot( 'before_content' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<div class="tn-single__content"><?php the_content(); ?></div>
	<?php echo tiempo_noticias_render_ad_slot( 'in_content' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php echo tiempo_noticias_render_ad_slot( 'after_content' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	<?php echo do_shortcode( '[tiempo_related count="3"]' ); ?>
</article>
<aside class="tn-sidebar"><?php dynamic_sidebar( 'sidebar-1' ); ?><?php echo tiempo_noticias_render_ad_slot( 'sidebar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></aside>
<?php endwhile; endif; ?>
<?php get_footer(); ?>
