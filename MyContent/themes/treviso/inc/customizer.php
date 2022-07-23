<?php
/**
 * Treviso Theme Customizer. Sections have been rearranged to provide a smooth and 
 * organized experience with the Customizer.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

/**
 * Add theme specific settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function treviso_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_image' )->transport     = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->get_control( 'header_image' )->section     = 'header_section';
	$wp_customize->get_control( 'background_image' )->section = 'content_section';

	$wp_customize->remove_section( 'background_image' );

	// Colors.
	$wp_customize->add_setting(
		'head_meta_color',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'head_meta_color',
			array(
				'label'    => esc_html__( 'Meta Color', 'treviso' ),
				'section'  => 'colors',
				'priority' => 1,
			)
		)
	);

	$wp_customize->add_setting(
		'header_bgcolor',
		array(
			'default'           => '#ffffff',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_bgcolor',
			array(
				'label'    => esc_html__( 'Header Background Color', 'treviso' ),
				'section'  => 'colors',
				'priority' => 2,
			)
		)
	);

	$wp_customize->add_setting(
		'hero_textcolor',
		array(
			'default'           => '#ffffff',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'hero_textcolor',
			array(
				'label'           => esc_html__( 'Hero Text Color', 'treviso' ),
				'section'         => 'colors',
				'active_callback' => 'treviso_callback_is_singular',
			)
		)
	);

	$wp_customize->add_setting(
		'sidebar_bgcolor',
		array(
			'default'           => '#f8f6f6',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'sidebar_bgcolor',
			array(
				'label'   => esc_html__( 'Sidebar Background Color', 'treviso' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'content_primarycolor',
		array(
			'default'           => '#0045cf',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'content_primarycolor',
			array(
				'label'   => esc_html__( 'Content Primary Color', 'treviso' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'footer_bgcolor',
		array(
			'default'           => '#0045cf',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_bgcolor',
			array(
				'label'   => esc_html__( 'Footer Background Color', 'treviso' ),
				'section' => 'colors',
			)
		)
	);

	$wp_customize->add_setting(
		'footer_textcolor',
		array(
			'default'           => '#fcfcfc',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'footer_textcolor',
			array(
				'label'   => esc_html__( 'Footer Text Color', 'treviso' ),
				'section' => 'colors',
			)
		)
	);

	// Typography.
	$wp_customize->add_section(
		'typography_section',
		array(
			'title'    => esc_html__( 'Typography', 'treviso' ),
			'priority' => 95,
		)
	);

	$wp_customize->add_setting(
		'typography_bodyfontfamily',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'treviso_sanitize_google_fonts_select',
		)
	);
	$wp_customize->add_control(
		new Treviso_Customize_Google_Fonts(
			$wp_customize,
			'typography_bodyfontfamily',
			array(
				'section'     => 'typography_section',
				'label'       => esc_html__( 'Body Font', 'treviso' ),
				'description' => esc_html__( 'Select which fonts to affect body text.', 'treviso' ),
			)
		)
	);

	$wp_customize->add_setting(
		'typography_bodyfontsize',
		array(
			'default'           => '1em',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'typography_bodyfontsize',
		array(
			'type'        => 'text',
			'section'     => 'typography_section',
			'description' => esc_html__( 'Font Size', 'treviso' ),
		)
	);

	$wp_customize->add_setting(
		'typography_bodyfontweight',
		array(
			'default'           => '400',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'treviso_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'typography_bodyfontweight',
		array(
			'type'        => 'select',
			'section'     => 'typography_section',
			'description' => esc_html__( 'Font Weight', 'treviso' ),
			'choices'     => array(
				'100'    => esc_html__( '100', 'treviso' ),
				'200'    => esc_html__( '200', 'treviso' ),
				'300'    => esc_html__( '300', 'treviso' ),
				'400'    => esc_html__( '400', 'treviso' ),
				'500'    => esc_html__( '500', 'treviso' ),
				'600'    => esc_html__( '600', 'treviso' ),
				'700'    => esc_html__( '700', 'treviso' ),
				'800'    => esc_html__( '800', 'treviso' ),
				'900'    => esc_html__( '900', 'treviso' ),
				'normal' => esc_html__( 'Normal', 'treviso' ),
				'bold'   => esc_html__( 'Bold', 'treviso' ),
			),
		)
	);

	$wp_customize->add_setting(
		'typography_bodyfontstyle',
		array(
			'default'           => 'normal',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'treviso_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'typography_bodyfontstyle',
		array(
			'type'        => 'select',
			'section'     => 'typography_section',
			'description' => esc_html__( 'Font Style', 'treviso' ),
			'choices'     => array(
				'normal' => esc_html__( 'Normal', 'treviso' ),
				'italic' => esc_html__( 'Italic', 'treviso' ),
			),
		)
	);

	$wp_customize->add_setting(
		'typography_headerfontfamily',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'treviso_sanitize_google_fonts_select',
		)
	);
	$wp_customize->add_control(
		new Treviso_Customize_Google_Fonts(
			$wp_customize,
			'typography_headerfontfamily',
			array(
				'section'     => 'typography_section',
				'label'       => esc_html__( 'Header Font', 'treviso' ),
				'description' => esc_html__( 'Select which fonts to affect header text.', 'treviso' ),
			)
		)
	);

	$wp_customize->add_setting(
		'typography_headerfontsize',
		array(
			'default'           => '1em',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'typography_headerfontsize',
		array(
			'type'        => 'text',
			'section'     => 'typography_section',
			'description' => esc_html__( 'Font Size', 'treviso' ),
		)
	);

	$wp_customize->add_setting(
		'typography_headerfontweight',
		array(
			'default'           => '700',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'treviso_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'typography_headerfontweight',
		array(
			'type'        => 'select',
			'section'     => 'typography_section',
			'description' => esc_html__( 'Font Weight', 'treviso' ),
			'choices'     => array(
				'100'    => esc_html__( '100', 'treviso' ),
				'200'    => esc_html__( '200', 'treviso' ),
				'300'    => esc_html__( '300', 'treviso' ),
				'400'    => esc_html__( '400', 'treviso' ),
				'500'    => esc_html__( '500', 'treviso' ),
				'600'    => esc_html__( '600', 'treviso' ),
				'700'    => esc_html__( '700', 'treviso' ),
				'800'    => esc_html__( '800', 'treviso' ),
				'900'    => esc_html__( '900', 'treviso' ),
				'normal' => esc_html__( 'Normal', 'treviso' ),
				'bold'   => esc_html__( 'Bold', 'treviso' ),
			),
		)
	);

	$wp_customize->add_setting(
		'typography_headerfontstyle',
		array(
			'default'           => 'normal',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'treviso_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'typography_headerfontstyle',
		array(
			'type'        => 'select',
			'section'     => 'typography_section',
			'description' => esc_html__( 'Font Style', 'treviso' ),
			'choices'     => array(
				'normal' => esc_html__( 'Normal', 'treviso' ),
				'italic' => esc_html__( 'Italic', 'treviso' ),
			),
		)
	);

	// Header.
	$wp_customize->add_section(
		'header_section',
		array(
			'title'    => esc_html__( 'Header', 'treviso' ),
			'priority' => 95,
		)
	);

	$wp_customize->add_setting(
		'header_fixed',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'treviso_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'header_fixed',
		array(
			'type'        => 'checkbox',
			'section'     => 'header_section',
			'label'       => esc_html__( 'Fixed Header', 'treviso' ),
			'description' => esc_html__( 'Enable a fixed header at the top of the screen.', 'treviso' ),
		)
	);

	$wp_customize->add_setting(
		'header_transparent',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'treviso_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'header_transparent',
		array(
			'type'        => 'checkbox',
			'section'     => 'header_section',
			'label'       => esc_html__( 'Transparent Header', 'treviso' ),
			'description' => esc_html__( 'Enable a transparent header.', 'treviso' ),
		)
	);

	$wp_customize->add_setting(
		'header_transparent_exclusions',
		array(
			'default'           => '3',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'header_transparent_exclusions',
		array(
			'type'            => 'text',
			'section'         => 'header_section',
			'description'     => esc_html__( 'Post/page IDs to exclude from the Transparent Header setting above. Use negative numbers for categories. Comma separated values.', 'treviso' ),
			'active_callback' => 'treviso_callback_header_transparent_option',
		)
	);

	$wp_customize->add_setting(
		'header_transparent_singular_only',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'treviso_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'header_transparent_singular_only',
		array(
			'type'            => 'checkbox',
			'section'         => 'header_section',
			'label'           => esc_html__( 'Singular Pages Only', 'treviso' ),
			'description'     => esc_html__( 'Apply the Transparent Header setting above to singular pages only.', 'treviso' ),
			'active_callback' => 'treviso_callback_header_transparent_option',
		)
	);

	$wp_customize->add_setting(
		'header_disabled',
		array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'treviso_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'header_disabled',
		array(
			'type'        => 'checkbox',
			'section'     => 'header_section',
			'label'       => esc_html__( 'Disable Header', 'treviso' ),
			'description' => esc_html__( 'Prevent output of the header.', 'treviso' ),
		)
	);

	// Content.
	$wp_customize->add_section(
		'content_section',
		array(
			'title'    => esc_html__( 'Content', 'treviso' ),
			'priority' => 96,
		)
	);

	$wp_customize->add_setting(
		'content_hero',
		array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'treviso_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'content_hero',
		array(
			'type'            => 'checkbox',
			'section'         => 'content_section',
			'label'           => esc_html__( 'Hero Section', 'treviso' ),
			'description'     => esc_html__( 'Enable a hero section with a featured image, title, excerpt and category tags.', 'treviso' ),
			'active_callback' => 'treviso_callback_is_singular',
		)
	);

	$wp_customize->add_setting(
		'content_hero_parallax',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'treviso_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'content_hero_parallax',
		array(
			'type'            => 'checkbox',
			'section'         => 'content_section',
			'label'           => esc_html__( 'Hero Parallax Image', 'treviso' ),
			'description'     => esc_html__( 'Enable a parallax effect for the Hero Section setting above.', 'treviso' ),
			'active_callback' => 'treviso_callback_content_hero_option',
		)
	);

	$wp_customize->add_setting(
		'content_breadcrumbs',
		array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'treviso_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'content_breadcrumbs',
		array(
			'type'            => 'checkbox',
			'section'         => 'content_section',
			'label'           => esc_html__( 'Breadcrumbs', 'treviso' ),
			'description'     => esc_html__( 'Include breadcrumbs at the top of singular posts.', 'treviso' ),
			'active_callback' => 'treviso_callback_is_singular',
		)
	);

	$wp_customize->add_setting(
		'content_sidebar_location',
		array(
			'default'           => 'disabled',
			'transport'         => 'refresh',
			'sanitize_callback' => 'treviso_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'content_sidebar_location',
		array(
			'type'        => 'select',
			'section'     => 'content_section',
			'label'       => esc_html__( 'Sidebar Location', 'treviso' ),
			'description' => esc_html__( 'Choose where to display the sidebar.', 'treviso' ),
			'choices'     => array(
				'disabled' => esc_html__( 'Disabled', 'treviso' ),
				'left'     => esc_html__( 'Left', 'treviso' ),
				'right'    => esc_html__( 'Right', 'treviso' ),
			),
		)
	);

	$wp_customize->add_setting(
		'content_post_tags',
		array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'treviso_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'content_post_tags',
		array(
			'type'            => 'checkbox',
			'section'         => 'content_section',
			'label'           => esc_html__( 'Post Tags', 'treviso' ),
			'description'     => esc_html__( 'Show post tags at the bottom of posts.', 'treviso' ),
			'active_callback' => 'treviso_callback_is_singular',
		)
	);

	$wp_customize->add_setting(
		'content_socialbtns',
		array(
			'default'           => 'none',
			'transport'         => 'refresh',
			'sanitize_callback' => 'treviso_sanitize_multiple_select',
		)
	);
	$wp_customize->add_control(
		new Treviso_Customize_Multi_Select(
			$wp_customize,
			'content_socialbtns',
			array(
				'section'         => 'content_section',
				'label'           => esc_html__( 'Social Buttons', 'treviso' ),
				'description'     => esc_html__( 'Select which social buttons to display on a post.', 'treviso' ),
				'choices'         => treviso_get_social_media_networks_list(),
				'active_callback' => 'treviso_callback_is_singular',
			)
		)
	);

	$wp_customize->add_setting(
		'content_socialbtns_location',
		array(
			'default'           => 'bottom',
			'transport'         => 'refresh',
			'sanitize_callback' => 'treviso_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'content_socialbtns_location',
		array(
			'type'            => 'select',
			'section'         => 'content_section',
			'description'     => esc_html__( 'Choose where to display the social buttons for a post.', 'treviso' ),
			'choices'         => array(
				'topbottom' => esc_html__( 'Top & Bottom', 'treviso' ),
				'top'       => esc_html__( 'Top', 'treviso' ),
				'bottom'    => esc_html__( 'Bottom', 'treviso' ),
			),
			'active_callback' => 'treviso_callback_social_option',
		)
	);

	$wp_customize->add_setting(
		'content_socialbtns_options',
		array(
			'default'           => array( 'register', 'submit', 'pass', 'reset' ),
			'transport'         => 'refresh',
			'sanitize_callback' => 'treviso_sanitize_multiple_checkbox',
		)
	);
	$wp_customize->add_control(
		new Treviso_Customize_Multi_Checkbox(
			$wp_customize,
			'content_socialbtns_options',
			array(
				'section'         => 'content_section',
				'description'     => esc_html__( 'Add some styling to social buttons.', 'treviso' ),
				'choices'         => array(
					'rounded'  => esc_html__( 'Rounded', 'treviso' ),
					'outlined' => esc_html__( 'Outlined', 'treviso' ),
					'shadow'   => esc_html__( 'Shadow', 'treviso' ),
					'label'    => esc_html__( 'Label', 'treviso' ),
					'size_md'  => esc_html__( 'Medium Size', 'treviso' ),
				),
				'active_callback' => 'treviso_callback_social_option',
			)
		)
	);

	$wp_customize->add_setting(
		'content_post_nav',
		array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'treviso_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'content_post_nav',
		array(
			'type'            => 'checkbox',
			'section'         => 'content_section',
			'label'           => esc_html__( 'Post Navigation', 'treviso' ),
			'description'     => esc_html__( 'Show previous and next post links.', 'treviso' ),
			'active_callback' => 'treviso_callback_is_singular',
		)
	);

	$wp_customize->add_setting(
		'content_containers_disabled',
		array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'treviso_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'content_containers_disabled',
		array(
			'type'        => 'checkbox',
			'section'     => 'content_section',
			'label'       => esc_html__( 'Disable Containers', 'treviso' ),
			'description' => esc_html__( 'Remove containers for some page builders.', 'treviso' ),
		)
	);

	// Footer.
	$wp_customize->add_section(
		'footer_section',
		array(
			'title'    => esc_html__( 'Footer', 'treviso' ),
			'priority' => 97,
		)
	);

	$wp_customize->add_setting(
		'footer_bgimage',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'footer_bgimage',
			array(
				'label'   => esc_html__( 'Footer Background Image', 'treviso' ),
				'section' => 'footer_section',
			)
		)
	);

	$wp_customize->add_setting(
		'footer_copyrighttext',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'footer_copyrighttext',
		array(
			'type'        => 'text',
			'label'       => esc_html__( 'Copyright Text', 'treviso' ),
			'section'     => 'footer_section',
			'description' => esc_html__( 'Enter a company name, author or any arbitrary text.', 'treviso' ),
		)
	);

	$wp_customize->add_setting(
		'footer_disabled',
		array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'treviso_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'footer_disabled',
		array(
			'type'        => 'checkbox',
			'section'     => 'footer_section',
			'label'       => esc_html__( 'Disable Footer', 'treviso' ),
			'description' => esc_html__( 'Prevent output of the footer.', 'treviso' ),
		)
	);

	// Misc.
	$wp_customize->add_section(
		'misc_section',
		array(
			'title'    => esc_html__( 'Misc', 'treviso' ),
			'priority' => 98,
		)
	);

	$wp_customize->add_setting(
		'btt_btnimage',
		array(
			'default'           => '',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'btt_btnimage',
			array(
				'label'   => esc_html__( 'Back To Top Image', 'treviso' ),
				'section' => 'misc_section',
			)
		)
	);

	$wp_customize->add_setting(
		'misc_search_exclusions',
		array(
			'default'           => '3',
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'misc_search_exclusions',
		array(
			'type'        => 'text',
			'section'     => 'misc_section',
			'label'       => esc_html__( 'Search Exclusions', 'treviso' ),
			'description' => esc_html__( 'Post/page IDs to exclude from search. Use negative numbers for categories. Comma separated values.', 'treviso' ),
		)
	);

	$wp_customize->add_setting(
		'misc_disable_media_comments',
		array(
			'default'           => '',
			'transport'         => 'refresh',
			'sanitize_callback' => 'treviso_sanitize_checkbox',
		)
	);
	$wp_customize->add_control(
		'misc_disable_media_comments',
		array(
			'type'        => 'checkbox',
			'section'     => 'misc_section',
			'label'       => esc_html__( 'Disable Media Comments', 'treviso' ),
			'description' => esc_html__( 'Prevent comments on media files.', 'treviso' ),
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title',
				'render_callback' => 'treviso_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'treviso_customize_partial_blogdescription',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'footer_copyrighttext',
			array(
				'selector'        => '.copyright-start',
				'render_callback' => 'treviso_customize_partial_footer_copyrighttext',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'btt_btnimage',
			array(
				'selector'        => '.back-to-top',
				'render_callback' => 'treviso_customize_partial_btt_btnimage',
			)
		);
	}
}
add_action( 'customize_register', 'treviso_customize_register' );

/**
 * Wrapper for is_singular function.
 */
