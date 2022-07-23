<?php
/**
 * Treviso custom navbar walker.
 *
 * Custom Walker_Nav_Menu to display the header. Based on the WordPress Nav Walker.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

/**
 * Setup the Navbar menu.
 */
class Treviso_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * Flag when outputting mega menu.
	 *
	 * @var boolean Mega menu flag.
	 */
	private $mega_menu = false;

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

		// Dropdown class.
		$classes = array( 'navbar-dropdown' );

		if ( $depth > 0 ) {
			$classes[] = 'is-nested is-boxed';
		}

		if ( $this->mega_menu ) {
			$classes[] = 'is-mega-menu';
		}

		$class_names = join( ' ', apply_filters( 'treviso_nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		// Wrap items in container for mega menu.
		if ( $this->mega_menu ) {
			if ( 0 === $depth ) {
				$output .= "{$n}{$indent}<div$class_names>{$n}";
				$output .= '<!-- mega menu start -->';
				$output .= "{$n}{$indent}<div class=\"container\">{$n}";
				$output .= "{$n}{$indent}<div class=\"columns\">{$n}";
			}
		} else {
			$output .= "{$n}{$indent}<div$class_names>{$n}";
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

		// End container wrapper for mega menu.
		if ( $this->mega_menu ) {
			if ( 0 === $depth ) {
				$output .= "$indent</div>{$n}";
				$output .= "$indent</div>{$n}";
				$output .= '<!-- mega menu end -->';
				$output .= "$indent</div>{$n}";

				$this->mega_menu = false;
			}
		} else {
			$output .= "$indent</div>{$n}";
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

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		// Enable a mega menu.
		if ( in_array( 'has-mega-menu', $classes, true ) ) {
			$this->mega_menu = true;
		}

		// Make any item with children hoverable with a dropdown.
		if ( $args->walker->has_children ) {
			array_unshift( $classes, 'is-hoverable' );
			array_unshift( $classes, 'has-dropdown' );
		}

		// Only the mega menu footer uses level-item, everywhere else navbar-item is used.
		if ( $this->mega_menu ) {
			if ( in_array( 'is-footer-left', $classes, true ) || in_array( 'is-footer-right', $classes, true ) ) {
				array_unshift( $classes, 'level-item' );
			} else {
				array_unshift( $classes, 'navbar-item' );
			}
		} else {
			array_unshift( $classes, 'navbar-item' );
		}

		$classes[] = 'menu-item-' . $item->ID;

		// Get font awesome classes from menu item and remove, to be added to descendant <i>.
		$fa_classes = preg_grep( '/(fa-.*|^fas|^fab)/m', $classes );
		$classes    = array_diff( $classes, $fa_classes );

		$args = apply_filters( 'treviso_nav_menu_item_args', $args, $item, $depth );

		$class_names = join( ' ', apply_filters( 'treviso_nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		$id = apply_filters( 'treviso_nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

		// Custom wrappers for different objects.
		if ( $this->mega_menu ) {
			if ( 1 === $depth ) {
				if ( in_array( 'is-footer', $classes, true ) ) {
					$output .= "</div>{$n}";
					$output .= "</div>{$n}";
					$output .= "<hr class=\"navbar-divider\">{$n}";
					$output .= $indent . '<div' . $class_names . $id . '><div class="navbar-content"><div class="level is-mobile">';
				} elseif ( in_array( 'is-post', $classes, true ) || in_array( 'is-img', $classes, true ) ) {
					$output .= $indent . '<div class="column has-card">';
				} else {
					$output .= $indent . '<div class="column">';
				}
			} elseif ( in_array( 'is-footer-left', $classes, true ) ) {
				$output .= $indent . '<div class="level-left"><div' . $class_names . $id . '>';
			} elseif ( in_array( 'is-footer-right', $classes, true ) ) {
				$output .= $indent . '<div class="level-right"><div' . $class_names . $id . '>';
			} else {
				$output .= $indent . '<div' . $class_names . $id . '>';
			}
		} else {
			$output .= $indent . '<div' . $class_names . $id . '>';
		}

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		if ( '_blank' === $item->target && empty( $item->xfn ) ) {
			$atts['rel'] = 'noopener noreferrer';
		} else {
			$atts['rel'] = $item->xfn;
		}

		$atts['href']         = $item->url;
		$atts['aria-current'] = $item->current ? 'page' : '';

		$atts = apply_filters( 'treviso_nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value       = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title = apply_filters( 'treviso_the_title', $item->title, $item->ID );

		$title = apply_filters( 'treviso_nav_menu_item_title', $title, $item, $args, $depth );

		$item_classes = array();

		// Enable a navbar button.
		if ( in_array( 'is-button', $classes, true ) ) {
			$item_classes = array( 'button is-fullwidth navbar-button' );

			// Use a small button for mega menu footer.
			if ( in_array( 'is-footer-left', $classes, true ) || in_array( 'is-footer-right', $classes, true ) ) {
				$item_classes = array( 'button is-small' );
			}
		} else {
			$item_classes = array( 'navbar-link' );

			// Remove arrow when navbar-link has no children.
			if ( ! $args->walker->has_children ) {
				$item_classes[] = 'is-arrowless';
			}
		}

		if ( 0 === $depth ) {
			$item_classes[] = 'top';
		}

		$item_class_names = array_map( 'esc_attr', $item_classes );
		$item_class_names = $item_class_names ? ' class="' . implode( ' ', $item_class_names ) . '"' : '';

		$item_output = $args->before;

		// Display font-awesome elements and wrap in span.
		if ( $fa_classes ) {
			$fa_class_names = array_map( 'esc_attr', $fa_classes );
			$fa_class_names = ' class="' . implode( ' ', $fa_class_names ) . '"';

			$item_output .= ( isset( $atts['href'] ) ? '<a' : '<div' ) . $item_class_names . ' ' . $attributes . '>';
			$item_output .= '<span class="icon"><i' . $fa_class_names . '></i></span><span>';
			$item_output .= $args->link_before . $title . $args->link_after;
			$item_output .= '</span>' . ( isset( $atts['href'] ) ? '</a>' : '</div>' );
		} else {
			$item_output .= '<a' . $item_class_names . ' ' . $attributes . '>';
			$item_output .= $args->link_before . $title . $args->link_after;
			$item_output .= '</a>';
		}

		$item_output .= $args->after;

		// Reset is-img, is-post and is-footer items html.
		if ( $this->mega_menu && ( in_array( 'is-footer', $classes, true ) || in_array( 'is-img', $classes, true ) || in_array( 'is-post', $classes, true ) ) ) {
			$item_output = '';
		}

		if ( in_array( 'is-search', $classes, true ) ) {
			$item_output  = "{$n}{$indent}<a href=\"#\" class=\"navbar-search-icon\"><i class=\"fas fa-search\"></i></a>{$n}";
			$item_output .= "{$n}{$indent}<div class=\"navbar-search-block\">{$n}";
			$item_output .= get_search_form( false );
			$item_output .= "{$n}{$indent}</div>{$n}";
		}

		// Override $item_output for mega menu specific objects.
		if ( $this->mega_menu ) {
			if ( in_array( 'is-img', $classes, true ) ) {
				$item_output  = "{$n}{$indent}<div class=\"card\">{$n}";
				$item_output .= "{$n}{$indent}<div class=\"card-image\">{$n}";
				$item_output .= "{$n}{$indent}<figure class=\"image is-16by9\">{$n}";
				$item_output .= "{$n}{$indent}<img src=\"" . esc_url( $atts['href'] ) . "\" alt=\"...\">{$n}";
				$item_output .= "{$n}{$indent}</figure>{$n}";
				$item_output .= "{$n}{$indent}</div>{$n}";
				$item_output .= "{$n}{$indent}<div class=\"card-content\">{$n}";
				$item_output .= "{$n}{$indent}<div class=\"content\">{$n}";
				$item_output .= "{$n}{$indent}<div>" . $title . "</div>{$n}";
				$item_output .= "{$n}{$indent}</div>{$n}";
				$item_output .= "{$n}{$indent}</div>{$n}";
				$item_output .= "{$n}{$indent}</div>{$n}";
			} elseif ( in_array( 'is-post', $classes, true ) ) {
				$matches    = preg_grep( '/post-.*/m', $classes );
				$post_id    = reset( $matches );
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

				$item_output  = "{$n}{$indent}<div class=\"card\">{$n}";
				$item_output .= "{$n}{$indent}<div class=\"card-image\">{$n}";
				$item_output .= "{$n}{$indent}<figure class=\"image is-16by9\">{$n}";
				$item_output .= "{$n}{$indent}" . $post_img . "{$n}";
				$item_output .= "{$n}{$indent}</figure>{$n}";
				$item_output .= "{$n}{$indent}</div>{$n}";
				$item_output .= "{$n}{$indent}<div class=\"card-content\">{$n}";
				$item_output .= "{$n}{$indent}<div class=\"content\">{$n}";
				$item_output .= "{$n}{$indent}<h6 class=\"title is-6\">" . $post_title . "</h6>{$n}";
				$item_output .= "{$n}{$indent}<a href=\"" . $post_url . '\">' . esc_html__( 'Read more', 'treviso' ) . "...</a>{$n}";
				$item_output .= "{$n}{$indent}</div>{$n}";
				$item_output .= "{$n}{$indent}</div>{$n}";
				$item_output .= "{$n}{$indent}</div>{$n}";
			} elseif ( in_array( 'is-footer', $classes, true ) ) {
				$item_output = '';
			} elseif ( in_array( 'is-footer-left', $classes, true ) || in_array( 'is-footer-right', $classes, true ) ) {
				if ( ! in_array( 'is-button', $classes, true ) ) {
					$item_output = '<strong>' . $title . '</strong>';
				}
			} elseif ( 1 === $depth ) {
				if ( in_array( 'no-header', $classes, true ) ) {
					$item_output = '<div class="empty-title"></div>';
				} else {
					$item_output = '<h3 class="title">' . $title . '</h3>';
				}
			}
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

		// Footer alignment classes require an extra closing div.
		if ( $depth >= 0 && $this->mega_menu && ( in_array( 'is-footer-left', $classes, true ) || in_array( 'is-footer-right', $classes, true ) ) ) {
			$output .= "</div>{$n}";
			$output .= "</div>{$n}";
		} else {
			$output .= "</div>{$n}";
		}
	}
}
