<?php
/**
 * Manduca accessible theme motor
 * 
 * @ Theme: Manduca - focus on accessibility
 * @ Since 1.0
 **/
 
 // Load files
 
 $dirs = array( get_template_directory() .'/inc/' ) ;
		
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