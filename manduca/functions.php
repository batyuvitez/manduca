<?php
/**
 * Manduca
 *
 * @since 1.0 */

if ( ! isset( $content_width ) ) {
	$content_width = 625;
}

//-------------------------------------------------------------------------------------------
// Manduca setup
//-------------------------------------------------------------------------------------------
function manduca_setup() {
	
	// Styles the visual editor with editor-style.css
	add_editor_style();
	
	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );
	
	// Switch default core markup to output valid HTML5.
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'caption'
	) );
	//Allows themes to add document title tag
	add_theme_support( 'title-tag' );
	
	//Register navigation menus
	register_nav_menu( 'primary', __( 'Main navigation', 'manduca' ) );
	register_nav_menu( 'footer', __( 'Footer navigation', 'manduca' ) );
	
	//Makes translation-ready
	load_theme_textdomain( 'manduca', get_template_directory() . '/lang' );
	
	 //Supports custom background color and image
	add_theme_support( 'custom-background', array(
		'default-color' => 'f3f3f5',
	) );

	// Uses a custom image size for featured images
	add_theme_support( 'post-thumbnails' );
	add_image_size ('post-size', 770, 417 );
	add_image_size ('excerpt-size', 268, 178 );
}
add_action( 'after_setup_theme', 'manduca_setup' );

require( get_template_directory() . '/inc/custom-header.php' );


/**
 *Image optimazation
 *delete WordPress default image sizes
 *
 **/
function manduca_filter_image_sizes( $sizes) {
	unset( $sizes[ 'medium' ] );
	unset( $sizes[ 'large' ] );
 
	return $sizes;
}

add_filter('intermediate_image_sizes_advanced', 'manduca_filter_image_sizes');
 
function manduca_custom_image_sizes($sizes) {
	$add_sizes = array(
		'thumbnail-size' 	=> __( 'Thumbnail', 'manduca' ),
		'post-size' 		=> __( 'Image in Post', 'manduca' ),
		'full' 				=> __( 'Original size', 'manduca' )
	);
	$new_sizes = array_merge($sizes, $add_sizes);
	return $new_sizes;
}
add_filter('image_size_names_choose', 'manduca_custom_image_sizes');

 
 
//-------------------------------------------------------------------------------------------
// Manduca Scripts
//-------------------------------------------------------------------------------------------
function manduca_scripts_styles() {
	global $wp_styles;


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

		// Loads stylesheets.
	wp_enqueue_style( 'manduca-main-style', get_stylesheet_uri(), false, false, 'all' );
	wp_enqueue_style( 'manduca-print-style', get_template_directory_uri() .'/css/print.min.css', false, false, 'print'  );
	
	//Loads Font Awesome
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.0/css/font-awesome.min.css' );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'manduca-ie', get_template_directory_uri() . '/css/ie.css', array( 'manduca-style' ), '20121010' );
	$wp_styles->add_data( 'manduca-ie', 'conditional', 'lt IE 9' );
	
	wp_enqueue_script( 'manduca-scripts', get_template_directory_uri() . '/js/manduca-scripts.min.js', array( 'jquery' ), '160226', true );
	
	wp_localize_script( 'manduca-scripts', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'manduca' ),
		'collapse' => __( 'collapse child menu', 'manduca' ),
	) );
	
}

add_action( 'wp_enqueue_scripts', 'manduca_scripts_styles', true );


//-------------------------------------------------------------------------------------------
// Filter the page menu arguments.
//-------------------------------------------------------------------------------------------
 
function manduca_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) ) {
		$args['show_home'] = true;
	}
	return $args;
}

add_filter( 'wp_page_menu_args', 'manduca_page_menu_args' );
		
