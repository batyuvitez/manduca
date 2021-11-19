<?php
/*
 * This is the main class of the theme
 *
 * Theme Execution begins here:
 *  -add static controller function
 * - autoload all files,
 * - Initiate Manduca functions
 *
 **/

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2021  Zsolt Edelényi (ezs@web25.hu)

    This program is free software: you can redistribute it and/or modify
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


class Manduca_Setup {
		
		
	public function init() {
		
		new \Manduca\filters\Controller;
		new \Manduca\Debug_Mode;
		new \Manduca\Enqueue;
		
	
		// Open the files which ara not classes.
		$this->load_notclasses();
		
		//scale oEmbed code to a specific width, and insert large images without breaking the main content area. 
		if ( ! isset( $content_width ) ) {
			$content_width = 625;
		}
		
		// Register the themes main parameters
		new \Manduca\Theme_Support;
		new \Manduca\Images;
		new \Manduca\Register_Sidebar;		
		
		// Add childthemes' icons to global
		(new \Manduca\Define_Globals ) -> load_svg_to_global();
				
		new Manduca\widgets\Controller;
		
		new Manduca\customizer\Controller;
			
		
		// Functions of admin size
		if ( is_admin() ){
			
			// Add tiny MCE functions and stylesheets
			$tinimce = new Tiny_Mce;
			$tinimce->add_hooks_to_wp();
		}
		
		else {
			// Add accessible more-links Need svg to be loaded. 
			$more_links = new Manduca\accessibility\More_Links;
		
			// Remove gallery inline style
			add_filter( 'use_default_gallery_style', '__return_false' );
		
			
			// Correct headings 2-5 on archive pages
			new Manduca\Correct_Headings;
			
			// add alt tag to avatar
			new \Manduca\Avatar_Alt_Text;
			
			// Add homepage when listing page anywhere (e.g. in menu or widget )
			add_filter( 'wp_page_menu_args', array( $this, 'add_home_to_page_menu' ) );
			
			//add aria-current="page to the current menu item. 
			new Accessible_Menu;
			
			new Search_Functions;
			
		}	
	}
	
	

	
	public function add_home_to_page_menu( $args ) {
		if ( ! isset( $args['show_home'] ) ) {
			$args['show_home'] = true;
		}
		return $args;
	}
	
	
	 
	
	protected function load_notclasses() {
		$dir = get_template_directory() .'/inc/notclasses/' ;
		
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
	}
}
