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
		array (	'name' => 'high-contrast',
			//translators: Toolbar color scheme selector
			'label'	   =>__( 'Inverse color scheme' , 'manduca' ) ),
		
		array (	'name' => 'font-type',
			//translators: Toolbar color scheme selector
			'label'    => __( 'Dyslexie font type' , 'manduca' ) ),
			
		array (	'name' => 'font-size',
			//translators: Toolbar color scheme selector
			'label'    => __( 'Bigger font size' , 'manduca' ) ),
			
		array (	'name' => 'line-height',
			//translators: Toolbar line height selector
			'label'	   => __( 'Wider line height' , 'manduca' ) ),
			
		array (	'name' => 'letter-spacing',
			//translators: Toolbar letter psacing selector button
			'label'		=> __( 'Wider letter spacing' , 'manduca' ) ),
			
		array (	'name'	=> 'paragraph-spacing',
			//translators: Toolbar paragrpah spacing selector button
			'label'		=> __( 'Wider paragraph spacing' , 'manduca' ) ),
			
		array (	'name'	=> 'word-spacing',
			//translators: Toolbar word spacing selector button
			'label'		=> __( 'Wider word spacing' , 'manduca' ) ),
			
		array (	'name'	=> 'hyphen',
			//translators: Toolbar hyphenation selector label
			'label'		=> __( 'Do Hyphenate' , 'manduca' ) ),
			
		array (	'name'	=>	'animation',
			//translators: Toolbar animation disable/enable label
			'label'		=> __( "Disable animation" , 'manduca' ) ),
			
		array (	'name'	=> 'link-appearance',
			//translators: Toolbar link appearance selector label (bold or underlined)
			'label'		=> __( 'Underline links' , 'manduca' ) ),
			
		array (	'name'	=> 'link-target-same-window',
			//translators: Toolbar link target selector label
			'label'		=> __( 'Links open in same window' , 'manduca' ) ),
			
		array (	'name'	=> 'link-target-new-window',
			//translators: Toolbar link target selector label
			'label'		=> __( 'Links open in new window' , 'manduca' ) ),
		);
	?>
<?php
foreach ($button_args as $block) :
	$unique_id		= 'checkbox-'.$block['name'];
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
				<span class="screen-reader-text"><?php echo $block['label']; ?></span>
			</label>
			
		</div>
	</div>
<?php endforeach; ?>



