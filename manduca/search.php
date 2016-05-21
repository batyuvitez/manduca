<?php
/**
 * Manduca
 *
 * @since 1.0 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
				<?php
				 global $wp_query;
                    /* translators: %1$s is the number of results found, %2$s is the search term */
                    printf( __( 'Found %1$s search result for keyword: %2$s', 'manduca' ), 
                            number_format_i18n( $wp_query->found_posts ), 
                            '<span>' . get_search_query() . '</span>' 
                    );
				?>
				</h1>
			</header>

			<?php manduca_page_navigation(); ?>

			<?php /* Start the Loop */ ?>
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

		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>