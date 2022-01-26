<?php
/**
 * Display the meta data of the post*
 **/

  /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2021  Zsolt Edelényi (ezs@web25.hu)

    This program is free software: you can redistribute it and/or modify
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

$list_item_mask 	= '<li>%s<span class="meta-item"><span>%s : </span>%s</span></li>';
//translators: attachment metadata link to original size image
$original_size_text=__( 'Show original', 'manduca' );

//key of meta_type array has only comment function 
$meta_type=array(
		'image_caption' => array (
						'icon'=> manduca_icon( 'film', false ),
						//translators: catpion of image in attachment page
						'label' => __( 'Captions/Subtitles' ),
						'callback'=>array( 'Manduca\helpers\Meta_Tags', 'get_caption')),
		
		'alt-tag' => array (
						'icon'=> manduca_icon( 'calendar', false  ),
						//translators: alternative text of an image on attachment page
						'label' => __( 'Alternative Text' ),
						'callback'=>array( 'Manduca\helpers\Meta_Tags', 'get_alt_tag')),
		'description' => array (
						'icon'=> manduca_icon( 'bubble', false  ),
						//translators: image desctription of an image on attachment page
						'label' => __( 'Image description'  ),
						'callback'=>array( 'Manduca\helpers\Meta_Tags', 'get_description')),
		'image_size' => array (
						'icon'=> manduca_icon( 'cube', false  ),
						//translators: attachment metadata size of image in attachment page
						'label' => __( 'Original size', 'manduca' ),
						'callback'=>array( 'Manduca\helpers\Meta_Tags', 'get_image_size')),
		'date' => array (
						'icon'=> manduca_icon( 'calendar', false  ),
						// translators: Date of post - in the post meta. 
						'label'=> __( 'Entry date', 'manduca' ),
						'callback'=>array( 'Manduca\helpers\Meta_Tags', 'get_post_date')),
		'parent' => array (
						'icon'=> manduca_icon( 'info', false ),
						// translators: This is a link to the realted (parent) post of an image. 
						'label'=> __( 'Part of the following post', 'manduca' ),
						'callback'=>array( 'Manduca\helpers\Meta_Tags', 'get_attachment_parent'))
		);

?>
<footer class="lighter-scheme metatags">
	<ul>
		
		<?php echo Manduca\helpers\Meta_Tags::meta_tag_html ($list_item_mask, $meta_type); ?>

		<li><?php manduca_icon( 'image' ); ?>
			<a href="<?php echo esc_url( wp_get_attachment_url()); ?>" class="meta-item"><?php echo $original_size_text; ?></a>
		</li>						
			
	</ul>
</footer>



