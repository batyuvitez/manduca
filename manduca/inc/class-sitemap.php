<?php
/*
 * This class provide the sitemap to Manduca sitemap page
 *@since 17.9.17
 *
 **/

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


Class Sitemap {
	
		
	public function authors() {
		$args = array(
					  'exclude_admin' 	=> true,
					  'echo'			=> false
					  ); 
	
		return '<ol>' .wp_list_authors( $args ) .'</ol>';
	}
	
	public function pages() {
		$args = array(
						'exclude'        => '',
						'title_li'     => '',
						'sort_column'  => 'post_title',
						'echo'			=> false
						);
		return '<ol>' .wp_list_pages( $args ) .'</ol>';
	}
 
	public function posts_by_category(){
		
		$html = '<ol>';
		$cats = get_categories();
		foreach ( $cats as $cat ) {
			$html .= '<h3 class="js-expandmore">' .esc_html( $cat->cat_name ) .'</h3>';
			$html .= '<ul class="js-to_expand">';
			
			$posts  = new  \WP_Query( [
					'cat' => $cat->cat_ID, // Just in case Yoast data corrupted & post no longer attached to X term but primary meta remains
					'meta_query' => [
						[
							'key' => '_yoast_wpseo_primary_category',
							'value' => $cat->cat_ID,
						]
					],
				]);
			
			$html .= $this->create_list_elements( $posts );
			$html .=  '</ul>';
			$html .= '</li>';
		}
		$html .= '</ol>';
		return $html;
	}	
		
	public function posts_in_abc() {
		$html = '<ol>';	
		$list_posts = new \WP_Query( array( 
			'post_type'       => 'post', 
			'posts_per_page'  => -1, 
			'post_status'     => 'publish',
			'order'           => 'ASC',
			'orderby'         => 'title'
			) );
	
		$html .= $this->create_list_elements( $list_posts );
		$html .= '</ol>';
		return $html;
	}
	
	
	public function images() {
		$html = '<ol>';
		$query_images_args = array(
		  'post_type' => 'attachment',
		  'post_mime_type' =>'image',
		  'post_status' => 'inherit',
		  'posts_per_page' => -1,
		  'order'           => 'ASC',
		  'orderby'         => 'title'
	  );
			  
		$query_images = new \WP_Query( $query_images_args );
		$images = array();
		foreach ( $query_images->posts as $image) {
			setup_postdata( $image );
			
			$post_title = $image->post_title;
			// This can be empty 
			if( empty( $post_title)  ) {
				//translators: When image has no title, indicated with this text in sitemap.
				$post_title = __( 'No title', 'manduca' ) ;
			}
			
			$html .= sprintf( '<li><a href="%1$s">%2$s</a></li>',
				   get_attachment_link( $image->ID ),
				   $post_title
				   );
			
		}
		
		$html .= '</ol>';
		return $html;
	}

	
	
	public function pdfs(){
		$query_pdf = new \WP_Query( array(
				'post_type' => 'attachment',
				'post_mime_type' =>'application/pdf',
				'post_status' => 'inherit',
				'posts_per_page' => -1,
				'order'           => 'ASC',
				'orderby'         => 'title'
			)
		);
		
		$pdf = array();
	   
		//If is there any PDF? 
		If( $query_pdf->post_count  > 0 ) {
				$html = '<ol>';
		 
				foreach ( $query_pdf->posts as $pdf) {
						setup_postdata($pdf);
			
						$html .= sprintf( '<li><a href="%1$s">%2$s</a></li>',
							   wp_get_attachment_url( $pdf->ID ),
							   $pdf->post_title
							   );			
				}
				$html .= '</ol>';
				return $html;
		}
		else {
				return '';
		}
	  
	}
	
	
	/*
	 * Create list elements from query
	 * */
	protected function create_list_elements( $query ) {
		$html = '';
		while ( $query->have_posts() ) {
			$query->the_post();
			$html .= sprintf( '<li><a href="%1$s">%2$s</a></li>',
				   get_permalink(),
				   get_the_title()
				  );
		}
		return $html;
	}
}