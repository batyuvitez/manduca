<?php
/**
 * Template Name: Accessible tab page template
 *
 * Add accessible tabs to sitemap page
 *
 * How to use: <div class="tabs">
 *             <h2>Tab #1 label</h2>
 *             <div class="tabbody">tab #1 content</div>
 *             <h2>Tab #2 label</h2>
 *             <div class="tabbody">tab #2 content</div>
 *         </div>
 *
 */

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2018  Zsolt Edelényi (ezs@web25.hu)

    This program is free software: you can redistribute it and/or modify
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