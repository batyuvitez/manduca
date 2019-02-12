<?php

 
/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *  Copyright (C) 2015-2019  Zsolt Edelényi (ezs@web25.hu)

    Manduca is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    in /assets/docs/licence.txt.  If not, see <https://www.gnu.org/licenses/>.
*/


 class Browser_Type{
  
    public function __construct() {
        $this->user_agent = $_SERVER['HTTP_USER_AGENT'] ;
    }
  
    public function get_classes(){
        $classes = $this->get_browser_type();
        $classes .= $this->get_operating_system();
        return $classes;
    }
    
  
	/**
    * Get informations about user agent. 
    *
    * @since 18.6
    *@see: http://www.wpbeginner.com/wp-themes/how-to-add-user-browser-and-os-classes-in-wordpress-body-class/
    * 
    *@return string : browser type
    *
    */

	public function get_browser_type() {
            
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
         
    /*
     * Find the operating system of the session user
     *
     *@since 19.2
     *@see: https://stackoverflow.com/questions/18070154/get-operating-system-info
     *
     *@return string shortname of OS type. 
     */
         
    public function get_operating_system() { 
        
        $os_platform  = "Unknown OS Platform";    
        $os_array     = array(
                              '/windows nt 10/i'      =>  'Win10',
                              '/windows nt 6.3/i'     =>  'Win8',
                              '/windows nt 6.2/i'     =>  'Win8',
                              '/windows nt 6.1/i'     =>  'Win7',
                              '/windows nt 6.0/i'     =>  'WinVista',
                              '/windows nt 5.2/i'     =>  'WinServer',
                              '/windows nt 5.1/i'     =>  'WinXP',
                              '/windows xp/i'         =>  'WinXP',
                              '/windows nt 5.0/i'     =>  'Win2000',
                              '/windows me/i'         =>  'WinME',
                              '/win98/i'              =>  'Win98',
                              '/win95/i'              =>  'Win95',
                              '/win16/i'              =>  'Win3',
                              '/macintosh|mac os x/i' =>  'MacOSX',
                              '/mac_powerpc/i'        =>  'MacOS9',
                              '/linux/i'              =>  'Linux',
                              '/ubuntu/i'             =>  'Ubuntu',
                              '/iphone/i'             =>  'iPhone',
                              '/ipod/i'               =>  'iPod',
                              '/ipad/i'               =>  'iPad',
                              '/android/i'            =>  'Android',
                              '/blackberry/i'         =>  'BlackBerry',
                              '/webos/i'              =>  'Mobile'
                        );
    
        foreach ( $os_array as $regex => $value)
            if ( preg_match($regex, $user_agent))
                $os_platform = $value;
    
        return $os_platform;
    }
 }