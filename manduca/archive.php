<?php
/**
 * Manduca
 *
 * @since 1.0 */

get_header(); ?>
	<section id="primary" class="site-content">
		<main id="content">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php
					if ( is_day() ) :
						printf( __( 'Daily Archives: %s', 'manduca' ), '<span>' . get_the_date() . '</span>' );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archives: %s', 'manduca' ), '<span>' . get_the_date() . '</span>' );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archives: %s', 'manduca' ), '<span>' . get_the_date() . '</span>' );
					else :
						_e( 'Archives', 'manduca' );
					endif;
				?></h1>


			<?php
				$term_description = category_description();
				if ( ! empty( $term_description ) ) {
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
				} ?>
			</header><!-- .archive-header -->
			
			<?php manduca_display_excerpt() ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</main><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>