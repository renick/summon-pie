<?php
/**
 * Custom multi-checkbox control for the WP Customizer. Based on the WordPress 
 * WP_Customize_Control. Class is not defined outside the customizer.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

if ( class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Setup the multi-checkbox customizer control.
	 */
	class Treviso_Customize_Multi_Checkbox extends WP_Customize_Control {
		/**
		 * The type of control being rendered.
		 * 
		 * @var string.
		 */
		public $type = 'treviso_multi_checkbox';

		/**
		 * Enqueue control styles and scripts.
		 */
		public function enqueue() {
			treviso_custom_controls_enqueue();
		}
	
		/**
		 * Render the control's content.
		 */
		protected function render_content() {
			$input_id         = '_customize-input-' . $this->id;
			$description_id   = '_customize-description-' . $this->id;
			$describedby_attr = ( ! empty( $this->description ) ) ? ' aria-describedby="' . esc_attr( $description_id ) . '" ' : '';
	
			if ( empty( $this->choices ) ) {
				return;
			}
	
			?>
			<?php if ( ! empty( $this->label ) ) : ?>
				<label for="<?php echo esc_attr( $input_id ); ?>" class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>
			<?php endif; ?>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span id="<?php echo esc_attr( $description_id ); ?>" class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>

			<?php $multi_values = ! is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); ?>

			<ul id="<?php echo esc_attr( $input_id ); ?>" <?php echo esc_attr( $describedby_attr ); ?>>
				<?php foreach ( $this->choices as $value => $label ) : ?>
				<li>
					<label>
						<input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values, true ) ); ?> /> 
						<?php echo esc_html( $label ); ?>
					</label>
				</li>
				<?php endforeach; ?>
			</ul>

			<input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>" />
			<?php
		}
	}
}
