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
$original_size_text=__( 'Original image' );

?>
<footer class="lighter-scheme metatags">
	<ul>
		
		<?php echo Manduca\helpers\Meta_Tags::attachment_meta_tag_html ($list_item_mask); ?>

		<li><?php echo manduca_get_svg( array( 'icon' => 'image' ) )?>
			<a href="<?php echo esc_url( wp_get_attachment_url()); ?>" class="meta-item"><?php echo $original_size_text; ?></a>
		</li>						
			
	</ul>
</footer>



