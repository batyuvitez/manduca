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
<?php
$button_args=
	array(
		array (	'name'											=>'high-contrast',
			//translators: Toolbar color scheme selector
			'label'	=>__( 'Color scheme' , 'manduca' ),
			'elements'=>
				array (
					array( 
							'phone_text'					=>'Abc',
							//translators: Toolbar color scheme selector original colors set
							'desktop_text'			=>__( 'Original' , 'manduca' )),
					
					array( 
							'phone_text'					=>'Abc',
							//translators: Toolbar color scheme set dark background white letters. 
							'desktop_text'			=>__( 'Inverse' , 'manduca' ),
							'aria_label'			=> __( 'Dark background, light letters' , 'manduca' )) ) ),
		
		array (	'name'=>'font-type',
			//translators: Toolbar color scheme selector
			'label'										=>__( 'Font type' , 'manduca' ),
			'elements'=>
				array (
					array( 
							'phone_text'					=>'Abc',
							//translators: Toolbar font type selector
							'desktop_text'			=>__( 'Default' , 'manduca' )),
					
					array( 
							'phone_text'					=>'Abc',
						//translators: Toolbar font type selector
							'desktop_text'			=>__( 'Dyslexie' , 'manduca' ) ) ) ),
			
			
			array (	'name'=>'font-size',
			//translators: Toolbar color scheme selector
			'label'=>__( 'Font size' , 'manduca' ),
			'elements'=>
				array (
					array( 
							'phone_text'					=>'Abc',
							//translators: Toolbar font-size selector default font size
							'desktop_text'			=>__( 'Default' , 'manduca' )),
					
					array( 
							'phone_text'					=>'Abc',
						//translators: Toolbar font-size selector large (200%)font size
							'desktop_text'			=>__( 'Large' , 'manduca' ) ) ) ),
			
			array (	'name'=>'line-height',
			//translators: Toolbar line height selector
			'label'=>__( 'Line height' , 'manduca' ),
			'elements'=>
				array (
					array( 
							'phone_text'			=>__( 'Default' , 'manduca' ) ,
							//translators: Toolbar line height 1.7
							'desktop_text'			=>__( 'Default' , 'manduca' ) ),
					array( 
							'phone_text'			=>__( 'Wide' , 'manduca' ),
						//translators: Toolbar line height 2
							'desktop_text'			=>__( 'Wide' , 'manduca' ) ) ) ),
			
			
			array (	'name'=>'letter-spacing',
			//translators: Toolbar letter psacing selector button
			'label'=>__( 'Letter spacing' , 'manduca' ),
			'elements'=>
				array (
					array( 
							'phone_text'			=>'Abc',
							//translators: Toolbar line height 1.7
							'desktop_text'			=>__( 'Default' , 'manduca' ) ),
					array( 
							'phone_text'					=>'Abc',
						//translators: Toolbar line height 2
							'desktop_text'			=>__( 'Wide' , 'manduca' ) ) ) ),
			
			
			array (	'name'=>'paragraph-spacing',
			//translators: Toolbar paragrpah spacing selector button
			'label'=>__( 'Paragraph spacing' , 'manduca' ),
			'elements'=>
				array (
					array( 
							'phone_text'			=>__( 'Default' , 'manduca' ) ,
							'desktop_text'			=>__( 'Default' , 'manduca' ) ),
					array( 
							'phone_text'			=>__( 'Wide' , 'manduca' ),
							'desktop_text'			=>__( 'Wide' , 'manduca' ) ) ) ),
			
			
			array (	'name'=>'word-spacing',
			//translators: Toolbar word spacing selector button
			'label'=>__( 'Word spacing' , 'manduca' ),
			'elements'=>
				array (
					array( 
							'phone_text'					=>'Ab ce',
							'desktop_text'			=>__( 'Default' , 'manduca' ) ),
					array( 
							'phone_text'					=>'Ab ce',
							'desktop_text'			=>__( 'Wide' , 'manduca' ) ) ) ),
			
			
			
			array (	'name'=>'hyphen',
			//translators: Toolbar hyphenation selector label
			'label'=>__( 'Hyphenation' , 'manduca' ),
			'elements'=>
				array (
					array( 
							'phone_text'			=>'Abce',
							//translators: Toolbar font-size selector default font sizet
							'desktop_text'			=>__( 'None' , 'manduca' )),
					array( 
							'phone_text'			=>'Ab-ce',
							//translators: Toolbar font-size selector larger (150%) font sizet
							'desktop_text'			=>__( 'All' , 'manduca' ) ) ) ),
			
			
			array (	'name'=>'animation',
			//translators: Toolbar animation disable/enable label
			'label'=>__( 'Animation' , 'manduca' ),
			'elements'=>
				array (
					array( 
							//translators: Animation default settings on phone
							'phone_text'			=>__( 'On' , 'manduca' ),
							//translators: Animation default settings on monitor
							'desktop_text'			=>__( 'Enabled' , 'manduca' )),
					array( 
							'phone_text'			=>__( 'Off' , 'manduca' ),
							//translators: Animation stopped
							'desktop_text'			=>__( 'Disabled' , 'manduca' ) ) ) ),
			
			
			
			array (	'name'=>'link-appearance',
			//translators: Toolbar link appearance selector label (bold or underlined)
			'label'=>__( 'Link appearance' , 'manduca' ),
			'elements'=>
				array (
					array( 
							'phone_text'					=>'link',
							//translators: links are bold and has contrast of 3:1 to text color
							'desktop_text'			=>__( 'Bold' , 'manduca' )),
					array( 
							'phone_text'					=>'link',
							//translators: lins are underlined 
							'desktop_text'			=>__( 'Underlined' , 'manduca' ) ) ) ),
			
			
			
			array (	'name'=>'link-target-same-window',
			//translators: Toolbar link target selector label
			'label'=>__( 'Links open in same window' , 'manduca' ),
			'elements'=>
				array (
					array( 
							'phone_text'			=>manduca_icon ( 'minus', false ),
							//translators: Toolbar link target selector: links open where specified
							'desktop_text'			=>__( 'Default' , 'manduca' ),
							//translators: Toolbar link target selector: screenreader text. 
							'aria_label'			=>__( 'Leave as it is', 'manduca' ) ),
					array( 
							'phone_text'			=> manduca_icon( 'target', false ),
							//translators: Toolbar link target selector: Links open in same window
							'desktop_text'			=>__( 'Same window' , 'manduca' ),
							//translators: Toolbar link target selector: Links open in same window
							'aria_label'			=>__( 'Always opens link in same window', 'manduca' ) )
				)
			),
			
			array (	'name'=>'link-target-new-window',
			//translators: Toolbar link target selector label
			'label'=>__( 'Links open in same window' , 'manduca' ),
			'elements'=>
				array (
					array( 
							'phone_text'			=>manduca_icon ( 'minus', false ),
							//translators: Toolbar link target selector: links open where specified
							'desktop_text'			=>__( 'Default' , 'manduca' ),
							//translators: Toolbar link target selector: screenreader text. 
							'aria_label'			=>__( 'Leave as it is', 'manduca' ) ),

					array( 
							'phone_text'			=>manduca_icon( 'extlink', false ),
							//translators: Toolbar link target seleccotr: Open links in new window
							'desktop_text'			=>__( 'New window' , 'manduca' ),
							//translators: Toolbar link target seleccotr: Open links in new window
							'aria_label'			=>__( 'Always opens link in new window', 'manduca' )
					)
				)
			)
		);
	?>
<?php
foreach ($button_args as $block) :
	$unique_id		= 'checkbox-'.$block['name'];
	$desktop_text	= $block['elements'][1]['desktop_text'];
?>
	<div class="row">
		<div class="toolbar-label">
			<span><?php echo $block['label']; ?>:</span>
		</div>
		
		<div class="buttons-wrapper">
			<label for="<?php echo $unique_id; ?>">
				<input type="checkbox" class="toggle-checkbox <?php echo $block['name']; ?>"
					   id="<?php echo $unique_id; ?>" />
				<span class="toggle-track">
					<span class="toggle-indicator">
						<span class="toggle-checkmark">
							<?php manduca_icon ('check'); ?>
						</span>
					</span>
				</span>
				<span class="screen-reader-text"><?php echo $desktop_text; ?></span>
			</label>
			
		</div>
	</div>
<?php endforeach; ?>



