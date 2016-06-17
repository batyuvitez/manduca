<?php
/** Manduca
 *
 * @ since 1.0
 */


if ( post_password_required() )
	return;
?>

<aside id="comments" class="comments-area">

	

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( __( '%1$s thought(s)', 'manduca' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'manduca_comment', 'style' => 'ol' ) ); ?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav id="comment-nav-below" class="navigation" role="navigation">
			<p class="assistive-text section-heading"><?php __( 'Comments', 'manduca' ) ?></p>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older comments', 'manduca' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Latest comments &rarr;', 'manduca' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.', 'manduca' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form(); ?>

</aside><!-- #comments .comments-area -->