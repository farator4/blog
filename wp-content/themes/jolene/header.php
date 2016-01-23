<?php
/**
 * The template for displaying the header
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
			<!-- Header -->
			<?php $defaults = jolene_get_defaults(); ?>
			<!-- Header text while header image is empty -->
			<header id="masthead" class="site-header" role="banner">	
				<?php if ( display_header_text() && ( get_header_image() == '' 
							|| ( ! is_front_page() && get_theme_mod( 'is_header_on_front_page_only', $defaults['is_header_on_front_page_only'] ) == '1' 
												   && get_theme_mod( 'is_text_on_front_page_only', $defaults['is_text_on_front_page_only'] ) != '1')  )) : ?>

					<div class="site-info-text-top">
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<!-- Dscription -->
						<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
						<br class="clear">
					</div>
					
				<?php endif; ?>

				<!-- First Top Menu -->		
					<div id="top-1-navigation" class="nav-container">
					
						<?php if ( get_theme_mod( 'logotype_url', $defaults['logotype_url'] ) != '' ) : ?>

							<a class="logo-section" href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
								<img src='<?php echo esc_url( get_theme_mod( 'logotype_url', $defaults['logotype_url'] ) ); ?>' class="logo" alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
							</a>
							
						<?php endif; ?>
						
						<?php get_sidebar('header'); ?>
						
						<?php if ( get_theme_mod( 'is_show_top_menu', $defaults['is_show_top_menu'] ) == '1' ) : ?>
							<nav id="menu-1" class="horisontal-navigation" role="navigation">
								<h3 class="menu-toggle"></h3>
								<?php wp_nav_menu( array( 'theme_location' => 'top1', 'menu_class' => 'nav-horizontal' ) ); ?>
							</nav>
						<?php endif; ?>
						<div class="clear"></div>
					</div>
					
				<?php do_action('jolene_header_image') ?>

				<?php get_sidebar('top'); ?>
				<!-- Second Top Menu -->	
				<?php if ( get_theme_mod( 'is_show_secont_top_menu', $defaults['is_show_secont_top_menu']) == '1'
					&& (get_theme_mod( 'is_second_menu_on_front_page_only', $defaults['is_second_menu_on_front_page_only']) != '1' || is_front_page())) : ?>
					<div id="top-navigation" class="nav-container">
						<nav id="menu-2" class="horisontal-navigation" role="navigation">
							<h3 class="menu-toggle"></h3>
							<?php wp_nav_menu( array( 'theme_location' => 'top2', 'menu_class' => 'nav-horizontal' ) ); ?>
						</nav>
						<div class="clear"></div>
					</div>
				<?php endif; ?>
				<?php get_sidebar(); ?>
				<?php get_sidebar('right'); ?>

			</header><!-- #masthead -->
	
			<div class="site-content"> 
				<div class="content">
				<?php if ( is_page_template( 'page-templates/front-page.php' ) || is_front_page() ) : 
					get_sidebar('home-top-content');
				endif; ?>