function manduca_widgets_init() {
		register_sidebar( array(
		'name' =>__( 'Sidebar', 'manduca' ),
		'id' => 'main_sidebar',
		'description' => __( 'Appears all pages except when using full page template', 'manduca' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s" aria-labelledby ="w-%1$s"><h4 id="w-%1$s" class="widget-title"> ',
		'after_widget' => '</section>',
		'before_title' => '',
		'after_title' =>'</h4>',
	) );

	
}
add_action( 'widgets_init', 'manduca_widgets_init' );

//-------------------------------------------------------------------------------------------
// Template for comments and pingbacks.
//-------------------------------------------------------------------------------------------

if ( ! function_exists( 'manduca_comment' ) ) :
 
function manduca_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'manduca' ), '<span class="edit-link"><i class="fa fa-pencil" aria-hidden="true"></i> ', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<header class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						( $comment->user_id === $post->post_author ) ? '<span>' .__( 'Author', 'manduca' ) .'</span>' : ''
					);
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( __( 'Date: %1$s: %2$s', 'manduca' ), get_comment_date(), get_comment_time() )
					);
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) { ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Comment is awaiting for apporval.', 'manduca' ) ?></p>
			<?php } ?>

			<section class="comment-content comment">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'manduca' ), '<p class="edit-link"><i class="fa fa-pencil"></i> ', '</p>' ); ?>
			</section><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'manduca' ), 'after' => ' <span>&rarr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;

//-------------------------------------------------------------------------------------------
// Set up Manduca post meta.
//-------------------------------------------------------------------------------------------

if ( ! function_exists( 'manduca_entry_meta' ) ) :

	function manduca_entry_meta()
	{	
		$categories_list = get_the_category_list( ', ' );
		$tag_list = get_the_tag_list( '', ', ' );	
		$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><abbr class="published" title="%3$s"><time class="entry-date" datetime="%3$s">%4$s</time></abbr></a>',
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
		
	
		$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'All posts by %s', ' manduca' ), get_the_author() ) ),
			get_the_author()
		);
	
		$modified_date = sprintf( '<time class="updated" datetime="%1$s">%2$s</time></a>',
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date( 'Y. F j.' ) )
		);
	
		$utility_text ='<p class="screen-reader-text">'. __( 'Post meta', 'manduca' ) .'</p>';
		$utility_text .= "<ul>";
		
		$utility_text .= '<li><i class="fa fa-clock-o" aria-hidden="true"></i><span> ' .__( 'Entry date', 'manduca' ) .':</span> ' . $date .'</li>';
		
		if( get_the_date() !== get_the_modified_date() ) {
			$utility_text .='<li><i class="fa fa-pencil-square-o" aria-hidden="true"></i><span> ' . __( 'Last revision:', 'manduca' ) .':</span> ' .$modified_date .'</li>';
		}
		
		$utility_text .= '<li><i class="fa fa-user" aria-hidden="true"></i><span> ' .__( 'Author', 'manduca' ) .':</span> ' . $author .'</li>';
	
		if ( $categories_list ) {
			$utility_text .='<li><i class="fa fa-folder-open-o" aria-hidden="true"></i><span> ' .__( 'Category', 'manduca' ) .':</span> ' .$categories_list .'</li>';
		}
		
		if ( $tag_list ) {
			$utility_text .= '<li><i class="fa fa-tags" aria-hidden="true"></i><span> '. __( 'Tags', 'manduca' ) .':</span> ' .$tag_list .'</li>';
		}
		
		
		$utility_text .="</ul>";
		
		
		echo $utility_text;
	}
endif;

//-------------------------------------------------------------------------------------------
// Customizer setup
//-------------------------------------------------------------------------------------------

function manduca_sanitize_text_input( $input ) {
    $output = strip_tags( stripslashes( $input ) );  
    return $output;
} 

function manduca_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

// Move theme option to the customizer
	$wp_customize->add_setting( 'manduca_copyright_text', array(
		'default' => get_bloginfo(),
		'sanitize_callback' => 'manduca_sanitize_text_input'
		) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'manduca_options', array(
		'label'        =>  __( 'Copyright text', 'manduca' ),
		'section'    => 'title_tagline',
		'settings'   => 'manduca_copyright_text',
	) ) );
}
add_action( 'customize_register', 'manduca_customize_register' );

//-------------------------------------------------------------------------------------------
// Enqueue Javascript postMessage handlers for the Customizer.
//-------------------------------------------------------------------------------------------
 
function manduca_customize_preview_js() {
	wp_enqueue_script( 'manduca-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20141120', true );
}
add_action( 'customize_preview_init', 'manduca_customize_preview_js' );






/**
 * Displays paginated link for post pages in the format of serial numbers (e.g. '11-20' ).
 * Shows all links. 
 *
 * @since 16.7
 * Manduca replaces wp_list_pages() with this function. 
 *
 * @global WP_Query   $wp_query
 * @global WP_Rewrite $wp_rewrite
 *
 */

