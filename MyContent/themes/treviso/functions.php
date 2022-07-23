<?php
/**
 * Treviso functions and definitions.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function treviso_setup() {
	// Make theme available for translation.
	load_theme_textdomain( 'treviso', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Register nav menus used by the theme.
	register_nav_menus(
		array(
			'navbar-start' => esc_html__( 'Navbar Start', 'treviso' ),
			'navbar-end'   => esc_html__( 'Navbar End', 'treviso' ),
			'footer'       => esc_html__( 'Footer', 'treviso' ),
			'copyright'    => esc_html__( 'Copyright', 'treviso' ),
		)
	);

	// Switch default core markup to output valid HTML5.
	$html5_args = array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	);
	add_theme_support( 'html5', $html5_args );

	// Set up the WordPress core custom background feature.
	$custom_bg_args = apply_filters(
		'treviso_custom_background_args',
		array(
			'default-color' => 'ffffff',
			'default-image' => '',
		)
	);
	add_theme_support( 'custom-background', $custom_bg_args );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Add support for core custom logo.
	$custom_logo_args = array(
		'flex-width'  => true,
		'flex-height' => true,
	);
	add_theme_support( 'custom-logo', $custom_logo_args );

	// Add theme support for custom headers.
	$custom_header_args = apply_filters(
		'treviso_custom_header_args',
		array(
			'default-image'      => '',
			'default-text-color' => '#0045cf',
			'width'              => 1000,
			'height'             => 250,
			'flex-height'        => true,
		)
	);
	add_theme_support( 'custom-header', $custom_header_args );

	add_theme_support( 'responsive-embeds' );

	// Add excerpt support for pages.
	add_post_type_support( 'page', 'excerpt' );

	// Add editor style for Customizer.
	$css_suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';
	add_editor_style( get_template_directory_uri() . '/assets/css/treviso-editor-style' . $css_suffix );
}
add_action( 'after_setup_theme', 'treviso_setup' );

// Functions which enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Customizer additions.
require get_template_directory() . '/inc/customizer.php';

// Custom Nav Walker for site header.
require get_template_directory() . '/inc/class-treviso-walker-nav-menu.php';

// Custom Nav Walker for site footer.
require get_template_directory() . '/inc/class-treviso-walker-footer-menu.php';

// Custom Google Fonts Customizer control.
require get_template_directory() . '/inc/class-treviso-customize-google-fonts.php';

// Custom Multi Checkbox Customizer control.
require get_template_directory() . '/inc/class-treviso-customize-multi-checkbox.php';

// Custom Multi Select Customizer control.
require get_template_directory() . '/inc/class-treviso-customize-multi-select.php';

// Load Jetpack compatibility file.
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

// Load Elementor compatibility file.
if ( defined( 'ELEMENTOR_VERSION' ) ) {
	require get_template_directory() . '/inc/elementor.php';
}

/**
 * Enqueue theme styles.
 */
function treviso_enqueue_styles() {
	$css_suffix    = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.css' : '.min.css';
	$theme_version = wp_get_theme()->get( 'Version' );

	// Add main theme CSS.
	wp_enqueue_style( 'treviso', get_template_directory_uri() . '/assets/css/treviso' . $css_suffix, array(), $theme_version );

	// Add Font-Awesome Free.
	wp_enqueue_style( 'font-awesome-free', get_template_directory_uri() . '/assets/css/all' . $css_suffix, array(), '5.15.3' );

	// Add custom body font.
	$body_font = get_theme_mod( 'typography_bodyfontfamily' );
	if ( ! empty( $body_font ) ) {
		wp_enqueue_style( 'treviso-body-font', 'https://fonts.googleapis.com/css?family=' . esc_html( $body_font ), array(), $theme_version );
	}

	// Add custom header font.
	$header_font = get_theme_mod( 'typography_headerfontfamily' );
	if ( ! empty( $header_font ) ) {
		wp_enqueue_style( 'treviso-header-font', 'https://fonts.googleapis.com/css?family=' . esc_html( $header_font ), array(), $theme_version );
	}
}
add_action( 'wp_enqueue_scripts', 'treviso_enqueue_styles' );

/**
 * Enqueue theme scripts.
 */
function treviso_enqueue_scripts() {
	$js_suffix     = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';
	$theme_version = wp_get_theme()->get( 'Version' );

	// Add main theme js.
	wp_enqueue_script( 'treviso', get_template_directory_uri() . '/assets/js/treviso' . $js_suffix, array( 'jquery', 'masonry' ), $theme_version, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		// Add comments js.
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'treviso_enqueue_scripts' );

/**
 * Register widget area.
 */
function treviso_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'treviso' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'treviso' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="title is-4 widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'treviso_widgets_init' );
