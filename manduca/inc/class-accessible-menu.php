<?php
//add aria-current="page to the current menu item. 
class Accessible_Menu {
    
    public function __construct() {
        
			add_filter( 'nav_menu_link_attributes',
                       array( $this, 'add_aria_to_current_menu' ) ,
                       10,
                       3 );
			add_filter(
					   'walker_nav_menu_start_el',
					   array( $this, 'change_current_menu_item' ),
					   4,
					   12
					  );
    }
    
    public function change_current_menu_item( $item_output, $item, $depth, $args  ) {
		if( in_array( 'current-menu-item', $item->classes ) ) {
				$item_output = sprintf( '<span class="current-menu-item">%s %s</span>',
									   manduca_get_svg( array( 'icon' => 'current') ),
									   $item->title
									   );
		}
		return $item_output;
	}
	
	public function add_aria_to_current_menu( $atts, $item, $args ) {
        
     
		if( in_array( 'current-menu-item', $item->classes ) ) {
			$atts['aria-current'] = 'page';
		}
		return $atts;
	}
}