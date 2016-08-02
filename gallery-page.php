<?php
/**
 * 
 * Template Name: Gallery Page
 * The template for the Gallery page.
 * 
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package triblets
 */
get_header(); ?>

<article id="post-<?php the_ID(); ?>" class="gallery">
	<?php while ( have_posts() ) : the_post();
	if (has_post_thumbnail( $post->ID ) ): 
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'side-navigation' ); ?>
	
	<section >
		<div id="info" class="small" style="background:#333333 url('<?php //echo $image[0]; ?>') no-repeat scroll 50% 50%">
			<header class="fp-title">
				<?php the_title( '<h2> <span>', '</span> </h2>' ); ?>
			</header><!-- .entry-header -->

			<div class="gal-content">
				<span class="gal-desc"> 
					<?php the_content(); ?>
				</span>
			</div>
		</div>
	<?php endif; ?>
	
		<div id="gallery" class="gal-wrap">				
			<?php  $gallery = get_post_gallery_images( $post );
			if( $gallery ){
				echo '<ul>';
				foreach($gallery as $url){ ?>
					<li class="tile">
						<a href=" <?php echo $url; ?> ">
							<img src ="<?php echo $url; ?>"> 
						</a>
					</li>
				<?php }
				echo '</ul>';
			}  
			else {
				echo "nope";
			} ?> 
		</div>	
	</section>
	<?php endwhile; // End of the loop.?>
</article><!-- gallery -->

<?php get_footer(); ?>