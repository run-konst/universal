<?php get_header('post'); ?>
<?php
	get_template_part( 'template-parts/content', get_post_type() );	
?>
<?php get_footer(); ?>
