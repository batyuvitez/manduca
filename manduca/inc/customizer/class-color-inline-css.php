<?php
/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	   Copyright (C) 2015-2021  Zsolt Edelényi (ezs@web25.hu)

    Source code is available at https://github.com/batyuvitez/manduca
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

 
namespace Manduca\customizer;
 
class Color_Inline_Css {
		
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this,  'inline_css' ) );
     }
     
    public function inline_css() {
        $custom_css = $this->site_title_color ();
        $custom_css .= $this->background_color ();
        if (!empty ($custom_css)) {
            $r=wp_add_inline_style( 'manduca-stylesheet', $custom_css );
        }
        
    }
    
    
    public function site_title_color() {
        $text_color = get_theme_mod( 'header_textcolor', '' );
        if (  empty( $text_color ) ) {
            return '';
        }
        return ':root { --site-title: #' . $text_color .'}';
    }
    
    public function background_color() {
        $color = get_background_color();
        if (  empty( $color ) ) {
            return '';
        }
        return ':root { --default-background: #' . $color .'}';
    }
     
}
