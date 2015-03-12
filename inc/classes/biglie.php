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
 * @param $in_atts array Attributes passed by the user
 *              ['size'] string (optional) The size of the circle (Options: small|medium|large|larger; Default: medium)
 *              ['style'] string (optional) Eventual inline styling
 * @param null $content
 *
 * @return string
 */

function biglie_f( $atts, $content = null ) {

	// Default values if user doesn't provide any
	$default = array(
		'size'  => 'medium',
		'style' => null,
	);

	$atts = shortcode_atts( $default, $atts, 'biglie' );


	// Let's sanitize and clean up the input that will be used
	if ( preg_match( "/\A(small|medium|large|larger)\z/", $atts['size'] ) === 0 ) {
		unset( $atts['size'] );
	}

	$atts['style'] = esc_html( $atts['style'] );


	// Starting to construct the output
	$output = '<ul class="biglie ' . $atts['size'] . '-size"';

	if ( ! empty( $atts['style'] ) ) {
		$output .= ' style="' . $atts['style'] . '"';
	}

	$output .= '>';


	// Since we also want to provide support for empty [biglie], we check if its content is empty
	if ( empty( $content ) ) {
		// If it is, we output a biglia for each children of the page

		if ( empty( $atts['children_of'] ) ) {
			$parent = get_post();
		} else {
			$parent = get_page_by_path( $atts['children_of'] );

			if ( empty( $parent ) ) {
				return __( 'Not a page', 'marblestheme' );
			}
		}

		$children = get_pages( array(
			'child_of'    => $parent->ID,
			'parent'      => $parent->ID,
			'post_status' => 'publish',
		) );

		if ( empty( $children ) ) {
			return __( 'No children to show', 'marblestheme' );
		}

		foreach ( $children as $child ) {
			$output .= print_marble( array(
				'post-ID' => $child->ID,
				'link'    => get_page_link( $child->ID ),
				'title'   => $child->post_title,
			) );

		}

	} else {
		$output .= do_shortcode( $content, null );
	}

	$output .= '</ul>';

	return $output;

}

add_shortcode( 'biglie', 'biglie_f' );


/**
 * Translates the shortcode [biglia] to its HTML
 *
 * @param $atts_in
 *
 * @return string
 */
function biglia_f( $atts ) {

	$default = array(
		'image'    => null,
		'link'     => null,
		'page'     => null,
		'subtitle' => null,
		'title'    => null,
	);

	$atts = shortcode_atts( $default, $atts );


	// Sanitizing
	$atts['image']    = esc_url( $atts_in['image'] );
	$atts['link']     = esc_url( $atts_in['link'] );
	$atts['page']     = sanitize_text_field( $atts['page'] );
	$atts['subtitle'] = wp_kses( $atts['subtitle'], array( 'br' => array() ) );
	$atts['title']    = wp_kses( $atts['title'], array( 'br' => array() ) );


	// Check whether the user provided a page to link and take data from
	if ( ! empty( $atts['page'] ) ) {

		// retrieve the page using the provided page name
		$atts['page'] = get_page_by_path( $atts['page'] );

		if ( empty( $atts['page'] ) ) {
			return 'Not a page';
		}

		$atts['page-ID'] = $atts['page']->ID;

		$atts['link'] = get_page_link( $atts['page']->ID );

		// If a title was provided, keep it; otherwise get the page's title
		if ( ! isset( $atts['title'] ) || empty( $atts['title'] ) ) {
			$atts['title'] = $atts['page']->post_title;
		}

		// If a subtitle was provided, keep it; otherwise get the page's custom field subtitle
		if ( ! isset( $atts['subtitle'] ) || empty( $atts['subtitle'] ) ) {
			if ( function_exists( 'get_field' ) && ! empty( $atts['page']->subtitle ) ) {
				$atts['subtitle'] = $atts['page']->subtitle;
			}
		}

	}

	return print_marble( $atts );
}

add_shortcode( 'biglia', 'biglia_f' );


/**
 * Prints the HTML code of a single biglia
 *
 * @param $in_atts array
 *              ['image'] string (optional) The URL of the image inside the biglia
 *              ['link'] string The URL to which the biglia links
 *              ['page-ID'] integer (optional) The ID of the page
 *              ['subtitle'] string The subtitle ('false' means the title will be hidden)
 *              ['title'] string The title ('false' means the subtitle will be hidden)
 *
 * @return string
 */
function print_marble( $in_atts ) {

	$default = array(
		'image'    => null,
		'link'     => null,
		'page-ID'  => null,
		'subtitle' => false,
		'title'    => null,
	);

	$atts = wp_parse_args( $in_atts, $default );

	$output = '<li class="biglia">';
	$output .= '<a href="' . $atts['link'] . '">';
	$output .= '<div class="biglia-image">';

	if ( empty( $atts['image'] ) ) {
		$output .= get_the_post_thumbnail( $atts['page-ID'], 'marble' );
	} else {
		$output .= '<img src="' . $atts['image'] . '" title="' . $atts['title'] . '" />';
	}

	$output .= '</div>';

	if ( $atts['title'] != 'false' ) {
		$output .= '<h2>' . $atts['title'] . '</h2>';
	}

	if ( $atts['subtitle'] != 'false' ) {
		$output .= '<h3>' . $atts['subtitle'] . '</h3>';
	}

	$output .= '</a>';
	$output .= '</li>';

	return $output;
}