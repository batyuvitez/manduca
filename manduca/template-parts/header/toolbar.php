<?php
/**
 * Readability toolbar in the header. 
 * Theme: Manduca
 *
 * @since 17.8
 * */
?>

<?php

printf( '<button id="toolbar-buttons-open" aria-label="%3$s" class="toolbar-buttons-open color-3" aria-expanded="false">%1$s%2$s<span class="desktop-text">%3$s</span></button></td>',
		   manduca_get_svg( array( 'icon' => 'eye' ) ),
		   manduca_get_svg( array( 'icon' => 'close' ) ),
		   __( 'Display options', 'manduca' )
		  );
?>


 
 <div id="toolbar-buttons" class="toolbar-buttons">
	  <h1><?php _e( 'Display options', 'manduca' ); ?></h1>

	   <table role="presentation">
			<tbody>
				  
					  <tr>
						   <td><span class="toolbar-label"><?php _e( 'Contrast:' , 'manduca' ); ?></span></td>
						   <td><button class="high-contrast" id="high-contrast-0" aria-label="<?php _e( 'Original contrast' , 'manduca' ); ?>" data-contrast-type="high-contrast-0"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text">Eredeti</span></button></td>
						   <td><button class="high-contrast" id="high-contrast-1" aria-label="<?php _e( 'Pastel background' , 'manduca' ); ?>" data-contrast-type="high-contrast-1"><span class="phone-text" aria-hidden="true">Abc</span><span class="desktop-text">Abc</span></button></td>
						   <td><button class="high-contrast" id="high-contrast-2" aria-label="<?php _e( 'Black background with yellow letters' , 'manduca' ); ?>" data-contrast-type="high-contrast-2"><span class="phone-text" aria-hidden="true" >Abc</span><span class="desktop-text">Abc</span></button></td>
						   <td><button class="high-contrast" id="high-contrast-3" aria-label="<?php _e( 'Yellow background with black letters' , 'manduca' ); ?>" data-contrast-type="high-contrast-3"><span class="phone-text" aria-hidden="true" >Abc</span><span class="desktop-text">Abc</span></button></td>
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
	  
	  <?php echo Manduca_Template_Functions::get_info_button_html(); ?>
	  
	  </ul>
		  <span role="button" id="buttons-close" class="buttons-close" aria-label="<?php _e( 'Close' ) ; ?>">
			<?php echo manduca_get_svg( array( 'icon' => 'close' ) ); ?>
	   </span>
</div>


