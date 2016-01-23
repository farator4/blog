<?php
/**
 * Functions and definitions
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
*/

/**
 * Set up the content width value.
 *
 * @since jolene 1.0
 */
  
if ( ! isset( $content_width ) ) {
	$content_width = 987;
}

if ( ! isset( $jolene_sidebars ) ) {
	$jolene_sidebars = array();
}

if ( ! function_exists( 'jolene_setup' ) ) :

/**
 * Jolene setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * @since jolene 1.0
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
		'default-image'          => jolene_get_header(get_theme_mod('color_scheme'), $defaults ['color_scheme']),
		'default-text-color'     => jolene_text_color(get_theme_mod('color_scheme'), $defaults ['color_scheme']),
		'width'                  => 1309,
		'height'                 => 400,
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
endif;

if ( ! function_exists( '_wp_render_title_tag' ) ) :
/**
 *  Backwards compatibility for older versions (4.1)
 * 
 * @since jolene 1.0.1
 */
	function jolene_render_title() {
	?>
		 <title><?php wp_title( '|', true, 'right' ); ?></title>
	<?php
	}
	add_action( 'wp_head', 'jolene_render_title' );
	
/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since jolene 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function jolene_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'jolene' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'jolene_wp_title', 10, 2 );
	
endif;

if ( ! function_exists( 'jolene_big_thumbnail_size' ) ) :

/**
 * Return big thumbnail size.
 *
 * @since jolene 1.0
 */

function jolene_big_thumbnail_size() {
	
	return jolene_max_content_size(); 

}
endif;


if ( ! function_exists( 'jolene_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 * 
 * @since jolene 1.0
 */
function jolene_header_style() {
	$text_color = get_header_textcolor();

	if ( display_header_text() && $text_color === get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
	<style type="text/css" id="jolene-header-css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
	<?php
		// If the user has set a custom color for the text, use that.
		elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
	?>
		.site-info-text-top .site-title a,
		.site-title a {
			color: #<?php echo esc_attr( $text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif;
if ( ! function_exists( 'jolene_admin_header_style' ) ) :
/**
 * Style the header image displayed on the Appearance > Header screen.
 *
 * @since jolene 1.0
 */
function jolene_admin_header_style() {

	$def_colors = jolene_get_colors(get_theme_mod('color_scheme', jolene_default_color_scheme()));

?>
	<style type="text/css" id="jolene-admin-header-css">
	.appearance_page_custom-header #headimg {
		background: #fff;
		border: none;
		max-width: 1349px;
	}
	
	<?php if ( get_header_image() == '' && display_header_text() ) : ?>

		#headimg .site-info-text-top {
			background-color:<?php echo esc_attr(get_theme_mod('menu1_color', $def_colors['menu1']['color'])); ?>;
		}

		#headimg .site-info-text-top .site-description {
			display: none;
		}

		#headimg .site-info-text-top .site-title {
			text-align: left;
		}

		#headimg .site-info-text-top .site-title a {
			color: #<?php echo esc_attr( get_header_textcolor() ); ?>;
			padding: 0 40px;
		}
		
		#headimg .site-info-text-top  .site-description {
			color: #ccc;
			display: inline-block;
			float: right;
			padding: 20px 40px 0 0;
			text-align: left;
			max-width: 30%;
		}
	
		#headimg .site-info-text-top  .site-title {
			float: left;
			width: 50%;
		}
	<?php endif; ?>
	#headimg .site-description {
		margin-top: 0;
		padding-top: 0;
	}
	
	#headimg .site-title {
		font-family: 'Lobster', sans-serif;
		margin-bottom: 0;
	}
	
	#headimg .site-description {
		color: #ccc;
		font-size: 14px;
		margin-bottom: 20px;
		margin-top: 0;
	}
	<?php if ( get_header_image() && display_header_text() ) : ?>		
	
		#headimg .site-info-text {
			background: <?php echo esc_attr(get_theme_mod('site_name_back', $def_colors['site_name']['back'])); ?>;
			box-shadow: 0 0 4px 4px #999;
			display: block;
			margin: 0 20px -20px 20px;
			opacity: 0.7;
			left: 40px;
			position: absolute;
			text-align: center;
			top: 40px;
			width: 30%;
		}
		
		#headimg .img-container {
			position: relative;
		}
		
		#headimg .site-title a {
			color: #<?php echo esc_attr( get_header_textcolor() ); ?>;
		}
	
	<?php endif; ?>

	</style>
<?php
}
endif; 

if ( ! function_exists( 'jolene_admin_header_image' ) ) :
/**
 * Create the custom header image markup displayed on the Appearance > Header screen.
 *
 * @since jolene 1.0
 */
function jolene_admin_header_image() {
?>
	<div id="headimg">
		<?php if ( get_header_image() == '' && display_header_text() ) : ?>

			<div class="site-info-text-top">
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<!-- Dscription -->
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				<br class="clear">
			</div>
			
		<?php endif; ?>
		
		<?php if ( get_header_image() ) : ?>		

			<div class="img-container">
				<?php if ( display_header_text() ) : ?>
					<!-- Site Name -->
					<div class="site-info-text">
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<!-- Dscription -->
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					</div>
				<?php endif; ?>
				
				<!-- Banner -->
				<div class="header-wrapper">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php header_image(); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
					</a>
				</div>

			</div>
		<?php endif; ?>
	</div>
<?php
}
endif;

/**
 * Load our special font CSS file.
 *
 * @since jolene 1.0
 */
function jolene_custom_header_fonts() {
	$font_url = jolene_get_font_url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'jolene-fonts', esc_url_raw( $font_url ), array(), null );
}
add_action( 'admin_print_styles-appearance_page_custom-header', 'jolene_custom_header_fonts' );

