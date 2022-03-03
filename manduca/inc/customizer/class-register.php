<?php
/*
 *  This file is part of WordPress theme named Manduca - focus on accessibility.
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
 
class Register {
		
    public function __construct() {
        add_action( 'customize_register', array( $this,  'customize_register' ) );
     }
     
    protected function sanitize_text_input( $input ) {
     $output = strip_tags( stripslashes( $input ) );  
       return $output;
       } 
      
    public function customize_register( $wp_customize ) {
        $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
        $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
        $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
        $wp_customize->remove_control( 'custom_css' );  
        $wp_customize->add_setting( 'manduca_copyright_text', array(
         'default' => get_bloginfo(),
         'sanitize_callback' => 'manduca_sanitize_text_input'
         ) );
        $wp_customize->add_control( new \WP_Customize_Control( $wp_customize, 'manduca_options', array(
         'label'        =>  __( 'Copyright text', 'manduca' ),
         'section'    => 'title_tagline',
         'settings'   => 'manduca_copyright_text',
        ) ) );
       }
        
}
