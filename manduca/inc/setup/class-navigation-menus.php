<?php
/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022 Zsolt Edelényi (ezs@web25.hu)

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

namespace Manduca\setup;

class Navigation_Menus {
	
						
	
	public function __construct ()	{
		add_action( 'after_setup_theme', array($this, 'nav_menus' ) );
	}
	
	
	
	public function nav_menus() {
		//Register navigation menus
		
		//translators: name of main menu for admin and for screen reader users also
		register_nav_menu( 'primary', __( 'Main navigation', 'manduca' ) );
		//translators: name of menu in footer for admin and screen reader users also
		register_nav_menu( 'footer', __( 'Footer navigation', 'manduca' ) );
		
		
	}
	
}



