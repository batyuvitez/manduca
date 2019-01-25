<?php
/**
 * Manduca initialization
 * 
 * @ Since 1.0
 **/

/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2018  Zsolt Edelényi (ezs@web25.hu)

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

 
 // Load files
 
 $dirs = array( get_template_directory() .'/inc/',
               'Manduca' => get_template_directory() .'/inc/' ) ;
		
// Open the files which ara not classes. 
$dir 			= get_template_directory() .'/inc/notclasses/' ;
$files 		= scandir( $dir );

//Get rid of points (libraries )
$files 		= array_diff( $files, array('..', '.') ) ;

// Open all files in it
if( !empty ($files ) ) {
	foreach( $files as $file ) {
		if( strpos( $file , '.php' ) !== false ) {
			require_once( $dir .$file );
		}
	}
}
 
// If child_theme exists, it may opened Manduca_Classloader
if( class_exists( 'Manduca_Classloader' ) ) {
	Manduca_Classloader::add_dirs( $dirs );
}
else {
	  require_once( get_template_directory() .'/inc/class-manduca-classloader.php' );
	  $autoload = new Manduca_Classloader( $dirs );		
}

// It is not necessary to open Manduca in child theme, but if it did, not open twice. 
if( !class_exists( 'Manduca' ) ){
	$manduca =  new Manduca_Setup();
	$manduca->init();
}