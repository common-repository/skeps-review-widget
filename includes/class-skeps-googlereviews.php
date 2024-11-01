<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.skeps.nl/wordpress
 * @since      1.0.0
 *
 * @package    Skeps_GoogleReviews
 * @subpackage Skeps_GoogleReviews/includes
 */


/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Skeps_GoogleReviews
 * @subpackage Skeps_GoogleReviews/includes
 * @author     SKEPS <support@skeps.nl>
 */
class Skeps_GoogleReviews {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Skeps_GoogleReviews_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'Skeps_GoogleReviews_VERSION' ) ) {
			$this->version = Skeps_GoogleReviews_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'skeps-googlereviews';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Skeps_GoogleReviews_Loader. Orchestrates the hooks of the plugin.
	 * - Skeps_GoogleReviews_i18n. Defines internationalization functionality.
	 * - Skeps_GoogleReviews_Admin. Defines all hooks for the admin area.
	 * - Skeps_GoogleReviews_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-skeps-googlereviews-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-skeps-googlereviews-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-skeps-googlereviews-admin.php';

		// Skeps Connector API
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-skeps-connector-api.php';

		// Skeps My Business Account Class
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-skeps-googlereviews-mybusiness.php';

		// Skeps My Business Location Class
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-skeps-googlereviews-location.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-skeps-googlereviews-public.php';

		$this->loader = new Skeps_GoogleReviews_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Skeps_GoogleReviews_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Skeps_GoogleReviews_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Skeps_GoogleReviews_Admin( $this->get_plugin_name(), $this->get_version() );
		$mybusiness = new Skeps_GoogleReviews_MyBusiness( $this->get_plugin_name(), $this->get_version() );
		$location = new Skeps_GoogleReviews_Location( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'admin_menu' );

		$this->loader->add_filter( 'plugin_action_links_' . $this->plugin_name . '/' . $this->plugin_name . '.php', $plugin_admin, 'admin_settingslink' );

		//authorisation
		$this->loader->add_action( 'admin_post_sgr_authorize', $mybusiness, 'authorize' );
		$this->loader->add_action( 'admin_post_sgr_authorize_response', $mybusiness, 'authorizeResponse' );
		$this->loader->add_action( 'admin_post_sgr_deauthorize', $mybusiness, 'deauthorize' );

		//ajax
		$this->loader->add_action( 'wp_ajax_sgr_status', $mybusiness, 'status' );
		$this->loader->add_action( 'wp_ajax_sgr_locations', $mybusiness, 'fetchAccountLocations' );
		$this->loader->add_action( 'wp_ajax_sgr_get_location', $plugin_admin, 'getLocationAjax' );
		$this->loader->add_action( 'wp_ajax_sgr_save_location', $plugin_admin, 'setLocationAjax' );

		//reviews
		$this->loader->add_action( 'sgr_update_location', $location, 'updateLocation' );
		
		//shortcode
		$this->loader->add_action( 'wp_ajax_sgr_preview_shortcode', $plugin_admin, 'previewShortcode' );




	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Skeps_GoogleReviews_Public( $this->get_plugin_name(), $this->get_version() );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Skeps_GoogleReviews_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	

}
