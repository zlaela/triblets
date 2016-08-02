<?php
/**
 * Custom template for event list widget for Event Organiser
 * Must be named: widget-event-list.php and live in your theme's directory'
 */
global $eo_event_loop,$eo_event_loop_args;
//Date % Time format for events
$date_format = get_option('date_format');
$time_format = get_option('time_format');

//The list ID / classes
$id = $eo_event_loop_args['id'];
$classes = $eo_event_loop_args['class'];
?>

<?php
$events = eo_get_events(array(
           'event_end_after'=>'now',
           'event_start_before'=>'now',
		   'showpastevents' => 'true'
         ));

if( $eo_event_loop->have_posts() ): ?>

	<!--container for events-->
	<div <?php if( $id ) echo 'id="'.esc_attr($id).'"';?> class="<?php echo esc_attr($classes);?> grid-parent" > 
	
<!-- Make it big -->
<div class="last_day grid-parent " >
	<div class="last_day_img tablet-grid-50 mobile-grid-100" >
		<?php 
		echo get_the_post_thumbnail( $event->ID); 
		?>
	</div>
	<div class="last_day_details tablet-grid-50 mobile-grid-100" >
		<h2>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_title(); ?> </a>
		</h2>
		<div class="notice" >
		Last&nbsp;Day
		</div>
		<span class="blurb">
			<h3>
				<?php
				echo eo_get_the_start($format)
				?>
				Today at 4:30 pm
			</h3>
			<h4>
				<?php echo wp_trim_words( get_the_content(), 50 );
				?>
			Maecenas suscipit, risus et eleifend imperdiet, nisi orci ullamcorper massa, et adipiscing orci velit quis magna. Praesent sit amet ligula id orci venenatis auctor. Phasellus porttitor, metus non tincidunt dapibus, orci pede pretium neque, sit amet adipiscing ipsum lectus et libero. Aenean bibendum. Curabitur mattis quam id urna. Vivamus dui. Donec nonummy lacinia lorem.
			</h4>
		</span>
	</div>
</div>
	
		<?php while( $eo_event_loop->have_posts() ): $eo_event_loop->the_post(); ?>

		
			<?php 
				//Generate HTML classes for this event
				$eo_event_classes = eo_get_event_classes(); 
				//For non-all-day events, include time format
				$format = ( eo_is_all_day() ? $date_format : $date_format.' -- '.$time_format );
				
				/* DATE-BASED */
				$today  = new DateTime( 'today', eo_get_blog_timezone() );
				$last = eo_get_schedule_last( DATETIMEOBJ );
				$lastTodayDiff = (int) eo_date_interval( $last, $today, '%a' );
				
							
				if( $last->format( 'Y-m-d' ) == $today->format( 'Y-m-d' ) ){ 
					//last occurrence is today!!!
					$messageBox = "<span class='notice endsSoon'>Last&nbsp;Day</span>";
				}
				if( $lastTodayDiff > 0 && $lastTodayDiff < 7 ){
					//Less than 4 days to go, but one or more days (i.e. more than 24 hours to go).
					$messageBox = "<span class='notice endsSoon'>Ends&nbsp;Soon</span>";
				}

				if ( $messageBox  ) {
					echo $messageBox;
				}

				$messageBox = '';								
			?>
			

			<?php

			?>
			<!-- each event-->
			<li class="<?php echo esc_attr(implode(' ',$eo_event_classes)); ?> grid-25 tablet-grid-50 mobile-grid-100" >
			
				<!--this is the calendar icon and title -->
				<div class="cal-title grid-parent grid-offset">
				
					<!-- calendar icon -->
					<div class="eo-cal grid-20 tablet-grid-20 mobile-grid-100">
						<div class="eo-date-container">
							<span class="eo-date-month" style="background-color: <?php echo eo_get_event_color(); ?>;">
								<?php eo_the_end( 'M'); ?>
							</span>
							<span class="eo-date-day" style="background: <?php echo eo_color_luminance( eo_get_event_color(), 0.2 ); ?>;">
								<?php eo_the_end( 'j'); ?>
							</span>
						</div>
					</div>
					
					<!-- event title -->
					<div class="eo-title grid-80 tablet-grid-80 mobile-grid-100" >
						<h4>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_title(); ?> </a>
						</h4>
					</div>
				</div>
				
				<!-- this is the event details section -->
				<div class="eo-details grip-parent grid-offset" >
				
					<div class="grid-100">
						<?php //the picture 
						echo get_the_post_thumbnail( $event->ID); 
						?>
					</div>
					<div class="grid-100">
						<span> 
							<h5>
								<?php echo eo_get_the_start($format). ' to ' .eo_get_the_end($time_format); ?>
							</h5>					
							<?php echo wp_trim_words( get_the_content(), 20 ); ?>
						</span>	
					</div>
				</div>
			</li>

		<?php endwhile; ?>

	</div>

<?php elseif( ! empty($eo_event_loop_args['no_events']) ): ?>

	<ul id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr($classes);?>" > 
		<li class="eo-no-events" > <?php echo $eo_event_loop_args['no_events']; ?> </li>
	</ul>

<?php endif; ?>