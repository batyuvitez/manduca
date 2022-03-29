<?php
/**
 * Display the navigation in attachment 
 **/

  /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

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
  
//translators: aria label to announce the navigation area in attachemnt page

$data=Manduca\helpers\Navigation_Single::attachment_navigation_html ();
$title=__( 'Image navigation', 'manduca' );
// Translators: attachment navigation: go to previous image
$prev_text=__( 'Previous image', 'manduca');

// Translators: attachment navigation: go to next image
$next_text=__( 'Next image', 'manduca');

//translators: link to the related page on attachment page
$parent_text=__( 'Related content', 'manduca' );


?>
<nav class="image-navigation nav-single" aria-label="<?php echo $title ; ?>">

	<?php if( !empty ( $data['previous_title'] ) ) : ?>
		<div class="nav-previous link-button">
			<a  href="<?php echo $data['previous_permalink']; ?>"
				rel="prev">
				<span class="screen-reader-text"><?php echo $prev_text; ?></span>
				<?php manduca_icon( 'angle-circle-left' ); ?>
				<?php echo $data['previous_title']; ?>
			</a>
		</div>
	<?php endif; ?>
	
	<?php if( !empty ( $data['next_title'] ) ) : ?>
		<div class="nav-next link-button">
			<a href="<?php echo $data['next_permalink']; ?>"
				rel="next">
				<span class="screen-reader-text"><?php echo $next_text; ?></span>
				<?php echo $data['next_title']; ?>
				<?php manduca_icon( 'angle-circle-right'); ?>
			</a>
		</div>
	<?php endif; ?>
	
</nav>