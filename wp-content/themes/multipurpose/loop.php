

        <?php

        do_action("before_loop");

        while(have_posts()): the_post(); ?>
            <div class="archive-item">
            <?php get_template_part("content",get_post_format()); ?>
            <div class="clear"></div>
            </div>
        <?php endwhile; ?>

        <?php
        global $wp_query;
        if (  $wp_query->max_num_pages > 1 ) : ?>
            <div class="clear"></div>
            <div id="nav-below" class="navigation post box arc breadcrumb">
                <div class="btn"><?php previous_posts_link(  '<i class="icon icon-chevron-left"></i> Previous'  ); ?></div>
                <div class="btn next-link"><?php next_posts_link( 'Next <i class="icon icon-chevron-right"></i>'  ); ?></div>
                <div class="clear"></div>
            </div><!-- #nav-below -->
        <?php endif;

        do_action("after_loop");

        ?>
