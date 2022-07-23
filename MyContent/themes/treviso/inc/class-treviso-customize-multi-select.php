<?php
/**
 * Custom multi-select control for the WP Customizer. Based on the WordPress 
 * WP_Customize_Control. Class is not defined outside the customizer.
 *
 * @package     Treviso
 * @author      JB Software
 * @copyright   2021 JB Software
 * @license     GPL-2.0-or-later
 */

if ( class_exists( 'WP_Customize_Control' ) ) {
	/**
	 * Setup the multi-select customizer control.
	 */
	class Treviso_Customize_Multi_Select extends WP_Customize_Control {
		/**
		 * The type of control being rendered.
		 * 
		 * @var string.
		 */
		public $type = 'treviso_multi_select';

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

			<select id="<?php echo esc_attr( $input_id ); ?>" <?php echo esc_attr( $describedby_attr ); ?> <?php $this->link(); ?> multiple="multiple" style="width: 100%">
				<?php
				if ( is_array( $this->value() ) ) {
					// For select2 to maintain order from db unselected options must be printed 
					// first followed by the ordered options from the db.
					foreach ( $this->choices as $value => $label ) {
						if ( in_array( $value, $this->value(), true ) ) {
							continue;
						}
						echo '<option value="' . esc_attr( $value ) . '">' . esc_html( $label ) . '</option>';
					}
					foreach ( $this->value() as $v ) {
						foreach ( $this->choices as $value => $label ) {
							if ( $v === $value ) {
								echo '<option value="' . esc_attr( $value ) . '" selected="selected">' . esc_html( $label ) . '</option>';
							}
						}
					}
				} else {
					foreach ( $this->choices as $value => $label ) {
						echo '<option value="' . esc_attr( $value ) . '">' . esc_html( $label ) . '</option>';
					}
				}
				?>
			</select>
			<?php
		}
	}
}
