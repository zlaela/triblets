<?php 
/**
 * 
 * Template Name: Single Lesson Page
 * The template for the Lessons page.
 * 
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package triblets
 */
 ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'lesson' ); 
				
			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->