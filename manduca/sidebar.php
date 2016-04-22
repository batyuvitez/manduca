<?php
/**
 * Manduca
 *
 * @since 1.0 */

?>

	<?php if ( is_active_sidebar( 'main_sidebar' ) ) : ?>
		<aside id="secondary" class="widget-area" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
			<?php dynamic_sidebar( 'main_sidebar' ); ?>
		</aside><!-- #secondary -->
	<?php endif; ?>