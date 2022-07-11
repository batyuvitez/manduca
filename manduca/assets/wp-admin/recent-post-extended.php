<?php
/**
 * The custom recent posts widget.
 * This widget gives enahnced control over the output to the user.
 *
 */

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)
	Source code is available at https://github.com/batyuvitez/manduca

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    in assets/docs/licence.txt.  If not, see <https://www.gnu.org/licenses/>.
*/

use \Manduca\helpers as hlp;
?>

<div class="admin-col">

	<p>
		<label for="<?php echo $args[ 'id' ][ 'title' ]; ?>">
			<?php _e( 'Title', 'manduca' ); ?>
		</label>
		<input class="widefat" id="<?php echo $args[ 'id' ][ 'title' ]; ?>" name="<?php echo $args[ 'name' ][ 'title' ]; ?>" type="text" value="<?php echo esc_attr( $args[ 'value' ][ 'title'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo $args[ 'id' ][ 'title_url' ]; ?>">
			<?php _e( 'Title URL', 'manduca' ); ?>
		</label>
		<input class="widefat" id="<?php echo $args[ 'id' ][ 'title_url' ]; ?>" name="<?php echo $args[ 'name' ][ 'title_url' ]; ?>" type="text" value="<?php echo esc_url( $args[ 'value' ][ 'title_url'] ); ?>" />
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $args[ 'value' ][ 'ignore_sticky'], 1 ); ?> id="<?php echo $args[ 'id' ][ 'ignore_sticky' ]; ?>" name="<?php echo $args ['name'] [ 'ignore_sticky' ]; ?>" />
		<label for="<?php echo $args[ 'id' ][ 'ignore_sticky' ]; ?>">
			<?php _e( 'Ignore sticky posts', 'manduca' ); ?>
		</label>
	</p>

	<p>
		<input class="checkbox" type="checkbox" <?php checked( $args[ 'value' ][ 'exclude_current'], 1 ); ?> id="<?php echo $args[ 'id' ][ 'exclude_current' ]; ?>" name="<?php echo $args ['name'] ['exclude_current' ]; ?>" />
		<label for="<?php echo $args[ 'id' ][ 'exclude_current' ]; ?>">
			<?php _e( 'Exclude current post', 'manduca' ); ?>
		</label>
	</p>

	<div class="admin-multiple-check-form">
		<label>
			<?php _e( 'Post Types', 'manduca' ); ?>
		</label>
		<ul>
			<?php foreach ( get_post_types( array( 'public' => true ), 'objects' ) as $type ) : ?>
				<li>
					<input type="checkbox" value="<?php echo esc_attr( $type->name ); ?>" id="<?php echo $args[ 'id' ][ 'post_type' ] . '-' . $type->name; ?>" name="<?php echo $args ['name'] ['post_type' ]; ?>[]" <?php checked( is_array( $args[ 'value' ][ 'post_type'] ) && in_array( $type->name, $args[ 'value' ][ 'post_type'] ) ); ?> />
					<label for="<?php echo $args[ 'id' ][ 'post_type' ] . '-' . $type->name; ?>">
						<?php echo esc_html( $type->labels->name ); ?>
					</label>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

	<p>
		<label for="<?php echo $args[ 'id' ][ 'post_status' ]; ?>">
			<?php _e( 'Post Status', 'manduca' ); ?>
		</label>
		<select class="widefat" id="<?php echo $args[ 'id' ][ 'post_status' ]; ?>" name="<?php echo $args[ 'name' ][ 'post_status' ]; ?>" style="width:100%;">
			<?php foreach ( get_available_post_statuses() as $status_value => $status_label ) { ?>
				<option value="<?php echo esc_attr( $status_label ); ?>" <?php selected( $args[ 'value' ][ 'post_status'], $status_label ); ?>><?php echo esc_html( ucfirst( $status_label ) ); ?></option>
			<?php } ?>
		</select>
	</p>

	<p>
		<label for="<?php echo $args[ 'id' ][ 'order' ]; ?>">
			<?php _e( 'Order', 'manduca' ); ?>
		</label>
		<select class="widefat" id="<?php echo $args[ 'id' ][ 'order' ]; ?>" name="<?php echo $args[ 'name' ][ 'order' ]; ?>" style="width:100%;">
			<option value="DESC" <?php selected( $args[ 'value' ][ 'order'], 'DESC' ); ?>><?php _e( 'Descending', 'manduca' ) ?></option>
			<option value="ASC" <?php selected( $args[ 'value' ][ 'order'], 'ASC' ); ?>><?php _e( 'Ascending', 'manduca' ) ?></option>
		</select>
	</p>

	<p>
		<label for="<?php echo $args[ 'id' ][ 'orderby' ]; ?>">
			<?php _e( 'Orderby', 'manduca' ); ?>
		</label>
		<select class="widefat" id="<?php echo $args[ 'id' ][ 'orderby' ]; ?>" name="<?php echo $args[ 'name' ][ 'orderby' ]; ?>" style="width:100%;">
			<option value="ID" <?php selected( $args[ 'value' ][ 'orderby'], 'ID' ); ?>><?php _e( 'ID', 'manduca' ) ?></option>
			<option value="author" <?php selected( $args[ 'value' ][ 'orderby'], 'author' ); ?>><?php _e( 'Author', 'manduca' ) ?></option>
			<option value="title" <?php selected( $args[ 'value' ][ 'orderby'], 'title' ); ?>><?php _e( 'Title', 'manduca' ) ?></option>
			<option value="date" <?php selected( $args[ 'value' ][ 'orderby'], 'date' ); ?>><?php _e( 'Date', 'manduca' ) ?></option>
			<option value="modified" <?php selected( $args[ 'value' ][ 'orderby'], 'modified' ); ?>><?php _e( 'Modified', 'manduca' ) ?></option>
			<option value="rand" <?php selected( $args[ 'value' ][ 'orderby'], 'rand' ); ?>><?php _e( 'Random', 'manduca' ) ?></option>
			<option value="comment_count" <?php selected( $args[ 'value' ][ 'orderby'], 'comment_count' ); ?>><?php _e( 'Comment Count', 'manduca' ) ?></option>
			<option value="menu_order" <?php selected( $args[ 'value' ][ 'orderby'], 'menu_order' ); ?>><?php _e( 'Menu Order', 'manduca' ) ?></option>
		</select>
	</p>

		
