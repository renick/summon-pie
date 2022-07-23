<?php
/**
 * Functions which enhance the theme by hooking into WordPress and other 
 * various functions used throughout the theme.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

/**
 * Get the classes for the body tag.
 *
 * @param array $classes Current classes for the body element.
 * @return array The altered list of body classes.
 */
function treviso_get_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Fixed nav bar.
	if ( true === get_theme_mod( 'header_fixed' ) ) {
		$classes[] = 'has-navbar-fixed-top';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	$location = get_theme_mod( 'content_sidebar_location' );
	if ( 'right' === $location ) {
		$classes[] = 'has-sidebar-right';
	} elseif ( 'left' === $location ) {
		$classes[] = 'has-sidebar-left';
	} else {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'treviso_get_body_classes' );

/**
 * Get the classes for the navbar.
 *
 * @return array The header classes to be added.
 */
function treviso_get_header_classes() {
	$classes = array( 'site-header', 'navbar' );

	// Fixed nav bar.
	if ( true === get_theme_mod( 'header_fixed' ) ) {
		$classes[] = 'is-fixed-top';
	}

	// Header background image styles.
	if ( has_header_image() ) {
		$classes[] = 'has-bg-image';
	}

	// Transparent nav bar.
	if ( true === get_theme_mod( 'header_transparent' ) ) {
		$post_id   = get_queried_object_id();
		$post_cats = wp_get_post_categories( $post_id, array( 'fields' => 'ids' ) );
		$exclude   = false;

		// Split and trim exclusions.
		$exclusions = preg_split( '/\,/', get_theme_mod( 'header_transparent_exclusions' ) );
		$exclusions = array_map( 'trim', $exclusions );
		
		// Get categories and remove from original array.
		$ex_cats    = preg_grep( '/-(.*)/', $exclusions );
		$exclusions = array_diff( $exclusions, $ex_cats );

		// Exclude by post/page id.
		if ( in_array( (string) $post_id, $exclusions, true ) ) {
			$exclude = true;
		}

		// Exclude by category id.
		foreach ( $post_cats as $id ) {
			if ( in_array( '-' . $id, $ex_cats, true ) ) {
				$exclude = true;
				break;
			}
		}

		// Check Singular Pages Only option.
		if ( ! is_singular() && true === get_theme_mod( 'header_transparent_singular_only' ) ) {
			$exclude = true;
		}

		if ( ! $exclude ) {
			$classes[] = 'is-transparent';
		}
	}

	return implode( ' ', $classes );
}

/**
 * Get the classes for the footer.
 *
 * @return array The footer classes to be added.
 */
function treviso_get_footer_classes() {
	$classes = array( 'site-footer' );

	// Background image.
	if ( ! empty( get_theme_mod( 'footer_bgimage' ) ) ) {
		$classes[] = 'has-bg-image';
	}

	return implode( ' ', $classes );
}

/**
 * Get the classes for the main section.
 *
 * @return array The main classes to be added.
 */
function treviso_get_main_classes() {
	$classes = array( 'column' );

	if ( 'left' === get_theme_mod( 'content_sidebar_location' ) || 'right' === get_theme_mod( 'content_sidebar_location' ) ) {
		$classes[] = 'is-8-desktop';
	} else {
		$classes[] = 'is-12-desktop';
	}

	$classes[] = 'site-main';

	return implode( ' ', $classes );
}

/**
 * Add data-* attributes to #page in the Customizer.
 */
function treviso_preview_data_attr() {
	if ( is_customize_preview() ) {
		$post_id   = get_queried_object_id();
		$post_cats = wp_get_post_categories( $post_id, array( 'fields' => 'ids' ) );

		printf(
			' data-object-id="%s" data-categories="%s" data-singular="%s"',
			esc_attr( $post_id ),
			esc_attr( implode( ',', $post_cats ) ),
			is_singular() ? 'true' : 'false'
		);
	}
}

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function treviso_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'treviso_pingback_header' );

/**
 * Adds a meta tag for the meta-theme-color on supported browsers.
 */
function treviso_meta_theme_color() {
	if ( ! empty( get_theme_mod( 'head_meta_color' ) ) ) {
		printf( '<meta name="theme-color" content="%s">', esc_attr( get_theme_mod( 'head_meta_color' ) ) );
	}
}
add_action( 'wp_head', 'treviso_meta_theme_color' );

/**
 * Adds a stylesheet to fix the WordPress Admin Bar to the top of the screen.
 */
function treviso_fixed_admin_bar() {
	if ( is_admin_bar_showing() ) {
		?>
		<style id="fixed-admin-bar">
			#wpadminbar {
				position: fixed;
			}
			.admin-bar .navbar.is-fixed-top {
				top: 46px;
			}
			@media only screen and (min-width: 782px) {
				.admin-bar .navbar.is-fixed-top {
					top: 32px;
				}
			}
		</style>
		<?php
	}
}
add_action( 'wp_head', 'treviso_fixed_admin_bar' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function treviso_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:disable
	$GLOBALS['content_width'] = apply_filters( 'treviso_content_width', 640 );
	// phpcs:enable
}
add_action( 'after_setup_theme', 'treviso_content_width', 0 );

