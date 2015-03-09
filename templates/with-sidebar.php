<?php
/**
 * (T)emplate Name: With sidebar
 *
 * This is the full width page template, i.e. no sidebar
 *
 * @package soblossom
 */

get_header(); ?>

<div id="content" class="contentarea-wrap">

	<div id="inner-content" class="row">

		<main id="main" class="site-main small-12 medium-8 large-9 columns clearfix" role="main">

			<?php while ( have_posts() ) { the_post();

				get_template_part( 'tplparts/content', 'page' );

			} //endwhile; // end of the loop. ?>

		</main><!-- #main.site-main -->

		<?php get_sidebar(); ?>

	</div> <!-- end #inner-content -->

</div> <!-- end #content.contentarea-wrap -->

<?php get_footer(); ?>
