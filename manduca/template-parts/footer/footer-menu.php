<?php
/*
 *footer site info
 *
 * &since 17.3
 **/

    $menu = wp_nav_menu(array (
            'echo' => false,
            'fallback_cb' => '__return_false',
            'container'       	=> false,
            'theme_location' 	=> 'footer',
            'menu_class' 		=> 'footer-menu',
            'depth'             => 1    //only one level should be included in footer menu
        ) );
    
    if ( ! empty ( $menu ) ) {
        echo '<nav id="footer-navigation" class="footer-navigation">' .$menu .'</nav>';
    }

?>
        

