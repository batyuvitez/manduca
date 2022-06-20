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

use Manduca\helpers as hlp; 
?>





<div class="excerpt-wrapper">

	<?php while ( have_posts() ) : the_post();  ?>
		
		<?php $extra_classes = is_sticky() ? 'excerpt featured-scheme' : 'excerpt' ; ?>
		
		<article id="post-<?php echo the_ID(); ?>" <?php post_class( $extra_classes ); ?>>
		 
			<header class="excerpt-header">
				<?php get_template_part( 'template-parts/posts/entry-header' ); ?>
			</header>
		
			 <?php get_template_part( '/template-parts/postlink', 'edit' ) ; ?>
		
		
			<?php if ( hlp\Images::has_thumbnail() ) : ?>
				 <div class="excerpt-thumbnail">
					<?php hlp\Images::thumbnail_substitution() ;?>
				 </div>
			<?php endif; ?>
			 
				
			<div class="entry-content">		
					<?php echo hlp\Excerpts::get_the_excerpt(); ?>
			</div>
			
			<div class="clearfix-content"></div>
		
		</article>
		
	<?php endwhile; ?>

</div>

<?php get_template_part ('/template-parts/posts/post', 'navigation'); ?>