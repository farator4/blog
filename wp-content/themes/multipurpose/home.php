<?php 

if ( !defined('ABSPATH')) exit; 

 

get_header(); 

?>


<div class="container">
    <?php  if('posts' == get_option( 'show_on_front' )&&!multipurpose_get_theme_opts('multipurpose_home')) :  ?>

        <div class="row-fluid">
            <div class="span<?php echo apply_filters("homepage_content_grid",8); ?>">
            <?php        get_template_part('loop'); ?>
            </div>
            <?php
                $homepage_sidebar_grid = apply_filters("homepage_sidebar_grid",4);

                if($homepage_sidebar_grid>0){
                    ?>
                    <div class="span<?php echo $homepage_sidebar_grid; ?>">

                          <?php  dynamic_sidebar("homepage_sidebar_right"); ?>

                    </div>

                    <?php
                }
            ?>
        </div>

    <?php else:   ?>



        <div class="row-fluid">
            <div class="span12">

                        <div class="row-fluid">
                            <div class="span12 c2a" align="center">

                                <h2><?php echo esc_attr(multipurpose_get_theme_opts('featured_section_1_title','Our Services')); ?></h2>
                                <?php
                                echo esc_attr(multipurpose_get_theme_opts('featured_section_1_desc','What we do, we do in a perfect way....'));
                                ?>
                                <br/>

                            </div>
                        </div>

            </div>
        </div>

        <div class="clear"><br/><br/></div>

        <div class="row-fluid">

            <?php
               for($i=1; $i<=3; $i++):

               $page_id = multipurpose_get_theme_opts("home_featured_page_".$i);
               $page  = get_page($page_id);
               $meta = get_post_meta($page_id, 'multipurpose_post_meta', true);
               $url = esc_url(get_permalink($page_id));
            ?>
            <div class="span4">
                <div class="contentbox-style2">        <div align="center" class="feature-icon-top">
                        <div align="center" class="iconbox">
                            <a href="<?php echo $url; ?>">
        <span class="icon-stack icon-3x img-circle">
          <i class="icon <?php echo isset($meta['icon'])?esc_attr($meta['icon']):'icon-leaf'; ?> icon-inner"></i>
        </span>

                            </a>
                        </div>

                        <h2 style="margin-top:0px;"><a href="<?php echo $url; ?>""><?php echo esc_attr($page->post_title); ?></a></h2>
                        <?php echo isset($meta['excerpt'])?esc_attr($meta['excerpt']):""; ?>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <?php endfor; ?>

        </div>


        <div class="sap" align="center"><span><?php echo esc_attr(multipurpose_get_theme_opts('featured_section_2_title','Recent Works')); ?></span></div>

    <div class="row-fluid">
        <div class="span12" align="center"><?php echo esc_attr(multipurpose_get_theme_opts('featured_section_2_desc')); ?><br/><br/><br/></div>
    </div>

        <div class="row-fluid">
            <?php
            global $post;
            for($i=4; $i<=7; $i++):

            $page_id = multipurpose_get_theme_opts("home_featured_page_".$i, get_the_ID());
            $page  = get_post($page_id);
            $meta = get_post_meta($page_id, 'multipurpose_post_meta', true);
            $url = esc_url(get_permalink($page_id));
            if(is_object($page))
                $post = $page;
            ?>
            <div class="span3">
                <div class="thumbnail portfolio-block">
                    <div class="show show-first">
                        <a href="<?php echo $url;?>"><?php multipurpose_post_thumb(array(300,250)); ?></a>
                        <div class="mask">


                            <a href="<?php echo multipurpose_post_thumb_url(); ?>" class="btn btn-theme imgpreview"><i class="icon icon-search"></i></a>
                            <a href="<?php echo $url; ?>" class="btn btn-theme"><i class="icon icon-chevron-right"></i></a>
                        </div>
                    </div>
                    <h3><a href='<?php echo $url; ?>'><?php echo $post->post_title; ?></a></h3>
                </div>
            </div>
            <?php endfor; ?>


        </div>





        <div class="sap" align="center"><span><?php echo esc_attr(multipurpose_get_theme_opts('blog_section_title','From Blog')); ?></span></div>

        <div class="row-fluid">
            <div class="span12" align="center"><?php echo esc_attr(multipurpose_get_theme_opts('blog_section_desc')); ?><br/><br/><br/></div>
        </div>

        <div class="row-fluid">
            <div class="span12" >
                <ul class="thumbnails">
                    <?php
                    $q = new WP_Query('posts_per_page=2');
                    $ccnt = 0;
                    while($q->have_posts()): $q->the_post(); ?>
                        <li class="span6 home-cat-single">
                            <div class="entry-content media">
                                <a href="<?php the_permalink();?>" class="pull-left">
                                    <?php multipurpose_post_thumb(array(200,180),true, array('class'=>'img-rounded')); ?>
                                </a>
                                <div class="media-body">
                                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>&nbsp;</h2>
                                <div class="post-meta"><i class="icon icon-time"></i> <?php echo get_the_date(); ?></div>
                                <p><?php multipurpose_post_excerpt(100); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-bordered btn-mini">Read More <i class="icon icon-chevron-right"></i></a>
                                </div>
                            </div>

                        </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>

    <?php  endif; ?>
 
<div class="clear"></div>
         

</div><!-- /.span4 -->
         
 

        
<?php get_footer(); ?>
