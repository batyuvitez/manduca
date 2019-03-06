<?php
/**
 * Readability toolbar in the header. 
 *
 * @since 17.8
 * */

 /*  This file is part of WordPress theme named Manduca - focus on accessibility.
 *
	Copyright (C) 2015-2019  Zsolt Edelényi (ezs@web25.hu)

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

printf( '<button id="toolbar-buttons-open" aria-label="%3$s" class="toolbar-buttons-open color-3" aria-expanded="false">%1$s%2$s<span class="desktop-text">%3$s</span></button>',
		   manduca_get_svg( array( 'icon' => 'eye' ) ),
		   manduca_get_svg( array( 'icon' => 'close' ) ),
		   __( 'Display options', 'manduca' )
		  );
?>


 
 <div id="toolbar-buttons" class="toolbar-buttons">
	<h1 aria-hidden="true"><?php _e( 'Display options', 'manduca' ); ?></h1>
	<p><?php _e( 'When using non-default reading options you accept that cookies will be saved in your browser.', 'manduca' ) ; ?> </p>
	 <table role="presentation">
		  <tbody>
				
					<tr>
						 <td><span class="toolbar-label"><?php _e( 'Color scheme:' , 'manduca' ); ?></span></td>
						 <td><button class="high-contrast" id="high-contrast-0" data-contrast-type="high-contrast-0"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Original' , 'manduca' ); ?></span></button></td>
								  <td><button class="high-contrast" id="high-contrast-1" data-contrast-type="high-contrast-1"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'For night' , 'manduca' ); ?></span></button></td>
						 <td><button class="high-contrast" id="high-contrast-2" aria-label="<?php _e( 'Dark background, light letters' , 'manduca' ); ?>" data-contrast-type="high-contrast-2"><span class="phone-text" aria-hidden="true" >Abc</span><span class="desktop-text">Abc</span></button></td>
						 <td><button class="high-contrast" id="high-contrast-3" aria-label="<?php _e( 'Light background, black letters' , 'manduca' ); ?>" data-contrast-type="high-contrast-3"><span class="phone-text" aria-hidden="true" >Abc</span><span class="desktop-text">Abc</span></button></td>
					 </tr>
				   
					<tr>
						 <td><span class="toolbar-label"><?php _e( 'Font type:' , 'manduca' ); ?></span></td>
						 <td><button class="change-font-type" id="font-type-0" aria-label="<?php _e( 'Sans serif' , 'manduca' ); ?>" data-font-type="font-type-0"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Sans serif' , 'manduca' ); ?></span></button></td>
						 <td><button class="change-font-type" id="font-type-1" aria-label="<?php _e( 'Serif' , 'manduca' ); ?>" data-font-type="font-type-1"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Serif' , 'manduca' ); ?></span></button></td>
						 <td><button class="change-font-type"  id="font-type-2" aria-label="<?php _e( 'Monotype' , 'manduca' ); ?>" data-font-type="font-type-2"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Monotype' , 'manduca' ); ?></span></button></td>
					 </tr>
				   
					 <tr>
						 <td><span class="toolbar-label"><?php _e( 'Font size:' , 'manduca' ); ?></span></td>
						 <td><button class="change-font-size"  id ="font-size-0" aria-label="<?php _e( 'Small' , 'manduca' ); ?>" data-zoom="font-size-0"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Small', 'manduca' ); ?></span></button></td>
						 <td><button class="change-font-size" id ="font-size-1" aria-label="<?php _e( 'Normal' , 'manduca' ); ?>" data-zoom="font-size-1"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Normal', 'manduca' ); ?></span></button></td>
						 <td><button class="change-font-size" id ="font-size-2" aria-label="<?php _e( 'Large' , 'manduca' ); ?>" data-zoom="font-size-2"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Large', 'manduca' ); ?></span></button></td>
						 <td><button class="change-font-size" id ="font-size-3" aria-label="<?php _e( 'Extra large' , 'manduca' ); ?>" data-zoom="font-size-3"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Extra Large', 'manduca' ); ?></span></button></td>
					 </tr>
		   </tbody>
	 </table>		
	  
	  <label for="target-selector"><?php _e( 'Choose link target', 'manduca' ); ?></label>
	  <select name="target-selector" id="target-selector">
		<option value="default"><?php _e( 'Leave as it is', 'manduca' );?></option>
		<option value="self"><?php _e( "Don't open link in new window", 'manduca' ); ?></option>
		<option value="blank"><?php _e( "Open links in new window", 'manduca' ); ?></option>
	  </select>
	  
	  <?php echo Manduca_Template_Functions::get_info_button_html(); ?>
	  
		<span role="button" id="buttons-close" class="buttons-close" aria-label="<?php _e( 'Close' ) ; ?>">
				<?php echo manduca_get_svg( array( 'icon' => 'close' ) ); ?>
	   </span>
		
</div>


