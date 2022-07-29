<?php
/*
 * Moved from Template_functions
 * @since 22.6
 **/

 
/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

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

namespace Manduca\helpers;
use Manduca\helpers as hlp;

class Excerpts {
		
	private static $prefix;
	
	
	/*
	 * Creating the excerpt
	 *
	 * @param $morelink_flag : depretiated in #20.1
	 * @param int $len       : If no excerpt provided in post, the number of words from the beggining. 
	 * @return (string): HTML content of excerpt with readmore link. 
	 *
	 * */
	
	public static function get_the_excerpt ($always_morelink=false, int $len=45, string $prefix='' ) {
		self::$prefix = $prefix;
		$post 		  = get_post();
		$post_content = $post->post_content;
		$post_content = Blocks::get_text_contents ($post_content);
		$post_content = self::correct_headings ( $post_content );
		if( has_excerpt() === true ) {
				$html 		= $post->post_excerpt;
				$morelink_flag=TRUE;
		}
		
		elseif( false !==  strpos( $post_content, '<!--more-->' ) ) {
				$paragpraphs = 	explode( '<!--more-->', $post_content ) ;
				$morelink_flag=TRUE;
				if( isset( $paragpraphs[0] ) ) {
					$html = $paragpraphs[ 0 ];
				}
		}
		else {
				$html = self::trim_excerpt ($always_morelink,  $post_content, $len);
				$morelink_flag=FALSE;
		}
		$html = strip_shortcodes( $html);
		if( $morelink_flag ) {
			$html=self::add_morelink ($html, $prefix );
		}
		
		return $html;
	}
	
	
	
	
	
	
	
	/*
	 * Create Human readable excerpt from the content.
	 * Breaking sentence at the end, or at the end of HTML tag
	 *
	 * @param (string) HTML content
	 * @param (int) $len : number of words stripped from beginning.
	 * @param bool always_morelink
	 *
	 * @return (string) excerpt in HTML 
	 * @see: https://wordpress.stackexchange.com/questions/141125/allow-html-in-excerpt/141136#141136
	 */
    protected static function trim_excerpt( $always_morelink, string $content, int $excerpt_word_count  ) {
		$allowed_tags =  '<br>,<em>,<i>,<ul>,<ol>,<li>,<a>,<p>,<video>,<audio>,<h2>,<h3>,<h4>'; 
		$excerpt = strip_shortcodes( $content );
		$excerpt = apply_filters('the_content', $excerpt);
		$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
		$excerpt = strip_tags( $excerpt, $allowed_tags ); 

		
		//Filter depretiated as of 20.4
		$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); 
		$tokens = array();
		$excerptOutput = '';
		$count = 0;

		// Divide the string into tokens; HTML tags, or words, followed by any whitespace
		preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $excerpt, $tokens);

		$morelink_flag =FALSE;
		foreach ($tokens[0] as $token) {
			if ($count++ >= $excerpt_length && preg_match('/[\,\;\?\.\!]\s*$/uS', $token)) { 
			// Limit reached, continue until , ; ? . or ! occur at the end
				$excerptOutput .= trim($token);
				$morelink_flag =TRUE;
				break;
			}
			$excerptOutput .= $token;// Append what's left of the token
		}
		$excerpt = trim(force_balance_tags($excerptOutput));
		if ( $morelink_flag || $always_morelink ) {
			$excerpt=self::add_morelink( $excerpt );
		}
		return $excerpt;   
	}
	
	
	/*
	 *Add morelink to the end of HTML
	 *
	 *@param string $html HTML code
	 *@return string HTML code with morelink
	 **/
	protected static function add_morelink( string $html) 	{
		return $html.hlp\More_Links::more_link_create_html( self::$prefix );
	}


	public static function correct_headings ( string $content ) {
			$content = str_replace( '<h4>', '<h5>', $content );
			$content = str_replace( '</h4>', '</h5>', $content );
			$content = str_replace( '<h3>', '<h4>', $content );
			$content = str_replace( '</h3>', '</h4>', $content );
			$content = str_replace( '<h2>', '<h3>', $content );
			$content = str_replace( '</h2>', '</h3>', $content );
			$content = str_replace ('<h2 class="js-expandmore">', '<h3 class="js-expandmore">',$content);
		return $content;
	}
	
}

