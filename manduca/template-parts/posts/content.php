<?php
/**
 * Manduca
 *
 * @since 1.0 */

?>		
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php if ( has_post_thumbnail() ) {
				$class = 'has-thumbnail'; 
			}
			else{
				$class = 'no-thumbnail';
			}
			//display header tag
			printf( '<header class="%1$s">',
				   $class
				   );
	?>
			
		<?php get_template_part( 'template-parts/posts/entry-header' ); ?>

		<?php if ( has_post_thumbnail() ) : ?>
			
			<div>
				<?php the_post_thumbnail( 'post-size' ); ?> 
			</div>

		<?php endif; ?>
		
		<?php //deprecated_after_title_function(); ?>
		
	</header>
			
	<?php get_template_part( '/template-parts/postlink', 'edit' ) ; ?>
	

	<div class="entry-content" >
		<?php Manduca_Template_Functions::manduca_link_pages(); ?>
		<?php the_content() ; //last correction: @17.9?>
		<?php Manduca_Template_Functions::manduca_link_pages(); ?>
	<div class="clearfix-content"></div>
	</div>
	
	<?php
		/* Action hook: manduca_after_entry_content
		 * Add something after entry content
		 * @since 17.2.8
		 * */
		do_action( 'manduca_after_entry_content' );
	?>

	<footer>
		<?php get_template_part( 'template-parts/posts/content', 'meta' ); ?>
	</footer>

</article>