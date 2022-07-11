<?php
 /*
 * This functions from the older Manduca version is still here
 * Maybe they are usefull, or should be provide backward compatibility
 */
 
 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

    Source code is available at https://github.com/batyuvitez/manduca
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
 


/*
 * Return the icon or display the icon
 *
 * @param string icon's name
 * @param $display (optional) boolean TRUE to display ( default: TRUE )
 *
 * @return html markup of the icon 
 * */
function manduca_icon( string $icon, bool $display=TRUE ) {
       $arg = array( 'icon'=> $icon);
       $svg = new Manduca\accessibleServices\Svg_Functions( $arg ) ;
       $html = $svg->Return_HTML();
       if ($display) {
            echo $html;
       }
       return $html;
 }

 
