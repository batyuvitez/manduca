<?php
/*
 *@Since 18.9
 **/


class Manduca_Template_Functions {
		
	/*
	 *If a post slited into more pages with <!! nextpage --> shortag, this shows the previous and next page
	 *(this is not the default WP setup)
	 **/
	public static function manduca_link_pages() {
			$next_link = sprintf( '%s&nbsp;%s ',
								 __( 'Next page of post', 'manduca' ),
								 manduca_get_svg( array( 'icon' => 'angle-circle-right') )
								 );
			$previous_link = sprintf( '%s&nbsp;%s ',
								 manduca_get_svg( array( 'icon' => 'angle-circle-left') ),
								 __( 'Previous page of post', 'manduca' )
								 );
		
			$args = array (
				'before'            => '<div class="post-pagination"><span class="screen-reader-text" role="heading">' . __( 'Pages of this post', 'manduca' ) . ': </span>',
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
	 * Displays the accessible navigation  between posts
	 *
	 * @return (string) : html markup of navigation 
	 * */
	public static function post_navigation(){
		

				$arrow_right_svg = manduca_get_svg( array( 'icon' => 'angle-right' ) ) ;
				$arrow_left_svg = manduca_get_svg( array( 'icon' => 'angle-left' ) ) ;;
				$args = array(
					'prev_text' 		=> $arrow_left_svg .'<span class="screen-reader-text">' . __( 'Newer posts', 'manduca' ) .'</span>'		,
					'next_text' 		=> '<span class="screen-reader-text">' .__( 'Older posts', 'manduca' ) .'</span>' . $arrow_right_svg,
					'before_page_number' => '<span class="screen-reader-text">' . __( 'page', 'manduca' ) . ' </span>',
					'end_size'			=> 3
				);
				$nav = get_the_posts_pagination( $args ) ;
				// Add access keys @18.9.3
				$nav = str_ireplace( 'class="next page-numbers"', 'class="next page-numbers" accesskey="k"' , $nav );
				$nav = str_ireplace( 'class="previous page-numbers"', 'class="previous page-numbers" accesskey="e"' , $nav );
				
		return $nav;
	}
	
	public static function get_info_button_html() {
		/* Add information button, if there is a link to it.
		*
		* Return @array: 'url' :		the url of the info page
		* 				 'title' : 		the tooltip, screen-reader text of the link
		* 				 'anchor text': the anchor text of the link
		*/
		
		$info_button_data = apply_filters ( 'manduca_toolbar_info_button' , false );
		
		if( $info_button_data === false ) {
				return null;
		}
		
		 return sprintf( '<div class="more-link">	<a href="%1$s" class="info-button" title="%2$s">%3$s<span class="desktop-text">%4$s</span></a></div>' ,
			esc_html( $info_button_data[ 'url' ] ), 
			esc_html( $info_button_data[ 'title' ] ),
			manduca_get_svg( array( 'icon' => 'info' ) ),
			esc_html( $info_button_data[ 'anchor-text' ] )
			);
	}
}

