<?php
/**
 * Headerdata of Theme options.
 * @package LeatherDiary
 * @since LeatherDiary 1.0.0
*/  

// additional js and css
if(	!is_admin()){
function leatherdiary_fonts_include () {
global $leatherdiary_options_db;
// Google Fonts
$bodyfont = $leatherdiary_options_db['leatherdiary_body_google_fonts'];
$headingfont = $leatherdiary_options_db['leatherdiary_headings_google_fonts'];
$descriptionfont = $leatherdiary_options_db['leatherdiary_description_google_fonts'];
$headlinefont = $leatherdiary_options_db['leatherdiary_headline_google_fonts'];
$headlineboxfont = $leatherdiary_options_db['leatherdiary_headline_box_google_fonts'];
$postentryfont = $leatherdiary_options_db['leatherdiary_postentry_google_fonts'];
$sidebarfont = $leatherdiary_options_db['leatherdiary_sidebar_google_fonts'];
$menufont = $leatherdiary_options_db['leatherdiary_menu_google_fonts'];
$topmenufont = $leatherdiary_options_db['leatherdiary_top_menu_google_fonts'];

$fonturl = "//fonts.googleapis.com/css?family=";

$bodyfonturl = $fonturl.$bodyfont;
$headingfonturl = $fonturl.$headingfont;
$descriptionfonturl = $fonturl.$descriptionfont;
$headlinefonturl = $fonturl.$headlinefont;
$headlineboxfonturl = $fonturl.$headlineboxfont;
$postentryfonturl = $fonturl.$postentryfont;
$sidebarfonturl = $fonturl.$sidebarfont;
$menufonturl = $fonturl.$menufont;
$topmenufonturl = $fonturl.$topmenufont;
	// Google Fonts
     if ($bodyfont != 'default' && $bodyfont != ''){
      wp_enqueue_style('leatherdiary-google-font1', $bodyfonturl); 
		 }
     if ($headingfont != 'default' && $headingfont != ''){
      wp_enqueue_style('leatherdiary-google-font2', $headingfonturl);
		 }
     if ($descriptionfont != 'default' && $descriptionfont != ''){
      wp_enqueue_style('leatherdiary-google-font3', $descriptionfonturl);
		 }
     if ($headlinefont != 'default' && $headlinefont != ''){
      wp_enqueue_style('leatherdiary-google-font4', $headlinefonturl); 
		 }
     if ($postentryfont != 'default' && $postentryfont != ''){
      wp_enqueue_style('leatherdiary-google-font5', $postentryfonturl); 
		 }
     if ($sidebarfont != 'default' && $sidebarfont != ''){
      wp_enqueue_style('leatherdiary-google-font6', $sidebarfonturl);
		 }
     if ($menufont != 'default' && $menufont != ''){
      wp_enqueue_style('leatherdiary-google-font8', $menufonturl);
		 }
     if ($topmenufont != 'default' && $topmenufont != ''){
      wp_enqueue_style('leatherdiary-google-font9', $topmenufonturl);
		 }
     if ($headlineboxfont != 'default' && $headlineboxfont != ''){
      wp_enqueue_style('leatherdiary-google-font10', $headlineboxfonturl); 
		 }
}
add_action( 'wp_enqueue_scripts', 'leatherdiary_fonts_include' );
}

// additional js and css
function leatherdiary_css_include () {
global $leatherdiary_options_db;
	if ($leatherdiary_options_db['leatherdiary_css'] == 'Green (default)' ){
			wp_enqueue_style('leatherdiary-style', get_stylesheet_uri());
		}

		if ($leatherdiary_options_db['leatherdiary_css'] == 'Brown' ){
			wp_enqueue_style('leatherdiary-style-brown', get_template_directory_uri().'/css/brown.css');
		}
    
    if ($leatherdiary_options_db['leatherdiary_css'] == 'Orange' ){
			wp_enqueue_style('leatherdiary-style-orange', get_template_directory_uri().'/css/orange.css');
		}

		if ($leatherdiary_options_db['leatherdiary_css'] == 'Pink' ){
			wp_enqueue_style('leatherdiary-style-pink', get_template_directory_uri().'/css/pink.css');
		}
    
    if ($leatherdiary_options_db['leatherdiary_css'] == 'Silver' ){
			wp_enqueue_style('leatherdiary-style-silver', get_template_directory_uri().'/css/silver.css');
		}
    
    if ($leatherdiary_options_db['leatherdiary_css'] == 'Tan' ){
			wp_enqueue_style('leatherdiary-style-tan', get_template_directory_uri().'/css/tan.css');
		}
    
    if ($leatherdiary_options_db['leatherdiary_css'] == 'Turquoise' ){
			wp_enqueue_style('leatherdiary-style-turquoise', get_template_directory_uri().'/css/turquoise.css');
		}
}
add_action( 'wp_enqueue_scripts', 'leatherdiary_css_include' );

