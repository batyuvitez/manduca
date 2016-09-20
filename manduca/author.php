<?php
/**
 * Manduca
 *
 * @since 1.0 */

get_header(); ?>

	<section id="primary" class="site-content">
		<main id="content">

		<?php if ( have_posts() ) : ?>

			<?php
				
				the_post();
			?>
			
			<header class="archive-header">
				<h1 class="archive-title">
				<?php
					printf( __( 'Author: %s', 'manduca' ),
						   '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" >' . get_the_author() . '</a></span>' );
				?>
				</h1>
				
			</header><!-- .archive-header -->

			<?php rewind_posts(); ?>

			

			<?php
			$author_description = get_the_author_meta( 'description' );
			if ( ! empty ( $author_description ) ) : ?>
			<div class="author-info">
				<div class="author-avatar">
					<?php
					$author_bio_avatar_size = apply_filters( 'manduca_author_bio_avatar_size', 68 );
					echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
					?>
				</div><!-- .author-avatar -->
				<div class="author-description">
					<h3><?php printf( __( 'About %s', 'manduca' ), get_the_author() ); ?></h3>
					
					<?php
						$user_url= get_the_author_meta( 'user_url' );
						If ( !empty( $user_url ) ) {
							if( function_exists ( 'idn_to_utf8') ) {
								$user_url_utf8 = idn_to_utf8($user_url );
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
				</div><!-- .author-description	-->
			</div><!-- .author-info -->
			<?php endif; ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php manduca_page_navigation(); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</main><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>