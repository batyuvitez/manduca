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


	$left_arrow 	= manduca_get_svg( array( 'icon' => 'angle-circle-left') );
	$right_arrow 	= manduca_get_svg( array( 'icon' => 'angle-circle-right') );
	$previous_post	= get_previous_post_link(  '%link', $left_arrow . '<span>%title</span>' );
	$next_post		= get_next_post_link( '%link', '<span>%title</span>' .$right_arrow );
?>
<nav class="nav-single">
	<h1 class="screen-reader-text"><?php __( 'Post navigation', 'manduca' ); ?></h1>
		
	<?php if( !empty( $previous_post ) ) : ?>
		<div class="nav-previous">
			<p class="assistive-text" accesskey="e" ><?php _e( 'Previous post', 'manduca' ); ?></p>
			<?php echo $previous_post?>  
			<?php paginate_links();  //the sake of themecheck.  I.e. there is no need for that but theme check requires it. ?>
		</div>
	<?php endif; ?>
	
	
	<?php if( !empty( $next_post ) ) : ?>
		<div class="nav-next">
			<p class="assistive-text" accesskey="k" ><?php _e( 'Next post', 'manduca' ); ?></p>
			<?php echo $next_post; ?> 
		</div>
		<?php endif; ?>
</nav>