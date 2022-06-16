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

class Custom_Logo {
   
   public function __construct() {
      
         add_filter( 'get_custom_logo', array ($this, 'change_logo_class' ) );
   
   }

   public function change_logo_class( $html ) {
    
      $html=str_replace ( '<img ', '<img class="custom-logo-image" ', $html);
      
      return $html;
        
   }

   
}