<?php
 
if ( ! isset( $content_width ) ) $content_width = 960;


require_once(dirname(__FILE__)."/admin/engine.php"); 
require_once(dirname(__FILE__)."/libs/nav-menu-walker.class.php"); 
require_once(dirname(__FILE__)."/modules/colorbox/colorbox.php");


 
//generate thumbnail 
function multipurpose_thumb($post, $size='', $extra = array(), $echo = true){    
    $size = $size?$size:'large';   
    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $size); 
    $large_image_url = $large_image_url[0];    
    $large_image_url = $large_image_url?$large_image_url:'';        
    $class = isset($extra['class'])?$extra['class']:'';
    if($echo&&has_post_thumbnail($post->ID ))
    echo get_the_post_thumbnail($post->ID, $size, $extra );
    else if(!$echo&&has_post_thumbnail($post->ID ))
    return get_the_post_thumbnail($post->ID, $size, $extra );  
    else if($echo)
    echo "";
    else
    return "";
    
}
    

//post thumbnail function
function multipurpose_post_thumb($size='', $echo = true, $extra = null){
    global $post;
    if(!is_object($post)) return "";
    $size = $size?$size:'thumbnail';
    $class = isset($extra['class'])?$extra['class']:'';
   
    if(is_array($size))
    {
        $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
        $large_image_url = $large_image_url[0];
        if($large_image_url!=''){
            $path = str_replace(site_url('/'), ABSPATH, $large_image_url);
            $thumb = multipurpose_dynamic_thumb($path, $size);
            $thumb = str_replace(ABSPATH, site_url('/'), $thumb);
            $alt = get_post_meta(get_post_thumbnail_id($post->ID), '_wp_attachment_image_alt', true);
            $img = "<img src='".$thumb."' alt='{$alt}' class='{$class}' />";
            if($echo) { echo $img; return; }
            else
            return $img;
        }
    }
    if($echo&&has_post_thumbnail($post->ID ))
    echo get_the_post_thumbnail($post->ID, $size, $extra );    
    else if(!$echo&&has_post_thumbnail($post->ID ))
    return get_the_post_thumbnail($post->ID, $size, $extra );  
    else if($echo)
    echo "";
    else
    return "";
}

//post thumbnail url
function multipurpose_post_thumb_url($size='', $echo = true, $extra = null){
    global $post;
    $size = $size?$size:'thumbnail';
    if(is_array($size))
    {
        $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
        $large_image_url = $large_image_url[0];
        if($large_image_url!=''){
            $path = str_replace(site_url('/'), ABSPATH, $large_image_url);
            $thumb = multipurpose_dynamic_thumb($path, $size);
            $thumb = str_replace(ABSPATH, site_url('/'), $thumb);
            return $thumb;
        }
    }
    $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
    $large_image_url = $large_image_url[0];
    return esc_url($large_image_url);
}

//genrate thumbnail url
function multipurpose_thumb_url($image, $size='', $echo = true, $extra = null){
    global $post;
    $size = $size?$size:'thumbnail';
    if(is_array($size))
    {        
        $large_image_url = $image;
        if($large_image_url!=''){
            $path = str_replace(site_url('/'), ABSPATH, $large_image_url);
            $thumb = multipurpose_dynamic_thumb($path, $size);
            $thumb = str_replace(ABSPATH, site_url('/'), $thumb);
            return esc_url($thumb);
        }
    }
    
    return esc_url($image);
}

//generate cutom excerpt
function multipurpose_post_excerpt($length){
    global $post;
    if(!is_object($post)) return "";
    $uexcerpt = $post->post_excerpt?$post->post_excerpt:preg_replace("/\[([^\]]*)\]/","",$post->post_content);
    $uexcerpt = strip_tags($uexcerpt);
    $uexcerpt = esc_html($uexcerpt);
    $excerpt = substr($uexcerpt,0,$length);
    $eexcerpt = substr($uexcerpt,$length);
    $eexcerpt = explode(" ",$eexcerpt);
    $excerpt .= array_shift($eexcerpt);
    echo $excerpt?$excerpt.'...':$excerpt;
}