/**
 * Return the Google font stylesheet URL if available.
 *
 * @since jolene 1.0
 */
function jolene_get_font_url() {
	$font_url = '';
	$defaults = jolene_get_defaults();

	/* translators: If there are characters in your language that are not supported
	 * by Open Sans, Lobster fonts, translate this to 'off'. Do not translate into your own language.
	 */
	
	$font_url = '';
	$font = str_replace( ' ', '+', get_theme_mod( 'body_font', $defaults['body_font'] ) );
	$heading_font = str_replace( ' ', '+', get_theme_mod( 'heading_font', $defaults['heading_font'] ) );
	$header_font = str_replace( ' ', '+', get_theme_mod( 'header_font', $defaults['header_font']) );
	
	if ( '0' == $font && '0' == $heading_font && '0' == $header_font ) 
		return $font_url;
		
	if ( '0' != $font && '0' != $heading_font )
		$font .= '%7C';
		
	$font .= $heading_font;	
	
	if ( '0' != $font && '0' != $header_font )
		$font .= '%7C';

	$font .= $header_font;
	 
	if ( 'off' !== _x( 'on', 'Open Sans, Lobster fonts: on or off', 'jolene' ) ) {
		$subsets = 'latin,latin-ext';
		$family = $font . ':300,400';

		/* translators: To add an additional Open Sans, Lobster character subset specific to your language,	
		 * translate this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language.
		 */
		$subset = _x( 'no-subset', 'Font: add new subset (greek, cyrillic, vietnamese)', 'jolene' );

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
		$font_url = "//fonts.googleapis.com/css?family=" . $family . '&' . $subsets;
		
	}

	return $font_url;
}
/**
 * Enqueue scripts and styles for front-end.
 *
 * @since jolene 1.0
 */
function jolene_scripts_styles() {
	global $wp_styles;
	
	// Add Genericons font.
	wp_enqueue_style( 'jolene-genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '18112014' );
	
	$font_url = jolene_get_font_url();
	if ( ! empty( $font_url ) )
		wp_enqueue_style( 'jolene-fonts', esc_url_raw( $font_url ), array(), null );
		
	// Loads our main stylesheet.
	wp_enqueue_style( 'jolene-style', get_stylesheet_uri() );
			
	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'jolene-ie', get_template_directory_uri() . '/css/ie.css', array( 'jolene-style' ), '20141210' );
	$wp_styles->add_data( 'jolene-ie', 'conditional', 'lt IE 9' );
	
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
		
	// Adds JavaScript for handing the navigation menu and top sidebars hide-and-show behavior.
	wp_enqueue_script( 'jolene-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20141012', true );
	
	// Adds JavaScript for handing the custom widget behavior.
	wp_enqueue_script( 'jolene-custom-widget', get_template_directory_uri() . '/js/custom-widget.js', array( 'jquery' ), '20141012', true );
	
}
add_action( 'wp_enqueue_scripts', 'jolene_scripts_styles' );
 
/**
 * Add Editor styles and fonts to Tiny MCE
 *
 * @since jolene 1.0
 */
function jolene_add_editor_styles() {
	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css' ) );
	
	$font_url = jolene_get_font_url();
	if ( ! empty( $font_url ) )
		 add_editor_style( $font_url );
}
add_action( 'after_setup_theme', 'jolene_add_editor_styles' );

/**
 * set globals jolene_sidebars.
 *
 * @since Jolene 1.0.1
 */
function jolene_set_sidebars_visibility() {

	global $jolene_sidebars;

	$jolene_sidebars['right'] = 1;
	$jolene_sidebars['left'] = 1;

}
add_action( 'template_redirect', 'jolene_set_sidebars_visibility' );
/**
 * Extend the default WordPress body classes.
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 *
 * @since jolene 1.0
 */

