<?php get_header(); ?>     
<div class="container">
<div class="row-fluid">
<div class="span8">
<div  id="post-<?php the_ID(); ?>" <?php post_class(); ?>> 
<?php 

 the_post(); $data = maybe_unserialize(get_post_meta(get_the_ID(),'wpeden_post_meta',true)); ?>
     
<div  <?php post_class('post'); ?>>
 
<div class="clear"></div>
<div class="portfolio-content entry-content">
<?php multipurpose_post_thumb('edenfresh-responsive-post-thumb'); ?>
<br/>
<br/>
<?php 

 $args = array(
   'post_type' => 'attachment',
   'numberposts' => -1,
   'post_status' => null,
   'post_parent' => $post->ID
  );
  echo "<div class='row-fluid' id='portfolio-gallery'>";
  $attachments = get_posts( $args );
     if ( $attachments ) {
        foreach ( $attachments as $attachment ) {
           $imgsrc = wp_get_attachment_image_src( $attachment->ID, 'full');
           echo "<a rel='lightbox' title='".$attachment->post_title."' class='thumbnail span2' href='".$imgsrc[0]."'>". wp_get_attachment_image( $attachment->ID, 'thumbnail',1,array('class'=>'') )."</a>";
            
          }
     }
  echo "</div>";
?>         
<div class="clear"><br/></div>
<?php the_content(); ?>
</div>
<?php wp_link_pages( ); ?>
 
</div>
 
</div>
</div>
<div class="span4">
<div class="box widget">
<h3 class="widget-title">Protect Name

<div id="project-nav-single" class="btn-group pull-right"> 
                        <?php previous_post_link( '%link', '<span title="Previous Item" class="meta-nav btn"><i class="icon icon-arrow-left"></i></span>'); ?>
                        <?php next_post_link( '%link', '<span title="Next Item" class="meta-nav btn"><i class="icon icon-arrow-right"></i></span>' ); ?>
</div>
</h3>
<h1 class="project-title"><?php the_title(); ?></h1>
</div>
<div class="box widget">
<h3 class="widget-title">Project Details<i class="icon icon-cogs pull-right"></i></h3>
<ul>
<li><i class="icon icon-time"></i><?php the_date(); ?></li>
<li><i class="icon icon-user"></i> <?php the_author(); ?></li>
</ul>
</div>
 

</div>
</div>
<div class="row-fluid">
<div class="span12">
<div class="mx_comments"> 
<?php comments_template(); ?>
</div>
</div>
</div>
</div>
 <script language="JavaScript">jQuery(function(){ jQuery('#portfolio-gallery a').lightBox(); });</script>
         

<?php get_footer(); ?>
