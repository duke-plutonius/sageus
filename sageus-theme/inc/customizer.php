<?php
/**
 * Sageus Theme Customizer
 *
 * @package Sageus
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function sageus_customize_register( $wp_customize ) {
	// Load customizer dependencies
	require_once SAGEUS_INC_DIR . '/customizer-controls.php';

	// Add Theme Options panel
	$wp_customize->add_panel( 'sageus_theme_options', array(
		'title'    => esc_html__( 'Theme Options', 'sageus-theme' ),
		'priority' => 120,
	) );

	// ============================================
	// Header Top Text Section
	// ============================================
	
	$wp_customize->add_section( 'sageus_header_top_text', array(
		'title'    => esc_html__( 'Header Top Text', 'sageus-theme' ),
		'priority' => 10,
		'panel'    => 'sageus_theme_options',
	) );

	// Header Top Text Left
	$wp_customize->add_setting( 'sageus_header_top_text_left', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'sageus_header_top_text_left', array(
		'label'       => esc_html__( 'Left Text', 'sageus-theme' ),
		'description' => esc_html__( 'HTML is allowed. This text appears on the left side of the header.', 'sageus-theme' ),
		'section'     => 'sageus_header_top_text',
		'type'        => 'textarea',
	) );

	// Header Top Text Right
	$wp_customize->add_setting( 'sageus_header_top_text_right', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'sageus_header_top_text_right', array(
		'label'       => esc_html__( 'Right Text', 'sageus-theme' ),
		'description' => esc_html__( 'HTML is allowed. This text appears on the right side of the header.', 'sageus-theme' ),
		'section'     => 'sageus_header_top_text',
		'type'        => 'textarea',
	) );

	// ============================================
	// Front Page Panels Section
	// ============================================
	
	$wp_customize->add_section( 'sageus_front_page_panels', array(
		'title'       => esc_html__( 'Front Page Panels', 'sageus-theme' ),
		'description' => esc_html__( 'Select pages to display as panels on the static front page. The first panel is the hero section.', 'sageus-theme' ),
		'priority'    => 20,
		'panel'       => 'sageus_theme_options',
	) );

	// Panel 1
	$wp_customize->add_setting( 'sageus_panel_page_1', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'sageus_panel_page_1', array(
		'label'       => esc_html__( 'Panel 1 (Hero)', 'sageus-theme' ),
		'description' => esc_html__( 'Select a page for the hero section. This page should have a featured image.', 'sageus-theme' ),
		'section'     => 'sageus_front_page_panels',
		'type'        => 'dropdown-pages',
		'allow_addition' => false,
	) );

	$wp_customize->add_setting( 'sageus_panel_column_1', array(
		'default'           => 'one',
		'sanitize_callback' => 'sageus_sanitize_panel_column',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'sageus_panel_column_1', array(
		'label'   => esc_html__( 'Panel 1 Layout', 'sageus-theme' ),
		'section' => 'sageus_front_page_panels',
		'type'    => 'select',
		'choices' => array(
			'one'   => esc_html__( 'One Column', 'sageus-theme' ),
			'two'   => esc_html__( 'Two Columns', 'sageus-theme' ),
		),
	) );

	// Panel 2
	$wp_customize->add_setting( 'sageus_panel_page_2', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'sageus_panel_page_2', array(
		'label'       => esc_html__( 'Panel 2', 'sageus-theme' ),
		'description' => esc_html__( 'Select a page for the second panel.', 'sageus-theme' ),
		'section'     => 'sageus_front_page_panels',
		'type'        => 'dropdown-pages',
		'allow_addition' => false,
	) );

	$wp_customize->add_setting( 'sageus_panel_column_2', array(
		'default'           => 'one',
		'sanitize_callback' => 'sageus_sanitize_panel_column',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'sageus_panel_column_2', array(
		'label'   => esc_html__( 'Panel 2 Layout', 'sageus-theme' ),
		'section' => 'sageus_front_page_panels',
		'type'    => 'select',
		'choices' => array(
			'one'   => esc_html__( 'One Column', 'sageus-theme' ),
			'two'   => esc_html__( 'Two Columns', 'sageus-theme' ),
		),
	) );

	// Panel 3
	$wp_customize->add_setting( 'sageus_panel_page_3', array(
		'default'           => 0,
		'sanitize_callback' => 'absint',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'sageus_panel_page_3', array(
		'label'       => esc_html__( 'Panel 3', 'sageus-theme' ),
		'description' => esc_html__( 'Select a page for the third panel.', 'sageus-theme' ),
		'section'     => 'sageus_front_page_panels',
		'type'        => 'dropdown-pages',
		'allow_addition' => false,
	) );

	$wp_customize->add_setting( 'sageus_panel_column_3', array(
		'default'           => 'one',
		'sanitize_callback' => 'sageus_sanitize_panel_column',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'sageus_panel_column_3', array(
		'label'   => esc_html__( 'Panel 3 Layout', 'sageus-theme' ),
		'section' => 'sageus_front_page_panels',
		'type'    => 'select',
		'choices' => array(
			'one'   => esc_html__( 'One Column', 'sageus-theme' ),
			'two'   => esc_html__( 'Two Columns', 'sageus-theme' ),
		),
	) );

	// ============================================
	// Footer Image Section
	// ============================================
	
	$wp_customize->add_section( 'sageus_footer_image', array(
		'title'       => esc_html__( 'Footer Image', 'sageus-theme' ),
		'description' => esc_html__( 'Upload an image to display as a full-width footer image on the front page.', 'sageus-theme' ),
		'priority'    => 30,
		'panel'       => 'sageus_theme_options',
	) );

	$wp_customize->add_setting( 'sageus_footer_image', array(
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sageus_footer_image', array(
		'label'       => esc_html__( 'Footer Image', 'sageus-theme' ),
		'description' => esc_html__( 'Recommended size: 2000x1200 pixels', 'sageus-theme' ),
		'section'     => 'sageus_footer_image',
		'settings'    => 'sageus_footer_image',
	) ) );

	// ============================================
	// Custom Colors Section
	// ============================================
	
	$wp_customize->add_section( 'sageus_custom_colors', array(
		'title'       => esc_html__( 'Custom Colors', 'sageus-theme' ),
		'priority'    => 40,
		'panel'       => 'sageus_theme_options',
	) );

	// Primary Color
	$wp_customize->add_setting( 'sageus_primary_color', array(
		'default'           => '#222222',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sageus_primary_color', array(
		'label'   => esc_html__( 'Primary Color', 'sageus-theme' ),
		'section' => 'sageus_custom_colors',
	) ) );

	// Secondary Color
	$wp_customize->add_setting( 'sageus_secondary_color', array(
		'default'           => '#0066cc',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sageus_secondary_color', array(
		'label'   => esc_html__( 'Secondary Color', 'sageus-theme' ),
		'section' => 'sageus_custom_colors',
	) ) );

	// Text Color
	$wp_customize->add_setting( 'sageus_text_color', array(
		'default'           => '#333333',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sageus_text_color', array(
		'label'   => esc_html__( 'Text Color', 'sageus-theme' ),
		'section' => 'sageus_custom_colors',
	) ) );

	// Link Color
	$wp_customize->add_setting( 'sageus_link_color', array(
		'default'           => '#0066cc',
		'sanitize_callback' => 'sanitize_hex_color',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sageus_link_color', array(
		'label'   => esc_html__( 'Link Color', 'sageus-theme' ),
		'section' => 'sageus_custom_colors',
	) ) );

	// ============================================
	// Custom Fonts Section
	// ============================================
	
	$wp_customize->add_section( 'sageus_custom_fonts', array(
		'title'       => esc_html__( 'Custom Fonts', 'sageus-theme' ),
		'priority'    => 50,
		'panel'       => 'sageus_theme_options',
	) );

	// Heading Font
	$wp_customize->add_setting( 'sageus_heading_font', array(
		'default'           => 'Montserrat',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'sageus_heading_font', array(
		'label'       => esc_html__( 'Heading Font', 'sageus-theme' ),
		'description' => esc_html__( 'Enter a Google Font name (e.g., Montserrat, Open Sans).', 'sageus-theme' ),
		'section'     => 'sageus_custom_fonts',
		'type'        => 'text',
	) );

	// Body Font
	$wp_customize->add_setting( 'sageus_body_font', array(
		'default'           => 'Open Sans',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	) );

	$wp_customize->add_control( 'sageus_body_font', array(
		'label'       => esc_html__( 'Body Font', 'sageus-theme' ),
		'description' => esc_html__( 'Enter a Google Font name (e.g., Montserrat, Open Sans).', 'sageus-theme' ),
		'section'     => 'sageus_custom_fonts',
		'type'        => 'text',
	) );

	// ============================================
	// Modify existing sections
	// ============================================
	
	// Modify the Site Identity section
	$wp_customize->get_section( 'title_tagline' )->priority = 5;
	$wp_customize->get_section( 'title_tagline' )->panel = 'sageus_theme_options';

	// Modify the Colors section
	$wp_customize->get_section( 'colors' )->priority = 35;
	$wp_customize->get_section( 'colors' )->panel = 'sageus_theme_options';

	// Modify the Background Image section
	$wp_customize->get_section( 'background_image' )->priority = 45;
	$wp_customize->get_section( 'background_image' )->panel = 'sageus_theme_options';

	// Modify the Header Image section
	$wp_customize->get_section( 'header_image' )->priority = 25;
	$wp_customize->get_section( 'header_image' )->panel = 'sageus_theme_options';

	// Modify the Menus section
	$wp_customize->get_section( 'nav' )->priority = 15;
	$wp_customize->get_section( 'nav' )->panel = 'sageus_theme_options';

	// Modify the Widgets section
	$wp_customize->get_section( 'widgets' )->priority = 55;
	$wp_customize->get_section( 'widgets' )->panel = 'sageus_theme_options';

	// Modify the Static Front Page section
	$wp_customize->get_section( 'static_front_page' )->priority = 5;
	$wp_customize->get_section( 'static_front_page' )->panel = 'sageus_theme_options';
}
add_action( 'customize_register', 'sageus_customize_register' );

/**
 * Sanitize panel column selection
 */
