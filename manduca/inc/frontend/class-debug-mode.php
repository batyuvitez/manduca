<?php

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

namespace Manduca\frontend;

class Debug_Mode {
   
   public function __construct() {
      
      if (defined ('WP_DEBUG') && WP_DEBUG===TRUE) {
         add_filter ( 'document_title_parts', array ($this, 'debug_title' ));
         add_filter ('get_site_icon_url', array ($this, 'debug_favicon'));
      }
   }
   
   
   
   public function debug_title( $title ) {
      //translators: test text in case of debug mode
      $text=__( 'DEBUG', 'manduca');
      $title['title']=$text.' '.$title['title'];
      return $title;
   }
   
   /*
    *Dont use because browser is willing to cache this when you exit debug mode
    **/
   public function debug_favicon ($favicon_url) {
       return get_template_directory_uri() . '/assets/images/debug-mode-favicon.jpg';
   }

   
}