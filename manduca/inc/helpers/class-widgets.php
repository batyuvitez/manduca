<?php
/**
 * Extended recen post widget 
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

namespace Manduca\helpers;
 
class Widgets {
	
	public static function get_categories () {
		$args = array(
			'number' => 99
		);
	
		return  get_terms( 'category', $args );
	}
	
	
	public static function tag_list() {

		$args = array(
			'number' => 99
		);
	
		return get_terms( 'post_tag', $args );

	}

	/**
	* Generates the posts markup for accessible recent posts.
	*
	* @return string|array The HTML for the random posts.
	*/
   public static function display_recent_posts( $args = array() ) {
   
	   $html=FALSE;
		$posts = self::get_posts( $args );
		$all_args=array( $posts, $args);
		if ( $posts->have_posts() ) {
			get_template_part ('template-parts/widget/recentposts' , NULL, $all_args);
		}
	   wp_reset_postdata();
   }
   
   /**
	* The posts query  for accessible recent posts.
	*
	* @param  array  $args
	* @return array
	*/
   protected static function get_posts( $args = array() ) {
   
	   // Query arguments.
	   $query = array(
		   'offset'              => $args['offset'],
		   'posts_per_page'      => $args['limit'],
		   'orderby'             => $args['orderby'],
		   'order'               => $args['order'],
		   'post_type'           => $args['post_type'],
		   'post_status'         => $args['post_status'],
		   'ignore_sticky_posts' => $args['ignore_sticky'],
	   );
   
	   // Exclude current post
	   if ( $args['exclude_current'] ) {
		   $query['post__not_in'] = array( get_the_ID() );
	   }
   
	   // Limit posts based on category.
	   if ( ! empty( $args['cat'] ) ) {
		   $query['category__in'] = $args['cat'];
	   }
   
	   // Limit posts based on post tag.
	   if ( ! empty( $args['tag'] ) ) {
		   $query['tag__in'] = $args['tag'];
	   }
   
	   /**
		* Taxonomy query.
		* Prop Miniloop plugin by Kailey Lampert.
		*/
	   if ( ! empty( $args['taxonomy'] ) ) {
   
		   parse_str( $args['taxonomy'], $taxes );
   
		   $operator  = 'IN';
		   $tax_query = array();
		   foreach( array_keys( $taxes ) as $k => $slug ) {
			   $ids = explode( ',', $taxes[$slug] );
			   if ( count( $ids ) == 1 && $ids['0'] < 0 ) {
				   // If there is only one id given, and it's negative
				   // Let's treat it as 'posts not in'
				   $ids['0'] = $ids['0'] * -1;
				   $operator = 'NOT IN';
			   }
			   $tax_query[] = array(
				   'taxonomy' => $slug,
				   'field'    => 'id',
				   'terms'    => $ids,
				   'operator' => $operator
			   );
		   }
   
		   $query['tax_query'] = $tax_query;
   
	   }
   
	   // Allow plugins/themes developer to filter the default query.
	   $query = apply_filters( 'rpwe_default_query_arguments', $query );
   
	   // Perform the query.
	   $posts = new \WP_Query( $query );
   
	   return $posts;   
	}

}