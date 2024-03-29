<?php
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

namespace Manduca\widgets;

class Ajax_Call_Handler {
	
	public function __construct(){
		add_filter('query_vars',
				   array( $this, 'plugin_query_vars')
				  );
		
		add_action('parse_request',
			   array( $this, 'plugin_parse_request')
			  );
	}
	
	
	public function plugin_query_vars($vars) {
		$vars[] = 'manduca';
		return $vars;
	}
	
	

	public function plugin_parse_request($qstring) {
		if (array_key_exists('manduca', $qstring->query_vars)) {
			$page = $qstring->query_vars['manduca'];
			switch($page) {
				case 'ajax':
					do_action( 'manduca_ajax_call' );
					break;
			}
		}
	}
		
}



