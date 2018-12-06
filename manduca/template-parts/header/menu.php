<?php
/**
 * Displays top navigation
 *  *
 * @ Manduca - focus on accessibility
 * @ since 17.4
 * @last modification: 18.10.16
 */

?>
<?php
	// Translators: name of the main menu for screen reader users. 
	$menu_name = __( 'Main navigation', 'manduca' ) ;
	
	printf( '<button id="menu-toggle" class="menu-toggle" aria-label="%3$s" accesskey="k" aria-expanded="false">%1$s%2$s<span>%3$s</span></button>',
		   manduca_get_svg( array( 'icon' => 'bars' ) ),
		   manduca_get_svg( array( 'icon' => 'close' ) ),
		   $menu_name
		  );
?>

<div id="site-header-menu" class="site-header-menu">
	
	<?php if ( has_nav_menu( 'primary' ) ) : ?>
	
		<div id="site-navigation" class="main-navigation">
			
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
			
		</div>
		
	<?php endif; ?>
	
</div>
<div class="clearfix"></div>
