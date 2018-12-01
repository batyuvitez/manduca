<?php
/**
 * Display content of page
 *
 * @ Theme: Manduca - focus on accessibility
 * @ Since 1.0
 **/

get_header();

	while ( have_posts() ) : the_post(); 
		
        get_template_part( 'template-parts/pages/content', 'page' ); 
					
			//Add content after each page					
			do_action( 'manduca_after_single_page' );
					
			comments_template(); 
			
	endwhile; // end of the loop.
				
get_footer();
?>