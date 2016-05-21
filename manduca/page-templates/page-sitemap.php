<?php
/**
 * Template Name: Sitemap Page Template
 *
 * @since Manduca 1.8.5 */


get_header(); ?>

	<div id="primary" class="site-content entry-content">
		<div id="content" class="sitemap" role="main">

				<?php get_template_part( '/sitemap'); ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>