function jolene_body_class( $classes ) {

	$background_color = get_background_color();
	$background_image = get_background_image();
	
	$defaults = jolene_get_defaults();
	
	
	if ( empty( $background_image ) ) {
		if ( empty( $background_color ) )
			$classes[] = 'custom-background';
		elseif ( in_array( $background_color, array( 'ccc', 'cccccc' ) ) )
			$classes[] = 'custom-background';
	}
	
	// Enable custom class only if the header text enabled.
	if ( display_header_text() ) {
		$classes[] = 'header-text-is-on';
	}	
	
	if ( ! has_post_thumbnail() ) {
		$classes[] = 'no-thumbnail';
	}
	
	if ( ! has_category() ) {
		$classes[] = 'no-cat';
	}
	else {
		$classes[] = 'cat';
	}
	
	if ( is_category() ) {
		$classes[] = 'archive-page';
	}
	
	// Enable custom class only if the header image enabled.
	if ( get_header_image() && ( get_theme_mod( 'is_header_on_front_page_only', $defaults['is_header_on_front_page_only'] ) != '1' || is_front_page()) ) {
		if ( 'large' == get_theme_mod( 'post_thumbnail', $defaults['post_thumbnail'] ) && is_page() && ! has_post_thumbnail() ) {
		} else {
			$classes[] = 'header-is-on';
		}
	}
	
	if (  'large' == get_theme_mod( 'post_thumbnail', $defaults['post_thumbnail'] ) && (has_post_thumbnail() || ! is_page() ) && !(function_exists('is_woocommerce') && is_woocommerce()) && ! is_front_page() && ! is_archive() && ! is_home() && ! is_search() ) {
		
		if ( 'large' == get_theme_mod( 'post_thumbnail', $defaults['post_thumbnail'] ) && is_page() && ! has_post_thumbnail() ) {
		} else {
			$classes[] = 'header-is-on';
		}
	}
	

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'jolene-fonts', 'queue' ) )
		$classes[] = 'google-fonts-on';

		
	// Enable custom class only if the header right sidebar is active.
	if ( is_active_sidebar( 'sidebar-8' ) || get_theme_mod( 'is_empty_8_on', $defaults['is_empty_8_on'] ) == 1 )
		$classes[] = 'header-sidebar-is-on';
		
	// Enable custom class only if the logotype is active.
	if ( get_theme_mod( 'logotype_url', $defaults['logotype_url'] ) != '' ) 
		$classes[] = 'logo-is-on';	

	// this is a WooCommerce plugin shop page
	if ( (function_exists('is_woocommerce') && is_woocommerce()) ) {
		 
		if ( is_active_sidebar( 'sidebar-5' ) ) {
			$classes[] = 'top-sidebar-is-on';
		}
		
		if( get_theme_mod( 'is_has_shop_sidebar', $defaults['is_has_shop_sidebar'] ) == '1' ) {
			// Enable custom class only if the left sidebar and the right sidebar are inactive.
			if( ! is_active_sidebar( 'sidebar-20' ) && ! is_active_sidebar( 'sidebar-19' ) )
				$classes[] = 'no-sidebar';	
			// Enable custom class only if the left and the right sidebar are active.
			if( is_active_sidebar( 'sidebar-19' ) && is_active_sidebar( 'sidebar-20' ) )
				$classes[] = 'two-sidebars';		
			// Enable custom class only if the left sidebar is inactive.
			if ( ! is_active_sidebar( 'sidebar-20' ) )
				$classes[] = 'no-left-sidebar';		
			// Enable custom class only if the right sidebar is active and the left sidebar is inactive.
			if ( !is_active_sidebar( 'sidebar-20' ) && is_active_sidebar( 'sidebar-19' ) )
				$classes[] = 'right-sidebar-is-on';		
			// Enable custom class only if the left sidebar is active.
			if ( is_active_sidebar( 'sidebar-20' ) )
				$classes[] = 'left-sidebar-is-on';
		}
		else {
			$classes[] = 'no-sidebar';
		}
	}
	else {
	
		// Enable custom class only if the left sidebar is active.
		if ( ! is_page_template( 'page-templates/full-width.php' ) && ! is_page_template( 'page-templates/full-width-wide.php' ) && ! is_page_template( 'page-templates/right-sidebar.php' ) ) {
			if ( is_front_page() || is_page_template( 'page-templates/front-page.php' ) ) {
				if ( is_active_sidebar( 'sidebar-13' ) )
					$classes[] = 'left-sidebar-is-on';
			}
			elseif ( is_page() ) {
				if(is_active_sidebar( 'sidebar-3' ))
					$classes[] = 'left-sidebar-is-on';
			}
			elseif ( is_active_sidebar( 'sidebar-1' ) )
				$classes[] = 'left-sidebar-is-on';
		}
		
		// Enable custom class only if the top sidebar is active.
		if ( (is_page_template( 'page-templates/front-page.php' ) || is_front_page()) ) {
			if( is_active_sidebar( 'sidebar-10' ) )
				$classes[] = 'top-sidebar-is-on';
		}
		elseif ( is_active_sidebar( 'sidebar-5' ) ) {
			$classes[] = 'top-sidebar-is-on';
		}
		
		// Enable custom class only if the left sidebar and the right sidebar are inactive.
		if ( is_page_template( 'page-templates/full-width.php' ) || is_page_template( 'page-templates/full-width-wide.php' ))
			$classes[] = 'no-sidebar';
		elseif ( is_front_page() || is_page_template( 'page-templates/front-page.php' ) ) {
			if( ! is_active_sidebar( 'sidebar-13' ) && ! is_active_sidebar( 'sidebar-14' ) )
				$classes[] = 'no-sidebar';
		}
		elseif ( is_page() ) {
			 if( ! is_active_sidebar( 'sidebar-3' ) && ! is_active_sidebar( 'sidebar-4' ) )
				$classes[] = 'no-sidebar';
		}
		elseif ( ! is_active_sidebar( 'sidebar-1' ) && ! is_active_sidebar( 'sidebar-2' ) )
			$classes[] = 'no-sidebar';	
		
		// Enable custom class only if the left sidebar is inactive.
		if ( is_page_template( 'page-templates/full-width.php' ) || is_page_template( 'page-templates/full-width-wide.php' ) || is_page_template( 'page-templates/right-sidebar.php' ))
			$classes[] = 'no-left-sidebar';	
		elseif ( is_front_page() || is_page_template( 'page-templates/front-page.php' ) ) {
			if ( ! is_active_sidebar( 'sidebar-13' ))
				$classes[] = 'no-left-sidebar';	
		}
		elseif ( is_page() ) {
			if ( !is_active_sidebar( 'sidebar-3' ) )
				$classes[] = 'no-left-sidebar';	
		}
		elseif ( ! is_active_sidebar( 'sidebar-1' ) )
			$classes[] = 'no-left-sidebar';			
				
		// Enable custom class only if the left and the right sidebar are active.
		if ( ! is_page_template( 'page-templates/full-width.php' ) 
				&& ! is_page_template( 'page-templates/full-width-wide.php' ) 
				&& ! is_page_template( 'page-templates/right-sidebar.php') 
				&& ! is_page_template( 'page-templates/left-sidebar.php') ) {
			if (  is_page_template( 'page-templates/front-page.php' ) || is_front_page() ) {
				if ( is_active_sidebar( 'sidebar-13' ) && is_active_sidebar( 'sidebar-14' ))
					$classes[] = 'two-sidebars';
			}
			elseif ( is_page() ) {
				if( is_active_sidebar( 'sidebar-3' ) && is_active_sidebar( 'sidebar-4' ) )
					$classes[] = 'two-sidebars';
			}
			elseif ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) )
				$classes[] = 'two-sidebars';
		}
				
		// Enable custom class only if the right sidebar is active and the left sidebar is inactive.
		if ( ! is_page_template( 'page-templates/full-width.php' ) && ! is_page_template( 'page-templates/full-width-wide.php' ) && ! is_page_template( 'page-templates/left-sidebar.php') ) {
			if ( is_page_template( 'page-templates/right-sidebar.php' ) && is_active_sidebar( 'sidebar-4' ) )
				$classes[] = 'right-sidebar-is-on';
			elseif ( is_page_template( 'page-templates/front-page.php' ) || is_front_page() ) {
				if( !is_active_sidebar( 'sidebar-13' ) && is_active_sidebar( 'sidebar-14' ) )
					$classes[] = 'right-sidebar-is-on';
			}
			elseif ( is_page() ) {
				if (!is_active_sidebar( 'sidebar-3' ) && is_active_sidebar( 'sidebar-4' ) )
					$classes[] = 'right-sidebar-is-on';
			}
			elseif ( !is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) )
				$classes[] = 'right-sidebar-is-on';	
		}
	}
	
	return $classes;
}
add_filter( 'body_class', 'jolene_body_class' );

