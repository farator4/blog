<?php

if ( ! class_exists( 'WSW_Show' ) ) {

    /**
     * generate SEO info;
     */
    class WSW_Show extends WSW_Module {
        /**
         * Constructor
         */
        protected function __construct() {

            $this->register_hook_callbacks();
        }

        /**
         * Register callbacks for actions and filters
         */
        public function register_hook_callbacks() {

            add_action('wp_head', array($this, 'fake_wp_head') );
            add_action('wp_footer', array($this,'fake_wp_footer') );
            add_action('login_head', array($this,'fake_login_head') );
            add_action('admin_head', array($this,'fake_admin_head') );

            // Add filter for POST content
            add_filter('the_content', array($this,'filter_post_content'), 1, 2);
            // Add filter for POST title
            add_filter('the_title', array($this,'filter_post_title'), 1, 2);
            // Filter the Posts Slugs
            add_filter('name_save_pre', array($this, 'filter_post_slug'),10);


            if(WSW_Main::$settings['chk_tweak_permalink'] == '1'){
                // Strip the category base
                add_action('created_category', array($this,'no_category_base_refresh_rules'));
                add_action('edited_category', array($this,'no_category_base_refresh_rules'));
                add_action('delete_category', array($this,'no_category_base_refresh_rules'));
                add_action('init', array($this,'no_category_base_permastruct'));

                // Add our custom category rewrite rules
                add_filter('category_rewrite_rules', array($this,'no_category_base_rewrite_rules'));
                // Add 'category_redirect' query variable
                add_filter('query_vars',  array($this,'no_category_base_query_vars'));
                // Redirect if 'category_redirect' is set
                add_filter('request', array($this,'no_category_base_request'));

            }


        }

      public  function fake_login_head() {
            if (WSW_Main::$settings['chk_block_login_page'] == '1') {
                echo "\n<!-- WordPress SEO Wizard -->\n";
                echo "<link rel=\"canonical\" href=\"".get_option('home')."\" />\n";
                echo "<!-- WordPress SEO Wizard -->\n";
            }
        }
      public  function fake_admin_head() {
            if (WSW_Main::$settings['chk_block_admin_page'] == '1') {
                echo "\n<!-- WordPress SEO Wizard -->\n";
                echo "<link rel=\"canonical\" href=\"".get_option('home')."\" />\n";
                echo "<!-- WordPress SEO Wizard -->\n";
            }
        }
        public  function filter_post_slug($slug) {
            // If settings is enable, filter the Slug
            $settings = WSW_Main::$settings;

            if ($settings['chk_tweak_permalink']=='1') {

            }

            return $slug;
        }

        /**
         * hook wp_head
         */
        public  function fake_wp_head() {
            // Only to add the head in Single page where Post is shown
            if (is_single() || is_page()) {
                $post_id = get_the_ID();

                $settings = get_post_meta( $post_id , 'wsw-settings');
        

                if(array_key_exists(0,$settings) && $settings[0]['is_meta_keyword']){

                    $meta_keyword_type = $settings[0]['meta_keyword_type'];
                    if (trim($meta_keyword_type)!='') {

                        if($meta_keyword_type == 'keywords'){
                            $meta_value = $settings[0]['keyword_value'];
                        }
                        elseif ($meta_keyword_type=='categories') {
                            $categories_arr = wp_get_post_categories($post_id,array('fields'=>'names'));

                            if (count($categories_arr)>0) {
                                $meta_value = implode(',', $categories_arr);
                            }
                        }
                        elseif ($meta_keyword_type=='tags') {
                            $tags_arr = wp_get_post_tags($post_id,array('fields'=>'names'));

                            if (count($tags_arr)>0) {
                                $meta_value = implode(',', $tags_arr);
                            }
                        }
                        if($meta_value!='')   echo '<meta name="keywords" content="' . $meta_value . '" />'. "\r\n";;
                    }
                }

                if( array_key_exists(0,$settings) && $settings[0]['is_meta_title']){
                    $meta_title_metadata = $settings[0]['meta_title'];
                    if (trim($meta_title_metadata)!='') {
                        echo '<meta name="title" content="' . $meta_title_metadata . '" />'. "\r\n";;
                    }
                }

                if( array_key_exists(0,$settings) && $settings[0]['is_meta_description']){
                    $meta_description_metadata = $settings[0]['meta_description'];
                    if (trim($meta_description_metadata)!='') {
                        echo '<meta name="description" content="' . $meta_description_metadata . '" />'. "\r\n";;
                    }
                }

                /*
                 * Add Facebook meta data
                 */
                if (WSW_Main::$settings['chk_use_facebook'] == '1' && array_key_exists(0,$settings) && $settings[0]['is_social_facebook']=='1') {
                    echo '<meta property="og:type"   content="article" />' . "\r\n";
                    echo '<meta property="og:title"  content="' . esc_attr( $settings[0]['social_facebook_publisher'] ) . '" />' . "\r\n";
                    echo '<meta property="article:author"  content="' . esc_attr( $settings[0]['social_facebook_author'] ) . '" />' . "\r\n";
                    echo '<meta property="article:publisher"  content="' . esc_attr( $settings[0]['social_facebook_publisher'] ) . '" />' . "\r\n";
                    echo '<meta property="og:description"  content="' . esc_attr( $settings[0]['social_facebook_description'] ) . '" /> ' . "\r\n";
                 }
                /*
                 * Add Twitter meta data
                 */
                if (WSW_Main::$settings['chk_use_twitter'] == '1' && array_key_exists(0,$settings)&& $settings[0]['is_social_twitter']=='1') {
                    echo '<meta name="twitter:card" content="summary">' . "\n";
                    echo '<meta name="twitter:title" content="' . esc_attr( $settings[0]['social_twitter_title'] ) . '">' . "\n";
                    echo '<meta name="twitter:description" content="' . esc_attr( $settings[0]['social_twitter_description'] ) . '">' . "\n";
                }

                /*
                * Add Robot meta data
                */
                if (WSW_Main::$settings['chk_use_meta_robot'] == '1') {
                    $strIndex = 'index';
                    if(array_key_exists(0,$settings) && $settings[0]['is_meta_robot_noindex'] == '1') $strIndex = 'noindex';
                    $strFollow = 'follow';
                    if( array_key_exists(0,$settings) && $settings[0]['is_meta_robot_nofollow'] == '1') $strFollow = 'nofollow';
                    echo '<meta name="robots" content="' . $strIndex . ',' . $strFollow .'" />' . "\n";

                   $strODP = '';
                    if(array_key_exists(0,$settings) && $settings[0]['is_meta_robot_noodp'] == '1')
                    {
                        $strODP = 'noodp';
                        echo '<meta name="robots" content="' . $strODP .'" />' . "\n";
                    }
                    $strYDIR = '';
                    if(array_key_exists(0,$settings) && $settings[0]['is_meta_robot_noydir'] == '1')
                    {
                        $strYDIR = 'noydir';
                        echo '<meta name="robots" content="' .$strYDIR.'" />' . "\n";
                    }


                }
            }
        }

        /**
         * hook wp_footer
         */
        public function fake_wp_footer() {
            // Only to add the head in Single page where Post is shown
        
            if (is_single() || is_page()) {
                $post_id = get_the_ID();

                //$settings = get_post_meta( $post_id , 'wsw-settings');

                if (WSW_Main::$settings['chk_author_linking'] == '1') {

                    echo '<div align="center"><small>Site is using the <a href="https://wordpress.org/plugins/seo-wizard/" title="Wordpress Seo" target="_blank">Seo Wizard</a> plugin by <a href="http://seo.uk.net/" target="_blank">http://seo.uk.net/</a></small></div>' . "\n";

                }
            }
        }

        /**
         *
         * Filter the POST content
         *
         */
        function filter_post_content($content,$post_id='') {
            // Only filter if is Single Page
            if (!((is_single()  || is_page() ) && !is_feed())) {
                return $content;
            }

            if ($post_id=='') {
                global $post;
                $post_id = $post->ID;
            }

            if (!isset($post)) {
                $post = get_post($post_id);
            }

            $filtered_content = $content;

            $settings = get_post_meta( $post_id , 'wsw-settings');

            if(WSW_Main::$settings['chk_use_richsnippets'] == '1' && array_key_exists(0,$settings) && $settings[0]['is_rich_snippets'] == '1'){
                if($settings[0]['rating_value']!=0){
                    $variables = array();
                    $variables['seo_post_title'] = $post->post_title;
                    $variables['seo_rating_value'] = $settings[0]['rating_value'];
                    $variables['seo_review_author'] = $settings[0]['review_author'];
                    $variables['seo_review_summary'] = $settings[0]['review_summary'];
                    $variables['seo_review_description'] = $settings[0]['review_description'];
                    $variables['seo_show_rich_snippets'] = $settings[0]['show_rich_snippets'];

                    $attach_content = self::render_template( 'templates/page-rating.php', $variables);
                    $filtered_content = $filtered_content . $attach_content ;
                }

                if($settings[0]['event_name']!=''){

                    $variables = array();

                    $variables['seo_event_name'] = $settings[0]['event_name'];
                    $variables['seo_event_url'] = $settings[0]['event_url'];
                    $variables['seo_event_date'] = $settings[0]['event_date'];
                    $variables['seo_event_location'] = $settings[0]['event_location_name'];
                    $variables['seo_event_street'] = $settings[0]['event_location_street'];
                    $variables['seo_event_locality'] = $settings[0]['event_location_locality'];
                    $variables['seo_event_region'] = $settings[0]['event_location_region'];
                    $variables['seo_show_rich_snippets'] = $settings[0]['show_rich_snippets'];

                    $attach_content = self::render_template( 'templates/page-event.php', $variables );
                    $filtered_content = $filtered_content . $attach_content ;
                }

                if($settings[0]['people_fname']!=''){
                    $variables = array();

                    $variables['seo_people_name'] = $settings[0]['people_fname'] . ' ' . $settings[0]['people_lname'];
                    $variables['seo_people_locality'] = $settings[0]['people_locality'];
                    $variables['seo_people_region'] = $settings[0]['people_region'];
                    $variables['seo_show_rich_snippets'] = $settings[0]['show_rich_snippets'];
                    $attach_content = self::render_template( 'templates/page-people.php' , $variables);
                    $filtered_content = $filtered_content . $attach_content ;
                }

                if($settings[0]['product_name']!=''){

                    $variables = array();

                    $variables['seo_product_name'] = $settings[0]['product_name'] ;
                    $variables['seo_product_description'] = $settings[0]['product_description'];
                    $variables['seo_product_price'] = $settings[0]['product_offers'];
                    $variables['seo_show_rich_snippets'] = $settings[0]['show_rich_snippets'];
                    $attach_content = self::render_template( 'templates/page-product.php' , $variables);
                    $filtered_content = $filtered_content . $attach_content ;
                }
            }

            // Apply settings related to keyword, if keyword is specified
            if ( array_key_exists(0,$settings) && $settings[0]['keyword_value'] != '') {
                $filtered_content = self::apply_biu_to_content($filtered_content, $settings[0]['keyword_value']);
            }

            // Decorates all Images Alt and Title attributes
            $filtered_content = WSW_HtmlStyles::decorates_images($filtered_content, WSW_Main::$settings);

            // Add of rel="nofollow" to external links
            $filtered_content = WSW_HtmlStyles::add_rel_nofollow_external_links($filtered_content, WSW_Main::$settings);

            // Add of rel="nofollow" to Image links
            $filtered_content = WSW_HtmlStyles::add_rel_nofollow_image_links($filtered_content, WSW_Main::$settings);

            if (WSW_Main::$settings['chk_tagging_using_google'] == '1') {

                // Check for Google Searchs and Tags
                if(trim(WSW_Main::$settings['txt_generic_tags']) != '')
                {
                    $tags_to_keep = array();
                    wp_set_post_tags( $post_id, $tags_to_keep, false );
                    wp_set_post_tags( $post_id, trim(WSW_Main::$settings['txt_generic_tags']), true );
                }
            }

            return $filtered_content;

        }

        static function apply_biu_to_content($content, $keyword) {
            $settings = WSW_Main::$settings;

            $new_content = $content;

                if ($settings['chk_keyword_decorate_bold']===1 || $settings['chk_keyword_decorate_bold']==='1')
                    $already_apply_bold = FALSE;
                else
                    $already_apply_bold = TRUE;

                if ($settings['chk_keyword_decorate_italic']===1 || $settings['chk_keyword_decorate_italic']==='1')
                    $already_apply_italic = FALSE;
                else
                    $already_apply_italic = TRUE;

                if ($settings['chk_keyword_decorate_underline']===1 || $settings['chk_keyword_decorate_underline']==='1')
                    $already_apply_underline = FALSE;
                else
                    $already_apply_underline = TRUE;

                // Pass through all keyword until ends or until are applied all designs
                $how_many_keys = WSW_Keywords::how_many_keywords(array($keyword), $new_content);



                // To avoid make the request for each keyword: Get pieces by keyword for determine if some has the design applied
                $pieces_by_keyword = WSW_Keywords::get_pieces_by_keyword(array($keyword), $new_content,TRUE);
                $pieces_by_keyword_matches = $pieces_by_keyword[1];
                $pieces_by_keyword = $pieces_by_keyword[0];

                // First, only check for designs already applied
                for ($i=1;$i<=$how_many_keys;$i++) {

                    // Stop if are already all the design applied
                    if ($already_apply_bold && $already_apply_italic && $already_apply_underline)
                        break;


                    // Getting the position
                    $key_pos = WSW_Keywords::strpos_offset($keyword,$new_content,$i,$pieces_by_keyword,$pieces_by_keyword_matches);

                    if ($key_pos!==FALSE) {
                        $already_style = WSW_HtmlStyles::if_some_style_or_in_tag_attribute($new_content,array($keyword),$i);


                        if ($already_style) {
                            if ($already_style[1] == 'bold')
                                $already_apply_bold = TRUE;
                            elseif ($already_style[1] == 'italic')
                                $already_apply_italic = TRUE;
                            elseif ($already_style[1] == 'underline')
                                $already_apply_underline = TRUE;
                        }
                    }
                }

                // Apply designs pendings to apply
                for ($i=1;$i<=$how_many_keys;$i++) {

                    // Stop if are already all the design applied
                    if ($already_apply_bold && $already_apply_italic && $already_apply_underline)
                        break;

                    // Getting the position. Here can't be calculate one time ($pieces_by_keyword) and rehuse it because the content changes
                    $key_pos = WSW_Keywords::strpos_offset($keyword,$new_content,$i);
                    $pieces_by_keyword_matches_item = $pieces_by_keyword_matches[$i-1];


                    if ($key_pos!==FALSE) {
                        $already_style = WSW_HtmlStyles::if_some_style_or_in_tag_attribute($new_content,array($keyword),$i);

                        if ($already_style) {
                            if ($already_style[1] == 'bold')
                                $already_apply_bold = TRUE;
                            elseif ($already_style[1] == 'italic')
                                $already_apply_italic = TRUE;
                            elseif ($already_style[1] == 'underline')
                                $already_apply_underline = TRUE;
                        }
                        else {

                            if (!$already_apply_bold) {
                                $keyword_with_style = WSW_HtmlStyles::apply_bold_styles($pieces_by_keyword_matches_item);
                                $already_apply_bold = TRUE;
                            }
                            elseif (!$already_apply_italic) {
                                $keyword_with_style = WSW_HtmlStyles::apply_italic_styles($pieces_by_keyword_matches_item);
                                $already_apply_italic = TRUE;
                            }
                            elseif (!$already_apply_underline) {
                                $keyword_with_style = WSW_HtmlStyles::apply_underline_styles($pieces_by_keyword_matches_item);
                                $already_apply_underline = TRUE;
                            }

                           {
                                $new_content = substr_replace($new_content,$keyword_with_style
                                    ,$key_pos,strlen($pieces_by_keyword_matches_item));
                            }

                            // Calculate how many keyword, because in case the keyword is, for example "b" this value will change
                            $how_many_keys = WSW_Keywords::how_many_keywords(array($keyword), $new_content);
                        }
                    }
                }


            return $new_content;
        }

        public function filter_post_title($title,$post_id='') {

            if ($post_id=='') {
                global $post;
                $post_id = $post->ID;
            }

            if (!isset($post)) {
                $post = get_post($post_id);
            }

            // Check if the filter must be applied
            if (WSW_Main::$settings['chk_keyword_to_titles'] != '1')
                return $title;

            if ($title=='')
                return 'no title';

            if ($post->post_status=='auto-draft' || $post->post_status=='trash'
                || $post->post_status=='inherit'
            ) {
                return $title;
            }

            $settings = get_post_meta( $post_id , 'wsw-settings');



            if(array_key_exists(0,$settings) && trim($settings[0]['keyword_value']) == '') return $title;
if(array_key_exists(0,$settings)){
    $filtered_title = $title . ' | ' . $settings[0]['keyword_value'];

}


            // Changed for Headway Theme
            if (! isset ( $filtered_title ) || trim ( $filtered_title ) == '') {
                return $title;
            } else {
                return $filtered_title;
            }
        }


        /**
         *
         * Strip the category base
         *
         */

        function no_category_base_refresh_rules() {
            global $wp_rewrite;
            $wp_rewrite -> flush_rules();
        }

        function no_category_base_permastruct() {
            global $wp_rewrite, $wp_version;
            if (version_compare($wp_version, '3.4', '<')) {
                // For pre-3.4 support
                $wp_rewrite -> extra_permastructs['category'][0] = '%category%';
            } else {
                $wp_rewrite -> extra_permastructs['category']['struct'] = '%category%';
            }
        }

        function no_category_base_rewrite_rules($category_rewrite) {
            //var_dump($category_rewrite); // For Debugging

            $category_rewrite = array();
            $categories = get_categories(array('hide_empty' => false));
            foreach ($categories as $category) {
                $category_nicename = $category -> slug;
                if ($category -> parent == $category -> cat_ID)// recursive recursion
                    $category -> parent = 0;
                elseif ($category -> parent != 0)
                    $category_nicename = get_category_parents($category -> parent, false, '/', true) . $category_nicename;
                $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$'] = 'index.php?category_name=$matches[1]&feed=$matches[2]';
                $category_rewrite['(' . $category_nicename . ')/page/?([0-9]{1,})/?$'] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
                $category_rewrite['(' . $category_nicename . ')/?$'] = 'index.php?category_name=$matches[1]';
            }
            // Redirect support from Old Category Base
            global $wp_rewrite;
            $old_category_base = get_option('category_base') ? get_option('category_base') : 'category';
            $old_category_base = trim($old_category_base, '/');
            $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';

            //var_dump($category_rewrite); // For Debugging
            return $category_rewrite;
        }

        function no_category_base_query_vars($public_query_vars) {
            $public_query_vars[] = 'category_redirect';
            return $public_query_vars;
        }

        function no_category_base_request($query_vars) {
            //print_r($query_vars); // For Debugging
            if (isset($query_vars['category_redirect'])) {
                $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
                status_header(301);
                header("Location: $catlink");
                exit();
            }
            return $query_vars;
        }

    } // end WSW_Show
}
