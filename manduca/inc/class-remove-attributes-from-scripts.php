<?php
/**
 * * Remove type='text/javascript' from scripts 
 *
 * https://codeless.co/remove-type-attribute-from-wordpress/
 * wp_localize_script() function has no html filter.
 *
 * @since 18.7
 */

class Remove_Attributes_From_Scripts {

    public function __construct() {
        
		add_filter( 'script_loader_tag',
				   array( $this, 'codeless_remove_type_attr' ),
				   10,
				   3
				   );
		add_filter( 'style_loader_tag',
				   array( $this, 'codeless_remove_type_attr' ),
				   10,
				   3
				   );
		
    }
	
	function codeless_remove_type_attr($tag, $handle) {
			return preg_replace(
								"/type=['\"]text\/(javascript|css)['\"]/",
								'',
								$tag
								);
	}
	
}