/**
 * Create not empty title
 *
 * @since jolene 1.0
 *
 * @param string $title Default title text.
 * @param int $id.
 * @return string The filtered title.
 */
function jolene_title( $title, $id = null ) {

    if ( trim($title) == '' && (is_archive() || is_home() || is_search() ) ) {
        return ( esc_html( get_the_date() ) );
    }
	
    return $title;
}
add_filter( 'the_title', 'jolene_title', 10, 2 );

if ( ! function_exists( 'jolene_get_header' ) ) :

/**
 * Return default header image url
 *
 * @since jolene 1.0
 *
 * @param string color_scheme color scheme.
 * @return string header url.
 */
function jolene_get_header( $color_scheme ) {

	$header_img  = get_template_directory_uri() . '/img/';
	
	switch ($color_scheme) {
		case 'black':
			$header_img .= 'header-black.jpg';
		break;
		default:
			$header_img .= 'header.jpg';
		break;
	}

    return $header_img;
}

endif;

if ( ! function_exists( 'jolene_text_color' ) ) :

/**
 * Return default header text color
 *
 * @since jolene 1.0
 *
 * @param string color_scheme color scheme.
 * @return string header url.
 */
function jolene_text_color( $color_scheme ) {
	$text_color = 'ffffff';
	switch ($color_scheme) {
		case 'black':
			$text_color = '000000';
		break;
		default:
			$text_color = 'ffffff';
		break;
	}

    return $text_color;
}

endif;
/**
 * Register sidebars and widgetized areas.
 *
 * @since jolene 1.0
 */
function jolene_widgets_init() {

	$defaults = jolene_get_defaults();

	register_sidebar( array(
		'name' => __( 'Left Sidebar', 'jolene' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<div class="before-widget-title"></div><h3 class="widget-title">',
		'after_title' => '</h3><div class="after-widget-title"></div>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Pages, Left Sidebar', 'jolene' ),
		'id' => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<div class="before-widget-title"></div><h3 class="widget-title">',
		'after_title' => '</h3><div class="after-widget-title"></div>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Right Sidebar', 'jolene' ),
		'id' => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<div class="before-widget-title"></div><h3 class="widget-title">',
		'after_title' => '</h3><div class="after-widget-title"></div>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Pages, Right Sidebar', 'jolene' ),
		'id' => 'sidebar-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<div class="before-widget-title"></div><h3 class="widget-title">',
		'after_title' => '</h3><div class="after-widget-title"></div>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Top Sidebar', 'jolene' ),
		'id' => 'sidebar-5',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => __( 'Footer Sidebar', 'jolene' ),
		'id' => 'sidebar-6',
		'before_widget' => '<div class="widget-wrap"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside></div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Content Sidebar', 'jolene' ),
		'id' => 'sidebar-7',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Header, Right Sidebar', 'jolene' ),
		'id' => 'sidebar-8',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
/* Home Page Widgets */

	register_sidebar( array(
		'name' => __( 'Home Page, Left Sidebar', 'jolene' ),
		'id' => 'sidebar-13',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<div class="before-widget-title"></div><h3 class="widget-title">',
		'after_title' => '</h3><div class="after-widget-title"></div>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Home Page, Right Sidebar', 'jolene' ),
		'id' => 'sidebar-14',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<div class="before-widget-title"></div><h3 class="widget-title">',
		'after_title' => '</h3><div class="after-widget-title"></div>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Home Page, Top Sidebar', 'jolene' ),
		'id' => 'sidebar-10',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Home Page, First Content Sidebar', 'jolene' ),
		'id' => 'sidebar-11',
		'before_widget' => '<div class="widget-wrap"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside></div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Home Page, Second Content Sidebar', 'jolene' ),
		'id' => 'sidebar-12',
		'before_widget' => '<div class="widget-wrap"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside></div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	
	register_sidebar( array(
		'name' => __( 'Home Page Before Footer Sidebar', 'jolene' ),
		'id' => 'sidebar-15',
		'before_widget' => '<div class="widget-wrap"><aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside></div>",
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );
	
	if( get_theme_mod( 'is_has_mobile_sidebar', $defaults['is_has_mobile_sidebar'] ) ) {
		register_sidebar( array(
			'name' => __( 'Visible on small screens only', 'jolene' ),
			'id' => 'sidebar-16',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Pages, visible on small screens only', 'jolene' ),
			'id' => 'sidebar-17',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Home, visible on small screens only', 'jolene' ),
			'id' => 'sidebar-18',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'WooCommerce, visible on small screens only', 'jolene' ),
			'id' => 'sidebar-21',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );
	}
	
	if( get_theme_mod( 'is_has_shop_sidebar', $defaults['is_has_shop_sidebar'] ) == '1' ) {
	
		register_sidebar( array(
			'name' => __( 'Shop, right sidebar', 'jolene' ),
			'id' => 'sidebar-19',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<div class="before-widget-title"></div><h3 class="widget-title">',
			'after_title' => '</h3><div class="after-widget-title"></div>',
		) );
		
		register_sidebar( array(
			'name' => __( 'Shop, left sidebar', 'jolene' ),
			'id' => 'sidebar-20',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => "</aside>",
			'before_title' => '<div class="before-widget-title"></div><h3 class="widget-title">',
			'after_title' => '</h3><div class="after-widget-title"></div>',
		) );
		
	}
		
}
add_action( 'widgets_init', 'jolene_widgets_init' );

