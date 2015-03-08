<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> and <header> sections
 *
 * @package soblossom
 */
?>
<!doctype html>

<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

	<head>

		<meta charset="<?php bloginfo( 'charset' ); ?>">

		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<!-- mobile meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!--[if lt IE 9]>
			<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
		<![endif]-->
		
		<?php wp_head(); ?>

	</head>

<body <?php body_class(); ?>>

<?php
/**
 * Add hook right after the opening body tag to be able to add scripts that 
 * need to be placed there, for example Google Analytics, Facebook, Google+, etc.
 * 
 * See inc/functions/misc.php for details
 *
 * uncomment to start using
 *
 * @since 140730
 */
	
	//soblossom_body_open();

?>

	<div class="off-canvas-wrap" data-offcanvas>

		<div class="inner-wrap">
			
			<div id="page" class="hfeed site">

				<header id="masthead" class="site-header" role="banner">

					<div class="inner-header row collapse">

						<div class="site-branding small-12 medium-8 columns">
								<div class="site-logo">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
									   title="<?php esc_attr( bloginfo( 'name' ) ); ?>, <?php esc_attr( bloginfo( 'description' ) ); ?>"
									   rel="home">
										<img src="<?php echo get_template_directory_uri(); ?>/images/logo.svg"
										     alt="<?php esc_attr( bloginfo( 'name' ) ); ?> logo"/>
									</a>
								</div>

								<div class="site-info">
									<h1 class="site-title">
										<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
										   rel="home"><?php esc_attr( bloginfo( 'name' ) ); ?></a>
									</h1>

									<h2 class="site-description"><?php esc_attr( bloginfo( 'description' ) ); ?>
										info@teatrodellebiglie.org</h2>
								</div>
						</div>
						<!-- end .site-branding -->

						<div class="social-media small-12 medium-4 columns">
							<?php soblossom_social_media_links(); ?>
						</div> <!-- end .social-media -->

					</div> <!-- end .inner-header -->

				</header> <!-- end header -->