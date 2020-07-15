<?php
/**
 * Displays header/site/main navigation bar 
 * 
 */

/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2020  Zsolt Edelényi (ezs@web25.hu)

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

if ( !has_nav_menu('primary'))
	return;
 

	//choose which menü you want to apply.
	//Until 20.7 default menu was "megamenu"
	$menu_types=array( 'wai', 'megamenu');
	$menu_type=$menu_types[0];
	
	// Translators: name of the main menu for screen reader users. 
	$menu_name = __( 'Main navigation', 'manduca' ) ;
	
	$menu_toggle_html=sprintf( '<button id="menu-toggle" class="menu-toggle link-button" aria-label="%3$s" aria-expanded="false">%1$s%2$s<span>%3$s</span></button>',
		   manduca_get_svg( array( 'icon' => 'bars' ) ),
		   manduca_get_svg( array( 'icon' => 'close' ) ),
		   $menu_name
		  );
	
	$aria_label='aria-label="'.$menu_name.'"';
		$items_wrap='<ul ';
		$items_wrap.='id="%2$s" ';
		$items_wrap.='role="menubar"';
		$items_wrap.=$aria_label;
		$items_wrap.='>%3$s</ul>';
		
?>


<button
	id="menu-toggle"
	class="menu-toggle link-button"
	aria-label="<?php echo $menu_name; ?>"
	aria-expanded="false" >
	<?php 	echo manduca_get_svg( array( 'icon' => 'bars' ) );
			echo manduca_get_svg( array( 'icon' => 'close' ) );
	?>
	<span><?php echo $menu_name; ?></span>
</button>
<div id="site-header-menu" class="site-header-menu">
	<div id="navigation-bar" class="main-navigation">
		<?php if ($menu_type==='wai') : ?>
			<nav <?php echo $aria_label; ?>>
					<?php
						$args = array(
						   'theme_location'  => 'primary',
						   'menu'            => 'primary Menu',
						   'menu_class'      => 'wai-nav-menu',
						   'container'       => false,
						   'items_wrap'      => $items_wrap,
						   'depth'           => 3,
						   'walker'          => new \Manduca\Walker_Wai_Navmenu
						   );
						wp_nav_menu( $args );
					?>
				</nav>
				<script type="text/javascript">
					var menubar = new Menubar(document.getElementById('wai-nav-menu'));
					menubar.init();
				</script>	
		
		<?php elseif ($menu_type==='megamenu') : ?>
			<nav id="megamenu" class="megamenu" aria-label="<?php echo $menu_name; ?>">
					<?php
						$args = array(
						   'theme_location'  => 'primary',
						   'menu'            => 'primary Menu',
						   'menu_class'      => 'nav-menu',
						   'container'       => false,
						   'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
						   'depth'           => 3,
						   'walker'          => new Manduca_accessible_walker() 
						   );
						wp_nav_menu( $args );
					?>
			</nav>
		<?php endif; ?>
	
	</div>
</div>
<div class="clearfix"></div>
