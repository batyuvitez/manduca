<?php
/**
 * Manduca
 *
 * @since 1.0 */

get_header(); ?>
	<section id="primary" class="site-content">
		<div id="content" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title" itemprop="headline" ><span><?php echo single_cat_title( '', false ); ?></span></h1>


			<?php
				$term_description = category_description();
				if ( ! empty( $term_description ) ) {
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
				} ?>
			</header><!-- .archive-header -->
			
			<?php manduca_display_in_exerpt() ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>