<?php
/**
 * The header template file.
 * @package LeatherDiary
 * @since LeatherDiary 1.0.0
*/
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<?php global $leatherdiary_options_db; ?>
  <meta charset="<?php bloginfo( 'charset' ); ?>" /> 
  <meta name="viewport" content="width=device-width" />  
<?php if ( ! function_exists( '_wp_render_title_tag' ) ) { ?><title><?php wp_title( '|', true, 'right' ); ?></title><?php } ?>  
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">  
<?php if ($leatherdiary_options_db['leatherdiary_favicon_url'] != ''){ ?>
	<link rel="shortcut icon" href="<?php echo $leatherdiary_options_db['leatherdiary_favicon_url']; ?>" />
<?php } ?>
<?php wp_head(); ?>   
</head>
 
<body <?php body_class(); ?> id="wrapper">
<div id="page">
<div id="main-wrapper">
  <header id="header">
<?php if ( !is_page_template('template-landing-page.php') ) { ?>
<?php if ( has_nav_menu( 'top-navigation' ) || !empty($leatherdiary_options_db['leatherdiary_header_facebook_link']) || !empty($leatherdiary_options_db['leatherdiary_header_twitter_link']) || !empty($leatherdiary_options_db['leatherdiary_header_google_link']) || !empty($leatherdiary_options_db['leatherdiary_header_linkedin_link']) || !empty($leatherdiary_options_db['leatherdiary_header_rss_link']) ) {  ?>
    <div id="top-navigation">
<?php if ( has_nav_menu( 'top-navigation' ) ) { wp_nav_menu( array( 'menu_id'=>'top-nav', 'theme_location'=>'top-navigation' ) ); } ?>
      
      <div class="header-icons">
<?php if ( !empty($leatherdiary_options_db['leatherdiary_header_facebook_link']) ){ ?>
        <a class="social-icon facebook-icon" href="<?php echo esc_url($leatherdiary_options_db['leatherdiary_header_facebook_link']); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon-facebook.png" alt="Facebook" /></a>
<?php } ?>
<?php if ( !empty($leatherdiary_options_db['leatherdiary_header_twitter_link']) ){ ?>
        <a class="social-icon twitter-icon" href="<?php echo esc_url($leatherdiary_options_db['leatherdiary_header_twitter_link']); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon-twitter.png" alt="Twitter" /></a>
<?php } ?>
<?php if ( !empty($leatherdiary_options_db['leatherdiary_header_google_link']) ){ ?>
        <a class="social-icon google-icon" href="<?php echo esc_url($leatherdiary_options_db['leatherdiary_header_google_link']); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon-google.png" alt="Google +" /></a>
<?php } ?>
<?php if ( !empty($leatherdiary_options_db['leatherdiary_header_linkedin_link']) ){ ?>
        <a class="social-icon linkedin-icon" href="<?php echo esc_url($leatherdiary_options_db['leatherdiary_header_linkedin_link']); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon-linkedin.png" alt="LinkedIn" /></a>
<?php } ?>
<?php if ( !empty($leatherdiary_options_db['leatherdiary_header_rss_link']) ){ ?>
        <a class="social-icon rss-icon" href="<?php echo esc_url($leatherdiary_options_db['leatherdiary_header_rss_link']); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon-rss.png" alt="RSS" /></a>
<?php } ?>
      </div>
    </div>
<?php }} ?>
    
    <div class="header-content">
<?php if ( $leatherdiary_options_db['leatherdiary_header_title_format'] != 'Logo' ) { ?>
      <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
<?php if ( $leatherdiary_options_db['leatherdiary_display_site_description'] != 'Hide' ) { ?>
      <p class="site-description"><?php bloginfo( 'description' ); ?></p>
<?php } ?>
<?php } else { ?>
<?php if ( $leatherdiary_options_db['leatherdiary_logo_url'] != '' ) { ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img class="header-logo" src="<?php echo $leatherdiary_options_db['leatherdiary_logo_url']; ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
<?php } else { ?>
       <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img class="header-logo" src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php bloginfo( 'name' ); ?>" /></a>
<?php } ?>
<?php } ?>

<?php if ( $leatherdiary_options_db['leatherdiary_display_header_searchform'] != 'Hide' ) { ?> 
<?php if ( !is_page_template('template-landing-page.php') ) { ?>
<?php get_search_form(); ?>
<?php }} ?>
    </div> <!-- end of header-content -->
    
<?php if ( is_home() || is_front_page() ) { ?>
<?php if ( get_header_image() != '' ) { ?>
    <img class="header-image" src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>" />
<?php } ?>
<?php } else { ?>
<?php if ( get_header_image() != '' && isset($leatherdiary_options_db['leatherdiary_display_header_image']) ) { ?>
<?php if ( $leatherdiary_options_db['leatherdiary_display_header_image'] != 'Only on Homepage'  ) { ?>
    <img class="header-image" src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>" />
<?php }} ?>
<?php } ?>

<?php if ( $leatherdiary_options_db['leatherdiary_display_fixed_menu'] != 'Hide' ) { ?> 
<?php if ( !is_page_template('template-landing-page.php') ) { ?>   
    <div id="fixed-navigation-wrapper">
    <nav id="fixed-navigation">
      <div class="fixed-navigation-background"></div>
      <a class="fix-nav-home" href="<?php echo esc_url( home_url( '/' ) ); ?>"></a>
      <div class="fix-nav-wrapper">
<?php wp_nav_menu( array( 'menu_id'=>'fix-nav', 'theme_location'=>'fixed-navigation' ) ); ?>
      </div>
      <div class="scroll-top"></div>
    </nav>
    </div>
<?php }} ?>
  </header>