<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage Jolene
 * @since Jolene 1.0
 */
 
 		if ( is_page_template( 'page-templates/front-page.php' ) || is_front_page() ) :
			get_sidebar('home-bottom-content');
		endif;
?>
				</div><!-- .content -->
				<div class="clear"></div>
			</div><!-- .site-content -->
			<?php get_sidebar('before-footer'); ?>
			<footer id="colophon" class="site-footer">
	
				<?php do_action('jolene_footer_menu'); ?>				
				<?php get_sidebar('footer'); ?>
				<?php do_action('jolene_site_info'); ?>

			</footer><!-- #colophon -->
	</div><!-- #page -->
	<?php wp_footer(); ?>
</body>
</html>