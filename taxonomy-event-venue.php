<?php
/**
 *	Template for event venues (Event Organiser support)
 *
 *  @package Marbles
 *	@since 1.0.2
 */
	get_header();

	$venue_id = get_queried_object_id();
?>

			<div id="content">

				<div id="inner-content" class="wrap cf">

						<div id="main" class="m-all t-all d-all cf" role="main">


							<article id="venue-<?php echo $venue_id ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

								<header class="article-header venue-header">

									<h1 class="page-title venue-title" itemprop="headline"><?php printf( __( 'Events at: %s', 'marbles' ), '<span>' .eo_get_venue_name($venue_id). '</span>' );?></h1>
									
								</header> <?php // end event header ?>

								<section class="entry-content venue-description cf" itemprop="articleBody">
									
									<?php if ( have_posts() ) : ?>
										
									<?php endif; ?>

								</section> <?php // end article section ?>

								<footer class="article-footer event-infos cf">

								</footer>

							</article>

						</div>

				</div>

			</div>

<?php get_footer(); ?>
