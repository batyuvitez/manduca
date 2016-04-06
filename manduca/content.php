<?php
/**
 * Manduca
 *
 * @since 1.0 */

?>		
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost" >
		<header class="entry-header">
				<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
					<div class="featured-post"><?php _e( 'Featured', 'manduca' ) ?></div>
				<?php endif; ?>

			<?php if ( is_single() ) : ?>
				<h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
				<?php else : ?>
				<h2 class="entry-title"  itemprop="headline">
					<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
			<?php endif; // is_single() ?>
			
			<?php manduca_entry_meta( true ); ?>
			<div class="clearfix"></div>
		</header><!-- .entry-header -->
		
		<?php edit_post_link( __( 'Edit', 'manduca' ), '<span class="edit-link"><i class="fa fa-pencil" aria-hidden="true"></i> ', '</span>' ); ?>
		
		<?php if ( ! post_password_required() && ! is_attachment() ) :
				the_post_thumbnail( 'large' ); endif; ?>
			

		<?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
			
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content" itemprop="text">
			<?php the_content( __( 'Continue reading', 'manduca' ) .'<span class="screen-reader-text">  ' .get_the_title() .'</span><span class="meta-nav" aria-hidden="true">&rarr;</span>' ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Paging', 'manduca' ), 'after' => '</div>' ) ); ?>
		<div class="clearfix-content"></div>
		</div><!-- .entry-content -->
		<?php endif; ?>

		<footer class="entry-meta">
			<?php manduca_entry_meta(); ?>
			<?php edit_post_link( __( 'Edit', 'manduca' ), '<span class="edit-link"><i class="fa fa-pencil" aria-hidden="true"></i> ', '</span>' ); ?>
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
