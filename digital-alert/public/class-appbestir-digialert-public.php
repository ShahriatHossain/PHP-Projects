<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Appbestir_Digialert
 * @subpackage Appbestir_Digialert/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Appbestir_Digialert
 * @subpackage Appbestir_Digialert/public
 * @author     Your Name <email@example.com>
 */
class Appbestir_Digialert_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $appbestir_digialert    The ID of this plugin.
	 */
	private $appbestir_digialert;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $appbestir_digialert       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $appbestir_digialert, $version ) {

		$this->appbestir_digialert = $appbestir_digialert;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Appbestir_Digialert_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Appbestir_Digialert_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( "bootstrap-min", plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( "bootstrap-datepicker", plugin_dir_url( __FILE__ ) . 'css/bootstrap-datepicker.css', array(), $this->version, 'all' );
		//wp_enqueue_style( $this->appbestir_digialert, plugin_dir_url( __FILE__ ) . 'css/appbestir-digialert-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Appbestir_Digialert_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Appbestir_Digialert_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( "jquery-min", plugin_dir_url( __FILE__ ) . 'js/jquery.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "bootstrap-min-js", plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "bootstrap-datepicker-js", plugin_dir_url( __FILE__ ) . 'js/bootstrap-datepicker.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->appbestir_digialert, plugin_dir_url( __FILE__ ) . 'js/appbestir-digialert-public.js', array( 'jquery' ), $this->version, false );

	}

}
