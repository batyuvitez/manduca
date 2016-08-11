<?php
/**
 * Manduca
 *
 * @since 1.0 */

get_header(); ?>


	<section id="primary" class="site-content">
		<main id="content" >

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php bloginfo( 'description' ); ?></h1>
			</header>

			<?php manduca_display_excerpt() ?>
			

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h2 class="entry-title"><?php _e( 'No matching result found.', 'manduca' ) ?></h2>
				</header>

				<div class="entry-content">
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		<?php endif; ?>

		</main><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>