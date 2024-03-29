<?php
/**
 * Display the meta data of the post*
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

$list_item_mask 	= '<li>%s<span class="meta-item"><span class="meta-item-label">%s: </span>%s</span></li>';

//key of meta_type array has only comment function 
$meta_type=array(
		'date' => array (
						'icon'=> manduca_icon( 'calendar', false ),
						// translators: Date of post - in the post meta. 
						'label'=> __( 'Entry date', 'manduca' ),
						'callback'=>array( 'Manduca\helpers\Meta_Tags', 'get_post_date')),
		'modified-date' => array (
						'icon'=> manduca_icon( 'calendar-add', false ) ,
						//translators: Last modification of post - in the post meta
						'label' => __( 'Last revision', 'manduca', false ),
						'callback'=>array( 'Manduca\helpers\Meta_Tags', 'get_modified_date') ),
		'author' => array (
						'icon'=> manduca_icon( 'author', false ) ,
						//translators: Author of post - in the post meta
						'label' => __( 'Author', 'manduca'),
						'callback'=>array( 'Manduca\helpers\Meta_Tags', 'get_author') ),
		'categories' => array (
						'icon'=> manduca_icon( 'folder-open', false ),
						//translators: Category of post - in the post meta 
						'label' => __( 'Category', 'manduca', false ),
						'callback'=>array( 'Manduca\helpers\Meta_Tags', 'get_categories') ),
		'tags' => array (
						'icon'=> manduca_icon( 'tags', false ),
						//translators: Tags of post - in the post meta
						'label' => __( 'Tags', 'manduca', false ),
						'callback'=>array( 'Manduca\helpers\Meta_Tags', 'get_tags') ),
						
		);
$meta_html=Manduca\helpers\Meta_Tags::meta_tag_html ($list_item_mask, $meta_type); 
if ($meta_html ) : ?>
<footer class="lighter-scheme metatags">
	<ul>
		<?php echo $meta_html; ?>
	</ul>
</footer>
<?php endif; ?>


<?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) :  ?>
	<section class="metatags" arialabelledby="author-header">
		<h2 class="screen-reader-text" id="author-header">
		<?php
		// Translators: visually hidden title of author info
		_e( 'Author info', 'manduca' ) ;?>
	</h2>
		<div class="author-info">
			<div class="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), 68 ); ?>
			</div>
			
			<div class="author-description">
				<h3><?php printf( __( 'Author: %s', 'manduca' ), get_the_author() ); ?></h3>
				<p><?php the_author_meta( 'description' ); ?></p>
				<div class="author-link">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
						<?php printf( __( 'All posts by %s', 'manduca' ) , get_the_author() ) ; ?>
						<?php manduca_icon( 'angle-circle-right' ) ?>
					</a>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

