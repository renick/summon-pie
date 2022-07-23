<?php
/**
 * Custom Google Fonts control for the WP Customizer. Based on the WordPress 
 * WP_Customize_Control. Class is not defined outside the customizer.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

if ( class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Setup the google fonts customizer control.
	 */
	class Treviso_Customize_Google_Fonts extends WP_Customize_Control {
		/**
		 * The type of control being rendered.
		 * 
		 * @var string.
		 */
		public $type = 'treviso_google_fonts';

		/**
		 * Array to hold all Google Fonts.
		 * 
		 * @var array.
		 */
		public $fonts = false;

		/**
		 * Enqueue control styles and scripts.
		 */
		public function enqueue() {
			treviso_custom_controls_enqueue();
		}

		/**
		 * Get the list of fonts from the json file.
		 * 
		 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
		 * @param string               $id Control ID.
		 * @param array                $args Arguements.
		 */
		public function __construct( $manager, $id, $args = array() ) {
			parent::__construct( $manager, $id, $args );

			$this->fonts = $this->treviso_get_fonts();
		}
	
		/**
		 * Render the control's content.
		 */
		protected function render_content() {
			$input_id         = '_customize-input-' . $this->id;
			$description_id   = '_customize-description-' . $this->id;
			$describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';
	
			?>
			<?php if ( ! empty( $this->label ) ) : ?>
				<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>

			<select id="<?php echo esc_attr( $input_id ); ?>" <?php echo esc_attr( $describedby_attr ); ?> class="font-select" <?php $this->link(); ?>>
				<?php
				foreach ( $this->fonts as $k => $v ) {
					$font = $v->family . ':' . implode( ',', $v->variants );
					printf(
						'<option value="%s" %s>%s</option>',
						esc_attr( $font ),
						selected( $this->value(), $font, false ),
						esc_html( $v->family )
					);
				}
				?>
			</select>
			<?php
		}

		/**
		 * Get the list of Google Fonts from a json file.
		 * 
		 * @return array The deserialized Google fonts.
		 */
		public function treviso_get_fonts() {
			$font_file = get_template_directory_uri() . '/inc/google-fonts.json';

			$request = wp_remote_get( $font_file );
			if ( is_wp_error( $request ) ) {
				return '';
			}

			$content = json_decode( wp_remote_retrieve_body( $request ) );
			return $content->items;
		}
	}
}
