<?php
/**
 * Manduca
 *
 * @since 1.0 */

?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />

<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body id="total" <?php body_class(); ?>>
	<div id="svg-layer">
		<?php echo apply_filters( 'manduca_background_images', '' ); ?>
		<div id="page" class="hfeed site">
			<div class="top-bar" id="top-bar"></div>
			<div id="masthead" class="site-header" >
				<div id="header-bar" class="header-bar">
					<header>
						<a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'manduca' ); ?></a>
						<a class="screen-reader-text skip-link" href="#secondary"><?php _e( 'Skip to sidebar', 'manduca' ); ?></a>
						
						<?php
						/*
						 *Filter of site title
						 **/
						echo apply_filters( 'manduca_site_title', sprintf ( '<a class="site-title" href="%1$s" rel="home">%2$s</a>', esc_url( home_url( '/' ) ) , get_bloginfo( 'name' ) ) );
						
						/*
						 *Filter of blog description
						 **/
						echo apply_filters( 'manduca_blog_description', '' );
						?>
						
						<form role="search" method="get" id="header-searchform" class="header-searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<div>
							<label class="screen-reader-text" for="s" ><?php _e( 'Search', 'manduca' ) ?></label>
							<input type="text" placeholder="<?php _e( 'Search', 'manduca' ) ?>" value="<?php echo get_search_query(); ?>" name="s"  id="s" />
							<button type="submit" class="search-submit" id="search-submit" aria-label="<?php _e( 'Start search', 'manduca' ) ?>" >
								<span class="screen-reader-text">
									<?php _e( 'Search', 'manduca' ) ?>
								</span>
								<svg id="search-icon" class="search-icon" viewBox="0 0 24 24">
									<path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
									<path d="M0 0h24v24H0z" fill="none"/>
								</svg>
							</button>
						</div>
					</form>
						
					</header>
				</div>
			
					<?php if( ( is_home() || is_front_page() ) && get_header_image() ) : ?>
						<img src="<?php header_image(); ?>" class="header-image" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( manduca_get_header_image_alt() ); ?>" />
					<?php endif; ?>
				
				<button id="menu-toggle" class="menu-toggle"><svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1664 1344v128q0 26-19 45t-45 19h-1408q-26 0-45-19t-19-45v-128q0-26 19-45t45-19h1408q26 0 45 19t19 45zm0-512v128q0 26-19 45t-45 19h-1408q-26 0-45-19t-19-45v-128q0-26 19-45t45-19h1408q26 0 45 19t19 45zm0-512v128q0 26-19 45t-45 19h-1408q-26 0-45-19t-19-45v-128q0-26 19-45t45-19h1408q26 0 45 19t19 45z"/></svg><?php _e( 'Menu', 'manduca' ) ?></button>	
				
				<div id="site-header-menu" class="site-header-menu">
					<?php if ( has_nav_menu( 'primary' ) ) : ?>
						<nav id="site-navigation" class="main-navigation" aria-label="<?php _e( 'Primary Menu', 'manduca' ); ?>">
							<?php
								/*
								*Filter of submenu icon
								**/
								$submenu_icon = apply_filters( 'manduca_submenu_icon' , '<svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1395 736q0 13-10 23l-466 466q-10 10-23 10t-23-10l-466-466q-10-10-10-23t10-23l50-50q10-10 23-10t23 10l393 393 393-393q10-10 23-10t23 10l50 50q10 10 10 23z"/></svg>' );
			
								wp_nav_menu( array(
									'theme_location' => 'primary',
									'menu_class'     => 'primary-menu',
									'after'			 => $submenu_icon
								 ) );
							?>
						</nav><!-- .main-navigation -->
					<?php endif; ?>
				</div>
			
					<?php 
						/*		
						 *  Add breadcrumb  at the very end of masthead
						 * @ since 16.10
						 * */
						
						do_action( 'manduca_masthead_end' );
					
					?> 
			
				
		
			</div><!-- .masthead -->
	
			<div id="wrapper" class="wrapper">