<?php

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2019  Zsolt Edelényi (ezs@web25.hu)

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

namespace Manduca;

class Sitemap_Category_Walker extends \Walker_Category {
   	/**
	 * 
	 *
	 * @since 2.1.0
	 *
	 * @see Walker::start_el()
	 *
	 * @param string $output   Used to append additional content (passed by reference).
	 * @param object $category Category data object.
	 * @param int    $depth    Optional. Depth of category in reference to parents. Default 0.
	 * @param array  $args     Optional. An array of arguments. See wp_list_categories(). Default empty array.
	 * @param int    $id       Optional. ID of the current category. Default 0.
	 */
	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		/** This filter is documented in wp-includes/category-template.php */
		$cat_name = esc_attr( $category->name );

		// Don't generate an element if the category name is empty.
		if ( '' === $cat_name ) {
			return;
		}

		if ( !$depth ) {
         $output .= '<h2 class="js-expandmore">';
         $heading = 2;
      }
      else{
         $heading = $depth +3;
         $output    .= "\t<h". $heading .' class="js-expandmore">';
      }
      $output     .= $category->name .'</h' .$heading .">\n";
      
      $posts  = new  \WP_Query( [
					'cat' => $category->cat_ID, // Just in case Yoast data corrupted & post no longer attached to X term but primary meta remains
					'meta_query' => [
						[
							'key' => '_yoast_wpseo_primary_category',
							'value' => $category->cat_ID,
						]
					],
				]);
      $output .= '<ul class="js-to_expand">';
      while ( $posts->have_posts() ) {
			$posts->the_post();
			$output.= sprintf( '<li><a href="%1$s">%2$s</a></li>',
				   get_permalink(),
				   get_the_title()
				  );
		}
      $output .= '</ul>';
      
	}

}