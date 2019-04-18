<?php
/**
 * Displaying excerpts of search
 * IMPORTANT! Includes the hook
 *
 * This files is the same as excerpt.
 * 
 * @ Theme Manduca - focus on accessibility
 * @ Since 18.1.6
 **/
 
?>





<div class="excerpt-wrapper">

	<?php while ( have_posts() ) : the_post();  ?>
		
		<?php $extra_classes = is_sticky() ? 'excerpt featured-scheme' : 'excerpt' ; ?>
		
		<article id="post-<?php echo the_ID(); ?>" <?php post_class( $extra_classes ); ?>>
		 
			<header class="excerpt-header">
				<?php get_template_part( 'template-parts/posts/entry-header' ); ?>
			</header>
		
			 <?php get_template_part( '/template-parts/postlink', 'edit' ) ; ?>
		
		
			<?php if ( has_post_thumbnail() ) : ?>
				 <div class="post-thumbnail">
					<?php the_post_thumbnail( 'excerpt-size' ); // defined in Manduca 268*178 | aspect-ratio: 1.5:1  ?>
				 </div>
			<?php endif; ?>
			 
				
			<div class="entry-content">		
					<?php echo Manduca_Template_Functions::get_the_excerpt(); ?>
			</div>
			
			<div class="clearfix-content"></div>
		
		</article>
		
	<?php endwhile; ?>

</div>

<?php echo Manduca_Template_Functions::post_navigation(); ?>