if ( ! function_exists( 'manduca_page_navigation' ) ) :
 
	function manduca_page_navigation() {
		global $wp_query, $wp_rewrite;
	
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}
		
		
		// Setting up default values based on the current URL.
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$url_parts    = explode( '?', $pagenum_link );
		
		if ( isset( $url_parts[1] ) ) {
				wp_parse_str( $url_parts[1], $query_args );
			}
		
	
		// Get max pages and current page out of the current query, if available.
		$total   = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
		$current = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	
		// Append the format placeholder to the base URL.
		$pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';
	
		// URL base depends on permalink settings.
		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';
	
		//default post per page
		$default_posts_per_page 	= get_option( 'posts_per_page' );
		
		$args = array(
			'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
			'format' => $format, // ?page=%#% : %#% is replaced by the page number
			'total' => $total,	
			'current' => $current,
			'show_all' => true,
			'prev_next' => true,
			'prev_text' =>  '<i class="fa fa-angle-left"></i>' .__( 'Previous', 'manduca' ),
			'next_text' => __( 'Next', 'manduca' )  .'<i class="fa fa-angle-right"></i>',
			'end_size' => 1,
			'mid_size' => 1,
			'add_args' => array_map( 'urlencode', array() ),
			'add_fragment' => '',
			'before_page_number' => '',
			'after_page_number' => ''
		);
	
	
	
		$add_args = $args['add_args'];
		$page_links = array();
		$dots = false;
		
		/* Boolean filter
		 * @ name: manduca_page_navigation_format
		 * @ true : default : use from-to pagination
		 * @ false : use classic navigation
		 * */
		$type_flag = apply_filters( 'manduca_page_navigation_format' , '__return_true');
		
	
		if ( $args['prev_next'] && $current && 1 < $current ) :
			$link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
			$link = str_replace( '%#%', $current - 1, $link );
			if ( $add_args )
				$link = add_query_arg( $add_args, $link );
			$link .= $args['add_fragment'];
	
			$page_links[] = '<a class="prev page-numbers" href="' . esc_url( $link  ) . '">' . $args['prev_text'] . '</a>';
		endif;
		for ( $n = 1; $n <= $total; $n++ ) :
			
			if ( $type_flag ) {
				$current_display = manduca_current_pagination_display( $default_posts_per_page, $n - 1 );
			}
			else {
				$current_display = $n;
			}
			
			if ( $n == $current ) :
				$page_links[] = "<span class='page-numbers current'>" . $args['before_page_number'] . $current_display . $args['after_page_number'] . "</span>";
				$dots = true;
			else :
				if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
					$link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
					$link = str_replace( '%#%', $n, $link );
					if ( $add_args )
						$link = add_query_arg( $add_args, $link );
					$link .= $args['add_fragment'];
	
					$page_links[] = "<a class='page-numbers' href='" . esc_url( $link ) . "'>" . $args['before_page_number'] . $current_display . $args['after_page_number'] . "</a>";
				
				endif;
			endif;
		endfor;
		if ( $args['prev_next'] && $current && ( $current < $total || -1 == $total ) ) :
			$link = str_replace( '%_%', $args['format'], $args['base'] );
			$link = str_replace( '%#%', $current + 1, $link );
			if ( $add_args )
				$link = add_query_arg( $add_args, $link );
			$link .= $args['add_fragment'];
	
			$page_links[] = '<a class="next page-numbers" href="' . esc_url( $link ) . '">' . $args['next_text'] . '</a>';
		endif;
		
		$links = join("\n", $page_links);
	
		if ( $links ) :
	
		?>
		<nav class="navigation paging-navigation" role="navigation">
			<h3 class="screen-reader-text"><?php _e( 'Posts navigation', 'manduca' ); ?></h3>
			<div class="pagination loop-pagination">
				<?php echo $links; ?>
			</div><!-- .pagination -->
		</nav><!-- .navigation -->
		<?php
		endif;
}
endif;

/**
 * Manduca format of page navigation
 * that is show the serial number of posts eg. 11-20, 21-30 etc. 
 *
 * @since 16.7
 *
 * @parameters 
 * 		@type number 	$default_posts_per_page		Number of posts per page
 * 		@type number 	$link_number				Number of page of the posts
 * @global WP_Query   $wp_query
 * @global WP_Rewrite $wp_rewrite
 *
 * @return Void string manduca format of page navigation (e.g. '11-20')
 */


