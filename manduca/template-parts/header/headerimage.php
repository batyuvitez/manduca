<?php
/**
 * Generate header image
 * Header template file
 * 
 * @ Theme: Manduca - focus on accessibility 
 **/

 
    
$header_image = get_header_image() ;

if( false != $header_image ) :
    
    /*
     * Accessibility function: Get the alt text for header image
     **/
    
    if( false != get_theme_mod( 'header_image_data' ) ) {
        $data = get_object_vars ( get_theme_mod( 'header_image_data' ) ) ;    
    
        if( is_array( $data ) && isset( $data[ 'attachment_id' ] ) ) {
              
            $attachment_id =  $data[ 'attachment_id' ];
    
            $alt = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );
    
        }
        
        
    }
    if( '' ==$alt ) {
        $alt = __( 'This image has no alt text, sorry', 'manduca' )  ;    
    }
    

    
    if( is_home() || is_front_page() && get_header_image() ) {
       printf( '<img src="%1$s" id="header-image" class="header-image" width="%2$s" height="%3$s" alt="%4$s" />',
              $header_image,
              esc_attr( get_custom_header()->width ),
              esc_attr( get_custom_header()->height ),
              $alt
              );
    }
endif;