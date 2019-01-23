<?php
/* The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @theme: Manduca - focus on accessibility 
 * @since 1.0
 * @version 17.10.11
 **/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php wp_head(); ?>
<!-- Manduca <?php echo ( is_child_theme() )? wp_get_theme()->parent()->Version : wp_get_theme()->Version ; ?> - focus on accessibility  -->
</head>
<?php
	/*
	 * Additional body classes
	 **/
	$background_color 	= get_background_color();
	$background_image 	= get_background_image();
	$classes			= array();
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
	
	//Detect visitors browser and add to body tag	
	$browser_classes = new Browser_Type();
	$classes		= array_merge( $classes , $browser_classes->classes() );
	unset( $browser_classes );
?>


<body id="total" <?php body_class( $classes ); ?>>
		
		<?php get_template_part( '/template-parts/header/backgroundimages' ); ?>
		
		<div id="page" class="hfeed site">
			
			<noscript>
				<div id="no-javascript">
					<?php _e( 'JavaScript is off. Please enable to use all functions.', 'manduca' ); ?></div>
			</noscript>
			
			<div  id="top-bar" class="top-bar"></div>
			
			<?php get_template_part( '/template-parts/header/skiplinks' ); ?>
			
			<div id="masthead" class="site-header megamenu-parent" >
			
				<div id="header-bar" class="header-bar">
					<header>											
						<?php get_template_part( '/template-parts/header/sitetitle' ); ?>
						
						<?php get_template_part( '/template-parts/header/toolbar' ); ?>
						
					
					
					</header>
				</div>
						
					<?php get_template_part( '/template-parts/header/headerimage' ); ?>
					
					<?php get_template_part( '/template-parts/header/menu' ); ?>
					
					<?php get_template_part( '/template-parts/header/searchform' ); ?>
				
					
			</div>
			
				<div id="wrapper" class="wrapper">
					
					<?php get_template_part( '/template-parts/header/breadcrumb' , 'template' ); ?>
					
					<div id="primary" accesskey="s" class="site-content">
						<main id="content">