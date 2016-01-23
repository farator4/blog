<?php
/**
 * Functions and definitions
 *
 * @package WordPress
 * @subpackage Unicorn
 * @since Unicorn 1.0
*/

/**
 * Unicorn setup.
 *
 * @since Unicorn 1.0
 */
function unicorn_setup() {
	remove_action('jolene_empty_sidebar_6', 'jolene_empty_sidebar_6');
	load_child_theme_textdomain( 'unicorn', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'unicorn_setup' );
/**
 * New Jolene setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * @since unicorn 1.0
 */

function jolene_setup() {

	$defaults = jolene_get_defaults();

	if ( get_theme_mod( 'is_show_top_menu', $defaults ['is_show_top_menu']) == '1' )
		register_nav_menu( 'top1', __( 'First Top Menu', 'jolene' ));
	if ( get_theme_mod( 'is_show_secont_top_menu', $defaults ['is_show_secont_top_menu']) == '1' )
		register_nav_menu( 'top2', __( 'Second Top Menu', 'jolene' ));
	if ( get_theme_mod( 'is_show_footer_menu', $defaults ['is_show_footer_menu']) == '1' )
		register_nav_menu( 'footer', __( 'Footer Menu', 'jolene' ));

	load_theme_textdomain( 'jolene', get_template_directory() . '/languages' );
	
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'custom-background', array(
		'default-color' => 'cccccc',
	) );

	add_theme_support( 'post-thumbnails' );
	
	set_post_thumbnail_size( 300, 9999 ); 
	
	add_image_size( 'jolene-full-width', jolene_big_thumbnail_size());//big thumbnail
	add_image_size( 'jolene-full-screen', 1309);//large thumbnail
	
	
	$args = array(
		'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 1309,
		'height'                 => 200,
		'flex-height'            => true,
		'flex-width'             => false,
		'wp-head-callback'       => 'jolene_header_style',
		'admin-head-callback'    => 'jolene_admin_header_style',
		'admin-preview-callback' => 'jolene_admin_header_image',
	);
	add_theme_support( 'custom-header', $args );
		
	/*
	 * Enable support for Post Formats.
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );
	
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'caption'
	) );
	
	add_theme_support( 'title-tag' );
	
	/*
	 * Enable support for WooCommerce plugin.
	 */
	 
	add_theme_support( 'woocommerce' );

}
add_action( 'after_setup_theme', 'jolene_setup' );


/**
 * Return the Google font stylesheet URL if available.
 *
 * @since unicorn 1.0
 */
