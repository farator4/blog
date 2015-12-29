<?php
/*
Plugin Name: Colorbox
Description: Colorbox Image Preview
Plugin URI: http://wpeden.com/
Author: Shaon
Version: 1.0.0
Author URI: http://wpeden.com/
*/


function wpdm_qneue_colorbox(){
    wp_enqueue_script("wpdm-colorbox",get_template_directory_uri().'/modules/colorbox/jquery.colorbox-min.js',array('jquery'));
    wp_enqueue_style("wpdm-colorbox",get_template_directory_uri().'/modules/colorbox/colorbox.css');
}

function wpdm_colorbox_init(){
    ?>
    <script type="text/javascript">
     jQuery(function(){
        jQuery('.gallery-item .gallery-icon a').colorbox({maxWidth:'95%', maxHeight:'95%'});
	jQuery('.imgpreview').colorbox({maxWidth:'95%', maxHeight:'95%'});
     });
    </script>
    <?php
}

add_action("wp_enqueue_scripts", "wpdm_qneue_colorbox");
add_action("wp_head", "wpdm_colorbox_init");

?>
