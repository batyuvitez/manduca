<?php
/**
 * Manduca
 *
 * @since 17.1 */


$categories_list = get_the_category_list( ', ' );
$tag_list = get_the_tag_list( '', ', ' );	
$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><abbr class="published" title="%3$s"><time class="entry-date" datetime="%3$s">%4$s</time></abbr></a>',
	esc_url( get_permalink() ),
	esc_attr( get_the_time() ),
	esc_attr( get_the_date( 'c' ) ),
	esc_html( get_the_date() )
);


$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
	esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
	esc_attr( sprintf( __( 'All posts by %s', ' manduca' ), get_the_author() ) ),
	get_the_author()
);

$modified_date = sprintf( '<time class="updated" datetime="%1$s">%2$s</time></a>',
	esc_attr( get_the_modified_date( 'c' ) ),
	esc_html( get_the_modified_date( 'Y. F j.' ) )
);

$utility_text ='<div class="post-meta">';
$utility_text .='<p class="screen-reader-text">'. __( 'Post meta', 'manduca' ) .'</p>';
$utility_text .= "<ul>";

$utility_text .= '<li><svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M192 1664h288v-288h-288v288zm352 0h320v-288h-320v288zm-352-352h288v-320h-288v320zm352 0h320v-320h-320v320zm-352-384h288v-288h-288v288zm736 736h320v-288h-320v288zm-384-736h320v-288h-320v288zm768 736h288v-288h-288v288zm-384-352h320v-320h-320v320zm-352-864v-288q0-13-9.5-22.5t-22.5-9.5h-64q-13 0-22.5 9.5t-9.5 22.5v288q0 13 9.5 22.5t22.5 9.5h64q13 0 22.5-9.5t9.5-22.5zm736 864h288v-320h-288v320zm-384-384h320v-288h-320v288zm384 0h288v-288h-288v288zm32-480v-288q0-13-9.5-22.5t-22.5-9.5h-64q-13 0-22.5 9.5t-9.5 22.5v288q0 13 9.5 22.5t22.5 9.5h64q13 0 22.5-9.5t9.5-22.5zm384-64v1280q0 52-38 90t-90 38h-1408q-52 0-90-38t-38-90v-1280q0-52 38-90t90-38h128v-96q0-66 47-113t113-47h64q66 0 113 47t47 113v96h384v-96q0-66 47-113t113-47h64q66 0 113 47t47 113v96h128q52 0 90 38t38 90z"/></svg><span> ' .__( 'Entry date', 'manduca' ) .':</span> ' . $date .'</li>';

if( get_the_date() !== get_the_modified_date() ) {
	$utility_text .='<li><svg width="1792" height="1792" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1536 256q52 0 90 38t38 90v1280q0 52-38 90t-90 38h-1408q-52 0-90-38t-38-90v-1280q0-52 38-90t90-38h128v-96q0-66 47-113t113-47h64q66 0 113 47t47 113v96h384v-96q0-66 47-113t113-47h64q66 0 113 47t47 113v96h128zm-384-96v288q0 14 9 23t23 9h64q14 0 23-9t9-23v-288q0-14-9-23t-23-9h-64q-14 0-23 9t-9 23zm-768 0v288q0 14 9 23t23 9h64q14 0 23-9t9-23v-288q0-14-9-23t-23-9h-64q-14 0-23 9t-9 23zm1152 1504v-1024h-1408v1024h1408zm-640-576h224q14 0 23 9t9 23v64q0 14-9 23t-23 9h-224v224q0 14-9 23t-23 9h-64q-14 0-23-9t-9-23v-224h-224q-14 0-23-9t-9-23v-64q0-14 9-23t23-9h224v-224q0-14 9-23t23-9h64q14 0 23 9t9 23v224z"/></svg><span> ' . __( 'Last revision:', 'manduca' ) .':</span> ' .$modified_date .'</li>';
}

$utility_text .= '<li><svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1600 1405q0 120-73 189.5t-194 69.5h-874q-121 0-194-69.5t-73-189.5q0-53 3.5-103.5t14-109 26.5-108.5 43-97.5 62-81 85.5-53.5 111.5-20q9 0 42 21.5t74.5 48 108 48 133.5 21.5 133.5-21.5 108-48 74.5-48 42-21.5q61 0 111.5 20t85.5 53.5 62 81 43 97.5 26.5 108.5 14 109 3.5 103.5zm-320-893q0 159-112.5 271.5t-271.5 112.5-271.5-112.5-112.5-271.5 112.5-271.5 271.5-112.5 271.5 112.5 112.5 271.5z"/></svg><span> ' .__( 'Author', 'manduca' ) .':</span> ' . $author .'</li>';

if ( $categories_list ) {
	$utility_text .='<li><svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1815 952q0 31-31 66l-336 396q-43 51-120.5 86.5t-143.5 35.5h-1088q-34 0-60.5-13t-26.5-43q0-31 31-66l336-396q43-51 120.5-86.5t143.5-35.5h1088q34 0 60.5 13t26.5 43zm-343-344v160h-832q-94 0-197 47.5t-164 119.5l-337 396-5 6q0-4-.5-12.5t-.5-12.5v-960q0-92 66-158t158-66h320q92 0 158 66t66 158v32h544q92 0 158 66t66 158z"/></svg><span> ' .__( 'Category', 'manduca' ) .':</span> ' .$categories_list .'</li>';
}

if ( $tag_list ) {
	$utility_text .= '<li><svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M384 448q0-53-37.5-90.5t-90.5-37.5-90.5 37.5-37.5 90.5 37.5 90.5 90.5 37.5 90.5-37.5 37.5-90.5zm1067 576q0 53-37 90l-491 492q-39 37-91 37-53 0-90-37l-715-716q-38-37-64.5-101t-26.5-117v-416q0-52 38-90t90-38h416q53 0 117 26.5t102 64.5l715 714q37 39 37 91zm384 0q0 53-37 90l-491 492q-39 37-91 37-36 0-59-14t-53-45l470-470q37-37 37-90 0-52-37-91l-715-714q-38-38-102-64.5t-117-26.5h224q53 0 117 26.5t102 64.5l715 714q37 39 37 91z"/></svg><span> '. __( 'Tags', 'manduca' ) .':</span> ' .$tag_list .'</li>';
}


$utility_text .='</ul>' .PHP_EOL .'</div>';

$utility_text = apply_filters( 'manduca_post_meta', $utility_text );

echo $utility_text;
	


if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) :  ?>
	<div class="author-info">
		<div class="author-avatar">
			<?php
			/** This filter is documented in author.php */
			$author_bio_avatar_size = apply_filters( 'manduca_author_bio_avatar_size', 68 );
			echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
			?>
		</div><!-- .author-avatar -->
		<div class="author-description">
			<h3><?php printf( __( 'Author: %s', 'manduca' ), get_the_author() ); ?></h3>
			<p><?php the_author_meta( 'description' ); ?></p>
			<div class="author-link">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
					<?php printf( __( 'All posts by %s', 'manduca' ) . '<span class="meta-nav">&rarr;</span>', get_the_author() ); ?>
				</a>
			</div><!-- .author-link	-->
		</div><!-- .author-description -->
	</div><!-- .author-info -->
<?php endif; ?>