function unicorn_get_font_url() {
	$font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by Open Sans fonts, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'unicorn' ) ) {
		$subsets = 'latin,latin-ext';
		$family = 'Open+Sans:400italic,400,300';

		/* translators: To add an additional Open Sans character subset specific to your language,	
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Font: add new subset (greek, cyrillic, vietnamese)', 'unicorn' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic,cyrillic-ext';
		}
		if ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$query_args = array(
			'family' => $family,
			'subset' => $subsets,
		);
		$font_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
		
	}

	return $font_url;
}

/**
 * Enqueue parent and child scripts
 *
 * @package WordPress
 * @subpackage Unicorn
 * @since Unicorn 1.0
*/

function unicorn_enqueue_styles() {
    wp_enqueue_style( 'unicorn-parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'unicorn-style', get_stylesheet_uri(), array( 'unicorn-parent-style' ) );
	
	$font_url = unicorn_get_font_url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'unicorn-fonts', esc_url_raw( $font_url ), array(), null );
	
}
add_action( 'wp_enqueue_scripts', 'unicorn_enqueue_styles' );

/**
 * Unregister fonts
 *
 * @since unicorn 1.0
 */
function unicorn_dequeue_styles() {
	
	wp_dequeue_style('jolene-fonts');
	
}
add_action( 'wp_print_styles', 'unicorn_dequeue_styles' );

/**
 * Print Demo Widget into the empty sidebar-6.
 *
 * @since Unicorn 1.0
 */
function unicorn_empty_sidebar_6() {
	the_widget( 'WP_Widget_Calendar', 'title='.__('Calendar', 'unicorn'), 'before_widget=<div class="widget-wrap"><aside class="widget">&after_widget=</aside></div>&before_title=<h3 class="widget-title">&after_title=</h3>');
	the_widget( 'WP_Widget_Recent_Posts', 'title='.__('Recent Posts', 'unicorn').'&sortby=post_modified', 'before_widget=<div class="widget-wrap"><aside class="widget">&after_widget=</aside></div>&before_title=<h3 class="widget-title">&after_title=</h3>');
	the_widget( 'WP_Widget_Search', 'title='.__('Search', 'unicorn'), 'before_widget=<div class="widget-wrap"><aside class="widget widget_search">&after_widget=</aside></div>&before_title=<h3 class="widget-title">&after_title=</h3>');
}
add_action('jolene_empty_sidebar_6', 'unicorn_empty_sidebar_6');

/**
 * Unicorn setup.
 *
 * Filter for theme defaults.
 *
 * @since Unicorn 1.0
 */
function unicorn_option_defaults($defaults){
	$defaults['color_scheme'] = 'unicorn';
	$defaults['is_second_menu_on_front_page_only'] = '0';
	$defaults['is_empty_6_on'] = 1;
	return $defaults;
}
add_filter('jolene_option_defaults', 'unicorn_option_defaults');
/**
 * Unicorn Color scheme.
 *
 * Default Colors for the child theme Unicorn.
 *
 * @since Unicorn  1.0
 */
function unicorn_def_colors($def_colors) {
	if(get_theme_mod('color_scheme', 'unicorn') == 'unicorn') { //this is color scheme of the child theme
			$def_colors['site_name_back'] = '#fff';
			$def_colors['widget_back'] = '#fff';
	
			$def_colors['link_color'] = '#1e73be';
			$def_colors['heading_color'] = '#000';
			
			$def_colors['menu1_color'] = '#fff';
			$def_colors['menu1_link'] = '#1e73be';
			$def_colors['menu1_hover'] = '#fff';
			$def_colors['menu1_hover_back'] = '#1e73be';
			
			$def_colors['menu2_color'] = '#1e73be';
			$def_colors['menu2_link'] = '#fff';
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
			
			$def_colors['sidebar2_color'] = '#fff';
			$def_colors['sidebar2_link'] = '#1e73be';
			$def_colors['sidebar2_hover'] = '#000';
			$def_colors['sidebar2_text'] = '#828282';
			
			//columns
			$def_colors['sidebar3_color'] = '#eee';
			$def_colors['sidebar3_link'] = '#1e73be';
			$def_colors['sidebar3_hover'] = '#000066';
			$def_colors['sidebar3_text'] = '#999';
			
			$def_colors['column_header_color'] = '#eee';
			$def_colors['column_header_text'] = '#000';
			
			$def_colors['border_color'] = '#fff';
			$def_colors['border_shadow_color'] = '#bfbfbf';
	}
	return $def_colors;
}
add_filter('jolene_def_colors', 'unicorn_def_colors');
/**
 * Add Unicorn Color scheme to the list of color schemes.
 *
 * @since Unicorn  1.0
 */
function unicorn_schemes($jolene_schemes) {
	$jolene_schemes['unicorn'] = __( 'Unicorn', 'unicorn' );

	return $jolene_schemes;
}
add_filter('jolene_schemes', 'unicorn_schemes');
/**
 * Set Unicorn def background to ''.
 *
 * @since Unicorn  1.0
 */
function unicorn_column_background($jolene_schemes) {
	return '';
}
add_filter('jolene_column_background', 'unicorn_column_background');

/**
 * Enqueue Javascript postMessage handlers for the Customizer.
 *
 * Binds JS handlers to make the Customizer preview reload changes asynchronously.
 *
 * @since Unicorn 1.0
 */
function unicorn_customize_preview_js() {
	wp_enqueue_script( 'unicorn-customizer', get_stylesheet_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), time(), true );
}
add_action( 'customize_preview_init', 'unicorn_customize_preview_js', 99 );