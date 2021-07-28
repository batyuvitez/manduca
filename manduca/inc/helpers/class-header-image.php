<?php
/**
 * Get the header image code from WordPress
 *
 *
 * 
**/

/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	
	Copyright (C) 2015-2021  Zsolt Edelényi (ezs@web25.hu)

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

namespace Manduca\helpers; 

class Header_Image {
	
	
	public static function get_header_image (){
		$header_image = get_header_image() ;	
		if( !$header_image ) {
			return FALSE;
		}
		$header_image_data = get_theme_mod( 'header_image_data' ) ;
		if( is_array ($header_image_data) && isset ($header_image_data['attachment_id'])) {
		    $attachment_id=$header_image_data['attachment_id'];
		}
		elseif (is_object ($header_image_data)) {
		    $attachment_id=$header_image_data->attachment_id;
		}
		else {
		    return FALSE ;
		}
		
		$img= wp_get_attachment_image( $attachment_id,
                                            'full',
                                            FALSE,
                                            array( 'class'=>'header-image'));
		if (!$img)
			return FALSE;
		return $img;
	}
	
	
	public static function add_header_video_scripts () 	{
		$video_settings=get_header_video_settings();
		$video_settings['width']=1280;
		$video_settings['height']=800;

		if ( is_header_video_active() && ( has_header_video() || is_customize_preview() ) ) {
			wp_enqueue_script( 'wp-custom-header' );
			wp_localize_script( 'wp-custom-header', '_wpCustomHeaderSettings', $video_settings );
		}
	}	
		
}
