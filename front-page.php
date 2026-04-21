<?php get_header(); ?>
<section class="tn-home-hero">
	<?php echo do_shortcode( '[tiempo_breaking limit="6"]' ); ?>
	<?php echo tiempo_noticias_render_ad_slot( 'home_between_blocks' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</section>
<section class="tn-grid tn-grid--home">
	<?php $q = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 8 ) ); ?>
	<?php if ( $q->have_posts() ) : while ( $q->have_posts() ) : $q->the_post(); ?>
		<?php get_template_part( 'template-parts/content', 'card' ); ?>
	<?php endwhile; wp_reset_postdata(); endif; ?>
</section>
<?php get_footer(); ?>
