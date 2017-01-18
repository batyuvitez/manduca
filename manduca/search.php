<?php
/**
 * Manduca
 *
 * @since 1.0 */

get_header(); ?>

	<section id="primary" class="site-content">
		<main id="content">

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

			
			<?php
				global $wp_query;
			
				if ( $wp_query->max_num_pages > 1 ) : ?>
					<nav id="<?php echo esc_attr( $html_id ); ?>" class="navigation" role="navigation">
						<h3 class="assistive-text"><?php _e( 'Post navigation', 'manduca' ); ?></h3>
						<div class="nav-previous"><span class="meta-nav">&larr;</span> <?php next_posts_link( __( 'Older posts', 'manduca' ) ); ?></div>
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'manduca' ) ); ?> <span class="meta-nav"> &rarr;</span></div>
					</nav><!-- .navigation -->
				
				<?php endif;
			
				manduca_display_excerpt() ?>

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