<?php
/**
 * Display bottom of the page
 * 
 **/

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

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
			<?php get_template_part ('template-parts/wrapper/wrapper','bottom'); ?>					
			<?php get_template_part( 'template-parts/footer/footer', 'before' ); ?>
			
			<?php get_template_part( 'template-parts/footer/footer', 'wrappertop' ); ?>
			<?php get_template_part( 'template-parts/footer/footer', 'menu' ); ?>
			<?php get_template_part( 'template-parts/footer/footer', 'siteinfo' ); ?>
			<?php get_template_part( 'template-parts/footer/footer', 'wrapperbottom' ); ?>
			
			<?php get_template_part( 'template-parts/footer/footer', 'backtotop' ); ?>
			<?php get_template_part( 'template-parts/footer/footer', 'overlay' ); ?>
			<?php get_template_part( 'template-parts/footer/footer', 'after' ); ?>
			<?php wp_footer(); ?>
		</div> <?php // closing tag of  .site #page  ?>
	</body>
</html>