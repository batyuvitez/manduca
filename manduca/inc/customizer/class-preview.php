<?php
/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	   Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

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
 
 class Preview {
		
    public function __construct() {
     // Enqueue Javascript postMessage handlers for the Customizer.
     add_action( 'customize_preview_init', array( $this, 'customize_preview_js' ) );
    }
     
      
    public function customize_preview_js() {
      wp_enqueue_script( 'manduca-customizer', get_template_directory_uri() . '/assets/js/theme-customizer.js', array( 'customize-preview' ), '20141120', true );
    }
}
