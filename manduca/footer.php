<?php
/**
 * Manduca
 *
 * @since 1.0 */
 
?>
				</div><!-- #main .wrapper -->
				<div id="footer-wrapper" class="footer-wrapper">
					<footer id="colophon" >
						<?php do_action( 'manduca_before_footer' ); ?>
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
									echo '<nav id="footer-navigation" class="footer-navigation">' .$menu .'</nav>';
								}
							?>
							<p>&copy; <?php echo date( 'Y' ) .", " .esc_html( get_theme_mod( 'manduca_copyright_text', get_bloginfo() ) ); ?></p>
						</div><!-- .site-info -->
						<?php do_action( 'manduca_after_footer' ); ?>
					</footer><!-- #colophon -->
					<div class="clearfix"></div>
				</div>
		
			</div><!-- #page -->
		
			<?php wp_footer(); ?>
		</div><!-- #svg-layer -->
	</body>
</html>