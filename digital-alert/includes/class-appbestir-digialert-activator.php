<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Appbestir_Digialert
 * @subpackage Appbestir_Digialert/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Appbestir_Digialert
 * @subpackage Appbestir_Digialert/includes
 * @author     Your Name <email@example.com>
 */
class Appbestir_Digialert_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		self::setup_custom_table_channel();
		self::setup_custom_table_notice();
		self::setup_custom_table_channel_subscribe();
		self::setup_custom_table_notice_vote();
	}

	static public function setup_custom_table_channel(){

		global $wpdb;

		$table_name = $wpdb->prefix . "digialert_channel";

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  status tinyint(1) DEFAULT 0 NOT NULL,
		  user_id mediumint(9) NOT NULL,
		  name tinytext NOT NULL,
		  short_name tinytext NOT NULL,
		  logo text DEFAULT '' NOT NULL,
		  description text DEFAULT '' NOT NULL,
		  secure_pin char(5) DEFAULT '' NOT NULL,
		  logo_file_type varchar(3) DEFAULT '' NOT NULL,
		  logo_display_name varchar(100) DEFAULT '' NOT NULL,
		  modified_date datetime NOT NULL,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

	}

	static public function setup_custom_table_notice(){

		global $wpdb;

		$table_name = $wpdb->prefix . "digialert_notice";

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  is_voting_enabled tinyint(1) DEFAULT 0 NOT NULL,
		  channel_id mediumint(9) NOT NULL,
		  notice text NOT NULL,
		  secure_pin char(5) DEFAULT '' NOT NULL,
		  notice_type varchar(10) DEFAULT '' NOT NULL,
		  file_display_name varchar(100) DEFAULT '' NOT NULL,
		  voting_last_date datetime NOT NULL,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	static public function setup_custom_table_channel_subscribe(){

		global $wpdb;

		$table_name = $wpdb->prefix . "digialert_channel_subscribe";

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
		  channel_id mediumint(9) NOT NULL,
		  user_id mediumint(9) NOT NULL
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

	static public function setup_custom_table_notice_vote(){

		global $wpdb;

		$table_name = $wpdb->prefix . "digialert_notice_vote";

		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
		  notice_id mediumint(9) NOT NULL,
		  user_id mediumint(9) NOT NULL,
		  response tinyint(1) DEFAULT 0 NOT NULL
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}

}
