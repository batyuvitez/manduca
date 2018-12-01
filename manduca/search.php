<?php
/**
 * Display search result page. 
 * 
 * @ Theme: Manduca - focus on accessibility
 * @ Since 1.0
 **/
?>

<?php get_header(); ?>

		<?php if ( have_posts() ) : ?>

			<header class="entry-header no-thumbnail">
				<h1>
				<?php
				 global $wp_query;
                    /* translators: %1$s is the number of results found, %2$s is the search term */
                    printf( __( 'Found %1$s search result for keyword: %2$s', 'manduca' ), 
                            number_format_i18n( $wp_query->found_posts ), 
                            '<span class="twocolumns">' . get_search_query() . '</span>' 
                    );
				?>
				</h1>
			</header>

			
			<?php get_template_part( 'template-parts/posts/content', 'search' ); ?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">
					<h1><?php _e( 'No matching result found.', 'manduca' ) ?></h1>
				</header>

				<div class="entry-content">
					<?php get_search_form(); ?>
				</div>
			</article>

		<?php endif; ?>

<?php get_footer(); ?>