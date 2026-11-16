<?php
/**
 * Sageus Theme Customizer Controls
 *
 * @package Sageus
 */

/**
 * Class for dropdown pages control with column selection
 */
class Sageus_Customizer_Dropdown_Pages_Control extends WP_Customize_Control {
	public $type = 'dropdown-pages';
	public $allow_addition = false;

	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
		$this->allow_addition = isset( $args['allow_addition'] ) ? $args['allow_addition'] : false;
	}

	public function render_content() {
		$dropdown = wp_dropdown_pages( array(
			'name'              => '_customize-dropdown-pages-' . $this->id,
			'echo'              => 0,
			'show_option_none'  => __( '&mdash; Select &mdash;', 'sageus' ),
			'option_none_value' => '0',
			'selected'          => $this->value(),
			'allow_addition'    => $this->allow_addition,
		) );

		// Hackily add in the data link parameter.
		$dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );

		printf(
			'<label class="customize-control-select">%s %s</label>',
			esc_html( $this->label ),
			$dropdown
		);

		if ( ! empty( $this->description ) ) {
			echo '<span class="description customize-control-description">' . esc_html( $this->description ) . '</span>';
		}
	}
}

/**
 * Class for radio image control
 */
class Sageus_Customizer_Radio_Image_Control extends WP_Customize_Control {
	public $type = 'radio-image';

	public function __construct( $manager, $id, $args = array() ) {
		parent::__construct( $manager, $id, $args );
		$this->choices = isset( $args['choices'] ) ? $args['choices'] : array();
	}

	public function render_content() {
		if ( empty( $this->choices ) ) {
			return;
		}

		$name = '_customize-radio-' . $this->id;

		?>
		<label class="customize-control-select">
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php if ( ! empty( $this->description ) ) : ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php endif; ?>
			<div class="sageus-radio-image-control">
				<?php foreach ( $this->choices as $value => $label ) : ?>
					<label class="sageus-radio-image-label">
						<input type="radio" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php $this->link(); ?> <?php checked( $this->value(), $value ); ?> />
						<img src="<?php echo esc_url( $label['image'] ); ?>" alt="<?php echo esc_attr( $label['name'] ); ?>" />
						<span><?php echo esc_html( $label['name'] ); ?></span>
					</label>
				<?php endforeach; ?>
			</div>
		</label>
		<?php
	}
}
