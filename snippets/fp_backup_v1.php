
<script>
(function ($) {
        $(document).ready(function() {
          $('#slides').slidesjs({	
            height: 500,
            navigation: true,
            pagination: true,
			start: 3,
            effect: {
              fade: {
                speed: 1000
              }
            },
            play: {
                active: true,
                auto: true,
				swap: true,
                interval: 6000,
                pauseOnHover: false,
                effect: "fade"
            }
          });
        });
		}(jQuery));
</script>


<?php
/**
 * The template for the front page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package triblets
 */

get_header(); ?>

<?php
$events = new WP_Query(array(
	'post_type' => 'event', 
	'suppress_filters' => false, 
	'posts_per_page' => 2,
	//'ondate'=>'today',
	//'event_end_before' => 'last day of this month',
	'showpastevents' => false,
	'group_events_by'=> 'series',
	'orderby'=> 'DESC'
));
?>
	$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array( 1200,750 ), false, '' ); ?>
	
<h2 class="hidden">Front Page</h2>
<section id="post-<?php the_ID(); ?>" class="fp-content" >
	<?php while ( have_posts() ) : the_post(); ?>
	
	<article id="featured-slider" class="slides-container grid-parent">
		<div id="slides" class="grid-parent">	
		
		<!-- loop through events, if they exist -->	
		<?php while ( $events->have_posts() ) : $events->the_post(); ?>	
			<div class="slide">			
				<?php $url = get_post_meta($events->ID, "url", true);
				if($url!='') {
					echo '<a href="'.$url.'">';
					echo the_post_thumbnail('full');
					echo '</a>';
				} 
				else {
					echo the_post_thumbnail('full');
				} ?>
				
				<div class="caption">
					<h5><a><?php the_title(); ?></a></h5> 
					<?php the_content();?>
				</div><!-- .caption -->	
				
			</div><!-- .slide -->	
			<?php endwhile;
			wp_reset_query(); ?>
			
			<!--regardless of events, show image from the front page -->
			<div class="slide grid-parent">
				<?php echo the_post_thumbnail('full'); ?>
				<!-- the title -->
				<?php the_title( '<h1 class="fp-title">', '</h1>' ); ?>
			</div>
		<?php endwhile; // End of the loop.	?>
	
			<a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>
			<a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>	  
		</div><!-- #slides -->	
	</article>
	
	<article id="front-page-content" class="grid-parent">
		<div class="fp-content grid-90 suffix-5">
		<?php
			the_content();
		?>
		</div><!-- .fp-content -->
	</article>
	


	<article id="mailing-list" class="get-mail grid-parent">
		<h2>Join Our Mailing List</h2>
		<div class="email">
		
		</div>
		<button class="join-list">
		</button>
	</article>	

	<?php get_sidebar(); ?>

</section>
	
<?php

get_footer();
