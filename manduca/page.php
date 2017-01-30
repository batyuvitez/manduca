<?php
/**
 * Manduca
 *
 * @since 1.0 */


get_header(); ?>

	<div id="primary" class="site-content">
		<main id="content">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/pages/content', 'page' ); ?>
				
			<?php endwhile; // end of the loop. ?>

		</main><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>