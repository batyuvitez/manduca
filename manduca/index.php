<?php
/**
 * Index file of Manduca
 *
 * @ Theme: Manduca - focus on accessibility
 * @ Since 1.0
 **/

?>
<?php
 get_header();

	if ( have_posts() ) : 

	// Start the Loop
	while ( have_posts() ) : the_post(); 	
		get_template_part( 'template-parts/posts/content' ); 
	
	endwhile; 

	get_template_part( 'template-parts/posts/navigation' ); 

	else : ?>

			<article id="post-0" class="post no-results not-found">

			<?php if ( current_user_can( 'edit_posts' ) ) :
			?>
				<header class="entry-header">
					<h1><?php _e( 'No post', 'manduca' ) ?></h1>
				</header>

				<div class="entry-content">
					<p><?php printf( __( 'Ready to publish your first post?', 'manduca' ) .'<a href="%s">' .__( 'Get started here!', 'manduca' ) .'</a>', admin_url( 'post-new.php' ) ); ?></p>
				</div>

			<?php else :
				
			?>
				<header>
					<h1><?php _e( 'Nothing found', 'manduca' ) ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Maybe try a search.', 'manduca' ) ?></p>
					<?php get_search_form(); ?>
				</div>
			<?php endif; ?>

			</article>

		<?php endif; // end have_posts() check ?>
		
<?php get_footer(); ?>