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
		   'showpastevents' => 'true',
		   'order' => 'DESC',
		   'numberposts' => 4		   
         ));

if( $eo_event_loop->have_posts() ): ?>

	<!--container for events-->
	<div <?php if( $id ) echo 'id="'.esc_attr($id).'"';?> class="<?php echo esc_attr($classes);?> grid-parent" > 	
	
		<?php while( $eo_event_loop->have_posts() ): $eo_event_loop->the_post(); ?>
		
			<?php 
			//Generate HTML classes for this event
			$eo_event_classes = eo_get_event_classes(); 
			//For non-all-day events, include time format
			$format = ( eo_is_all_day() ? $date_format : $date_format.' -- '.$time_format );
			?>
	
			<!-- each event-->
			<li class="<?php echo esc_attr(implode(' ',$eo_event_classes)); ?> grid-100" >
				
				<!--this is the calendar icon and title -->
				<div class="cal-title grid-parent grid-offset">
					<?php 
					/* DATE-BASED */
					$today  = new DateTime( 'today', eo_get_blog_timezone() );
					$last = eo_get_schedule_last( DATETIMEOBJ );
					$lastTodayDiff = (int) eo_date_interval( $last, $today, '%a' );						
					if( $last->format( 'Y-m-d' ) < $today->format( 'Y-m-d' ) ){ 
						//Ended - sad day.. :(
						$messageBox = "<span class='overlay ended'>Ended</span>";
					}							
					if( $last->format( 'Y-m-d' ) == $today->format( 'Y-m-d' ) ){ 
						//last occurrence is today!!!
						$messageBox = "<span class='notice lastDay'>Last&nbsp;Day!</span>";
					}
					if( $lastTodayDiff > 0 && $lastTodayDiff < 5 ){
						//Less than 4 days to go, but one or more days (i.e. more than 24 hours to go).
						$messageBox = "<span class='notice endsSoon'>Ends&nbsp;Soon</span>";
					}
					if ( $messageBox  ) {
						echo $messageBox;
					}
					$messageBox = '';	
					?>
					
					<!-- calendar icon -->
					<div class="eo-cal grid-25 tablet-grid-100 mobile-grid-100">
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
					<div class="eo-title grid-75 tablet-grid-100 mobile-grid-100" >
						<h4>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" ><?php the_title(); ?> </a>
						</h4>
					</div>
					<h5>
						<?php echo eo_get_the_start($time_format). ' to ' .eo_get_the_end($time_format); ?>
					</h5>	
				</div>
				
				<!-- this is the event details section -->
				<div class="eo-details grip-parent" >
					<!-- event description -->
					<div class="grid-66 tablet-grid-70 mobile-grid-65">
						<?php echo wp_trim_words( get_the_content(), 30 ); ?>
					</div>
					<!-- event picture -->
					<div class="grid-33 tablet-grid-30 mobile-grid-35">
						<?php //the picture 
						echo get_the_post_thumbnail( $event->ID, 'small-thumbnail' ); 
						?>
					</div>
					
					
					<div class="grid-100">
						<span>
						<!-- Is event recurring or a single event -->
						<?php if ( eo_recurs() ) :?>
							<!-- Event recurs - is there a next occurrence? -->
							<?php $next = eo_get_next_occurrence( eo_get_event_datetime_format() );?>

							<?php if ( $next ) : ?>
								<!-- If the event is occurring again in the future, display the date -->
								<?php printf( '<p>' . __( 'This event is running from %1$s until %2$s. It is next occurring on %3$s', 'eventorganiser' ) . '</p>', eo_get_schedule_start( 'j F Y' ), eo_get_schedule_last( 'j F Y' ), $next );?>

							<?php else : ?>
								<!-- Otherwise the event has finished (no more occurrences) -->
								<?php printf( '<p>' . __( 'This event finished on %s', 'eventorganiser' ) . '</p>', eo_get_schedule_last( 'd F Y', '' ) );?>
							<?php endif; ?>
						<?php endif; ?>
						</span>
						
					</div>
				</div>
			</li>

		<?php endwhile; ?>
	<div class="eo-all-events">
		<a href="events/event">See all events </a>
	</div>
		
	</div>

<?php elseif( ! empty($eo_event_loop_args['no_events']) ): ?>

	<ul id="<?php echo esc_attr($id);?>" class="<?php echo esc_attr($classes);?>" > 
		<li class="eo-no-events" > <?php echo $eo_event_loop_args['no_events']; ?> </li>
	</ul>

<?php endif; ?>


<!-- Make it big 
<div class="last_day grid-parent " >
	<div class="last_day_img tablet-grid-50 mobile-grid-100" >
		<?php 
		// echo get_the_post_thumbnail( $event->ID); 
		?>
	</div>
	<div class="last_day_details tablet-grid-50 mobile-grid-100" >
		<h2>
			<a href="<?php // the_permalink(); ?>" title="<?php // the_title_attribute(); ?>" ><?php //the_title(); ?> </a>
		</h2>
		<div class="notice" >
		Last&nbsp;Day
		</div>
		<span class="blurb">
			<h3>
				<?php
				// echo eo_get_the_start($format)
				?>
			</h3>
			<h4>
				<?php // echo wp_trim_words( get_the_content(), 50 );
				?>
			</h4>
		</span>
	</div>
</div>
-->