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
				<h1 class="archive-title" itemprop="headline"><?php echo single_cat_title( '', false ) ; ?></h1>

			<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>
			</header><!-- .archive-header -->

			<?php manduca_display_in_two_columns() ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>