<?php
/**
 * Search form in the header. 
 *
 * Theme: Manduca - focus on accessiblilty
 *@ Since 1.0
 **/
?>
<form method="get" id="header-searchform" class="header-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div role="search" >
		<label for="s" ><?php _e( 'Search', 'manduca' ) ?></label>
		<input type="text" placeholder="<?php _e( 'Search', 'manduca' ); ?>" value="<?php echo get_search_query(); ?>" name="s"  id="s" />
	
		<button type="submit" class="search-submit" id="search-submit" aria-label="<?php _e( 'Start search', 'manduca' ) ?>" >
		   <span class="screen-reader-text">
			   <?php _e( 'Search', 'manduca' ) ?>
		   </span>
		   <?php echo  manduca_get_svg( array( 'icon'=>'search') ) ;?>
		</button>
	</div>
</form>