function multipurpose_meta_boxes(){ 
                                       
    $meta_boxes = array(
                        'multipurpose-icons'=>array('title'=>'Featured Icon','callback'=>'multipurpose_meta_box_icons','position'=>'side','priority'=>'core','post_type'=>'page'),
                        'multipurpose-page-excerpt'=>array('title'=>'Excerpt','callback'=>'multipurpose_meta_box_page_excerpt','position'=>'normal','priority'=>'core','post_type'=>'page'),
                        'multipurpose-post-settings'=>array('title'=>'Post Format Settings','callback'=>'multipurpose_meta_box_post_format_settings','position'=>'normal','priority'=>'core','post_type'=>'post'),
                   );
                       
                     
                       
    $meta_boxes = apply_filters("wpmp_meta_box", $meta_boxes);
    foreach($meta_boxes as $id=>$meta_box){
        extract($meta_box);
        add_meta_box($id, $title, $callback,$post_type, $position, $priority);
    }    
}

function multipurpose_meta_box_post_format_settings($post){
    $data = maybe_unserialize(get_post_meta($post->ID,'wpeden_post_meta', true));

    ?>
    <div class="pfset" id="post-format-link-settings">
        <label for="spro">Link URL</label><br/>
        <input type="text" style="width:370px" name="wpeden_post_meta[linkurl]" type="text" value="<?php echo $data['linkurl']; ?>" /><br/>
    </div>
    <div class="pfset" id="post-format-video-settings">
        <label for="spro">Video URL</label><br/>
        <input type="text" style="width:370px" id="spro" name="wpeden_post_meta[videourl]" type="text" value="<?php echo $data['videourl']; ?>" /><br/>
    </div>
    <script>
        jQuery(function($){
            $('#post-formats-select input[type=radio]').click(function(){
                var id = '#'+this.id+'-settings'
                $('.pfset').hide();
                $(id).show();
            });
            $('.pfset').hide();
            $('#post-format-<?php echo get_post_format(); ?>-settings').show();
        });
    </script>
<?php
}

function multipurpose_meta_box_page_excerpt($post){
        $data = maybe_unserialize(get_post_meta($post->ID,'multipurpose_post_meta', true));
        if(!$data) $data['excerpt']  = '';
         
        ?>
        <textarea style="width: 100%" id="whyus" name="multipurpose_post_meta[excerpt]" type="text"><?php echo $data['excerpt']; ?></textarea>        
        <?php     
}

