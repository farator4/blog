<?php
/**
 * Add new fields to customizer and register postMessage support for site title and description for the Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @since Jolene 1.0
 */

function jolene_customize_register( $wp_customize ) {

	$defaults = jolene_get_defaults();
		
	
	$wp_customize->add_panel( 'sidebars', array(
		'priority'       => 10,
		'title'          => __( 'Customize Sidebars', 'jolene' ),
		'description'    => __( 'Custom sidebars', 'jolene' ),
	) );
	
//New section in customizer: Mobile
	$wp_customize->add_section( 'jolene_mobile', array(
		'title'          => __( 'Settings for Mobile', 'jolene' ),
		'description'          => __( 'For small screens', 'jolene' ),
		'priority'       => 5,
		'panel'       => 'sidebars',
	) );
	
	$wp_customize->add_setting( 'is_has_mobile_sidebar', array(
		'default'        => $defaults['is_has_mobile_sidebar'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_checkbox'
	) );
	
	$wp_customize->add_control( 'is_has_mobile_sidebar', array(
		'label'      => __( 'Activate sidebars, visible on small screens only (at "Appearance >> Widgets")', 'jolene' ),
		'section'    => 'jolene_mobile',
		'settings'   => 'is_has_mobile_sidebar',
		'type'       => 'checkbox',
		'priority'       => 1,
	) );
//New section in customizer: Shop
	$wp_customize->add_section( 'jolene_shop', array(
		'title'          => __( 'Settings for the Shop', 'jolene' ),
		'description'          => __( 'WooCommerce plugin pages', 'jolene' ),
		'priority'       => 5,
		'panel'       => 'sidebars',

	) );
	
	$wp_customize->add_setting( 'is_has_shop_sidebar', array(
		'default'        => $defaults['is_has_shop_sidebar'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_checkbox'
	) );
	
	$wp_customize->add_control( 'is_has_shop_sidebar', array(
		'label'      => __( 'Activate sidebars, visible at WooCommerce pages', 'jolene' ),
		'section'    => 'jolene_shop',
		'settings'   => 'is_has_shop_sidebar',
		'type'       => 'checkbox',
		'priority'       => 1,
	) );
	

//New section in customizer: Featured Image
	$wp_customize->add_section( 'jolene_post_thumbnail', array(
		'title'          => __( 'Featured Image', 'jolene' ),
		'description'          => __( 'Type of Featured Image', 'jolene' ),
		'priority'       => 71,
	) );
	
//New setting in Featured Image section: Type
	$wp_customize->add_setting( 'post_thumbnail', array(
		'default'        => $defaults['post_thumbnail'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_post_thumbnail'
	) );
	
	$wp_customize->add_control( 'jolene_post_thumbnail_sidebar', array(
		'label'      => __( 'Select one', 'jolene' ),
		'section'    => 'jolene_post_thumbnail',
		'settings'   => 'post_thumbnail',
		'type'       => 'select',
		'priority'   => 1,
		'choices'	 => array ('large' => __( 'Large', 'jolene' ), 'big' => __( 'Big', 'jolene' ), 'small' => __( 'Small', 'jolene' ))
	) );
	
	$wp_customize->add_panel( 'main_colors', array(
		'priority'       => 10,
		'title'          => __( 'Customize Colors', 'jolene' ),
		'description'    => __( 'Custom colors', 'jolene' ),
	) );
	
	$wp_customize->get_section( 'colors' )->panel = 'main_colors';	
	$wp_customize->get_section( 'colors' )->priority = '2';	
	
//New section in customizer: Color Scheme
	$wp_customize->add_section( 'jolene_color_scheme', array(
		'title'          => __( 'Color Scheme ', 'jolene' ),
		'description'    => __( 'This option refresh theme colors.', 'jolene' ),
		'priority'       => 1,
		'panel' => 'main_colors',
	) );
	
//New setting in Featured Image section: Type
	$wp_customize->add_setting( 'color_scheme', array(
		'default'        => $defaults['color_scheme'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_color_scheme'
	) );
	
	$wp_customize->add_control( 'jolene_color_scheme', array(
		'label'      => __( 'Color Scheme', 'jolene' ),
		'section'    => 'jolene_color_scheme',
		'settings'   => 'color_scheme',
		'type'       => 'select',
		'priority'   => 1,
		'choices'	 => jolene_schemes(),
	) );
	

//New section in customizer: Content Width
	$wp_customize->add_section( 'jolene_content_width', array(
		'title'          => __( 'Content Width', 'jolene' ),
		'description'          => __( 'Number between 500 and 1349. ', 'jolene' ) . $defaults['content_width'] . __( 'px is default width.' , 'jolene' ),
		'priority'       => 100,
	) );
	
//New setting in Content Width section: Max Content Width No Sidebars
	$wp_customize->add_setting( 'content_width_no_sidebar', array(
		'default'        => $defaults['content_width'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_content_width'
	) );
	
	$wp_customize->add_control( 'jolene_content_width_no_sidebar', array(
		'label'      => __( 'Content Width while both sidebars are empty', 'jolene' ),
		'section'    => 'jolene_content_width',
		'settings'   => 'content_width_no_sidebar',
		'type'       => 'text',
		'priority'   => '1',
	) );
	
//New setting in Content Width section: Max Content Width Right Sidebar Is On (Number between 500 and 1349)
	$wp_customize->add_setting( 'content_width_right_sidebar', array(
		'default'        => $defaults['content_width'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_content_width'
	) );
	
	$wp_customize->add_control( 'jolene_content_width_right_sidebar', array(
		'label'      => __( 'Content Width while left sidebar is empty', 'jolene' ),
		'section'    => 'jolene_content_width',
		'settings'   => 'content_width_right_sidebar',
		'type'       => 'text',
		'priority'   => '2',
	) );
	
//New setting in Content Width section: Max Content Width Left Sidebar Is On
	$wp_customize->add_setting( 'content_width_left_sidebar', array(
		'default'        => $defaults['content_width'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_content_width'
	) );
	
	$wp_customize->add_control( 'jolene_content_width_left_sidebar', array(
		'label'      => __( 'Content Width while right sidebar is empty.', 'jolene' ),
		'section'    => 'jolene_content_width',
		'settings'   => 'content_width_left_sidebar',
		'type'       => 'text',
		'priority'   => '3',
	) );
	
//New setting in Content Width section: Max Content Width Left Sidebar Is On, Page
	$wp_customize->add_setting( 'content_width_left_sidebar_page', array(
		'default'        => $defaults['content_width_page'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_content_width'
	) );
	
	$wp_customize->add_control( 'jolene_content_width_left_sidebar_page', array(
		'label'      => __( 'Page Template Left Sidebar: Content Width', 'jolene' ),
		'section'    => 'jolene_content_width',
		'settings'   => 'content_width_left_sidebar_page',
		'type'       => 'text',
		'priority'   => '10',
	) );
	
//New setting in Content Width section: Max Content Width right Sidebar Is On, Page
	$wp_customize->add_setting( 'content_width_right_sidebar_page', array(
		'default'        => $defaults['content_width_page'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_content_width'
	) );
	
	$wp_customize->add_control( 'jolene_content_width_right_sidebar_page', array(
		'label'      => __( 'Page Template Right Sidebar: Content Width', 'jolene' ),
		'section'    => 'jolene_content_width',
		'settings'   => 'content_width_right_sidebar_page',
		'type'       => 'text',
		'priority'   => '11',
	) );
	
//New setting in Content Width section: Max Content Width No Sidebar, Page
	$wp_customize->add_setting( 'content_width_no_sidebar_page', array(
		'default'        => $defaults['content_width_no_sidebar_page'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_content_width'
	) );
	
	$wp_customize->add_control( 'jolene_content_width_no_sidebar_page', array(
		'label'      => __( 'Page Template Full Width: Content Width', 'jolene' ),
		'section'    => 'jolene_content_width',
		'settings'   => 'content_width_no_sidebar_page',
		'type'       => 'text',
		'priority'   => '12',
	) );
	
//New setting in Content Width section: Max Content Width No Sidebar, Page
	$wp_customize->add_setting( 'content_width_no_sidebar_wide_page', array(
		'default'        => $defaults['content_width_page_no_sidebar_wide'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_content_width'
	) );
	
	$wp_customize->add_control( 'jolene_content_width_no_sidebar_wide', array(
		'label'      => __( 'Page Template Full Width Wide: Content Width', 'jolene' ),
		'section'    => 'jolene_content_width',
		'settings'   => 'content_width_no_sidebar_wide_page',
		'type'       => 'text',
		'priority'   => '14',
	) );
	

//New section in customizer: Logotype
	$wp_customize->add_section( 'jolene_theme_logotype', array(
		'title'          => __( 'Logotype', 'jolene' ),
		'priority'       => 10,
	) );
	
//New setting in Logotype section: Logo Image
	$wp_customize->add_setting( 'logotype_url', array(
		'default'        => get_template_directory_uri().'/img/logo.png',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_url'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'logotype_url', array(
		'label'      => __('Logotype Image', 'jolene'),
		'section'    => 'jolene_theme_logotype',
		'settings'   => 'logotype_url',
		'priority'   => '1',
	) ) );
	
	jolene_create_social_icons_section( $wp_customize );
	

//New section in customizer: Navigation Options
	$wp_customize->add_section( 'jolene_nav_options', array(
		'title'          => __( 'Navigation menu settings', 'jolene' ),
		'priority'       => 81,
	) );	
	
//New setting in Navigation section: Switch On First Top Menu
	$wp_customize->add_setting( 'is_show_top_menu', array(
		'default'        => '1',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'jolene_is_show_top_menu', array(
		'label'      => __( 'Switch On First Top Menu', 'jolene' ),
		'section'    => 'jolene_nav_options',
		'settings'   => 'is_show_top_menu',
		'type'       => 'checkbox',
		'priority'       => 21,
	) );
	
//New setting in Navigation section: Switch On Second Top Menu
	$wp_customize->add_setting( 'is_show_secont_top_menu', array(
		'default'        => $defaults['is_show_secont_top_menu'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'jolene_is_show_secont_top_menu', array(
		'label'      => __( 'Switch On Second Top Menu', 'jolene' ),
		'section'    => 'jolene_nav_options',
		'settings'   => 'is_show_secont_top_menu',
		'type'       => 'checkbox',
		'priority'       => 22,
	) );
	
//New setting in Navigation section: Switch On Footer Menu
	$wp_customize->add_setting( 'is_show_footer_menu', array(
		'default'        => '1',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_checkbox'
	) );
	$wp_customize->add_control( 'jolene_is_show_footer_menu', array(
		'label'      => __( 'Switch On Footer Menu', 'jolene' ),
		'section'    => 'jolene_nav_options',
		'settings'   => 'is_show_footer_menu',
		'type'       => 'checkbox',
		'priority'       => 23,
	) );

// Add more color settings 
//link

	$def_colors = jolene_get_colors(get_theme_mod('color_scheme', $defaults['color_scheme']));
	
	$wp_customize->add_section( 'main_theme_colors', array(
		'title'          => __( 'Main colors', 'jolene' ),
		'description'    => __( 'Colors for elements.', 'jolene' ),
		'priority'       => 11,
		'panel' => 'main_colors',
	) );

	$wp_customize->add_setting( 'link_color', array(
		'default'        => $def_colors['link_color'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
		'label'   => __( 'Link Color', 'jolene' ),
		'section' => 'main_theme_colors',
		'settings'   => 'link_color',
		'priority'   => '11'
	) ) );
//heading
	$wp_customize->add_setting( 'heading_color', array(
		'default'        => $def_colors['heading_color'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'heading_color', array(
		'label'   => __( 'H1-H6 Color', 'jolene' ),
		'section' => 'main_theme_colors',
		'settings'   => 'heading_color',
		'priority'   => '12'
	) ) );
	

//description color
	$wp_customize->add_setting( 'description_color', array(
		'default'        => $def_colors['description_color'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'description_color', array(
		'label'   => __( 'Description Color', 'jolene' ),
		'section' => 'main_theme_colors',
		'settings'   => 'description_color',
		'priority'   => '5'
	) ) );
	
//hover color
	$wp_customize->add_setting( 'hover_color', array(
		'default'        => $def_colors['hover_color'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'hover_color', array(
		'label'   => __( 'Hover Color', 'jolene' ),
		'section' => 'main_theme_colors',
		'settings'   => 'hover_color',
		'priority'   => '14'
	) ) );

//Site Name Background
	$wp_customize->add_setting( 'site_name_back', array(
		'default'        => $def_colors['site_name_back'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'site_name_back', array(
		'label'   => __( 'Site Name Background Color', 'jolene' ),
		'section' => 'main_theme_colors',
		'settings'   => 'site_name_back',
		'priority'   => '14'
	) ) );
	
//shadow
	$wp_customize->add_setting( 'shadow_color', array(
		'default'        => $def_colors['border_shadow_color'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'shadow_color', array(
		'label'   => __( 'Shadow Color', 'jolene' ),
		'section' => 'main_theme_colors',
		'settings'   => 'shadow_color',
		'priority'   => '91'
	) ) );
	
// First Menu
	$wp_customize->add_section( 'first_menu', array(
		'title'          => __( 'First Menu', 'jolene' ),
		'priority'       => 21,
		'panel' => 'main_colors',
	) );
	$wp_customize->add_setting( 'menu1_color', array(
		'default'        => $def_colors['menu1_color'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu1_color', array(
		'label'   => __( 'First Menu Color', 'jolene' ),
		'section' => 'first_menu',
		'settings'   => 'menu1_color',
		'priority'   => '20'
	) ) );
	//link
	$wp_customize->add_setting( 'menu1_link', array(
		'default'        => $def_colors['menu1_link'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu1_link', array(
		'label'   => __( 'First Menu Link Color', 'jolene' ),
		'section' => 'first_menu',
		'settings'   => 'menu1_link',
		'priority'   => '21'
	) ) );
	//hover
	$wp_customize->add_setting( 'menu1_hover', array(
		'default'        => $def_colors['menu1_hover'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu1_hover', array(
		'label'   => __( 'First Menu Link Hover Color', 'jolene' ),
		'section' => 'first_menu',
		'settings'   => 'menu1_hover',
		'priority'   => '22'
	) ) );
	//hover background
	$wp_customize->add_setting( 'menu1_hover_back', array(
		'default'        => $def_colors['menu1_hover_back'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu1_hover_back', array(
		'label'   => __( 'First Menu Link Hover Background', 'jolene' ),
		'section' => 'first_menu',
		'settings'   => 'menu1_hover_back',
		'priority'   => '23'
	) ) );

// Second Menu
	$wp_customize->add_section( 'second_menu', array(
		'title'          => __( 'Second menu', 'jolene' ),
		'priority'       => 51,
		'panel' => 'main_colors',
	) );
	$wp_customize->add_setting( 'menu2_color', array(
		'default'        => $def_colors['menu2_color'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu2_color', array(
		'label'   => __( 'Second Menu Color', 'jolene' ),
		'section' => 'second_menu',
		'settings'   => 'menu2_color',
		'priority'   => '30'
	) ) );
	//link
	$wp_customize->add_setting( 'menu2_link', array(
		'default'        => $def_colors['menu2_link'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu2_link', array(
		'label'   => __( 'Second Menu Link Color', 'jolene' ),
		'section' => 'second_menu',
		'settings'   => 'menu2_link',
		'priority'   => '31'
	) ) );
	//hover
	$wp_customize->add_setting( 'menu2_hover', array(
		'default'        => $def_colors['menu2_hover'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu2_hover', array(
		'label'   => __( 'Second Menu Link Hover Color', 'jolene' ),
		'section' => 'second_menu',
		'settings'   => 'menu2_hover',
		'priority'   => '32'
	) ) );
	//hover background
	$wp_customize->add_setting( 'menu2_hover_back', array(
		'default'        => $def_colors['menu2_hover_back'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu2_hover_back', array(
		'label'   => __( 'Second Menu Link Hover Background', 'jolene' ),
		'section' => 'second_menu',
		'settings'   => 'menu2_hover_back',
		'priority'   => '33'
	) ) );
	
// Footer Menu
	$wp_customize->add_section( 'footer_menu', array(
		'title'          => __( 'Footer menu', 'jolene' ),
		'priority'       => 61,
		'panel' => 'main_colors',
	) );
	$wp_customize->add_setting( 'menu3_color', array(
		'default'        => $def_colors['menu3_color'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu3_color', array(
		'label'   => __( 'Footer Menu Color', 'jolene' ),
		'section' => 'footer_menu',
		'settings'   => 'menu3_color',
		'priority'   => '40'
	) ) );
	//link
	$wp_customize->add_setting( 'menu3_link', array(
		'default'        => $def_colors['menu3_link'] ,
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu3_link', array(
		'label'   => __( 'Footer Menu Link Color', 'jolene' ),
		'section' => 'footer_menu',
		'settings'   => 'menu3_link',
		'priority'   => '41'
	) ) );
	//hover
	$wp_customize->add_setting( 'menu3_hover', array(
		'default'        => $def_colors['menu3_hover'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu3_hover', array(
		'label'   => __( 'Footer Menu Link Hover Color', 'jolene' ),
		'section' => 'footer_menu',
		'settings'   => 'menu3_hover',
		'priority'   => '42'
	) ) );
	//hover background
	$wp_customize->add_setting( 'menu3_hover_back', array(
		'default'        => $def_colors['menu3_hover_back'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'menu3_hover_back', array(
		'label'   => __( 'Footer Menu Link Hover Background', 'jolene' ),
		'section' => 'footer_menu',
		'settings'   => 'menu3_hover_back',
		'priority'   => '43'
	) ) );
	
// Top Sidebar
	$wp_customize->add_section( 'top_sidebar', array(
		'title'          => __( 'Top sidebar', 'jolene' ),
		'priority'       => 81,
		'panel' => 'main_colors',
	) );
	$wp_customize->add_setting( 'sidebar1_color', array(
		'default'        => $def_colors['sidebar1_color'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar1_color', array(
		'label'   => __( 'Top Sidebar Color', 'jolene' ),
		'section' => 'top_sidebar',
		'settings'   => 'sidebar1_color',
		'priority'   => '50'
	) ) );
	//link
	$wp_customize->add_setting( 'sidebar1_link', array(
		'default'        => $def_colors['sidebar1_link'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar1_link', array(
		'label'   => __( 'Top Sidebar Link Color', 'jolene' ),
		'section' => 'top_sidebar',
		'settings'   => 'sidebar1_link',
		'priority'   => '51'
	) ) );
	//top link
	$wp_customize->add_setting( 'sidebar1_hover', array(
		'default'        => $def_colors['sidebar1_hover'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar1_hover', array(
		'label'   => __( 'Top Sidebar Link Hover Color', 'jolene' ),
		'section' => 'top_sidebar',
		'settings'   => 'sidebar1_hover',
		'priority'   => '52'
	) ) );
	//top text
	$wp_customize->add_setting( 'sidebar1_text', array(
		'default'        => $def_colors['sidebar1_text'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar1_text', array(
		'label'   => __( 'Top Sidebar Text Color', 'jolene' ),
		'section' => 'top_sidebar',
		'settings'   => 'sidebar1_text',
		'priority'   => '53'
	) ) );
	
// Footer Sidebar
	$wp_customize->add_section( 'footer_sidebar', array(
		'title'          => __( 'Footer sidebar', 'jolene' ),
		'priority'       => 91,
		'panel' => 'main_colors',
	) );
	$wp_customize->add_setting( 'sidebar2_color', array(
		'default'        => $def_colors['sidebar2_color'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar2_color', array(
		'label'   => __( 'Footer Sidebar Color', 'jolene' ),
		'section' => 'footer_sidebar',
		'settings'   => 'sidebar2_color',
		'priority'   => '60'
	) ) );
	//link
	$wp_customize->add_setting( 'sidebar2_link', array(
		'default'        => $def_colors['sidebar2_link'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar2_link', array(
		'label'   => __( 'Footer Sidebar Link Color', 'jolene' ),
		'section' => 'footer_sidebar',
		'settings'   => 'sidebar2_link',
		'priority'   => '61'
	) ) );

	//footer link
	$wp_customize->add_setting( 'sidebar2_hover', array(
		'default'        => $def_colors['sidebar2_hover'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar2_hover', array(
		'label'   => __( 'Footer Sidebar Link Hover Color', 'jolene' ),
		'section' => 'footer_sidebar',
		'settings'   => 'sidebar2_hover',
		'priority'   => '62'
	) ) );
	//footer text
	$wp_customize->add_setting( 'sidebar2_text', array(
		'default'        => $def_colors['sidebar2_text'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar2_text', array(
		'label'   => __( 'Footer Sidebar Text Color', 'jolene' ),
		'section' => 'footer_sidebar',
		'settings'   => 'sidebar2_text',
		'priority'   => '63'
	) ) );
	
// Column
	$wp_customize->add_section( 'column', array(
		'title'          => __( 'Columns', 'jolene' ),
		'priority'       => 111,
		'panel' => 'main_colors',
	) );
	
	//Column widget header color
	$wp_customize->add_setting( 'column_header_color', array(
		'default'        => $def_colors['column_header_color'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'column_header_color', array(
		'label'   => __( 'Column Widget Header Color', 'jolene' ),
		'section' => 'column',
		'settings'   => 'column_header_color',
		'priority'   => '70'
	) ) );
	
	//Column widget header text color
	$wp_customize->add_setting( 'column_header_text', array(
		'default'        => $def_colors['column_header_text'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'column_header_text', array(
		'label'   => __( 'Column Widget Header Text Color', 'jolene' ),
		'section' => 'column',
		'settings'   => 'column_header_text',
		'priority'   => '71'
	) ) );
	
//column widget background

	$wp_customize->add_setting( 'w1', array(
		'default'        => $def_colors['widget_back'],
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'w1', array(
		'label'   => __( 'Column Widget Background Color', 'jolene' ),
		'section' => 'column',
		'settings'   => 'w1',
		'priority'   => '1'
	) ) );
	
	$wp_customize->add_setting( 'sidebar3_color', array(
		'default'        => $def_colors['sidebar3_color'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar3_color', array(
		'label'   => __( 'Column Sidebar Color', 'jolene' ),
		'section' => 'column',
		'settings'   => 'sidebar3_color',
		'priority'   => '80'
	) ) );
	//link
	$wp_customize->add_setting( 'sidebar3_link', array(
		'default'        => $def_colors['sidebar3_link'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar3_link', array(
		'label'   => __( 'column Sidebar Link Color', 'jolene' ),
		'section' => 'column',
		'settings'   => 'sidebar3_link',
		'priority'   => '81'
	) ) );
	//column link
	$wp_customize->add_setting( 'sidebar3_hover', array(
		'default'        => $def_colors['sidebar3_hover'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar3_hover', array(
		'label'   => __( 'column Sidebar Link Hover Color', 'jolene' ),
		'section' => 'column',
		'settings'   => 'sidebar3_hover',
		'priority'   => '82'
	) ) );
	//column text
	$wp_customize->add_setting( 'sidebar3_text', array(
		'default'        => $def_colors['sidebar3_text'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'sidebar3_text', array(
		'label'   => __( 'Column Sidebar Text Color', 'jolene' ),
		'section' => 'column',
		'settings'   => 'sidebar3_text',
		'priority'   => '83'
	) ) );

//column background image
	$wp_customize->add_setting( 'column_background_url', array(
		'default'        => jolene_get_column_background(),
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_background_url'
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'column_background_url', array(
		'label'      => __('Columns Background', 'jolene'),
		'section'    => 'background_image',
		'settings'   => 'column_background_url',
		'priority'   => '1',
	) ) );
	
	//column border
	$wp_customize->add_setting( 'border_color', array(
		'default'        => $def_colors['border_color'],
		'transport'		 => 'postMessage',
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_hex_color'
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'border_color', array(
		'label'   => __( 'Sidebar Border Color', 'jolene' ),
		'section' => 'column',
		'settings'   => 'border_color',
		'priority'   => '90'
	) ) );
	

//New section in the customizer: Scroll To Top Button
	$wp_customize->add_section( 'jolene_scroll', array(
		'title'          => __( 'Scroll To Top Button', 'jolene' ),
		'priority'       => 101,
	) );
	
	$wp_customize->add_setting( 'scroll_button', array(
		'default'        => $defaults['scroll_button'],
		'capability'     => 'edit_theme_options',
		'transport'		 => 'refresh',
		'sanitize_callback' => 'jolene_sanitize_scroll_button'
	) );
	
	
	$wp_customize->add_control( 'scroll_button', array(
		'label'      => __( 'How to display the scroll to top button', 'jolene' ),
		'section'    => 'jolene_scroll',
		'settings'   => 'scroll_button',
		'type'       => 'select',
		'priority'   => 1,
		'choices'	 => array ('none' => __('None', 'jolene'),
								'right' => __('Right', 'jolene'), 
								'left' => __('Left', 'jolene'),
								'center' => __('Center', 'jolene'))
	) );
	
	$wp_customize->add_setting( 'scroll_animate', array(
		'default'        => $defaults['scroll_animate'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_scroll_effect'
	) );
	
	
	$wp_customize->add_control( 'scroll_animate', array(
		'label'      => __( 'How to animate the scroll to top button', 'jolene' ),
		'section'    => 'jolene_scroll',
		'settings'   => 'scroll_animate',
		'type'       => 'select',
		'priority'   => 1,
		'choices'	 => array ('none' => __('None', 'jolene'),
								'move' => __('Jump', 'jolene')), 
	) );
	
//New section in the customizer: Favicon
	$wp_customize->add_section( 'jolene_favicon', array(
		'title'          => __( 'Favicon', 'jolene' ),
		'description'    => __( 'You can select an Icon to be shown at the top of browser window by uploading from your computer. (Size: [16X16] px)', 'jolene' ),
		'priority'       => 121,
	) );
	
	$wp_customize->add_setting( 'favicon', array(
		'default'        => $defaults['favicon'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_url'
	) );
	
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,'favicon', array(
		'label'      => __('Favicon', 'jolene'),
		'section'    => 'jolene_favicon',
		'settings'   => 'favicon',
		'priority'   => '1',
	) ) );
	
	$wp_customize->add_setting( 'is_header_on_front_page_only', array(
		'default'        => $defaults['is_header_on_front_page_only'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_checkbox'
	) );
	

	$wp_customize->add_control( 'is_header_on_front_page_only', array(
		'label'      => __( 'Display Header Image on the Front Page only', 'jolene' ),
		'section'    => 'header_image',
		'settings'   => 'is_header_on_front_page_only',
		'type'       => 'checkbox',
		'priority'       => 40,
	) );	
	
	$wp_customize->add_setting( 'is_text_on_front_page_only', array(
		'default'        => $defaults['is_text_on_front_page_only'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_checkbox'
	) );
	

	$wp_customize->add_control( 'is_text_on_front_page_only', array(
		'label'      => __( 'Display Header Text on the Front Page only', 'jolene' ),
		'section'    => 'header_image',
		'settings'   => 'is_text_on_front_page_only',
		'type'       => 'checkbox',
		'priority'       => 41,
	) );
	
	$wp_customize->add_setting( 'is_second_menu_on_front_page_only', array(
		'default'        => $defaults['is_second_menu_on_front_page_only'],
		'capability'     => 'edit_theme_options',
		'sanitize_callback' => 'jolene_sanitize_checkbox'
	) );
	

	$wp_customize->add_control( 'is_second_menu_on_front_page_only', array(
		'label'      => __( 'Display Second Menu on the Front Page only', 'jolene' ),
		'section'    => 'jolene_nav_options',
		'settings'   => 'is_second_menu_on_front_page_only',
		'type'       => 'checkbox',
		'priority'       => 40,
	) );
	
//Sets postMessage support
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'jolene_customize_register' );
 
 /**
 * Add custom styles to the header.
 *
 * @since jolene 1.0
*/
function jolene_hook_css() {
	$defaults = jolene_get_defaults();
	$def_colors = jolene_get_colors(get_theme_mod('color_scheme', $defaults['color_scheme']));
?>

	<style type="text/css"> 
		/* Top Menu */

		.site-info-text-top,
		#top-1-navigation {
			background-color:<?php echo esc_attr(get_theme_mod('menu1_color', $def_colors['menu1_color'])); ?>;
		}

		#top-1-navigation .horisontal-navigation li a {
			color: <?php echo esc_attr(get_theme_mod('menu1_link', $def_colors['menu1_link'])); ?>;
		}	
		#menu-1 {
			border: 1px solid <?php echo esc_attr(get_theme_mod('menu1_link', $def_colors['menu1_link'])); ?>;
		}
		#top-1-navigation .horisontal-navigation li ul {
			background-color: <?php echo esc_attr(get_theme_mod('menu1_hover_back', $def_colors['menu1_hover_back'])); ?>;
		}

		#top-1-navigation .horisontal-navigation li ul li a {
			color: <?php echo esc_attr(get_theme_mod('menu1_hover', $def_colors['menu1_hover'])); ?>;
		}
		#top-1-navigation .horisontal-navigation li a:hover,
		#top-1-navigation .horisontal-navigation li a:focus {
			background: <?php echo esc_attr(get_theme_mod('menu1_hover_back', $def_colors['menu1_hover_back'])); ?>;
			color: <?php echo esc_attr(get_theme_mod('menu1_hover', $def_colors['menu1_hover'])); ?>;
		}
		#top-1-navigation .horisontal-navigation li ul li a:hover,
		.horisontal-navigation li ul li a:focus {
			background-color: <?php echo esc_attr(get_theme_mod('menu1_hover', $def_colors['menu1_hover'])); ?>;
			color: <?php echo esc_attr(get_theme_mod('menu1_hover_back', $def_colors['menu1_hover_back'])); ?>;
		}
		#top-1-navigation .horisontal-navigation .current-menu-item > a,
		#top-1-navigation .horisontal-navigation .current-menu-ancestor > a,
		#top-1-navigation .horisontal-navigation .current_page_item > a,
		#top-1-navigation .horisontal-navigation .current_page_ancestor > a {
			border: 1px solid <?php echo esc_attr(get_theme_mod('menu1_hover_back', $def_colors['menu1_hover_back'])); ?>;
		}
		#top-1-navigation .horisontal-navigation li ul .current-menu-item > a,
		#top-1-navigation .horisontal-navigation li ul .current-menu-ancestor > a,
		#top-1-navigation .horisontal-navigation li ul .current_page_item > a,
		#top-1-navigation .horisontal-navigation li ul .current_page_ancestor > a {
			background-color: <?php echo esc_attr(get_theme_mod('menu1_hover', $def_colors['menu1_hover'])); ?>;
			color: <?php echo esc_attr(get_theme_mod('menu1_hover_back', $def_colors['menu1_hover_back'])); ?>;
		}
		
		/* Second Top Menu */
		
		#top-navigation {
			background-color:<?php echo esc_attr(get_theme_mod('menu2_color', $def_colors['menu2_color'])); ?>;
		}
		#top-navigation .horisontal-navigation li a {
			color: <?php echo esc_attr(get_theme_mod('menu2_link', $def_colors['menu2_link'])); ?>;
		}	
		#top-navigation .horisontal-navigation li ul {
			background-color: <?php echo esc_attr(get_theme_mod('menu2_hover_back', $def_colors['menu2_hover_back'])); ?>;
		}
		#top-navigation .horisontal-navigation li ul li a {
			color: <?php echo esc_attr(get_theme_mod('menu2_hover', $def_colors['menu2_hover'])); ?>;
		}
		#top-navigation .horisontal-navigation li a:hover,
		#top-navigation .horisontal-navigation li a:focus {
			background: <?php echo esc_attr(get_theme_mod('menu2_hover_back', $def_colors['menu2_hover_back'])); ?>;
			color: <?php echo esc_attr(get_theme_mod('menu2_hover', $def_colors['menu2_hover'])); ?>;
		}
		#top-navigation .horisontal-navigation li ul li a:hover,
		#top-navigation .horisontal-navigation li ul li a:focus {
			background: <?php echo esc_attr(get_theme_mod('menu2_color', $def_colors['menu2_color'])); ?>;
			color: <?php echo esc_attr(get_theme_mod('menu2_link', $def_colors['menu2_link'])); ?>;
		}
		#top-navigation .horisontal-navigation .current-menu-item > a,
		#top-navigation .horisontal-navigation .current-menu-ancestor > a,
		#top-navigation .horisontal-navigation .current_page_item > a,
		#top-navigation .horisontal-navigation .current_page_ancestor > a {
			border: 1px solid <?php echo esc_attr(get_theme_mod('menu3_hover_back', $def_colors['menu3_hover_back'])); ?>;
		}

		#top-navigation .horisontal-navigation li ul .current-menu-item > a,
		#top-navigation .horisontal-navigation li ul .current-menu-ancestor > a,
		#top-navigation .horisontal-navigation li ul .current_page_item > a,
		#top-navigation .horisontal-navigation li ul .current_page_ancestor > a {
			background-color: <?php echo esc_attr(get_theme_mod('menu2_color', $def_colors['menu2_color'])); ?>;
			color: <?php echo esc_attr(get_theme_mod('menu2_link', $def_colors['menu2_link'])); ?>;
		}	
		#top-navigation {
			border-top: 1px solid <?php echo esc_attr(get_theme_mod('menu2_link', $def_colors['menu2_link'])); ?>;
		}
		
		/* Footer Menu */
		
		.site-info,
		#footer-navigation {
			background-color:<?php echo esc_attr(get_theme_mod('menu3_color', $def_colors['menu3_color'])); ?>;
			color: <?php echo esc_attr(get_theme_mod('menu3_hover_back', $def_colors['menu3_hover_back'])); ?>;
		}
		.site-info a{
			color: <?php echo esc_attr(get_theme_mod('menu3_link', $def_colors['menu3_link'])); ?>;
		}	
		#footer-navigation .horisontal-navigation li a {
			color: <?php echo esc_attr(get_theme_mod('menu3_link', $def_colors['menu3_link'])); ?>;
		}	
		#footer-navigation .horisontal-navigation li ul {
			background-color: <?php echo esc_attr(get_theme_mod('menu3_hover_back', $def_colors['menu3_hover_back'])); ?>;
		}
		#footer-navigation .horisontal-navigation li ul li a {
			color: <?php echo esc_attr(get_theme_mod('menu3_hover', $def_colors['menu3_hover'])); ?>;
		}
		#footer-navigation .horisontal-navigation li a:hover,
		#footer-navigation .horisontal-navigation li a:focus {
			background: <?php echo esc_attr(get_theme_mod('menu3_hover_back', $def_colors['menu3_hover_back'])); ?>;
			color: <?php echo esc_attr(get_theme_mod('menu3_hover', $def_colors['menu3_hover'])); ?>;
		}
		#footer-navigation .horisontal-navigation li ul li a:hover {
			background: <?php echo esc_attr(get_theme_mod('menu3_color', $def_colors['menu3_color'])); ?>;
			color: <?php echo esc_attr(get_theme_mod('menu3_link', $def_colors['menu3_link'])); ?>;
		}
		#footer-navigation .horisontal-navigation .current-menu-item > a,
		#footer-navigation .horisontal-navigation .current-menu-ancestor > a,
		#footer-navigation .horisontal-navigation .current_page_item > a,
		#footer-navigation .horisontal-navigation .current_page_ancestor > a {
			border: 1px solid <?php echo esc_attr(get_theme_mod('menu3_hover_back', $def_colors['menu3_hover_back'])); ?>;
		}
		#footer-navigation .horisontal-navigation li ul .current-menu-item > a,
		#footer-navigation .horisontal-navigation li ul .current-menu-ancestor > a,
		#footer-navigation .horisontal-navigation li ul .current_page_item > a,
		#footer-navigation .horisontal-navigation li ul .current_page_ancestor > a {
			background-color: <?php echo esc_attr(get_theme_mod('menu3_color', $def_colors['menu3_color'])); ?>;
			color: <?php echo esc_attr(get_theme_mod('menu3_link', $def_colors['menu3_link'])); ?>;
		}

		/* Footer Sidebar */
		
		.sidebar-footer {
			background-color:<?php echo esc_attr(get_theme_mod('sidebar2_color', $def_colors['sidebar2_color'])); ?>;
		}	
		.sidebar-footer .widget-wrap .widget-title,
		.sidebar-footer .widget-wrap .widget {
			color: <?php echo esc_attr(get_theme_mod('sidebar2_text', $def_colors['sidebar2_text'])); ?>;
		}
		.sidebar-footer .widget-wrap .widget a {
			color: <?php echo esc_attr(get_theme_mod('sidebar2_link', $def_colors['sidebar2_link'])); ?>;
		}
		.sidebar-footer .widget-wrap .widget a:hover {
			color: <?php echo esc_attr(get_theme_mod('sidebar2_hover', $def_colors['sidebar2_hover'])); ?>;
		}
		
		/* Top Sidebar */
		.sidebar-top-full,
		.sidebar-top {
			background-color:<?php echo esc_attr(get_theme_mod('sidebar1_color', $def_colors['sidebar1_color'])); ?>;
		}	
		.sidebar-top-full .widget,
		.sidebar-top .widget-wrap .widget {
			color: <?php echo esc_attr(get_theme_mod('sidebar1_text', $def_colors['sidebar1_text'])); ?>;
		}
		.sidebar-top-full .widget a,
		.sidebar-top .widget-wrap .widget a {
			color: <?php echo esc_attr(get_theme_mod('sidebar1_link', $def_colors['sidebar1_link'])); ?>;
		}
		.sidebar-top-full .widget a:hover,
		.sidebar-top .widget-wrap .widget a:hover {
			color: <?php echo esc_attr(get_theme_mod('sidebar1_hover', $def_colors['sidebar1_hover'])); ?>;
		}
		
		.image-and-cats a,
		.featured-post,
		.post-date a,
		.column .widget a,
		.content a {
			color: <?php echo esc_attr(get_theme_mod('link_color', $def_colors['link_color'])); ?>;
		}
		
		a:hover,
		.entry-date a:hover,
		.author a:hover,
		.site-info-text-top .site-title a:hover,
		.site-title a:hover,
		.entry-header .entry-title a:hover,
		.category-list a:hover {
			color: <?php echo esc_attr(get_theme_mod('hover_color', $def_colors['hover_color'])); ?>;;
		}
				
		.site-description {
			color: <?php echo esc_attr(get_theme_mod('description_color', $def_colors['description_color'])); ?>;;
		}
		
		entry-header .entry-title a,
		h1,
		h2,
		h3,
		h4,
		h5,
		h6 {
			color: <?php echo esc_attr(get_theme_mod('heading_color', $def_colors['heading_color'])); ?>;
		}
		
		.column .widget .widget-title {
			background: <?php echo esc_attr(get_theme_mod('column_header_color', $def_colors['column_header_color'])); ?>;
			color: <?php echo esc_attr(get_theme_mod('column_header_text', $def_colors['column_header_text'])); ?>;
		}
		
		<?php if( get_theme_mod('w1', $def_colors['widget_back']) != '' && get_theme_mod('w1', $def_colors['widget_back']) != '#eeeeee') : ?>
			.column .widget {
				background: <?php echo esc_attr(get_theme_mod('w1', $def_colors['widget_back'])); ?>;
				opacity: 0.8;
			}
		<?php endif; ?>

		.site {
			background:<?php echo esc_attr(get_theme_mod('sidebar3_color', $def_colors['sidebar3_color'])); ?> url(<?php echo esc_url(get_theme_mod('column_background_url', jolene_get_column_background())); ?>) repeat 0 0 fixed;		
		}
		
		.header-text-is-on.header-is-on .site-info-text {
			background: <?php echo esc_attr(get_theme_mod('site_name_back', $def_colors['site_name_back'])); ?>;
		}
		
		.image-and-cats-big a,
		.image-and-cats a,
		.site-cat a {
			color: #1e73be;;
		}

		.sidebar-left .widget,
		.sidebar-right .widget {
			color: <?php echo esc_attr(get_theme_mod('sidebar3_text', $def_colors['sidebar3_text'])); ?>;
		}
		
		.sidebar-left .widget a,
		.sidebar-right .widget a {
			color: <?php echo esc_attr(get_theme_mod('sidebar3_link', $def_colors['sidebar3_link'])); ?>;
		}
		
		.sidebar-left .widget a:hover,
		.sidebar-right .widget a:hover {
			color: <?php echo esc_attr(get_theme_mod('sidebar3_hover', $def_colors['sidebar3_hover'])); ?>;
		}
		
		.column .widget {
			border: 1px solid <?php echo esc_attr(get_theme_mod('border_color', $def_colors['border_color'])); ?>;
		}
		
		.header-wrapper,
		.sidebar-top-full,
		.sidebar-before-footer,	
		.site-content {
			box-shadow: 0 0 4px 4px <?php echo esc_attr(get_theme_mod('shadow_color', $def_colors['border_shadow_color'])); ?>;
		}
		
		.site-content {
			max-width: <?php echo esc_attr(get_theme_mod('content_width_no_sidebar', $defaults['content_width'])); ?>px;
		}
		
		.page .site-content {
			max-width: <?php echo esc_attr(get_theme_mod('content_width_no_sidebar_page', $defaults['content_width_no_sidebar_page'])); ?>px;
		}
		
		.left-sidebar-is-on .site-content {
			max-width: <?php echo esc_attr(get_theme_mod('content_width_left_sidebar', $defaults['content_width'])); ?>px;
		}
		.page.left-sidebar-is-on .site-content {
			max-width: <?php echo esc_attr(get_theme_mod('content_width_left_sidebar_page', $defaults['content_width_page'])); ?>px;
		}
		.right-sidebar-is-on .site-content {
			max-width: <?php echo esc_attr(get_theme_mod('content_width_right_sidebar', $defaults['content_width'])); ?>px;
		}
		.page.right-sidebar-is-on .site-content {
			max-width: <?php echo esc_attr(get_theme_mod('content_width_right_sidebar_page', $defaults['content_width_page'])); ?>px;
		}
		
		.two-sidebars .site-content {
			max-width: <?php echo esc_attr(get_theme_mod('content_width_no_sidebar', $defaults['content_width'])); ?>px;
		}
		.page.two-sidebars .site-content {
			max-width: <?php echo esc_attr(get_theme_mod('content_width_no_sidebar_page', $defaults['content_width_page'])); ?>px;
		}
		
		@media screen and (min-width: 1349px) {
			.page.two-sidebars .site-content,
			.two-sidebars .site-content {
				max-width: <?php echo esc_attr(get_theme_mod('content_width', $defaults['content_width'])); ?>px;
			}
		}
		
		.page-template-page-templatesfull-width-wide-php .site-content {
			max-width: <?php echo esc_attr(get_theme_mod('content_width_no_sidebar_wide_page', $defaults['content_width_page_no_sidebar_wide'])); ?>px;
		}
		
		@media screen and (max-width: 759px) {		
			.site-content {
				box-shadow: none;
			}
		}
		
	</style>
	<?php
}
add_action('wp_head', 'jolene_hook_css');
/**
 * Return Column Default Background Image URL
 *
 * @since jolene 1.0
 */
