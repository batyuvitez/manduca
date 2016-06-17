<?php
/**
 * Manduca
 *
 * @since 1.0 */

?>

	<?php if ( is_active_sidebar( 'main_sidebar' ) ) : ?>
		<aside id="secondary" class="widget-area" >
			<?php dynamic_sidebar( 'main_sidebar' ); ?>
		</aside><!-- #secondary -->
	<?php endif; ?>