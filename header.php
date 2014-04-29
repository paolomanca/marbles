<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // Google Chrome Frame for IE ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

		<?php // icons & favicons (for more: http://www.jonathantneal.com/blog/understand-the-favicon/) ?>
		<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-touch.png">
		<link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
		<!--[if IE]>
			<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico">
		<![endif]-->
		<?php // or, set /favicon.ico for IE10 win ?>
		<meta name="msapplication-TileColor" content="#f01d4f">
		<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>

	</head>

	<body <?php body_class(); ?>>

		<div id="container">

			<header class="header" role="banner">

				<div id="inner-header" class="wrap cf">

					<?php
					
					$logo_img = trim(get_header_image());
					
					if ( !empty( $logo_img ) ) {
							
					?>
					<div id="site-logo">
						<?php printf('<a href="%s" rel="nofollow"><img src="%s" alt="TdB" /></a>', home_url(), $logo_img); ?>
					</div>
					<?php } ?>

					<div id="site-info">
													
						<h1 id="site-name"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php bloginfo( 'name' ); ?></a></h1>
						
						<?php
						
						$site_description = get_bloginfo('description');
						
						if ( !empty( $site_description ) ) {
							printf('<span id="site-description">%s</span>', $site_description);
						} else {
							printf('<span id="site-email"><a href="mailto:%s">%s</a></span>', get_bloginfo( 'admin_email'), get_bloginfo( 'admin_email'));
						}
						
						?>

					</div>
					
					<?php
					wp_nav_menu(	array(	'theme_location' 	=> 'social-links',
											'container_class'	=> 'social-links',
											'link_before'		=> '<span>',
											'link_after'		=> '</span>',
											'items_wrap'		=> '<ul id="%1$s" class="%2$s"><span>Scopri di più su</span>%3$s</ul>',
						) ); ?>

				</div>

			</header>
