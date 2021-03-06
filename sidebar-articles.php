<?php

if ( ! is_active_sidebar( 'sidebar-articles' ) ) {
	return;
}
?>

<aside id="sidebar-articles" class="widget-area">
	<?php dynamic_sidebar( 'sidebar-articles' ); ?>
</aside>
