<?php
/**
 * Generate  and display breadcrumb
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
**/

class manduca_breadcrumb extends breadcrumb {
    
    
    
    public function customize_breadcrumb() {
	
        $this->templates = array(
            'before' 		=> '<ul>',
            'after' 		=> '</ul>',
            'standard' 		=> '<li>%1$s %2$s</li>',  // %1 :breadcrumb link %2: separator 
            'current' 		=> '<li class="current">%s</li>',
            'link' 			=> '<a href="%s"><span >%s</span></a>'
        );
        $this->options = array(
          //Post Type term as index
          'show_pta'		=>false,
          
          // which taxonomy to show
          'show_tax'   => 'category',
          
          // show hierarchical terms for post types
         'show_htfpt' => true, 							
         
         'separator'		=> manduca_get_svg( array( 'icon' => 'arrow-right-double' ) ) ,
         
         'posts_on_front' => 'posts' == get_option( 'show_on_front' ) ? true : false,
         
         // The ID of the page that displays posts. Useful when show_on_front's value is page
         'page_for_posts' => get_option( 'page_for_posts' ),  
         
         // support pagination
         'show_pagenum' => true, 						
        );
        
        $this->strings  = array(
         // Translators: Breadcrumb home page.
         'home' => __( 'Home', 'manduca' ),
         
         //Translators: search page singular in breadcrumb
         'search' => __( '%s hits of searching for <em>%s</em>', 'manduca' ),
         
         //Translators: Breadcrumb paginated pages
         'paged' => __( 'Page %d', 'manduca' ),
         
         //Translators: Breadcrumb page not found text
         '404_error' => __( 'Page not found', 'manduca' )
		);
	}
}




//translators: Breadcrumb prefix text: 
$prefix_text=__( 'You are here:', 'manduca' );

//Translators: Title of breadcrumb navigation (for screen reader users)
$name=__('breadcrumb', 'manduca');       

$breadcrumb = new manduca_breadcrumb();
$breadcrumb->customize_breadcrumb();

?>


<div id="breadcrumb" class="breadcrumb" >
        <nav aria-label="<?php echo $name; ?>">
            <span><?php echo $prefix_text; ?></span>
            <?php echo $breadcrumb->output(); ?>
        </nav>
</div>