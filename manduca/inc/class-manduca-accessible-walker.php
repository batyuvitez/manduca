<?php
/**
 * Add html markup to main navigation with walker
 *
 * @ Theme: Manduca - focus on accessibility
 * @ since 17.7
 *
 **/

class Manduca_accessible_walker extends Walker_Nav_Menu  {

   
	 public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n" .$indent ."<div class='sub-nav lighter-scheme'><ul>\n";
    }
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
		
		/*Translators: screen reader text saying that there is no more item in the submenu */
		$screen_reader_text = '<span class="screen-reader-text">' .__( 'End of submenu' , 'manduca' ) .'</span>';
        $output .= "$indent</ul>$screen_reader_text</div>\n";
    }

}


 



 
 




 
