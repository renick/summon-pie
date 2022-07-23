<?php
/**
 * Societas: Block Patterns
 *
 * @since Societas 1.0
 */

/**
 * Registers block patterns and categories.
 *
 * @return void
 * @since Societas 1.0
 *
 */
function societas_register_block_patterns() {
	$block_pattern_categories = array(
		'featured' => array( 'label' => __( 'Featured', 'societas' ) ),
		'footer'   => array( 'label' => __( 'Footers', 'societas' ) ),
		'header'   => array( 'label' => __( 'Headers', 'societas' ) ),
	);

	/**
	 * Filters the theme block pattern categories.
	 *
	 * @param array[] $block_pattern_categories {
	 *     An associative array of block pattern categories, keyed by category name.
	 *
	 * @type array[] $properties {
	 *         An array of block category properties.
	 *
	 * @type string $label A human-readable label for the pattern category.
	 *     }
	 * }
	 * @since Societas 1.0
	 *
	 */
	$block_pattern_categories = apply_filters( 'societas_block_pattern_categories', $block_pattern_categories );

	foreach ( $block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}

	$block_patterns = array(
		'footer-default',
		'header-default',
		'header-dark',
		'section-hero',
		'section-team',
		'section-icon-boxes',
		'section-services',
		'section-counter',
		'section-why-us',
		'section-team',
		'section-call-to-action',
		'section-icon-cards',
		'section-faq',
		'section-latest-posts'
	);

	/**
	 * Filters the theme block patterns.
	 *
	 * @param array $block_patterns List of block patterns by name.
	 *
	 * @since Societas 1.0
	 *
	 */
	$block_patterns = apply_filters( 'societas_block_patterns', $block_patterns );

	foreach ( $block_patterns as $block_pattern ) {

		$explode_pattern_names = explode( '-', $block_pattern );
		$pattern_path          = $explode_pattern_names[0] . 's';
		$pattern_file          = get_theme_file_path( '/inc/patterns/' . $pattern_path . '/' . $block_pattern . '.php' );

		register_block_pattern(
			'societas/' . $block_pattern,
			require $pattern_file
		);
	}
}

add_action( 'init', 'societas_register_block_patterns', 9 );
