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

namespace Manduca\helpers;
 
class Meta_Tags {
	
	
	public static function get_post_date() {
		return sprintf( '<time datetime="%s">%s</time>',
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);	
	}
	
	public static function get_author() {
		return sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'All posts by %s', 'manduca' ), get_the_author() ) ),
				get_the_author()
			);
	}
	
	public static function get_modified_date() {
		if( get_the_date() === get_the_modified_date() ){
			return FALSE;
		}
		return sprintf( '<time class="updated" datetime="%1$s">%2$s</time>',
					esc_attr( get_the_modified_date( 'c' ) ),
					esc_html( get_the_modified_date( ) )
				);
	}
	
	
	public static function get_categories () {
		if ( has_category() ) {
			return get_the_category_list( ', ' );
		}
		return FALSE;
	}
	
	
	public static function get_tags () {
		if ( has_tag() ) {
			return get_the_tag_list( ', ' );
		}
		return FALSE;
	}

	
	
	public static function post_meta_tag_html (string $list_item_mask, array $meta_type) {
		$utility_text='';
		foreach( $meta_type as $metatag ) {
			$value = call_user_func ($metatag['callback']);
			if ($value) {
				$utility_text 	.= sprintf(
									$list_item_mask,
									$metatag ['icon'],
									$metatag ['label'],
									$value);
			}
		}
		return $utility_text;
	}
	
	
	
	
	public static function attachment_meta_tag_html ($list_item_mask) {
		global $post;
		$metadata = wp_get_attachment_metadata();
		$image_alt 			= get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
		$image_caption  	= $post->post_excerpt;
		$image_description 	= $post->post_content;
	
		$utility_text=self::post_meta_tag_html ($list_item_mask);
		$utility_text.=sprintf( $list_item_mask,
						manduca_get_svg( array( 'icon' => 'cube' ) ),
						//translators: attachment metadata size of attachment
						__( 'Original size', 'manduca' ),
						$metadata['width'].' * ' . $metadata['height'] 		
						);
		if ($image_alt ) {
			$utility_text.=sprintf( $list_item_mask,
						manduca_get_svg( array( 'icon' => 'text' ) ),
						//translators: attachment metadata size of attachment
						__( 'Alternative Text' ),
						$image_alt
						);
		}
		if( !empty( $image_caption ) ) {
			$utility_text.=sprintf( $list_item_mask,
					manduca_get_svg( array( 'icon' => 'film' ) ),
					__( 'Captions/Subtitles' ),
					$image_caption
					);			
		}
			
		if( !empty( $image_description ) ) {
			$utility_text.=sprintf( $list_item_mask,
							manduca_get_svg( array( 'icon' => 'bubble' ) ),
							__( 'Image description'  ),
							$image_description
							);
		}
		
		return $utility_text;
	}

}