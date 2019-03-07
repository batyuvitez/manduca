<?php

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2019  Zsolt Edelényi (ezs@web25.hu)

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
	
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	
		// Loads stylesheets.
		wp_enqueue_style( 'theme-stylesheet', get_stylesheet_uri(), false, false, 'all' );
			
		// Loads the Internet Explorer specific stylesheet.
		wp_enqueue_style( 'manduca-ie', get_template_directory_uri() . '/assets/css/ie.css', array( 'manduca-style' ) );
		$wp_styles->add_data( 'manduca-ie', 'conditional', 'lt IE 9' );
		
		wp_enqueue_script( 'manduca-scripts', get_template_directory_uri() . '/assets/js/manduca-scripts.js', array( 'jquery' ), '', 'true'); 
			
			$js_variable['expand']         = __( 'expand child menu', 'manduca' );
			$js_variable['collapse']       = __( 'collapse child menu', 'manduca' );
			$js_variable['icon']           = manduca_get_svg( array( 'icon' => 'caret-down', 'fallback' => true ) );
			if( \Manduca\Widget_Archives::is_this_widget_active() ) {
				$js_variable['hash']       	= wp_create_nonce( 'manduca-ajax' );
			}
			wp_localize_script( 'manduca-scripts', 'manducaScreenReaderText', $js_variable );
			
			$focus_snail_color = array (
								'red'		=>22,
								'green'		=>78,
								'blue'		=>104
				);

			$focus_snail_color = apply_filters( 'manduca_focus_snail_color' , $focus_snail_color );
				
			wp_localize_script( 'manduca-scripts', 'manducaFocusSnailColour', $focus_snail_color );
	}
   
   
   
   
   public function admin_stylesheet() {
		wp_enqueue_style( 'admin-styles', get_template_directory_uri() .'/assets/css/admin.css') ;
	}

   
}