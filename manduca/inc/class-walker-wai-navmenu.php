<?php
/**
 * Apply WAI menubar
 * @see: https://www.w3.org/TR/wai-aria-practices-1.1/examples/menubar/menubar-1/menubar-1.html
 * @since 20.7
 *
 * @ Theme: Manduca - focus on accessibility
 *
 **/

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

 

namespace Manduca;
 
class Walker_Wai_Navmenu extends \Walker_Nav_Menu  {

	public $submenu_ul_id;
	public $menu_item_id;
	public $parent_menu_title;
   
	 public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n" .$indent;
		$output .='<ul role="menu"';
		$output .='class="wai-submenu" ';
		$output.='aria-label="'.$this->parent_menu_title.'">';
		$output.="\n";
    }
	
	
	
	
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
		
		/*Translators: screen reader text saying that there is no more item in the submenu */
        $output .= "$indent</ul>\n";
    }
	
	
	
	
	/*
	* Add menubutton if it has children.
	*/
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
				
				
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		$class_names = join( ' ', array_filter( $classes ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		
		$id = 'menu-item-' . $item->ID;
		$id_html = $id ? ' id="' . esc_attr( $id ) . '"' : '';
		$output .= $indent . '<li role="none"'  . $class_names . '>';
		$item_output  = '';
		if ($this->has_children)
		{
			
			$this->submenu_ul_id='submenu-list-'.$item->ID;
			$this->parent_menu_id=$id;
			$this->parent_menu_title=$item->title;
			$item_output .= '<a ';
			$item_output .= 'role="menuitem" ';
			$item_output .='aria-haspopup="true" ';
			$item_output .='aria-expanded="false" ';
			$item_output .='tabindex="0">';
			$item_output .= $item->title;
			$item_output.=manduca_get_svg (array ('icon'=>'caret-down'));
			$item_output .= '</a>';
		}
		else
		{	
			$atts                 = array();
			$atts['title']        = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target']       = ! empty( $item->target ) ? $item->target : '';
			$atts['rel']          = ! empty( $item->xfn ) ? $item->xfn : '';
			$atts['href']         = ! empty( $item->url ) ? $item->url : '';
			$atts['aria-current'] = $item->current ? 'page' : '';
			//$atts['tabindex']	  = '-1';
			$atts['role']		 ='menuitem';
	
			
			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}
	
					
			
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $item->title;
			$item_output .= '</a>';
			$item_output .= $args->after;
	
			
		}
			$output .= $item_output;
	}


}


 



 
 




 