if( !function_exists( 'manduca_current_pagination_display' ) ) :

	function manduca_current_pagination_display( $default_posts_per_page, $link_number ) {
		$post_count_first 	= ( $default_posts_per_page  * ( $link_number ) ) + 1; 
		$post_count_last	= $post_count_first +$default_posts_per_page - 1;
		return number_format_i18n( $post_count_first ) .' - ' .number_format_i18n($post_count_last );
		
	}

endif;


//-------------------------------------------------------------------------------------------
// Change default text for comments
//-------------------------------------------------------------------------------------------
if( !function_exists( 'manduca_comment_form_text' ) ) :
	
	add_filter( 'comment_form_defaults', 'manduca_comment_form_text' );
	
	function manduca_comment_form_text( $defaults ) {
		$defaults['comment_notes_after'] 	= '';
		$defaults['title_reply']		= __( 'Please give your comments!', 'manduca' );
	$commenter = wp_get_current_commenter();
		$fields =  array(
	
	  'author' =>
		'<p class="comment-form-author"><label for="author">' . __( 'Your name', 'manduca' )  .'</label> <input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		'" size="30" /></p>',
	
	  'email' =>
		'<p class="comment-form-email"><label for="email">' .__( 'Email', 'manduca' ) .'</label> <input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		'" size="30" /></p>',
	
	);
		$defaults['fields'] =$fields;
		$defaults['comment_field'] ='<p class="comment-form-comment"><label for="comment">' .__( 'Your comment', 'manduca' ) .'</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';
		$defaults['comment_notes_before'] = '<p class="comment-notes">' .__( 'Your email address is confidential.', 'manduca' ) .'</p>';
		return $defaults;
	
	}
endif;
	
	
/*
 * Setup TinyMCE so user can easaly use accessible formats. 
 *
 * @ Remove H1 from TinyMCE so users are discouraged from breaking headings hierarchy.
 * @ add 2 highlights formats
 * 
 * Thanks to Joe dolson 
 * */
if( !function_exists( 'manduca_tinymce_init') ) :
 
function manduca_tinymce_init( $init_array ) {
	
	// Define the style_formats array
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(  
			'title' => __( 'Highlight-2' , 'manduca' ) ,
			'block' => 'div',  
			'classes' => 'highlight-1',
			'wrapper' => true,
			
		),  
		array(  
			'title' => __( 'Highlight-1' , 'manduca' ) ,  
			'block' => 'div',  
			'classes' => 'highlight-2',
			'wrapper' => true,
		),
		array(  
			'title' => __( 'Quotation' , 'manduca' ),  
			'inline' => 'q',  
			'wrapper' => true,
		),
			array(  
			'title' => __( 'Abbreviation' , 'manduca' ),  
			'inline' => 'abbr',  
			'wrapper' => true,
		)
	);
	
			
	
	$init_array['style_formats'] = json_encode( $style_formats );
	
	
	
    // replace block formats with elements helps bulding an accessibile content
		$block_formats 			= 'Paragraph=p; ' .__( 'Heading 2', 'manduca' ) .'=h2; ';
		$block_formats 			.= __( 'Heading 3', 'manduca' ) .'=h3; ';
		$block_formats 			.= __( 'Preformatted', 'manduca' ) .'=pre; ';
		$block_formats			.= __( 'Blockquote', 'manduca') .'=blockquote;';
		
		
		$init_array[ 'block_formats' ] = $block_formats;
		
			
    return $init_array;  
}

add_filter( 'tiny_mce_before_init', 'manduca_tinymce_init' );

endif;
	
	
	
	
/*
 *
 * Add in a core buttons that's disabled by default and stylebutton 
 *
 **/


