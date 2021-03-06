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

 
?>
<?php if ( is_sticky() &&  ! is_paged() ) : ?>
		<div class="featured-post featured-scheme"><?php _e( 'Featured', 'manduca' ) ?></div>
<?php endif; ?>


	<div class="entry-header-wrapper">
		<div class="entry-title-wrapper">
			
					
	
				<?php if ( is_single() ) :
					printf( '<h1 id="post-%1$s-title">%2$s</h1>',
						   get_the_ID(),
						   get_the_title()
						  );
					
					elseif( is_search() ) :
					$title = Search_Functions::emphasize( get_the_title(), get_search_query() );

					printf( '<h2 class="entry-title"><a  id="post-%3$s-title" href="%1$s">%2$s</a></h2>',
						   esc_url( get_permalink() ),
						   $title,
						   get_the_ID()
						   );
					
					else : 
					printf( '<h2 class="entry-title"><a href="%1$s" id="post-%2$s-title">%3$s</a></h2>',
						   get_permalink(),
						   get_the_ID(),
						   get_the_title()
						  );
				endif; // is_single() ?>
				
				<?php do_action( 'manduca_post_subtitle' ); ?>
					
			
		</div>
		
		<div class="content-date featured-scheme">
		
				<?php
				$month 		= esc_html( get_the_date( 'M' ) );
				$day		= esc_html( get_the_date( 'j' ) );
				$date_mask	='<time class="entry-date featured-scheme" datetime="%1$s"><span class="entry-date-month">%4$s</span> <span class="entry-date-day">%3$s</span> <span class="entry-date-year">%2$s</span></time>';
	
				if ( strpos ( get_bloginfo( 'language' ), 'hu' ) !== FALSE ) {
						$short_month_array = array('','jan.','febr.','márc.','ápr.','máj.','jún.','júl.','aug.','szept.','okt.','nov.','dec.');
						$month =$short_month_array[ get_post_time( 'n' ) ] ;
						$day 		.= '.';
						$date_mask	='<time class="entry-date " datetime="%1$s"><span class="entry-date-year">%2$s.</span> <span class="entry-date-month">%4$s</span> <span class="entry-date-day">%3$s</span></time>';
	
				}
				
				/*
				 *  Filter of content date of the entry header
				 * @ since 16.8
				 * */
				echo apply_filters( 'manduca_content_date', 
					sprintf( $date_mask,
						esc_attr( get_the_date( 'c' ) ),
						esc_attr( get_the_date( 'Y' ) ),
						$day,
						$month
				   )
				); ?>
		
		</div>
	</div>	

	
		
	
 