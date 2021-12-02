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
	
	
	/*
	 *For backwards compatibility
	 **/
	public static function post_meta_tag_html (string $list_item_mask, array $meta_type) {
		return self::meta_tag_html ($list_item_mask, $meta_type);
	}
	
	
	
	
	public static function meta_tag_html (string $list_item_mask, array $meta_type) {
		$utility_text='';
		foreach( $meta_type as $metatag ) {
			$value = call_user_func ($metatag['callback']);
			if ($value !== FALSE ) {
				$utility_text 	.= sprintf(
									$list_item_mask,
									$metatag ['icon'],
									$metatag ['label'],
									$value);
			}
		}
		return $utility_text;
	}
	
	
		
	public static function get_post_date( $format=NULL) {
		return sprintf( '<time datetime="%s">%s</time>',
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date( $format ) )
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
			return get_the_category_list( ', ');
		}
		return FALSE;
	}
	
	
	public static function get_tags () {
		if ( has_tag() ) {
			return get_the_tag_list( '', ', ','' );
		}
		return FALSE;
	}

	public static function get_alt_tag () {
		global $post;
		$image_alt 			= get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
		if ($image_alt)
			return $image_alt;
		return self::empty_metadata();
	}
	
	public static function get_image_size () {
		$metadata = wp_get_attachment_metadata();
		return $metadata['width'].' * ' . $metadata['height'];
	}
	
	public static function get_caption (){
		global $post;
		$image_caption  	= $post->post_excerpt;
		if ($image_caption)
			return $image_caption;
		return self::empty_metadata();
		
	}
	
	public static function empty_metadata () {
		//Translators: Missing metadata 
		return __( 'none', 'manduca' );
	}
	
	public static function get_description () {
		global $post;
		$image_description 	= $post->post_content;
		if ($image_description 	)
			return $image_description ;
		return self::empty_metadata();
	}
	
	public static function get_attachment_parent (){
		$post = get_post();
		$parent_id = $post->post_parent;
		
		if( !empty( $parent_id ) ) {
			$parent_title = get_the_title( $parent_id );
		}
		else {
		 return FALSE;
		}
		$parent_permalink = get_permalink( $parent_id );
		$a ='<a href="';
		$a.=$parent_permalink;
		$a.='">'.$parent_title;
		$a.='</a>';
		return $a;
	}

}