<?php
/*
 * Filters the title of the page.
 *
 * 1. Modify if paginated (i.e. archives )
 *    Hungarian translation in WP is unexpectable ( i.e. 'Oldal3' ),
 *  2. Remove teh | element from the title,
 *     which represents a line break in HTML
 *
 **/


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


namespace Manduca\filters;


class Title {
    
    public function __construct(){ 
        add_action ( 'init',
                    array( $this, 'place_filter_very_early')
                   );
    }
    public function place_filter_very_early() {
      
        // In case of Yoast Seo active. This hook is called earlier. 
        add_filter(
                   'pre_get_document_title',
                   array( $this, 'filter_title' ),
                    20
                  );
          // If yoast seo not active, this hook will be applied
        add_filter(
                   'document_title_parts',
                   array( $this, 'filter_title' ),
                    1
                  );
        
    }
    
    public function filter_title( $title ) {
        $title=str_replace ('|', '', $title);
        
        if( '' == $title || !is_array( $title )) return ; // If Yoast Seo is not active, the pre_get_document_title hook does'nt needed. 
            global $paged, $page;
                    if( $paged < 2  || is_404() ) {
                    return $title;
            }
            // translators: This string is a replacement of the same string in WP's. Hungarian translation in WP is bad. 
            $string = __( 'Page %d' , 'manduca' );
            $title[ 'page'] = sprintf( $string, $paged );
            return $title;
    }
    
    public static function site_title_with_linebreak () {
		return str_replace (' | ', '<br />', get_bloginfo( 'name' ));
	}
	
	public static function site_title_with_whitespace () {
		return str_replace (' | ', ' ', get_bloginfo( 'name' ));
	}

	
    
}
