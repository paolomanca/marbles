<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
// require_once( 'library/custom-post-type.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

	// let's get language support going, if you need it
	load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

	// launching operation cleanup
	add_action( 'init', 'bones_head_cleanup' );
	// A better title
	add_filter( 'wp_title', 'rw_title', 10, 3 );
	// remove WP version from RSS
	add_filter( 'the_generator', 'bones_rss_version' );
	// remove pesky injected css for recent comments widget
	add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
	// clean up comment styles in the head
	add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
	// clean up gallery output in wp
	add_filter( 'gallery_style', 'bones_gallery_style' );

	// enqueue base scripts and styles
	add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
	// ie conditional wrapper

	// launching this stuff after theme setup
	bones_theme_support();

	// adding sidebars to Wordpress (these are created in functions.php)
	add_action( 'widgets_init', 'bones_register_sidebars' );

	// cleaning up random code around images
	add_filter( 'the_content', 'bones_filter_ptags_on_images' );
	// cleaning up excerpt
	add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );
add_image_size( 'marbles-thumb', 350, 350, true );

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
	return array_merge( $sizes, array(
		'bones-thumb-600' => __('600px by 150px'),
		'bones-thumb-300' => __('300px by 100px'),
	));
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
	'id' => 'sidebar2',
	'name' => __( 'Sidebar 2', 'bonestheme' ),
	'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h4 class="widgettitle">',
	'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment; ?>
	<div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
		<article  class="cf">
			<header class="comment-author vcard">
				<?php
				/*
				this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
				echo get_avatar($comment,$size='32',$default='<path_to_url>' );
				*/
				?>
				<?php // custom gravatar call ?>
				<?php
				// create variable
				$bgauthemail = get_comment_author_email();
				?>
				<img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
				<?php // end custom gravatar call ?>
				<?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
				<time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
				</div>
			<?php endif; ?>
			<section class="comment_content cf">
				<?php comment_text() ?>
			</section>
			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</article>
<?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function bones_fonts() {
	// wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
	// wp_enqueue_style( 'googleFonts');
  
	wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,200italic,300italic,400italic,600italic');
	wp_enqueue_style( 'googleFonts');
}
add_action('wp_print_styles', 'bones_fonts');


/*************** REGISTERING MENUS ***************/

register_nav_menu('social-links', 'Social Links');


/************** SHORTCODES **************/


function biglie_f( $atts, $content = null ) {
	
	global $thumb_size;
	
	$m_style = null;
	
	$default = array(
		'size'	=>	'medium',
	);

	$atts = array_merge($default, $atts);
	
	if ( !empty($atts['style']) ) {
		$m_style = ' style="'. $atts['style'] .'"';
	}
	
	$output = '<nav class="marbles '. $atts['size'] .'-size"'. $m_style .'>';
		
	if ( !empty($content) )	:
		
		$output .= do_shortcode( wp_kses($content, null) );
		
	else:
		
		if ( empty($atts['children_of']) ) {
			return 'No marbles to show';
		}
		
		$parent = get_page_by_path($atts['children_of']);
		
		if ( empty($parent) ) {
			return 'Not a page';
		}
		
		$children = get_pages(array(
			'child_of' => $parent->ID,
			'parent' => $parent->ID,
			'post_status' => 'publish',
		));
		
		
		
		foreach ( $children as $child ) :
			$thumb_img = wp_get_attachment_image_src( get_post_thumbnail_id($child->ID), $thumb_size);
			
			$output .= print_marble(array(
				'link' 	=>	get_page_link($child->ID),
				'image'	=>	$thumb_img[0],
				'title'	=>	$child->post_title,
			));
			
		endforeach;
		
	endif;
	
		
	$output .= '</nav><!-- .marbles -->';
	
	return $output;
	
}
add_shortcode( 'biglie', 'biglie_f' );


function print_marble( $marble ) {
	
	$output = '<div class="marble">';
	
	$output .= '<a href="'. $marble['link'] .'">';
	
	$output .= '<div class="marble-image" role="presentation">';
	
	$output .= '<img src="'. $marble['image'] .'" title="'. $marble['title'] .'" />';
	
	$output .= '</div><!-- .marble-image -->';
	
	$output .= '<h2 class="marble-title">'. $marble['title'] .'</h2>';
	
	$output .= '</a>';
	
	$output .= '</div><!-- .marble -->';
	
	return $output;
}


function biglia_f( $atts ) {
	
	global $thumb_size;
	
	$marble = array();
	
	
	if ( !empty($atts['page']) ) {
		
		$marble['page'] = get_page_by_path($atts['page']);
								
		if ( empty($marble['page']) ) {
			return 'Not a page';
		}
		
		$marble['link'] = get_page_link($marble['page']->ID);
		
		$thumb_img = wp_get_attachment_image_src( get_post_thumbnail_id($marble['page']->ID), $thumb_size );
		$marble['image'] = $thumb_img[0];// [0] => url
		$marble['title'] = $marble['page']->post_title;
	}
	
	if ( !empty($atts['link']) ) {
		$marble['link'] = $atts['link'];
	}
	
	if ( !empty($atts['title']) ) {
		$marble['title'] = $atts['title'];
	}
	
	if ( !empty($atts['image']) ) {
		$marble['image'] = $atts['image'];
	}
	
	
	return print_marble($marble);
	
}
add_shortcode( 'biglia', 'biglia_f' );


function tdb_events_f( $atts ) {
		
	if ( !empty($atts['event_category']) ) {
		$atts['event-category'] = $atts['event_category'];
		unset($atts['event_category']);
	}
	
	if ( !empty($atts['event_venue']) ) {
		$atts['event-venue'] = $atts['event-venue'];
		unset($atts['event_venue']);
	}

	$events = eo_get_events($atts);
	
	$output = '<ul class="tdb-events">';
	
	foreach ( $events as $event ) {
				
		$output .= '<li>';
		$output .= '<div class="event-date" style="background-color: '. eo_get_event_color($event->ID) .'">';
		$output .= '<div class="event-day">'. eo_get_the_start('j', $event->ID, null, $event->occurrence_id) .'</div>';
		$output .= '<div class="event-month">'. eo_get_the_start('M', $event->ID, null, $event->occurrence_id) .'</div>';
		$output .= '</div>';
		$output .= '<div class="event-description">';
		$output .= '<a href="'. get_the_permalink($event->ID) .'">'. get_the_title($event->ID) .'</a>';
		
		$output .= '<span>'. eo_get_the_start('G:i', $event->ID, null, $event->occurrence_id) .'-'. eo_get_the_end('G:i', $event->ID, null, $event->occurrence_id) .'</span>';
		
		$venue_name = eo_get_venue_name(eo_get_venue($event->ID));
		
		if ( !empty($venue_name) ) {
			$output .= '<span>'. $venue_name .'</span></div>';
		}
		
		$output .= '</li>';
		
	}
	
	$output .= '</ul>';
	
	return $output;
}
add_shortcode( 'tdb_events', 'tdb_events_f' );

/* DON'T DELETE THIS CLOSING TAG */ ?>
