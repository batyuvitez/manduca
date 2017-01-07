<?php
/**
 * Manduca
 *
 * @since 1.0 */
 
		/* Before footer hook
		 * */
		do_action( 'manduca_after_content' );

?>			</div><!-- .outer-wrapper -->
				</div><!-- .wrapper -->
				<div id="footer-wrapper" class="footer-wrapper">
					<footer id="colophon" >
						<?php
							/*add comething at the beginning of footer
							 **/
							do_action( 'manduca_before_footer' );
						?>
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
							
							/*
							 * filter of copyright text
							 * @since 16.12
							 * */
							
							echo apply_filters( 'manduca_copyright_text' , sprintf ('<p class="copyright-text">&copy; %1$s, %2$s</p>', date( 'Y' ), get_bloginfo() ) ) ;
							?>
								
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