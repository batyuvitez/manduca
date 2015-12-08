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
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body id="total" <?php body_class(); ?>>
<div id="page" class="hfeed site">
	
	
	<div id="header-bar" class="header-bar">
		<header id="masthead" class="site-header" role="banner"  itemtype="https://schema.org/WPHeader" itemscope="itemscope">
			<a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				<?php get_search_form(); ?>
		</header>
	</div>
		
	<div class="vonalzo"></div>

		<?php if( ( is_home() || is_front_page() ) && get_header_image() ) : ?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php header_image(); ?>" class="header-image" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( manduca_get_header_image_alt() ); ?>" /></a>
		<?php endif; ?>
	
	<nav id="site-navigation" class="main-navigation" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
		<button id="menu-toggle" class="menu-toggle"><i class="fa fa-bars" aria-hidden="true">&nbsp;</i><?php _e( 'Menu', 'manduca' ) ?></button>
		<a class="assistive-text" href="#content"><?php _e( 'Skip to content', 'manduca' ); ?></a>
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
	</nav><!-- #site-navigation -->


	<div class="breadrcumb "id="breadcrumb">	
				<?php if ( function_exists( 'yoast_breadcrumb' ) ) {
					yoast_breadcrumb( '<p>','</p>' );
				} ?>
			</div>

	<div id="wrapper" class="wrapper" tabindex="-1">