<?php
/**
 * Default homepages
 * 
 * @ Theme: Manduca - focus on accessibility
 * @ Since 1.0
 **/
?>
<?php get_header(); ?>

		<?php if ( have_posts() ) : ?>

			<header>
				<h1 id="homepage" tabindex="0"><?php echo apply_filters( 'manduca_home_title', get_bloginfo( 'description' ) ); ?></h1>
			</header>

			<?php get_template_part( 'template-parts/posts/content', 'excerpt' ); ?>
			
		<?php else : ?>

			<article class="post no-results not-found">
				<header>
					<h1><?php _e( 'No matching result found.', 'manduca' ) ?></h1>
				</header>

				<div class="entry-content">
					<?php get_search_form(); ?>
				</div>	
			</article>

		<?php endif; ?>

<?php get_footer(); ?>