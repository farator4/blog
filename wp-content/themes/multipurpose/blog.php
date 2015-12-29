<?php 
//Template Name: Blog
get_header(); ?>    
    
     
            
<div class="container">
<div class="row-fluid">
<div class="span8">
      
<?php 
wp_reset_query();
global $wp_query;
$q = new WP_Query('post_type=post&paged='.$wp_query->query_vars['paged']);
while($q->have_posts()): $q->the_post(); ?>
<div class="post box arc">
<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>&nbsp;</h2> 
<?php multipurpose_post_thumb('edenfresh-responsive-blog-thumb'); ?>  
<div class="entry-content"><?php the_excerpt(); ?>
<div class="breadcrumb">Posted on <?php echo get_the_date(); ?> / Posted by <a href="<?php $taid = get_the_author_meta( 'ID' ); echo get_author_posts_url( $taid ); ?>"><?php the_author(); ?></a> / <a href="<?php the_permalink();?>">read more &#187;</a></div>
</div> 
</div> 
<?php endwhile; ?>               

<?php 
  
if (  $wp_query->max_num_pages > 1 ) : ?>
<div class="clear"></div>
                <div id="nav-below" class="navigation post box arc breadcrumb">
                    <div class="btn"><?php next_posts_link( '<span class="meta-nav">&#9668;</span> Older posts'  ); ?>&nbsp;</div>
                    <div class="btn next-link"><?php previous_posts_link(  'Newer posts <span class="meta-nav">&#9658;</span>'  ); ?>&nbsp;</div>  
                </div><!-- #nav-below -->
<?php endif; ?>

</div>
<div class="span4">
<div class="sidebar">
<?php dynamic_sidebar('Archive Page'); ?>
</div>
</div>
</div>
</div>
      
<?php get_footer(); ?>
