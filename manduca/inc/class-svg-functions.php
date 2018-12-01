<?php
/**
 * SVG icons related functions and filters
 *
 * @ Theme: Manduca focus on accessiblilty 
 * @ since 17.4
 **/

/**
 * Add SVG definitions to the footer.
 */

class SVG_Functions {
	 protected $svg_name ;
	 
	 function __construct( $args ) {
			   $this->svg_name = $args;
			}
			
			/**
			 * Return SVG markup.
			 *
			 * @param array $args {
			 *     Parameters needed to display an SVG.
			 *
			 *     @type string $icon  Required SVG icon filename.
			 *     @type string $title Optional SVG title.
			 *     @type string $desc  Optional SVG description.
			 * }
			 * @return string SVG markup.
			 */
	 function SVG_Markup( ) {
			  // Make sure $this->svg_name are an array.
			  if ( empty( $this->svg_name ) ) {
				  /* translators: Error message if there no array in the parameter */
				  trigger_error ( __( 'Please define default parameters in the form of an array.', 'manduca' ) , E_USER_WARNING ) ;
				  return;
			  }
		  
			  // Define an icon.
			  if ( false === array_key_exists( 'icon', $this->svg_name ) ) {
				  /* translators: Error message if there is no icon exist with the given name */
				  trigger_error ( __( 'Please define an SVG icon filename.', 'manduca' ), E_USER_WARNING );
				  return;
			  }
			  // Set defaults.
			  $defaults = array(
				  'icon'        => '',
				  'title'       => '',
				  'desc'        => '',
				  'fallback'    => false,
			  );
		  
			  // Parse args.
			  $this->svg_name = wp_parse_args( $this->svg_name, $defaults );
			   $svg_icons = $GLOBALS[ 'svg_icons' ];
		  
			  // Set aria hidden.
			  $aria_hidden = ' aria-hidden="true"';
		  
			  // Set ARIA.
			  $aria_labelledby = '';
		  
			  /**
			   * Manduca doesn't use the SVG title or description attributes; non-decorative icons are described with .screen-reader-text.
			   *
			   * However, child themes can use the title and description to add information to non-decorative SVG icons to improve accessibility.
			   * Example 1 with title:
			   * 			<?php echo manduca_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ) ) ); ?>
			   
			   * Example 2 with title and description:
			   *			<?php echo manduca_get_svg( array( 'icon' => 'arrow-right', 'title' => __( 'This is the title', 'textdomain' ), 'desc' => __( 'This is the description', 'textdomain' ) ) ); ?>
			   
			   * See https://www.paciellogroup.com/blog/2013/12/using-aria-enhance-svg-accessibility/.
			   **/
			  if ( $this->svg_name['title'] ) {
				  $aria_hidden     = '';
				  $unique_id       = uniqid();
				  $aria_labelledby = ' aria-labelledby="title-' . $unique_id . '"';
		  
				  if ( $this->svg_name['desc'] ) {
					  $aria_labelledby = ' aria-labelledby="title-' . $unique_id . ' desc-' . $unique_id . '"';
				  }
			  }
		  
			  // Begin SVG markup.
			  
		  
			  // Display the title.
			  if ( $this->svg_name['title'] ) {
				  $title = '<title id="title-' . $unique_id . '">' . esc_html( $this->svg_name['title'] ) . '</title>';
		  
				  // Display the desc only if the title is already set.
				  if ( $this->svg_name['desc'] ) {
					  $description = '<desc id="desc-' . $unique_id . '">' . esc_html( $this->svg_name['desc'] ) . '</desc>';
				  }
				  else {
					   $description = '';
				  }
			  }
			  else {
				  $title= '';
			  }
		  
		  
			  /*
			   * Display the icon.
			   *
			   * The whitespace around `<use>` is intentional - it is a work around to a keyboard navigation bug in Safari 10.
			   *
			   * See https://core.trac.wordpress.org/ticket/38387.
			   *
			   * The 'xlink:href' is depretiated since SVG 2, but needed because browsers do not support href attr. 
			   *  
			   */
			  if( isset ( $svg_icons [ esc_html( $this->svg_name['icon'] ) ] ) ) {

					$svg_item 	=  $svg_icons [ esc_html( $this->svg_name['icon'] ) ] ;
			  }
			  else {
					//translators: PHP user error message when child theme not define an svg icon.
					$error_message = sprintf( '%1$s : "%2$s"',
											 __( 'No svg icon declared', 'manduca' ),
											 $this->svg_name['icon']
											);
					user_error( $error_message );
					return;
			  }
			   
			   $vector		= $svg_item[ 'vector' ]  ;
							  
			   $viewBox		= $svg_item[ 'viewBox' ];
			   $svg  = sprintf( '<svg xmlns="http://www.w3.org/2000/svg" class="icon-%1$s" viewbox="%2$s" %3$s %4$s >%5$s</svg>',
							   esc_attr( $this->svg_name['icon'] ),
							   $viewBox,
							   $aria_hidden,
							   $aria_labelledby,
							   $vector
							 );
			  
			  return $svg;
	 }
	 
	
	public function Return_HTML() {
			   return $this->SVG_Markup();
	}
	 
	  public static function load_svg_to_global() {
		  
		  require( get_template_directory() . '/assets/images/svg-icons.php' );
		  
		  // Filter svg icon array before put it into global variable 
		  $svg_icons = apply_filters( 'manduca_svg_icons' , $svg_icons );
						 
		  $GLOBALS[ 'svg_icons' ] = $svg_icons;

	 }
	 
	
 }	