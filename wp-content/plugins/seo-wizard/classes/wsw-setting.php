<?php

if ( ! class_exists( 'WSW_Settings' ) ) {

    /**
     *
     */
    class WSW_Settings{

        /**
         * The name for plugin options
         *
         * @var string
         */
        static $global_option = 'SEOWizard_Options';

        /**
         * Updates the General Settings of Plugin
         *
         * @return void
         * @access public
         */
        static function update_options($options) {
            // Save Class variable
            WSW_Main::$settings = $options;

            return update_option(self::$global_option, $options);
        }

        static function delete_options() {
            delete_option(self::$global_option);
        }


        /**
         * Return the General Settings of Plugin, and set them to default values if they are empty
         *
         * @return array general options of plugin
         * @access public
         */
        static function get_options() {

            // If isn't empty, return class variable
            if (WSW_Main::$settings) {
                return WSW_Main::$settings;
            }

            // default values
            $options = array (
                'chk_keyword_to_titles' => '1',
                'chk_nofollow_in_external' => '0',
                'chk_nofollow_in_image' => '0',
                'chk_use_facebook' => '0',
                'chk_use_twitter' => '0',
                'chk_use_richsnippets' => '1',

                'chk_keyword_decorate_bold' => '0',
                'chk_keyword_decorate_italic' => '0',
                'chk_keyword_decorate_underline' => '0',

                'opt_keyword_decorate_bold_type' => '0',
                'opt_keyword_decorate_italic_type' => '0',
                'opt_keyword_decorate_underline_type' => '0',
                'opt_image_alternate_type' => 'empty',
                'opt_image_title_type' => 'empty',

                'txt_image_alternate' => '',
                'txt_image_title' => '',
                'lsi_bing_api_key' => '',

                'chk_use_headings_h1' => '0',
                'chk_use_headings_h2' => '0',
                'chk_use_headings_h3' => '0',

                'chk_tagging_using_google' => '0',
                'txt_generic_tags' => '',
                'chk_author_linking' => '0',
                'wsw_initial_dt' => '',
                'chk_block_login_page' => '0',
                'chk_block_admin_page' => '0',

                'chk_use_meta_robot' => '1',
                'chk_tweak_permalink' => '0',
                'chk_make_sitemap' => '0',
                'wsw_set_time_check'=>'0',
                'anchor_text'=>''
            );


            // get saved options
            $saved = get_option(self::$global_option);

            // assign them
            if (!empty($saved)) {
                foreach ($saved as $key => $option) {

                    $options[$key] = $option;
                }
            }else{
                update_option(self::$global_option, $options);
            }

/*            // update the options if necessary
            if ($saved != $options) {var_dump("111");
                update_option(self::$global_option, $options);
            }*/

            // Save class variable
            WSW_Main::$settings = $options;

            //return the options
            return $options;
        }

    } // end WSW_Settings
}
