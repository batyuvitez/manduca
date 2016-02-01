<?php
/**
 * Manduca
 *
 * @since 1.0 */


if ( !defined( 'ABSPATH' ) ) exit;

?>
	
	
	<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div>
		<label class="screen-reader-text" for="s" ><?php _e( 'Search', 'manduca' ) ?></label>
		<input type="text" placeholder="<?php _e( 'Search', 'manduca' ) ?>" value="<?php echo get_search_query(); ?>" name="s" id="s" />
		<input type="submit" id="searchsubmit" value="&#xf002;" aria-label="<?php _e( 'Start search', 'manduca' ) ?>" />
	</div>
</form>