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
							
							<div class="nav-previous">
								<?php previous_image_link( false, __( 'Previous', 'manduca' ) ) ; ?> 
							</div>
							
							<div class="nav-next">
								<?php next_image_link( false, __( 'Next', 'manduca' ) ) ; ?>
							</div>
							
							
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
									<svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
										<path d="M192 1664h288v-288h-288v288zm352 0h320v-288h-320v288zm-352-352h288v-320h-288v320zm352 0h320v-320h-320v320zm-352-384h288v-288h-288v288zm736 736h320v-288h-320v288zm-384-736h320v-288h-320v288zm768 736h288v-288h-288v288zm-384-352h320v-320h-320v320zm-352-864v-288q0-13-9.5-22.5t-22.5-9.5h-64q-13 0-22.5 9.5t-9.5 22.5v288q0 13 9.5 22.5t22.5 9.5h64q13 0 22.5-9.5t9.5-22.5zm736 864h288v-320h-288v320zm-384-384h320v-288h-320v288zm384 0h288v-288h-288v288zm32-480v-288q0-13-9.5-22.5t-22.5-9.5h-64q-13 0-22.5 9.5t-9.5 22.5v288q0 13 9.5 22.5t22.5 9.5h64q13 0 22.5-9.5t9.5-22.5zm384-64v1280q0 52-38 90t-90 38h-1408q-52 0-90-38t-38-90v-1280q0-52 38-90t90-38h128v-96q0-66 47-113t113-47h64q66 0 113 47t47 113v96h384v-96q0-66 47-113t113-47h64q66 0 113 47t47 113v96h128q52 0 90 38t38 90z"/>
									</svg>
									<?php echo __( 'Date:', 'manduca' ) .': ' ?>
									<b><time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></b>
							</li>
							<li>
									<svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
										<path d="M896 1629l640-349v-636l-640 233v752zm-64-865l698-254-698-254-698 254zm832-252v768q0 35-18 65t-49 47l-704 384q-28 16-61 16t-61-16l-704-384q-31-17-49-47t-18-65v-768q0-40 23-73t61-47l704-256q22-8 44-8t44 8l704 256q38 14 61 47t23 73z"/>
									</svg>
									<?php echo __( 'Original size', 'manduca' ) .': <b>' .$metadata['width'] .'*' .$metadata['height'] .'</b>'; ?>
							</li>
							
							<?php if( !empty( $image_alt ) ) : ?>
							<li>
									<svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
										<path d="M1596 380q28 28 48 76t20 88v1152q0 40-28 68t-68 28h-1344q-40 0-68-28t-28-68v-1600q0-40 28-68t68-28h896q40 0 88 20t76 48zm-444-244v376h376q-10-29-22-41l-313-313q-12-12-41-22zm384 1528v-1024h-416q-40 0-68-28t-28-68v-416h-768v1536h1280zm-1024-864q0-14 9-23t23-9h704q14 0 23 9t9 23v64q0 14-9 23t-23 9h-704q-14 0-23-9t-9-23v-64zm736 224q14 0 23 9t9 23v64q0 14-9 23t-23 9h-704q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h704zm0 256q14 0 23 9t9 23v64q0 14-9 23t-23 9h-704q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h704z"/>
									</svg>
									<?php echo __( 'Alternative Text' ) .': <b>' .$image_alt. '</b>'; ?>
							</li>
							<?php endif; ?>	
						
							<?php if( !empty( $image_caption ) ) : ?>
							<li>
									<svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
										<path d="M320 1600v-128q0-26-19-45t-45-19h-128q-26 0-45 19t-19 45v128q0 26 19 45t45 19h128q26 0 45-19t19-45zm0-384v-128q0-26-19-45t-45-19h-128q-26 0-45 19t-19 45v128q0 26 19 45t45 19h128q26 0 45-19t19-45zm0-384v-128q0-26-19-45t-45-19h-128q-26 0-45 19t-19 45v128q0 26 19 45t45 19h128q26 0 45-19t19-45zm1024 768v-512q0-26-19-45t-45-19h-768q-26 0-45 19t-19 45v512q0 26 19 45t45 19h768q26 0 45-19t19-45zm-1024-1152v-128q0-26-19-45t-45-19h-128q-26 0-45 19t-19 45v128q0 26 19 45t45 19h128q26 0 45-19t19-45zm1408 1152v-128q0-26-19-45t-45-19h-128q-26 0-45 19t-19 45v128q0 26 19 45t45 19h128q26 0 45-19t19-45zm-384-768v-512q0-26-19-45t-45-19h-768q-26 0-45 19t-19 45v512q0 26 19 45t45 19h768q26 0 45-19t19-45zm384 384v-128q0-26-19-45t-45-19h-128q-26 0-45 19t-19 45v128q0 26 19 45t45 19h128q26 0 45-19t19-45zm0-384v-128q0-26-19-45t-45-19h-128q-26 0-45 19t-19 45v128q0 26 19 45t45 19h128q26 0 45-19t19-45zm0-384v-128q0-26-19-45t-45-19h-128q-26 0-45 19t-19 45v128q0 26 19 45t45 19h128q26 0 45-19t19-45zm128-160v1344q0 66-47 113t-113 47h-1600q-66 0-113-47t-47-113v-1344q0-66 47-113t113-47h1600q66 0 113 47t47 113z"/>
									</svg>
									<?php echo __( 'Captions/Subtitles' ) .': <b>' . $image_caption .'</b>'; ?>
							</li>
							<?php endif; ?>
							
							<?php if( !empty( $image_description ) ) : ?>
							<li>
									<svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
										<path d="M640 896q0-53-37.5-90.5t-90.5-37.5-90.5 37.5-37.5 90.5 37.5 90.5 90.5 37.5 90.5-37.5 37.5-90.5zm384 0q0-53-37.5-90.5t-90.5-37.5-90.5 37.5-37.5 90.5 37.5 90.5 90.5 37.5 90.5-37.5 37.5-90.5zm384 0q0-53-37.5-90.5t-90.5-37.5-90.5 37.5-37.5 90.5 37.5 90.5 90.5 37.5 90.5-37.5 37.5-90.5zm384 0q0 174-120 321.5t-326 233-450 85.5q-110 0-211-18-173 173-435 229-52 10-86 13-12 1-22-6t-13-18q-4-15 20-37 5-5 23.5-21.5t25.5-23.5 23.5-25.5 24-31.5 20.5-37 20-48 14.5-57.5 12.5-72.5q-146-90-229.5-216.5t-83.5-269.5q0-174 120-321.5t326-233 450-85.5 450 85.5 326 233 120 321.5z"/>
									</svg>
									<?php echo __( 'Image description'  ) .': <b id="long-description">' .$image_description .'</b>' ?>
							</li>
							<?php endif; ?>
							
						</ul>
						
							<?php edit_post_link( '<svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M491 1536l91-91-235-235-91 91v107h128v128h107zm523-928q0-22-22-22-10 0-17 7l-542 542q-7 7-7 17 0 22 22 22 10 0 17-7l542-542q7-7 7-17zm-54-192l416 416-832 832h-416v-416zm683 96q0 53-37 90l-166 166-416-416 166-165q36-38 90-38 53 0 91 38l235 234q37 39 37 91z"/></svg>' .__( 'Edit', 'manduca' ) , '<span class="edit-link">', '</span>' ); ?>
						</footer><!-- .entry-meta -->


					</div><!-- .entry-content -->
					
					<nav id="image-navigation" class="nav-single">
							
							<div class="nav-previous">
								<?php previous_image_link( false, __( 'Previous', 'manduca' ) ) ; ?> 
							</div>
							
							<div class="nav-next">
								<?php next_image_link( false, __( 'Next', 'manduca' ) ) ; ?>
							</div>
							
							
						</nav><!-- .nav-single -->

				</article><!-- #post -->

				<?php comments_template(); ?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>