function manduca_form_button( $buttons ) {	
	$buttons[] = 'superscript';
	$buttons[] = 'subscript';
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter( 'mce_buttons_2', 'manduca_form_button' );


function manduca_editor_css() {
	add_editor_style( 'editor.css' );    
}

add_action( 'after_setup_theme', 'manduca_editor_css' );

//-------------------------------------------------------------------------------------------
// Get custom header's alt data.
//-------------------------------------------------------------------------------------------
function manduca_get_header_image_alt() {
    $attachment_id = 0;
    
    if ( is_random_header_image() && $header_url = get_header_image() ) {
	    // For a random header, we have to search for a match against all headers.
	    foreach ( get_uploaded_header_images() as $header ) {
		    if ( $header['url'] == $header_url ) {
			    $attachment_id = $header['attachment_id'];
			    break;
		    }
	    }
    
    } elseif ( $data = get_custom_header() ) {
	    // For static headers, less intensive approach.
	    $attachment_id = $data->attachment_id;
    } 
    
    if ( $attachment_id ) {
	    $alt = trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) );

	    if ( ! $alt ) {
		    $alt = trim( strip_tags( get_post_field( 'post_excerpt', $attachment_id ) ) );
	    }
	    if ( ! $alt ) {
		    $alt = trim( strip_tags( get_post_field( 'post_title', $attachment_id ) ) );
	    }
    }
	else {
	    $alt = '';
    }
    
    return $alt;
}
  

//---------------------------------------------------------------------------------------------------------------------------
// Manduca body class
//---------------------------------------------------------------------------------------------------------------------------

function manduca_body_class( $classes ) {
	$background_color = get_background_color();
	$background_image = get_background_image();

	if ( ! is_active_sidebar( 'main_sidebar' ) || is_page_template( 'page-templates/full-width.php' ) ) {
		$classes[] = 'full-width';
	}

	if ( is_page_template( 'page-templates/front-page.php' ) ) {
		$classes[] = 'template-front-page';
		if ( has_post_thumbnail() ) {
			$classes[] = 'has-post-thumbnail';
		}
	}

	if ( empty( $background_image ) ) {
		if ( empty( $background_color ) ) {
			$classes[] = 'custom-background-empty';
		}
		elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) ) {
			$classes[] = 'custom-background-white';
		}
	}

	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	return $classes; 
}
add_filter( 'body_class', 'manduca_body_class' );


 /*
  *
  * original:
  * Display posts in two columns
  * but this was a bad typography and changed.
  *
  *Name has been remained for compatibility of child themes
  *
  * used in front-page and archive pages
 /**/
 
 if( !function_exists(  'manduca_display_excerpt' ) ) :
 
	function manduca_display_excerpt() {
	?>				<div class="excerpt-wrapper">
	
				<?php
				/* Start the Loop */
				while ( have_posts() ) : the_post(); ?>
					
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>  >
						
						<header class="excerpt-header">
							<?php manduca_display_entry_header(); ?>
						</header>
						
						<?php edit_post_link( __( 'Edit', 'manduca' ), '<span class="edit-link"><i class="fa fa-pencil" aria-hidden="true"></i> ', '</span>' ); ?>
						
							<?php if ( has_post_thumbnail() ) :?>
							<div class="crop-height">
								<?php the_post_thumbnail( 'excerpt-size' ); ?>
							</div>
							
							<div class="excerpt-entry has-thumbnail">
						
						<?php else : ?>
							<div class="excerpt-entry no-thumbnail">
						<?php endif; ?>
				
						
							<?php
								if( strpos( get_the_content(), 'more-link' ) === false ) {
									the_excerpt();
								}
								else {
									the_content();
								}
							?>
							</div>
						<div class='clearfix-content'></div>
					</article>				
				<?php
				endwhile;
				
				manduca_page_navigation();
				?>
				</div>
	<?php
	}
endif;
//-------------------------------------------------------------------------------------------
// Avatar need alt tag
//-------------------------------------------------------------------------------------------

    
function manduca_add_alt_to_avatar( $text )
{
	$alt = get_the_author_meta( 'display_name' );
	$text = str_replace( 'alt=""', 'alt="'.$alt . __( 'avatar', 'manduca' ) , $text );
	return $text;
}
add_filter( 'get_avatar', 'manduca_add_alt_to_avatar' );

