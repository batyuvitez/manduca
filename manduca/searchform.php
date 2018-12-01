<?php
/**
 * Template for displaying search forms in Manduca
 *
 * Theme: Manduca - focus on accessibility 
 * @ Since 16.9
 */
?>

<form role="search" method="get" class="widget-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<label class="screen-reader-text" for="ws" ><?php _e( 'Search', 'manduca' ) ?></label>
		<input type="text" placeholder="<?php echo esc_attr_e( 'Search', 'manduca' ) ?>" value="<?php echo get_search_query(); ?>" name="ws"  id="ws" />
		<button type="submit" class="search-submit" id="widget-search-submit" aria-label="<?php _e( 'Start search', 'manduca' ) ?>" >
			<span class="screen-reader-text">
				<?php _e( 'Search', 'manduca' ) ?>
			</span>
			
			<?php echo  manduca_get_svg( array( 'icon'=>'search') ) ;?>
			
		</button>
	</div>
</form>
			