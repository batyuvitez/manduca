<?php
/**
 * Generate the reading options table
 *
 * @since 20.11
 *
 * 
**/

/*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	
	Copyright (C) 2015-2021  Zsolt Edelényi (ezs@web25.hu)

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

namespace Manduca\helpers; 

class Reading_Options {
	
	
	public static function display_table( $args )
	{
		$html='';
		foreach ($args as $block)
		{
			$html.='<div class="row">'."\n";
			$html.='<div class="toolbar-label">';
			$html.='<span>'.$block['label'].':</span>';
			$html.='</div>'."\n";
			$html.='<div class="buttons-wrapper">'."\n";
			for ($counter=0; $counter <count ($block['elements']); $counter++)
			{
				$element=$block['elements'][$counter];
				$html.='<div class="button">';
				
				$html.='<button class="'.$block['name'].'" ';
				$html.='id="'.$block['name'].'-'.strval ($counter).'" ';
				if (isset ($element['aria_label']))
					$html.='aria-label="'.$element['aria_label'].'" ';
				$html.='>'."\n";
				$html.='<span class="explain">';
				//translators: Opt reading option
				$html .= __( 'Change to', 'manduca' );
				$html .='&nbsp;</span>';
				$html .=$element['desktop_text'];
				$html .= '</button></div>'."\n";
			}
			$html .= '</div>'."\n"; //end tag of .button-wrapper
			$html .= '<div class="vonalzo"></div>'."\n"; //need because floated element
			$html .= '</div>'."\n";  //end tag of .row
		}
		echo $html;
	}
	
		
}
