<?php
/**
 * Template of site title and blog description 
 *
 *
 * @Theme: Manduca - focus on accessibilits
 * @since 17.1
 * @last modification: 18.2
 *
 * */

 ?>

<?php $site_title = str_replace (' | ', '<br />', get_bloginfo( 'name' ) )  //replace | with line-break  since @17.4 ; ?>
 
<?php if( is_front_page() ) : ?>
    
        <div class="site-title">
            <span class="display-site-title"><?php echo $site_title; ?> </span>
        </div>
        
<?php else :  ?>
 
    <a class="site-title" href="<?php home_url( '/' );  ?>" rel="home">
        <span class="screen-reader-text"><?php _e( 'site title to jump homepage' , 'manduca' ) ; ?></span>
        <span class="display-site-title"><?php echo $site_title; ?></span>
    </a>

<?php endif; ?>