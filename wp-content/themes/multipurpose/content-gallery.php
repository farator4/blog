<div  <?php post_class('media'); ?>>
    <a href="<?php the_permalink(); ?>">
        <?php multipurpose_post_thumb(array(900,300)); ?>
    </a>
    <div class="entry-content media-body">
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>&nbsp;</h2>
        <?php the_excerpt(); ?>
    </div>
    <div class="clear"></div>
    <div class="breadcrumb">Posted on <?php echo get_the_date(); ?> / Posted by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a> / <a href="<?php the_permalink();?>">read more &#187;</a></div>
</div>