if ( ! function_exists( 'jolene_post_nav' ) ) :

/**
 * Retrieve sidebar for current type of page.
 *
 * @since jolene 1.0.6
 */
function jolene_get_mobile_sidebar_id() {

	if ( is_front_page() )
		return 'sidebar-18';
	if ( function_exists('is_woocommerce') && is_woocommerce() )
		return 'sidebar-21';
	if ( is_page() )
		return 'sidebar-17';

	return 'sidebar-16';
}
endif;

if ( ! function_exists( 'jolene_post_nav' ) ) :
/**
 * Display navigation to next/previous post.
 *
 * @since jolene 1.0
 */
function jolene_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'jolene' ); ?></h1>
		<div class="nav-link">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'jolene' ) );
			else :
				$next = next_post_link( '%link ', __( '<span class="nav-next">%title &rarr;</span>', 'jolene' ) );
				if ( $next ) :
					previous_post_link( '%link', __( '<span class="nav-previous">&larr; %title</span>', 'jolene' ) );
					$next;
				else :
					previous_post_link( '%link', __( '<span class="nav-previous-one">&larr; %title</span>', 'jolene' ) );
				endif;
				
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<div class="clear-right"></div>
	<?php
}
endif;

if ( ! function_exists( 'jolene_post_thumbnail_small' ) ) :
/**
 * Display post thumbnail.
 *
 * @since jolene 1.0
 */
function jolene_post_thumbnail_small() {

	$defaults = jolene_get_defaults();

	if ( 'small' == get_theme_mod('post_thumbnail', $defaults['post_thumbnail'] ) ) : 
		if( ! is_page() ) : ?>
			<div class="image-and-cats">
				<div class="category-list">
					<?php echo get_the_category_list(); ?>
				</div>
				<?php if ( ! post_password_required() && ! is_attachment() ) :
							the_post_thumbnail();
				endif; ?>
			</div>
		<?php else :
			 if ( has_post_thumbnail() ) : ?>
				<div class="image-and-cats">
					<?php the_post_thumbnail(); ?>
				</div><!-- .image-and-cats -->
		<?php endif; 
		endif; 
	 endif; 
}
endif;

if ( ! function_exists( 'jolene_post_thumbnail_big' ) ) :
/**
 * Display post thumbnail.
 *
 * @since jolene 1.0
 */
function jolene_post_thumbnail_big() {

	$defaults = jolene_get_defaults();

	if ( 'big' == get_theme_mod('post_thumbnail', $defaults['post_thumbnail']) || 
		('large' == get_theme_mod('post_thumbnail', $defaults['post_thumbnail']) && ( is_archive() || is_home() || is_search()) ) ) : 
		if( ! is_page() ) : ?>
			<div class="image-and-cats-big">
				<div class="category-list">
					<?php echo get_the_category_list(); ?>
				</div>
				<?php if ( ! post_password_required() && ! is_attachment() ) :
							the_post_thumbnail('jolene-full-width');
				endif; ?>
			</div>
		<?php else :
				if ( has_post_thumbnail() ) : ?>
				<div class="image-and-cats-big">
					<?php the_post_thumbnail('jolene-full-width'); ?>
				</div><!-- .image-and-cats-big -->
			<?php endif; 
		endif; 
	endif; 
}
endif;

if ( ! function_exists( 'jolene_post_nav' ) ) :
/**
 * Display navigation to next/previous post.
 *
 * @since jolene 1.0
 */
function jolene_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}

	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'jolene' ); ?></h1>
		<div class="nav-link">
			<?php
			if ( is_attachment() ) :
				previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'jolene' ) );
			else :
				$next = next_post_link( '%link ', __( '<span class="nav-next">%title &rarr;</span>', 'jolene' ) );
				if ( $next ) :
					previous_post_link( '%link', __( '<span class="nav-previous">&larr; %title</span>', 'jolene' ) );
					$next;
				else :
					previous_post_link( '%link', __( '<span class="nav-previous-one">&larr; %title</span>', 'jolene' ) );
				endif;
				
			endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<div class="clear"></div>
	<?php
}
endif;

