<?php
/**
 * Post navigation 
 * Navigation to previous / next post in a single post page
 * Displays the title of the prev/next post.
 * 
 *
 * @ Theme: Manduca - focus on accessibility 
 * @ Since 17.9
 * Add access key imn @18.9.2
 * */
?>

<?php
	$previous_post = Manduca_Template_Functions::previous_post_link_html();
	$next_post = Manduca_Template_Functions::next_post_link_html();
?>

<nav class="nav-single" aria-label="<?php _e( 'Post navigation', 'manduca' ); ?>">
	<?php if( !empty ( $previous_post ) ) : ?>
		<div class="nav-previous">
			<?php echo $previous_post;?>  	
		</div>
	<?php endif; ?>
	
	
	<?php if( !empty ( $next_post ) ) : ?>
		<div class="nav-next">
			<?php echo $next_post ?> 
		</div>
		<?php endif; ?>
</nav>