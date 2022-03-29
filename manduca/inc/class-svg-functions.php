<?php
/**
 * Create SVG icon markup
 * see: setup\Define_Globals
 *
 **/

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

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

namespace Manduca; 

class SVG_Functions {
	 
		protected $svg_name ;
	 
	 public function __construct( $args ) {
			   $this->svg_name = $args;
			}
			
			/**
			 * Return SVG markup.
			 *
			 * @param array $args {
			 *     Parameters needed to display an SVG.
			 *
			 *     @type string $icon  Required SVG icon filename.
			 * }
			 * @return string SVG markup.
			 */
	 public function SVG_Markup( ) {
			  // Make sure $this->svg_name are an array.
			  if ( empty( $this->svg_name ) ) {
						
				  /* translators: Error message if there no array in the parameter */
				  trigger_error ( __( 'Please define default parameters in the form of an array.', 'manduca' ) , E_USER_WARNING ) ;
						return;			  
					}
		  
			  // Define an icon.
			  if ( false === array_key_exists( 'icon', $this->svg_name ) ) {
				  /* translators: Error message if there is no icon exist with the given name */
				  trigger_error ( __( 'Please define an SVG icon filename.', 'manduca' ), E_USER_WARNING );
				  return;
			  }
			  // Set defaults.
			  $defaults = array(
				  'icon'        => '',
				  'fallback'    => false,
			  );
		  
			  // Parse args.
			  $this->svg_name = wp_parse_args( $this->svg_name, $defaults );
			   $svg_icons = $GLOBALS[ 'svg_icons' ];
		  
			  // Set WAI_ARIA
			  //@see: https://www.w3.org/WAI/WCAG21/Techniques/aria/ARIA24.html
			  $aria_hidden = ' aria-hidden="true"';
			  $aria_role = ' role="img"';
		  
			  // Set ARIA.
			  $aria_labelledby = '';
		  
			  
			  
		  
			  /*
			   * Display the icon.
			   *
			   * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
			   *
			   * See https://core.trac.wordpress.org/ticket/38387.
			   *
			   * The 'xlink:href' is depretiated since SVG 2, but needed because browsers do not support href attr. 
			   *  
			   */
			  if( isset ( $svg_icons [ esc_html( $this->svg_name['icon'] ) ] ) ) {
										$svg_item 	=  $svg_icons [ esc_html( $this->svg_name['icon'] ) ] ;
			  }
			  else {
					return;
			  }
			   
			   $vector		= $svg_item[ 'vector' ]  ;
							  
			   $viewBox		= $svg_item[ 'viewBox' ];
			   $svg  = sprintf( '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="icon-%1$s" viewbox="%2$s" %3$s %4$s %6$s >%5$s</svg>',
							   esc_attr( $this->svg_name['icon'] ),
							   $viewBox,
							   $aria_hidden,
							   $aria_labelledby,
							   $vector,
							   $aria_role //since 21.2
							 );
			  
			  return $svg;
	 }
	 
	
	
				/*
					*Call method
					*Invoke the SVG complier and  return HTML code of accessible icon
					*
					*@return string: HTML code
					**/
				public function Return_HTML() {
									return $this->SVG_Markup();
				}
	}	