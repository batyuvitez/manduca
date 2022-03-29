<?php

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

	<article id="post-0" class="post no-results not-found">
		<header class="entry-header">
			<h1 class="entry-title"><?php _e( 'Nothing found', 'manduca' ); ?></h1>
		</header>

		<div class="entry-content">
			<p><?php _e( 'No results were found. Perhaps to choose from the HTML sitemap below.', 'manduca' ); ?></p>
			<h2><?php _e( 'Sitemap', 'manduca' ) ?></h2>
			<?php get_template_part( '/sitemap' ); ?>

		</div><!-- .entry-content -->
	</article><!-- #post-0 -->
