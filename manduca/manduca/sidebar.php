<?php
/**
 * Display sidebar 
 *
 * @theme: Manduca - focus on accessiblilty
 * @ver 17.10.12
 **/

if ( is_active_sidebar( 'main_sidebar' ) &&  ! is_page_template( 'page-templates/full-width.php' ) ) {
	echo '<aside id="secondary" class="widget-area" >';
	/* translators: heading for screen reader users*/
	printf( '<h1 class="screen-reader-text">%s</h1>' 	,
			__( 'Sidebar area' , 'manduca' )
		  );
	dynamic_sidebar( 'main_sidebar' );
	echo '</aside>';
}