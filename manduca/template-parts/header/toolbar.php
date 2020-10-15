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

printf( '<button id="toolbar-buttons-open" aria-label="%3$s" class="toolbar-buttons-open link-button" aria-expanded="false">%1$s%2$s<span class="desktop-text">%3$s</span></button>',
		   manduca_get_svg( array( 'icon' => 'eye' ) ),
		   manduca_get_svg( array( 'icon' => 'close' ) ),
		   //Translators: Name of options button (text size, color etc) at the header.
					__( 'Display options', 'manduca' )
		  );
?>
 <div id="toolbar-buttons" class="toolbar-buttons featured-scheme">
	<h1 aria-hidden="true"><?php _e( 'Display options', 'manduca' ); ?></h1>
	<p><?php
			//Translators: cookie consent only if user change the default option with Display Options. 
			_e( 'When using non-default reading options you accept that cookies will be saved in your browser.', 'manduca' ) ; ?></p>
	
	 <table role="presentation" class= "featured-scheme">
		  <tbody>
				
					<tr>
						 <td class="toolbar-label"><span><?php _e( 'Color scheme' , 'manduca' ); ?>:</span></td>
						 <td><button class="high-contrast" id="high-contrast-0" data-contrast-type="high-contrast-0"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Original' , 'manduca' ); ?></span></button></td>
						<td><button class="high-contrast" id="high-contrast-1" data-contrast-type="high-contrast-1"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Pastel' , 'manduca' ); ?></span></button></td>
						 <td><button class="high-contrast" id="high-contrast-2" aria-label="<?php _e( 'Dark background, light letters' , 'manduca' ); ?>" data-contrast-type="high-contrast-2"><span class="phone-text" aria-hidden="true" >Abc</span><span class="desktop-text"><?php _e( 'Inverse' , 'manduca' ); ?></span></button></td>
					 </tr>
				   
					<tr>
						 <td class="toolbar-label"><span><?php _e( 'Font type' , 'manduca' ); ?>:</span></td>
						 <td><button class="change-font-type" id="font-type-0" aria-label="<?php _e( 'Sans serif' , 'manduca' ); ?>" data-font-type="font-type-0"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Sans serif' , 'manduca' ); ?></span></button></td>
						 <td><button class="change-font-type" id="font-type-1" aria-label="<?php _e( 'Serif' , 'manduca' ); ?>" data-font-type="font-type-1"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Serif' , 'manduca' ); ?></span></button></td>
						 <td><button class="change-font-type"  id="font-type-2" aria-label="<?php _e( 'Monotype' , 'manduca' ); ?>" data-font-type="font-type-2"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Monotype' , 'manduca' ); ?></span></button></td>
					 </tr>
				   
					 <tr>
						 <td class="toolbar-label"><span><?php _e( 'Font size' , 'manduca' ); ?>:</span></td>
						 <td><button class="change-font-size"  id ="font-size-0" aria-label="<?php _e( 'Small' , 'manduca' ); ?>" data-zoom="font-size-0"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Small', 'manduca' ); ?></span></button></td>
						 <td><button class="change-font-size" id ="font-size-1" aria-label="<?php _e( 'Normal' , 'manduca' ); ?>" data-zoom="font-size-1"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Normal', 'manduca' ); ?></span></button></td>
						 <td><button class="change-font-size" id ="font-size-2" aria-label="<?php _e( 'Large' , 'manduca' ); ?>" data-zoom="font-size-2"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text"><?php _e( 'Large', 'manduca' ); ?></span></button></td>
					 </tr>
						
						<tr>
						 <td class="toolbar-label"><span><?php _e( 'Hypenation' , 'manduca' ); ?>:</span></td>
						 <td><button class="change-hyphen"  id ="hyphen-0" aria-label="<?php _e( 'none' , 'manduca' ); ?>" data-hyphen="hyphen-0"><span class="phone-text" aria-hidden="true">Ab-ce</span><span class="desktop-text"><?php _e( 'none', 'manduca' ); ?></span></button></td>
						 <td><button class="change-hyphen"  id ="hyphen-1" aria-label="<?php _e( 'all' , 'manduca' ); ?>" data-hyphen="hyphen-1"><span class="phone-text" aria-hidden="true">Abce</span><span class="desktop-text"><?php _e( 'all', 'manduca' ); ?></span></button></td>
					 </tr>
						
						
						<tr>
						 <td class="toolbar-label"><span><?php _e( 'Choose link target', 'manduca' ); ?></span></td>
						 <td>
							<button class="target-selector" id ="target-default" aria-label="<?php _e( 'Leave as it is', 'manduca' );?>" data-target="default">
								<span class="phone-text" aria-hidden="true"><?php echo manduca_get_svg (array ('icon'=>'minus'));?></span>
								<span class="desktop-text"><?php _e( 'Leave as it is', 'manduca' ); ?></span>
							</button>
						 </td>
						 <td>
							<button class="target-selector" id ="target-self" aria-label="<?php _e( "Don't open link in new window", 'manduca' ); ?>" data-target="self">
								<span class="phone-text" aria-hidden="true"><?php echo manduca_get_svg( array ( 'icon'=>'target' ) ) ;?></span>
								<?php // translators: Button text in reading options: links are always never open in window ?>
								<span class="desktop-text"><?php _e( "Same window", 'manduca' ); ?></span>
							</button>
						 </td>
						 <td>
							<button class="target-selector" id ="target-blank" aria-label="<?php _e( "Open links in new window", 'manduca' ); ?>" data-target="blank">
								<span class="phone-text" aria-hidden="true"><?php echo manduca_get_svg( array ( 'icon'=>'extlink' ) ) ;?></span>
								<?php // translators: Button text in reading options: links are always open in new window ?>
								<span class="desktop-text"><?php _e( "New window", 'manduca' ); ?></span>
							</button>
						 </td>
						 			 
					 </tr>
		   </tbody>
	 </table>		
	  
	 
		 <?php echo Manduca_Template_Functions::get_info_button_html( 'inverse3' ); ?>
	  
		<span role="button" id="buttons-close" class="buttons-close featured-scheme" aria-label="<?php _e( 'Close' ) ; ?>">
				<?php echo manduca_get_svg( array( 'icon' => 'close' ) ); ?>
	   </span>
		
</div>


