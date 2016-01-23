<?php

if ( ! class_exists( 'WSW_Module' ) ) {

	/**
	 * Abstract class to define/implement base methods for all module classes
	 */
	abstract class WSW_Module {
		private static $instances = array();
		/**
		 * Public getter for protected variables
		 * @param string $variable
		 * @return mixed
		 */
		public function __get( $variable ) {
			$module = get_called_class();


			if ( in_array( $variable, $module::$readable_properties ) ) {
				return $this->$variable;
			}
            else {
				throw new Exception( __METHOD__ . " error: $" . $variable . " doesn't exist or isn't readable." );
			}
		}
		/**
		 * Public setter for protected variables
		 * @param string $variable
		 * @param mixed  $value
		 */
		public function __set( $variable, $value ) {
			$module = get_called_class();

			if ( in_array( $variable, $module::$writeable_properties ) ) {
				$this->$variable = $value;

				if ( ! $this->is_valid() ) {
					throw new Exception( __METHOD__ . ' error: $' . $value . ' is not valid.' );
				}
			}
            else {
				throw new Exception( __METHOD__ . " error: $" . $variable . " doesn't exist or isn't writable." );
			}
		}

		/*
		 * Non-abstract methods
		 */
		/**
		 * Provides access to a single instance of a module using the singleton pattern
		 * @return object
		 */
		public static function get_instance() {
			$module = get_called_class();

            if ( ! isset( self::$instances[ $module ] ) ) {
				self::$instances[ $module ] = new $module();
			}

			return self::$instances[ $module ];
		}

		/**
		 * Render a template
		 * @param  string $default_template_path The path to the template, relative to the plugin's `views` folder
		 * @param  array  $variables             An array of variables to pass into the template's scope, indexed with the variable name so that it can be extract()-ed
		 * @param  string $require               'once' to use require_once() | 'always' to use require()
		 * @return string
		 */

        public static function render_template( $default_template_path = false, $variables = array(), $require = 'once' ) {
            do_action( 'wp_render_template_pre', $default_template_path, $variables );

            $template_path = locate_template( basename( $default_template_path ) );

            if ( ! $template_path ) {
                $template_path = dirname( __DIR__ ) . '/views/' . $default_template_path;
            }
            $template_path = apply_filters( 'wp_template_path', $template_path );

            if ( is_file( $template_path ) ) {
                extract( $variables );
                ob_start();

                if ( 'always' == $require ) {
                    require( $template_path );
                }
                else {
                    require_once( $template_path );
                }

                $template_content = apply_filters( 'wp_template_content', ob_get_clean(), $default_template_path, $template_path, $variables );
            }
            else {
                $template_content = '';
            }

            do_action( 'wp_render_template_post', $default_template_path, $variables, $template_path, $template_content );
            return $template_content;
        }

		/**
		 * Constructor
		 */
		abstract protected function __construct();

	    } // end WSW_Module
}
