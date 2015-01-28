<?php
/**
 * Custom Walker to add icon fonts to navigation (via description field)
 *
 * @package soblossom
 */

class iconfont_walker extends Walker_Nav_Menu {


	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$class_names = $value = '';
		
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;
		
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
		
		$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		if ( $item->menu_order == 1 ) {
			$locations = get_nav_menu_locations();

			$menu = wp_get_nav_menu_object($locations['social']);

			$output .= '<li id="menu-name" class="hide-for-small-only">'. $menu->name .'</li>';

		}
		
		$output .= $indent . '<li' . $id . $value . $class_names .'>';
		
		$attributes  = ' title="'  . apply_filters( 'the_title', $item->title, $item->ID ) . '"';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		
		$description  = ! empty( $item->description ) ? esc_attr( $item->description ) : '';
		
		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '><i class="fa fa-lg fa-' . $description . '"></i></span> ';
		$item_output .= '</a>';
		$item_output .= $args->after;
		$item_output .= "\r\n";
		
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}
