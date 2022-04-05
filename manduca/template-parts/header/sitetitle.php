<?php
/**
 * Template of site title and blog description 
 *
 *
 * */

 /*
  * identify the front page is not so simple: 
    On the site front page, is_front_page() will always return TRUE, regardless of whether the site front page displays the blog posts index or a static page.
    On the blog posts index, is_home() will always return TRUE, regardless of whether the blog posts index is displayed on the site front page or a separate page.
    
*/
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
?>
<?php $site_title = str_replace (' | ', '<br />', get_bloginfo( 'name' ) )  //replace | with line-break  since @17.4 ; ?>
 
    
<div id="site-title" class="site-title">
    

        <?php if( is_front_page() || is_home () && empty( get_query_var('paged'))) : ?>
        
            <?php if ( function_exists( 'the_custom_logo' ) ) : ?>
 
                <?php the_custom_logo(); ?>
 
            <?php endif; ?>
        
            <span class="display-site-title"><?php echo $site_title; ?> </span>
        
        <?php else :  ?>

            <a href="<?php echo esc_html (home_url( '/' ));  ?>" rel="home">
                <span class="screen-reader-text"><?php _e( 'Jump to homepage' , 'manduca' ) ; ?></span>
                    <?php if ( function_exists( 'the_custom_logo' ) ) : ?>
 
                        <?php the_custom_logo(); ?>
 
                    <?php endif; ?>

                <span class="display-site-title"><?php echo $site_title; ?></span>
            </a>

        <?php endif; ?>
    
</div>