<?php
/**
 * Template Name: Collapsable paragraph page template
 *
 *
 * @ Usage: content after headings <h2>, <h3> etc. are collapsable with jQuery
 *
 * @ Theme: Manduca - focus on accessibility
 * @ since 17.10.3
 *
 **/

 $args = 	array(
                    'icon'  	=> manduca_get_svg( array( 'icon' => 'caret-down', 'fallback' => true ) ),
					'selector'	=> '.entry-content > h2',
                    'header'    => 'h2'
                );
 
$accordion = new accordion( $args );
$accordion->add_hook_to_wp();

get_header();

	while ( have_posts() ) : the_post(); 
		
        get_template_part( 'template-parts/pages/content', 'page' ); 
					
			//Add content after each page					
			do_action( 'manduca_after_single_page' );
					
			
	endwhile; // end of the loop.
				
get_footer();