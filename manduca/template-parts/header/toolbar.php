<?php
/**
 * Readability toolbar in the header. 
 *
 * @since 17.8
 * */

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

?>

<?php

printf( '<button id="toolbar-buttons-open" aria-label="%3$s" class="toolbar-buttons-open link-button open-dialog" aria-expanded="false">%1$s%2$s<span class="desktop-text">%3$s</span></button>',
		   manduca_get_svg( array( 'icon' => 'eye' ) ),
		   manduca_get_svg( array( 'icon' => 'close' ) ),
		   //Translators: Name of options button (text size, color etc) at the header.
					__( 'Display options', 'manduca' )
		  );
?>
<section id="toolbar-buttons" class="toolbar-buttons featured-scheme dialog" role="dialog" aria-labelledby="dialog-title" aria-describedby="dialog-description">
	<h1 id="dialog-title"><?php _e( 'Display options', 'manduca' ); ?></h1>
	<p id="dialog-description"><?php
		//Translators: cookie consent only if user change the default option with Display Options. 
		_e( 'When using non-default reading options you accept that cookies will be saved in your browser.', 'manduca' ) ; ?>
	</p>
	
	<div id="toolbar-buttons-table" class= "featured-scheme toolbar-buttons-table">
		<?php 	get_template_part ('/template-parts/header/toolbarinner');?>
	</div>		
 
	<?php echo Manduca_Template_Functions::get_info_button_html( 'inverse3' ); ?>
	<button id="buttons-close" class="buttons-close close-dialog"><?php echo manduca_get_svg( array( 'icon' => 'close' ) ).'&nbsp;'; _e( 'Close' ); ?></button>
</section>


