<?php
/**
 * Template of site title and blog description 
 *
 *
 * @Theme: Manduca - focus on accessibilits
 * @since 17.1
 * @last modification: 18.10.3
 *
 * */

 /*
  * identify the front page is not so simple: 
    On the site front page, is_front_page() will always return TRUE, regardless of whether the site front page displays the blog posts index or a static page.
    On the blog posts index, is_home() will always return TRUE, regardless of whether the blog posts index is displayed on the site front page or a separate page.
    
*/
 ?>
<?php
$current_url = trim( '/', $_SERVER['REQUEST_URI'] ) ;
$home_url = trim( '/', get_home_url() );
?>

 
<?php $site_title = str_replace (' | ', '<br />', get_bloginfo( 'name' ) )  //replace | with line-break  since @17.4 ; ?>
 <?php echo $current_url ;?>
 <?php echo $home_url ;?>
<?php if( is_front_page() ) : ?>
    
        <div class="site-title">
            <span class="display-site-title"><?php echo $site_title; ?> </span>
        </div>
        
<?php else :  ?>
    <div class="site-title">
        <a href="<?php echo home_url( '/' );  ?>" rel="home" accesskey="1">
            <span class="screen-reader-text"><?php _e( 'site title to jump homepage' , 'manduca' ) ; ?></span>
            <span class="display-site-title"><?php echo $site_title; ?></span>
        </a>
    </div>

<?php endif; ?>