<?php
/**
 * Comments helpers
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
 
class Comments {
	
	/**
	* Defines the callback function for use with wp_list_comments(). This function controls
	* how comments are displayed.
	*/
	public static function manduca_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		if ( $comment->comment_type !== 'pingback' && $comment->comment_type !== 'trackback'  ) {	
			$pass=array( 'args'=>$args, 'depth'=>$depth);
			get_template_part( '/template-parts/posts/comments', NULL ,$pass);
		}
	}
 
	/**
	* Adds the functionality to count comments by type, eg. comments, pingbacks, tracbacks. Return the number of comments, but do not print them.
	* Based on the code at WPCanyon (http://wpcanyon.com/tipsandtricks/get-separate-count-for-comments-trackbacks-and-pingbacks-in-wordpress/)
	* 
   */
	public static function manduca_get_comment_count( $type = 'comments', $only_approved_comments = true, $top_level = false ){
	   if ( ! get_the_ID() ) return;
	   if 		( $type == 'comments' ) 	$type_sql = 'comment_type = ""';
	   elseif 	( $type == 'pings' )		$type_sql = 'comment_type != ""';
	   elseif 	( $type == 'trackbacks' ) 	$type_sql = 'comment_type = "trackback"';
	   elseif 	( $type == 'pingbacks' )	$type_sql = 'comment_type = "pingback"';
	   
	   $approved_sql = $only_approved_comments ? ' AND comment_approved="1"' : '';
	   $top_level_sql = ( $top_level ) ? ' AND comment_parent="0" ' : '';
		   
	   global $wpdb;
   
	   $result = $wpdb->get_var( '
		   SELECT
			   COUNT(comment_ID)
		   FROM
			   ' . $wpdb->comments . '
		   WHERE
			   ' . $type_sql . $approved_sql . $top_level_sql . ' AND 
			   comment_post_ID= ' . get_the_ID() );
	   
	   return $result;
	}
	
	public static function get_comment_date() {
		return sprintf( '<time datetime="%s">%s</time>',
			esc_attr( get_comment_time() ),
			esc_html( get_comment_date() )
		);	
	}
 	
}