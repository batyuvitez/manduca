<?php
/**
 * Display tag archive
 *
 * @ Theme: Manduca - focus on accessibility
 * @ Since 1.0
 **/
?>

<?php get_header(); ?>

		<?php if ( have_posts() ) : ?>
			<header>
				<h1 tabindex="0"><?php echo single_cat_title( '', false ) ; ?></h1>

			<?php
					// Show an optional term description.
					$term_description = term_description();
					if ( ! empty( $term_description ) ) :
						printf( '<div class="taxonomy-description">%s</div>', $term_description );
					endif;
				?>
			</header>

			<?php get_template_part( 'template-parts/posts/content', 'excerpt' ); ?>

		<?php endif; ?>

<?php get_footer(); ?>