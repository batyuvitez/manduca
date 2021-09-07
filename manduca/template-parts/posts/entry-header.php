<?php
 /*
  * Display entry header
  * Display the header of the article in two-column format. 
  *
  * Called from excerpt template
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

 
if( is_search() ) {
	$title = Search_Functions::emphasize( get_the_title(), get_search_query() );
}
else {
	$title=get_the_title();
} ?>

<?php if ( is_sticky() &&  ! is_paged() ) : ?>
		<div class="featured-post featured-scheme"><?php _e( 'Featured', 'manduca' ) ?></div>
<?php endif; ?>


	<div class="entry-header-wrapper">
		<div class="entry-title-wrapper">
			
					
	
				<?php if ( is_single() ) : ?> 
					<h1 id="post-<?php echo get_the_ID(); ?>-title" class="entry-title"><?php echo $title; ?></h1>
				<?php else : ?>	
					<h2 id="post-<?php echo get_the_ID(); ?>-title" class="entry-title">
						<a href="<?php echo esc_url (get_permalink()); ?>"><?php echo $title; ?></a>
					</h2>
				<?php endif; ?>
				
				<?php do_action( 'manduca_post_subtitle' ); ?>
					
		</div>
		
		<div class="content-date featured-scheme">
		
				<?php
				/*
				 *  Filter of content date of the entry header
				 * */
				echo apply_filters( 'manduca_content_date', Manduca\helpers\Hungarian_Contents::entry_date_html ()); ?>
		
		</div>
	</div>	

	
		
	
 