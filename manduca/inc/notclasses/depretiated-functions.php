<?php
 /*
 * This functions from the older Manduca version is still here
 * to provide backwards compatibility
 *
 * @ Theme: Manduca - focus on accessibility
 * @ Since 17.10.4
 **/

 

 function manduca_get_svg( $args = array() ) {
	 
	  $svg= new SVG_Functions( $args ) ;
	  return $svg->Return_HTML();
	  
 }
 
 /*
  * Since WP 5.2 it needed for backwards compatibility
  * */
 if ( ! function_exists( 'wp_body_open' ) ) {
    function wp_body_open() {
        do_action( 'wp_body_open' );
    }
}