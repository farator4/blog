<?php

if ( ! class_exists( 'WSW_Score' ) ) {

    /**
     * Handles plugin settings and user profile meta fields
     */
    class WSW_Score extends WP_Module {
        const page_id = 'wsw_score_page';

        /*
         * Instance methods
         */
        protected function __construct() {
            add_action( 'admin_menu', __CLASS__ . '::register_score_page' );
        }

        /**
         * Adds pages to the Admin Panel menu
         */
        public function register_score_page() {

            add_submenu_page( WSW_Dashboard::page_id, WSW_NAME . 'settings', 'Scores',
                WSW_Main::REQUIRED_CAPABILITY, self::page_id,  __CLASS__ . '::markup_score_page');
        }

        /**
         * Creates the markup for the Settings page
         */
        public function markup_score_page() {
            echo '<div id="wrap" class="container">';
            WSW_Main::markup_settings_header();
            if ( current_user_can( WSW_Main::REQUIRED_CAPABILITY ) ) {


                echo self::render_template( 'global-settings/page-score.php' );
            } else {
                wp_die( 'Access denied.' );
            }
            echo '</div>';
        }
    } // end WSW_Score
}
