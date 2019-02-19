<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Appbestir_Digialert
 * @subpackage Appbestir_Digialert/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Appbestir_Digialert
 * @subpackage Appbestir_Digialert/includes
 * @author     Your Name <email@example.com>
 */
class Appbestir_Digialert_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		// drop a custom database table
		global $wpdb;
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}digialert_channel");
		$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}digialert_notice");

	}

}
