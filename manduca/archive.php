<?php
/**
 * The template for displaying date archive pages
 *
 * @ Theme: Manduca - focus on accessibility
 * @ Since 1.0
 */
?>

<?php get_header() ?>

		<?php if ( have_posts() ) : ?>
			<header>
				<h1><?php
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

			</header>
			
			<?php get_template_part( 'template-parts/posts/content', 'excerpt' ); ?>
				

		<?php else : ?>
			<?php get_template_part( 'template-parts/posts/content', 'none' ); ?>
		<?php endif; ?>

<?php get_footer() ?>