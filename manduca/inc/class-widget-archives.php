<?php
/**
 * Accessible archive widget
 *@since 19.2
 */

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2019  Zsolt Edelényi (ezs@web25.hu)

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

 namespace Manduca;

 
class Widget_Archives extends \WP_Widget {
	
	/**
	 * Sets up a new Archives widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_archive',
			'description' => __( 'More user-friendly archive of your site&#8217;s Posts.', 'manduca' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'manduca_archives', __(' User-friendly archives' , 'manduca' ), $widget_ops);
	}

	/**
	 * Outputs the content.
	 *
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Archives widget instance.
	 */
	public function widget( $args, $instance ) {
        global $wp_locale;
                
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Archives', 'manduca' );

		$c = ! empty( $instance['count'] ) ? '1' : '0';

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
        $dropdown_id = "{$this->id_base}-dropdown-{$this->number}";
        $dropdown_html = $this->get_archives(  array('show_post_count'   => $c) ) ;
        ?>
        
		<label class="screen-reader-text" for="<?php echo 'year-' .esc_attr( $dropdown_id ); ?>"><?php _e( 'Select Year' ) ; ?>:</label>
		<select id="manduca-archive-year-dropdown" name="manduca-archive-year-dropdown" >
        <?php
            foreach( $dropdown_html as $year => $months ) {
                printf( '<option value ="%1$s">%1$s</options>', $year );
            }
        ?>
        </select>
        
        <label class="screen-reader-text" for="<?php echo 'month-' .esc_attr( $dropdown_id ); ?>"><?php _e( 'Select Month' ) ; ?>:</label>
		<select id="manduca-archive-month-dropdown" name="manduca-archive-month-dropdown" >
			<?php
            for( $month = 1; $month <= 12; $month ++ ) {
                printf( '<option value ="%02d">%2$s</options>',
                       $month,
                       $wp_locale->get_month( $month )
                       );
            }
        ?>
		</select>
        <button id="manduca-archive-widget-submit"><?php _e( 'Jump to archive', 'manduca' ); ?> </button> 
		<?php 

		echo $args['after_widget'];
	}

	/**
	 * Handles updating settings for the current Archives widget instance.
	 *
	 * @since 2.8.0
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget_Archives::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		
		return $instance;
	}

	/**
	 * Outputs the settings form for the Archives widget.
	 *
	 * @since 2.8.0
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0 ) );
		$title = sanitize_text_field( $instance['title'] );
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
		
		<?php
	}
    
    
    
    /**
     * Display archive links based on type and format.
     * With modification of wp_get_archives in general-template.php: 
     * If you call monthly, you get only the actual year.
     *
     * This method is not necessary, need to think it again.
     * 
     * @see get_archives_link()
     *
     * @global wpdb      $wpdb
     *
     * @param string|array $args {
     *     Default archive links arguments. Optional.
     *
     *     @type string|int $limit           Number of links to limit the query to. Default empty (no limit).
     *     @type string     $before          Markup to prepend to the beginning of each link. Default empty.
     *     @type string     $after           Markup to append to the end of each link. Default empty.
     *     @type bool       $show_post_count Whether to display the post count alongside the link. Default false.
     *     @type string     $order           Whether to use ascending or descending order. Accepts 'ASC', or 'DESC'.
     *                                       Default 'DESC'.
     *     @type string     $post_type       Post type. Default 'post'.
     * }
     * @return string|void String when retrieving.
     */
    public function get_archives( $args = '' ) {
        global $wpdb, $wp_locale;
    
        $defaults = array(
            'limit' => '',
             'before' => '',
            'after' => '',
            'order' => 'DESC',
            'post_type' => 'post'
        );
    
        $r = wp_parse_args( $args, $defaults );
    
        $post_type_object = get_post_type_object( $r['post_type'] );
        if ( ! is_post_type_viewable( $post_type_object ) ) {
            return;
        }
        $r['post_type'] = $post_type_object->name;
    
        if ( ! empty( $r['limit'] ) ) {
            $r['limit'] = absint( $r['limit'] );
            $r['limit'] = ' LIMIT ' . $r['limit'];
        }
    
        $order = strtoupper( $r['order'] );
        if ( $order !== 'ASC' ) {
            $order = 'DESC';
        }
    
        
        $where = $wpdb->prepare( "WHERE post_type = %s AND post_status = 'publish'", $r['post_type'] );
    
    
        $output = array();
        $last_changed = wp_cache_get_last_changed( 'posts' );
    
        $limit = $r['limit'];
        
        $query = "
                SELECT
                    YEAR(post_date) AS `year`,
                    MONTH(post_date) AS `month`,
                    count(ID) as posts
                FROM $wpdb->posts
                $where
                GROUP BY YEAR(post_date),
                MONTH(post_date)
                ORDER BY post_date $order $limit";
        $key = md5( $query );
        $key = "wp_get_archives:$key:$last_changed";
        if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
            $results = $wpdb->get_results( $query );
            wp_cache_set( $key, $results, 'posts' );
        }
        
        if ( $results ) {
            $after = $r['after'];
            
            $years = array();
            foreach ( (array) $results as $result ) {
                $year = $result->year;
                if( !in_array( $year, $years ) ){
                    $years[] = $year;
                }
            }
            foreach( $years as $year ){
                    
                foreach ( (array) $results as $result ) {
                    if( $result->year ===$year ) {
                                    
                        $url = get_month_link( $year, $result->month );
                        if ( 'post' !== $r['post_type'] ) {
                            $url = add_query_arg( 'post_type', $r['post_type'], $url );
                        }
                        /* translators: 1: month name, 2: 4-digit year */
                        $text = $wp_locale->get_month( $result->month );
                        $output[ $year ][] = get_archives_link( $url, $text, 'option', $r['before'], $r['after'] );
                    }
                }
            }
        }
                    
        return $output;
    
    }

    
}
