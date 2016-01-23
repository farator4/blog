<?php
/**
 * Add new fields to customizer, create panel 'Info'
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @since Jolene 1.1.0
 */
 
function jolene_customize_register_info( $wp_customize ) {

	class Jolene_Customize_Button_Control extends WP_Customize_Control {
		public $type = 'button';
	 
		/**
		 * Render the control's content.
		 *
		 * Allows the content to be overriden without having to rewrite the wrapper.
		 *
		 * @since Jolene 1.1.0
		 */
		public function render_content() {
			?>
			<form>
			<input type="button" value="<?php echo esc_attr( $this->label ); ?>" onclick="window.open('<?php echo esc_url( $this->value() ); ?>')" />
			</form>
			<?php
		}

	}	
	
	class Jolene_Customize_Donate_Control extends WP_Customize_Control {
		public $type = 'donate';
	 
		/**
		 * Render the control's content.
		 *
		 * Allows the content to be overriden without having to rewrite the wrapper.
		 *
		 * @since Jolene 1.1.0
		 */
		public function render_content() {
			?>
			<p>
			<?php
				_e( 'Jolene is a free software, both for personal and commercial use. Anyway, if you feel that this tool comes handy to you or your business, you can show your appreciation by donating something to the project. By donating, you show your interest in this product.', 'jolene' );
			?>
			</p>
			<form style="margin: 0 auto;display:block;width:100px;" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
			">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			</form>
			<?php
			_e( 'You will be transferred to PayPal secure site.', 'jolene' );

		}

	}

	$defaults = jolene_get_defaults();
	
	$wp_customize->add_panel( 'info', array(
		'priority'       => 0,
		'title'          => __( 'Info', 'jolene' ),
		'description'    => __( 'Info and Links.', 'jolene' ),
	) );

	$section_priority = 10;
	
//New section in customizer: Support
	$wp_customize->add_section( 'support', array(
		'title'          => __( 'Support', 'jolene' ),
		'description'          => __( 'Got something to say? Need help?', 'jolene' ),
		'priority'       => $section_priority++,
		'panel'  => 'info',
	) );
	
//Support button
	$wp_customize->add_setting( 'support_url', array(
		'type'			 => 'empty',
		'default'        => 'https://wordpress.org/support/theme/jolene',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_url'
	) );
	
	$wp_customize->add_control( new Jolene_Customize_Button_Control( $wp_customize, 'support_url', array(
		'label'   => __( 'View Support forum', 'jolene' ),
		'description'   => __( 'View Support forum', 'jolene' ),
		'section' => 'support',
		'settings'   => 'support_url',
		'priority'   => 10,
	) ) );
	
//New section in customizer: Rate
	$wp_customize->add_section( 'rate', array(
		'title'          => __( 'Rate on WordPress.org', 'jolene' ),
		'description'          => __( 'Add feedback for this theme.', 'jolene' ),
		'priority'       => $section_priority++,
		'panel'  => 'info',
	) );
	
// Rate button
	$wp_customize->add_setting( 'rate_url', array(
		'type'			 => 'empty',
		'default'        => 'https://wordpress.org/support/view/theme-reviews/jolene#postform',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_url'
	) );
	
	$wp_customize->add_control( new Jolene_Customize_Button_Control( $wp_customize, 'rate_url', array(
		'label'   => __( 'Rate', 'jolene' ),
		'description'   => __( 'Rate', 'jolene' ),
		'section' => 'rate',
		'settings'   => 'rate_url',
		'priority'   => 10,
	) ) );

	//New section in customizer: Doc Url
	$wp_customize->add_section( 'docs', array(
		'title'          => __( 'How to use a theme', 'jolene' ),
		'description'          => __( 'Documentation.', 'jolene' ),
		'priority'       => $section_priority++,
		'panel'  => 'info',
	) );
	
	$wp_customize->add_setting( 'doc_url', array(
		'type'			 => 'empty',
		'default'        => 'http://wpblogs.ru/themes/documentation-jolene-theme/',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_url'
	) );
	
	$wp_customize->add_control( new Jolene_Customize_Button_Control( $wp_customize, 'doc_url', array(
		'label'   => __( 'How to use a theme', 'jolene' ),
		'description'   => __( 'Theme Documentation', 'jolene' ),
		'section' => 'docs',
		'settings'   => 'doc_url',
		'priority'   => 10,
	) ) );
	
	$wp_customize->add_section( 'donate', array(
		'title'          => __( 'Donate', 'jolene' ),
		'priority'       => $section_priority++,
		'panel'  => 'info',
	) );
	
	$wp_customize->add_setting( 'donate', array(
		'type'			 => 'empty',
		'default'        => '',
		'sanitize_callback' => 'jolene_sanitize_url'
	) );
	
	$wp_customize->add_control( new Jolene_Customize_Donate_Control( $wp_customize, 'donate', array(
		'label'   => __( 'Donate', 'jolene' ),
		'description'   => __( 'Donate', 'jolene' ),
		'section' => 'donate',
		'settings'   => 'donate',
		'priority'   => 100,
	) ) );
}
add_action( 'customize_register', 'jolene_customize_register_info' );