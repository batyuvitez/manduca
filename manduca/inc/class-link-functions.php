<?php
/**
 * Modify links and make it more accessibile  
 * Add ARIA, screen-reader-text and svg icons to links
 *
 *
 *@see https://www.w3.org/WAI/GL/wiki/Using_aria-label_for_link_purpose
 *@since 17.9.6
 * */

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2018  Zsolt Edelényi (ezs@web25.hu)

    Manduca is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    in /assets/docs/licence.txt.  If not, see <https://www.gnu.org/licenses/>.
*/


namespace Manduca;
  
 Class Link_Functions {
	
   protected $dom;
   
   public function __construct () {
      // filters have high (late) priority to make sure that any markup plugins have done their HTML. 
      add_filter( 'the_content', array( $this , 'filter_links' ) , 999 );
      add_filter( 'the_excerpt', array( $this , 'filter_links' ) , 999 );
      add_filter( 'comment_text', array( $this , 'filter_links' ) , 999 );
      add_filter( 'widget_text', array( $this , 'filter_links' ) , 999 );
   }
   
   /*
    * Filter the content of different parts of webpage (main,widget etc. )
    *
    * Comments:
    *     None of any Firefox version reads the aria-label attribute in Windows/JAWS. Therefore I still apply screen-reader text.
    *     Other browser sometimes read aria-label before the value of element, which is not satisfactory. 
    * 
    * @param string $content : HTMl markup of content to be modified. 
    * @return $string : modified HTML markup
    * 
   */
   public function filter_links( $content ) {
      libxml_use_internal_errors( true );
      $content = mb_convert_encoding (
              $content,
              'HTML-ENTITIES',
              'UTF-8'
              );
      if( empty ( $content ) ) {
       return ;
      }
      $this->dom = new \DOMDocument;
      $this->dom->encoding = 'utf-8'; //@see: https://stackoverflow.com/questions/6573258/domdocument-and-special-characters
      $this->dom->loadHTML( $content ); 
      libxml_use_internal_errors( false );
    
      foreach ( $this->dom->getElementsByTagName('a') as $node) {
         
       $href		= 	$node->getAttribute( 'href' );
       $link_text 	= $node->nodeValue;
       $link_text= preg_replace('/[\x00-\x1F\x7F]/u', '', $link_text);  // filter invisible chars. 
       
       
       if( ! $this->check_if_valid_link( $href ) ){
        continue;
       }
       
       // Search for img child-node
       $has_img_child = false;
       $child_nodes = $node->childNodes;
       foreach( $child_nodes as $child_node) {
        if( 'img' == $child_node->nodeName ) {
         $has_img_child = true;
         $attrs = $child_node->attributes;
         foreach( $attrs  as $attr ) {
          if( 'alt' == $attr->name) {
           $alt_text = $attr->value ;
           $child_node->setAttribute( 'role', 'presentation' );
          }
         }
        }
       }
       if( $has_img_child ) {
        if( !isset( $alt_text ) || '' == $alt_text ) {
         $post_title= get_the_title();
         if( ! empty( $post_title) ) {
          //Translators: %s = title of post. This is an aria-label to a link  which has a children of an image, and image has no alt text. 
          $aria_label = sprintf( __( 'Image to the post titled: %s' , 'manduca' ),
                 $post_title
                );
          $node->setAttribute( 'aria-label', $aria_label );
         }
         
         unset( $post_title );
        }
        else{
         //Translators: %s = alt text of image. This is an aria label to a link which has a children of an image.
         $aria_label = sprintf( __( 'Image: %s' , 'manduca' ),
                 $alt_text
                 );
         $node->setAttribute( 'aria-label', $aria_label) ;					
         unset( $alt_text);
        }
       }
       
       // Looking for url_scheme
       elseif( false !== strpos( $href, ':' ) && 4 < strlen( $href ) && false === strpos( $href , 'http' ) ) {
         $node = $this->add_icon_to_url_schemes( $node, $href );
       }
    
       elseif( $this->check_if_self_link( $href ) ) {
         $parent_node = 	$node->parentNode;
         $span_element 	= $this->dom->createElement( 'span', $node->nodeValue );
         $span_element->setAttribute(
          'class',
          'self-link'
         );
         
         $screen_reader_text = $this->dom->createElement(
             'span',
              // translators: this is the text read by screen readers only in case of you are in a html element referring to current page. 
              $screen_reader_text =  __( 'Current page', 'manduca' )  
             );
         $screen_reader_text->setAttribute(
             'class',
             'screen-reader-text'
          );
         $span_element 	= $this->dom->createElement( 'span', $node->nodeValue );
         $parent_node->insertBefore( $screen_reader_text, $node);
         $parent_node->insertBefore( $span_element, $node );
         $parent_node->removeChild( $node );
         
         
        }
       elseif( !$this->check_if_internal_link( $href ) ) {
        //Google map link
        if( false !== strpos( $href, 'goo.gl/maps' ) || false !== strpos( $href, 'google.hu/maps' ) ) {
          
         $node->setAttribute( 'aria-label',
              //Translatos: add aria label to links to google maps. 
            __( 'open map', 'manduca' ) .' : ' .$link_text
              );
         $svg_node = $this->create_svg_node( 'map-marker' );
         $node->appendChild( $svg_node ) ; 
        }
       
        //all other external link
        else{
         
            $node->setAttribute( 'aria-label',
                        //Translators: add screen-reader-text to external link. 
                         __( 'external', 'manduca' ) .' : ' .$link_text
                         );
             $svg_node = $this->create_svg_node( 'extlink' );
             $node->appendChild( $svg_node ) ; 
      
        }
        
        //open in new window
        if( '_blank' == $node->getAttribute( 'target' ) ) {
         /*Add rel=noopener to links open in new window
          *@see: https://dev.to/ben/the-targetblank-vulnerability-by-example
          @since 18.11
          */
         $node->setAttribute(
            'rel',
            'noopener noreferrer'
         );
         

         $node->setAttribute( 'aria-label',
                        //Translators: add screen-reader-text to target="'_blank". 
                     __( 'Opens a new window' , 'manduca' ) .' : ' .$link_text
                     );
         $svg_node = $this->create_svg_node( 'new-window' );
         $node->appendChild( $svg_node ) ; 
        }
       } //end of external-link
       if( false !== strpos( $href, '.' ) && 3 < strlen( $href ) ) {
        $node = $this->add_icon_to_static_files( $node, $href );
       }
      }
      
      /* Add role="presentation" to images without alt-text
      * @since 18.10
      */
      foreach ( $this->dom->getElementsByTagName('img') as $node) {
        $alt= 	$node->getAttribute( 'alt' );
        if( empty( $alt ) || '' == $alt ) {
         $node->setAttribute( 'role', 'presentation' );
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
            $data[ 'text' ] .' : ' . $node->nodeValue
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
   
   /*
    *Check if url is internal link
    *
    *@param string $url : URL to examine and decide if it's an internal-link or not.
    *@return bool       : true - if it is internal link,
    *                     false - if it is external link. 
    **/
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
         
   if( isset( $correct_domain_array[ 'scheme' ] ) ) {
     $url = str_ireplace( $correct_domain_array[ 'scheme' ], '' , $url );
    }
  
    if( isset( $correct_domain_array[ 'host' ] ) ){
       $correct_domain	= $correct_domain_array[ 'host' ];
    }
    else {
     
      $regex = '%^(?:www\.)?(.*?)\.(?:com|au\.uk|co\.in|net|org|hu|gov)$%'; //https://stackoverflow.com/questions/569137/how-to-get-domain-name-from-url
      if( 1 == preg_match( $regex, $url , $result ) ) {
          $correct_domain = $result[1];
      }
      else {
         // e.g. 'wp-content/uploads/img.jpg'
         return true;
      }
    }
    
    $home_parse_array = parse_url( home_url() );  //@since 18.7.2	   
    $home_host 			= $home_parse_array[ 'host' ];
     
    if( function_exists ( 'idn_to_utf8' ) ) {
        $home_host 		= idn_to_utf8( $home_host ); // some server does not have this function . See. http://www.queryadmin.com/1491/call-undefined-function-idn_to_utf8/
        $correct_domain	= idn_to_utf8( $correct_domain );
    }
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
    $svg_node->appendChild( $svg_attr ) ; 
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
    /*
     *filter manduca_extenstion_array
     */
     return apply_filters( 'manduca_extenstion_array' , $extenstion_array );
   }
   
   
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
    /*
     *filter manduca_url_sheme_array
     *Filter the aria label texts and icons added to the links of schemes (mailto, tel )
     **/    
    return apply_filters( 'manduca_url_scheme_array' , $url_schemes );
   }
   
   
   /*
    * Add screen-reader text to $parent_node
    *(not used yet)
    *
    * @param string  $screen_reader_text : the text to add. 
    * @param domNode class               : $partent_node
    *
    * @return domNode class;
    **/
   protected function create_screen_reader_text_node ( $screen_reader_text ) {
         $node = $this->dom->createElement(
             'span',
              $screen_reader_text
             );
         $node->setAttribute(
             'class',
             'screen-reader-text'
          );
              
       return $node;
   }
 }