// Page Alignment
function leatherdiary_page_alignment() {
global $leatherdiary_options_db;
    $page_alignment = $leatherdiary_options_db['leatherdiary_page_alignment']; 
		if ($page_alignment == 'Center') { ?>
		<?php _e('#wrapper #page { margin: 0 auto; } @media screen and (max-width: 1100px) { #wrapper #header #fixed-navigation-wrapper { position: fixed; } }', 'leatherdiary'); ?>
<?php } 
}

// Background Pattern
function leatherdiary_get_background_pattern() {
    $background_color = get_background_color(); 
    if ($background_color != '') { ?>
		<?php _e('html body { background: none; }', 'leatherdiary'); ?>
<?php } 
}

// Display sidebar on Pages
function leatherdiary_display_sidebar_pages() {
global $leatherdiary_options_db;
    $display_sidebar_pages = $leatherdiary_options_db['leatherdiary_display_sidebar_pages']; 
		if ($display_sidebar_pages == 'Hide') { ?>
		<?php _e('html .page #main-content #content, html .woocommerce-page #main-wrapper #main-content #content { width: 100%; }', 'leatherdiary'); ?>
<?php } 
}

// Display sidebar on Posts
function leatherdiary_display_sidebar_posts() {
global $leatherdiary_options_db;
    $display_sidebar_posts = $leatherdiary_options_db['leatherdiary_display_sidebar_posts']; 
		if ($display_sidebar_posts == 'Hide') { ?>
		<?php _e('html .single-post #main-content #content { width: 100%; }', 'leatherdiary'); ?>
<?php } 
}

// Display sidebar on Homepage and Archive Pages
function leatherdiary_display_sidebar_archive() {
global $leatherdiary_options_db;
    $display_sidebar_archive = $leatherdiary_options_db['leatherdiary_display_sidebar_archive'];
    $theme_folder = get_template_directory_uri(); 
		if ($display_sidebar_archive == 'Display') { ?>
		<?php echo 'html .blog #main-content #content, html .archive #main-content #content, html .search #main-content #content  { margin-right: 35px; width: 545px; } .post-entry .attachment-post-thumbnail { max-width: 50%; } #wrapper .post-entry-column-first .attachment-post-thumbnail { max-width: 90%; } html .archive #main-content .breadcrumb-navigation-wrapper, html .search #main-content .breadcrumb-navigation-wrapper { background: left bottom repeat-x url('; ?><?php echo esc_url($theme_folder); ?><?php echo '/images/double-dotted.png) !important; } .archive #main-content .entry-headline, .search #main-content .entry-headline { background-image: none; padding: 8px 0 10px; }'; ?>
<?php } 
}

// Display Fixed Menu - page width
function leatherdiary_display_fixed_menu() {
global $leatherdiary_options_db;
    $display_fixed_menu = $leatherdiary_options_db['leatherdiary_display_fixed_menu']; 
		if ($display_fixed_menu == 'Hide') { ?>
		<?php _e('#wrapper #main-content, #wrapper .header-content, #wrapper #top-navigation { padding-right: 45px; } #wrapper #page { max-width: 900px; } #wrapper .header-content #searchform .searchform-wrapper { right: 45px; } #wrapper #page .header-content { padding-top: 35px; } #wrapper .post-entry .date-arrow { display: none; } .rtl #main-content, .rtl .header-content, .rtl #top-navigation { padding-left: 45px; } .rtl .header-content #searchform .searchform-wrapper { left: 45px; right: auto !important; }', 'leatherdiary'); ?>
<?php } 
}

// Fixed Menu position
function leatherdiary_position_fixed_menu() {
global $leatherdiary_options_db;
    $position_fixed_menu = $leatherdiary_options_db['leatherdiary_position_fixed_menu']; 
		if ($position_fixed_menu == 'Absolute') { ?>
		<?php _e('#wrapper #page #header #fixed-navigation-wrapper #fixed-navigation { position: absolute; top: 40px; } #wrapper #header #fixed-navigation-wrapper { top: 40px; } #wrapper #page #fixed-navigation .scroll-top { display: none !important; }', 'leatherdiary'); ?>
<?php } 
}

