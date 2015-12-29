

<div  <?php post_class('media'); ?>>
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>&nbsp;</h2>

        <div class="video-player">
            <?php
            $meta = maybe_unserialize(get_post_meta(get_the_ID(),'wpeden_post_meta', true));
            echo wp_oembed_get(esc_url($meta['videourl']),array('width'=>658)); ?>
        </div>

        <?php the_excerpt(); ?>

    <div class="breadcrumb">Posted on <?php echo get_the_date(); ?> / Posted by <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a> / <a href="<?php the_permalink();?>">read more &#187;</a></div>
</div>