<?php
/*
 * This is the main class of the theme
 *
 * Theme Execution begins here:
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


namespace Manduca;

class Theme_Setup {
		
		
	public function init() {
		
		new filters\Controller;
		new Enqueue;
		
		
		new setup\Controller;		
		new widgets\Controller;
		new customizer\Controller;
		new frontend\Controller;
		new backend\Controller;
				
		if ( is_admin() ) {
			new backend\Tiny_Mce;
		}
		
		else {
			// Add accessible more-links Need svg to be loaded. 
			new helpers\More_Links;
		
			// Remove gallery inline style
			add_filter( 'use_default_gallery_style', '__return_false' );
		
			// add alt tag to avatar
			new Avatar_Alt_Text;
			
			//add aria-current="page to the current menu item. 
			new \Accessible_Menu;
			
			new \Search_Functions;
			
		}	
	}
	
}
