<?php
/**
 * WP's attachment navigation sometimes get errorneus links.
 * This is a working navigation
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

namespace Manduca\helpers;
 
class Navigation_Single {


	public static function attachment_navigation_html (){
		$post = get_post();
		
		/* Get all images */
		$query_images_args = array(
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
			'post_status'    => 'inherit',
			'posts_per_page' => - 1,
		);
		
		$query_images = new \WP_Query( $query_images_args );
	
		// Input image IDs to $images 
		$images 		= array();
		$previous_id 	= false;
		$previous_title 	= false;
		$one_more 		= false;
		$first_cycle	=true;		
		
		foreach ( $query_images->posts as $image ) {
			$next_id = $image->ID;
			$next_title = $image->post_title;
			if( $one_more ) {
				break;
			}
			if( $post->ID == $image->ID ) {
				$one_more = true;
			}
			if( !$first_cycle && !$one_more ) {
				$previous_id = $image->ID;
				$previous_title = $image->post_title;
				}
			else {
				$first_cycle = false;
			}
			//If the cycle runs to the end, there is no next image
			$next_title = false;
		}
		
		$data=array (
			'previous_permalink'  	=> get_attachment_link( $previous_id ),
			'next_permalink' 		=> get_attachment_link ( $next_id ),
			'next_title'			=> $next_title);
		return $data;
	}
	
}