//-------------------------------------------------------------------------------------------
// Make different  "continue reading" tags acccessible.
//-------------------------------------------------------------------------------------------
function manduca_more_unique_id () {
	$title = get_the_title();
	$firstwords = '';
	$space_count = 0;
	if ( get_locale() ==='hu_HU' ) {
		$firstwords ='a ';
		$hungarian_regex = '/^[aáeéiíoóöőuúüű]/i';
		if (preg_match ( $hungarian_regex, $title ) ) {
			$firstwords = 'az ';	
		}
	}
	for ( $char_count = 0 ; $char_count < strlen( $title ) ; $char_count++ ) {
		if ( $title{ $char_count } === ' ' ) {
			$space_count++;	
		}
		if( $space_count < 5 ) {
			$firstwords .= $title{ $char_count };
		}
	}
	if ( $space_count > 4) {
		$firstwords .= '&hellip;'; 
	}
	return  sprintf( __( 'Titled as follows: %s', 'manduca' ), $firstwords );
}

function manduca_content_more_link() {
	return '<a class="more-link" rel="nofollow" href="' . get_permalink() .'">' . __( 'Continue reading', 'manduca' ) .'&nbsp;<i class="fa fa-angle-double-right"></i>
<span class="screen-reader-text">' .manduca_more_unique_id() .'</span></a>';
}
add_filter( 'the_content_more_link', 'manduca_content_more_link' );
add_filter( 'excerpt_more', 'manduca_content_more_link' );

// add read-more link to manual excerpt
function manduca_manual_excerpt ( $param ) {
	global $post;
	if( $post->post_excerpt ) {
    return $param .'<a class="more-link" rel="nofollow" href="' . get_permalink() .'">' . __( 'Continue reading', 'manduca' ) .'&nbsp;<i class="fa fa-angle-double-right"></i>
<span class="screen-reader-text">  ' .manduca_more_unique_id() .'</span></a>';
	} else {
		return $param;
	}
}
add_filter('get_the_excerpt', 'manduca_manual_excerpt');

/*
* Add "ext-link" class aan d aria-label to external links
*
* */


function manduca_get_domain_name_from_uri( $uri ) {
	preg_match( '/^(http:\/\/)?([^\/]+)/i', $uri, $matches );
	$host = $matches[2];
	preg_match( '/[^\.\/]+\.[^\.\/]+$/', $host, $matches );
	return $host;
}


function mandcua_parse_external_links( $matches ) {
	if ( manduca_get_domain_name_from_uri( $matches[3] ) != manduca_get_domain_name_from_uri( $_SERVER["HTTP_HOST"] ) ) {
		
		$flag = FALSE ;
		foreach( $matches as $key => $match ) {
			
			if( !empty ($match) ) {
	
				if ( strpos( $match, 'class=') !== FALSE  ) {
					$matches[$key] = str_replace ( 'class="', 'class="ext-link ', $match);
					$flag = TRUE;
				}
			}
		}
		if ( $flag ) {
		$pattern = '<a href="' . $matches[2] . '//' . $matches[3] . '"' . $matches[1] . $matches[4] .'>' . $matches[5] . '<span class="screen-reader-text"> ' .__( 'external', 'manduca' ) .'</span></a>';	 	
		}
		else {
			$pattern = '<a href="' . $matches[2] . '//' . $matches[3] . '"' . $matches[1] . $matches[4] .' class="ext-link">' . $matches[5] . '<span class="screen-reader-text"> ' .__( 'external', 'manduca' ) .'</span></a>';	 
		}
		return $pattern;
	
	} else {
		return '<a href="' . $matches[2] . '//' . $matches[3] . '"' . $matches[1] . $matches[4] . '>' . $matches[5] . '</a>';
	}
}
	

function manduca_external_links( $text ) {
	$pattern = '/<a (.*?)href="(.*?)\/\/(.*?)"(.*?)>(.*?)<\/a>/i';
	$text = preg_replace_callback( $pattern, 'mandcua_parse_external_links', $text );
	return $text;
}

// filters have high priority to make sure that any markup plugins like Textile or Markdown have already created the HTML links
add_filter( 'the_content', 'manduca_external_links', 999 );
add_filter( 'the_excerpt', 'manduca_external_links', 999 );

// delete this one if you don't want it run on comments
add_filter( 'comment_text', 'manduca_external_links', 999 );

/**
 * Change HTML headings
 * 
 * */

