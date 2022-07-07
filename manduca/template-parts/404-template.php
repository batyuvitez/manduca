<?php
/**
 * Display page 404
 * if there is one page is saved with "page not found page" template, that is used instead of this.
 *
 **/

 
/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

    Source code is available at https://github.com/batyuvitez/manduca
    Manduca is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    in /assets/docs/licence.txt.  If not, see <https://www.gnu.org/licenses/>.
*/

 
?>

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
		$thumbnail = false;
		$class	   ="page-404";
		if( $the_pages->have_posts() ) {
				
				$the_pages->the_post();
				$title 		= the_title( '', '', false );
				$content  	= get_the_content();
				$content	= apply_filters( 'the_content', $content );
				if (has_post_thumbnail ()) {
					$thumbnail  = get_the_post_thumbnail ();
				}
				$class     = get_post_class ();
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



<article <?php post_class(); ?>>
		<header class="entry-title-wrapper">
			<h1 class="entry-title main-header"><?php echo $title ; ?></h1>
	</header>
	
	<?php if ($thumbnail) : ?>
	
		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
	
	<?php else : ?>
	
		<div class="post-thumbnail image-fallback" aria-hidden="true"></div>
	
	<?php endif; ?>
	
	<div class="entry-content" >
	
		<?php echo $article[ 'content' ]; ?>
	
	</div>
	
	<div class="clearfix-content"></div>

</article>