<?php
/*
 * Displays the comment part blow the the post content
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

?>

<?php if ( comments_open()  && !post_password_required()  ) :  ?>
	<aside id="comments" class="comments-area">

	
		<?php /* Get the comments and pings count */ 
			
			$comments_num = Manduca\helpers\Comments::manduca_get_comment_count();
			// to also show comments awaiting approval
			$allcomments_num = Manduca\helpers\Comments::manduca_get_comment_count( 'comments', false );
		?>
		<h1 class="comments-title">
			<?php printf(
						__('Reply to &bdquo;%s&rdquo;' , 'manduca' ),
						get_the_title()
					);
			?>
		</h1>
		<?php if ( $comments_num ) : ?>
			<header class="comments-meta">
			
				
				<svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
					<path d="M704 384q-153 0-286 52t-211.5 141-78.5 191q0 82 53 158t149 132l97 56-35 84q34-20 62-39l44-31 53 10q78 14 153 14 153 0 286-52t211.5-141 78.5-191-78.5-191-211.5-141-286-52zm0-128q191 0 353.5 68.5t256.5 186.5 94 257-94 257-256.5 186.5-353.5 68.5q-86 0-176-16-124 88-278 128-36 9-86 16h-3q-11 0-20.5-8t-11.5-21q-1-3-1-6.5t.5-6.5 2-6l2.5-5 3.5-5.5 4-5 4.5-5 4-4.5q5-6 23-25t26-29.5 22.5-29 25-38.5 20.5-44q-124-72-195-177t-71-224q0-139 94-257t256.5-186.5 353.5-68.5zm822 1169q10 24 20.5 44t25 38.5 22.5 29 26 29.5 23 25q1 1 4 4.5t4.5 5 4 5 3.5 5.5l2.5 5 2 6 .5 6.5-1 6.5q-3 14-13 22t-22 7q-50-7-86-16-154-40-278-128-90 16-176 16-271 0-472-132 58 4 88 4 161 0 309-45t264-129q125-92 192-212t67-254q0-77-23-152 129 71 204 178t75 230q0 120-71 224.5t-195 176.5z"/>
				</svg>
				<span>
					<?php printf( __( '%s comments', 'manduca' ), number_format_i18n( $comments_num ) ); ?>
				</span>
			</header>
		<?php endif; ?>


		<ol class="commentlist">
			<?php wp_list_comments( array(
										  'callback' => array ('Manduca\helpers\Comments','manduca_comment'),
										  'style' => 'ol'
										  )
									); ?>
		</ol>
		
		<?php the_comments_pagination( array(
			'prev_text' => manduca_icon( 'angle-circle-left', false ) . '<span class="screen-reader-text">' . __( 'Previous', 'manduca' ) . '</span>',
			'next_text' => '<span class="screen-reader-text">' . __( 'Next', 'manduca' ) . '</span>' . manduca_icon( 'angle-circle-right',false ),
		) );

		
		if ( ! comments_open() && get_comments_number() ) {
		
			/*
			 * Filter nocomment text
			 * */
			
			echo apply_filters	( 'manduca_nocomment_text', sprintf(
														   '<p class="no-comment-text">%s</p>',
														   __( 'Comments are closed.', 'manduca' )
														   )
						 );
			
		} 
		
		$args=array ( 'class_submit'=>'link-button');
		comment_form($args ); ?>

	</aside>
	
<?php endif; // have_comments() 