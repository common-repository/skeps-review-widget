<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.skeps.nl/wordpress
 * @since      1.0.0
 *
 * @package    Skeps_GoogleReviews
 * @subpackage Skeps_GoogleReviews/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Skeps_GoogleReviews
 * @subpackage Skeps_GoogleReviews/admin
 * @author     SKEPS <support@skeps.nl>
 */
class Skeps_GoogleReviews_Admin {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->mybusiness = new Skeps_GoogleReviews_MyBusiness( $this->plugin_name, $this->version );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {


		if ( 'settings_page_'.$this->plugin_name === get_current_screen()->base):

			wp_enqueue_style( $this->plugin_name.'-admin', plugins_url('skeps-review-widget/dist/assets/') . 'css/sgr-admin.min.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name.'-public', plugins_url('skeps-review-widget/dist/assets/') . 'css/sgr-public.min.css', array(), $this->version, 'all' );

		endif;

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {


		if ( 'settings_page_'.$this->plugin_name === get_current_screen()->base):
		
			wp_enqueue_script( $this->plugin_name.'-admin', plugins_url('skeps-review-widget/dist/assets/') . 'js/sgr-admin.js', '', $this->version, true );

			$params = array(
				'url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('sgr_nonce'),
			);

			wp_localize_script( $this->plugin_name.'-admin', 'sgr_ajax', $params);

		endif;

		
	}

	/**
	 * Add menu in Wordpress admin
	 *
	 * @since    1.0.0
	 */
	public function admin_menu() {

        add_submenu_page(
            'options-general.php',
            'Skeps Review Widget',
            'Skeps Review Widget',
            'moderate_comments',
            'skeps-googlereviews',
            array($this, 'display_admin_page')
		);
		
	}
	
	/**
	 * Display adminpage in Wordpress admin
	 *
	 * @since    1.0.0
	 */
	public function display_admin_page() {

		include_once 'partials/skeps-googlereviews-admin-display.php';
		include_once(WP_PLUGIN_DIR . '/skeps-googlereviews/public/shared/skeps-googlereviews-stars.php');

	}

	/**
	 * Add settingslink to plugin overview
	 *
	 * @since    1.0.0
	 */

	public function admin_settingslink( $links ){
			
		array_unshift( $links, '<a href="options-general.php?page='.$this->plugin_name.'">Settings</a>' );
		return $links;

	}



	/**
	 * Get location info
	 * 
	 * @since 1.0.0
	 */
	public function getLocationAjax() {

		check_ajax_referer( 'sgr_nonce', 'sgr_nonce' );

		$location_id = sanitize_text_field($_POST["location_id"]);

		$location = $this->mybusiness->location->getLocation($location_id);

        return wp_send_json(['data' => $location]);

	}

	
	/**
	 * Store location info
	 * 
	 * @since 1.0.0
	*/
	public function setLocationAjax() {

		check_ajax_referer( 'sgr_nonce', 'sgr_nonce' );

		$location_id = sanitize_text_field($_POST["location_id"]);

		return $this->mybusiness->setAccountLocation($location_id);
		    
	}

	/**
	 * Preview widget shortcode in admin
	 * 
	 * @since 1.0.0
	 */
	public function previewShortcode(){

		check_ajax_referer( 'sgr_nonce', 'sgr_nonce' );

		$shortcode = (string) stripslashes($_POST["shortcode"]);
		$shortcode = str_replace('sgr-widget', 'sgr-widget preview="true"', $shortcode);

		echo do_shortcode($shortcode);

		die();

	}

	

}
