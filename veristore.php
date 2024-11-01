<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.veristore.de/
 * @since             1.0.1
 * @package           Veristore
 *
 * @wordpress-plugin
 * Plugin Name:       Veristore
 * Plugin URI:        https://www.veristore.de/onlineshop-bewertung/integrationscenter-plug-ins-fuer-onlineshops/plug-in-fuer-wordpress/
 * Description:       Mit dem Veristore Plugin bindest Du ganz einfach Kundenbewertungen in Deine Seite ein. Als hoverndes Widget am Seitenrand, als Badge auf der Seite und als strukturierte Daten zur Anzeige der Sterne in der Google-Suche.
 * Version:           1.3.0
 * Author:            veristore.de
 * Author URI:        http://www.veristore.de/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       veristore
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-veristore-activator.php
 */
function activate_veristore() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-veristore-activator.php';
    Veristore_Activator::activate( file_get_contents( 'TOKEN.txt', FILE_USE_INCLUDE_PATH ) );
}

register_activation_hook( __FILE__, 'activate_veristore' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-veristore.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_veristore() {
    global $useStructData;

    $veristore = new Veristore();
    $useStructData = $veristore->get_option( 'vs_structdata' );
    $veristore->run();
}

$useStructData = false;
run_veristore();

function stars_veristore() {
	$vs_app_data = get_transient( 'vs_app_data' );

        // kp 24.08.2017   get only valid data
        if ( is_object($vs_app_data) ) {

            $aVs_app_data = (array)$vs_app_data;

            if ( array_key_exists('token', $aVs_app_data) && !empty($aVs_app_data['token']) && array_key_exists('score', $aVs_app_data) && !empty($aVs_app_data['score']) ) {

                $image = 'https://www.veristore.de/app/s/' . $aVs_app_data['token'] . '/logo.png';
        echo '	<script type="application/ld+json">
                            {
                            "@context": "http://schema.org",
                            "@type": "LocalBusiness",
                            "url": "' . $vs_app_data->url . '",
                            "name": "' . $vs_app_data->name . '",
                            "image": "' . $image  . '",

                            "aggregateRating": {
                              "@type": "AggregateRating",
                              "ratingValue": "' . $vs_app_data->score . '",
                              "bestRating": "5,0",
                              "reviewCount": "' . $vs_app_data->ratings . '"
                              }
                            }
                            </script>
            ';

            }
        }
}

if ( $useStructData == true ) {
    add_action( 'wp_footer', 'stars_veristore' );
}
