<?php
/**
 * Enhanced archive widget
 *
 * The archive widget (archive by months) may have very long: more hundreds item in select menu.
 *  This is reduced significantly with 2 select menus: year and months. 
 * 
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
    in assets/docs/licence.txt.  If not, see <https://www.gnu.org/licenses/>.
*/


namespace Manduca;

 
class Widget_Archives extends \WP_Widget {
	
   const WIDGET_ID = 'manduca_archive';
	
	protected $archive_array = array();
	
	/**
	 * Sets up a new Archives widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_archive',
			// translators: description of Manduca's accessible archive widget
			'description' => __( 'More user-friendly archive of your site&#8217;s Posts.', 'manduca' ),
			'customize_selective_refresh' => true,
		);
		// translators: name of Manduca's accessible archive widget
		parent::__construct( self::WIDGET_ID, __(' User-friendly archives' , 'manduca' ), $widget_ops);
		
		add_action(
				   'manduca_ajax_call',
				   array( $this, 'get_archive_months')
				   ); 
		
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
				
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Archives' );
		
		$c = ! empty( $instance['count'] ) ? '1' : '0';
		
		echo $args['before_widget'];
		
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}
		
		$dropdown_id = "{$this->id_base}-dropdown-{$this->number}";
		//$dropdown_html = $this->get_archives(  array('show_post_count'   => $c) ) ;
		$years = $this->get_years();
				
		// translators: first select menu's text in archive widget
		$year_select_text = __( 'Select year', 'manduca' );
		
		// translators: second select menus's text in archive widget if no year selected.
		$month_select_text = __( 'First select year', 'manduca' );
				
		?>
		<select id="manduca-archive-year-dropdown" name="manduca-archive-year-dropdown" >
		 <option value="" disabled selected><?php echo $year_select_text; ?></option>
		<?php
			foreach( $years as $year => $count  ) {
			   if( 1 === $c ) {
				printf( '<option value ="%1$s">%1$s ( %2$s) </option>', $year, $count );
			   }
			   else {
				  printf( '<option value ="%1$s">%1$s</option>', $year );
			   }
			}
		?>
		</select>
		
		<select id="manduca-archive-month-dropdown" name="manduca-archive-month-dropdown" >
			<option disabled selected><?php echo $month_select_text; ?></option>
		</select>
		<button id="manduca_archive-month-submit"><?php _e( 'Submit' ) ?></button>
		
		<?php
		echo $args['after_widget'];
	}

	
	
	/**
	 * Handles updating settings for the current Archives widget instance.
	 * Copied from Wordpress widget
	 *
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
     * Return years of archive links 
     *
     * @return array {year=>count}
     */
    public function get_years() {
        global $wpdb;
        $query = "
                SELECT
                    YEAR(post_date) AS 'year',        
                    count(ID) as count
                FROM $wpdb->posts
                WHERE post_type = 'post' AND post_status = 'publish'
                GROUP BY YEAR(post_date)
                ORDER BY post_date";
		 $results = $wpdb->get_results( $query );
        
		$years = array();
        if ( $results ) {    
            $years = array();
            foreach ( (array) $results as $result ) {
			   $years[ $result->year ] = $result->count;
            }
		}
        return $years;
    
    }
	
	/*
	 *This method is called with ajax
	 *displays the html of the month select menu
	 */
	
	public function get_archive_months(){
		check_ajax_referer( 'manduca-ajax', 'hash', false );
		global $wpdb, $wp_locale;
    
        $defaults = array(
            'limit' => '',
            'order' => 'DESC',
            'post_type' => 'post'
        );
    
        $r = $defaults;
    
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
            $years = array();
            foreach ( (array) $results as $result ) {
                $year = $result->year;
                if( !in_array( $year, $years ) ){
                    $years[] = $year;
                }
            }
			
		 //translators: second select menu's text in archive widget is year is selected:
		$month_text_year_selected = __( 'Months in %s', 'manduca' );
            foreach( $years as $year ){
               $current_year = array();
               foreach ( (array) $results as $result ) {
                    if( $result->year ===$year ) {                
                        $url = get_month_link( $year, $result->month );
                        if ( 'post' !== $r['post_type'] ) {
                            $url = add_query_arg( 'post_type', $r['post_type'], $url );
                        }
                        /* translators: 1: month name, 2: 4-digit year */
                        $text = $wp_locale->get_month( $result->month );
                        //$output[ $year ][] = get_archives_link( $url, $text, 'option', $r['before'], $r['after'] );
						$current_year[] = sprintf( '<option value="%1$s">%2$s</option>', $result->month, $text );
                    }
                }
				$current_year[] = sprintf( '<option value="" disabled="disabled" selected >%s</option>',
										  sprintf( $month_text_year_selected, $year )
									);
				$output[ $year ] = array_reverse( $current_year );
            }
        }
                    
		
		$this->archive_array = $this->get_archives();
		
		if( isset( $output[ $_REQUEST[ 'year' ] ] ) ){
			echo implode( ' ',  $output[ $_REQUEST[ 'year' ] ] ) ;
		}
		die();
	}

   
   
   
   
   /*
    * The is_active_widget has bugs, this should be used instead.
    *
    *@return bool : true if this widget is active. 
    * */
	public static function is_this_widget_active(){
	  foreach( wp_get_sidebars_widgets() as $sidebars) {
		 foreach( $sidebars as $widget ){
			if( false !== strpos( $widget, self::WIDGET_ID ) ){
			   return true;
			}
		 }
	  }
	  return false;
	}
	
}