if( !function_exists( 'manduca_heading_correction' ) ) :

	function manduca_heading_correction ( $content ) {
		if ( is_archive() ) {
			$content = str_replace( '<h4>', '<h5>', $content );
			$content = str_replace( '</h4>', '</h5>', $content );
			$content = str_replace( '<h3>', '<h4>', $content );
			$content = str_replace( '</h3>', '</h4>', $content );
			$content = str_replace( '<h2>', '<h3>', $content );
			$content = str_replace( '</h2>', '</h3>', $content );
		}
		return $content;
	}

	add_filter( 'the_content', 'manduca_heading_correction' );

endif;

/*
 * Speed up page
 * Function to add async to all scripts
 * 
 */

if( !function_exists( 'manduca_js_async' ) ) :

	function manduca_js_async( $tag, $handle ) {
		if( !is_admin() ) {
			$tag = str_replace( ' src', ' async defer src', $tag );
		}
		
		return $tag;
	}

add_filter( 'script_loader_tag', 'manduca_js_async', 20, 2 );
	
endif;


/**
 * Breadcrumb navigation
 * 
 * Display breadcrumb navigation
 *     = display category in case of sinlge post
 *     = display hierarchy of pages
 * 
 * @since 2.1.4
 *
 *  
 */


if( !function_exists( 'manduca_breadcrumb') ) :

function manduca_breadcrumb() {
	
	if (is_home() || is_front_page() ) {
		printf( '<strong>%s</strong>', __( 'Home', 'manduca' ) );
	}
	
	else {
		?>
		<a rel="bookmark" href="<?php echo get_site_url(); ?>"><?php _E( 'Home', 'manduca' ); ?></a><i class="fa fa-angle-double-right" aria-hidden="true"></i>
		<?php
		
			/**
			* Add custom post types or custom taxonomies here
			*
			* @since 16.7
			*/
		
			do_action( 'manduca_custom_breadcrumb' );
			
			if (is_category() ) { 
					$category_ID  		= get_queried_object()->term_id;
					$category_object 	= get_category( $category_ID );
					$parent_ID			= $category_object->category_parent;
					if( $parent_ID !== 0 ) {
						echo get_category_parents( $parent_ID, true, '<i class="fa fa-angle-double-right" aria-hidden="true"></i>' );
					}
					single_cat_title();
			}
			
			
			
			elseif (is_single()) { //Title of post in category
			
				
				$term_object = get_the_terms( get_the_ID() , 'category' );
				$term  = $term_object [0];
				$link = esc_url( get_term_link( $term ) );
				
				//get parent
				$parent_object  = get_term_by( 'id', $term->parent, 'category' );
				if ( !empty( $parent_object) ) { 
					$parent_link = esc_url( get_term_link( $parent_object ) );
					
					echo sprintf( '<a href="%1$s">%2$s</a><i class="fa fa-angle-double-right" aria-hidden="true"></i><a href="%3$s">%4$s</a><i class="fa fa-angle-double-right" aria-hidden="true"></i>%5$s' ,
								$parent_link,
								$parent_object->name,
								$link,
								$term->name,
								the_title( '', '', FALSE )
								);
				}
				else {
					
					the_title();
				}
			}
		
		elseif ( is_page() ) {
			global $post;
			$first_parent = $post->post_parent;
			
			$first_parent_object = get_post( $first_parent );
			$second_parent = $first_parent_object->post_parent;
			
			
			if ( $second_parent ) {
				printf( '<a href="%1$s">%2$s</a><i class="fa fa-angle-double-right" aria-hidden="true"></i>',
					   get_page_link( $second_parent ),
					   get_the_title( $second_parent )
					  );
			}
			if ( $first_parent ) {
				printf( '<a href="%1$s">%2$s</a><i class="fa fa-angle-double-right" aria-hidden="true"></i>',
					   get_page_link( $first_parent ),
					   get_the_title( $first_parent )
					  );
			}
			
			
			the_title();
		}
		
		if (is_404()) {
			_e( 'Page not found', 'manduca' );
		}
		if (is_search()) {
			_e( 'Search', 'manduca' );
		} ?>
	
	<?php
	}
}


endif;




