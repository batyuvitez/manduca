<?php
/**
 * This is the default page in case of 404 error.
 *

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

<?php get_template_part( 'template-parts/main/twocolums', 'start' ); ?>

			<article>
				<header>
					<h1 class="entry-title main-header">
						<?php _e( 'Error 404 &#45; Page Not Found!', 'manduca' ); ?>
					</h1>
					
				</header>

				<div class="entry-content" >
					<p>
						<?php _e( 'The requested page could not be located on this blog. We highly recommend to choose from the HTML sitemap below.', 'manduca' ) ?>
					</p>	
					
					<?php get_template_part( 'template-parts/sitemap' ); ?>
				</div>
			</article>

<?php get_template_part( 'template-parts/main/twocolums', 'finish' ); ?>