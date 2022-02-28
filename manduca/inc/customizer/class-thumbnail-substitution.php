<?php
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
namespace Manduca\customizer;

class Thumbnail_Substitution
{
	
	
	public function __construct () {
		
		add_action( 'customize_register', array( $this, 'thumbnail_substitution' ));
	
	}
	
	
	
	public function thumbnail_substitution( $wp_customize ) {
		
		$wp_customize->add_section( 'thumbnail_substitution', array(
			//translators: the title of the thumbnail substitution customizer section
            'title' => __('Post thumbnail substitution', 'manduca'),
            'description' => __( 'This image appears in excerpt if no thumbnail assigned', 'manduca'),
            'priority' => 10,
            'capability' => 'edit_theme_options', 
            'theme_supports' => '',
            'active_callback' => ''
			) );
	    
		$wp_customize->add_setting( 'thumbnail_substitution', array(
			'default' => get_theme_file_uri('assets/images/manduca.jpg'), // 
			'sanitize_callback' => 'esc_url_raw'
		));
 
		$control = array(
			'label' => __('Post thumbnail substitution', 'manduca'),
			'priority' => 20,
			'section' => 'thumbnail_substitution',
			'settings' => 'thumbnail_substitution',
			'button_labels' => array(// All These labels are optional
						'select' => __( 'Select thumbnail substitution', 'manduca'),
						'remove' => __( 'Remove thumbnail substitution', 'manduca'),
						'change' => __( 'Change thumbnail substitution', 'manduca')
						) );
		
		$args= new \WP_Customize_Image_Control( $wp_customize, 'thumbnail_substitution', $control);
		$wp_customize->add_control( $args );
		
	}
	
}