/**
 * Get the URL of the custom logo.
 *
 * @return string The custom logo url.
 */
function treviso_get_the_logo() {
	$id   = get_theme_mod( 'custom_logo' );
	$logo = wp_get_attachment_image_src( $id, 'full' );
	return $logo[0];
}

/**
 * Add tag classes to tag cloud links
 *
 * @param array $tag_data Tag data.
 * @return array The classes to be added to the tag cloud.
 */
function treviso_tag_cloud_classes( $tag_data ) {
	$tags = array();
	foreach ( $tag_data as $tag ) {
		$tag['class'] .= ' tag';
		$tags[]        = $tag;
	}
	return $tags;
}
add_filter( 'wp_generate_tag_cloud_data', 'treviso_tag_cloud_classes' );

/**
 * Change the tag cloud font sizes.
 *
 * @param array $args Tag cloud arguments.
 * @return array The altered args for the tag cloud.
 */
function treviso_tag_cloud_font_sizes( array $args ) {
	$args['smallest'] = '10';
	$args['largest']  = '18';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'treviso_tag_cloud_font_sizes' );

/**
 * Add class to submit button in comments.
 *
 * @param string $defaults Comment form defaults.
 * @return array The edited defaults.
 */
function treviso_comment_form_defaults( $defaults ) {
	$defaults['class_submit'] = esc_attr( 'button' );
	return $defaults;
}
add_filter( 'comment_form_defaults', 'treviso_comment_form_defaults' );

/**
 * Disable comments on media.
 *
 * @param object $open Open.
 * @param object $post_id The post ID.
 * @return boolean True when disable_media_comments is defined.
 */
function treviso_disable_media_comments( $open, $post_id ) {
	if ( true === get_theme_mod( 'misc_disable_media_comments' ) ) {
		$post = get_post( $post_id );
		if ( 'attachment' === $post->post_type ) {
			return false;
		}
	}
	return $open;
}
add_filter( 'comments_open', 'treviso_disable_media_comments', 10, 2 );

/**
 * Register search query exclusions.
 *
 * @param object $query The query.
 */
function treviso_search_exclude_filter( $query ) {
	if ( ! $query->is_admin && $query->is_search && $query->is_main_query() ) {
		if ( ! empty( get_theme_mod( 'misc_search_exclusions' ) ) ) {
			$exclusions = preg_split( '/\,/', get_theme_mod( 'misc_search_exclusions' ) );
			$exclusions = array_map( 'trim', $exclusions );
			$categories = preg_grep( '/-(.*)/', $exclusions );
			$exclusions = array_diff( $exclusions, $categories );

			$query->set( 'post__not_in', $exclusions );
			foreach ( $categories as $category ) {
				$query->set( 'cat', $category );
			}

			$query->set( 'posts_per_page', 20 );
		}
	}
}
add_filter( 'pre_get_posts', 'treviso_search_exclude_filter' );

/**
 * Get an array of supported social media networks.
 *
 * @return array The supported social networks.
 */
function treviso_get_social_media_networks() {
	return array(
		'email'     => array(
			'name'       => 'Email',
			'fa_icon'    => 'fas fa-envelope fa-lg',
			'share_url'  => 'mailto:',
			'url_params' => array(
				'subject' => esc_html__( 'Checkout this post: ', 'treviso' ) . esc_attr( get_the_title() ),
				'body'    => esc_attr( get_the_excerpt() ) . PHP_EOL . esc_url( get_the_permalink() ),
			),
		),
		'facebook'  => array(
			'name'       => 'Facebook',
			'fa_icon'    => 'fab fa-facebook fa-lg',
			'share_url'  => 'https://www.facebook.com/sharer/sharer.php',
			'url_params' => array(
				'u'       => esc_url( get_the_permalink() ),
				'hashtag' => has_tag() ? '#' . esc_attr( treviso_str_remove_spaces( current( get_the_tags() )->name ) ) : '',
			),
		),
		'linkedin'  => array(
			'name'       => 'LinkedIn',
			'fa_icon'    => 'fab fa-linkedin fa-lg',
			'share_url'  => 'https://www.linkedin.com/sharing/share-offsite',
			'url_params' => array(
				'mini'    => true,
				'url'     => esc_url( get_the_permalink() ),
				'title'   => esc_attr( get_the_title() ),
				'summary' => esc_attr( get_the_excerpt() ),
				'source'  => esc_attr( get_theme_mod( 'footer_copyrighttext' ) ),
			),
		),
		'pinterest' => array(
			'name'       => 'Pinterest',
			'fa_icon'    => 'fab fa-pinterest fa-lg',
			'share_url'  => 'https://www.pinterest.com/pin/create/button',
			'url_params' => array(
				'url'         => esc_url( get_the_permalink() ),
				'media'       => esc_url( get_the_post_thumbnail_url() ),
				'description' => esc_attr( get_the_excerpt() ),
			),
		),
		'reddit'    => array(
			'name'       => 'Reddit',
			'fa_icon'    => 'fab fa-reddit fa-lg',
			'share_url'  => 'https://www.reddit.com/submit',
			'url_params' => array(
				'url' => esc_url( get_the_permalink() ),
			),
		),
		'twitter'   => array(
			'name'       => 'Twitter',
			'fa_icon'    => 'fab fa-twitter fa-lg',
			'share_url'  => 'https://twitter.com/intent/tweet',
			'url_params' => array(
				'url'      => esc_url( get_the_permalink() ),
				'text'     => esc_attr( get_the_excerpt() ),
				'hashtags' => '',
				'via'      => ! empty( get_theme_mod( 'footer_copyrighttext' ) ) ? esc_attr( get_theme_mod( 'footer_copyrighttext' ) ) : '',
			),
		),
	);
}

