<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://www.skeps.nl/wordpress
 * @since      1.0.0
 *
 * @package    Skeps_GoogleReviews
 * @subpackage Skeps_GoogleReviews/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Skeps_GoogleReviews
 * @subpackage Skeps_GoogleReviews/includes
 * @author     SKEPS <support@skeps.nl>
 */
class Skeps_GoogleReviews_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		wp_clear_scheduled_hook('sgr_update_location');

		delete_option('sgr_site_token');
		delete_option('sgr_location_id');
		delete_option('sgr_location_info');
		delete_transient('sgr_accounts_cache');
	}

}
