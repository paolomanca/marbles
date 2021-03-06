<div class="entry-meta eventorganiser-event-meta">
	<!-- Choose a different date format depending on whether we want to include time -->
	<?php if ( eo_is_all_day() ) {
		$date_format = 'j F Y';
	} else {
		$date_format = 'j F Y ' . get_option( 'time_format' );
	} ?>
	<hr>

	<!-- Event details -->
	<h4><?php _e( 'Event Details', 'eventorganiser' ); ?></h4>

	<div class="eo-event-details">
		<?php if ( eo_reoccurs() ): ?>
			<?php $next = eo_get_next_occurrence( $date_format ); ?>

			<?php if ( $next ): ?>
				<?php printf( '<p>' . __( 'This event is running from %1$s until %2$s. It is next occurring on %3$s',
						'eventorganiser' ) . '.</p>', eo_get_schedule_start( 'j F Y' ), eo_get_schedule_last( 'j F Y' ),
					$next ); ?>

			<?php else: ?>
				<!-- Otherwise the event has finished (no more occurrences) -->
				<?php printf( '<p>' . __( 'This event finished on %s', 'eventorganiser' ) . '.</p>',
					eo_get_schedule_last( 'd F Y', '' ) ); ?>
			<?php endif; ?>
		<?php endif; ?>

		<ul class="eo-event-meta">

			<?php if ( ! eo_reoccurs() ) { ?>
				<!-- Single event -->
				<li><strong><?php _e( 'Start', 'eventorganiser' ); ?>:</strong> <?php eo_the_start( $date_format ); ?>
				</li>
				<li><strong><?php _e( 'End', 'eventorganiser' ); ?>:</strong> <?php eo_the_end( $date_format ); ?>
				</li>
			<?php
			} ?>

			<?php if ( eo_get_venue() ) { ?>
				<li><strong><?php _e( 'Venue', 'eventorganiser' ); ?>:</strong>
					<?php eo_venue_name(); ?></li>
			<?php } ?>


			<?php if ( eo_reoccurs() ) {
				//Event reoccurs - display dates. 
				$upcoming = new WP_Query( array(
					'post_type'         => 'event',
					'event_start_after' => 'today',
					'posts_per_page'    => - 1,
					'event_series'      => get_the_ID(),
					'group_events_by'   => 'occurrence'//Don't group by series
				) );

				if ( $upcoming->have_posts() ): ?>

					<li><strong><?php _e( 'Upcoming Dates', 'eventorganiser' ); ?>:</strong>
						<ul id="eo-upcoming-dates">
							<?php while ( $upcoming->have_posts() ): $upcoming->the_post(); ?>
								<li> <?php eo_the_start( $date_format ) ?></li>
							<?php endwhile; ?>
						</ul>
					</li>

					<?php
					wp_reset_postdata();
					//With the ID 'eo-upcoming-dates', JS will hide all but the next 5 dates, with options to show more.
					wp_enqueue_script( 'eo_front' );
					?>
				<?php endif; ?>
			<?php } ?>

		</ul>
	</div>

	<?php if ( eo_get_venue() ): ?>
		<div class="eo-event-venue-map clearfix">
			<?php echo eo_get_venue_map( eo_get_venue(), array( 'width' => '100%' ) ); ?>
		</div>
	<?php endif; ?>

	<hr class="clearfix">

</div><!-- .entry-meta -->