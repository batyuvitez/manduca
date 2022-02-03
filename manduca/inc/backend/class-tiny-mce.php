<?php
 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

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
 
namespace Manduca\backend;
 
class Tiny_Mce {
	
	public function __construct() {
		
		// Add accessible format options to TinyMCE. 
		add_filter( 'tiny_mce_before_init', array ( $this, 'tinymce_formats' ) );
	
		//Add tiny MCE 2 core buttons that's disabled by default and stylebutton
		add_filter( 'mce_buttons_2', array( $this, 'core_buttons' ) );
				   
		// Add ediotor stylesheet to tiny mce
		add_action( 'admin_init', array( $this, 'editor_css' ) );
		
	}
	
	
   public function tinymce_formats( $init_array ) {
	   
	   // Define the style_formats array
	   $style_formats = array(  
		   // Each array child is a format with it's own settings
		   array(  
			   'title' => __( 'Quotation' , 'manduca' ),  
			   'inline' => 'q',  
			   'wrapper' => true,
		   ),
			   array(  
			   'title' => __( 'Abbreviation' , 'manduca' ),  
			   'inline' => 'abbr',  
			   'wrapper' => true,
		   )
	   );
	   
	   $init_array['style_formats'] = json_encode( $style_formats );
	   
	   // replace block formats with elements helps bulding an accessibile content
		   $block_formats 			= 'Paragraph=p; ' .__( 'Heading 2', 'manduca' ) .'=h2; ';
		   $block_formats 			.= __( 'Heading 3', 'manduca' ) .'=h3; ';
		   $block_formats 			.= __( 'Preformatted', 'manduca' ) .'=pre; ';
		   $block_formats			.= __( 'Blockquote', 'manduca') .'=blockquote;';
		   
		   $init_array[ 'block_formats' ] = $block_formats;
			   
	   return $init_array;  
   }
   
	
   public function core_buttons( $buttons ) {	
	   $buttons[] = 'superscript';
	   $buttons[] = 'subscript';
	   array_unshift( $buttons, 'styleselect' );
	   return $buttons;
   }
   
	
	
   public function editor_css() {
	   add_editor_style( 'assets/css/manduca-tinymce.css' );    
   }  
}