/*
 * Post navigation
 *
 * */

 
 
 if( !function_exists( 'manduca_post_navigation' ) ) :
 
 function manduca_post_navigation() {
	?>
	
	<nav class="nav-single">
		
			<?php
			$previous_post	= get_previous_post_link(  '%link', '<span>%title</span>' );
			$next_post		= get_next_post_link( '%link', '<span>%title</span>' );
				if( !empty( $previous_post ) ) : ?>
				<div class="nav-previous">
					<p class="assistive-text"><?php _e( 'Previous post', 'manduca' ) ?></p>
					<?php  echo $previous_post; ?>
					<?php paginate_links(); //the sake of themecheck.  I.e. there is no need for that but theme check requires it. ?>
				</div>
				
				<?php endif;
				
				
				if( !empty( $next_post ) ) : ?>
				<div class="nav-next">
					<p class="assistive-text"><?php _e( 'Next post', 'manduca' ) ?></p>
					<?php echo $next_post; ?>
				</div>
				<?php endif;
			?>
		
	</nav><!-- .nav-single -->
 
 <?php 
 }
 
 endif;
 /*
  * Display entry header
  * Display the header of the article in two-column format. 
  *
  * since @16.8
  * */
 
 if( !function_exists( 'manduca_display_entry_header' ) ) :
 
 function manduca_display_entry_header() {
	?>
	
	<div class="columns-mask">
		<div class="columns-wrapper">
			<div class="column-right-wrapper">
				<div class="column-right">
						<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
							<div class="featured-post"><?php _e( 'Featured', 'manduca' ) ?></div>
						<?php endif; ?>
		
					<?php if ( is_single() ) : ?>
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php else : ?>
						<h2 class="entry-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
						</h2>
					<?php endif; // is_single() ?>
				</div>
			</div>
			
			<div class="column-left">
			
					<?php
					$month 	= esc_html( get_the_date( 'M' ) );
					$day	= esc_html( get_the_date( 'j' ) );
		
					if ( get_bloginfo( 'language' ) ==='hu-HU' ) {
							setlocale(LC_ALL, 'hu_HU.UTF8');
							$month 		=  strftime( '%b', get_post_time('U', true) ) .'.' ;
							$day 		.= '.';
					}
					
					/*
					 *  Filter of content date of the entry header
					 * @ since 16.8
					 * */
					echo apply_filters( 'manduca_content_date', 
						sprintf( '<p class="content-date"><time class="entry-date" datetime="%1$s"></time><span class="entry-date-month">%4$s</span><span class="entry-date-day">%3$s</span><span class="entry-date-year">%2$s</span></p>',
							esc_attr( get_the_date( 'c' ) ),
							esc_attr( get_the_date( 'Y' ) ),
							$day,
							$month
					   )
					); ?>
			
			</div>
		</div>	
	</div>
	
		
	
<?php	
 }
 
 endif;
 
/*
 * Stop reserving slug for media items.
 * Computes a unique slug for the post, when given the desired slug and some post details.
 *
 * @since 16.7
 *
 **/

add_filter( 'wp_unique_post_slug_is_bad_attachment_slug', '__return_true' );




/**
 * Displays previous image link
 * in spite of the WP function: browse all, not only the ones belong the same parent.
 *
 * @since 16.7
 *
 * @param bool         $prev Optional. Whether to display the next (false) or previous (true) link. 
 * 
 */

function manduca_adjacent_image_link( $prev ) {
	
    $post = get_post();
    $attachments = array_values( get_children( array(
													 'post_status' => 'inherit',
													 'post_type' => 'attachment',
													 'post_mime_type' => 'image',
													 'order' => 'ASC',
													 'orderby' => 'menu_order ID' ) ) );
 
    foreach ( $attachments as $k => $attachment ) {
        if ( $attachment->ID == $post->ID ) {
            break;
        }
    }
 
    $output = '';
    $attachment_id = 0;
 
    if ( $attachments ) {
        $k = $prev ? $k - 1 : $k + 1;
		$text = $prev ?  __( 'Previous', 'manduca' ) : __( 'Next', 'manduca' ) ;
 
        if ( isset( $attachments[ $k ] ) ) {
            $attachment_id = $attachments[ $k ]->ID;
            $output = wp_get_attachment_link( $attachment_id, false, true, false, $text );
        }
    }
	if ( !empty( $output ) ) {
		if ( $prev ) {
			printf( '<div class="nav-previous">%s</div>', $output );
    
		}
		else {
			printf( '<div class="nav-next">%s</div>', $output );
		}
	}
	
}

	
 
?>