<?php
/**
 * Template Name: Collapsable paragraph page template
 *
 *
 *@alias: acccessible show hide system
 *@Usage: see docs/how-to
 *
 **/

	/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

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

use Manduca\accessibleServices as serv;

$args = 	array(
					'icon'  	=> manduca_icon( 'caret-down', false ),
					'selector'	=> '.entry-content > h2',
					'header'    => 'h2',
					'skip'		=>'.not-to-collapse'
					);
 
new serv\Show_Hide_System( $args );

get_header();

	while ( have_posts() ) : the_post(); 
		
        get_template_part( 'template-parts/pages/content', 'page' ); 
					
			//Add content after each page					
			do_action( 'manduca_after_single_page' );
					
	endwhile; // end of the loop.
				
get_footer();