<?php
/**
 * Displays toggle menu button (for mobile)
 *
 */

/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2021  Zsolt Edelényi (ezs@web25.hu)

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

?>
<?php
// Translators: name of the main menu for screen reader users. 
$menu_name = __( 'Main navigation', 'manduca' ) ;	
?>

<button id="menu-toggle"
		class="menu-toggle link-button"
		aria-hashpopup="false"
		aria-controls="primary-nav-menu">
		<?php 	echo manduca_get_svg( array( 'icon' => 'bars' ) );
		echo manduca_get_svg( array( 'icon' => 'close' ) ); ?>
		<span class="desktop-text"><?php echo $menu_name;?></span>
		
		
