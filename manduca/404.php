<?php
/**
 * Manduca
 *
 * @since 1.0 */



get_header(); ?>

	<div id="primary" class="site-content">
		<main id="content">

			<article id="post-0" class="post error404 no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title">
						<?php _e( 'Error 404 &#45; Page Not Found!', 'manduca' ); ?>
					</h1>
					
				</header>

				<div class="entry-content" >
					<p>
						<?php _e( 'The requested page could not be located on this blog. We highly recommend to choose from the HTML sitemap below.', 'manduca' ) ?>
					</p>	
					
					<?php get_template_part( 'template-parts/sitemap' ); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		</main><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>