function treviso_callback_is_singular() {
	return is_singular();
}

/**
 * Active callback for social buttons options.
 */
function treviso_callback_social_option() {
	return is_singular() && ! empty( get_theme_mod( 'content_socialbtns' ) );
}

/**
 * Active callback for the content_hero option.
 */
function treviso_callback_content_hero_option() {
	return is_singular() && true === get_theme_mod( 'content_hero' );
}

/**
 * Active callback for the header transparent exclusions option.
 */
function treviso_callback_header_transparent_option() {
	return true === get_theme_mod( 'header_transparent' );
}

/**
 * Render the site logo and title for the selective refresh partial.
 */
function treviso_customize_partial_blogname() {
	treviso_site_title();
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function treviso_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Render the copyright text for the selective refresh partial.
 */
function treviso_customize_partial_footer_copyrighttext() {
	treviso_footer_copyright_text();
}

/**
 * Render the back to top button image for the selective refresh partial.
 */
function treviso_customize_partial_btt_btnimage() {
	treviso_back_to_top();
}

/**
 * Binds JS handlers to configure controls in the Theme Customizer.
 */
function treviso_customize_control_js() {
	$js_suffix     = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';
	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_script( 'treviso-customizer-controls', get_template_directory_uri() . '/assets/js/treviso-customizer-controls' . $js_suffix, array( 'jquery', 'customize-controls' ), $theme_version, true );
}
add_action( 'customize_controls_enqueue_scripts', 'treviso_customize_control_js' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function treviso_customize_preview_js() {
	$js_suffix     = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '.js' : '.min.js';
	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_script( 'treviso-customizer-preview', get_template_directory_uri() . '/assets/js/treviso-customizer-preview' . $js_suffix, array( 'jquery', 'customize-preview' ), $theme_version, true );
}
add_action( 'customize_preview_init', 'treviso_customize_preview_js' );

/**
 * Adds customizer styles to the head.
 */
function treviso_custom_styles() {
	$css = get_theme_mod( 'treviso_custom_styles', false );

	if ( $css ) {
		printf(
			'<style id="treviso-custom-styles">
				%s
			</style>',
			esc_html( $css )
		);
	}
}
add_action( 'wp_head', 'treviso_custom_styles' );

/**
 * Saves customizer styles to theme_mod
 */
function treviso_cache_custom_styles() {
	$css  = '';
	$css .= treviso_get_header_bgcolor_css();
	$css .= treviso_get_header_textcolor_css();
	$css .= treviso_get_hero_textcolor_css();
	$css .= treviso_get_sidebar_bgcolor_css();
	$css .= treviso_get_content_primarycolor_css();
	$css .= treviso_get_footer_bgcolor_css();
	$css .= treviso_get_footer_textcolor_css();
	$css .= treviso_get_typography_bodyfontfamily_css();
	$css .= treviso_get_typography_bodyfontsize_css();
	$css .= treviso_get_typography_bodyfontweight_css();
	$css .= treviso_get_typography_bodyfontstyle_css();
	$css .= treviso_get_typography_headerfontfamily_css();
	$css .= treviso_get_typography_headerfontsize_css();
	$css .= treviso_get_typography_headerfontweight_css();
	$css .= treviso_get_typography_headerfontstyle_css();
	set_theme_mod( 'treviso_custom_styles', $css );
}
add_action( 'customize_save_after', 'treviso_cache_custom_styles' );

/**
 * Get the css for the header_bgcolor option.
 */
function treviso_get_header_bgcolor_css() {
	$header_bgcolor = sanitize_hex_color( get_theme_mod( 'header_bgcolor' ) );

	if ( empty( $header_bgcolor ) || '#ffffff' === $header_bgcolor ) {
		return;
	}

	return "\n" . <<<CSS
/* Header Background Color */
.navbar,
.navbar.is-transparent.is-scrolled {
	background: {$header_bgcolor};
}
CSS;
}

/**
 * Get the css for the header_textcolor option.
 */
function treviso_get_header_textcolor_css() {
	$header_textcolor  = sanitize_hex_color( '#' . get_header_textcolor() );
	$header_textcolor2 = treviso_adjust_brightness( $header_textcolor, 0.5 );

	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_textcolor ) {
		return;
	}

	if ( ! display_header_text() ) {
		return "\n" . <<<CSS
.site-title,
.site-description {
	position: absolute;
	clip: rect(1px, 1px, 1px, 1px);
}
CSS;
	} elseif ( empty( $header_textcolor ) ) {
		return;
	} else {
		return "\n" . <<<CSS
/* Header Text Color */
.navbar-heading,
.navbar.is-transparent.is-scrolled .navbar-heading,
.navbar-caption,
.navbar.is-transparent.is-scrolled .navbar-caption,
.navbar-link,
.navbar.is-transparent.is-scrolled .navbar-link.top,
.navbar .card a,
.navbar-search-icon:hover,
.navbar-search-icon:focus,
.navbar.is-transparent .navbar-search-icon:hover,
.navbar.is-transparent .navbar-search-icon:focus,
.navbar.is-transparent.is-scrolled .navbar-search-icon:hover,
.navbar.is-transparent.is-scrolled .navbar-search-icon:focus {
	color: {$header_textcolor};
}
.navbar-link:hover,
.navbar-link:focus,
.navbar .card a:hover,
.navbar .card a:focus,
.navbar-item:hover .navbar-heading,
.navbar-item:focus .navbar-heading,
.navbar.is-transparent.is-scrolled .navbar-item:hover .navbar-heading,
.navbar.is-transparent.is-scrolled .navbar-item:focus .navbar-heading,
.navbar.is-transparent .navbar-link.top:hover,
.navbar.is-transparent .navbar-link.top:focus {
	color: {$header_textcolor2};
}
.navbar-button:hover,
.navbar-button:focus,
.navbar.is-transparent .navbar-button:hover,
.navbar.is-transparent .navbar-button:focus,
.navbar.is-transparent.is-scrolled .navbar-button:hover,
.navbar.is-transparent.is-scrolled .navbar-button:focus {
	background: {$header_textcolor};
	border: 1.2px solid {$header_textcolor};
}
.navbar-menu {
	border-top: 2px solid {$header_textcolor};
}
@media only screen and (min-width: 1024px) {
	.navbar-menu {
		border-top: none;
	}
	.navbar-dropdown {
		border-top: 2px solid {$header_textcolor};
	}
}
CSS;
	}
}

/**
 * Get the css for the hero_textcolor option.
 */
function treviso_get_hero_textcolor_css() {
	$hero_textcolor = sanitize_hex_color( get_theme_mod( 'hero_textcolor' ) );

	if ( empty( $hero_textcolor ) || '#ffffff' === $hero_textcolor ) {
		return;
	}

	return PHP_EOL . <<<CSS
/* Hero Text Color */
.hero.has-bg .title,
.hero.has-bg .subtitle {
	color: {$hero_textcolor};
}
CSS;
}

/**
 * Get the css for the sidebar_bgcolor option.
 */
function treviso_get_sidebar_bgcolor_css() {
	$sidebar_bgcolor  = sanitize_hex_color( get_theme_mod( 'sidebar_bgcolor' ) );
	$sidebar_bgcolor2 = treviso_adjust_brightness( $sidebar_bgcolor, -0.2 );

	if ( empty( $sidebar_bgcolor ) || '#f8f6f6' === $sidebar_bgcolor ) {
		return;
	}

	return PHP_EOL . <<<CSS
/* Sidebar Background Color */
.sidebar .widget:nth-child(odd) {
	background: {$sidebar_bgcolor};
	border: 1px solid {$sidebar_bgcolor2};
}
.sidebar .widget:nth-child(even) {
	border: 1px solid {$sidebar_bgcolor2};
}
CSS;
}

/**
 * Get the css for the content_primarycolor option.
 */
function treviso_get_content_primarycolor_css() {
	$content_primarycolor = sanitize_hex_color( get_theme_mod( 'content_primarycolor' ) );

	if ( empty( $content_primarycolor ) || '#0045cf' === $content_primarycolor ) {
		return;
	}

	return PHP_EOL . <<<CSS
/* Content Primary Color */
.site-main a,
.sidebar a,
.card .card-header-title {
	color: {$content_primarycolor};
}

.site-main a:hover,
.sidebar a:hover {
	color: #4a4a4a;
}

.site-main .button,
.site-main .tag,
.hero .tag,
.sidebar .button,
.sidebar .tag {
	background: {$content_primarycolor};
	color: white;
}

.site-main .button:hover,
.site-main .tag:hover,
.sidebar .button:hover,
.sidebar .tag:hover {
	background: #363636;
	color: #ffffff;
}

.card .ribbon,
.site-main .pagination-link.is-current {
	background: {$content_primarycolor};
	border-color: {$content_primarycolor};
	color: white;
}
CSS;
}

/**
 * Get the css for the footer_bgcolor option.
 */
function treviso_get_footer_bgcolor_css() {
	$footer_bgcolor = sanitize_hex_color( get_theme_mod( 'footer_bgcolor' ) );
	
	if ( empty( $footer_bgcolor ) || '#0045cf' === $footer_bgcolor ) {
		return;
	}

	$footer_bgcolor2 = treviso_adjust_brightness( $footer_bgcolor, 0.3 );
	$footer_bgcolor3 = treviso_adjust_brightness( $footer_bgcolor, 0.5 );

	return PHP_EOL . <<<CSS
/* Footer Background Color */
.site-footer {
	background: linear-gradient(to top right, {$footer_bgcolor}, {$footer_bgcolor2});
}
.site-footer .socials .social:hover i {
	color: {$footer_bgcolor};
}
.site-footer .footer-link:active, .site-footer .footer-link:hover,
.site-footer .copyright .footer-menu li a:hover {
	color: {$footer_bgcolor3};
}
CSS;
}

/**
 * Get the css for the footer_textcolor option.
 */
function treviso_get_footer_textcolor_css() {
	$footer_textcolor = sanitize_hex_color( get_theme_mod( 'footer_textcolor' ) );

	if ( empty( $footer_textcolor ) || '#fcfcfc' === $footer_textcolor ) {
		return;
	}

	return PHP_EOL . <<<CSS
/* Footer Text Color */
.site-footer .title,
.site-footer .footer-link,
.site-footer .copyright .copyright-text,
.site-footer .copyright .footer-menu li a {
	color: {$footer_textcolor};
}
CSS;
}

/**
 * Get the css for the typography_bodyfontfamily option.
 */
function treviso_get_typography_bodyfontfamily_css() {
	$typography_bodyfontfamily = get_theme_mod( 'typography_bodyfontfamily' );

	if ( empty( $typography_bodyfontfamily ) ) {
		return;
	}
	$typography_bodyfontfamily = substr( $typography_bodyfontfamily, 0, strpos( $typography_bodyfontfamily, ':' ) );

	return PHP_EOL . <<<CSS
/* Body Font Family */
body, button, input, optgroup, select, textarea {
	font-family: {$typography_bodyfontfamily};
}
CSS;
}

/**
 * Get the css for the typography_bodyfontsize option.
 */
function treviso_get_typography_bodyfontsize_css() {
	$typography_bodyfontsize = get_theme_mod( 'typography_bodyfontsize' );

	if ( empty( $typography_bodyfontsize ) || '1em' === $typography_bodyfontsize ) {
		return;
	}

	return PHP_EOL . <<<CSS
/* Body Font Size */
body {
	font-size: {$typography_bodyfontsize};
}
CSS;
}

/**
 * Get the css for the typography_bodyfontweight option.
 */
function treviso_get_typography_bodyfontweight_css() {
	$typography_bodyfontweight = get_theme_mod( 'typography_bodyfontweight' );

	if ( empty( $typography_bodyfontweight ) || '400' === $typography_bodyfontweight ) {
		return;
	}

	return PHP_EOL . <<<CSS
/* Body Font Weight */
body {
	font-weight: {$typography_bodyfontweight};
}
CSS;
}

/**
 * Get the css for the typography_bodyfontstyle option.
 */
function treviso_get_typography_bodyfontstyle_css() {
	$typography_bodyfontstyle = get_theme_mod( 'typography_bodyfontstyle' );

	if ( empty( $typography_bodyfontstyle ) || 'normal' === $typography_bodyfontstyle ) {
		return;
	}

	return PHP_EOL . <<<CSS
/* Body Font Style */
body {
	font-style: {$typography_bodyfontstyle};
}
CSS;
}

/**
 * Get the css for the typography_headerfontfamily option.
 */
function treviso_get_typography_headerfontfamily_css() {
	$typography_headerfontfamily = get_theme_mod( 'typography_headerfontfamily' );

	if ( empty( $typography_headerfontfamily ) ) {
		return;
	}
	$typography_headerfontfamily = substr( $typography_headerfontfamily, 0, strpos( $typography_headerfontfamily, ':' ) );

	return PHP_EOL . <<<CSS
/* Header Font Family */
.title, h1, h2, h3, h4, h5, h6 {
	font-family: {$typography_headerfontfamily};
}
CSS;
}

/**
 * Get the css for the typography_headerfontsize option.
 */
function treviso_get_typography_headerfontsize_css() {
	$typography_headerfontsize = get_theme_mod( 'typography_headerfontsize' );

	if ( empty( $typography_headerfontsize ) || '1em' === $typography_headerfontsize ) {
		return;
	}

	return PHP_EOL . <<<CSS
/* Header Font Size */
.title, h1, h2, h3, h4, h5, h6 {
	font-size: {$typography_headerfontsize};
}
CSS;
}

/**
 * Get the css for the typography_headerfontweight option.
 */
function treviso_get_typography_headerfontweight_css() {
	$typography_headerfontweight = get_theme_mod( 'typography_headerfontweight' );

	if ( empty( $typography_headerfontweight ) || '700' === $typography_headerfontweight ) {
		return;
	}

	return PHP_EOL . <<<CSS
/* Header Font Weight */
.title, h1, h2, h3, h4, h5, h6 {
	font-weight: {$typography_headerfontweight};
}
CSS;
}

/**
 * Get the css for the typography_headerfontstyle option.
 */
function treviso_get_typography_headerfontstyle_css() {
	$typography_headerfontstyle = get_theme_mod( 'typography_headerfontstyle' );

	if ( empty( $typography_headerfontstyle ) || 'normal' === $typography_headerfontstyle ) {
		return;
	}

	return PHP_EOL . <<<CSS
/* Header Font Style */
.title, h1, h2, h3, h4, h5, h6 {
	font-style: {$typography_headerfontstyle};
}
CSS;
}

/**
 * Sanitize the values of a select control.
 *
 * @param string $input Input to be sanitized.
 * @param object $setting The setting being referred to.
 * @return array The cleaned input.
 */
function treviso_sanitize_select( $input, $setting ) {
	$input   = sanitize_key( $input );
	$choices = $setting->manager->get_control( $setting->id )->choices;
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Sanitize the values of a multiple select control.
 *
 * @param string $input Input to be sanitized.
 * @param object $setting The setting being referred to.
 * @return array The cleaned input.
 */
function treviso_sanitize_multiple_select( $input, $setting ) {
	$choices = $setting->manager->get_control( $setting->id )->choices;
	$values  = array();

	foreach ( $input as $value ) {
		$value = sanitize_key( $value );
		if ( array_key_exists( $value, $choices ) ) {
			$values[] = $value;
		}
	}
	return $values;
}

/**
 * Sanitize the values of a checkbox control.
 *
 * @param string $input Input to be sanitized.
 * @return array The cleaned input.
 */
function treviso_sanitize_checkbox( $input ) {
	return ( 1 === absint( $input ) ) ? true : false;
}

/**
 * Sanitize the values of a multiple checkbox control.
 *
 * @param string $input Input to be sanitized.
 * @param object $setting The setting being referred to.
 * @return array The cleaned input.
 */
function treviso_sanitize_multiple_checkbox( $input, $setting ) {
	$choices = $setting->manager->get_control( $setting->id )->choices;
	$values  = array();

	foreach ( explode( ',', $input ) as $value ) {
		$value = sanitize_key( $value );
		if ( array_key_exists( $value, $choices ) ) {
			$values[] = $value;
		}
	}
	return $values;
}

/**
 * Sanitize the values of a google fonts select control.
 *
 * @param string $input Input to be sanitized.
 * @param object $setting The setting being referred to.
 * @return array The cleaned input.
 */
function treviso_sanitize_google_fonts_select( $input, $setting ) {
	$font  = esc_html( substr( $input, 0, strpos( $input, ':' ) ) );
	$fonts = $setting->manager->get_control( $setting->id )->fonts;

	foreach ( $fonts as $k => $v ) {
		if ( $v->family === $font ) {
			return $input;
		}
	}
	return $setting->default;
}
