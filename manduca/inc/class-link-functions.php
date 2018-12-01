<?php
/**
 * Complete accessibility-review of links. 
 *
 * Add ARIA and svg icons to links
 *
 * The following type of links filtered:
 * 	PDF, external links, image in links. 
 *
 * Theme: Manduca - focus on accessibility
 * @ Since 17.9.6
 * */

  
 Class Link_Functions {
	/* DomDocument Object
	*
	**/
	protected $dom;
	
	public function __construct () {
		// filters have high (late) priority to make sure that any markup plugins have done their HTML. 
		add_filter( 'the_content', array( $this , 'filter_links' ) , 999 );
		add_filter( 'the_excerpt', array( $this , 'filter_links' ) , 999 );
		add_filter( 'comment_text', array( $this , 'filter_links' ) , 999 );
		add_filter( 'widget_text', array( $this , 'filter_links' ) , 999 );
	}
	
	public function filter_links( $content ) {
		libxml_use_internal_errors( true );
		$this->dom = new DOMDocument;
		$content = mb_convert_encoding (
									 $content,
									 'HTML-ENTITIES',
									 'UTF-8'
									 );
		if( empty ( $content ) ) {
			return ;
		}
		$this->dom->loadHTML( $content ); 
		libxml_use_internal_errors( false );

		foreach ( $this->dom->getElementsByTagName('a') as $node) {
					
			$href	= 	$node->getAttribute( 'href' );
			if( ! $this->check_if_valid_link( $href ) ){
				continue;
			}
			
			// Looking for url_scheme
			if( false !== strpos( $href, ':' ) && 4 < strlen( $href ) && false === strpos( $href , 'http' ) ) {
					$node = $this->add_icon_to_url_schemes( $node, $href );
			}

			elseif( $this->check_if_self_link( $href ) ) {
					$parent_node = 	$node->parentNode;
					$span_element 	= $this->dom->createElement( 'span', $node->nodeValue );
					$span_element->setAttribute(
						'class',
						'self-link'
					);
					$parent_node->insertBefore( $span_element, $node );
					$parent_node->removeChild( $node );
				}
			elseif( !$this->check_if_internal_link( $href ) ) {
				//Google map link
				if( false !== strpos( $href, 'goo.gl/maps' ) || false !== strpos( $href, 'google.hu/maps' ) ) {
					 
					$node->setAttribute( 'aria-label',
								  //Translatos: add aria label to links to google maps. 
								__( 'open map', 'manduca' )
							   );
					$svg_node = $this->create_svg_node( 'map-marker' );
					$node->appendChild( $svg_node ) ; 
				}
			
				//all other external link
				else{	
					$node->setAttribute( 'aria-label',
								  //Translators: add aria-label to link. 
									__( 'external', 'manduca' )
								   );
					$svg_node = $this->create_svg_node( 'extlink' );
					$node->appendChild( $svg_node ) ; 
				}
				
				//open in new window
				if( '_blank' == $node->getAttribute( 'target' ) ) {
					$node->setAttribute( 'aria-label',
								  //Translators: add screen-reader text to link
									__( 'Opens a new window' , 'manduca' )
								   );
					$svg_node = $this->create_svg_node( 'new-window' );
					$node->appendChild( $svg_node ) ; 
				}
			} //end of external-link
			if( false !== strpos( $href, '.' ) && 3 < strlen( $href ) ) {
				$node = $this->add_icon_to_static_files( $node, $href );
			}
		}
		
		$final_html 	= $this->dom->saveHtml();
		$search			= array(
											  '<html>',
											  '</html>',
											  '<body>',
											  '</body>'
											  );
		$replace		= array('', '', '', '');
		$final_html		= str_replace( $search, $replace,  $final_html );
		$regex			= '/^<!DOCTYPE.+?>/';
		
		$final_html		= preg_replace(
							$regex,
							'',
							$final_html
							);
		return $final_html;
		
	}
	
	protected function add_icon_to_static_files( $node, $href ) {
		$file_extension_array 	= $this->get_file_extensions_array();
		foreach( $file_extension_array as $extension => $data ) {	// @since 17.7.2
			$needle 	= sprintf( '.%s' ,$extension );
			$needle_len	= strlen( $needle );
			$href_part	= substr( $href, - $needle_len, $needle_len );
			if( $href_part == $needle ) {
				$node->setAttribute( 	'aria-label',
								$data[ 'text' ]
							   );
				$node->appendChild( $this->create_svg_node( $data[ 'icon' ] ) ) ; 
			}
		}
		
		return $node;
	}
	
	protected function add_icon_to_url_schemes( $node, $href ) {
		$url_scheme_array 	= $this->get_url_scheme();
		foreach( $url_scheme_array as $scheme => $data ) {	// @since 17.8
			$needle 	= sprintf( '%s:' ,$scheme );
			$needle_len	= strlen( $needle );
			$href_part	= substr( $href, 0, $needle_len );
			if( $href_part == $needle ) {
				$node->setAttribute( 	'aria-label',
									$data[ 'text' ]
								);
				//this function is not installed yet. 
				//$node->appendChild( $this->create_svg_node( $data[ 'icon' ] ) ) ; 
			}
		}
		return $node;
	}
	protected function check_if_valid_link( $url ) {
		if( 0 == strlen( $url ) )  {
			return false;
		}
		
		if( 1 == strlen( $url )) {
			  if( '/' != $url[0] )  {
				return false;
			  }
		}
		
		return true;
	}
	
	
	protected function check_if_internal_link( $url ) {
		
		$url = str_replace( '\\', '/' , $url );
		if( '/' ==  $url[0] ) {
			return true;
		}
		// pl. './valami'
		elseif( '.' ==  $url[0] ) {
			return true;
		}
		elseif( 'index.php?' == substr( $url, 0, 10 ) ) {  
			  return true;
		}
		$correct_domain_array 	= parse_url( $url );
					  
		if( !isset( $correct_domain_array[ 'scheme' ] ) ) {
			$regex = '%^(?:www\.)?(.*?)\.(?:com|au\.uk|co\.in|net|org|hu|gov)$%'; //https://stackoverflow.com/questions/569137/how-to-get-domain-name-from-url
			  if( 1 == preg_match( $regex, $url , $result ) ) {
					$correct_domain = $result[1];
			  }
			  else {
				return true;
			  }
		}

		if( isset( $correct_domain_array[ 'host' ] ) ){
			  $correct_domain	= $correct_domain_array[ 'host' ];	  
		}
		else {
			if( !isset( $correct_domain_array[ 'scheme' ] ) ) {
				$regex = '%^(?:www\.)?(.*?)\.(?:com|au\.uk|co\.in|net|org|hu|gov)$%'; //https://stackoverflow.com/questions/569137/how-to-get-domain-name-from-url
				if( 1 == preg_match( $regex, $url , $result ) ) {
				    $correct_domain = $result[1];
				}
				else {
					    return false;
				}
			}
			else{
				return false;
			}
		}
		$home_parse_array = parse_url( home_url() );  //@since 18.7.2
		$home_host 			= $home_parse_array[ 'host' ];
		if( $home_host  == $correct_domain ) {
			  return true ;	
		}
		
		return false;
	}
	
	/*
	 *close is the default icon if it is empty
	 **/
	protected function create_svg_node( $svg = 'close' ) {
		if( !isset( $GLOBALS[ 'svg_icons' ][ $svg ] ) ) {
			$svg = 'close';
		}
		 $svg_array = $GLOBALS[ 'svg_icons' ][ $svg ] ;
		 $svg_node 	= $this->dom->createElement( 'svg' );
						
		//aria-hidden attributum
		$svg_attr = $this->dom->createAttribute( 'aria-hidden' );
		$svg_attr->value = 'true';
		$svg_node->appendChild( $svg_attr ) ; 
		
		//aria-hidden attributum
		$svg_attr = $this->dom->createAttribute( 'class' );
		$svg_attr->value = sprintf( 'icon-%s',
						   $svg
						  );
		$svg_node->appendChild( $svg_attr ) ; 
		
		//viewbox attr. 
		$svg_attr = $this->dom->createAttribute( 'viewbox' );
		$svg_attr->value = $svg_array[ 'viewBox' ];
		$svg_node->appendChild( $svg_attr ) ; 
		
		
		// path child
		$svg_path = $this->dom->createElement( 'path' );
		$svg_path_attr = $this->dom->createAttribute( 'd' );
		$svg_path_attr->value = $svg_array[ 'path' ]	;
		$svg_path->appendChild( $svg_path_attr );
		$svg_node->appendChild( $svg_path );
		return $svg_node;
	}
	
	protected function check_if_self_link( $href ) {
		$href	= rtrim( urldecode( $href ) ,'/' ) ;
		global $wp;
		$current_url	= home_url( $wp->request );
		$current_url	= urldecode( $current_url );
		$current_url 	=  rtrim ( $current_url, '/' );
		
		if( $href == $current_url ) {
			return true;
		}
		return false;
	}
	
	protected function get_file_extensions_array() {
		$extenstion_array = array(
				'docx'		=> array(
					//Translatos: add aria label to links to google maps. 
					'text' 	=> __( 'MS Word document', 'manduca' ),
					'icon'	=> 'word'
					),
				'doc'		=> array(
					//Translatos: add aria label to links to google maps. 
					'text' 	=> __( 'MS Word document', 'manduca' ),
					'icon'	=> 'word'
					),
				'odt'		=> array(
					//Translatos: add aria label to links to google maps. 
					'text' 	=> __( 'MS Word document', 'manduca' ),
					'icon'	=> 'word'
					),
				'xls'		=> array(
					//translators: Aria label for xls and xlsx links. 
					'text'		=> __( 'MS Excel document', 'manduca' ),
					'icon'		=> 'excel'
					),
				'xlsx'		=> array(
					//translators: Aria label for xls and xlsx links. 
					'text'		=> __( 'MS Excel document', 'manduca' ),
					'icon'		=> 'excel'
					),
				
				'pdf'		=> array(
					//translators: Aria label for pdf links. 
					'text'		=> __( 'PDF document', 'manduca' ),
					'icon'		=> 'pdf'
					),
				'epub'	=> array(
					//translator aria label for epub and other electronic book type link
					'text'		=> __( 'Electronic book' , 'manduca' ),
					'icon'		=> 'epub'
					)
				);
			return apply_filters( 'manduca_extenstion_array' , $extenstion_array );
	}
	
	/* This is not used yet, since domDocument not includes these links.
	 * */
	protected function get_url_scheme(){
		$url_schemes = array(
			'mailto'	=> array(
					//translator aria label for epub and other electronic book type link
					'text'		=> __( 'Send email' , 'manduca' ),
					'icon'		=> 'at'
					),
			'tel'	=> array(
					//translator aria label for epub and other electronic book type link
					'text'		=> __( 'Call on phone' , 'manduca' ),
					'icon'		=> 'phone'
					)
		);
		return apply_filters( 'manduca_url_scheme_array' , $url_schemes );
	}

 }