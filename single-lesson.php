<?php get_header(''); ?>

<main class="single-main">
    <?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'lesson' );			

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
    ?>
</main>

<?php get_footer(); ?>