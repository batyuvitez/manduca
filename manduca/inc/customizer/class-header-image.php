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

class Header_Image
{
	
	
	public function __construct ()
	{
		add_action( 'after_setup_theme', array( $this, 'manduca_custom_header_setup'));
		add_action( 'customize_register', array( $this, 'customize_register' ));
		add_filter( 'header_video_settings', array( $this, 'header_video_settings'));
	}
	
	
	
	public function customize_register( $wp_customize ) {
		$wp_customize->remove_control( 'custom_css' );
	}
	
	
	public function header_video_settings( $settings ) {
		  $settings['minWidth'] = 680;
		  $settings['minHeight'] = 400;
		  return $settings;
	}
	
	
	public function manduca_custom_header_setup() {
		$args = array(
			// Text color and image (empty to use none).
			'default-text-color'     => '232323',
			'default-image'          => '',
	
			// Set height and width, with a maximum value for the width.
			'height'                 => 200,
			'width'                  => 1070,  /* 80rem */
			'max-width'              => 1070,
	
			// Support flexible height and width.
			'flex-height'            => true,
			'flex-width'             => true,
	
			// Random image rotation off by default.
			'random-default'         => false,
	
			// Callbacks for styling the header and the admin preview.
			'admin-preview-callback' => array ($this, 'header_image'),
			//since 21.2
			'video'					 =>TRUE);
		
		/*
		 *Filter header image settings
		*/
		$args = apply_filters( 'manduca_header_image_args', $args );
		
		add_theme_support( 'custom-header', $args );
	}
	
	
	
	public function header_image() {
		?>
		<div id="heading">
			<?php
			if ( ! display_header_text() ) {
				$style = ' style="display:none;"';
			}
			else {
				$style = ' style="color:#' . get_header_textcolor() . ';"';
			}
			?>
			<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"  tabindex="-1"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 id="desc" class="displaying-header-text"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></h2>
			<?php $header_image = get_header_image();
			if ( ! empty( $header_image ) ) : ?>
				<img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
			<?php endif; ?>
		</div>
	<?php
	}

	
}