function jolene_get_column_background(){
	$url = apply_filters( 'jolene_column_background', '' );
	return $url;
}

/**
 * Return Array Default Colors for color scheme
 *
 * @param string $color_scheme color scheme id.
 * @since jolene 1.0
 */
function jolene_get_colors( $color_scheme = 'blue') {

	$def_colors = array();
	switch( $color_scheme ) {
		case 'blue':
			$def_colors['site_name_back'] = '#006600';
			$def_colors['widget_back'] = '#eeeeee';
			
			$def_colors['link_color'] = '#1e73be';
			$def_colors['heading_color'] = '#000';
			
			$def_colors['menu1_color'] = '#1e73be';
			$def_colors['menu1_link'] = '#fff';
			$def_colors['menu1_hover'] = '#1e73be';
			$def_colors['menu1_hover_back'] = '#eee';
			
			$def_colors['menu2_color'] = '#1e73be';
			$def_colors['menu2_link'] = '#c9daf2';
			$def_colors['menu2_hover'] = '#1e73be';
			$def_colors['menu2_hover_back'] = '#eee';
			
			$def_colors['menu3_color'] = '#1e73be';
			$def_colors['menu3_link'] = '#fff';
			$def_colors['menu3_hover'] = '#1e73be';
			$def_colors['menu3_hover_back'] = '#eee';
			
			$def_colors['sidebar1_color'] = '#eee';
			$def_colors['sidebar1_link'] = '#1e73be';
			$def_colors['sidebar1_hover'] = '#000';
			$def_colors['sidebar1_text'] = '#333';
			
			$def_colors['sidebar2_color'] = '#ddd';
			$def_colors['sidebar2_link'] = '#1e73be';
			$def_colors['sidebar2_hover'] = '#000';
			$def_colors['sidebar2_text'] = '#828282';
			
			//columns
			$def_colors['sidebar3_color'] = '#eee';
			$def_colors['sidebar3_link'] = '#1e73be';
			$def_colors['sidebar3_hover'] = '#000066';
			$def_colors['sidebar3_text'] = '#999';
			
			$def_colors['column_header_color'] = '#1e73be';
			$def_colors['column_header_text'] = '#fff';
			
			$def_colors['border_color'] = '#eee';
			$def_colors['border_shadow_color'] = '#bfbfbf';
			
			$def_colors['hover_color'] = '#339900';

		break;
		case 'black':
			$def_colors['site_name_back'] = '#fff';
			$def_colors['widget_back'] = '#000';

			$def_colors['link_color'] = '#1e73be';
			$def_colors['heading_color'] = '#000';
			$def_colors['menu1_color'] = '#000';
			$def_colors['menu1_link'] = '#fff';
			$def_colors['menu1_hover'] = '#ccc';
			$def_colors['menu1_hover_back'] = '#3f3f3f';
			
			$def_colors['menu2_color'] = '#000';
			$def_colors['menu2_link'] = '#fff';
			$def_colors['menu2_hover'] = '#ccc';
			$def_colors['menu2_hover_back'] = '#3f3f3f';
			
			$def_colors['menu3_color'] = '#000';
			$def_colors['menu3_link'] = '#fff';
			$def_colors['menu3_hover'] = '#ccc';
			$def_colors['menu3_hover_back'] = '#3f3f3f';
			
			$def_colors['sidebar1_color'] = '#eee';
			$def_colors['sidebar1_link'] = '#1e73be';
			$def_colors['sidebar1_hover'] = '#000';
			$def_colors['sidebar1_text'] = '#333';
			
			$def_colors['sidebar2_color'] = '#333';
			$def_colors['sidebar2_link'] = '#fff';
			$def_colors['sidebar2_hover'] = '#ccc';
			$def_colors['sidebar2_text'] = '#ccc';
			
			//columns
			$def_colors['sidebar3_color'] = '#666';
			$def_colors['sidebar3_link'] = '#ccc';
			$def_colors['sidebar3_hover'] = '#fff';
			$def_colors['sidebar3_text'] = '#ccc';
			
			$def_colors['column_header_color'] = '#000';
			$def_colors['column_header_text'] = '#fff';
			
			$def_colors['border_color'] = '#111';
			$def_colors['border_shadow_color'] = '#3f3f3f';
			
			$def_colors['hover_color'] = '#339900';

		break;
		case 'green':
			$def_colors['site_name_back'] = '#33cc00';
			$def_colors['widget_back'] = '#000';

			$def_colors['link_color'] = '#1e73be';
			$def_colors['heading_color'] = '#000';
			$def_colors['menu1_color'] = '#336600';
			$def_colors['menu1_link'] = '#fff';
			$def_colors['menu1_hover'] = '#a6d684';
			$def_colors['menu1_hover_back'] = '#003300';
			
			$def_colors['menu2_color'] = '#336600';
			$def_colors['menu2_link'] = '#fff';
			$def_colors['menu2_hover'] = '#a6d684';
			$def_colors['menu2_hover_back'] = '#003300';
			
			$def_colors['menu3_color'] = '#336600';
			$def_colors['menu3_link'] = '#fff';
			$def_colors['menu3_hover'] = '#a6d684';
			$def_colors['menu3_hover_back'] = '#003300';
			
			$def_colors['sidebar1_color'] = '#dd9933';
			$def_colors['sidebar1_link'] = '#000';
			$def_colors['sidebar1_hover'] = '#fff';
			$def_colors['sidebar1_text'] = '#333';
			
			$def_colors['sidebar2_color'] = '#dd9933';
			$def_colors['sidebar2_link'] = '#000';
			$def_colors['sidebar2_hover'] = '#fff';
			$def_colors['sidebar2_text'] = '#333';
			
			//columns
			$def_colors['sidebar3_color'] = '#b6d6a0';
			$def_colors['sidebar3_link'] = '#1e73be';
			$def_colors['sidebar3_hover'] = '#000';
			$def_colors['sidebar3_text'] = '#333';
			
			$def_colors['column_header_color'] = '#336600';
			$def_colors['column_header_text'] = '#fff';
			
			$def_colors['border_color'] = '#fff';
			$def_colors['border_shadow_color'] = '#6d6d6d';
			
			$def_colors['hover_color'] = '#339900';

		break;
		default:
			$def_colors['site_name_back'] = '#006600';
			$def_colors['widget_back'] = '';
			
			$def_colors['link_color'] = '#1e73be';
			$def_colors['heading_color'] = '#000';
			
			$def_colors['menu1_color'] = '#1e73be';
			$def_colors['menu1_link'] = '#fff';
			$def_colors['menu1_hover'] = '#1e73be';
			$def_colors['menu1_hover_back'] = '#eee';
			
			$def_colors['menu2_color'] = '#1e73be';
			$def_colors['menu2_link'] = '#c9daf2';
			$def_colors['menu2_hover'] = '#1e73be';
			$def_colors['menu2_hover_back'] = '#eee';
			
			$def_colors['menu3_color'] = '#1e73be';
			$def_colors['menu3_link'] = '#fff';
			$def_colors['menu3_hover'] = '#1e73be';
			$def_colors['menu3_hover_back'] = '#eee';
			
			$def_colors['sidebar1_color'] = '#eee';
			$def_colors['sidebar1_link'] = '#1e73be';
			$def_colors['sidebar1_hover'] = '#000';
			$def_colors['sidebar1_text'] = '#333';
			
			$def_colors['sidebar2_color'] = '#ddd';
			$def_colors['sidebar2_link'] = '#1e73be';
			$def_colors['sidebar2_hover'] = '#000';
			$def_colors['sidebar2_text'] = '#828282';
			
			//columns
			$def_colors['sidebar3_color'] = '#eee';
			$def_colors['sidebar3_link'] = '#1e73be';
			$def_colors['sidebar3_hover'] = '#000066';
			$def_colors['sidebar3_text'] = '#999';
			
			$def_colors['column_header_color'] = '#1e73be';
			$def_colors['column_header_text'] = '#fff';
			
			$def_colors['border_color'] = '#eee';
			$def_colors['border_shadow_color'] = '#bfbfbf';
			
			$def_colors['hover_color'] = '#339900';

		break;
	}

	$def_colors['description_color'] = '#ccc';	
	$def_colors = apply_filters( 'jolene_def_colors', $def_colors );
	
	return $def_colors;
}

