<?php
/**
 * Manduca
 *
 * @since 1.0 */

get_header(); ?>

	<div id="primary" class="site-content">
		<main id="content">

		<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class( 'image-attachment' ); ?>>
					
					<nav id="image-navigation" class="nav-single">
							
							<?php manduca_adjacent_image_link( true ); ?>
							<?php manduca_adjacent_image_link( false ) ; ?>  
							
						</nav><!-- .nav-single -->
					
					<header class="entry-header">
						<h1 class="entry-title" ><?php the_title(); ?></h1>
						
						
						
					</header><!-- .entry-header -->

					<div class="entry-content">

						
						<div class="attachment">
								<?php
								
								$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
								foreach ( $attachments as $k => $attachment ) :
									if ( $attachment->ID == $post->ID )
										break;
								endforeach;
								
								if ( count( $attachments ) > 1 ) :
									$k++;
									if ( isset( $attachments[ $k ] ) ) :
										// get the URL of the next image attachment
										$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
									else :
										// or get the URL of the first image attachment
										$next_attachment_url = get_attachment_link( $attachments[0]->ID );
									endif;
								else :
									// or, if there's only 1 image, get the URL of the image
									$next_attachment_url = wp_get_attachment_url();
								endif;
								?>
								<a href="<?php echo esc_url( $next_attachment_url ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php
								/**
 								 * Filter the image attachment size to use.
								 *
								 
								 *
								 * @param array $size {
								 *     @type int The attachment height in pixels.
								 *     @type int The attachment width in pixels.
								 * }
								 */
								$attachment_size = apply_filters( 'manduca_attachment_size', array( 960, 960 ) );
								echo wp_get_attachment_image( $post->ID, $attachment_size );
								?></a>

								
						</div><!-- .attachment -->
						

						<div class="entry-description">
							<?php wp_link_pages( array( 'before' => '<div class="page-links">'. __( 'Pages', 'manduca' ), 'after' => '</div>' ) ); ?>
						</div><!-- .entry-description -->
						
						
						<footer class="entry-meta">
							<?php
								$metadata = wp_get_attachment_metadata();
								sprintf( '<span class="meta-prep meta-prep-entry-date">' .__( 'Date:', 'manduca' ) .'</span> <span class="entry-date"><time class="entry-date" datetime="%1$s">%2$s</time></span>, '. __( 'Original size', 'manduca' ) . ': <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> ',
									esc_attr( get_the_date( 'c' ) ),
									esc_html( get_the_date() ),
									esc_url( wp_get_attachment_url() ),
									$metadata['width'],
									$metadata['height'],
									esc_url( get_permalink( $post->post_parent ) ),
									esc_attr( strip_tags( get_the_title( $post->post_parent ) ) ),
									get_the_title( $post->post_parent )
								);
								
							
						    $image_alt 			= get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
							$image_caption  	= $post->post_excerpt;
							$image_description 	= $post->post_content;
							
							?>
						<ul>
							<li class="meta-prep meta-prep-entry-date">
									<i class="fa fa-clock-o" aria-hidden="true"></i>
									<?php echo __( 'Date:', 'manduca' ) .': ' ?>
									<b><time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></b>
							</li>
							<li>
									<i class="fa fa-cube" aria-hidden="true"></i>
									<?php echo __( 'Original size', 'manduca' ) .': <b>' .$metadata['width'] .'*' .$metadata['height'] .'</b>'; ?>
							</li>
							
							<?php if( !empty( $image_alt ) ) : ?>
							<li>
									<i class="fa fa-braille" aria-hidden="true"></i>
									<?php echo __( 'Alternative Text' ) .': <b>' .$image_alt. '</b>'; ?>
							</li>
							<?php endif; ?>	
						
							<?php if( !empty( $image_caption ) ) : ?>
							<li>
									<i class="fa fa-film" aria-hidden="true"></i>
									<?php echo __( 'Captions/Subtitles' ) .': <b>' . $image_caption .'</b>'; ?>
							</li>
							<?php endif; ?>
							
							<?php if( !empty( $image_description ) ) : ?>
							<li>
									<i class="fa fa-commenting" aria-hidden="true"></i>
									<?php echo __( 'Image description'  ) .': <b id="long-description">' .$image_description .'</b>' ?>
							</li>
							<?php endif; ?>
							
						</ul>
						
							<?php edit_post_link( '<i class=\"fa fa-pencil\" aria-hidden="true"></i>' .__( 'Edit', 'manduca' ) , '<span class="edit-link">', '</span>' ); ?>
						</footer><!-- .entry-meta -->


					</div><!-- .entry-content -->
					
					<nav id="image-navigation" class="nav-single">
							
							<?php manduca_adjacent_image_link( true ); ?>
							<?php manduca_adjacent_image_link( false ) ; ?>  
							
					</nav><!-- .nav-single -->
					

				</article><!-- #post -->

				<?php comments_template(); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>