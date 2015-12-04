<?php
/**
 * Template Name: Sitemap Page Template
 *
 * @since Manduca 1.8.5 */


get_header(); ?>

	<div id="primary" class="entry-content">
		<div id="content" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

				<?php get_template_part( '/sitemap'); ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>