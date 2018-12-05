<?php
/*
 * Filters the title of the page. Modify if paginated (i.e. archives )
 * Hungarian translation in WP is unexpectable ( i.e. 'Oldal3' ), 
 *
 * @since 18.10.21
 **/


namespace Manduca;

class Manduca_Filter_Title{
    
    public function __construct(){ 
        add_action ( 'init',
                    array( $this, 'place_filter_very_early')
                   );
    }
    public function place_filter_very_early(){
      
        // In case of Yoast Seo active. This hook is called earlier. 
        add_filter(
                   'pre_get_document_title',
                   array( $this, 'add_hungarian_pagination' ),
                    20
                  );
          // If yoast seo not active, this hook will be applied
        add_filter(
                   'document_title_parts',
                   array( $this, 'add_hungarian_pagination' ),
                    1
                  );
    }
    
    public function add_hungarian_pagination( $title ) {
            if( '' == $title || !is_array( $title )) return ; // If Yoast Seo is not active, the pre_get_document_title hook does'nt needed. 
            global $paged, $page;
                    if( $paged < 2  || is_404() ) {
                    return $title;
            }
            // translators: This string is a replacement of the same string in WP's. Hungarian translation in WP is bad. 
            $string = __( 'Page %s' , 'manduca' );
            $title[ 'page'] = sprintf( $string, $paged );
            return $title;
    }
}
