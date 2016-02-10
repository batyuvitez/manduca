<?php
/**
 * Manduca
 *
 * @since 1.0 */
 
?>
		</div><!-- #main .wrapper -->
		<div id="footer-wrapper" class="footer-wrapper">
			<footer id="colophon" role="contentinfo" itemtype="https://schema.org/WPFooter" itemscope="itemscope" >
				<div class="site-info">
					<?php
						$menu = wp_nav_menu(array (
								'echo' => false,
								'fallback_cb' => '__return_false',
								'container'       	=> false,
								'theme_location' 	=> 'footer',
								'menu_class' 		=> 'footer-menu'
							) );
						
						if ( ! empty ( $menu ) ) {
							echo '<nav id="footer-navigation" class="footer-navigation" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">' .$menu .'</nav>';
						}
					?>
					<p>&copy; <?php echo date( 'Y' ) ."., " .esc_html( get_theme_mod( 'manduca_copyright_text', get_bloginfo() ) ); ?></p>
				</div><!-- .site-info -->
			</footer><!-- #colophon -->
			<div class="clearfix"></div>
		</div>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>