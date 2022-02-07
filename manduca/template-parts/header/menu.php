<?php
/**
 * Displays top navigation (main navigation, site-navigation)
 *
 * 
 */

/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

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

use Manduca\walkers as walk;

// Translators: name of the main menu for screen reader users. 
$menu_name = __( 'Main navigation', 'manduca' ) ;	

?>
<div id="site-header-menu" class="site-header-menu">
	
	<?php if ( has_nav_menu( 'primary' ) ) : ?>
	
		<div id="site-navigation" class="main-navigation">
			
			<nav id="megamenu"
				 class="megamenu default-scheme"
				 aria-label="<?php echo $menu_name; ?>">
				<?php
					wp_nav_menu (array(
					   'theme_location'  => 'primary',
					   'menu'            => 'primary Menu',
					   'menu_class'      => 'nav-menu',
					   'menu_id'		 => 'primary-nav-menu',
					   'container'       => false,
					   'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					   'depth'           => 4,
					   'walker'          => new walk\Nav_Menu_Walker() 
					   ));
				?>
				
				<?php get_template_part( '/template-parts/header/toolbarbutton' ); ?>
				
				<button id="primary-nav-close" class="modal-window-close"><?php manduca_icon( 'close' ).'&nbsp;'; _e( 'Close' ); ?></button>
			</nav>
			
		</div>
		
	<?php endif; ?>
	
</div>
