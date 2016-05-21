<?php
/**
 * Manduca
 *
 * @since 1.0 */

get_header(); ?>
	<section id="primary" class="site-content">
		<main id="content" role="main">
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content' ); ?>
			<?php endwhile; ?>

			<?php manduca_page_navigation(); ?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">

			<?php if ( current_user_can( 'edit_posts' ) ) :
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'No post', 'manduca' ) ?></h1>
				</header>

				<div class="entry-content">
					<p><?php printf( __( 'Ready to publish your first post?', 'manduca' ) .'<a href="%s">' .__( 'Get started here!', 'manduca' ) .'</a>', admin_url( 'post-new.php' ) ); ?></p>
				</div><!-- .entry-content -->

			<?php else :
				
			?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing found', 'manduca' ) ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Maybe try a search.', 'manduca' ) ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			<?php endif; ?>

			</article><!-- #post-0 -->

		<?php endif; // end have_posts() check ?>
		
		</main><!-- #content -->
		
	</section><!-- #primary .site-content-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>