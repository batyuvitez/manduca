<?php
/*
 *Footer site info
 *
 * for duplicating HTML5 and ARIA landmark:
 * @see: https://dequeuniversity.com/assets/html/jquery-summit/html5/slides/landmarks.html
 **/

 
 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
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

    
    // Translators: name of the footer menu for screen-reader users. 
    $menu_name = __( 'Footer navigation', 'manduca' );
    ?>
    
    <?php if ( has_nav_menu( 'footer' ) ) : ?>
        
        <nav id="footer-navigation"
             class="footer-navigation"
             aria-label="<?php echo $menu_name; ?>">
            <?php
                echo wp_nav_menu(array (
                    'echo' => false,
                    'fallback_cb' => '__return_false',
                    'container'       	=> false,
                    'theme_location' 	=> 'footer',
                    'menu_class' 		=> 'footer-menu',
                    'depth'             => 1    //only one level should be included in footer menu
                ) );
            ?>

        </nav>
    
    <?php endif; ?>
