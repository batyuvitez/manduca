<?php
/**
 * Returns the browser type of user. 
 
 *
 * @Theme: Manduca - focus on accessibility
 * &since 18.6
 *
 * see: http://www.wpbeginner.com/wp-themes/how-to-add-user-browser-and-os-classes-in-wordpress-body-class/
 */

 class Browser_Type{
		 
		  function classes () {
				  $classes = array();
				  global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
				  
				  if( $is_lynx ) $classes[] = 'lynx';
				  elseif( $is_gecko ) $classes[] = 'gecko';
				  elseif( $is_opera ) $classes[] = 'opera';
				  elseif( $is_NS4 ) $classes[] = 'ns4';
				  elseif( $is_safari ) $classes[] = 'safari';
				  elseif( $is_chrome ) $classes[] = 'chrome';
				  elseif( $is_IE ) {
					    $classes[] = 'ie';
					    if( preg_match( '/MSIE ( [0-9]+ )( [a-zA-Z0-9.]+ )/', $_SERVER['HTTP_USER_AGENT'], $browser_version ) )
					    $classes[] = 'ie'.$browser_version[1];
				  }
				  else $classes[] = 'unknown';
				  
				  if( $is_iphone ) $classes[] = 'iphone';
				  
				  if (  stristr( $_SERVER['HTTP_USER_AGENT'],"mac" )  ) {
					     $classes[] = 'osx';
				  }
				  elseif ( stristr(  $_SERVER['HTTP_USER_AGENT'],"linux" )  ) {
					     $classes[] = 'linux';
				  }
				  elseif ( stristr(  $_SERVER['HTTP_USER_AGENT'],"windows" )  ) {
					     $classes[] = 'windows';
				  }
				  
				  return $classes;
		 } 		  
 }