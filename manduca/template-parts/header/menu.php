<?php
/**
 * Displays top navigation
 * 
 * @ since 17.4
 * @last modification: 18.10.16
 */

/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2018  Zsolt Edelényi (ezs@web25.hu)

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
	
	printf( '<button id="menu-toggle" class="menu-toggle link-button" aria-label="%3$s" aria-expanded="false">%1$s%2$s<span>%3$s</span></button>',
		   manduca_get_svg( array( 'icon' => 'bars' ) ),
		   manduca_get_svg( array( 'icon' => 'close' ) ),
		   $menu_name
		  );
?>

<div id="site-header-menu" class="site-header-menu">
	
	<?php if ( has_nav_menu( 'primary' ) ) :
	$aria_label='aria-label="'.$menu_name.'"';
	$items_wrap='<ul ';
	$items_wrap.='id="%2$s" ';
	$items_wrap.='role="menubar"';
	$items_wrap.=$aria_label;
	$items_wrap.='>%3$s</ul>';
	?>
	
		<div id="site-navigation" class="main-navigation">
			
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
		</div>
		
	<?php endif; ?>
	
</div>
<div class="clearfix"></div>