function multipurpose_meta_box_icons(){
        global $post;

        $icons = array(
    "icon-glass",
    "icon-music",
    "icon-search",
    "icon-envelope",
    "icon-heart",
    "icon-star",
    "icon-star-empty",
    "icon-user",
    "icon-film",
    "icon-th-large",
    "icon-th",
    "icon-th-list",
    "icon-ok",
    "icon-remove",
    "icon-zoom-in",
    "icon-zoom-out",
    "icon-off",
    "icon-signal",
    "icon-cog",
    "icon-trash",
    "icon-home",
    "icon-file",
    "icon-time",
    "icon-road",
    "icon-download-alt",
    "icon-download",
    "icon-upload",
    "icon-inbox",
    "icon-play-circle",
    "icon-repeat",
    "icon-refresh",
    "icon-list-alt",
    "icon-lock",
    "icon-flag",
    "icon-headphones",
    "icon-volume-off",
    "icon-volume-down",
    "icon-volume-up",
    "icon-qrcode",
    "icon-barcode",
    "icon-tag",
    "icon-tags",
    "icon-book",
    "icon-bookmark",
    "icon-print",
    "icon-camera",
    "icon-font",
    "icon-bold",
    "icon-italic",
    "icon-text-height",
    "icon-text-width",
    "icon-align-left",
    "icon-align-center",
    "icon-align-right",
    "icon-align-justify",
    "icon-list",
    "icon-indent-left",
    "icon-indent-right",
    "icon-facetime-video",
    "icon-picture",
    "icon-pencil",
    "icon-map-marker",
    "icon-adjust",
    "icon-tint",
    "icon-edit",
    "icon-share",
    "icon-check",
    "icon-move",
    "icon-step-backward",
    "icon-fast-backward",
    "icon-backward",
    "icon-play",
    "icon-pause",
    "icon-stop",
    "icon-forward",
    "icon-fast-forward",
    "icon-step-forward",
    "icon-eject",
    "icon-chevron-left",
    "icon-chevron-right",
    "icon-plus-sign",
    "icon-minus-sign",
    "icon-remove-sign",
    "icon-ok-sign",
    "icon-question-sign",
    "icon-info-sign",
    "icon-screenshot",
    "icon-remove-circle",
    "icon-ok-circle",
    "icon-ban-circle",
    "icon-arrow-left",
    "icon-arrow-right",
    "icon-arrow-up",
    "icon-arrow-down",
    "icon-share-alt",
    "icon-resize-full",
    "icon-resize-small",
    "icon-plus",
    "icon-minus",
    "icon-asterisk",
    "icon-exclamation-sign",
    "icon-gift",
    "icon-leaf",
    "icon-fire",
    "icon-eye-open",
    "icon-eye-close",
    "icon-warning-sign",
    "icon-plane",
    "icon-calendar",
    "icon-random",
    "icon-comment",
    "icon-magnet",
    "icon-chevron-up",
    "icon-chevron-down",
    "icon-retweet",
    "icon-shopping-cart",
    "icon-folder-close",
    "icon-folder-open",
    "icon-resize-vertical",
    "icon-resize-horizontal",
    "icon-hdd",
    "icon-bullhorn",
    "icon-bell",
    "icon-certificate",
    "icon-thumbs-up",
    "icon-thumbs-down",
    "icon-hand-right",
    "icon-hand-left",
    "icon-hand-up",
    "icon-hand-down",
    "icon-circle-arrow-right",
    "icon-circle-arrow-left",
    "icon-circle-arrow-up",
    "icon-circle-arrow-down",
    "icon-globe",
    "icon-wrench",
    "icon-tasks",
    "icon-filter",
    "icon-briefcase",
    "icon-fullscreen",
);


        $data = maybe_unserialize(get_post_meta($post->ID,'multipurpose_post_meta', true));
        if(is_array($data))
        $icon = $data['icon'];
        ?>
        <label for="icons">Icon:</label>
        <select id="icons" name="multipurpose_post_meta[icon]" type="text">
        <?php foreach($icons  as $class ){ $name = ucwords(trim(str_replace(array('icon','-'),' ',$class))); echo "<option value='{$class}' ".selected($class, $icon).">{$name}</option>"; } ?>
        </select>
        <?php       
    
} 



function multipurpose_save_meta_data($postid, $post){
       if(isset($_POST['multipurpose_post_meta'])&&is_array($_POST['multipurpose_post_meta'])){
        update_post_meta($postid, 'multipurpose_post_meta',$_POST['multipurpose_post_meta']);
       }
}

function multipurpose_dynamic_thumb($path, $size){
    $name_p = explode(".",$path);
    $ext = ".".end($name_p);
    $thumbpath = str_replace($ext, "-".implode("x", $size).$ext, $path);
    if(file_exists($thumbpath)) return $thumbpath;
    $image = wp_get_image_editor( $path );
    if ( ! is_wp_error( $image ) ) {
        $image->resize( $size[0], $size[1], true );
        $image->save( $thumbpath );
    }
    return $thumbpath;
}