/**
 * Get the names of the supported social networks.
 *
 * @return array An array social networks names.
 */
function treviso_get_social_media_networks_list() {
	$social_networks = treviso_get_social_media_networks();
	$list            = array();

	foreach ( $social_networks as $key => $value ) {
		$list[ $key ] = $value['name'];
	}
	return $list;
}

/**
 * Add ellipses from excerpts.
 * 
 * @param string $more The string shown within the more link.
 */
function treviso_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}

	return ' ...';
}
add_filter( 'excerpt_more', 'treviso_excerpt_more' );

/**
 * Increases or decreases the brightness of a color by a percentage of the current brightness.
 *
 * @param string $hex_code Supported formats: `#FFF`, `#FFFFFF`, `FFF`, `FFFFFF`.
 * @param float  $adjust_percent A number between -1 and 1. E.g. 0.3 = 30% lighter; -0.4 = 40% darker.
 * @return string The adjusted hex color.
 */
function treviso_adjust_brightness( $hex_code, $adjust_percent ) {
	$hex_code = ltrim( $hex_code, '#' );

	if ( strlen( $hex_code ) === 3 ) {
		$hex_code = $hex_code[0] . $hex_code[0] . $hex_code[1] . $hex_code[1] . $hex_code[2] . $hex_code[2];
	}

	$hex_code = array_map( 'hexdec', str_split( $hex_code, 2 ) );

	foreach ( $hex_code as & $color ) {
		$adjustable_limit = $adjust_percent < 0 ? $color : 255 - $color;
		$adjust_amount    = ceil( $adjustable_limit * $adjust_percent );

		$color = str_pad( dechex( $color + $adjust_amount ), 2, '0', STR_PAD_LEFT );
	}

	return '#' . implode( $hex_code );
}

/**
 * Removes all spaces in a string based on the \s regex.
 *
 * @param string $string The string to remove spaces from.
 * @return string The processed string.
 */
function treviso_str_remove_spaces( $string ) {
	return preg_replace( '/\s+/', '', esc_attr( $string ) );
}

/**
 * Prints an array as data-* attributes.
 *
 * @param array $url_params The array of url parameters.
 */
function treviso_print_data_attrs( $url_params ) {
	if ( ! is_array( $url_params ) ) {
		return;
	}

	foreach ( $url_params as $key => $value ) {
		if ( empty( $value ) ) {
			continue;
		}

		printf( ' data-%s="%s"', esc_attr( $key ), esc_attr( $value ) );
	}
}

/**
 * Prints the style attribute with background-image.
 * 
 * @param string $url The url of the image.
 */
function treviso_bg_style_attr( $url ) {
	if ( ! $url || empty( $url ) ) {
		echo '';
	}
	printf( ' style="background-image: url(%s);"', esc_url( $url ) );
}

/**
 * Enqueue styles and scripts for the customizer custom controls.
 */
function treviso_custom_controls_enqueue() {
	$css_suffix      = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';
	$js_suffix       = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';
	$theme_version   = wp_get_theme()->get( 'Version' );
	$select2_version = '4.1.0-rc.0';

	$typography_bodyfontfamily = get_theme_mod( 'typography_bodyfontfamily' );
	if ( ! empty( $typography_bodyfontfamily ) ) {
		wp_enqueue_style( 'treviso-body-font', 'https://fonts.googleapis.com/css?family=' . esc_html( $typography_bodyfontfamily ), array(), $theme_version );
	}

	$typography_headerfontfamily = get_theme_mod( 'typography_headerfontfamily' );
	if ( ! empty( $typography_headerfontfamily ) ) {
		wp_enqueue_style( 'treviso-header-font', 'https://fonts.googleapis.com/css?family=' . esc_html( $typography_headerfontfamily ), array(), $theme_version );
	}

	wp_enqueue_style( 'select2', get_template_directory_uri() . '/assets/css/select2' . $css_suffix, array(), $select2_version );
	wp_enqueue_style( 'treviso-custom-controls', get_template_directory_uri() . '/assets/css/treviso-custom-controls' . $css_suffix, array( 'select2' ), $theme_version );

	wp_enqueue_script( 'select2', get_template_directory_uri() . '/assets/js/select2' . $js_suffix, array( 'jquery' ), $select2_version, true );
	wp_enqueue_script( 'treviso-custom-controls', get_template_directory_uri() . '/assets/js/treviso-custom-controls' . $js_suffix, array( 'jquery', 'select2' ), $theme_version, true );
}
