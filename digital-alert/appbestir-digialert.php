<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           Appbestir_Digialert
 *
 * @wordpress-plugin
 * Plugin Name:       Digialert
 * Plugin URI:        http://appbestir.com/appbestir-digialert-uri/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            AppBestir
 * Author URI:        http://appbestir.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       appbestir-digialert
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-appbestir-digialert-activator.php
 */
function activate_appbestir_digialert() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-appbestir-digialert-activator.php';
	Appbestir_Digialert_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-appbestir-digialert-deactivator.php
 */
function deactivate_appbestir_digialert() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-appbestir-digialert-deactivator.php';
	Appbestir_Digialert_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_appbestir_digialert' );
register_deactivation_hook( __FILE__, 'deactivate_appbestir_digialert' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-appbestir-digialert.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_appbestir_digialert() {

	$plugin = new Appbestir_Digialert();
	$plugin->run();

}
run_appbestir_digialert();
