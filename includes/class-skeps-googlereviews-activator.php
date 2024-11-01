<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.skeps.nl/wordpress
 * @since      1.0.0
 *
 * @package    Skeps_GoogleReviews
 * @subpackage Skeps_GoogleReviews/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Skeps_GoogleReviews
 * @subpackage Skeps_GoogleReviews/includes
 * @author     SKEPS <support@skeps.nl>
 */
class Skeps_GoogleReviews_Activator {

	/**
	 * @since    1.0.0
	 */

	public static function activate() {

		//create hourly event for fetching
		if (! wp_next_scheduled ( 'sgr_update_location' )) {
			wp_schedule_event(time(), 'daily', 'sgr_update_location');
		}

	}


}
