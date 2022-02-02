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
	
	protected static $thumbnail_html;
	protected static $size;	
		
	public static function get_first_image_of_post () {
		$images=self::get_images ();
		if (is_array( $images ) && isset( $images[0] ) ) {
			$attachmentUrl=$images[0];
			if (substr_count ($attachmentUrl, WP_HOME) === 2) {
				return preg_replace ('^'.WP_HOME.'/^', '', $attachmentUrl, 1);
			}
		}	
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
		foreach ($dom->getElementsByTagName ('img') as $node) {
			$images[] =home_url ( '/' ) .$node->getAttribute ('src');
		}
		return $images;
	}
	
	/*
	 *@parameter string img : URL of the image (attachment URL)
	 *
	 *@return string: HTML markup of post_thumbnail of the image. 
	 */
	public static function create_responsive_image( $img ) {
		$img_id = attachment_url_to_postid( $img );
		$args 	= array ( 'class'=>'attachment-post-size size-post-size wp-post-image');
		return wp_get_attachment_image( $img_id, self::$size, NULL, $args );
	}
	
	
	
	/*
	 * Returns  TRUE, if find an image to display as featured image (alias thumbnail). 
	 * This method need to be called before echo thumbnail substitution
	 *
	 *@param bool $firtsimage: if TRUE, thumbnail is set the first image of the post.
	 *                         Default: FALSE
	 *@param $size    : Image size. Accepts any registered image size name,
	 *                  or an array of width and height values in pixels (in that order).
	 *                  Default: excerpt-size
	 *
	 *@return bool: TRUE if find a thumbnail.
	 *
	 **/
	public static function has_thumbnail( bool $firstImage = FALSE,  $size = 'excerpt-size' ) {
		
		self::$size=$size;
		if ( has_post_thumbnail() ) {
			self::$thumbnail_html=get_the_post_thumbnail (null, $size);
			return TRUE;
		}
		$thumbnail_url = get_theme_mod ('thumbnail_substitution');
		self::$thumbnail_html=self::create_responsive_image ($thumbnail_url);
		if( $thumbnail_url && !$firstImage) {	
			return TRUE;
		}
		if( $firstImage ) {
			$thumbnail_url=self::get_first_image_of_post ();
			if( $thumbnail_url ) {
				self::$thumbnail_html=self::create_responsive_image ($thumbnail_url);
				return TRUE;
			}
		}
		return FALSE;
	}
	
	/*
	 *@return string of class.
	 *			If post has assigned featured-image: has-thumbnail,
	 *			other cases: no-thumbnail.
	 **/
	public static function thumbnail_class () {
		if ( has_post_thumbnail() ) {
				return 'has-thumbnail'; 
		}
		return 'no-thumbnail';
	}

}

