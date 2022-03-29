<?php
/*
 *  WordPress Themes Supports
 *@see: /*https://wordpress.stackexchange.com/questions/287830/remove-type-attribute-from-script-and-style-tags-added-by-wordpress
*/
/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022 Zsolt Edelényi (ezs@web25.hu)

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

namespace Manduca\setup;

class Theme_Support {
	
	
	public function __construct ()	{
		add_action( 'after_setup_theme', array($this, 'theme_supports' ) );
	}
	
	
	/*
	 * Add theme checks
	 * For the sake of theme check, this cannot be with cycles.
	 **/
	public function theme_supports() {
		// Styles the visual editor with editor-style.css
		add_editor_style();
		
		//Makes translation-ready
		load_theme_textdomain( 'manduca', get_template_directory() . '/assets/lang' );
		
		 //Supports custom background color and image 
		add_theme_support( 'automatic-feed-links');
		add_theme_support( 'html5', array(	'search-form',
												'comment-form',
												'comment-list',
												'caption',
												'gallery',
												'script', 
												'style') );
		add_theme_support( 'title-tag');
		add_theme_support( 'custom-background', array('default-color' => 'f3f3f5'));
		add_theme_support( 'custom-logo', array(
								'height'               => 400,
								'width'                => 400,
								'flex-height'          => true,
								'flex-width'           => true,
								'header-text'          => array( 'site-title', 'site-description' ),
								'unlink-homepage-logo' => true ) );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		
		
	}
	
}



