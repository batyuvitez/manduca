<?php
/**
 * SVG icons related functions and filters
 *
 * @ Theme: Manduca focus on accessiblilty 
 **/

  /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2021  Zsolt Edelényi (ezs@web25.hu)

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

namespace Manduca;

class Define_Globals {
	
	 
	 public function __construct() {
			   add_action( 'enqueue_block_editor_assets',array( $this, 'load_svg_to_global' ));
				 
			}
	 
	public function load_svg_to_global() {
		  
		  require( get_template_directory() . '/assets/images/svg-icons.php' );
		  
		  /*
				 * Filter of svg icons
				 * 
				 * Filter svg icon array before put it into global variable 
				 *@param array $svg_icons :
				 *							'icon_name ' => [ ['viewBox' => '',
				 *																									'vector'=> '',
				 *																									'path'=>''] ]
				 * */
		  $svg_icons = apply_filters( 'manduca_svg_icons' , $svg_icons );
						 
		  $GLOBALS[ 'svg_icons' ] = $svg_icons;

	 }
	 
	
 }	