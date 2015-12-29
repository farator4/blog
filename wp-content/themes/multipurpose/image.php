<?php get_header(); ?>     
<div class="container">
<div class="row-fluid">
<div class="span8">
<div  id="single-post post-<?php the_ID(); ?>" <?php post_class(); ?>> 
<?php 

while(have_posts()): the_post(); ?>
 
<div <?php post_class('post'); ?>>
<div class="clear"></div>
<h1 class="entry-title"><?php the_title(); ?>

<div id="nav-single" class="pull-right"> 
                        <?php previous_image_link( '%link', '<span class="meta-nav"><i class="icon icon-white icon-chevron-left"></i></span> Previous'); ?>
                        <?php next_image_link( '%link', 'Next <span class="meta-nav"><i class="icon icon-white icon-chevron-right"></i></span>' ); ?>
</div>

</h1>
<div class="entry-content">
<a class="thumbnail" href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'large' ); ?></a>
<?php the_content(); ?>
</div>
<?php wp_link_pages( ); ?>
</div>
 <div class="mx_comments"> 
<?php comments_template(); ?>
</div>
<?php endwhile; ?>
</div>
</div>
<div class="span4">
<div class="sidebar">
<?php dynamic_sidebar('Single Post'); ?>
</div>
</div>
</div>
</div>

         

<?php get_footer(); ?>
