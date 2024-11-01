<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.skeps.nl/wordpress
 * @since             1.0.0
 * @package           Skeps_GoogleReviews
 *
 * @wordpress-plugin
 * Plugin Name:       Skeps Google Reviews
 * Plugin URI:        https://www.skeps.nl/wordpress
 * Description:       Display your Google My Business star rating on your website in just a few clicks!
 * Version:           1.0.0
 * Author:            SKEPS
 * Author URI:        https://www.skeps.nl/wordpress
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       skeps-googlereviews
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'Skeps_GoogleReviews_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-skeps-googlereviews-activator.php
 */
function activate_Skeps_GoogleReviews() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-skeps-googlereviews-activator.php';
	Skeps_GoogleReviews_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-skeps-googlereviews-deactivator.php
 */
function deactivate_Skeps_GoogleReviews() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-skeps-googlereviews-deactivator.php';
	Skeps_GoogleReviews_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Skeps_GoogleReviews' );
register_deactivation_hook( __FILE__, 'deactivate_Skeps_GoogleReviews' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-skeps-googlereviews.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_Skeps_GoogleReviews() {

	$plugin = new Skeps_GoogleReviews();
	$plugin->run();

}
run_Skeps_GoogleReviews();
