<?php
/**
 * Add html markup to main navigation with walker
 *
 **/

/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *  Copyright (C) 2015-2021  Zsolt Edelényi (ezs@web25.hu)

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


class Manduca_accessible_walker extends Walker_Nav_Menu  {

	protected $aria_controls='';
	protected $aria_labelledby='';
   
	 public function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
        $output .= "\n" .$indent .'<div class="sub-nav lighter-scheme ';
		$output .= 'level-'.$depth.'">';
		$output .= '<ul role="menu" id="' .$this->aria_controls .'">';
		$output .= "\n";
    }
	
	
	
	
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
		$output .= $indent.'</ul>'."\n".'</div>';
		$output .= "\n";
    }
	
	
	
	
	/*
	* @since 19.4
	* Attach svg icon if there is submenu
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
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		$submenu= (bool) in_array( 'menu-item-has-children', $item->classes, true );
		if ($submenu) {
			$this->aria_controls='control-' . $item->ID;
			$this->aria_labelledby='title-'.$item->ID;
		}
		else {
			$this->aria_controls='';
			$this->aria_labelledby='';
		}
		
		$output .= $indent . '<li' . $id . $class_names .'>';

		$atts                 = array();
		$atts['title']        = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target']       = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']          = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']         = ! empty( $item->url ) ? $item->url : '';
		$atts['aria-current'] = $item->current ? 'page' : '';
		$atts ['id']		  = $submenu ? $this->aria_labelledby : '';
		$atts ['class']		  = $submenu ? 'has-dropdown-toggle ': '';
		$atts ['class']		  .= 'level-'.$depth;
		$atts ['class']		  .= ' menu-link';
		
		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

				
		$item_output  = $args->before;
		if( $submenu) {
			$item_output .='<div class="submenu-container ';
			$item_output .='level-'.$depth.'">';
		}
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . $item->title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= "\n";
		if( $submenu) {
			$item_output .='<div class="distance-keeper" aria-hidden="true"></div>';
			$item_output .= '<button class="dropdown-toggle level-'.$depth.'" ';			
			$item_output .= 'aria-haspopup="true" ';
			$item_output .= 'aria-controls="'. $this->aria_controls.'" ';
			$item_output .= 'aria-labelledby="'.$this->aria_labelledby .'" ';
			$item_output .= 'aria-expanded="false"';
			$item_output .= '>';
			$item_output .= manduca_get_svg( array( 'icon' => 'caret-down'));
			$item_output .= manduca_get_svg( array( 'icon' => 'close'));
			$item_output .='</button>';
			$item_output .= "\n";
			$item_output .= "</div>";  //submenu-container
			$item_output .= "\n";
		}
		$item_output .= $args->after;

		
		$output .= $item_output;
	}


}


 



 
 




 
