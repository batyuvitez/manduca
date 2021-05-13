<?php
/**
 * Accessible Searchform in the header. 
 * (Different one in widget)
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

//Translators: Start search button
$label=__( 'Start search', 'manduca' ) ;

?>
<form method="get"
	  id="header-searchform"
	  class="header-searchform"
	  role="search" 
	  action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="search-wrapper" >
		<input type="text"
			   placeholder="<?php _e( 'Search'); ?>"
			   value="<?php echo get_search_query(); ?>"
			   name="s"
			   id="s"/>
		<button type="submit"
				class="search-submit"
				id="search-submit">
		   <?php echo  manduca_get_svg( array( 'icon'=>'search') ) ;?>
		   <span class="screen-reader-text"><?php echo $label?></span>
		</button>
	</div>
</form>