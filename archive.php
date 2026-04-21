<?php get_header(); ?>
<header><h1><?php the_archive_title(); ?></h1><?php the_archive_description(); ?></header>
<section class="tn-grid tn-grid--archive">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/content', 'card' ); ?>
	<?php endwhile; echo tiempo_noticias_render_ad_slot( 'home_between_blocks' ); else : get_template_part( 'template-parts/content', 'none' ); endif; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</section>
<?php the_posts_pagination(); ?>
<?php get_footer(); ?>
