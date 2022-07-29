<?php
 /*
  * More-link template
  * @since 22.9.
  *
  * Called from helpers\More_Links
  * */

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
 
//Translators: text of the read more and excerpt more buttons
$text = __( 'Continue reading', 'manduca' );
?>
 
	<div  class="more-link link-button">
		<a href="<?php the_permalink(); ?>"
		   id="post-<?php the_ID(); ?>-morelink-<?php echo $args; ?>"
		   aria-labelledby="post-<?php the_ID(); ?>-morelink post-<?php the_ID(); ?>-title">
			<?php echo $text; manduca_icon( 'angle-right', true ) ;?>
		</a>
	</div>