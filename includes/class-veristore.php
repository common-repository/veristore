<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.veristore.de/
 * @since      1.0.0
 *
 * @package    Veristore
 * @subpackage veristore/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Veristore
 * @subpackage veristore/includes
 * @author     Lukas Kleinschmidt <lukas.kleinschmidt@aixhibit.de>
 */
class Veristore {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Plugin_Name_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $veristore    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
     * The options of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $options
     */
    private $options;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'veristore';
		$this->version = '1.2.0';
		$this->options = get_option( 'veristore_options' );

		// For multisite installations
        if ( !$this->options ) {
            activate_veristore();
            $this->options = get_option( 'veristore_options' );
        }

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_widget_hooks();
		$this->set_vs_app_data();

		add_filter( 'plugin_action_links_veristore/veristore.php', array( $this, 'add_action_edit_link' ) );
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-veristore-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-veristore-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-veristore-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-veristore-public.php';

		/**
		 * The class for the Veristore-WordPress-Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widget/class-veristore-wp-widgets.php';

		$this->loader = new Veristore_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Veristore_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Veristore_Admin( $this->get_plugin_name(), $this->get_version(), $this->get_options() );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'veristore_menu' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Veristore_Public( $this->get_plugin_name(), $this->get_version(), $this->get_options() );

		// Load Veristore-Widget script
		if ( $this->get_option( 'vs_valid_token' ) && $this->get_option( 'vs_widget' ) ) {
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		}

		// Load custom CSS for Widgets
		if ( $this->get_option( 'vs_valid_token' ) && $this->get_option( 'vs_inline_css' ) ) {
			$this->loader->add_action( 'wp_head', $plugin_public, 'add_inline_style', PHP_INT_MAX );
		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_widget_hooks() {

		if ( $this->get_option( 'vs_valid_token' ) && !$this->get_option( 'vs_deactivate_wp_widgets' ) ) {
			add_action( 'widgets_init', create_function( '', 'register_widget( \'Veristore_Widget_Badge\' );' ) );
			add_action( 'widgets_init', create_function( '', 'register_widget( \'Veristore_Widget_Structured_Data\' );' ) );
		}
	}

	/**
	 * Load app data and save to transient
	 *
	 * @since    1.0.0
	 */
	public function set_vs_app_data() {

		if ( $this->get_option( 'vs_valid_token' ) && !get_transient( 'vs_app_data' ) ) {

			$url = 'https://www.veristore.de/app/s/' . $this->get_option( 'vs_token' ) . '/shopdata.json';

			// Switch to wp_remote_get ()
			// get app data via curl
			if ( function_exists( 'curl_version' ) ) {

				$curl = curl_init();

				curl_setopt( $curl, CURLOPT_URL, $url );
				curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 );
				curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
				curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
                                
                                $data = curl_exec( $curl );
				$vs_app_data = json_decode( $data );
                              //  print_r($vs_app_data);
				curl_close( $curl );
                            //    die;

			// get app data via file_get_contents
			} else if ( file_get_contents( __FILE__ ) && ini_get( 'allow_url_fopen' ) ) {

				$vs_app_data = json_decode( @file_get_contents( $url ) );
			} 
                        
                        // kp 24.08.2017   save only valid data
                        if ( is_object($vs_app_data) ) {
                            $aVs_app_data = (array)$vs_app_data;
                            if ( array_key_exists('token', $aVs_app_data) && !empty($aVs_app_data['token']) && array_key_exists('score', $aVs_app_data) && !empty($aVs_app_data['score']) ) {

                                //set_transient( 'vs_app_data', $vs_app_data, 60 * 60 * 4 );
                                set_transient( 'vs_app_data', $vs_app_data, 60 * 60 * 24 );
                            }
                        }
		}
	}

	/**
	 * Add link to the settings page
	 *
	 * @since    1.0.0
	 */
	public function add_action_edit_link( $links ) {
		$links[] = '<a href="' . admin_url( 'options-general.php?page=veristore' ) . '" title="' . __( 'Zu den Einstellungen dieses Plugins', 'veristore' ) . '">' . __( 'Einstellungen', 'veristore' ) . '</a>';
		return $links;
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve options of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The options of the plugin.
	 */
	public function get_options() {
		return $this->options;
	}

	/**
	 * Retrieve specific option of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The option of the plugin.
	 */
	public function get_option( $option ) {
		return $this->options[ $option ];
	}

}