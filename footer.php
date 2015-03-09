<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package soblossom
 */
?>

					<footer id="colophon" class="site-footer" role="contentinfo">

						<div class="credits">
							<?php
								printf( __( 'Le attività del Teatro delle Biglie sono realizzate col contributo dei %1$s e del %2$s', 'marblestheme' ),
									'<a href="'. admin_url() .'" title="login" class="ghost-link">volontari</a>',
									'<a href="http://www.polimi.it">Politecnico di Milano</a>' );
							?>
						</div> <!-- end .credits -->

					</footer><!-- end #colophon -->

				</div> <!-- end #page .hfeed.site line 59 header.php -->

		</div> <!-- end .inner-wrap line 57 header.php -->
	
	</div> <!-- end .off-canvas-wrap line 55 header.php -->
							
	<?php // all js scripts are loaded in inc/soblossom.php
		wp_footer();
	?>

</body>

</html>