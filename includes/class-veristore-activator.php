<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.veristore.de/
 * @since      1.0.0
 *
 * @package    Veristore
 * @subpackage veristore/admin
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Veristore
 * @subpackage veristore/includes
 * @author     Lukas Kleinschmidt <lukas.kleinschmidt@aixhibit.de>
 */
class Veristore_Activator {

    /**
     * Set default options.
     * Checks for Multisite installation.
     *
     * @since    1.0.0
     */
    public static function activate( $vs_token = '' ) {

        $vs_valid_token = $vs_token ? 1 : 0;

        // Default $key => $value
        $vs_default_opt_val = array(
            'veristore_options' => array(
                'vs_token' => $vs_token,
                'vs_valid_token' => $vs_valid_token,
                'vs_widget' => 1,
                'vs_structdata' => 1,
                'vs_widget_variant' => 'medium',
                'vs_widget_offset' => 50,
                'vs_widget_position' => 'right',
                'vs_deactivate_wp_widgets' => 0,
                'vs_inline_css' => '',
            )
        );

        // Initiate default values.
        foreach ( $vs_default_opt_val as $opt_name => $opt_val ) {
            add_option( $opt_name, $opt_val );
        }
    }
}
