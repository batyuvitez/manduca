<?php
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

 
class Page_Sisters extends \WP_Widget
{
	
   const WIDGET_ID = 'page_sisters';
   
	protected $archive_array = array();
   
   protected $meta_name ='web25_page_order';
	
	/**
	 * Sets up a new Archives widget instance.
	 *
	 * @since 2.8.0
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'widget_page_sisters',
			// translators: description of Manduca's accessible archive widget
			'description' => __( 'Displays the pages of the same parent page' ),
			'customize_selective_refresh' => FALSE,
		);
		// translators: name of Manduca's accessible archive widget
		parent::__construct( self::WIDGET_ID, __( 'Sister pages' ), $widget_ops);
	}

	
	
	
	/**
	 * Outputs the content.
	 *
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Archives widget instance.
	 */
	public function widget( $args, $instance )   {
		global $wp_locale;
		/*Hiába tettem bele a widget_title filtert, nem ment valamiért, ez íygy most egyszerűbb volt,
		mivel az svg-t úgyis külön meg kell adni*/
		$args['title']=$instance['title'];
		$a=$this->getSisterPages ();
      if( $a ) {
         $args['list']=$a;
         get_template_part ( '/template-parts/widget/sisterpages', '', $args);
      }
		
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
	public function update( $new_instance, $old_instance )
   {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, array( 'title' => '') );
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		
		return $instance;
	}

	
	
	/**
	 * Outputs the settings form for the Archives widget.
	 * Copied from WordPress' archive widget
	 * 
	 *
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance )  {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'count' => 0 ) );
		$title = sanitize_text_field( $instance['title'] );
		?>
		<p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'manduca' ); ?></label>
         <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
      </p>
		
		<?php
	}
    
	
   private function getSisterPages () {
        global $post;
        if ($post->post_type !=='page')
           return FALSE;
        if ( $post->post_parent != 0 )
           $child_of = $post->post_parent;
        else
             $child_of = $post->ID;
		
		$args=array (
         'child_of' 			=> $child_of,
         'sort_order'		=>'ASC',
         'sort_column'		=>'post_date',
         'depth'				=> 2,
		'show_date'    => '',
		'date_format'  => get_option( 'date_format' ),
		'sort_column'  => 'menu_order, post_title',
		'item_spacing' => 'preserve' );
		
        $html = $this->listPages( $args);
        if (empty ($html))
            return FALSE;
        return $html;
	
    }
	
	
	/*
	 *Simplified clone of  wp_list_pages,
	 *Reason: there is no filter in wp_list_pages
	 **/
	private function listPages( $args )
	{
			
		$output= '';
		$args['hierarchical'] = 0;
	
		// Query pages.
		$pages=get_pages( $args );
		$pages=$this->reorderPages ($pages, $args['child_of']);
		if ( ! empty( $pages ) ) {
				
			global $wp_query;
	
			$current_page = get_queried_object_id();
			
			$output .= walk_page_tree( $pages, $args['depth'], $current_page, $args );
			
			return $output;
		}
		
	}
	
	/*
	 *A self::metaname érték alapján sorbarendezi.
	 *Ha nincs ilyen érték megadva,  többit a végére teszi.
	 **/
	private function reorderPages ( array $pages, int $parent )	{
		$reordered=array();
		$order=0;
		foreach ($pages as $page)
		{
			if ( $page->post_parent === $parent)
			{
				
            $order=get_post_meta ($page->ID, $this->meta_name, TRUE);
				if (!$order)
					$order=99;
				$order=intval ($order)+1;
				$reordered[$order][]=$page;
			}
			else {
				$reordered[$order][]=$page;
			}
			
		
		}
		ksort ($reordered, SORT_NUMERIC);
		$reorderedFinal=array();
		foreach ($reordered as $order=>$pages )
		{
			foreach ($pages as $page)
			{
				$reorderedFinal[]=$page;
			
			}
		}
		
		return $reorderedFinal;
	}


}
