<?php
/**
 * Manduca
 *
 * @since 1.0 */

get_header(); ?>
	<div id="primary" class="site-content" >
		
		<?php manduca_post_navigation() ?>
		
		<main id="content">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

				<?php manduca_post_navigation() ?>
		
				<?php comments_template(); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>