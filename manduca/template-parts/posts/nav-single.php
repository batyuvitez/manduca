<?php
/**
 * Single post navigation (.nav-single)
 * Navigation to previous / next post in a single post page
 * Displays the title of the prev/next post.
 *
 * */

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

<?php
	$previous_post = Manduca\helpers\Template_Functions::previous_post_link_html('angle-circle-left');
	$next_post = Manduca\helpers\Template_Functions::next_post_link_html('angle-circle-right');
?>

<nav id="nav-single" class="nav-single" aria-label="<?php _e( 'Post navigation', 'manduca' ); ?>">
	<?php if( !empty ( $previous_post ) ) : ?>
		<div class="nav-previous link-button">
			<?php echo $previous_post;?>  	
		</div>
	<?php endif; ?>
	
	
	<?php if( !empty ( $next_post ) ) : ?>
		<div class="nav-next link-button">
			<?php echo $next_post ?> 
		</div>
		<?php endif; ?>
</nav>