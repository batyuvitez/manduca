<?php
/* Tempplate of list items of existing comments.
 * embed in ul class=commentlist
 */
/*
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

use Manduca\helpers as hlp;
$depth=$args['depth'];
$args=$args['args'];

?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<article id="comment-<?php comment_ID(); ?>" class="comment">
		<header class="comment-meta comment-author">
			<div class="comment-avatar"><?php echo get_avatar( $comment, 44 );?></div>
				<div class="comment-info"><span class="author-ink"><?php echo get_comment_author_link(); ?></span>
					<?php if ( $comment->user_id === $post->post_author ) : ?>
						<span><?php _e( 'Author', 'manduca' ) ;?></span>
					<?php endif; ?>
				</div>
				<?php echo hlp\Comments::get_comment_date(); ?>
				
		</header>

		<?php if ( '0' == $comment->comment_approved ) { ?>
			<p class="comment-awaiting-moderation"><?php _e( 'Comment is awaiting for apporval.', 'manduca' ) ?></p>
		<?php } ?>

		<section class="comment-content comment">
			<?php comment_text(); ?>
			<?php edit_comment_link( __( 'Edit', 'manduca' ), '<p class="edit-link">', '</p>' ); ?>
		</section><!-- .comment-content -->

		<div class="reply more-link link-button">
			<?php comment_reply_link( array_merge(
								$args,
								array(
									  'reply_text' => __( 'Reply', 'manduca' ),
									  'before' => manduca_icon( 'mail-reply', false ),
									  'depth' => $depth,
									  'max_depth' => $args['max_depth']
									  )
								) ); ?>
		</div>
	</article>