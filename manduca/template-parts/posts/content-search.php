<?php
/**
 * Displaying excerpts of search
 *
 * This files is based on content-excerp in Manduca v18.1
 * 
 * @ Theme Manduca - focus on accessibility
 * @ Since 18.1.6
 **/
?>


<?php $nav = Manduca_Template_Functions::post_navigation(); ?>

<?php echo $nav; ?>

<div class="excerpt-wrapper">

	<?php while ( have_posts() ) : the_post();  ?>
		<article id="post-<?php echo the_ID(); ?>" <?php post_class( 'excerpt' ); ?>>
		 
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
		
		<?php if( strpos( get_the_content(), 'more-link' ) === false ) : ?>
				<?php the_excerpt(); ?> 
		<?php else:  ?>
	
			<?php the_content(); ?>
		<?php endif; ?>
		
		</div>
		<div class="clearfix-content"></div>
		</article>
		
	<?php endwhile; ?>
</div>

<?php echo $nav; ?>