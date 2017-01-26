<?php
/**
 * Manduca
 *
 * @since 1.0 */

?>		
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<header class="entry-header">
			
			<?php
				manduca_display_entry_header(); 
			
			/* Action hook
			 * name: add code after entry header
			 **/
			do_action('manduca_after_title');
			
			
			/* Boolean filter
			* @ name: manduca_meta_in_header
			* @ true : default : show meta data in footer
			* @ false : show meta data in entry header
			* since @17.1
			 **/
			$meta_flag = FALSE;
			$meta_flag  = apply_filters( 'manduca_meta_in_header' , FALSE ) ;
			if( $meta_flag ) :
			?>
				<a href="#entry-content" class="screen-reader-text"><?php _e( 'Jump the meta to the post' , 'manduca' ); ?></a>
				<div class="entry-meta">
				<?php get_template_part( 'content', 'meta' ); ?>
			</div>			
			<?php endif; ?>
				
			
			
		
			
		</header><!-- .entry-header -->
		
		
		<?php edit_post_link( __( 'Edit', 'manduca' ), '<span class="edit-link"><svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M491 1536l91-91-235-235-91 91v107h128v128h107zm523-928q0-22-22-22-10 0-17 7l-542 542q-7 7-7 17 0 22 22 22 10 0 17-7l542-542q7-7 7-17zm-54-192l416 416-832 832h-416v-416zm683 96q0 53-37 90l-166 166-416-416 166-165q36-38 90-38 53 0 91 38l235 234q37 39 37 91z"/></svg>', '</span>' ); ?>
		
		<?php if ( ! post_password_required() && ! is_attachment() ) :
				the_post_thumbnail( 'post-size' ); endif; ?>
			

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
			
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content" id="entry-content" >
			<?php the_content( __( 'Continue reading', 'manduca' ) .'<span class="screen-reader-text">  ' .get_the_title() .'</span><span class="meta-nav" aria-hidden="true">&rarr;</span>' ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Paging', 'manduca' ), 'after' => '</div>' ) ); ?>
		<div class="clearfix-content"></div>
		</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">
			<?php
				if( !$meta_flag ) {
					get_template_part( 'content', 'meta' );
				}
			?>
			
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
