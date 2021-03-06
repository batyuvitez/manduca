<?php
/**
 * Manduca initialization
 * 
 **/

/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	   Copyright (C) 2015-2021  Zsolt Edelényi (ezs@web25.hu)

    Source code is available at https://github.com/batyuvitez/manduca
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

 
 $dirs = array( get_template_directory() .'/inc/',
               'Manduca' => get_template_directory() .'/inc/',
               'Manduca\helpers' => get_template_directory() .'/inc/helpers') ;
  

 // If child_theme exists, it may opened Manduca_Classloader
if( class_exists( 'Manduca_Classloader' ) )     
    Manduca_Classloader::add_dirs( $dirs );
else
{	  
   require_once( get_template_directory() .'/inc/class-manduca-classloader.php' );  
   new Manduca_Classloader( $dirs );		
}
( new Manduca_Setup )-> init();
