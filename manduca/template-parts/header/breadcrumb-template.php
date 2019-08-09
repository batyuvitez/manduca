<?php
/**
 * Generate breadcrumb
 * Header template file
 * 
 * @ Theme: Manduca - focus on accessibility 
 * @ Since 17.10.7
 **/

 
 class manduca_breadcrumb extends breadcrumb {
    
    function __construct() {
        $args = $this->customize_breadcrumb();
    }
    
    function customize_breadcrumb() {
	
		$this->templates = array(
			'before' 		=> '<nav id="breadcrumb" class="breadcrumb"><span>' .__( 'You are here:', 'manduca' ) .'</span><ul>',
			'after' 		=> '</ul></nav>',
			'standard' 		=> '<li>%1$s %2$s</li>',  // %1 :breadcrumb link %2: separator 
			'current' 		=> '<li class="current">%s</li>',
			'link' 			=> '<a href="%s"><span >%s</span></a>'
		);
		$this->options = array(
		 	'show_pta'		=>false,						//Post Type term as index
    'show_tax'   => 'category', 							// which taxonomy to show
			'show_htfpt' => true, 							// show hierarchical terms for post types
			'separator'		=> manduca_get_svg( array( 'icon' => 'arrow-right-double' ) ) ,
			'posts_on_front' => 'posts' == get_option( 'show_on_front' ) ? true : false,
			'page_for_posts' => get_option( 'page_for_posts' ),  // The ID of the page that displays posts. Useful when show_on_front's value is page
			'show_pagenum' => true, 						// support pagination
		);
		
		$this->strings  = array(
			// Translators: Breadcrumb home page.
			'home' => __( 'Home', 'manduca' ),
			//Translators: search page singular in breadcrumb
			'search' => __( '%s hits of searching for <em>%s</em>', 'manduca' ),
			//Translators: Breadcrumb paginated pages
			'paged' => __( 'Page %d', 'manduca' ),
			//Translators: Breadcrumb page not found text
			'404_error' => __( 'Page not found', 'manduca' )
		);
		
	}
}
$breadcrumb = new manduca_breadcrumb();
echo $breadcrumb->output();
unset( $breadcrumb );
