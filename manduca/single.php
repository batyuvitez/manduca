<?php
/**
 * Display Singe post 
 * 
 * @ Theme: Manduca - focus on accessibility
 * @ Since 1.0
 **/
?>
<?php get_header(); ?>
				
<?php while ( have_posts() ) : the_post(); ?>

    <?php get_template_part( 'template-parts/posts/content', get_post_format() );  ?>
    
    
    <?php get_template_part( '/template-parts/posts/navigation' ) ; ?>

    <?php comments_template(); ?>

<?php endwhile; // end of the loop. ?>
		
<?php get_footer(); ?>