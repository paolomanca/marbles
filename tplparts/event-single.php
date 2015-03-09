<?php
/**
 * The Single Post template
 * 
 * @package soblossom
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
	
	<header class="entry-header">
		<?php
			the_title( '<h1 class="entry-title single-title" itemprop="headline">', '</h1>' );

			if ( function_exists( 'yoast_breadcrumb' ) ) {
				yoast_breadcrumb( '<div class="breadcrumbs clearfix">', '</div>' );
			}

		?>
	</header><!-- .entry-header -->

	<section class="entry-content clearfix" itemprop="articleBody">
		<?php

			the_content();

		?>
	</section><!-- .entry-content -->

	<footer class="event-meta">
		<?php
			get_template_part( 'tplparts/event-single', 'meta' );
		?>
	</footer><!-- .event-meta -->

</article><!-- #post-## -->
