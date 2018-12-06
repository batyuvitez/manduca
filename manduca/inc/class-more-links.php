<?php
/**
 * Customize more-links to be accessible
 *
 *
 * @Theme : Manduca - focus on accessibility
 * @Since 17.12.3
 **/


Class More_Links {
   
   
      
   protected $args;
   
   public function __construct() {
	  
	  //Translators: text of the read more and excerpt more buttons
		$args[ "text" ] 			= __( 'Continue reading', 'manduca' );
		$args[ 'icon' ] 			= manduca_get_svg( array( 'icon' => 'angle-right' ) ) ;
		$args[ 'classes']			= 'more-link';
		$this->args = apply_filters(
									'manduca_more_links' ,
									$args );
	
		
		add_filter( 'the_content_more_link', array( $this, 'more_link_create_html' ) );
		add_filter( 'excerpt_more', array( $this, 'more_link_create_html' ) );
		add_filter('get_the_excerpt', array( $this , 'manual_excerpt' ) );
	}
	
	
	public function more_link_create_html() {
			
		   return 	sprintf( '<div  class="%2$s"><a href="%1$s" id="post-%3$s-morelink" aria-labelledby="post-%3$s-morelink post-%3$s-title">%4$s %5$s</a></div>',
									   get_permalink(),
									   $this->args[ 'classes' ],
									   get_the_ID(),
									   $this->args[ 'text' ],
									   $this->args[ 'icon' ]
									  );
	   }
 
	
	
	public function manual_excerpt ( $excerpt ) {
	   
		global $post;
		if( $post->post_excerpt ) {
				return $excerpt .$this->more_link_create_html();
		} else {
				return $excerpt;
		}
	}
	
	
	
 }