<?php
/**
 * Elementor hooks to enhance page builder experience with Treviso.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

// If Elementor plugin does not exist then return.
if ( ! class_exists( '\Elementor\Plugin' ) ) {
	exit;
}

/**
 * Add Treviso custom page template hero section controls.
 *
 * @param \Elementor\Core\DocumentTypes\PageBase $page The elementor page.
 */
function treviso_elementor_page_hero_section_controls( \Elementor\Core\DocumentTypes\PageBase $page ) {
	$page->start_controls_section(
		'hero_section_section',
		array(
			'label'     => esc_html__( 'Hero Section', 'treviso' ),
			'tab'       => \Elementor\Controls_Manager::TAB_SETTINGS,
			'condition' => array(
				'template' => array( 'default' ),
			),
		)
	);

	$page->add_responsive_control(
		'hero_section_title_align',
		array(
			'label'     => esc_html__( 'Alignment', 'treviso' ),
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'options'   => array(
				'left'    => array(
					'title' => esc_html__( 'Left', 'treviso' ),
					'icon'  => 'eicon-text-align-left',
				),
				'center'  => array(
					'title' => esc_html__( 'Center', 'treviso' ),
					'icon'  => 'eicon-text-align-center',
				),
				'right'   => array(
					'title' => esc_html__( 'Right', 'treviso' ),
					'icon'  => 'eicon-text-align-right',
				),
				'justify' => array(
					'title' => esc_html__( 'Justified', 'treviso' ),
					'icon'  => 'eicon-text-align-justify',
				),
			),
			'condition' => array(
				'template' => array( 'default' ),
			),
			'selectors' => array(
				'{{WRAPPER}} .hero .title'    => 'text-align: {{VALUE}};',
				'{{WRAPPER}} .hero .subtitle' => 'text-align: {{VALUE}};',
			),
		)
	);

	$page->end_controls_section();

}
add_action( 'elementor/element/wp-post/document_settings/after_section_end', 'treviso_elementor_page_hero_section_controls', 10, 2 );

/**
 * Add Treviso custom style hero section controls.
 *
 * @param \Elementor\Core\DocumentTypes\PageBase $page The elementor page.
 */
function treviso_elementor_page_hero_section_styles( \Elementor\Core\DocumentTypes\PageBase $page ) {
	$page->start_controls_section(
		'hero_section_styles',
		array(
			'label'     => esc_html__( 'Hero Section', 'treviso' ),
			'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => array(
				'template' => array( 'default', 'theme' ),
			),
		)
	);

	$page->add_control(
		'hero_section_title_color',
		array(
			'label'     => esc_html__( 'Text Color', 'treviso' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => array( '{{WRAPPER}} .hero .title' => 'color: {{VALUE}};' ),
		)
	);

	$page->add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		array(
			'name'     => 'hero_section_title_typography',
			'selector' => '{{WRAPPER}} .hero .title',
		)
	);

	$page->add_group_control(
		\Elementor\Group_Control_Text_Shadow::get_type(),
		array(
			'name'     => 'hero_section_title_text_shadow',
			'selector' => '{{WRAPPER}} .hero .title',
		)
	);

	$page->end_controls_section();
}
add_action( 'elementor/element/wp-post/document_settings/after_section_end', 'treviso_elementor_page_hero_section_styles', 10, 2 );
