 
            
<?php $tcid =(int)multipurpose_get_theme_opts('home_cat_4',1); $homecategory = get_category($tcid); $category_link = get_category_link( $homecategory->term_id ); //$introcontent = strip_tags($intropage->post_content,"p,br"); if (preg_match('/^.{1,100}\b/s', $introcontent, $match)) $introcontent = $match[0];  ?> 
<div class="row-fluid">

<div class="span12">
        <div class="home-cat" ><span><?php echo $homecategory->name; ?></span>
         
        <div class="pull-right">
                    <a href="<?php echo esc_url( $category_link ); ?>" class="btn btn-mini btn-link">View All <i class="icon icon-theme icon-chevron-right"></i></a>
        </div>        
        <div class="clear"></div>

 </div>        
</div>         
</div>         
<div class="row-fluid">
<div class="span12" >
<ul class="thumbnails">
<?php 
$q = new WP_Query('posts_per_page=4&cat='.$homecategory->term_id);
$ccnt = 0;
while($q->have_posts()): $q->the_post(); ?>
<li class="span3 home-cat-single"> 
<div class="entry-content">
<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>&nbsp;</h2> 
<i class="icon icon-time"></i> <?php echo get_the_date(); ?> 
<p><?php multipurpose_post_excerpt(100); ?></p>
</div> 
 
</li>
<?php endwhile; ?>               
</ul>
</div>    
</div> 


