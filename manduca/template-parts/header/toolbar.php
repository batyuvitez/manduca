<?php
/**
 * Readability toolbar in the header. 
 *
 * */

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2022  Zsolt Edelényi (ezs@web25.hu)

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

<section id="toolbar-buttons" class="toolbar-buttons featured-scheme dialog" role="dialog" aria-labelledby="dialog-title" aria-describedby="dialog-description" aria-modal="true">
	<h1 class="dialog-title"><?php _e( 'Display options', 'manduca' ); ?></h1>
	<p id="dialog-description"><?php
		//Translators: cookie consent only if user change the default option with Display Options. 
		_e( 'When using non-default reading options you accept that cookies will be saved in your browser.', 'manduca' ) ; ?>
	</p>
	
	<div id="toolbar-buttons-table" class= "featured-scheme toolbar-buttons-table">
		<?php 	get_template_part ('/template-parts/header/toolbarinner');?>
	</div>		
 
	<?php echo Manduca\helpers\Template_Functions::get_info_button_html( 'inverse3' ); ?>
	<button id="buttons-close" class="modal-window-close" title="<?php  _e( 'Close' ); ?>"><?php manduca_icon( 'close' );?></button>
</section>