function sageus_sanitize_panel_column( $value ) {
	$valid = array( 'one', 'two' );
	if ( in_array( $value, $valid, true ) ) {
		return $value;
	}
	return 'one';
}

/**
 * Generate CSS for customizer settings
 */
function sageus_customizer_css() {
	$css = '';

	// Header Top Text
	$header_top_text_left  = get_theme_mod( 'sageus_header_top_text_left', '' );
	$header_top_text_right = get_theme_mod( 'sageus_header_top_text_right', '' );

	// Custom Colors
	$primary_color = get_theme_mod( 'sageus_primary_color', '#222222' );
	$secondary_color = get_theme_mod( 'sageus_secondary_color', '#0066cc' );
	$text_color = get_theme_mod( 'sageus_text_color', '#333333' );
	$link_color = get_theme_mod( 'sageus_link_color', '#0066cc' );

	// Custom Fonts
	$heading_font = get_theme_mod( 'sageus_heading_font', 'Montserrat' );
	$body_font = get_theme_mod( 'sageus_body_font', 'Open Sans' );

	// Generate CSS
	$css .= "/* Custom Colors */\n";
	$css .= "body { color: {$text_color}; }\n";
	$css .= "a { color: {$link_color}; }\n";
	$css .= ".site-title a, .site-title { color: {$primary_color}; }\n";
	$css .= ".main-navigation a:hover, .main-navigation .current-menu-item > a { background-color: {$primary_color}; }\n";
	$css .= ".pagination a:hover, .pagination .current { background-color: {$primary_color}; }\n";
	$css .= ".comment-form .submit { background-color: {$primary_color}; }\n";

	$css .= "/* Custom Fonts */\n";
	$css .= "body, .entry-content, .widget { font-family: '{$body_font}', sans-serif; }\n";
	$css .= ".site-title, .site-description, h1, h2, h3, h4, h5, h6, .widget-title, .main-navigation a, .panel-text h2, .portfolio-info h3 { font-family: '{$heading_font}', sans-serif; }\n";

	// Output the CSS
	wp_add_inline_style( 'sageus-theme-style', $css );
}
add_action( 'wp_enqueue_scripts', 'sageus_customizer_css' );

/**
 * Live preview for customizer settings
 */
function sageus_customizer_live_preview() {
	wp_enqueue_script( 'sageus-theme-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'jquery', 'customize-preview' ), SAGEUS_VERSION, true );
}
add_action( 'customize_preview_init', 'sageus_customizer_live_preview' );