// Display Top Header Menu - responzive displaying of Fixed Menu
function leatherdiary_display_top_menu() {
global $leatherdiary_options_db;
$position_of_fixed_menu = $leatherdiary_options_db['leatherdiary_position_fixed_menu'];
if ( !has_nav_menu( 'top-navigation' ) && empty($leatherdiary_options_db['leatherdiary_header_facebook_link']) && empty($leatherdiary_options_db['leatherdiary_header_twitter_link']) && empty($leatherdiary_options_db['leatherdiary_header_google_link']) && empty($leatherdiary_options_db['leatherdiary_header_linkedin_link']) && empty($leatherdiary_options_db['leatherdiary_header_rss_link']) ) {  ?>
		<?php _e('#wrapper #header #fixed-navigation-wrapper #fixed-navigation { top: 30px; } .admin-bar #page #header #fixed-navigation-wrapper #fixed-navigation { top: 62px; } @media screen and (max-width: 1100px) { #wrapper #header #fixed-navigation-wrapper #fixed-navigation { top: 0 !important; } }', 'leatherdiary'); ?>
<?php if ($position_of_fixed_menu == 'Absolute') { ?>
<?php _e('#wrapper #page #header #fixed-navigation-wrapper { top: 0 !important; }', 'leatherdiary'); } } 
}

// Display header searchform - header title width
function leatherdiary_display_header_searchform() {
global $leatherdiary_options_db;
    $display_header_searchform = $leatherdiary_options_db['leatherdiary_display_header_searchform']; 
		if ($display_header_searchform == 'Hide') { ?>
		<?php _e('#header .site-title, #header .site-description, #header .header-logo { max-width: 100%; }', 'leatherdiary'); ?>
<?php } 
}

// Display Meta Box on single posts - headline margin
function leatherdiary_display_meta_post() {
global $leatherdiary_options_db;
    $display_meta_post = $leatherdiary_options_db['leatherdiary_display_meta_post']; 
		if ($display_meta_post == 'Hide') { ?>
		<?php _e('#wrapper #content .post-entry .post-entry-headline { margin-bottom: 10px; }', 'leatherdiary'); ?>
<?php } 
}

// TEXT FONTS
// Body font
function leatherdiary_get_body_font() {
global $leatherdiary_options_db;
    $bodyfont = $leatherdiary_options_db['leatherdiary_body_google_fonts']; 
    if ($bodyfont != 'default' && $bodyfont != '') { ?>
    <?php _e('html body, #wrapper blockquote, #wrapper q, #wrapper #page #comments .comment, #wrapper #page #comments .comment time, #wrapper #content #commentform .form-allowed-tags, #wrapper #content #commentform p, #wrapper input, #wrapper button, #wrapper select { font-family: "', 'leatherdiary'); ?><?php echo $bodyfont ?><?php _e('", Arial, Helvetica, sans-serif; }', 'leatherdiary'); ?>
<?php } 
}

// Site title font
function leatherdiary_get_headings_google_fonts() {
global $leatherdiary_options_db;
    $headingfont = $leatherdiary_options_db['leatherdiary_headings_google_fonts']; 
		if ($headingfont != 'default' && $headingfont != '') { ?>
		<?php _e('#wrapper #header .site-title { font-family: "', 'leatherdiary'); ?><?php echo $headingfont ?><?php _e('", Arial, Helvetica, sans-serif; }', 'leatherdiary'); ?>
<?php } 
}

// Site description font
function leatherdiary_get_description_font() {
global $leatherdiary_options_db;
    $descriptionfont = $leatherdiary_options_db['leatherdiary_description_google_fonts']; 
    if ($descriptionfont != 'default' && $descriptionfont != '') { ?>
    <?php _e('#wrapper #page #header .site-description {font-family: "', 'leatherdiary'); ?><?php echo $descriptionfont ?><?php _e('", Arial, Helvetica, sans-serif; }', 'leatherdiary'); ?>
<?php } 
}

// Page/post headlines font
function leatherdiary_get_headlines_font() {
global $leatherdiary_options_db;
    $headlinefont = $leatherdiary_options_db['leatherdiary_headline_google_fonts']; 
    if ($headlinefont != 'default' && $headlinefont != '') { ?>
		<?php _e('#wrapper h1, #wrapper h2, #wrapper h3, #wrapper h4, #wrapper h5, #wrapper h6, #wrapper #page .navigation .section-heading { font-family: "', 'leatherdiary'); ?><?php echo $headlinefont ?><?php _e('", Arial, Helvetica, sans-serif; }', 'leatherdiary'); ?>
<?php } 
}

