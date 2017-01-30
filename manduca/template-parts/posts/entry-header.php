<?php
 /*
  * Display entry header
  * Display the header of the article in two-column format. 
  *
  * since @16.8
  * */
 
	?>
	
	<div class="columns-mask">
		<div class="columns-wrapper">
			<div class="column-right-wrapper">
				<div class="column-right">
						<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
							<div class="featured-post"><?php _e( 'Featured', 'manduca' ) ?></div>
						<?php endif; ?>
		
					<?php if ( is_single() ) : ?>
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php else : ?>
						<h2 class="entry-title">
							<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
						</h2>
					<?php endif; // is_single() ?>
				</div>
			</div>
			
			<div class="column-left">
			
					<?php
					$month 		= esc_html( get_the_date( 'M' ) );
					$day		= esc_html( get_the_date( 'j' ) );
					$date_mask	='<p class="content-date"><time class="entry-date" datetime="%1$s"><span class="entry-date-month">%4$s</span> <span class="entry-date-day">%3$s</span> <span class="entry-date-year">%2$s</span></time></p>';
		
					if ( get_bloginfo( 'language' ) ==='hu-HU' ) {
							setlocale(LC_ALL, 'hu_HU.UTF8');
							$short_month_array = array('','jan.','febr.','márc.','ápr.','máj.','jún.','júl.','aug.','szept.','okt.','nov.','dec.');
							$month =$short_month_array[ get_post_time( 'n' ) ] ;
							$day 		.= '.';
							$date_mask	='<p class="content-date"><time class="entry-date" datetime="%1$s"><span class="entry-date-year">%2$s.</span> <span class="entry-date-month">%4$s</span> <span class="entry-date-day">%3$s</span></time></p>';
		
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
	</div>
	
		
	
 