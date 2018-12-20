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