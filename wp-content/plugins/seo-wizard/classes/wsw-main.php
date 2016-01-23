<?php

if ( ! class_exists( 'WSW_Main' ) ) {

	/**
	 * Main / front controller class
	 */
	class WSW_Main extends WSW_Module {

		protected $modules;
		const VERSION    = '1.0.0';
		const PREFIX     = 'wsw-';
        const REQUIRED_CAPABILITY = 'administrator';

        /**
         * Plugin directory path value. set in constructor
         * @access public
         * @var string
         */
        public static $plugin_dir;
        /**
         * Plugin url. set in constructor
         * @access public
         * @var string
         */
        public static $plugin_url;

        /**
         * Plugin name. set in constructor
         * @access public
         * @var string
         */
        public static $plugin_name;

        /**
         * The Plugin settings
         *
         * @static
         * @var string
         */
        static $settings;

		/**
		 * Constructor
		 */
		protected function __construct() {

            self::$plugin_dir = plugin_dir_path(__FILE__);
            self::$plugin_url = plugins_url('', __FILE__);
            self::$plugin_name = plugin_basename(__FILE__);


            WSW_Settings::get_options();

            if(WSW_Main::$settings['wsw_initial_dt'] == ''){
                $options = WSW_Main::$settings;
                $options['wsw_initial_dt'] = time();
                WSW_Settings::update_options($options);
            }

            // create tables for plugin work
            WSW_Model_Log::create_table();

			$this->register_hook_callbacks();
			$this->modules = array(
				'WSW_Dashboard'     => WSW_Dashboard::get_instance(),
                'WSW_Show'          => WSW_Show::get_instance(),
			);

		}

		public function register_hook_callbacks() {

			add_action( 'wp_enqueue_scripts',    array($this, 'load_resources' ));
			add_action( 'admin_enqueue_scripts', array($this, 'load_resources' ));
            add_action('admin_init',             array($this, 'admin_init'));

            // If the plugin isn't activated by Aweber or can be upgrade, show message
            add_action('admin_notices',  array($this,'show_admin_notice'));
		}

        public function show_admin_notice() {

            $variables = array();
            $msg_warning_1[]='test';
            $variables['msg_warning'] = $msg_warning_1;
            echo self::render_template( 'global-settings/page-notice.php', $variables );
            unset($variables);
        }

        public function admin_init() {
            if (get_option('seo_wizard_do_activation_redirect', false)) {
                    delete_option('seo_wizard_do_activation_redirect');
                    if(!isset($_GET['activate-multi'])) {
                        wp_redirect(add_query_arg('page', 'wsw_dashboard_page', admin_url('admin.php')));
                    }
            }

            add_action('admin_post_wsw_post_settings', array('WSW_Dashboard', 'save_post_settings'));

            add_action('wp_ajax_wsw_save_global_settings', array( 'WSW_Dashboard', 'ajax_save_global_settings'));
            add_action('wp_ajax_wsw_build_sitemap', array( 'WSW_Dashboard', 'ajax_build_sitemap'));

            add_action('wp_ajax_wsw_save_post_settings', array( 'WSW_Dashboard', 'ajax_save_post_settings'));
            add_action('wp_ajax_wsw_calc_post_score', array( 'WSW_Dashboard', 'ajax_calc_post_score'));
            add_action('wp_ajax_wsw_calc_post_density', array( 'WSW_Dashboard', 'ajax_calc_post_density'));

            add_action('wp_ajax_wsw_get_keyword_suggestion', array( 'WSW_Dashboard', 'ajax_get_keyword_suggestion'));
            add_action('wp_ajax_wsw_get_url_suggestion', array( 'WSW_Dashboard', 'ajax_get_url_suggestion'));
            add_action('wp_ajax_wsw_get_content_suggestion', array( 'WSW_Dashboard', 'ajax_get_content_suggestion'));

            add_action('wp_ajax_wsw_get_youtube', array( 'WSW_Dashboard', 'ajax_get_youtube'));
            add_action('wp_ajax_wsw_get_lsi', array( 'WSW_Dashboard', 'ajax_get_lsi'));
            add_action('wp_ajax_wsw_set_support_link', array( 'WSW_Dashboard', 'ajax_set_support_link'));

            add_action('wp_ajax_wsw_set_support_time', array( 'WSW_Dashboard', 'ajax_set_support_time'));

        }

        /**
         * Register CSS, JavaScript, etc
         */
        public function load_resources() {

            wp_register_script(
                self::PREFIX . 'admin-js',
                plugins_url( '/js/admin.js', dirname( __FILE__ ) ),
                array( 'jquery' ),
                self::VERSION,
                true
            );

            wp_register_script(
                self::PREFIX . 'bootstrap-js',
                plugins_url( '/js/bootstrap/js/bootstrap.min.js', dirname( __FILE__ ) ),
                array( 'jquery' ),
                self::VERSION,
                true
            );

            wp_register_script(
                self::PREFIX . 'zozo-js',
                plugins_url( '/js/zozo/js/zozo.tabs.min.js', dirname( __FILE__ ) ),
                array( 'jquery' ),
                self::VERSION,
                true
            );

            wp_register_script(
                self::PREFIX . 'colorpicker-js',
                plugins_url( '/js/bootstrap-colorpicker.min.js', dirname( __FILE__ ) ),
                array( 'jquery' ),
                self::VERSION,
                true
            );

            wp_register_script(
                self::PREFIX . 'zeroclipboard-js',
                plugins_url( '/js/zeroclipboard/ZeroClipboard.js', dirname( __FILE__ ) ),
                array( 'jquery' ),
                self::VERSION,
                true
            );

            ///
            wp_register_style(
                self::PREFIX . 'admin-css',
                plugins_url( 'css/admin.css', dirname( __FILE__ ) ),
                array(),
                self::VERSION,
                'all'
            );

            wp_register_style(
                self::PREFIX . 'bootstrap-css',
                plugins_url( '/js/bootstrap/css/bootstrap.css', dirname( __FILE__ ) ),
                array(),
                self::VERSION,
                'all'
            );

            wp_register_style(
                self::PREFIX . 'zozo-tab-css',
                plugins_url( '/js/zozo/css/zozo.tabs.min.css', dirname( __FILE__ ) ),
                array(),
                self::VERSION,
                'all'
            );

            wp_register_style(
                self::PREFIX . 'zozo-tab-flat-css',
                plugins_url( '/js/zozo/css/zozo.tabs.flat.min.css', dirname( __FILE__ ) ),
                array(),
                self::VERSION,
                'all'
            );

            wp_register_style(
                self::PREFIX . 'colorpicker-css',
                plugins_url( '/css/bootstrap-colorpicker.min.css', dirname( __FILE__ ) ),
                array(),
                self::VERSION,
                'all'
            );


            wp_register_style(
                self::PREFIX . 'font-awesome-css',
                plugins_url( '/css/font-awesome-4.2.0/css/font-awesome.min.css', dirname( __FILE__ ) ),
                array(),
                self::VERSION,
                'all'
            );

            wp_enqueue_style(self::PREFIX . 'font-awesome-css');
            wp_localize_script(self::PREFIX . 'admin-js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
            wp_enqueue_script( self::PREFIX . 'admin-js' );
            wp_enqueue_script( self::PREFIX . 'zeroclipboard-js' );


        }

        /**
         * Creates the markup for the Settings header
         */
        public static function markup_settings_header() {
            if ( current_user_can( self::REQUIRED_CAPABILITY ) ) {
                $variables = array();
                $variables['setting_logo_path'] = dirname(WSW_Main::$plugin_url) . '/img/logo/wp_seo_wizard_logo.png';
                echo self::render_template( 'global-settings/page-header.php' ,$variables);
            }
            else {
                wp_die( 'Access denied.' );
            }
        }

        /** get rating value list */
        static function get_rating_values()
        {
            $rating_values = array('0', '1.0','1.5', '2.0', '2.5', '3.0', '3.5', '4.0', '4.5', '5.0');
            return $rating_values;
        }

        /*
         * Instance methods
         */
        public function activate( $network_wide ) {

            $options = WSW_Main::$settings;
            $options['wsw_initial_dt'] = time();
            WSW_Settings::update_options($options);

            wp_schedule_event(time(), 'daily', 'seowizard_sitemap_event');

            update_option('seo_wizard_do_activation_redirect', true);
         }

        public function deactivate() {
           // WSW_Settings::delete_options();
           /* $psdata = (array)get_option('seo_update', array());
            if (!empty($psdata['modules'])) {
                $module_keys = array_keys($psdata['modules']);
                foreach ($module_keys as $module)
                    delete_option("seo_update_module_$module");
            }

            //Delete plugin data
            delete_option('seo_update');*/
            remove_filter('category_rewrite_rules', 'WSW_Show::no_category_base_rewrite_rules');
            global $wp_rewrite;
            update_option("SEOWizard_Options",'');
            $wp_rewrite -> flush_rules();
        }

	} // end WSW_Main

}
