<?php
/**
 * Template Name: Parent of pages template
 *
 * Display subpages after the content of the page. 
 * Should be use in parent pages e.g. main menu elements. 
 **/

 /* This file is part of Manduca
 *
 *  Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)
 *  
 *  Manduca is a free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program in /assets/docs/licence.txt.  If not, see <https://www.gnu.org/licenses/>.
*/
 
get_header();
	
while ( have_posts() ) :
    the_post(); 

    printf('<article id="post-%1$s" class="%2$s">',
           get_the_ID(),
           join( get_post_class() )
          );
    printf( '<header><h1>%s</h1></header>',
        get_the_title()
        );
    get_template_part( '/template-parts/postlink', 'edit' ) ;
        
    echo '<div class="entry-content">';
        the_content();
    
    echo '<ul class="entry-content">';
    wp_list_pages( array (
        'child_of' 		=> $post->ID,
        'order'			=>'ASC',
        'orderby'		=>'menu_order',
        'depth'			=> 1,
        'title_li'		=>''
        )
    );
    echo '</ul>';
    echo '</div>';
    echo '</article>';
    
    //Add content after each page		
    do_action( 'manduca_after_single_page' );

endwhile; 
			
get_footer();