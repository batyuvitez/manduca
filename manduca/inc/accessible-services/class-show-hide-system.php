<?php
/**
 * Add accordion script to page and customize
 *
 * This function should be added to footer when needed. 
 *
 * @ Theme: Manduca - focus on accessibility
 * &since 17.9.5
 *
 * 
 * Remark: The is_page_template WP function do not work (why?),
 * consequeintly I could not enquing scripts.
 * This is the reason I add directly to this page. 
 * 	
 */
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
 

namespace Manduca\accessibleServices;
	
class Show_Hide_System {
		  
				public $accordion_args;
		  
				public function __construct( $args ) {
								$this->accordion_args = $args;
								add_action( 'wp_enqueue_scripts', array(  $this, 'accordion' ) , 990 );					
		  }
		  
		  public function accordion() {
								wp_enqueue_style( 'manduca-accordion-style', get_template_directory_uri() . '/assets/css/accordion.css'  );
								wp_enqueue_script( 'manduca-accordion-script', get_template_directory_uri() . '/assets/js/accordion.min.js', array( 'jquery' ), '', 'true'); 
								wp_localize_script( 'manduca-accordion-script', 'manducaAccordionArgs', $this->accordion_args );	  
		  }
 }