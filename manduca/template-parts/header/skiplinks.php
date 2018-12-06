<?php
/**
 * Jump links to content and sidebar
 * Header template file
 * 
 * @theme: Manduca - focus on accessibility 
 * @since 17.4
 * @last modification 18.10.14
 **/
?>
<nav id="skip-links" aria-label="<?php _e( 'Jump links' , 'manduca' ) ?>" >

    <a class="skip-link" href="#content"><?php _e( 'Skip to main content', 'manduca' ); ?></a>
    
    <a class="skip-link" href="#secondary"><?php _e( 'Skip to sidebar', 'manduca' ); ?></a>        
    
    <a class="skip-link" href="#colophon"><?php _e( 'Skip to footer', 'manduca' ); ?></a>           
    
    <?php if( defined( 'MANDUCA_ACCESS_KEYS') ) : ?>
        
        <a class="skip-link" href="<?php echo MANDUCA_ACCESS_KEYS; ?>" accesskey="0"><?php _e( 'Jump to access key details', 'manduca' ); ?></a>    
            
    <?php endif; ?>

</nav>