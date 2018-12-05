<?php
/**
 * Manduca
 *
 * @since 1.0 */
 
?>
<?php $title = str_replace(' | ', '<br />', get_the_title() ); // Change | to line break ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<header>
				<h1><?php echo $title ; ?></h1>
						
			
				<?php if ( has_post_thumbnail() ) :  ?>
				
					<div>
						<?php the_post_thumbnail( 'post-size' ); ?>
					</div>
		
				<?php endif; ?>
			
		</header>
			
				
	<?php get_template_part( '/template-parts/postlink', 'edit' ) ;?>
	
	<div class="entry-content">
		
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' .__( 'Pages',' manduca' ), 'after' => '</div>' ) ); ?>
	
	</div>
	
	<div class="clearfix-content"></div>
	
</article>