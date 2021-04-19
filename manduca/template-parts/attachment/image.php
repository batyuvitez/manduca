<?php
/**
 * Display attachment page
 * 
 **/

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2021  Zsolt Edelényi (ezs@web25.hu)

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

	<article id="post-<?php the_ID(); ?>" <?php post_class('image-attachment'); ?>>
	<header>
		<h1><?php the_title() ; ?></h1>
	</header>
	
	<div class="entry-content">
	
		<div class="attachment">							
			<?php $attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
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
			$attachment_size = apply_filters( 'manduca_attachment_size', array( 960, 960 ) );
			printf( '<a href="%1$s" title="%2$s" rel="attachment">%3$s</a>',
					esc_url( $next_attachment_url ),
					the_title_attribute( array( 'echo'=>false ) ),
					wp_get_attachment_image( $post->ID, $attachment_size )
					); ?>
		</div>
	
			<?php get_template_part ('/template-parts/attachment/attachment', 'meta'); ?>
		
	
		<?php get_template_part ('/template-parts/attachment/attachment', 'navigation'); ?>
	</div>
</article>

<?php comments_template(); ?>