/**
 * Create icon section in Customizer
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 *
 * @since jolene 1.0
 */

function jolene_create_social_icons_section( $wp_customize ){
	$icons = jolene_social_icons();
	
//New section in customizer: Featured Image
	$wp_customize->add_section( 'jolene_icons', array(
		'title'          => __( 'Social Media Icons', 'jolene' ),
		'description'          => __( 'Add your Social Media Links (Use Widget Social Icons for displaying icons on your website)', 'jolene' ),
		'priority'       => 101,
	) );
	
	$i = 0;
	foreach($icons as $id => $icon ) {
		$wp_customize->add_setting( $id, array(
			'default'        => '',
			'capability'     => 'edit_theme_options',
			'sanitize_callback' => 'jolene_sanitize_url'
		) );
		
		$wp_customize->add_control( 'jolene_icons_'.$id, array(
			'label'      => strtoupper($id),
			'section'    => 'jolene_icons',
			'settings'   => $id,
			'type'       => 'text',
			'priority'   => $i++,
		) );	
	}
}
/**
 * Return array Default Icons
 *
 * @since jolene 1.0
 */
function jolene_social_icons(){
	$icons = array(
					'facebook' => '',
					'twitter' => '',
					'google' => '',
					'wordpress' => '',
					'blogger' => '',
					'yahoo' => '',
					'youtube' => '',
					'myspace' => '',
					'livejournal' => '',
					'linkedin' => '',
					'friendster' => '',
					'friendfeed' => '',
					'digg' => '',
					'delicious' => '',
					'aim' => '',
					'ask' => '',
					'buzz' => '',
					'tumblr' => '',		
					'flickr' => '',						
					'rss' => '',
					'googleplus' => '',
				  );
	return apply_filters( 'jolene_icons', $icons);
}

