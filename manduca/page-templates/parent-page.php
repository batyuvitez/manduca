<?php
/**
 * Template Name: Parent of pages template
 *
 * Display subpages should be use in parent pages
 *
 * @ Theme: Manduca - focus on accessibility
 *
 * @since 17.1
 * */

 
get_header(); ?>

	<div id="primary" class="site-content">
		<main id="content">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/pages/content', 'parentpage' ); ?>
				<?php comments_template(); ?>
			<?php endwhile; // end of the loop. ?>

		</main><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
