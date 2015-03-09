<?php
/**
 * The Template for displaying all single posts.
 *
 * @package soblossom
 */

get_header(); ?>

	<div id="content" class="contentarea-wrap">

		<div id="inner-content" class="row">
	
			<main id="main" class="site-main small-12" role="main">

				<?php while ( have_posts() ) { the_post();
		
					get_template_part( 'tplparts/event', 'single' );

				} //endwhile end of the loop. ?>

			</main><!-- #main.site-main -->

		</div> <!-- end #inner-content -->
	
	</div> <!-- end #content.contentarea-wrap -->

<?php get_footer(); ?>