if ( ! function_exists( 'jolene_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since jolene 1.0
 */
function jolene_paging_nav() {

	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $GLOBALS['wp_query']->max_num_pages,
		'current'  => $paged,
		'mid_size' => 1,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&larr; Previous', 'jolene' ),
		'next_text' => __( 'Next &rarr;', 'jolene' ),
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'jolene' ); ?></h1>
		<div class="pagination loop-pagination">
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
	
}
endif;

if ( ! function_exists( 'jolene_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since jolene 1.0
 */
function jolene_the_attached_image() {
	$post                = get_post();

	$attachment_size     = apply_filters( 'jolene_attachment_size', array( 987, 9999 ) );
	$next_attachment_url = wp_get_attachment_url();

	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'jolene_posted_on' ) ) :
/**
 * Print HTML with meta information for the current post-date/time and author.
 *
 * @since Jolene 1.0
 */
function jolene_posted_on() {
	if ( is_sticky() && is_home() && ! is_paged() ) {
		echo '<span class="featured-post">' . __( 'Sticky', 'jolene' ) . '</span>';
	}

	// Set up and print post meta information.
	printf( '<span class="entry-date"><a href="%1$s" rel="bookmark"><time class="entry-date" datetime="%2$s">%3$s</time></a></span> <span class="byline"><span class="author vcard"><a class="url fn n" href="%4$s" rel="author">%5$s</a></span></span>',
		esc_url( get_permalink() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		get_the_author()
	);
	
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'jolene' ), __( '1 Comment', 'jolene' ), __( '% Comments', 'jolene' ) );
		echo '</span>';
	}
}
endif;

if ( ! function_exists( 'jolene_max_content_size' ) ) :
/**
 * Return max page and post width.
 *
 * @since jolene 1.0
 */

function jolene_max_content_size() {

	$defaults = jolene_get_defaults();
	
	$max_content_width = get_theme_mod('content_width_no_sidebar', $defaults['content_width']);
	$max_content_width = ($max_content_width > get_theme_mod('content_width_right_sidebar', 0) ? $max_content_width : get_theme_mod('content_width_right_sidebar', 0));
	$max_content_width = ($max_content_width > get_theme_mod('content_width_left_sidebar', 0) ? $max_content_width : get_theme_mod('content_width_left_sidebar', 0));

	$max_content_width_page = get_theme_mod('content_width_no_sidebar_page', $defaults['content_width_page']);
	$max_content_width_page = ($max_content_width_page > get_theme_mod('content_width_right_sidebar_page', $defaults['content_width_page']) ? $max_content_width_page : get_theme_mod('content_width_right_sidebar_page', $defaults['content_width_page']));
	$max_content_width_page = ($max_content_width_page > get_theme_mod('content_width_left_sidebar_page', 0) ? $max_content_width_page : get_theme_mod('content_width_left_sidebar_page', 0));
	  
	$max_content_width = ($max_content_width > $max_content_width_page ? $max_content_width : $max_content_width_page );
	return $max_content_width - 22; 
}
endif;

if ( ! function_exists( 'jolene_content_width' ) ) :
/**
 * Adjust content width in certain contexts.
 *
 * @since Jolene 1.0
 */
function jolene_content_width() {
	$defaults = jolene_get_defaults();
	$width = 0;
	if ( is_page_template( 'page-templates/full-width-wide.php' )) {
		$width = get_theme_mod('content_width_no_sidebar_wide_page', $defaults['content_width_page_no_sidebar_wide']);
	}
	elseif ( is_page_template( 'page-templates/full-width.php' )) {
		$width = get_theme_mod('content_width_no_sidebar_page', $defaults['content_width_no_sidebar_page']);
	}
	elseif ( is_page_template( 'page-templates/right-sidebar.php' ) ) {
		if ( is_active_sidebar( 'sidebar-4' ))
			$width = get_theme_mod('content_width_right_sidebar_page', $defaults['content_width_page']);
		else
			$width = get_theme_mod('content_width_no_sidebar_page', $defaults['content_width_no_sidebar_page']);
	}
	elseif ( is_page_template( 'page-templates/left-sidebar.php' )) {
		if ( is_active_sidebar( 'sidebar-3' ))
			$width = get_theme_mod('content_width_left_sidebar_page', $defaults['content_width_page']);
		else
			$width = get_theme_mod('content_width_no_sidebar_page', $defaults['content_width_no_sidebar_page']);
	}
	elseif ( is_page() ) {
		if( is_page_template( 'page-templates/front-page.php' )) {
			if( ! is_active_sidebar( 'sidebar-13' ) && is_active_sidebar( 'sidebar-14' )) {//right sidebar
				$width = get_theme_mod('content_width_right_sidebar_page', $defaults['content_width_page']);
			}
			elseif( is_active_sidebar( 'sidebar-13' ) && ! is_active_sidebar( 'sidebar-14' )) {//left sidebar
				$width = get_theme_mod('content_width_left_sidebar_page', $defaults['content_width_page']);	
			}
			else
				$width = get_theme_mod('content_width_no_sidebar_page', $defaults['content_width_no_sidebar_page']);
		}
		elseif( ! is_active_sidebar( 'sidebar-3' ) && is_active_sidebar( 'sidebar-4' )) {//right sidebar
			$width = get_theme_mod('content_width_right_sidebar_page', $defaults['content_width_page']);
		}
		elseif( ! is_active_sidebar( 'sidebar-4' ) && is_active_sidebar( 'sidebar-3' )) {//left sidebar
			$width = get_theme_mod('content_width_left_sidebar_page', $defaults['content_width_page']);
		}
		elseif( is_active_sidebar( 'sidebar-4' ) && is_active_sidebar( 'sidebar-3' )) {//2 sidebars
			$width = (749 > get_theme_mod('content_width_no_sidebar_page') ? 749 : get_theme_mod('content_width_no_sidebar_page')) ;
		}
		else {
			$width = get_theme_mod('content_width_no_sidebar_page', $defaults['content_width_no_sidebar_page']);
		}
	}
	else {
		if( is_active_sidebar( 'sidebar-1' ) && ! is_active_sidebar( 'sidebar-2' )) {//left sidebar
			$width = get_theme_mod('content_width_left_sidebar', $defaults['content_width']);
		}
		elseif( is_active_sidebar( 'sidebar-2' ) && ! is_active_sidebar( 'sidebar-1' )) {//right sidebar
			$width = get_theme_mod('content_width_right_sidebar', $defaults['content_width']);
		}
		elseif( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' )) {//2 sidebars
			$width = (749 > get_theme_mod('content_width_no_sidebar') ? 749 : get_theme_mod('content_width_no_sidebar')) ;
		}
		else {
			$width = get_theme_mod('content_width_no_sidebar', $defaults['content_width']);
		}
	}
	
	if($width > 0) {
		global $content_width;
		$content_width = $width - 24; //border and margins
	}
}
add_action( 'template_redirect', 'jolene_content_width' );
endif;

 /**
 * Return array default theme options
 *
 * @since Jolene 1.0.1
 */
