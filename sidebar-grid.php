<?php

if ( ! is_active_sidebar( 'sidebar-grid' ) ) {
	return;
}
?>

<aside id="grid-sidebar" class="widget-area grid-sidebar">
	<?php dynamic_sidebar( 'sidebar-grid' ); ?>
</aside>
