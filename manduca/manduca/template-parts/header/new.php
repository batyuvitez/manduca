<?php
/**
 * Readability toolbar in the header. 
 * Theme: Manduca
 *
 * @since 17.8
 * */
?>

<?php

printf( '<button id="toolbar-buttons-open" class="toolbar-buttons-open color-3" aria-expanded="false">%1$s%2$s<span class="desktop-text">%3$s</span></button>',
		   manduca_get_svg( array( 'icon' => 'eye' ) ),
		   manduca_get_svg( array( 'icon' => 'close' ) ),
		   __( 'Display options', 'manduca' )
		  );
?>

 
 <div id="toolbar-buttons" class="toolbar-buttons">
					  <h1><?php __( 'Display options', 'manduca' ); ?>'</h1>
					   <span aria-hidden="true" id="buttons-close" class="buttons-close">
											<?php echo manduca_get_svg( array( 'icon' => 'close' ) ); ?>
					   </span>
					   <table role="presentation">
											<tbody>
																  
											</tbody>
					   </table>
					  <ul>
					   <li class="button-container high-contrast-container">
							<span class="toolbar-label"><?php _e( 'Contrast:' , 'manduca' ); ?></span>
							<button class="high-contrast" aria-label="<?php _e( 'Original contrast' , 'manduca' ); ?>" data-contrast-type="high-contrast-0"><span class="phone-text">Abc</span><span class="desktop-text">Eredeti</span></button>
							<button class="high-contrast" aria-label="<?php _e( 'Pastel background' , 'manduca' ); ?>" data-contrast-type="high-contrast-1"><span class="phone-text">Abc</span><span class="desktop-text">Abc</span></button>
							<button class="high-contrast" aria-label="<?php _e( 'Black background with yellow letters' , 'manduca' ); ?>" data-contrast-type="high-contrast-2"><span class="phone-text">Abc</span><span class="desktop-text">Abc</span></button>
							<button class="high-contrast desktop-text" aria-label="<?php _e( 'Yellow background with black letters' , 'manduca' ); ?>" data-contrast-type="high-contrast-3"><span class="phone-text">Abc</span><span class="desktop-text">Abc</span></button>
						</li>
					  
					   <li class="button-container font-type-container">
							<span class="toolbar-label"><?php _e( 'Font type:' , 'manduca' ); ?></span>
							<button class="change-font-type" data-font-type="font-type-0"><span class="phone-text">Abc</span><span class="desktop-text"><?php _e( 'Original' , 'manduca' ); ?></span></button>
							<button class="change-font-type" data-font-type="font-type-1"><span class="phone-text">Abc</span><span class="desktop-text"><?php _e( 'Fixed with' , 'manduca' ); ?></span></button>
							<button class="change-font-type"  data-font-type="font-type-2"><span class="phone-text">Abc</span><span class="desktop-text"><?php _e( 'Serif' , 'manduca' ); ?></span></button>
						</li>
					  
						<li class="button-container font-size-container">
					   <span class="toolbar-label"><?php _e( 'Font size:' , 'manduca' ); ?></span>
							<button class="change-font-size"  data-zoom="font-size-0"><span class="phone-text">Abc</span><span class="desktop-text"><?php _e( 'Original' , 'manduca' ); ?></span></button>
							<button class="change-font-size" data-zoom="font-size-1"><span class="phone-text">Abc</span><span class="desktop-text"><?php _e( 'Bigger' , 'manduca' ); ?></span></button>
							<button class="change-font-size" data-zoom="font-size-2"><span class="phone-text">Abc</span><span class="desktop-text"><?php _e( 'Biggest' , 'manduca' ); ?></span></button>
						</li>
						
						<?php
						/* Add information button, if there is a link to it.
						*
						* Return @array: 'url' :		the url of the info page
						* 				 'title' : 		the tooltip, screen-reader text of the link
						* 				 'anchor text': the anchor text of the link
						*/
						
						$info_button_data = apply_filters ( 'manduca_toolbar_info_button' , false );
						
						if( $info_button_data !== false ) :
						?>
						
						<li class="button-container info-container">
					  <?php
					  printf( '<div class="more-link">	<a href="%1$s" class="info-button" title="%2$s">%3$s<span class="desktop-text">%4$s</span></a></div>' ,
											esc_html( $info_button_data[ 'url' ] ), 
											esc_html( $info_button_data[ 'title' ] ),
											manduca_get_svg( array( 'icon' => 'info' ) ),
											esc_html( $info_button_data[ 'anchor-text' ] )
											);
					  ?>
					  
						</li>
					  
					  <?php endif; ?>	
						
					  </ul>
</div>