function jolene_get_defaults() {
	$defaults = array();
	$defaults['logotype_url'] =  get_template_directory_uri() . '/img/logo.png';
	$defaults['is_show_top_menu'] = '1';
	$defaults['is_show_secont_top_menu'] = '1';
	$defaults['is_show_footer_menu'] = '1';
		
	$defaults['color_scheme'] = 'blue';
	$defaults['post_thumbnail'] = 'big';
	$defaults['content_width'] = 749;
	$defaults['content_width_page'] = 960;
	$defaults['content_width_no_sidebar_page'] = 749;
	$defaults['content_width_page_no_sidebar_wide'] = 960;
	
	$defaults['scroll_button'] = 'right';
	$defaults['scroll_animate'] = 'none';
	
	$defaults['favicon'] = '';

	$defaults['is_header_on_front_page_only'] = '1';
	$defaults['is_text_on_front_page_only'] = '1';
	$defaults['is_second_menu_on_front_page_only'] = '1';
	
	$defaults['is_empty_8_on'] = 0;
	$defaults['is_empty_6_on'] = 0;
	
	$defaults['is_has_shop_sidebar'] = '';
	$defaults['is_has_mobile_sidebar'] = '';
	
	/* Font Settings */
	$defaults['font_size'] = '16';
	$defaults['heading_font_size'] = '36';
	$defaults['heading_weight'] = 'bold';
	$defaults['header_font'] = 'Lobster';
	$defaults['heading_font'] = '0';
	$defaults['body_font'] = 'Open Sans';
	
	return apply_filters( 'jolene_option_defaults', $defaults );
}
/**
 * Print Demo Widget into the empty sidebar-8.
 *
 * @since Jolene 1.0.1
 */
function jolene_empty_sidebar_8() {
	the_widget('jolene_SocialIcons', 'facebook=#&twitter=#&wordpress=#&rss=#');
}
add_action('jolene_empty_sidebar_8', 'jolene_empty_sidebar_8');
/**
 * Print Demo Widget into the empty sidebar-6.
 *
 * @since Jolene 1.0.1
 */
function jolene_empty_sidebar_6() {
	the_widget( 'WP_Widget_Text', 'title='.__('Sample+Widget+1', 'jolene').'&text=<div style="margin-top: 50px;font-size: 20px;border:1px solid green; background: #eee;color:green;text-align: center;">'.__('You can select a Widget to be shown at the footer sidebar of your website by choosing from the page <span style="color:red;font-family: \'Lobster\', sans-serif;">"Appearance > Widgets"</span>', 'jolene').'</div>', 'before_widget=<div class="widget-wrap"><aside class="widget">&after_widget=</aside></div>&before_title=<h3 class="widget-title">&after_title=</h3>');
	the_widget( 'WP_Widget_Text', 'title='.__('Sample+Widget+2', 'jolene').'&text=<div style="margin-top: 50px;font-size: 20px;border:1px solid green; background: #eee;color:green;text-align: center;">'.__('You can replace this Text Widget by any other at the page <span style="color:red;font-family: \'Lobster\', sans-serif;">"Appearance > Widgets"</span>', 'jolene').'</div>', 'before_widget=<div class="widget-wrap"><aside class="widget">&after_widget=</aside></div>&before_title=<h3 class="widget-title">&after_title=</h3>');
	the_widget( 'WP_Widget_Text', 'title='.__('Sample+Widget+3', 'jolene').'&text=<div style="margin-top: 50px;font-size: 20px;border:1px solid green; background: #eee;color:green;text-align: center;">'.__('You can add as many Widgets as you want to be shown at the footer sidebar of your website by choosing from the page <span style="color:red;font-family: \'Lobster\', sans-serif;">"Appearance > Widgets"</span>', 'jolene').'</div>', 'before_widget=<div class="widget-wrap"><aside class="widget">&after_widget=</aside></div>&before_title=<h3 class="widget-title">&after_title=</h3>');
	the_widget( 'WP_Widget_Calendar', 'title='.__('Calendar', 'jolene').'&sortby=post_modified', 'before_widget=<div class="widget-wrap"><aside class="widget widget_calendar">&after_widget=</aside></div>&before_title=<h3 class="widget-title">&after_title=</h3>');
	the_widget( 'WP_Widget_Recent_Posts', 'title='.__('Sample+Widget+5', 'jolene').'&sortby=post_modified', 'before_widget=<div class="widget-wrap"><aside class="widget">&after_widget=</aside></div>&before_title=<h3 class="widget-title">&after_title=</h3>');
	the_widget( 'WP_Widget_Search', 'title='.__('Search', 'jolene'), 'before_widget=<div class="widget-wrap"><aside class="widget widget_search">&after_widget=</aside></div>&before_title=<h3 class="widget-title">&after_title=</h3>');
}
add_action('jolene_empty_sidebar_6', 'jolene_empty_sidebar_6');
 /**
 * Print credit links and scroll to top button
 *
 * @since Jolene 1.0.1
 */