/**
 * Return string Sanitized color scheme
 *
 * @since jolene 1.0
 */
function jolene_sanitize_color_scheme( $value ) {
	$possible_values = jolene_schemes();
	return ( array_key_exists( $value, $possible_values ) ? $value : 'blue' );
}
/**
 * Return string Sanitized color scheme
 *
 * @since jolene 1.0
 */
function jolene_schemes() {
	$jolene_schemes = array ('blue' => __( 'Blue', 'jolene' ), 'green' => __( 'Green', 'jolene' ), 'black' => __( 'Black', 'jolene' ));
	return apply_filters( 'jolene_schemes', $jolene_schemes);
}

/**
 * Return string Sanitized post thumbnail type
 *
 * @since jolene 1.0
 */
function jolene_sanitize_post_thumbnail( $value ) {
	$possible_values = array( 'large', 'big', 'small');
	return ( in_array( $value, $possible_values ) ? $value : 'big' );
}

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since jolene 1.0
 */
function jolene_customize_preview_js() {
	wp_enqueue_script( 'jolene-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), time(), true );
}
add_action( 'customize_preview_init', 'jolene_customize_preview_js', 99 );

 /**
 * Sanitize bool value.
 *
 * @param string $value Value to sanitize. 
 * @return int 1 or 0.
 * @since jolene 1.0
 */
function jolene_sanitize_checkbox( $value ) {	
	return ( $value == '1' ? '1' : 0 );
} 
 /**
 * Sanitize url value.
 *
 * @param string $value Value to sanitize. 
 * @return string sanitizes url.
 * @since jolene 1.0
 */
function jolene_sanitize_url( $value ) {	
	return esc_url( $value );
}
 /**
 * Sanitize url value.
 *
 * @param string $value Value to sanitize. 
 * @return string sanitizes url.
 * @since jolene 1.0
 */
function jolene_sanitize_background_url( $value ) {	
	$value = esc_url( $value );
	return ( $value == '' ? 'none' : $value );
}
/**
 * Sanitize integer.
 *
 * @param string $value Value to sanitize. 
 * @return int sanitized value.
 * @uses absint()
 * @since jolene 1.0
 */
function jolene_sanitize_int( $value ) {
	return absint( $value );
} 
/**
 * Sanitize text field.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @uses sanitize_text_field()
 * @since jolene 1.0
 */
function jolene_sanitize_text( $value ) {
	return sanitize_text_field( $value );
}
/**
 * Sanitize hex color.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @uses sanitize_hex_color()
 * @since jolene 1.0
 */
function jolene_sanitize_hex_color( $value ) {
	return sanitize_hex_color( $value );
}
/**
 * Sanitize hex color.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @uses sanitize_hex_color()
 * @since jolene 1.0
 */
function jolene_sanitize_content_width( $value ) {
	$value = absint($value);
	$value = ($value > 1349 ? 1349 : ($value < 500 ? 500 : $value));
	return $value;
}
/**
 * Sanitize scroll button.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @since jolene 1.0.1
 */
function jolene_sanitize_scroll_button( $value ) {
	$possible_values = array( 'none', 'right', 'left', 'center');
	return ( in_array( $value, $possible_values ) ? $value : 'right' );
}

/**
 * Sanitize scroll css3 effect.
 *
 * @param string $value Value to sanitize. 
 * @return sanitized value.
 * @since jolene 1.0.1
 */
function jolene_sanitize_scroll_effect( $value ) {
	$possible_values = array( 'none', 'move');
	return ( in_array( $value, $possible_values ) ? $value : 'move' );
}