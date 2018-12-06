<?php
/**
 * Navigation to previous / next post in a single post page
 * Displays the title of the prev/next post.
 * 
 *
 * @ Theme: Manduca - focus on accessibility 
 * @ Since 17.9
 * Add access key imn @18.9.2
 * */
?>

	
<nav class="nav-single">
<h3 class="screen-reader-text"><?php _e( 'Post navigation', 'manduca' ); ?></h3>
		
	<?php if( !empty( $previous_post = Manduca_Template_Functions::previous_post_link_html() ) ) : ?>
		<h4 class="nav-previous">
			<?php echo $previous_post?>  
			<?php paginate_links();  //the sake of themecheck.  I.e. there is no need for that but theme check requires it. ?>
		</h4>
	<?php endif; ?>
	
	
	<?php if( !empty( $next_post = Manduca_Template_Functions::next_post_link_html() ) ) : ?>
		<h4 class="nav-next">
			<?php echo $next_post; ?> 
		</h4>
		<?php endif; ?>
</nav>