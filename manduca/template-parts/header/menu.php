<?php
/**
 * Displays top navigation
 *  *
 * @ Manduca - focus on accessibility
 * @ since 17.4
 */

?>
<?php
	printf( '<button id="menu-toggle" class="menu-toggle" aria-expanded="false">%1$s%2$s<span>%3$s</span></button>',
		   manduca_get_svg( array( 'icon' => 'bars' ) ),
		   manduca_get_svg( array( 'icon' => 'close' ) ),
		   __( 'Menu', 'manduca' )
		  );
?>

<div id="site-header-menu" class="site-header-menu">
	<?php if ( has_nav_menu( 'primary' ) ) : ?>
		<div id="site-navigation" class="main-navigation">        
			<?php
				$args = array(
				   'theme_location'  => 'primary',
				   'menu'            => 'primary Menu',
				   'menu_class'      => 'nav-menu',
				   'container'       => 'nav',
				   'container_class' => 'megamenu',
				   'container_id'    => 'megamenu',
				   'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
				   'depth'           => 3,
				   'walker'          => new Manduca_accessible_walker() 
				   );
				wp_nav_menu( $args );
			?>
		</div>
		
	<?php endif; ?>
</div>
<div class="clearfix"></div>
