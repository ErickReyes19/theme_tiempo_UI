<?php get_header(); ?>
<header><h1><?php printf( esc_html__( 'Resultados para: %s', 'tiempo-noticias' ), esc_html( get_search_query() ) ); ?></h1></header>
<section class="tn-grid tn-grid--archive">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/content', 'card' ); ?>
	<?php endwhile; else : get_template_part( 'template-parts/content', 'none' ); endif; ?>
</section>
<?php the_posts_pagination(); ?>
<?php get_footer(); ?>
