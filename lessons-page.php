<?php
/**
 * 
 * Template Name: Lessons Page
 * The template for the Lessons page.
 * 
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package triblets
 */
get_header(); 
?>
<?php
while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'template-parts/content', 'page' ); ?>				
<section class="narrow">
	<div class ="work-belt">
		<div class="thumb-wrap">				
			<div class="thumb-container">
				<?php
				$lessons = page_children( $post->ID );
				foreach( $lessons as $lesson ) {
					setup_postdata($lesson);
					$url = wp_get_attachment_image_src( get_post_thumbnail_id( $lesson->ID ),array( 240,480 ), true, '' );	
					$source = get_the_permalink( $lesson-> ID );
					$title = $lesson->post_title;
				?>
				<div class="thumb-unit" 
				style="background-image:url(<?php print $url[0]; ?> );"	>						
					<div class="overlay">
						<?php 
						if ( isset( $title ) ){ ?>
								<strong><?php echo $title; ?></strong><?php
							}
						else { ?>
								<strong>+</strong><?php
							}  ?>
					</div><!--/overlay-->
					<div id="content" class="screen-reader-text" >
						<?php echo $source; ?>
					</div>
				</div><!--/thumb-unit-->
			<?php }	 ?>
			</div><!--/thumb-container-->
		</div> <!--/thumb-wrap-->
		<?php wp_reset_postdata(); ?>		
		<?php 
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
		comments_template();
		endif;
		endwhile; // End of the loop.
		?>		
		<div class="work-wrap">
			<div class = "work-container clearfix">
				<div class="work-return"><!--icon--></div>
				<div class="project-title"><!--Work Title--></div>
				<div class="project-load"> <!--this is where the project loads --></div>
			</div><!--/work-container-->
		</div><!--/work-wrap-->
	</div><!--/work-belt-->
</section> 

<?php
//get_sidebar();
get_footer();
