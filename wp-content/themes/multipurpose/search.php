<?php get_header();  ?>  

      

<div class="container">
<div class="row-fluid">
<div class="span8">
<h2>
  <?php printf( 'Search Results for: %s', '<span>' . get_search_query() . '</span>' );?>    
</h2> 
<?php if ( have_posts() ) : ?>     
<?php 
while(have_posts()): the_post(); ?> 
<div  <?php post_class('post box arc'); ?>>
<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>&nbsp;</h2> 
<?php multipurpose_post_thumb('edenfresh-responsive-blog-thumb'); ?>  
<div class="entry-content"><?php the_excerpt(); ?>
<div class="breadcrumb">Posted on <?php echo get_the_date(); ?> / Posted by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a> / <a href="<?php the_permalink();?>">read more &#187;</a></div>
</div> 
</div> 
<?php endwhile; ?>               

<?php 
global $wp_query;
if (  $wp_query->max_num_pages > 1 ) : ?>
<div class="clear"></div>
                <div id="nav-below" class="navigation post box arc breadcrumb">
                    <div class="btn"><?php next_posts_link( '<span class="meta-nav">&#9668;</span> Older posts'  ); ?>&nbsp;</div>
                    <div class="btn next-link"><?php previous_posts_link(  'Newer posts <span class="meta-nav">&#9658;</span>'  ); ?>&nbsp;</div>  
                </div><!-- #nav-below -->
<?php endif; ?>

<?php else: ?>
<div class="alert alert-warning">Nothing found!</div>
<?php endif; ?>

</div>
<div class="span4">
 
<?php dynamic_sidebar('Archive Page'); ?>
</div>
</div>
</div>
<?php get_footer(); ?>