// Homepage Sections headlines font
function leatherdiary_get_headline_box_google_fonts() {
global $leatherdiary_options_db;
    $headline_box_google_fonts = $leatherdiary_options_db['leatherdiary_headline_box_google_fonts']; 
		if ($headline_box_google_fonts != 'default' && $headline_box_google_fonts != '') { ?>
		<?php _e('.home #page #content .entry-headline { font-family: "', 'leatherdiary'); ?><?php echo $headline_box_google_fonts ?><?php _e('", Arial, Helvetica, sans-serif; }', 'leatherdiary'); ?>
<?php } 
}

// Post entry font
function leatherdiary_get_postentry_font() {
global $leatherdiary_options_db;
    $postentryfont = $leatherdiary_options_db['leatherdiary_postentry_google_fonts']; 
		if ($postentryfont != 'default' && $postentryfont != '') { ?>
		<?php _e('#wrapper #page .post-entry .post-entry-headline, #wrapper #page .slides li, #wrapper #page .home-list-posts ul li, #wrapper #page .home-thumbnail-posts .thumbnail-hover { font-family: "', 'leatherdiary'); ?><?php echo $postentryfont ?><?php _e('", Arial, Helvetica, sans-serif; }', 'leatherdiary'); ?>
<?php } 
} 

// Sidebar and Footer widget headlines font
function leatherdiary_get_sidebar_widget_font() {
global $leatherdiary_options_db;
    $sidebarfont = $leatherdiary_options_db['leatherdiary_sidebar_google_fonts'];
    if ($sidebarfont != 'default' && $sidebarfont != '') { ?>
		<?php _e('#wrapper #page #sidebar .sidebar-widget .sidebar-headline, #wrapper #page #footer .footer-widget .footer-headline { font-family: "', 'leatherdiary'); ?><?php echo $sidebarfont ?><?php _e('", Arial, Helvetica, sans-serif; }', 'leatherdiary'); ?>
<?php } 
}

// Fixed menu font
function leatherdiary_get_menu_font() {
global $leatherdiary_options_db;
    $menufont = $leatherdiary_options_db['leatherdiary_menu_google_fonts']; 
		if ($menufont != 'default' && $menufont != '') { ?>
		<?php _e('#wrapper #header #fixed-navigation ul li { font-family: "', 'leatherdiary'); ?><?php echo $menufont ?><?php _e('", Arial, Helvetica, sans-serif; }', 'leatherdiary'); ?>
<?php } 
}

// Header Top menu font
function leatherdiary_get_top_menu_font() {
global $leatherdiary_options_db;
    $topmenufont = $leatherdiary_options_db['leatherdiary_top_menu_google_fonts']; 
		if ($topmenufont != 'default' && $topmenufont != '') { ?>
		<?php _e('#wrapper #header #top-navigation ul li { font-family: "', 'leatherdiary'); ?><?php echo $topmenufont ?><?php _e('", Arial, Helvetica, sans-serif; }', 'leatherdiary'); ?>
<?php } 
}

// User defined CSS.
function leatherdiary_get_own_css() {
global $leatherdiary_options_db;
    $own_css = $leatherdiary_options_db['leatherdiary_own_css']; 
		if ($own_css != '') { ?>
		<?php echo $own_css ?>
<?php } 
}

// Display custom CSS.
function leatherdiary_custom_styles() { ?>
<?php echo ("<style type='text/css'>"); ?>
<?php leatherdiary_get_own_css(); ?>
<?php leatherdiary_page_alignment(); ?>
<?php leatherdiary_get_background_pattern(); ?>
<?php leatherdiary_display_sidebar_pages(); ?>
<?php leatherdiary_display_sidebar_posts(); ?>
<?php leatherdiary_display_sidebar_archive(); ?>
<?php leatherdiary_display_fixed_menu(); ?>
<?php leatherdiary_position_fixed_menu(); ?>
<?php leatherdiary_display_top_menu(); ?>
<?php leatherdiary_display_header_searchform(); ?>
<?php leatherdiary_display_meta_post(); ?>
<?php leatherdiary_get_body_font(); ?>
<?php leatherdiary_get_headings_google_fonts(); ?>
<?php leatherdiary_get_description_font(); ?>
<?php leatherdiary_get_headlines_font(); ?>
<?php leatherdiary_get_headline_box_google_fonts(); ?>
<?php leatherdiary_get_postentry_font(); ?>
<?php leatherdiary_get_sidebar_widget_font(); ?>
<?php leatherdiary_get_menu_font(); ?>
<?php leatherdiary_get_top_menu_font(); ?>
<?php echo ("</style>"); ?>
<?php
} 
add_action('wp_enqueue_scripts', 'leatherdiary_custom_styles');	?>