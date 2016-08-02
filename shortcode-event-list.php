<?php
/**
 * Event List Widget: Standard List
 *
 * Custom template for displaying the [eo_event] shortcode *unless* it is wrapped around a placeholder: e.g. [eo_event] {placeholder} [/eo_event].
 *
 */
global $eo_event_loop,$eo_event_loop_args;

//The list ID / classes
$id = ( $eo_event_loop_args['id'] ? 'id="'.$eo_event_loop_args['id'].'"' : '' );
$classes = $eo_event_loop_args['class'];

?>

<?php if ( $eo_event_loop->have_posts() ) :  ?>

	<ul <?php echo $id; ?> class="<?php echo esc_attr( $classes );?>" > 

		<?php while ( $eo_event_loop->have_posts() ) :  $eo_event_loop->the_post(); ?>

			<?php
				//Generate HTML classes for this event
				$eo_event_classes = eo_get_event_classes();

				//For non-all-day events, include time format
				$format = eo_get_event_datetime_format();
			?>

		 <div class="evlistWrap"> 
			  <div class="eo-date-container">
				   <span><?php eo_the_start('M');?></span> 
				   <span><?php eo_the_start('j');?></span>
				   <span><?php eo_the_start('Y');?></span>
			  </div> 
			  <div class="grid-33 tablet-grid-33">
				  <?php //the picture 
				  echo get_the_post_thumbnail( $event->ID ); 
				  ?>
			  </div>
			  <div class="evList grid-66 tablet-grid-66"> 
				   <h2><a href="<?php echo esc_url( get_permalink() );?>"><?php the_title();?></a></h2> 
				   <span> Last occurrence <?php echo eo_get_schedule_last( 'jS M Y' ); ?> 
				   <?php echo wp_trim_words( get_the_content(), 40 ); ?>
				   </span>
			  </div> 

		 </div>

		<?php endwhile; ?>

	</ul>

<?php elseif ( ! empty( $eo_event_loop_args['no_events'] ) ) :  ?>

	<ul id="<?php echo esc_attr( $id );?>" class="<?php echo esc_attr( $classes );?>" > 
		<li class="eo-no-events" > <?php echo $eo_event_loop_args['no_events']; ?> </li>
	</ul>

<?php endif;