function multipurpose_post_gallery($w = 900, $h = 300, $post_id = null, $extra = array()){
    if(!$post_id) $post_id = get_the_ID();
    $n = 0;
    $attachments = get_posts( array(
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_parent' => $post_id
    ) );

    $html = "";
    $link = get_permalink($post_id);
    if ( $attachments ) {
        foreach ( $attachments as $attachment ) {
            $image = wp_get_attachment_image_src( $attachment->ID, 'full', true );
            $active = ($n++==0)?'active':'';
            $html .= "<div class='item {$active}'><a href='{$image[0]}' rel='image-preview-{$post_id}' class='imgpreview'><img src='".multipurpose_thumb_url($image[0], array($w, $h))."' /></a></div>";
        }

    }
    $uniqid = uniqid();
    echo '<div id="post-carousel-'.$post_id.'-'.$uniqid.'" class="carousel slide"><div class="carousel-inner">'.$html.'</div><a class="carousel-control left" href="#post-carousel-'.$post_id.'-'.$uniqid.'" data-slide="prev"><i class="icon icon-angle-left"></i></a><a class="carousel-control right" href="#post-carousel-'.$post_id.'-'.$uniqid.'" data-slide="next"><i class="icon icon-angle-right"></i></a></div>';
}

 
//comments
function multipurpose_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
   $GLOBALS['comment'] = $comment;
    
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
        ?>
    <li class="post pingback">
        <p>Pingback: <?php comment_author_link(); ?><?php edit_comment_link( 'Edit', '<span class="edit-link">', '</span>' ); ?></p>
    <?php
        break;
        default :
   ?>
   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">         
            <div class="comment-body">
               <div id="comment-<?php comment_ID(); ?>" class="clearfix media">
                    <div class="author-box pull-left">
                        <?php echo get_avatar($comment,100); ?>
                         
                    </div> <!-- end .avatar-box -->
                    <div class="comment-wrap clearfix media-body">                        
                        <div class="comment-meta commentmetadata">
                        <?php printf('<span class="fn">%s</span>', get_comment_author_link()) ?>
                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                            <?php
                                /* translators: 1: date, 2: time */
                                printf(  '%1$s at %2$s', get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( '(Edit)', ' ' );
                            ?>
                        </div><!-- .comment-meta .commentmetadata -->

                        <?php if ($comment->comment_approved == '0') : ?>
                            <em class="moderation">Your comment is awaiting moderation.</em>
                            <br />
                        <?php endif; ?>

                        <div class="comment-content"><?php comment_text() ?></div> <!-- end comment-content-->
                        <div class="reply-container"><?php comment_reply_link(array_merge( $args, array('reply_text' => 'Reply','depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
                    </div> <!-- end comment-wrap-->
                    <div class="comment-arrow"></div>
                </div> <!-- end comment-body-->
            </div> <!-- end comment-body-->
         
 
<?php 
        break;
    endswitch;    
 }
 
 
 
//Sidebars
function multipurpose_widget_init(){
     
    register_sidebar(array(
      'name' => 'Header',
      'id' => 'header',
      'description' => 'Sidebar For Header.',
      'before_widget' => '<div class="header-widget">',
      'after_widget' => '</div>',
      'before_title' => '<h3><span>',
      'after_title' => '</span></h3>'
    ));
    register_sidebar(array(
      'name' => 'Single Post',
      'id' => 'single_post_sidebar',
      'description' => 'Sidebar For Single post.',
      'before_widget' => '<div class="box widget">',
      'after_widget' => '</div>',
      'before_title' => '<h3><span>',
      'after_title' => '</span></h3>'
    ));

     register_sidebar(array(
      'name' => 'Homepage Right',
      'id' => 'homepage_sidebar_right',
      'description' => 'Right Sidebar For Homepage.',
      'before_widget' => '<div class="box widget">',
      'after_widget' => '</div>',
      'before_title' => '<h3><span>',
      'after_title' => '</span></h3>'
    ));

     register_sidebar(array(
      'name' => 'Archive Page',
      'id' => 'archive_page_sidebar',
      'description' => 'Sidebar For Archive Page.',
      'before_widget' => '<div class="box widget box_yellow">',
      'after_widget' => '</div>',
      'before_title' => '<h3><span>',
      'after_title' => '</span></h3>'
    ));    
       
    
    register_sidebar(array(
      'name' => 'Footer Left',
      'id' => 'footer1',
      'description' => 'Footer Left',
      'before_widget' => '<div class="widget widget-footer">',
      'after_widget' => '</div>',
      'before_title' => '<h3><span>',
      'after_title' => '</span></h3>'
    )); 
    
    register_sidebar(array(
      'name' => 'Footer Middle',
      'id' => 'footer2',
      'description' => 'Footer Middle',
      'before_widget' => '<div class="widget widget-footer">',
      'after_widget' => '</div>',
      'before_title' => '<h3><span>',
      'after_title' => '</span></h3>'
    )); 
    
    register_sidebar(array(
      'name' => 'Footer Right',
      'id' => 'footer3',
      'description' => 'Footer Right',
      'before_widget' => '<div class="widget widget-footer">',
      'after_widget' => '</div>',
      'before_title' => '<h3><span>',
      'after_title' => '</span></h3>'
    ));  
    register_sidebar(array(
      'name' => 'Footer Last',
      'id' => 'footer4',
      'description' => 'Footer Last',
      'before_widget' => '<div class="widget widget-footer">',
      'after_widget' => '</div>',
      'before_title' => '<h3><span>',
      'after_title' => '</span></h3>'
    )); 
 }
 
// wp_title filter
function multipurpose_filter_wp_title( $old_title, $sep, $sep_location ){
    $ssep = ' ' . $sep . ' ';
    // find the type of index page this is
    if( is_category() ) $insert = $ssep . 'Category';
    elseif( is_tag() ) $insert = $ssep . 'Tag';
    elseif( is_author() ) $insert = $ssep . 'Author';
    elseif( is_year() || is_month() || is_day() ) $insert = $ssep . 'Archives';
    else $insert = NULL;
     
    // get the page number we're on (index)
    if( get_query_var( 'paged' ) )
    $num = $ssep . 'page ' . get_query_var( 'paged' );
     
    // get the page number we're on (multipage post)
    elseif( get_query_var( 'page' ) )
    $num = $ssep . 'page ' . get_query_var( 'page' );
     
    // else
    else $num = NULL;
    
    $site_description = get_bloginfo( 'description', 'display' );
    if ( is_home() && $site_description )
    $old_title .=  $ssep  . $site_description;
     
    // concoct and return new title
    return get_bloginfo( 'name' ) . $insert . $old_title . $num;
}
 
 
//Theme setup function 
function multipurpose_setup(){
    register_nav_menus( array(
        'primary' => 'Top Menu' 
          
    ) );
    
    
    add_theme_support( 'post-thumbnails' );
    //if(has_post_format('aside'))
    add_theme_support( 'post-formats', array( 'aside','image','chat', 'gallery','audio','video','quote','link' ) );
    add_post_type_support( 'post', 'post-formats' );
    add_theme_support("automatic-feed-links");
    add_theme_support("excerpt",array('post','page'));
    add_theme_support('custom-background');
     
    add_image_size( 'multipurpose-post-thumb', 960, 99999, false );
    add_image_size( 'multipurpose-blog-thumb', 960, 300, true ); 
    add_image_size( 'multipurpose-intro-thumb', 470, 200, true ); 
    add_image_size( 'multipurpose-category-thumb', 270, 270, true ); 
 
 }
 
 function multipurpose_enqueue_scripts(){
    wp_enqueue_style('multipurpose-main',get_stylesheet_uri());                 
    wp_enqueue_style('multipurpose-less',get_template_directory_uri().'/css/style.less');
    wp_enqueue_script('multipurpose-less',get_template_directory_uri().'/js/less.js',array('jquery'));
    wp_enqueue_script('multipurpose-bootstrap',get_template_directory_uri().'/bootstrap/js/bootstrap.min.js',array('jquery'));
    wp_enqueue_script('multipurpose-site',get_template_directory_uri().'/js/site.js',array('jquery'));
    wp_enqueue_style('multipurpose-font-awesome','//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css');
    wp_enqueue_script( 'comment-reply' );
 }

function multipurpose_enqueue_less_styles($tag, $handle) {
    global $wp_styles;
    $match_pattern = '/\.less$/U';
    if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
        $handle = $wp_styles->registered[$handle]->handle;
        $media = $wp_styles->registered[$handle]->args;
        $href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
        $rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
        $title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';

        $tag = "<link rel='stylesheet' id='$handle' $title href='$href' type='text/less' media='$media' />";
    }
    return $tag;
}

function multipurpose_less_var(){
    ?>
    <script type="text/javascript">
        less.modifyVars({
            '@color': '<?php echo multipurpose_get_theme_opts('color_scheme','#3399ff'); ?>'
        });
    </script>
    <?php
}

add_action( 'wp_enqueue_scripts', 'multipurpose_enqueue_scripts');
//add_action("init","multipurpose_save_theme_opt"); 
add_filter( 'wp_title', 'multipurpose_filter_wp_title', 10, 3 );
add_action( 'widgets_init', 'multipurpose_widget_init' );  
add_action( 'after_setup_theme', 'multipurpose_setup' );  
add_action( 'admin_init', 'multipurpose_meta_boxes', 0 );
add_action( 'save_post', 'multipurpose_save_meta_data',10,2);
add_filter( 'style_loader_tag', 'multipurpose_enqueue_less_styles', 5, 2);
add_action('wp_head','multipurpose_less_var',99);
