<?php
/**
 * Manduca
 *
 * @since 1.0 */
 
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title" ><?php the_title(); ?></h1>
			
		</header>

		<div class="entry-content">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' .__( 'Pages',' manduca' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		
		
		<footer class="entry-meta">
			<?php edit_post_link( '<i class=\"fa fa-pencil\" aria-hidden="true"></i>' .__( 'Edit', 'manduca' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
