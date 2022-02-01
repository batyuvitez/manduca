<?php
/*
 * Theme setup of images
 *
 *
 **/

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

namespace Manduca\setup;

class Images {

	public function __construct () {
		add_filter('image_send_to_editor',array( $this, 'add_class_image_anchor' ) ,10,8);
		add_action( 'after_setup_theme', array($this, 'image_size_settings' ) );
		add_filter( 'image_size_names_choose', array( $this, 'image_size_names' ) );
		add_filter('jpeg_quality', array( $this, 'set_jpg_quality' ) );
		add_filter('wp_editor_set_quality', array( $this, 'set_wp_editor_quality' ) );
		add_filter( 'big_image_size_threshold', array ($this, 'manduca_thereshold'));
	}
		
	
	/*
	 * Add anchor to image anchor insert in post content
	 * @Since 16.10
	 **/
	public function add_class_image_anchor($html, $id, $caption, $title, $align, $url, $size, $alt = '' ){
		$classes = 'image-link'; 
	  
		if ( preg_match('/<a.*? class=".*?">/', $html) ) {
		  $html = preg_replace('/(<a.*? class=".*?)(".*?>)/', '$1 ' . $classes . '$2', $html);
		} else {
		  $html = preg_replace('/(<a.*?)>/', '$1 class="' . $classes . '" >', $html);
		}
		return $html;
	}
	
	
		
	
	
	
	/*
	 * Change name of Manduca specific image sizes
	 */
   function image_size_names( $sizes ) {
	   $add_sizes = array(
		   'thumbnail-size' 	=> __( 'Thumbnail', 'manduca' ),
		   'post-size' 		=> __( 'Image in Post', 'manduca' ),
		   'full' 				=> __( 'Original size', 'manduca' ),
		   'excerpt-size' 	=> __( 'Excerpt size', 'manduca' ),
			'extra-wide'		=>__( 'Extra wide', 'manduca' )
	   );
	   $new_sizes = array_merge($sizes, $add_sizes);
	   return $new_sizes;
	}

	
	/*
	 *3 images sizes needed
	 **/
	public function image_size_settings() {
		// Uses a custom image size for featured images
		add_theme_support( 'post-thumbnails' );
		add_image_size ('post-size', 890, 592 );
		add_image_size ('excerpt-size', 268, 178 );
		add_image_size ('extra-wide', 1920, 384 );  // ratio: 1:5
	}
	
	
	/*
	 * Change jpg quality to best
	 * */
	public function set_jpg_quality () {
		return 100;
	}
	
	
	public function set_wp_editor_quality () {
		return 100;
	}

	public function manduca_thereshold ($threshold) {
		
		return 5000;
	}

}
