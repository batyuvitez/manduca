<?php
/**
 * Manduca
 *
 * @since 1.0 */

get_header(); ?>
	<div id="primary" class="site-content" >
		<nav class="nav-single">
					<div class="nav-previous">
						<p class="assistive-text"><?php _e( 'Previous post', 'manduca' ) ?></p>
						<?php previous_post_link( '%link', '<i class="fa fa-angle-double-left"></i><span>%title</span>' ); ?>
					</div>
					<div class="nav-next">
						<p class="assistive-text"><?php _e( 'Next post', 'manduca' ) ?></p>
						<?php next_post_link( '%link', '<span>%title</span><i class="fa fa-angle-double-right"></i>' ); ?>
					</div>
			</nav><!-- .nav-single -->
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

				<nav class="nav-single">
					<p class="assistive-text"><?php _e( 'Paging', 'manduca' ) ?></p>
					<div class="nav-previous"><?php previous_post_link( '%link', '<i class="fa fa-angle-double-left"></i><span>%title</span>' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '<span>%title</span><i class="fa fa-angle-double-right"></i>' ); ?></div>
				</nav><!-- .nav-single -->

				<?php comments_template(); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>