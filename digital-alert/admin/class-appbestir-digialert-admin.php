<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Appbestir_Digialert
 * @subpackage Appbestir_Digialert/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Appbestir_Digialert
 * @subpackage Appbestir_Digialert/admin
 * @author     Your Name <email@example.com>
 */
class Appbestir_Digialert_Admin {

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
	 * @param      string    $appbestir_digialert       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $appbestir_digialert, $version ) {

		$this->appbestir_digialert = $appbestir_digialert;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->appbestir_digialert, plugin_dir_url( __FILE__ ) . 'css/appbestir-digialert-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( "bootstrap-min", plugin_dir_url( __FILE__ ) . 'css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( "bootstrap-datepicker", plugin_dir_url( __FILE__ ) . 'css/bootstrap-datepicker.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_script( "appbestir-digialert-admin-js", plugin_dir_url( __FILE__ ) . 'js/appbestir-digialert-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( "Chart-bundle-js", plugin_dir_url( __FILE__ ) . 'js/Chart.bundle.js', array( 'jquery' ), $this->version, false );

	}

	// Create the Plugin Name menu page with add_menu_page();
	public function add_admin_page() {
	    //this is the main item for the menu
		add_menu_page('Digi Alert', //page title
		'Channels', //menu title
		'manage_options', //capabilities
		'digialert_channel_list', //menu slug
		array( $this, 'load_admin_page_channel_list' ) //function
		);
		
		//this is a submenu
		add_submenu_page(null, //parent slug
		'Add New Channel', //page title
		'Add New', //menu title
		'manage_options', //capability
		'digialert_channel_create', //menu slug
		array( $this, 'load_admin_page_channel_create' ) //function
		);
		
		//this submenu is HIDDEN, however, we need to add it anyways
		add_submenu_page(null, //parent slug
		'Update Channel', //page title
		'Update', //menu title
		'manage_options', //capability
		'digialert_channel_update', //menu slug
		array( $this, 'load_admin_page_channel_update' ) //function
		);

		//this is a submenu
		add_submenu_page('digialert_channel_list', //parent slug
		'My Channels', //page title
		'My Channels', //menu title
		'manage_options', //capability
		'digialert_my_channels', //menu slug
		array( $this, 'load_admin_page_my_channels' ) //function
		);

		//this is a submenu
		add_submenu_page(null, //parent slug
		'Channel Search', //page title
		'Channel Search', //menu title
		'manage_options', //capability
		'digialert_channel_search', //menu slug
		array( $this, 'load_admin_page_channel_search' ) //function
		);

		//this is a submenu
		add_submenu_page('digialert_channel_list', //parent slug
		'Notices', //page title
		'Notices', //menu title
		'manage_options', //capability
		'digialert_notice_list', //menu slug
		array( $this, 'load_admin_page_notice_list' ) //function
		);

		//this is a submenu
		add_submenu_page(null, //parent slug
		'Notice Board', //page title
		'Notice Board', //menu title
		'manage_options', //capability
		'digialert_notice_board', //menu slug
		array( $this, 'load_admin_page_notice_board' ) //function
		);

		//this is a submenu
		add_submenu_page(null, //parent slug
		'Notice Voting', //page title
		'Notice Voting', //menu title
		'manage_options', //capability
		'digialert_notice_voting_result', //menu slug
		array( $this, 'load_admin_page_notice_voting_result' ) //function
		);

		//this is a submenu
		add_submenu_page(null, //parent slug
		'Add New Notice', //page title
		'Add New', //menu title
		'manage_options', //capability
		'digialert_notice_create', //menu slug
		array( $this, 'load_admin_page_notice_create' ) //function
		);

		//this submenu is HIDDEN, however, we need to add it anyways
		add_submenu_page(null, //parent slug
		'Update Notice', //page title
		'Update', //menu title
		'manage_options', //capability
		'digialert_notice_update', //menu slug
		array( $this, 'load_admin_page_notice_update' ) //function
		);


	}

	// Load the plugin admin page channel list partial.
	public function load_admin_page_channel_list() {
	    require_once plugin_dir_path( __FILE__ ). 'partials/channel/appbestir-digialert-admin-channel-list.php';
	}

	// Load the plugin admin page channel create partial.
	public function load_admin_page_channel_create() {
	    require_once plugin_dir_path( __FILE__ ). 'partials/channel/appbestir-digialert-admin-channel-create.php';
	}

	// Load the plugin admin page channel update partial.
	public function load_admin_page_channel_update() {
	    require_once plugin_dir_path( __FILE__ ). 'partials/channel/appbestir-digialert-admin-channel-update.php';
	}

	// Load the plugin admin page my channels partial.
	public function load_admin_page_my_channels() {
	    require_once plugin_dir_path( __FILE__ ). 'partials/channel/appbestir-digialert-admin-my-channels.php';
	}

	// Load the plugin admin page channel search partial.
	public function load_admin_page_channel_search() {
	    require_once plugin_dir_path( __FILE__ ). 'partials/channel/appbestir-digialert-admin-channel-search.php';
	}

	// Load the plugin admin page notice list partial.
	public function load_admin_page_notice_list() {
	    require_once plugin_dir_path( __FILE__ ). 'partials/notice/appbestir-digialert-admin-notice-list.php';
	}

	// Load the plugin admin page notice board partial.
	public function load_admin_page_notice_board() {
	    require_once plugin_dir_path( __FILE__ ). 'partials/notice/appbestir-digialert-admin-notice-board.php';
	}

	// Load the plugin admin page notice voting result partial.
	public function load_admin_page_notice_voting_result() {
	    require_once plugin_dir_path( __FILE__ ). 'partials/notice/appbestir-digialert-admin-notice-voting-result.php';
	}

	// Load the plugin admin page notice create partial.
	public function load_admin_page_notice_create() {
	    require_once plugin_dir_path( __FILE__ ). 'partials/notice/appbestir-digialert-admin-notice-create.php';
	}

	// Load the plugin admin page notice update partial.
	public function load_admin_page_notice_update() {
	    require_once plugin_dir_path( __FILE__ ). 'partials/notice/appbestir-digialert-admin-notice-update.php';
	}

}
