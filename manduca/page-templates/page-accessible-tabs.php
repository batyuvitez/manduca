<?php
/**
 * Template Name: Accessible tab page template
 *
 * Add accessible tabs to sitemap page
 *
 * @Usage: <div class="tabs">
 *             <h2>Tab #1 label</h2>
 *             <div class="tabbody">tab #1 content</div>
 *             <h2>Tab #2 label</h2>
 *             <div class="tabbody">tab #2 content</div>
 *         </div>
 *
 * @ Theme: Manduca - focus on accessibility
 * @ since 17.9.2
 *
 */

// Insert scripts, css to footer.  
$accessible_tabs = new Accessible_Tabs;
$accessible_tabs->add_hooks_to_wp();


get_header();

	while ( have_posts() ) : the_post(); 
		
        get_template_part( 'template-parts/pages/content', 'page' ); 
					
			//Add content after each page					
			do_action( 'manduca_after_single_page' );
					
			comments_template(); 
			
	endwhile; // end of the loop.
				
get_footer();