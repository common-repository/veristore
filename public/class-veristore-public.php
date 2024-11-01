<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.veristore.de/
 * @since      1.0.0
 *
 * @package    Veristore
 * @subpackage veristore/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Veristore
 * @subpackage veristore/public
 * @author     Lukas Kleinschmidt <lukas.kleinschmidt@aixhibit.de>
 */
class Veristore_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
     * The options of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $options
     */
    private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $options ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->options = $options;

	}

	/**
	 * Register inline styles.
	 *
	 * @since    1.0.0
	 */
	public function add_inline_style() {

		printf( "<style type='text/css'>\n%s\n</style>\n", $this->get_option( 'vs_inline_css' ) );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		$vs_widget_opt = array(
			'token' => $this->get_option( 'vs_token' ),
			'variant' => $this->get_option( 'vs_widget_variant' ),
			'offset' => $this->get_option( 'vs_widget_offset' ),
			'position' => $this->get_option( 'vs_widget_position' ),
			'responsive' => true
		);

		wp_register_script( 'vs_widget', '//veristore.de/app/widget/veristore.min.js', array( 'jquery' ), false, true );
		wp_localize_script( 'vs_widget', 'vsConfig', $vs_widget_opt );
		wp_enqueue_script( 'vs_widget' );

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
