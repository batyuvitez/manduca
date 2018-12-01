<?php
/**
 * Display page 404
 * if there is one page is saved with "page not found page" template, that is used instead of this.
 *
 * 
 * @ Theme: Manduca - focus on accessibility
 * @ Since 1.0
 **/
?>

<?php get_header(); ?>

<?php
	$args = array(
				'post_type' => 'page',
				'posts_per_page' => 1,
				'meta_query' => array(
					array(
						'key' => '_wp_page_template',
						'value' => 'page-templates/page-notfound.php'
					)
				)
			);
		$the_pages = new WP_Query( $args );
							
		if( $the_pages->have_posts() ){
				
				$the_pages->the_post();
				$title 		= the_title( '', '', false );
				$content  	= get_the_content();
				$content	= apply_filters( 'the_content', $content );
		}
		else{
			//Translators: Default 404 page title
			$title 		= __( 'Error 404 &#45; Page Not Found!', 'manduca' );
			// Translators: Default 404 page content
			$content 	= __( 'The requested page could not be located on this blog.', 'manduca' ) ;
		}
		
		$article = array(
				'title' 	=> $title,
				'content' 	=> $content
				);

?>

<article>
	<header class="no-thumbnail">
		<h1>
			<?php echo $article[ 'title' ]; ?>
		</h1>
	</header>

	<div class="entry-content" >
		<?php echo $article[ 'content' ]; ?>
	</div>
</article>

<?php get_footer(); ?>