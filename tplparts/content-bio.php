<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package soblossom
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'clearfix' ); ?> itemscope itemtype="http://schema.org/WebPage"
         xmlns="http://www.w3.org/1999/html">

	<?php
		if ( function_exists('get_field') && !get_field('hide_title') ) {
	?>
	<header class="entry-header">
		<h1 class="page-title">
			<?php the_title();
			if ( function_exists('get_field') && get_field('subtitle') ) {
				printf('<small>_%s</small>', get_field('subtitle'));
			} ?>
		</h1>
	</header>
	<?php
		}

		if ( function_exists( 'yoast_breadcrumb' ) ) {
			yoast_breadcrumb( '<div class="breadcrumbs clearfix">', '</div>' );
		}
	?>
	<div class="row">
		<aside class="bio-picture small-12 medium-4 columns">
			<div class="biglia">
				<div class="biglia-image">
					<?php
					if ( has_post_thumbnail()) {
						the_post_thumbnail('marble');
					}
					?>
				</div>
			</div>
		</aside>

		<section class="entry-content small-12 medium-8 columns" itemprop="articleBody">

			<?php
				the_content();

				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'soblossom' ),
					'after'  => '</div>',
				) );
			?>

		</section><!-- .entry-content -->
	</div>
	
	<?php edit_post_link( __( 'Edit', 'soblossom' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>

</article><!-- #post-## -->
