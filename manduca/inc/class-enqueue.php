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

namespace Manduca;

class Enqueue{
   
   public function __construct() {
      // Add admin css  in order to properly display outgoing link icons.
		add_action(
                 'admin_enqueue_scripts',
                 array( $this, 'admin_stylesheet' )
                 );
         
      // Add frontend scripts and files
		add_action( 'wp_enqueue_scripts',
                 array( $this, 'enqueue' )
                 );
			
   }
   
   
   
   
   public function enqueue() {
		global $wp_styles;
	
		$assetDir=get_template_directory_uri() . '/assets/';
      if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	 	// Loads stylesheets.
      $stylesheet_path=get_stylesheet_directory(). '/assets/css/style.min.css';
      if (file_exists ($stylesheet_path)) {
          $stylesheet=get_stylesheet_directory_uri().'/assets/css/style.min.css';
      }
      else {
         $stylesheet=get_stylesheet_uri();
      }
      wp_enqueue_style( 'manduca-stylesheet', $stylesheet, false, false, 'all' );
			
		// Loads the Internet Explorer specific stylesheet.
		wp_enqueue_script( 'manduca-scripts', $assetDir.'js/manduca-scripts.min.js', array( 'jquery' ), '', 'true'); 
		
      	
      /*
       *Add variables to jQuery scripts (manduca-scripts.js)
       **/
      
      $js_variables = array(
                        // Translators: Accessible show-hide system: expand all button 
                        'expand_all'=> __( 'Expand all', 'manduca' ),
                        // Translators: Accessible show-hide system: collapse all button 
                        'collapse_all'=> __( 'Collapse all', 'manduca' ),
                        //Translators: submenu expand
                        'expand'=>__( 'expand child menu', 'manduca' ),
                        //Translators: submenu collapse
                        'collapse'=>__( 'collapse child menu', 'manduca' ),
                        'icon'=>manduca_icon( 'caret-down', false ),
                        'reading_options'=> array()
                        );
			
      if( \Manduca\widgets\Widget_Archives::is_this_widget_active() ) {
         $js_variables['hash']       	= wp_create_nonce( 'manduca-ajax' );
      }
         
         
      
      /*
       * Define focus snail color
       * */
      $focus_snail_color = array (
                     'red'		=>22,
                     'green'		=>78,
                     'blue'		=>104
         );
         /**
			 * Filters the focus snail color.
			 *
			 * @param array  RGB color of focus snail
			 */
      $focus_snail_color = apply_filters( 'manduca_focus_snail_color' , $focus_snail_color );
      $js_variables = $js_variables + $focus_snail_color;
      
      /**
			 * Filters all javascript variagles
			 *
			 * @param array  variables
			 */
      $js_variables = apply_filters( 'manduca_js_variables' , $js_variables);
      
      wp_localize_script( 'manduca-scripts', 'manducaVariables', $js_variables );
      
	}
   
   
   
   
   
   public function admin_stylesheet() {
		wp_enqueue_style( 'admin-styles', get_template_directory_uri() .'/assets/css/admin.css') ;
	}

   
}