</div>

<div class="admin-col">

	<div class="admin-multiple-check-form">
		<label>
			<?php _e( 'Limit to Category', 'manduca' ); ?>
		</label>
		<ul>
			<?php foreach ( hlp\Widgets::get_categories () as $category ) : ?>
				<li>
					<input type="checkbox" value="<?php echo (int) $category->term_id; ?>" id="<?php echo $args[ 'id' ][ 'cat' ] . '-' . (int) $category->term_id; ?>" name="<?php echo $args ['name']['cat' ]; ?>[]" <?php checked( is_array( $args[ 'value' ][ 'cat'] ) && in_array( $category->term_id, $args[ 'value' ][ 'cat'] ) ); ?> />
					<label for="<?php echo $args[ 'id' ][ 'cat' ] . '-' . (int) $category->term_id; ?>">
						<?php echo esc_html( $category->name ); ?>
					</label>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

	<div class="admin-multiple-check-form">
		<label>
			<?php _e( 'Limit to Tag', 'manduca' ); ?>
		</label>
		<ul>
			<?php foreach ( hlp\Widgets::tag_list () as $post_tag ) : ?>
				<li>
					<input type="checkbox" value="<?php echo (int) $post_tag->term_id; ?>" id="<?php echo $args[ 'id' ][ 'tag' ] . '-' . (int) $post_tag->term_id; ?>" name="<?php echo $args ['name'][ 'tag' ]; ?>[]" <?php checked( is_array( $args[ 'value' ][ 'tag'] ) && in_array( $post_tag->term_id, $args[ 'value' ][ 'tag'] ) ); ?> />
					<label for="<?php echo $args[ 'id' ][ 'tag' ] . '-' . (int) $post_tag->term_id; ?>">
						<?php echo esc_html( $post_tag->name ); ?>
					</label>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>

	
</div>

