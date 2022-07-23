<?php
/**
 * Treviso custom footer walker.
 *
 * Custom Walker_Nav_Menu to display the footer. Based on the WordPress Nav Walker.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

/**
 * Setup the Footer menu.
 */
class Treviso_Walker_Footer_Menu extends Walker_Nav_Menu {
	/**
	 * Array to hold item classes when needed.
	 *
	 * @var array Nav item classes.
	 */
	private $item_classes;

	/**
	 * Starts the list before the elements are added.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		// Footer menu classes.
		$classes = array( 'footer-menu' );

		if ( in_array( 'is-social', $this->item_classes, true ) ) {
			$classes = array( 'socials' );
		}

		$class_names = join( ' ', apply_filters( 'treviso_nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		if ( ! in_array( 'is-custom', $this->item_classes, true ) ) {
			$output .= "{$n}{$indent}<ul$class_names>{$n}";
		}
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		if ( ! in_array( 'is-custom', $this->item_classes, true ) ) {
			$output .= "$indent</ul>{$n}";
		}
	}

	/**
	 * Starts the element output.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Menu item data object.
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int      $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		// Get font awesome classes from menu item and remove, to be added to descendant <i>.
		$fa_classes = preg_grep( '/(fa-.*|^fas|^fab)/m', $classes );
		$classes    = array_diff( $classes, $fa_classes );

		$this->item_classes = $classes;

		$args = apply_filters( 'treviso_nav_menu_item_args', $args, $item, $depth );

		$class_names = join( ' ', apply_filters( 'treviso_nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'treviso_nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		if ( 0 === $depth ) {
			$output .= $indent . '<div class="column">';
		}

		if ( ( ! $args->walker->has_children ) 
			&& ( ! in_array( 'is-img', $classes, true ) ) 
			&& ( ! in_array( 'is-img-white', $classes, true ) ) 
			&& ( ! in_array( 'title', $classes, true ) ) ) {
			$output .= $indent . '<li' . $id . $class_names . '>';
		}

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		if ( '_blank' === $item->target && empty( $item->xfn ) ) {
			$atts['rel'] = 'noopener noreferrer';
		} else {
			$atts['rel'] = $item->xfn;
		}
		$atts['href']         = ! empty( $item->url ) ? $item->url : '';
		$atts['aria-current'] = $item->current ? 'page' : '';

		$atts = apply_filters( 'treviso_nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		// This filter is documented in wp-includes/post-template.php.
		$title = apply_filters( 'treviso_the_title', $item->title, $item->ID );

		$title = apply_filters( 'treviso_nav_menu_item_title', $title, $item, $args, $depth );

		$item_output = $args->before;

		// Display font-awesome elements and wrap in span.
		if ( $fa_classes ) {
			$fa_class_names = array_map( 'esc_attr', $fa_classes );
			$fa_class_names = ' class="' . implode( ' ', $fa_class_names ) . '"';

			$item_output .= '<a class="social" aria-label="' . $title . '"' . $attributes . '>';
			$item_output .= '<i' . $fa_class_names . '></i>';
			$item_output .= $args->link_before . $args->link_after;
			$item_output .= '</a>';
		} elseif ( in_array( 'is-post', $classes, true ) ) {
			$opts       = preg_grep( '/post-.*/m', $classes );
			$post_id    = reset( $opts );
			$post_title = '';
			$post_img   = '';
			$post_url   = '';

			if ( $post_id ) {
				$post_id    = str_replace( 'post-', '', $post_id );
				$post_title = get_the_title( $post_id );
				$post_img   = get_the_post_thumbnail( $post_id );
				$post_url   = get_the_permalink( $post_id );
			} else {
				$latest_post_query = new WP_Query( 'posts_per_page=1' );
				if ( have_posts() ) :
					while ( $latest_post_query->have_posts() ) :
						$latest_post_query->the_post();
						$post_title = get_the_title();
						$post_img   = get_the_post_thumbnail();
						$post_url   = get_the_permalink();
					endwhile;
				endif;
			}

			$item_output = "{$n}{$indent}<div class=\"card\">{$n}";
			if ( ! empty( $post_img ) ) {
				$item_output .= "{$n}{$indent}<div class=\"card-image\">{$n}";
				$item_output .= "{$n}{$indent}<figure class=\"image is-16by9\">{$n}";
				$item_output .= "{$n}{$indent}" . $post_img . "{$n}";
				$item_output .= "{$n}{$indent}</figure>{$n}";
				$item_output .= "{$n}{$indent}</div>{$n}";

			}
			$item_output .= "{$n}{$indent}<div class=\"card-content\">{$n}";
			$item_output .= "{$n}{$indent}<div class=\"content\">{$n}";
			$item_output .= "{$n}{$indent}<h2 class=\"title is-6\">" . $post_title . "</h2>{$n}";
			$item_output .= "{$n}{$indent}<a class=\"footer-link\" href=\"" . $post_url . '\">' . esc_html__( 'Read more', 'treviso' ) . "...</a>{$n}";
			$item_output .= "{$n}{$indent}</div>{$n}";
			$item_output .= "{$n}{$indent}</div>{$n}";
			$item_output .= "{$n}{$indent}</div>{$n}";
		} else {
			$item_output .= '<a class="footer-link"' . $attributes . '>';
			$item_output .= $args->link_before . $title . $args->link_after;
			$item_output .= '</a>';
		}

		$item_output .= $args->after;

		if ( in_array( 'no-header', $classes, true ) || in_array( 'is-custom', $classes, true ) || in_array( 'is-social', $classes, true ) ) {
			$item_output = '';
		} elseif ( in_array( 'title', $classes, true ) ) {
			$item_output = '<h2 class="title is-light is-5">' . $title . '</h2>';
		} elseif ( in_array( 'is-img', $classes, true ) ) {
			$item_output = '<div class="footer-image"><img src="' . esc_url( $item->url ) . '" alt="' . $title . '"/></div>';
		} elseif ( in_array( 'is-img-white', $classes, true ) ) {
			$item_output = '<div class="footer-image"><img src="' . esc_url( $item->url ) . '" class="white" alt="' . $title . '"/></div>';
		} elseif ( $args->walker->has_children ) {
			$item_output = '<h2 class="title is-light is-5">' . $title . '</h2>';
		}

		$output .= apply_filters( 'treviso_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param WP_Post  $item   Page data object. Not used.
	 * @param int      $depth  Depth of page. Not Used.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		if ( ( ! $args->walker->has_children ) && ( ! in_array( 'is-img', $classes, true ) ) && ( ! in_array( 'is-img-white', $classes, true ) ) ) {
			$output .= "</li>{$n}";
		}

		if ( 0 === $depth ) {
			$output .= "</div>{$n}";
		}
	}
}
