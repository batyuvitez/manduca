<?php
/**
 * Static methods for creating html output for meta tags
 *
 * @since 18.7
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

namespace Manduca;
 
class Meta_Tag_Helpers {
    
	public static function get_post_date() {
		return sprintf( '<time datetime="%s">%s</time>',
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);	
	}
	
	public static function get_authors() {
		return sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'All posts by %s', 'manduca' ), get_the_author() ) ),
				get_the_author()
			);
	}
	
	public static function get_modified_date() {
			return sprintf( '<time class="updated" datetime="%1$s">%2$s</time>',
					esc_attr( get_the_modified_date( 'c' ) ),
					esc_html( get_the_modified_date( ) )
				);
	}

	public static function meta_tag_generator () {
	
		$list_item_mask 	= '<li>%s<span class=metaBlock><span>%s : </span>%s</span></li>';
	
		$utility_text 	= sprintf(
									$list_item_mask,
									manduca_get_svg( array( 'icon' => 'calendar' ) ) ,
									// translators: Date of post - in the post meta. 
									__( 'Entry date', 'manduca' ),
									self::get_post_date()
								);
		
		if( get_the_date() !== get_the_modified_date() ) {
			$utility_text 	.= sprintf(
									$list_item_mask,
									manduca_get_svg( array( 'icon' => 'calendar-add' ) ) ,
									//translators: Last modification of post - in the post meta
									 __( 'Last revision', 'manduca' ),
									 self::get_modified_date()
								);				
		}
		
		
		$utility_text 	.= sprintf(
									$list_item_mask,
									manduca_get_svg( array( 'icon' => 'author' ) ),
									//translators: Author of post - in the post meta
									 __( 'Author', 'manduca' ),
									 self::get_authors()
								);				
		
		if ( has_category() ) {
		
			$utility_text 	.= sprintf(
									$list_item_mask,
									manduca_get_svg( array( 'icon' => 'folder-open' ) ),
									//translators: Category of post - in the post meta
									 __( 'Category', 'manduca' ),
									 get_the_category_list( ', ' )
								);			
		}
		
		if ( has_tag()) {
		
			$utility_text 	.= sprintf(
									$list_item_mask,
									manduca_get_svg( array( 'icon' => 'tags' ) ),
									//translators: Tags of post - in the post meta
									 __( 'Tags', 'manduca' ),
									 get_the_tag_list( '', ', ' )
								);			
		}
		return $utility_text;	
	}

}