function jolene_site_info() {
	$defaults = jolene_get_defaults();
 
?>
	<div class="site-info">
		<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'jolene' )); ?>"><?php printf( __( 'Proudly powered by %s', 'jolene' ), 'WordPress' ); ?></a><?php esc_html( _e( ' theme by ', 'jolene' ) ); ?><a href="<?php echo esc_url( 'http://wpblogs.ru/themes/' ); ?>">WP Blogs</a>
	</div><!-- .site-info -->
	
	<?php if ( get_theme_mod( 'scroll_button', $defaults['scroll_button'] ) != 'none' ) : ?>
		<a href="#" class="scrollup <?php echo esc_attr(get_theme_mod( 'scroll_button', $defaults['scroll_button'] )).
			esc_attr(get_theme_mod( 'scroll_animate', $defaults['scroll_animate'] ) == 'none' ? '' : ' '.get_theme_mod( 'scroll_animate', $defaults['scroll_animate'] ) ); ?>"></a>
	<?php endif; 
}
add_action( 'jolene_site_info', 'jolene_site_info' );

 /**
 * Print Footer Menu
 *
 * @since Jolene 1.0.1
 */
function jolene_echo_footer_menu() {
	$defaults = jolene_get_defaults();
 
	if ( get_theme_mod( 'is_show_footer_menu', $defaults['is_show_footer_menu'] ) == '1' ) : ?>
		<div id="footer-navigation" class="nav-container">
			<nav id="menu-4" class="horisontal-navigation" role="navigation">
				<h3 class="menu-toggle"></h3>
				<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'nav-horizontal' ) ); ?>
			</nav>
			<div class="clear"></div>
		</div>
	<?php else : ?>
		<div class="empty-menu"></div>
	<?php endif; ?>
	<div class="clear"></div>
<?php 
}
add_action( 'jolene_footer_menu', 'jolene_echo_footer_menu' );

/**
 * Print Favicon.
 *
 * @since Jolene 1.0.1
 */
function jolene_hook_favicon() {
	$defaults = jolene_get_defaults();
?>
	<?php if ( get_theme_mod( 'favicon', $defaults['favicon'] ) != '' ) : ?>
		<link rel="shortcut icon" href="<?php echo esc_url(get_theme_mod( 'favicon', $defaults['favicon'] )); ?>" />
	<?php endif;
}
add_action('wp_head', 'jolene_hook_favicon');


/**
 * return sidebar width.
 *
 * @since Jolene 1.0.1
 */
function jolene_get_width( $sidebar_id ) {	
	$width = 300;
	switch ( $sidebar_id ) {
		case 'sidebar-8':
			$width = 280;
		break;
	//columns
		case 'sidebar-1':
		case 'sidebar-2':
		case 'sidebar-3':
		case 'sidebar-4':
		case 'sidebar-13':
		case 'sidebar-14':
			$width = 238;
		break;
	//footer sidebar
		case 'sidebar-6':
			$width = 208;
		break;
	//content sidebars
		case 'sidebar-11':
		case 'sidebar-7':
		case 'sidebar-12':
			$width = 707;
		break;
	//100% sidebars
		case 'sidebar-10':
		case 'sidebar-5':
		case 'sidebar-15':
			$width = 1289;
		break;
	}
	return $width;
}

 /**
 * Print the Header Image or large post image.
 *
 * @since Jolene 1.0.1
 */
function jolene_header_image() {

	$defaults = jolene_get_defaults();
	
	if (  'large' == get_theme_mod( 'post_thumbnail', $defaults['post_thumbnail'] ) && !(function_exists('is_woocommerce') && is_woocommerce()) && ! is_front_page() && ! is_archive() && ! is_home() && ! is_search() ) {

		if( ! is_page() ) : ?>
			<div class="img-container">
				<div class="header-wrapper">
					<div class="image-and-cats-large">
						<div class="category-list">	
						<!-- Category-->
							<div class="site-cat">
								<h1 class="site-title"><?php echo get_the_category_list(', '); ?></h1>
							</div>
						</div>
						<?php if ( ! post_password_required() && ! is_attachment() ) :
									the_post_thumbnail('jolene-full-screen');
						endif; ?>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		<?php else :
				if ( has_post_thumbnail() ) : ?>
				<div class="img-container">
					<div class="header-wrapper">
						<div class="image-and-cats-large">
							<?php the_post_thumbnail('jolene-full-screen'); ?>
						</div><!-- .image-and-cats-big -->
					</div>
				</div>
			<?php endif; 
		endif; 	
		
		
	} else {
	
		if ( get_header_image() 
				&& ( get_theme_mod( 'is_header_on_front_page_only', $defaults['is_header_on_front_page_only'] ) != '1' || is_front_page())) : ?>		

			<div class="img-container">
				<?php if ( display_header_text() ) : ?>
					<!-- Site Name -->
					<div class="site-info-text">
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<!-- Dscription -->
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					</div>
				<?php endif; ?>
				
				<!-- Banner -->
				<div class="header-wrapper">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<img src="<?php header_image(); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
					</a>
				</div>

			</div>
		<?php endif;
	}
}
add_action( 'jolene_header_image', 'jolene_header_image' );

/**
 * Add new wrapper for woocommerce pages.
 *
 * @since Jolene 1.0.1
 */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action('woocommerce_before_main_content', 'jolene_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'jolene_wrapper_end', 10);

function jolene_wrapper_start() {
  echo '<div id="woocommerce-wrapper">';
}

function jolene_wrapper_end() {
  echo '</div>';
}


// Add custom widget.
require get_template_directory() . '/inc/widget.php';
// Add custom social media icons widget.
require get_template_directory() . '/inc/social-media-widget.php';
// Add customize options.
require get_template_directory() . '/inc/customize.php';
// Add customize options for fonts.
require get_template_directory() . '/inc/customize-fonts.php';

if ( ! is_child_theme() ) :
	// Add customize options for info.
	require get_template_directory() . '/inc/customize-info.php';
endif;