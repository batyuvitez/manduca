<?php
/**
 * Extended recen post widget 
 *
 **/

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

    This program is free software: you can redistribute it and/or modify
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

$posts=$args [0];
$args=$args [1];
extract( $args );

?>

<div class="recent-post-block">

		<?php while ( $posts->have_posts() ) :
			$posts->the_post(); ?>
			
			<article>
				
				<?php  if ( $args['thumb'] ) : ?>
					<header class="thumbnail">
							<div class="widget-thumbnail">
								<?php if ( has_post_thumbnail() ) : ?>
									<div>
										<?php the_post_thumbnail( 'thumbnail' ); // defined in Manduca 268*178 | aspect-ratio: 1.5:1  ?>
									</div>
								
								<?php elseif ( ! empty( $args['thumb_default'] ) ) : // Display default image. ?> 
									<img class="thumbnail-substitution" src="<?php echo esc_url( $args['thumb_default'] ); ?>" alt="<?php _e( 'thumbnail substitution', 'manduca') ?>">	
								<?php endif; ?>
							</div>
						<?php else : ?>
							<header class="without-thumbnail">
						<?php endif; ?>
						
					<h3>
						<a href="<?php echo esc_url( get_permalink() ) ; ?>" rel="bookmark"><?php echo  esc_attr( get_the_title() ); ?></a>
					</h3>
				</header>
				<div class="vonalzo"></div>
				<?php if ( $args['date'] ) : ?>
				
					<div class="date">
						<?php if ( $args['date_relative'] ) : ?>
							<?php echo  hlp\Hungarian_Contents::hege_style_post_date (); ?>
						<?php else :  ?>
							<time datetime="<?php echo esc_html( get_the_date( 'c' ) ) ?>"><?php esc_html( get_the_date () ) ?></time>
						<?php endif; ?>
					</div>								
				<?php endif; ?>
				
				
				<?php if ( $args['comment_count'] ) : 
					if ( get_comments_number() == 0 ) {
							$comments = __( 'No Comments', 'recent-posts-widget-extended' );
						} elseif ( get_comments_number() > 1 ) {
							$comments = sprintf( __( '%s Comments', 'recent-posts-widget-extended' ), get_comments_number() );
						} else {
							$comments = __( '1 Comment', 'recent-posts-widget-extended' );
						} ?>
					<div class="comments"><?php echo esc_html ( $comments );?></div>
				<?php endif; ?>

				<?php if ( $args['excerpt'] ) : ?>
					<div class="excerpt">
						<?php echo hlp\Template_Functions::get_the_excerpt ( TRUE );  ?>
					</div>
				<?php endif; ?>
			</article>

		<?php endwhile; ?>

	</ul>

</div>

	   
