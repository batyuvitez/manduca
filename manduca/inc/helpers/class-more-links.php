<?php
/**
 * Customize more-links to be accessible
 
 **/

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

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
use Manduca;

Class More_Links {
   
   
      
    protected $args;
    
    public function __construct() {
    
        add_filter( 'the_content_more_link', array( $this, 'more_link_create_html' ) );
       add_filter( 'excerpt_more', array( $this, 'more_link_create_html' ) );
       add_filter('get_the_excerpt', array( $this , 'manual_excerpt' ) );
    }
  
  
    
    public function more_link_create_html() {
    
      ob_start ();
      get_template_part ('/template-parts/posts/morelink');
      return ob_get_clean ();
     }
  
  
  
    public function manual_excerpt ( $excerpt ) {
     
        global $post;
        if( $post->post_excerpt ) {
            return $excerpt .$this->more_link_create_html();
        } else {
            return $excerpt;
        }
    }
	
	
 }