<div class="admin-col admin-last-col">

	<p>
		<label for="<?php echo $args[ 'id' ][ 'limit' ]; ?>">
			<?php _e( 'Number of posts to show', 'manduca' ); ?>
		</label>
		<input class="widefat" id="<?php echo $args[ 'id' ][ 'limit' ]; ?>" name="<?php echo $args[ 'name' ][ 'limit' ]; ?>" type="number" step="1" min="-1" value="<?php echo (int)( $args[ 'value' ][ 'limit'] ); ?>" />
	</p>

	<p>
		<label for="<?php echo $args[ 'id' ][ 'offset' ]; ?>">
			<?php _e( 'Offset', 'manduca' ); ?>
		</label>
		<input class="widefat" id="<?php echo $args[ 'id' ][ 'offset' ]; ?>" name="<?php echo $args[ 'name' ][ 'offset' ]; ?>" type="number" step="1" min="0" value="<?php echo (int)( $args[ 'value' ][ 'offset'] ); ?>" />
		
	</p>

	<?php if ( current_theme_supports( 'post-thumbnails' ) ) { ?>

		<p>
			<input id="<?php echo $args[ 'id' ][ 'thumb' ]; ?>" name="<?php echo $args[ 'name' ][ 'thumb' ]; ?>" type="checkbox" <?php checked( $args[ 'value' ][ 'thumb'] ); ?> />
			<label for="<?php echo $args[ 'id' ][ 'thumb' ]; ?>">
				<?php _e( 'Display Thumbnail', 'manduca' ); ?>
			</label>
		</p>

		
		<p>
			<label for="<?php echo $args[ 'id' ][ 'thumb_default' ]; ?>">
				<?php _e( 'Default Thumbnail', 'manduca' ); ?>
			</label>
			<input class="widefat" id="<?php echo $args[ 'id' ][ 'thumb_default' ]; ?>" name="<?php echo $args[ 'name' ][ 'thumb_default' ]; ?>" type="text" value="<?php echo $args[ 'value' ][ 'thumb_default']; ?>"/>
		</p>

	<?php } ?>


	<p>
		<input id="<?php echo $args[ 'id' ][ 'excerpt' ]; ?>" name="<?php echo $args[ 'name' ][ 'excerpt' ]; ?>" type="checkbox" <?php checked( $args[ 'value' ][ 'excerpt'] ); ?> />
		<label for="<?php echo $args[ 'id' ][ 'excerpt' ]; ?>">
			<?php _e( 'Display Excerpt', 'manduca' ); ?>
		</label>
	</p>

	
	
	<p>
		<input id="<?php echo $args[ 'id' ][ 'comment_count' ]; ?>" name="<?php echo $args[ 'name' ][ 'comment_count' ]; ?>" type="checkbox" <?php checked( $args[ 'value' ][ 'comment_count'] ); ?> />
		<label for="<?php echo $args[ 'id' ][ 'comment_count' ]; ?>">
			<?php _e( 'Display Comment Count', 'manduca' ); ?>
		</label>
	</p>

	<p>
		<input id="<?php echo $args[ 'id' ][ 'date' ]; ?>" name="<?php echo $args[ 'name' ][ 'date' ]; ?>" type="checkbox" <?php checked( $args[ 'value' ][ 'date'] ); ?> />
		<label for="<?php echo $args[ 'id' ][ 'date' ]; ?>">
			<?php _e( 'Display Date', 'manduca' ); ?>
		</label>
	</p>
	
	
	<p>
		<input id="<?php echo $args[ 'id' ][ 'date_relative' ]; ?>" name="<?php echo $args[ 'name' ][ 'date_relative' ]; ?>" type="checkbox" <?php checked( $args[ 'value' ][ 'date_relative'] ); ?> />
		<label for="<?php echo $args[ 'id' ][ 'date_relative' ]; ?>">
			<?php _e( 'Use Relative Date. eg: 5 days ago', 'manduca' ); ?>
		</label>
	</p>
	
	<p>
		<input id="<?php echo $args[ 'id' ][ 'more_posts' ]; ?>" name="<?php echo $args[ 'name' ][ 'more_posts' ]; ?>" type="checkbox" <?php checked( $args[ 'value' ][ 'more_posts'] ); ?> />
		<label for="<?php echo $args[ 'id' ][ 'more_posts' ]; ?>">
			<?php _e( 'Show all posts button', 'manduca' ); ?>
		</label>
	</p>
	

</div>

<div class="clear"></div>

