<?php 

define("multipurpose_THEME_DIR",dirname(dirname(__FILE__)));
define("multipurpose_THEME_URL",get_stylesheet_directory_uri());

global $multipurpose_wf_data;

//require(dirname(__FILE__).'/');

### SECTION
// LESS Processing
function enqueue_less_styles($tag, $handle) {
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

add_filter( 'style_loader_tag', 'enqueue_less_styles', 5, 2);
// LESS Processing Ends ^^
 
 
### SECTION
//Theme admin css & js
function multipurpose_theme_admin_scripts($hook){ 
    if($hook!='appearance_page_multipurpose-themeopts') return;
    wp_enqueue_style('bootstrap-ui',get_stylesheet_directory_uri().'/admin/bootstrap/css/bootstrap.css');
    wp_enqueue_style('chosen-ui',get_stylesheet_directory_uri().'/admin/css/chosen.css');
    wp_enqueue_style('admincss',get_stylesheet_directory_uri().'/admin/css/base-admin-style.css');
    wp_enqueue_script('bootstrap-js',get_stylesheet_directory_uri().'/admin/bootstrap/js/bootstrap.min.js',array('jquery'));
    wp_enqueue_script('chosen-js',get_stylesheet_directory_uri().'/admin/js/chosen.jquery.js',array('jquery'));
    wp_enqueue_script('multipurpose-js',get_stylesheet_directory_uri().'/admin/js/wpeden.js',array('jquery','chosen-js'));
    wp_enqueue_script('media-upload');
    wp_enqueue_media();
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_style( 'wp-color-picker' );
}

add_action( 'admin_enqueue_scripts', 'multipurpose_theme_admin_scripts');
//Theme admin css & js ends ^^
 
### SECTION
//Theme option menu function
function multipurpose_theme_opt_menu(){                                                                                             /*Theme Option Menu*/
      add_theme_page( "WPEden Theme Options", "Theme Options", 'edit_theme_options', 'multipurpose-themeopts', 'multipurpose_theme_options');  
}


function multipurpose_setting_field($data) {     
    
    switch($data['type']):
            case 'text':
                echo "<div class='controls'><input type='text' id='$data[id]' name='$data[name]' class='input span5' value='".esc_attr($data['value'])."' /></div></div>";
            break;
            case 'checkbox':
                echo "<div class='controls'><input type='checkbox' name='$data[name]' class='input' value='".esc_attr($data['value'])."' ".checked($data['sel'], $data['value'], false)." /></div></div>";
            break;
            case 'textarea':
                echo "<div class='controls'><textarea name='$data[name]' class='input span5'>".esc_html($data['value'])."</textarea></div></div>";
            break;
            case 'callback':
                echo "<div class='controls'>".call_user_func($data['dom_callback'], $data['dom_callback_params'])."</div></div>";
            break;
            case 'heading':
                echo "<div class='navbar'><div class='navbar-inner'><a href='#{$data['id']}' class='brand'>".$data['label']."</a></div></div></div>";
            break;
    endswitch;
}
global $wpede_data_fetched;
function multipurpose_get_theme_opts($index = null, $default = null){
    global $multipurpose_wf_data, $settings_sections, $wpede_data_fetched;
    if(!$wpede_data_fetched){
    $multipurpose_wf_data = array();    
    foreach($settings_sections as $section_id => $section_name) {
    $multipurpose_wf_data = array_merge($multipurpose_wf_data,get_option($section_id,array()));    
    }
    $wpede_data_fetched = 1;}
    
    if(!$index)
    return $multipurpose_wf_data;
    else
    return isset($multipurpose_wf_data[$index])&&$multipurpose_wf_data[$index]!=''?stripcslashes($multipurpose_wf_data[$index]):$default;
}

function multipurpose_subsection_heading($data){
    return "<h3>{$data}</h3>";
}


/**
 * Site Logo
 *
 * @param mixed $params
 */
function multipurpose_site_logo($params){
    extract($params);

    $html = "<div class='input-append'><input class='{$id}' type='text' name='{$name}' id='{$id}_image' value='{$selected}' /><button rel='#{$id}_image' class='btn btn-media-upload' type='button'><i class='icon icon-folder-open'></i></button></div>";
    $html .="<div style='clear:both'></div>";
    return $html;
}

function multipurpose_favicon(){
    ?>
    <link rel="icon" type="image/png" href="<?php echo multipurpose_get_theme_opts('favicon'); ?>" />
<?php
}

function multipurpose_css(){
        if(multipurpose_get_theme_opts('home_featured_image')=='') return;
    ?>

    <style>

        .header-area-bottom{
            background: <?php echo multipurpose_get_theme_opts('color_scheme'); ?> url(<?php echo multipurpose_get_theme_opts('home_featured_image'); ?>) top center !important;
        }

    </style>

<?php
}


function multipurpose_get_site_logo(){
    $logourl = wpeden_get_theme_opts('site_logo');
    if($logourl) echo "<img src='{$logourl}' title='".get_bloginfo('sitename')."' alt='".get_bloginfo('sitename')."' />";
    else echo get_bloginfo('sitename');
}

$section = isset($_GET['section'])?$_GET['section']:'multipurpose_general_settings';
$settings_sections = array(
            'multipurpose_general_settings' => 'General Settings',
            'multipurpose_homepage_settings' => 'Homepage Settings',
            
);
$settings_fields = array(
            'logo_url' => array('id' => 'logo_url',
                                'section'=>'multipurpose_general_settings',
                                'label'=>'Logo URL',
                                'description'=>'Size: 140x25 px',
                                'name' => 'multipurpose_general_settings[logo_url]',
                                'type' => 'callback',
                                'value' => multipurpose_get_theme_opts('logo_url'),
                                'validate' => 'url',
                                'dom_callback' => 'multipurpose_site_logo',
                                'dom_callback_params' => array('name'=>'multipurpose_general_settings[logo_url]','id'=>'logo_url','selected'=>multipurpose_get_theme_opts('logo_url'))
                                ),
            'favicon' => array('id' => 'favicon',
                                'section'=>'multipurpose_general_settings',
                                'label'=>'FavIcon URL',
                                'description'=>'Size: 16x16 px',
                                'name' => 'multipurpose_general_settings[favicon]',
                                'type' => 'callback',
                                'value' => multipurpose_get_theme_opts('favicon'),
                                'validate' => 'url',
                                'dom_callback' => 'multipurpose_site_logo',
                                'dom_callback_params' => array('name'=>'multipurpose_general_settings[favicon]','id'=>'favicon','selected'=>multipurpose_get_theme_opts('favicon'))
                                ),
            'color_scheme' => array('id' => 'color_scheme',
                                'section'=>'multipurpose_general_settings',
                                'label'=>'Color Scheme',
                                'name' => 'multipurpose_general_settings[color_scheme]',
                                'type' => 'text',
                                'value' => multipurpose_get_theme_opts('color_scheme'),
                                'validate' => 'str'                                 
                                ),
            'footer_text' => array('id' => 'footer_text',
                                'section'=>'multipurpose_general_settings',
                                'label'=>'Footer Text',
                                'name' => 'multipurpose_general_settings[footer_text]',
                                'type' => 'text',
                                'value' => multipurpose_get_theme_opts('footer_text'),
                                'validate' => 'str'
                                ),
            'custom_homepage' => array('id' => 'custom_homepage',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Custom Homepage',
                                'name' => 'custom_homepage',
                                'type' => 'heading'                                
                                ),
            'multipurpose_home' => array('id' => 'multipurpose_home',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Show Custom Homepage',
                                'name' => 'multipurpose_homepage_settings[multipurpose_home]',
                                'type' => 'checkbox',
                                'value' => 1,
                                'validate' => 'str',
                                'sel' => multipurpose_get_theme_opts('multipurpose_home')
                                ),
            'featured_slider_heading' => array('id' => 'featured_slider_heading',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Homepage Header Settings',
                                'name' => 'featured_slider_heading',
                                'type' => 'heading'
                                ),
            'home_featured_image' => array('id' => 'home_featured_image',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Image URL',
                                'name' => 'multipurpose_homepage_settings[home_featured_image]',
                                'type' => 'callback',
                                'value' => multipurpose_get_theme_opts('home_featured_image'),
                                'validate' => 'url',
                                'dom_callback' => 'multipurpose_site_logo',
                                'dom_callback_params' => array('name'=>'multipurpose_homepage_settings[home_featured_image]','id'=>'home_featured_image','selected'=>multipurpose_get_theme_opts('home_featured_image'))
                                ),
             
            'home_featured_title' => array('id' => 'home_featured_title',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Headline',
                                'name' => 'multipurpose_homepage_settings[home_featured_title]',
                                'type' => 'text',
                                'value' => multipurpose_get_theme_opts('home_featured_title'),
                                'validate' => 'str'                                
                                ),
             
            'home_featured_desc' => array('id' => 'home_featured_desc',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Description',
                                'name' => 'multipurpose_homepage_settings[home_featured_desc]',
                                'type' => 'textarea',
                                'value' => multipurpose_get_theme_opts('home_featured_desc'),
                                'validate' => 'str'                                
                                ),
             
            'home_featured_btntxt' => array('id' => 'home_featured_btntxt',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Button Text',
                                'name' => 'multipurpose_homepage_settings[home_featured_btntxt]',
                                'type' => 'text',
                                'value' => multipurpose_get_theme_opts('home_featured_btntxt'),
                                'validate' => 'str'                                
                                ),
             
            'home_featured_btnurl' => array('id' => 'home_featured_btnurl',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Button URL',
                                'name' => 'multipurpose_homepage_settings[home_featured_btnurl]',
                                'type' => 'text',
                                'value' => multipurpose_get_theme_opts('home_featured_btnurl'),
                                'validate' => 'str'                                
                                ),
             
            'home_featured_btntxt1' => array('id' => 'home_featured_btntxt1',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'2nd Button Text',
                                'name' => 'multipurpose_homepage_settings[home_featured_btntxt1]',
                                'type' => 'text',
                                'value' => multipurpose_get_theme_opts('home_featured_btntxt1'),
                                'validate' => 'str'
                                ),

            'home_featured_btnurl1' => array('id' => 'home_featured_btnurl1',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'2nd Button URL',
                                'name' => 'multipurpose_homepage_settings[home_featured_btnurl1]',
                                'type' => 'text',
                                'value' => multipurpose_get_theme_opts('home_featured_btnurl1'),
                                'validate' => 'str'
                                ),

            'featured_page_heading' => array('id' => 'featured_page_heading',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Featured Pages Section #1',
                                'name' => 'featured_page_heading',
                                'type' => 'heading'                                
                                ),
            'featured_section_1_title' => array('id' => 'featured_section_1_title',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Title',
                                'name' => 'multipurpose_homepage_settings[featured_section_1_title]',
                                'type' => 'text',
                                'value' => multipurpose_get_theme_opts('featured_section_1_title','Services'),
                                'validate' => 'str'
                                ),

            'featured_section_1_desc' => array('id' => 'featured_section_1_desc',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Tagline',
                                'name' => 'multipurpose_homepage_settings[featured_section_1_desc]',
                                'type' => 'text',
                                'value' => multipurpose_get_theme_opts('featured_section_1_desc','What we can do for you...'),
                                'validate' => 'str'
                                ),
            'home_featured_page_1' => array('id' => 'home_featured_page_1',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Featured Page 1',
                                'name' => 'multipurpose_homepage_settings[home_featured_page_1]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=multipurpose_homepage_settings[home_featured_page_1]&id=home_featured_page_1&selected='.multipurpose_get_theme_opts('home_featured_page_1')
                                ),
            'home_featured_page_2' => array('id' => 'home_featured_page_2',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Featured Page 2',
                                'name' => 'multipurpose_homepage_settings[home_featured_page_2]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=multipurpose_homepage_settings[home_featured_page_2]&id=home_featured_page_2&selected='.multipurpose_get_theme_opts('home_featured_page_2')
                                ),
            'home_featured_page_3' => array('id' => 'home_featured_page_3',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Featured Page 3',
                                'name' => 'multipurpose_homepage_settings[home_featured_page_3]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=multipurpose_homepage_settings[home_featured_page_3]&id=home_featured_page_3&selected='.multipurpose_get_theme_opts('home_featured_page_3')
                                ),
            'featured_page_heading2' => array('id' => 'featured_page_heading2',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Featured Pages Section #2',
                                'name' => 'featured_page_heading2',
                                'type' => 'heading'
                                ),
            'featured_section_2_title' => array('id' => 'featured_section_2_title',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Title',
                                'name' => 'multipurpose_homepage_settings[featured_section_2_title]',
                                'type' => 'text',
                                'value' => multipurpose_get_theme_opts('featured_section_2_title','Recent Works'),
                                'validate' => 'str'
                                ),

            'featured_section_2_desc' => array('id' => 'featured_section_1_desc',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Tagline',
                                'name' => 'multipurpose_homepage_settings[featured_section_2_desc]',
                                'type' => 'text',
                                'value' => multipurpose_get_theme_opts('featured_section_2_desc','Check out recent projects here...'),
                                'validate' => 'str'
                                ),
                    'home_featured_page_4' => array('id' => 'home_featured_page_4',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Featured Page 1',
                                'name' => 'multipurpose_homepage_settings[home_featured_page_4]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=multipurpose_homepage_settings[home_featured_page_4]&id=home_featured_page_4&selected='.multipurpose_get_theme_opts('home_featured_page_4')
                                ),
            'home_featured_page_5' => array('id' => 'home_featured_page_5',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Featured Page 2',
                                'name' => 'multipurpose_homepage_settings[home_featured_page_5]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=multipurpose_homepage_settings[home_featured_page_5]&id=home_featured_page_5&selected='.multipurpose_get_theme_opts('home_featured_page_5')
                                ),
            'home_featured_page_6' => array('id' => 'home_featured_page_6',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Featured Page 3',
                                'name' => 'multipurpose_homepage_settings[home_featured_page_6]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=multipurpose_homepage_settings[home_featured_page_6]&id=home_featured_page_6&selected='.multipurpose_get_theme_opts('home_featured_page_6')
                                ),
            'home_featured_page_7' => array('id' => 'home_featured_page_7',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Featured Page 4',
                                'name' => 'multipurpose_homepage_settings[home_featured_page_7]',
                                'type' => 'callback',
                                'validate' => 'int',
                                'dom_callback'=> 'wp_dropdown_pages',
                                'dom_callback_params' => 'echo=0&name=multipurpose_homepage_settings[home_featured_page_7]&id=home_featured_page_7&selected='.multipurpose_get_theme_opts('home_featured_page_7')
                                ),

            'home_cat_heading' => array('id' => 'home_cat_heading',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Homepage Blog Section',
                                'name' => 'home_cat_heading',
                                'type' => 'heading'                                
                                ),
            'blog_section_title' => array('id' => 'blog_section_title',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Title',
                                'name' => 'multipurpose_homepage_settings[blog_section_title]',
                                'type' => 'text',
                                'value' => multipurpose_get_theme_opts('blog_section_title','From Blog'),
                                'validate' => 'str'
                                ),

            'blog_section_desc' => array('id' => 'blog_section_desc',
                                'section'=>'multipurpose_homepage_settings',
                                'label'=>'Tagline',
                                'name' => 'multipurpose_homepage_settings[blog_section_desc]',
                                'type' => 'text',
                                'value' => multipurpose_get_theme_opts('blog_section_desc','They are talking about...'),
                                'validate' => 'str'
                                ),

);



function multipurpose_setup_theme_options(){
    global $settings_fields, $multipurpose_wf_data, $section, $settings_sections;   
    foreach($settings_sections as $section_id=>$section_name){                 
        register_setting($section_id,$section_id,'multipurpose_validate_optdata');           
    }
    foreach($settings_fields as $id=>$field){         
        if($field['type']=='heading')
        add_settings_field($id, '<div class="control-group">', 'multipurpose_setting_field', 'multipurpose-themeopts', $field['section'], $field);    
        else
        add_settings_field($id, '<div class="control-group"><label for="ftrcat" class="control-label">'.$field['label'].'</label>', 'multipurpose_setting_field', 'multipurpose-themeopts', $field['section'], $field);    
    }
}

add_action('admin_init','multipurpose_setup_theme_options');

function multipurpose_validate_optdata($data){    
    global $settings_fields;  
    $error = array();
    
    foreach($settings_fields as $id=>$field){
         if(!isset($data[$id])) continue;              
         switch($field['validate']){
             case 'url':
                $data[$id] = esc_url($data[$id]);
             break;
             case 'int':
                $data[$id] = intval($data[$id]);
             break;
             case 'double':
                $data[$id] = doubleval($data[$id]);
             break;
             case 'str':
                $data[$id] = mysql_escape_string(strval($data[$id]));
             break;
             case 'email':
                $data[$id] = is_email($data[$id])?$data[$id]:'';
                $error[$id] = 'Invalid Email Address';
             break;
         }
    }
    if($error) return $data['__error__'] = $error;
    
    return $data;
}

function multipurpose_logo(){
    $logo = esc_url(multipurpose_get_theme_opts('logo_url'));
    $sitename = get_bloginfo('sitename');
    if($logo!='')
    echo "<img src='{$logo}' title='{$sitename}' alt='{$sitename}' />";
    else 
    echo $sitename;
}
    
//theme option     
function multipurpose_theme_options(){
global $settings_sections, $section;                                                                                                  /*Theme Option Function*/      
?>

    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" />
    <div class="wrap wpeden-theme-options w3eden">
        <div class="container-fluid">
            <div class="row-fluid theader">
                <div class="span12">

                    <h2 class="thm_heading"><img src="<?php echo get_template_directory_uri(); ?>/admin/images/logo-min.png" /></h2>
                </div>

            </div>
            <div class="row-fluid">
                <div class="span12">

                    <div class=" tabbable tabs-left">
                        <!-- Theme Option Sections -->
                        <ul class="nav nav-tabs smn">
                            <<?php foreach($settings_sections as $section_id=>$section_name){ ?>
                                <li class="<?php echo $section==$section_id?'active':''; ?>"><a href="#<?php echo $section_id; ?>" data-toggle='tab'><?php echo $section_name; ?></a></li>
                            <?php } ?>
                        </ul>
                        <!-- Theme Option Sections Ends -->


                        <!-- Theme Option Fields for section # -->
                        <div class="tab-content">
                            <?php foreach($settings_sections as $section_id=>$section_name){ ?>
                                <div class="tab-pane <?php echo $section_id==$section?'active':''; ?>" id="<?php echo $section_id; ?>">
                                    <div class="btn-group pull-right" id="gopro">
                                        <a class="btn btn-success" href="http:///wpeden.com/product/multipurpose-pro-multipurpose-wordpress-theme/" target="_blank">Get Pro!</a>
                                        <a class="btn btn-danger" href="http://wpeden.com/wordpress/themes/" target="_blank">More Themes</a>
                                        <a class="btn btn-inverse" href="http://wpeden.com/wordpress/plugins/" target="_blank">Premium Plugins</a>
                                    </div>
                                    <form id="theme-admin-form" class="form-horizontal" action="options.php" method="post" enctype="multipart/form-data">
                                        <?php
                                        settings_fields( $section_id );
                                        do_settings_fields( 'multipurpose-themeopts',$section_id );
                                        ?>
                                        <div class="control-group">

                                            <div class="controls">
                                                <?php submit_button(); ?>
                                                <span id="loading" style="display: none;"><img src="images/loading.gif" alt=""> saving...</span>
                                                <a href="plugin-install.php?tab=search&type=term&s=%22Page+Layout+Builder%22&plugin-search-input=Search+Plugins" class="button button-secondary">Get Drag & Drop Page Builder Free</a><br/><br/>
                                                <span id="loading" style="display: none;"><img src="images/loading.gif" alt=""> saving...</span>
                                                <b>If you like this theme please consider:</b><Br/> <Br/>
                                                <a class="button" target="_blank" href="http://wordpress.org/support/view/theme-reviews/multipurpose?rate=5#postform">A 5&#9733; rating will inspire us huge</a><br><br>
                                                Please Like this theme in FB:<br/>
                                                <div id="fb-root"></div>
                                                <script>(function(d, s, id) {
                                                        var js, fjs = d.getElementsByTagName(s)[0];
                                                        if (d.getElementById(id)) return;
                                                        js = d.createElement(s); js.id = id;
                                                        js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=185450134846732";
                                                        fjs.parentNode.insertBefore(js, fjs);
                                                    }(document, 'script', 'facebook-jssdk'));</script>
                                                <div class="fb-like" data-href="http://wpeden.com/" data-send="true" data-width="450" data-show-faces="false"></div>
                                                <br clear="all" />
                                                <br clear="all" />
                                                Please follow in twitter:<br/>
                                                <a href="https://twitter.com/webmaniac" class="twitter-follow-button" data-show-count="true" data-size="large">Follow @webmaniac</a>
                                                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>

                                            </div>

                                        </div>
                                        <div class="clear"></div>
                                    </form>
                                    <div class="clear"></div>
                                </div>
                            <?php } ?>


                        </div>
                        <!-- Theme Option Fields for section # Ends -->
                    </div>
                </div>
                <script>jQuery('.ttip').tooltip({placement:'right',animation:false, container:'ul.nav-pills'}); jQuery('.nav-pills a').click(function(e){e.preventDefault(); jQuery('.nav-tabs li').slideUp();jQuery(jQuery(this).attr('rel')).slideDown(); });</script>
            </div>
        </div>

    </div>

<?php
        
}
  
 
add_action('admin_menu', 'multipurpose_theme_opt_menu');
add_action('wp_head', 'multipurpose_favicon');
add_action('wp_head', 'multipurpose_css');