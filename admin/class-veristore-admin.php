<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.veristore.de/
 * @since      1.0.0
 *
 * @package    Veristore
 * @subpackage veristore/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the veristore, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Veristore
 * @subpackage veristore/admin
 * @author     Lukas Kleinschmidt <lukas.kleinschmidt@aixhibit.de>
 */
class Veristore_Admin {

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
     * The current tab.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $action
     */
    private $action;

    /**
     * nonce
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $nonce
     */
    private $nonce;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version, $options ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->options = $options;
        $this->action = isset( $_REQUEST['action'] ) ? $_REQUEST['action'] : 'token';

    }

    /**
     * Register the menu for the admin area.
     *
     * @since    1.0.0
     */
    public function veristore_menu() {
        $veristore_admin_page = add_options_page( __( 'Veristore Einstellungen', 'veristore' ), __( 'Veristore', 'veristore' ), 'manage_options', 'veristore', array( $this, 'veristore_options' ) );
    }

    /**
     * Register options for the admin menu.
     *
     * @since    1.0.0
     */
    public function veristore_options() {

        $this->create_nonce();

        if ( !current_user_can( 'manage_options' ) )
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );

        if ( !$this->get_option( 'vs_valid_token' ) && $this->action != 'token' )
            wp_die( sprintf( __( 'Kein gültiges <a href="%s">Veristore-Token</a> gefunden.', 'veristore' ), get_admin_url() . 'options-general.php?page=veristore') );

        switch ( $this->action ) {
            case 'token':

                // Update values
                $this->veristore_update_options( array( 'vs_token' ), false );

                if ( !$this->get_option( 'vs_valid_token' ) && $this->get_option( 'vs_token' ) ) {
                    echo '<div class="error"><p><strong>' . __( 'Ungültiges Veristore-Token.', 'veristore' ) . '</strong></p></div>';
                }

                if ( !$this->get_option( 'vs_valid_token' ) ) {
                    echo '<div class="notice"><p>' . __( 'Um <strong>Veristore</strong> auf Ihrer Seite nutzen zu können müssen Sie Ihr <label for="vs-token" style="vertical-align: unset"><strong>Veristore-Token</strong></label> eintragen.', 'veristore' ) . '</p><p>' . __( 'Noch nicht bei <strong>Veristore</strong> angemeldet? Jetzt registrieren.', 'veristore' ) . '<br />' . __( '<a href="https://www.veristore.de/app/register_services" target="_blank">Veristore für Dienstleister</a> oder <a href="https://www.veristore.de/app/register" target="_blank">Veristore für Shops</a>.', 'veristore' ) . '</p></div>';
                }

                if ( $this->get_option( 'vs_valid_token' ) && isset( $_POST[ 'update' ] ) ) {
                    $this->veristore_success_message();
                }

                break;

            case 'widget':

                // Update values
                $this->veristore_update_options( array( 'vs_widget', 'vs_structdata', 'vs_widget_variant', 'vs_widget_position', 'vs_widget_offset' ) );

                break;

            case 'badge':

                // Update values
                $this->veristore_update_options( array( 'vs_badge_type', 'vs_badge_width' ) );

                break;

            case 'advanced':

                // Update values
                $this->veristore_update_options( array( 'vs_deactivate_wp_widgets', 'vs_inline_css' ) );

                break;

        }

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/views/veristore-options-page.php';
    }

    /**
     * Check the Veristore-Token.
     *
     * @since    1.0.0
     */
    public function veristore_check_token() {

        if ( $this->get_option( 'vs_token' ) ) {

            if ( isset( $_POST[ 'update' ] ) ) {

            	$url = 'https://www.veristore.de/app/s/' . $this->get_option( 'vs_token' ) . '/shopdata.json';


                // Switch to wp_remote_get ()
				if ( function_exists( 'curl_version' ) ) {

					$curl = curl_init();

					curl_setopt( $curl, CURLOPT_URL, $url );
					curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 );
					curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
					curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );

					$vs_app_data = json_decode( curl_exec( $curl ) );

					curl_close( $curl );

				} elseif ( file_get_contents( __FILE__ ) && ini_get( 'allow_url_fopen' ) ) {

					$vs_app_data = json_decode( @file_get_contents( $url ) );

				} else {

					echo '<div class="error"><p><strong>' . __( 'Es ist weder curl noch allow_url_fopen aktiviert.', 'veristore' ) . '</strong></p></div>';

					return false;
				}

                if ( $vs_app_data ) {

                    $this->set_option( 'vs_valid_token', 1 );

                    return true;
                }
            }
        }

        $this->set_option( 'vs_valid_token', 0 );

        return false;
    }

    /**
     * Update options.
     *
     * @since    1.0.0
     */
    public function veristore_update_options( $opt_to_update = null, $success_message = true ) {

        // If not specified all options will get updated
        $opt_to_update = $opt_to_update ? $opt_to_update : $this->options;

        if ( isset( $_POST[ '_wpnonce' ] ) && isset( $_POST[ 'update' ] ) && check_admin_referer( 'veristore-update-' . $this->action ) ) {

            foreach ( $opt_to_update as $opt_name ) {

                // Read their posted value
                $opt_val = isset( $_POST[ $opt_name ] ) ? $_POST[ $opt_name] : false;
                $opt_val = trim( $opt_val );

                // Update options array
                if ( $this->get_option( $opt_name ) != $opt_val ) {

                    $this->set_option( $opt_name, $opt_val );
                
                    // Check Veristore-Token
                    if ( $opt_name == 'vs_token' ) {
                        $this->veristore_check_token();
                    }
                }
            }

            // Save the posted value in the database
            update_option( 'veristore_options', $this->options );

            if ( $success_message ) {
                $this->veristore_success_message();
            }
        }

        return true;
    }

    /**
     * Succes message.
     *
     * @since    1.0.0
     */
    public function veristore_success_message( $message = '' ) {
        $message = $message ? $message : __( 'Einstellungen gespeichert.', 'veristore' );
        echo '<div class="updated"><p><strong>' . $message . '</strong></p></div>';
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

    /**
     * Retrieve specific option of the plugin.
     *
     * @since     1.0.0
     */
    public function set_option( $option, $value ) {
        $this->options[ $option ] = $value;
    }

    /**
     * Create nonce.
     *
     * @since     1.0.0
     */
    public function create_nonce() {
         $this->nonce = wp_create_nonce( 'veristore-update-' . $this->action );
    }
}
