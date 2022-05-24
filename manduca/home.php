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

use Manduca\filters as fil;
?>
<?php get_header(); ?>

	<?php if ( have_posts() ) : ?>
	
		<header>
			<h1 class="main-header">
				<?php echo fil\Title::site_title_with_whitespace (); ?>
			</h1>
		</header>
		<?php get_template_part( 'template-parts/posts/content', 'excerpt' ); ?>
		
	<?php else : ?>
	
		<article class="post no-results not-found">
			<header>
				<h1><?php _e( 'No matching result found.', 'manduca' ) ?></h1>
			</header>
	
			<div class="entry-content">
				<?php get_search_form(); ?>
			</div>	
		</article>
	
	<?php endif; ?>

<?php get_footer(); ?>