<?php
/*
 * Static functions used by template files
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
use Manduca\filters as fil;

class Template_Functions {
		
		
	/*For backward compatilbilty
	 *Depretiated in @22.6
	 **/
	public static function get_the_excerpt ($always_morelink=false, int $len=45 ) {
		return Excerpts::get_the_excerpt ($always_morelink, $len );
	}
	
	
	/*
	 * Return page links for paginated posts (i.e. includes the <!--nextpage-->.
     * Quicktag one or more times). This tag must be within The Loop.
     * replacement of WP's link_pages()
	 *
	 *If a post slited into more pages with <!! nextpage --> shortag, this shows the previous and next page
	 *(this is not the default WP setup, but use the built-in wp_link_pages() function
	 *
	 *@return string HTMl markup of navigation area
	 *@since 18.11
	 **/
	public static function manduca_link_pages( string $left, string $right) {
			$next_link = sprintf( '%s&nbsp;%s ',
								 __( 'Older posts', 'manduca' ),
								 manduca_icon( $left, false )
								 );
			$previous_link = sprintf( '%s&nbsp;%s ',
								 manduca_icon(  $right, false ),
								 __( 'Newer posts', 'manduca' )
								 );
		
			$args = array (
				'before'            => '<div class="post-pagination"><span class="screen-reader-text">' . __( 'Pages of this post', 'manduca' ) . ': </span>',
				'after'             => '</div>',
				'link_before'       => '<span class="page-link">',
				'link_after'        => '</span>',
				'next_or_number'    => 'next',
				'separator'         => ' | ',
				'nextpagelink'      => $next_link,
				'previouspagelink'  => $previous_link,
			);
			 
			wp_link_pages( $args );
	}
	
	
	
	/*
	 * Displays the navigation in post (next/previous set of posts)
	 * when you re in excerpt tamplate.
	 *
	 * @see template-parts/posts/content-excerpt.php
	 * @return (string) : html markup of navigation
	 * 
	 * */
		public static function post_navigation(\WP_Query $query=NULL ) {
				if (!$query) {
					global $wp_query;
					$query=$wp_query;
				}
				if ( $query->max_num_pages < 2 ) {
						return '';
				}
				$args						= array();
				$args[ 'prev_text']			= sprintf( '%s<span class="screen-reader-text">%s</span>',
												  manduca_icon(  'angle-left', false ),
												__( 'Newer posts', 'manduca' )
												);
				$args[ 'next_text']			= sprintf( '<span class="screen-reader-text">%s</span>%s',
												__( 'Older posts', 'manduca' ),
												manduca_icon(  'angle-right', false ) 
												);
			
				$args[ 'end_size' ]			= 3;
				$args['mid_size' ]           	= 1;
			
				/* The paginate_links() function cloned here and modified in 18.10.14 */
				global $wp_rewrite;
			
				// Setting up default values based on the current URL.
				$pagenum_link = html_entity_decode( get_pagenum_link() );
				$url_parts    = explode( '?', $pagenum_link );
			
				// Get max pages and current page out of the current query, if available.
				$total   = isset( $query->max_num_pages ) ? $query->max_num_pages : 1;
				$current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
			
				// Append the format placeholder to the base URL.
				$pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';
			
				// URL base depends on permalink settings.
				$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
				$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';
			
				$defaults = array(
					'base'               => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
					'format'             => $format, // ?page=%#% : %#% is replaced by the page number
					'total'              => $total,
					'current'            => $current,
					'show_all'           => false,
					'prev_next'          => true,
					'add_args'           => array(), // array of query args to add
					'add_fragment'       => '',
				);
			
				$args = wp_parse_args( $args, $defaults );
			
				// Merge additional query vars found in the original URL into 'add_args' array.
				if ( isset( $url_parts[1] ) ) {
					// Find the format argument.
					$format = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
					$format_query = isset( $format[1] ) ? $format[1] : '';
					wp_parse_str( $format_query, $format_args );
			
					// Find the query args of the requested URL.
					wp_parse_str( $url_parts[1], $url_query_args );
			
					// Remove the format argument from the array of query arguments, to avoid overwriting custom format.
					foreach ( $format_args as $format_arg => $format_arg_value ) {
						unset( $url_query_args[ $format_arg ] );
					}
			
					$args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
				}
			
				// Who knows what else people pass in $args
				$total = (int) $args['total'];
				if ( $total < 2 ) {
					return;
				}
				$current  = (int) $args['current'];
				$end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
				if ( $end_size < 1 ) {
					$end_size = 1;
				}
				$mid_size = (int) $args['mid_size'];
				if ( $mid_size < 0 ) {
					$mid_size = 2;
				}
				$add_args = $args['add_args'];
				$links = '';
				$page_links = array();
				$dots = false;
			
				if ( $args['prev_next'] && $current && 1 < $current ) :
					$link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
					$link = str_replace( '%#%', $current - 1, $link );
					if ( $add_args )
						$link = add_query_arg( $add_args, $link );
					$link .= $args['add_fragment'];
					$link = esc_html( $link );
					$page_links[] = sprintf(
								'<div class="nav-item link-button prev"><a href="%1$s">%2$s</a></div>',
								$link,
								$args['prev_text']
					);
				endif;
				for ( $n = 1; $n <= $total; $n++ ) :
					if ( $n == $current ) :
						// usage of aria-current: http://design-patterns.tink.uk/aria-current/
						// but some screen announce it after the title. This is the reason I use screen-reader-text
						//@since 18.11
						$page_links[] = sprintf(
								'<span class="nav-item current"><span class="screen-reader-text">%s </span>%s</span>',
								__( 'Current page', 'manduca' ),
								number_format_i18n( $n )
								);
						
						$dots = true;
					else :
						if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
							$link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
							$link = str_replace( '%#%', $n, $link );
							if ( $add_args )
								$link = add_query_arg( $add_args, $link );
							$link .= $args['add_fragment'];
							$link = esc_html( $link );
			
							
							//translators: screen reader text for numbered list items in post navigation
							$screen_reader_text = sprintf( __( '<span class="screen-reader-text">Page</span> %s', 'manduca' ),
														  number_format_i18n( $n )
														 );
							$page_links[] = sprintf(
								'<div class="nav-item link-button page-numbers"><a class="page-numbers" href="%1$s">%2$s</a></div>',
										$link,
										$screen_reader_text
										);
								
							$dots = true;
						elseif ( $dots && ! $args['show_all'] ) :
							$page_links[] = sprintf(
													'<span class="nav-item dots">%s</span>',
													manduca_icon(  'dots', false ) 
																   );
							$dots = false;
						endif;
					endif;
				endfor;
				if ( $args['prev_next'] && $current && $current < $total ) :
					$link = str_replace( '%_%', $args['format'], $args['base'] );
					$link = str_replace( '%#%', $current + 1, $link );
					if ( $add_args )
						$link = add_query_arg( $add_args, $link );
					$link .= $args['add_fragment'];
					$link = esc_html( $link );
					$page_links[] = sprintf(
								'<div class="link-button next"><a href="%1$s" >%2$s</a></div>',
								$link,
								$args['next_text']
								);
				endif;
		
				$links = join("\n", $page_links);
				if ( !$links ) {
					return;
				}
			
				return $links;

		}
	
		public static function get_info_button_html( $class = NULL ) {
				/* Add information button, if there is a link to it.
				*
				* Return @array: 'url' :		the url of the info page
				* 				 'title' : 		the tooltip, screen-reader text of the link
				* 				 'anchor text': the anchor text of the link
				*/
				
				$info_button_data = apply_filters ( 'manduca_toolbar_info_button' , false );
				
				if( $info_button_data === false ) {
						return '';
				}
		
				$class = $class ? ' '.$class : '';
				
				return sprintf( '<div class="more-link info-button link-button %5$s">	<a href="%1$s" class="info-button" title="%2$s">%3$s<span class="desktop-text">%4$s</span></a></div>' ,
				   esc_html( $info_button_data[ 'url' ] ), 
				   esc_html( $info_button_data[ 'title' ] ),
				   manduca_icon(  'info' , false ),
				   esc_html( $info_button_data[ 'anchor-text' ] ),
				   $class
				   );
	}
	
	
	
	
	/*
	 * Link html provided to previous post in the same category of single post
	 * Replacement of Wp get_previous_post_link() method
	 *
	 * @return  string HTMl markup of <a> element
	 * @see template-parts/posts/navigation
	 * @since 18.10.8
	 **/
	public static function previous_post_link_html( string $svg ) {
			if ( is_attachment() ){
					$post = get_post( get_post()->post_parent );
			}
			else {
					$post = get_adjacent_post( false , '' , true , 'category' );
			}

			if ( ! $post ) {
				$output = '';
			}
			else {
					$output = sprintf( '<a href="%1$s" rel="prev"><span class="screen-reader-text">%4$s</span>%3$s %2$s</a>',
						   get_permalink( $post ),
						   '<span>'.$post->post_title.'</span>',
						   manduca_icon(  $svg, false ),
						   __( 'Previous post', 'manduca' ) .' '
						   );
			}
			return $output;
	}
	
	/*
	 * Link html provided to next post in the same category of single post
	 * Replacement of Wp get_next_post_link() method
	 *
	 * @return  string HTMl markup of <a> element
	 * @see template-parts/posts/navigation
	 * @since 18.10.8
	 **/
	public static function next_post_link_html( string $svg) {
			$post = get_adjacent_post( false , '' , false , 'category' );
			if ( ! $post ) {
				$output = '';
			} else {
					$output = sprintf( '<a href="%1$s" rel="next"><span class="screen-reader-text">%4$s</span>%2$s %3$s</a>',
						   get_permalink( $post ),
						   '<span>'.$post->post_title.'</span>',
						   manduca_icon(  $svg, false ),
							__( 'Next post', 'manduca' ) .' '
						   );
			}
			return $output;
	}
		
		
		
	/*
	 *Additional classes for header
	 *
	 *@since 20.2.
	 **/
	public static function body_classes() {
		$background_color 	= get_background_color();
		$background_image 	= get_background_image();
		$classes			= array();
		$classes[] = 'total';
		
		if ( ! is_multi_author() ) {
			$classes[] = 'single-author';
		}
		
		//Detect visitors OS and browser and add to body tag	
		$classes=array_merge( $classes , (new \Manduca\User_Agent_Detect() )->get_classes() );
		if ( defined ('WP_DEBUG') && WP_DEBUG===TRUE) {
			$classes[]='debug';
		}
		return $classes;
	}
	
	
	public static function copyright_text() {
		if (get_theme_mod('manduca_copyright_text') ) {
			return get_theme_mod('manduca_copyright_text');
		}
		return '&copy; ' . date ('Y') . ' '. fil\Title::site_title_with_whitespace ();
		
	}
}

