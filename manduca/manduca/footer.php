<?php
/**
 * Display end of the page 
 *
 * @ Theme: Manduca - focus on accessibility 
 * @ since 1.0
 **/
?>
						
								</main>
							</div> <?php // END #primary .site-content ?>
							 
						 <?php get_sidebar(); ?>
			 
					</div> <?php // END .wrapper ?>
					
					<?php get_template_part( 'template-parts/footer/footer', 'before' ); ?>
						   
				<div id="footer-wrapper" class="footer-wrapper">
					<footer id="colophon" >
						<?php
							/*add something at the beginning of footer
							 * To be  Depreciated since 17.4
							 * */
							do_action( 'manduca_before_footer' );
						?>
						
						<div class="site-info">
						
						<?php get_template_part( 'template-parts/footer/footer', 'menu' ); ?>
						
						<?php get_template_part( 'template-parts/footer/footer', 'siteinfo' ); ?>
						
						</div>
											
						<?php
						/*
						 * Add action after footer
						 * to be depretiated - use template instead
						 * */
						do_action( 'manduca_after_footer' );
						?>
						
					</footer>
					<div class="clearfix"></div>
				</div>

			<?php get_template_part( 'template-parts/footer/footer', 'after' ); ?>
			
			<?php wp_footer(); ?>
			
		</div> <?php // closing tag of  .site #page  ?>
	</body>
</html>