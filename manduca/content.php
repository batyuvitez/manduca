<?php
/**
 * Manduca
 *
 * @since 1.0 */

?>		
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<header class="entry-header">
			<?php manduca_display_entry_header(); ?>
		
			<?php do_action('manduca_after_title'); ?>
		
		</header><!-- .entry-header -->
		
		
		<?php edit_post_link( __( 'Edit', 'manduca' ), '<span class="edit-link"><svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M491 1536l91-91-235-235-91 91v107h128v128h107zm523-928q0-22-22-22-10 0-17 7l-542 542q-7 7-7 17 0 22 22 22 10 0 17-7l542-542q7-7 7-17zm-54-192l416 416-832 832h-416v-416zm683 96q0 53-37 90l-166 166-416-416 166-165q36-38 90-38 53 0 91 38l235 234q37 39 37 91z"/></svg>', '</span>' ); ?>
		
		<?php if ( ! post_password_required() && ! is_attachment() ) :
				the_post_thumbnail( 'post-size' ); endif; ?>
			

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
			
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading', 'manduca' ) .'<span class="screen-reader-text">  ' .get_the_title() .'</span><span class="meta-nav" aria-hidden="true">&rarr;</span>' ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Paging', 'manduca' ), 'after' => '</div>' ) ); ?>
		<div class="clearfix-content"></div>
		</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">
			<?php manduca_entry_meta(); ?>
			<?php edit_post_link( __( 'Edit', 'manduca' ), '<span class="edit-link"><svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M491 1536l91-91-235-235-91 91v107h128v128h107zm523-928q0-22-22-22-10 0-17 7l-542 542q-7 7-7 17 0 22 22 22 10 0 17-7l542-542q7-7 7-17zm-54-192l416 416-832 832h-416v-416zm683 96q0 53-37 90l-166 166-416-416 166-165q36-38 90-38 53 0 91 38l235 234q37 39 37 91z"/></svg>', '</span>' ); ?>
			<?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) :  ?>
				<div class="author-info">
					<div class="author-avatar">
						<?php
						/** This filter is documented in author.php */
						$author_bio_avatar_size = apply_filters( 'manduca_author_bio_avatar_size', 68 );
						echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
						?>
					</div><!-- .author-avatar -->
					<div class="author-description">
						<h3><?php printf( __( 'Author: %s', 'manduca' ), get_the_author() ); ?></h3>
						<p><?php the_author_meta( 'description' ); ?></p>
						<div class="author-link">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php printf( __( 'All posts by %s', 'manduca' ) . '<span class="meta-nav">&rarr;</span>', get_the_author() ); ?>
							</a>
						</div><!-- .author-link	-->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
			<?php endif; ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
