<?php

/**
 *
 * The Biglie shortcodes
 *
 * Shortcodes to print link to pages with an image inside a 'biglia' (circle)
 *
 * @since 2.0.0
 * @package marbles
 *
 */

function biglie_f( $atts, $content = null ) {

	$m_style = null;

	$default = array(
		'size'	=>	'medium',
	);

	$atts = array_merge($default, $atts);

	if ( !empty($atts['style']) ) {
		$m_style = ' style="'. $atts['style'] .'"';
	}

	$output = '<ul class="biglie '. $atts['size'] .'-size"'. $m_style .'>';

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
			$thumb_img = wp_get_attachment_image_src( get_post_thumbnail_id($child->ID), 'marbles-thumb');

			$output .= print_marble(array(
				'link' 	=>	get_page_link($child->ID),
				'image'	=>	$thumb_img[0],
				'title'	=>	$child->post_title,
			));

		endforeach;

	endif;


	$output .= '</ul><!-- .marbles -->';

	return $output;

}
add_shortcode( 'biglie', 'biglie_f' );


/**
 * Translates the shortcode [biglia] to its HTML
 * @param $atts
 * @return string
 */
function biglia_f( $atts ) {

	// Check whether the user provided a page to link and take data from
	if ( !empty($atts['page']) ) {

		// retrieve the page using the provided page name
		$atts['page'] = get_page_by_path($atts['page']);

		if ( empty($atts['page']) ) {
			return 'Not a page';
		}

		$atts['link'] = get_page_link($atts['page']->ID);

		// If a link to an image was provided, keep it; otherwise retrieve the page thumbnail
		if ( !isset($atts['image']) || empty($atts['image']) ) {
			$thumb_img = wp_get_attachment_image_src(get_post_thumbnail_id($atts['page']->ID), 'marbles-thumb');
			$atts['image'] = $thumb_img[0];// [0] => url
		}

		// If a title was provided, keep it; otherwise get the page's title
		if ( !isset($atts['title']) || empty($atts['title']) ) {
			$atts['title'] = $atts['page']->post_title;
		}

		// If a title was provided, keep it; otherwise get the page's custom field course_type
		if ( !isset($atts['subtitle']) || empty($atts['subtitle']) ) {
			if (function_exists('get_field') && !empty($atts['page']->course_type)) {
				$atts['subtitle'] = $atts['page']->course_type;
			}
		}

	}

	return print_marble($atts);

}
add_shortcode( 'biglia', 'biglia_f' );


/**
 * @param $marble
 * @return string
 */
function _print_marble( $marble ) {


	$output = '<div class="marble">';

	$output .= '<a href="'. $marble['link'] .'">';

	$output .= '<div class="marble-image" role="presentation">';

	$output .= '<img class="grayscale" src="'. $marble['image'] .'" title="'. $marble['title'] .'" />';

	$output .= '</div><!-- .marble-image -->';

	if (!isset($marble['notitle'])) {
		$output .= '<h2 class="marble-title">' . $marble['title'] . '</h2>';
	}

	if (!isset($marble['nosubtitle'])) {
		$output .= '<h3 class="marble-subtitle">' . $marble['subtitle'] . '</h3>';
	}

	$output .= '</a>';

	$output .= '</div><!-- .marble -->';

	return $output;
}

/**
 * @param $marble
 * @return string
 */
function print_marble( $marble ) {


	$output = '<li class="biglia">';

	$output .= '<a href="'. $marble['link'] .'">';

	$output .= '<div class="biglia-image">';

	$output .= '<img src="'. $marble['image'] .'" title="'. $marble['title'] .'" />';

	$output .= '</div>';

	if (!isset($marble['notitle'])) {
		$output .= '<h2>' . $marble['title'] . '</h2>';
	}

	if (!isset($marble['nosubtitle'])) {
		$output .= '<h3>' . $marble['subtitle'] . '</h3>';
	}

	$output .= '</a>';

	$output .= '</li>';

	return $output;
}