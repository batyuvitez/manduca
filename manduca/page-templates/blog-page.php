<?php
/**
 * Template Name: Blog page template
 *
 *
 * @ Usage: see docs/how-to
 *
 **/

/*
 *This file is part of child theme of Manuca named: Fény a Sötében
 *@copyright 21 Zsolt Edelényi(ezs@web25.hu)
 *@authorised user: Fény a Sötétben Alapítvány
 *@license: Not for sale. 
*/
 

$exclude='1';
$args=array('category_not_in' => 1);
$blog_page= new \Wp_query ($args);
$label=__( 'Posts navigation', 'manduca' );    
?>



<?php get_header(); ?>


<div class="excerpt-wrapper">

	<?php while ( $blog_page->have_posts() ) : $blog_page->the_post();  ?>
		
		<article id="post-<?php echo the_ID(); ?>" <?php post_class(); ?>>
			
			<div class="excerpt-wrapper">
				   <header class="excerpt-header">
					   <h2 class="entry-title">
						   <a 	href="<?php echo get_permalink(); ?>"
							   rel="bookmark"><?php the_title(); ?></a>
					   </h2>
				   </header>
			   
				   <div class="entry-content">		
						<?php echo Manduca\helpers\Template_Functions::get_the_excerpt(); ?>
				   </div>
				   
			</div>
		   
		</article>
		
	<?php endwhile; ?>

</div>

<?php $label=__( 'Posts navigation', 'manduca' );   ?>




<nav id="post-navigation" class="post-navigation" aria-label="<?php echo $label; ?>">
	<div class="nav-links">
        <?php echo Manduca\helpers\Template_Functions::post_navigation( $blog_page); ?>        
    </div>
</nav>
							

<?php get_footer(); ?>