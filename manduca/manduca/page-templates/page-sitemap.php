<?php
/**
 * Template Name: Sitemap Page Template
 *
 * @ Theme: Manduca - focus on accessibility
 * @ Version: 17.10.9
 **/

// Add accessible tabs to sitemap page
$accessible_tabs = new accessible_tabs();
unset( $accessible_tabs);
		
 
get_header();

while ( have_posts() ) : the_post(); 
    
    get_template_part( 'template-parts/pages/content', 'page' ); 
                
    //Add content after each page					
    do_action( 'manduca_after_single_page' );
                
        
endwhile; // end of the loop.

$defaults = array(
                    // translators: Authors page in sitemap
                    'authors'               => __( 'Authors', 'manduca' ),
                    // translators: Page in sitemap
                    'pages'                 => __( 'Pages', 'manduca' ),
                    // translators: Category pages in sitemap
                    'posts_by_category' 	=> __( 'Posts by category', 'manduca' ),
                    // translators: Posts in alphabetical order in sitemap
                    'posts_in_abc' 		    =>  __( 'Posts in alphabetical', 'manduca' ),
                    // translators: images attachments in sitemap
                    'images' 				=>  __( 'Images', 'manduca' ),
                    // translators: PDF attachments in sitemap
                    'pdfs' 				    =>  __( 'PDFs', 'manduca' )
                    );
$sitemap = new sitemap( $defaults );	
echo $sitemap->html;

get_footer();