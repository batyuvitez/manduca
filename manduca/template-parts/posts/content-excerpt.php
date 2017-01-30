<?php
/**
 * The template for displaying search results pages
 *
 * 
  * @subpackage Manduca
 *  @since 17.1
 */
 
?>
<div class="excerpt-wrapper" id="entry-content">

	<?php
	/* Start the Loop */
	while ( have_posts() ) : the_post(); ?>
		
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>  >
			
			<header class="excerpt-header">
				<?php get_template_part( 'template-parts/posts/entry-header' ); ?>
			</header>
			
			<?php edit_post_link( __( 'Edit', 'manduca' ), '<span class="edit-link">', '</span>' ); ?>
			
				<?php if ( has_post_thumbnail() ) :?>
				<div class="crop-height">
					<?php the_post_thumbnail( 'excerpt-size' ); ?>
				</div>
				
				<div class="excerpt-entry has-thumbnail">
			
			<?php else : ?>
				<div class="excerpt-entry no-thumbnail">
			<?php endif; ?>
	
			
				<?php
					if( strpos( get_the_content(), 'more-link' ) === false ) {
						the_excerpt();
					}
					else {
						the_content();
					}
				?>
				</div>
			<div class='clearfix-content'></div>
		</article>				
	<?php
	endwhile;
	?>
</div>
	