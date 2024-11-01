<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://www.veristore.de/
 * @since      1.0.0
 *
 * @package    Veristore
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

$vs_options = array(
    'veristore_options'
);

$vs_transients = array(
    'vs_app_data'
);

if ( function_exists( 'is_multisite' ) && is_multisite() ) {
    $wp_sites = wp_get_sites( array( 'limit' => 0 ) );
    foreach ( $wp_sites as $wp_site ) {
        switch_to_blog( $wp_site[ 'blog_id' ] );
        veristore_delete_options( $vs_options );
        veristore_delete_transients( $vs_transients );
        restore_current_blog();
    }
} else {
    veristore_delete_options( $vs_options );
    veristore_delete_transients( $vs_transients );
}

function veristore_delete_options( $vs_options ) {
    foreach ( $vs_options as $option_name ) {
        delete_option( $option_name );
    }
}

function veristore_delete_transients( $vs_transients ) {
    foreach ( $vs_transients as $transient_name ) {
        delete_transient( $transient_name );
    }
}