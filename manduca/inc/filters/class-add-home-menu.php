<?php
/*
 *  Add homepage when listing page anywhere (e.g. in menu or widget )
 *
 * 
 **/

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

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


namespace Manduca\filters;

class Add_Home_Menu {
		
		
	public function __construct() {
					
			add_filter( 'wp_page_menu_args', array( $this, 'add_home_to_page_menu' ) );
			
	}
	
	

	
	public function add_home_to_page_menu( $args ) {
		if ( ! isset( $args['show_home'] ) ) {
			$args['show_home'] = true;
		}
		return $args;
	}
	
	
}
