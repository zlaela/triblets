<?php
/**
 * The template for the front page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package triblets
 */

get_header(); ?>

<h2 class="screen-reader-text">Front Page</h2>
<article class="slidejs">
	<?php
	//the loop
	while ( have_posts() ) : the_post(); ?>	

	<h3 class="screen-reader-text">Slider Section</h3>
	<?php 
	//get the events
	$events = new WP_Query(array(
		'post_type' => 'event', 
		'suppress_filters' => false, 
		'posts_per_page' => 3,
		//'ondate'=>'today',
		//'event_end_before' => 'last day of this month',
		'showpastevents' => false,
		'group_events_by'=> 'series',
		'orderby'=> 'DESC'
	));?>
	
	<section class="slides_container">
		<?php 
		$counter = 1; 
		$args = array(); 
		while ( $events->have_posts() ) : $events->the_post();	
		$url = get_post_thumbnail_id($post->ID); ?>		
			<!-- caption -->
			<div class="caption" id="slider_content<?=$counter?>">
				<h3>
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3> 
				<?php the_excerpt();?>
			</div><!-- .caption -->	
		<?php 
			$counter++; 
			$args [] = $url;
		endwhile;
		wp_reset_query(); ?>
		
		<!-- the slides -->	
		<div id="slides">			
			<?php
			foreach ($args as $i) { ?>
				<?php 
				$img = wp_get_attachment_url($i);
				$alt = get_post_meta($i, '_wp_attachment_image_alt', true);
		
				if (empty($i)){?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/fallback_feature.jpg"  alt="relevant image coming soon!"/>
				<?php }                                
				else { 
					echo '<img src="'.$img.'" alt="'.$alt.'"/>';
					}
				} ?>	

			<a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>
			<a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>	

		</div><!-- #slides -->	
	</section>
</article>

<article id="front-page-content">

	<section id="post-<?php the_ID(); ?>" style="background-color: blue">
		<h3 class="screen-reader-text">The main Section</h3>
		<div id="intro" class="narrow" style="background-color: yellow">
			<div class="fp-title">
				<h2><span><?php the_title(); ?></span></h2> 
			</div>
			<div class="fp-content">
				<?php the_content(); ?>
					<a href="<?php bloginfo('url'); ?>/about">More about us</a>
			</div>
		</div>
	</section>

	<section class="space-it" style="background-color: red">
		<h3 class="screen-reader-text">Our offerings</h3>
		<div id="offer_logos" class="narrow">
			<div class="feat"> 
				<h3><span></span></h2>
				<a href="<?php bloginfo('url'); ?>/lessons">Lessons Page</a>
			</div>
			<div class="feat"> 
				<a href="<?php bloginfo('url'); ?>/events">Events Page</a>
			</div>
			<div class="feat"> 
				<a href="<?php bloginfo('url'); ?>/stories">Stories Page</a>			
			</div>
			<div class="feat"> 
				<a href="<?php bloginfo('url'); ?>/stories">Stories Page</a>			
			</div>
		</div>
	</section>			
	
	<section class="space-it" style="background-color: orange">
		<h3 class="screen-reader-text">Our partners and testimonials</h3>
		<div id="reps">
			<div class="testimonials">
			<?php ?>
			</div><!-- .testimonials -->
			<div class="partners">
			<?php ?>
			</div><!-- .testimonials -->
		</div>
	</section>	
	
	<section class=" narrow" style="background-color: purple">
		<h3 class="screen-reader-text">Social and today</h3>
		<div id="socialize" class="space-it">
			<div class="fp-content">
			<?php ?>
			</div><!-- .fp-content -->
		</div>
	</section>	
	
</article>
			
<?php endwhile; // End of the loop.	?>

<?php

get_footer(); ?>
		<!--	<div class="fp-content grid-45 tablet-grid-40 tablet-suffix-5">
			<?php
				// get_sidebar();
			?>
			</div>
			-->
