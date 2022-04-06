<?php
/**
 * The custom recent posts widget.
 * This widget gives total control over the output to the user.
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
 


namespace Manduca\widgets;

use Manduca\helpers as hlp;

class Widget_Recent_Posts extends \WP_Widget {

	public function __construct() {

		$widget_options = array(
			'classname'   => 'accessible-recent-posts',
			'description' => __( 'Gives enhanced control and accessible HTML', 'manduca' ),
			'customize_selective_refresh' => true
		);

		$control_options = array(
			'width'  => 750,
			'height' => 350
		);

		/* Create the widget. */
		parent::__construct(
			'manduca-recent-posts-extended',                                             
			__( 'Accessible recent posts widget', 'manduca' ), 					
			$widget_options,                                               
			$control_options                                               
		);

		$this->alt_option_name = 'rpwe_widget';

	}

	
	public function widget( $args, $instance ) {
		
		$instance = wp_parse_args($instance, $this->get_default_args() );
		
		echo $args ['before_widget'];	
		
		if ( !empty ($instance['title'] ) ) {

			if ( ! empty( $instance['title_url'] ) ) {
				echo  $args['before_title'] . '<a href="' . esc_url( $instance['title_url'] ) . '" >' . $instance['title']. '</a>' . $args ['$after_title'];
			}
			else  {
				echo $args['before_title'] . $instance['title']. $args['after_title'];
			}
		}
		
		echo '<div class="widget-content">';
		hlp\Widgets::display_recent_posts ( $instance );
		echo '</div>';
		echo $args ['after_widget'];
	}

	public function update( $new_instance, $old_instance ) {
		
		
		// Validate post_type submissions
		$name = get_post_types( array( 'public' => true ), 'names' );
		$types = array();
		foreach( $new_instance['post_type'] as $type ) {
			if ( in_array( $type, $name ) ) {
				$types[] = $type;
			}
		}
		if ( empty( $types ) ) {
			$types[] = 'post';
		}

		$instance                     = $old_instance;
		$instance['title']            = sanitize_text_field( $new_instance['title'] );
		$instance['title_url']        = esc_url_raw( $new_instance['title_url'] );

		$instance['ignore_sticky']    = isset( $new_instance['ignore_sticky'] ) ? (bool) $new_instance['ignore_sticky'] : 0;
		$instance['exclude_current']  = isset( $new_instance['exclude_current'] ) ? (bool) $new_instance['exclude_current'] : 0;
		$instance['limit']            = intval( $new_instance['limit'] );
		$instance['offset']           = intval( $new_instance['offset'] );
		$instance['order']            = stripslashes( $new_instance['order'] );
		$instance['orderby']          = stripslashes( $new_instance['orderby'] );
		$instance['post_type']        = $types;
		$instance['post_status']      = stripslashes( $new_instance['post_status'] );
		$instance['cat']              = $new_instance['cat'];
		$instance['tag']              = $new_instance['tag'];
		
		$instance['excerpt']          = isset( $new_instance['excerpt'] ) ? (bool) $new_instance['excerpt'] : false;
		$instance['date']             = isset( $new_instance['date'] ) ? (bool) $new_instance['date'] : false;
		$instance['date_relative']    = isset( $new_instance['date_relative'] ) ? (bool) $new_instance['date_relative'] : false;
		$instance['comment_count']    = isset( $new_instance['comment_count'] ) ? (bool) $new_instance['comment_count'] : false;

		$instance['thumb']            = isset( $new_instance['thumb'] ) ? (bool) $new_instance['thumb'] : false;
		$instance['thumb_default']    = esc_url_raw( $new_instance['thumb_default'] );

		return $instance;

	}

	public function form( $instance ) {
		
		$default_args = $this->get_default_args() ;
		$all_args= wp_parse_args( (array) $instance, $default_args);
		$ids=array();
		foreach ( $all_args as $id => $arg ) {
			$form_args ['id'][$id]=$this->get_field_id( $id);
			$form_args['value'][$id]=$arg;
			$form_args['name'][$id]=$this->get_field_name( $id);;
		}
		get_template_part ('/assets/wp-admin/recent-post-extended' , NULL, $form_args);
	}
	
	
	public function get_default_args() {
	
		return array(
			'title'             => esc_attr__( 'Recent Posts', 'manduca' ),
			'title_url'         => '',
	
			'limit'            => 5,
			'offset'           => 0,
			'order'            => 'DESC',
			'orderby'          => 'date',
			'cat'              => array(),
			'tag'              => array(),
			'post_type'        => array( 'post' ),
			'post_status'      => 'publish',
			'ignore_sticky'    => 1,
			'exclude_current'  => 1,
	
			'excerpt'          => TRUE,
			'thumb'            => TRUE,
			'thumb_default'    => '',
			'date'             => true,
			'date_relative'    => TRUE,
			'comment_count'    => TRUE,
	
		);
	}
}
