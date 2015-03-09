<?php
/**
 * Template Name: Bio
 *
 *
 * @package marblestheme
 */

get_header(); ?>

	<div id="content" class="contentarea-wrap">
		
		<div id="inner-content" class="row">
	
			<main id="main" class="site-main small-12 medium-centered medium-10 columns" role="main">
		
				<?php while ( have_posts() ) { the_post();

					get_template_part( 'tplparts/content', 'bio' );


				} //endwhile; // end of the loop. ?>
	
			</main><!-- #main.site-main -->

		</div> <!-- end #inner-content -->
	
	</div> <!-- end #content.contentarea-wrap -->

<?php get_footer(); ?>
