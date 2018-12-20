<?php
/*
 * This class provide the sitemap to Manduca sitemap page
 *
 * @ Theme: Manduca - focus on accessibility
 * @ since 17.9.17
 *
 * @ parameter array $args sitemap lis
 * 					options: author, pages, posts, images, pdfs. 
 **/

Class Sitemap {
	
		public $html ;
		protected $tabs ;
	
	function __construct( $args ) {
		$this->tabs =  $args ;
		$this->html = '<div class="tabs sitemap">';
		$this->go_through_tabs();
	}
	
	function __destruct() {
		$this->html .= '</div>';
	}
	
	
	function go_through_tabs() {
		foreach ( $this->tabs as $method =>$header ){
				$tabbody = $this->$method();
				if ( !empty( $tabbody ) ) {
						$this->html .= $this->retreive_tab( $header, $tabbody  );		
				}
		}
	}
	
	
	function retreive_tab( $header, $tabbody ) {
		$html   = '<h2>' .$header .'</h2>';
		$html   .= '<div class="tabbody">';
		$html   .= $tabbody; 
		$html   .= '</div>';
		return $html;
	}
	
	function authors() {
		$args = array(
					  'exclude_admin' 	=> true,
					  'echo'			=> false
					  ); 
	
		return '<ol>' .wp_list_authors( $args ) .'</ol>';
		
	}
	
	function pages() {
		$args = array(
						'exclude'        => '',
						'title_li'     => '',
						'sort_column'  => 'post_title',
						'echo'			=> false
						);
		return '<ol>' .wp_list_pages( $args ) .'</ol>';
	}
 
		function posts_by_category(){
				$html = '<ol>';
				$cats = get_categories();
				foreach ( $cats as $cat ) {
						$html .= '<h3>' .esc_html( $cat->cat_name ) .'</h3>';
						$html .= '<ul>';
						query_posts('posts_per_page=-1&cat='.$cat->cat_ID);
						
						while ( have_posts() ) {
								the_post();
								$category = get_the_category();
								
								if ( $category[0] -> cat_ID == $cat->cat_ID ) {
									$html .= '<li><a href="'.get_permalink() .'">' .get_the_title() .'</a></li>';
								}
						}
						$html .=  '</ul>';
						$html .= '</li>';
				}
				$html .= '</ol>';
				return $html;
		}	
		
		function posts_in_abc() {
		$html = '<ol>';
		
		$list_posts = new WP_Query( array( 
			'post_type'       => 'post', 
			'posts_per_page'  => -1, 
			'post_status'     => 'publish',
			'order'           => 'ASC',
			'orderby'         => 'title'
			) );
	
		while ( $list_posts->have_posts() ) : $list_posts->the_post(); 
		  
			
			$html .= sprintf( '<li><a href="%1$s">%2$s</a></li>',
				   get_permalink(),
				   get_the_title()
				  );
		endwhile;
			
		$html .= '</ol>';
		return $html;
	}
	
	
	function images() {
		
		$html = '<ol>';
		$query_images_args = array(
		  'post_type' => 'attachment',
		  'post_mime_type' =>'image',
		  'post_status' => 'inherit',
		  'posts_per_page' => -1,
		  'order'           => 'ASC',
		  'orderby'         => 'title'
	  );
			  
		$query_images = new WP_Query( $query_images_args );
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

	function pdfs(){
		$query_pdf = new WP_Query( array(
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

	
}
?>