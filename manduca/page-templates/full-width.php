<?php
/**
 * Template Name: Full-width Page Template
 *
 * @since Manduca 1.6.8 */


get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'template-parts/pages/content', 'page' ); ?>
				<?php comments_template(); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>