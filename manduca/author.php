<?php
/**
 * Author archive page
 * 
 * @ Theme: Manduca - focus on accessibility
 * @ Since 1.0
 **/
?>

<?php get_header() ?>
		<?php if ( have_posts() ) : ?>
			<?php the_post(); ?>
			
			<header>
				<h1>
				<?php
					printf( __( 'Author: %s', 'manduca' ),
						   '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" >' . get_the_author() . '</a></span>' );
				?>
				</h1>
				
			</header>

			<?php rewind_posts(); ?>
			
			<?php
			$author_description = get_the_author_meta( 'description' );
			if ( ! empty ( $author_description ) ) : ?>
			<div class="author-info">
				<div class="author-avatar">
					<?php
					echo get_avatar( get_the_author_meta( 'user_email' ), 68 );
					?>
				</div>
				<div class="author-description">
					<h3><?php printf( __( 'About %s', 'manduca' ), get_the_author() ); ?></h3>
					
					<?php
						$user_url= get_the_author_meta( 'user_url' );
						If ( !empty( $user_url ) ) {
							if( function_exists ( 'idn_to_utf8') ) {
								$user_url_utf8 = idn_to_utf8( $user_url );
							}
							else {
								$user_url_utf8 = $user_url;
							}
							printf( '<p><a href="%1$s">%2$s</a></p>',
										$user_url,
										$user_url_utf8
									   ) ;
						}
					?>
					<p><?php the_author_meta( 'description' ); ?></p>
				</div>
			</div>
			<?php endif; ?>

			<?php get_template_part( 'template-parts/posts/content', 'excerpt' ); ?>

	<?php endif; ?>

<?php get_footer() ?>