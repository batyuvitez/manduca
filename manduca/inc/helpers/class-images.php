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

namespace Manduca\helpers;

class Images
{
	
	protected static $has_thumbnail = FALSE;
	protected static $thumbnail_html;
	
		
	public static function get_first_image_of_post () {
		if ($firstImage) {
			$attachmentUrl=$images[0];
			if (substr_count ($attachmentUrl, WP_HOME) === 2) {
				$thumbnail_substitution_url = preg_replace ('^'.WP_HOME.'/^', '', $attachmentUrl, 1);
			}
		}		
		return self::create_responsive_image ($thumbnail_substitution_url);
	}
	
	
	public static function thumbnail_substitution () {
		echo self::$thumbnail_html;
	}
	
	
	
	protected static function get_images () {
		$images =array ();
		global $post;
		$dom=new \DOMDocument;
		$content=mb_convert_encoding ($post->post_content, 'HTML-ENTITIES', 'UTF-8');
		$dom->loadHTML ($content);
		foreach ($dom->getElementsByTagName ('img') as $node)
			$images[] =home_url ( '/' ) .$node->getAttribute ('src');
		return $images;
	}
	
	/*
	 *@see: https://stackoverflow.com/questions/45504077/wordpress-adding-srcset-and-sizes-attributes-to-image-from-customizer
	 */
	public static function create_responsive_image( $img ) {
		$img_id = attachment_url_to_postid( $img );
		$img_srcset = wp_get_attachment_image_srcset( $img_id );
		$img_sizes = wp_get_attachment_image_sizes( $img_id );
		return '<img src="' . $img . '" srcset="' . esc_attr( $img_srcset ) . '" sizes="' . esc_attr( $img_sizes ) . '">';
	}
	
	
	public static function has_thumbnail( bool $firstImage = FALSE ) {
		if ( has_post_thumbnail() ) {
			self::$has_thumbnail=TRUE;
			self::$thumbnail_html=get_the_post_thumbnail (null, 'excerpt-size');
		}
		elseif( $firstImage ) {
			$thumbnail_url=self::get_first_image_of_post ();
			if( $thumbnail_url ) {
				self::$has_thumbnail=TRUE;
				self::$thumbnail_html=self::create_responsive_image ($thumbnail_url);
			}
		}
		else {
			$thumbnail_url = get_theme_mod ('thumbnail_substitution');
			if( $thumbnail_url ) {
				self::$has_thumbnail=TRUE;
				self::$thumbnail_html=self::create_responsive_image ($thumbnail_url);
			}
		}
		return self::$has_thumbnail;
	}

}

