<?php
/**
 * Add accessible tabs scripts and style to the page
 *
 * This function should be added to footer when needed. 
 *
 * @ Theme: Manduca - focus on accessibility
 * &since 17.9.5
 *
 * 
 * Remark: The is_page_template function do not work (why?),
 * consequeintly I could not enquing scripts.
 * This is the reason I add directly to this page. 
 * 	
 */

 class Accessible_Tabs{
		  
		  public function add_hooks_to_wp (){
					add_action( 'wp_footer', array(
												   $this,
												  'accessible_tabs_js' )
										, 100 );
					add_action( 'wp_footer', array(
												   $this,
												  'accessible_tabs_css' )
										, 100 );
		  }
		  
		  
		  static function accessible_tabs_js() {
			
					printf( "<script src='%s'></script>",
							  get_template_directory_uri() . '/assets/js/accessible-tabs.js'
							  )
					  ;
					  ?>
					   <script>
								(function($) {
										   $(document).ready(function(){
										   $(".tabs").accessibleTabs({
										   tabhead:'h2',
										   fx:"fadeIn",
										   currentInfoText: '<?php _e( 'Current tab:' , 'manduca' ); ?>' 
									   });
								   });
										   })(jQuery);
					 </script>
					<?php
		  }
		  
		  //Add sliding door css. 
		  static function accessible_tabs_css() {
		  		  printf( '<link rel="stylesheet" href="%s" type="text/css" media="screen">',
		  				  get_template_directory_uri() .'/assets/css/sliding-doors.css'
		  				  );
		  }
		  
		  
 }