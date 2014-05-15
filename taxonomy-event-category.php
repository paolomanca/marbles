<?php
/**
*	Template for event categories (Event Organiser support)
*
*  @package Marbles
*	@since 1.0.2
*/
get_header();

?>

<div id="content">

	<div id="inner-content" class="wrap cf">

		<div id="main" class="m-all t-all d-all cf" role="main">

			<?php if (have_posts()) : ?>

				<article id="category-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

					<header class="article-header category-header">

						<h1 class="page-title category-title" itemprop="headline"><?php
							printf( __( 'Event Category Archives: %s', 'eventorganiser' ), '<span>' . single_cat_title( '', false ) . '</span>' );
							?></h1>
									
						</header> <?php // end category header ?>

						<section class="entry-content event-description cf" itemprop="articleBody">
							<!-- Navigate between pages-->
							<!-- In TwentyEleven theme this is done by twentyeleven_content_nav-->
							<?php 
							global $wp_query;
							if ( $wp_query->max_num_pages > 1 ) : ?>
							<nav id="nav-above">
								<div class="nav-next events-nav-newer"><?php next_posts_link( __( 'Later events <span class="meta-nav">&rarr;</span>' , 'eventorganiser' ) ); ?></div>
								<div class="nav-previous events-nav-newer"><?php previous_posts_link( __( ' <span class="meta-nav">&larr;</span> Newer events', 'eventorganiser' ) ); ?></div>
							</nav><!-- #nav-above -->
						<?php endif; ?>

						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>
								
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<header class="entry-header">

									<h1 class="entry-title" style="display: inline;">
										<a href="<?php the_permalink(); ?>">
											<?php 
											//If it has one, display the thumbnail
											if( has_post_thumbnail() )
												the_post_thumbnail('thumbnail', array('style'=>'float:left;margin-right:20px;'));

											//Display the title
											the_title()
												;?>
										</a>
									</h1>
		
									<div class="event-entry-meta">

										<!-- Output the date of the occurrence-->
										<?php
										//Format date/time according to whether its an all day event.
										//Use microdata http://support.google.com/webmasters/bin/answer.py?hl=en&answer=176035
										if( eo_is_all_day() ){
											$format = 'd F Y';
											$microformat = 'Y-m-d';
										}else{
											$format = 'd F Y '.get_option('time_format');
											$microformat = 'c';
										}?>
										<time itemprop="startDate" datetime="<?php eo_the_start($microformat); ?>"><?php eo_the_start($format); ?></time>
			
										<!-- Display event meta list -->
										<?php echo eo_get_event_meta_list(); ?>

										<!-- Show Event text as 'the_excerpt' or 'the_content' -->
										<?php the_excerpt(); ?>
			
									</div><!-- .event-entry-meta -->
		
									<div style="clear:both;"></div>
								</header><!-- .entry-header -->

							</article><!-- #post-<?php the_ID(); ?> -->

						<?php endwhile; ?><!--The Loop ends-->

						<!-- Navigate between pages-->
						<?php 
						if ( $wp_query->max_num_pages > 1 ) : ?>
						<nav id="nav-below">
							<div class="nav-next events-nav-newer"><?php next_posts_link( __( 'Later events <span class="meta-nav">&rarr;</span>' , 'eventorganiser' ) ); ?></div>
							<div class="nav-previous events-nav-newer"><?php previous_posts_link( __( ' <span class="meta-nav">&larr;</span> Newer events', 'eventorganiser' ) ); ?></div>
						</nav><!-- #nav-below -->
						<?php
					endif;
					?>
				</section> <?php // end article section ?>

			</article>

		<?php  else : ?>

			<article id="post-not-found event-not-found" class="hentry cf">
				<header class="article-header">
					<h1><?php _e( 'Oops, Post Not Found!', 'bonestheme' ); ?></h1>
				</header>
				<section class="entry-content">
					<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'bonestheme' ); ?></p>
				</section>
				<footer class="article-footer">
					<p><?php _e( 'This is the error message in the page.php template.', 'bonestheme' ); ?></p>
				</footer>
			</article>

		<?php endif; ?>

	</div>

</div>

</div>

<?php get_footer(); ?>
