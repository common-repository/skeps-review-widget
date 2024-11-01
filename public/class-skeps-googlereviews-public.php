<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.skeps.nl/wordpress
 * @since      1.0.0
 *
 * @package    Skeps_GoogleReviews
 * @subpackage Skeps_GoogleReviews/public
 */


class Skeps_GoogleReviews_Public {


	private $plugin_name;
	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->mybusiness = new Skeps_GoogleReviews_MyBusiness( $this->plugin_name, $this->version );

		add_shortcode( 'sgr-widget', array( $this, 'sgr_widget' ) );

	}


	public function sgr_widget( $atts ) {


		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __DIR__ ) . 'dist/assets/css/sgr-public.min.css', array(), $this->version, 'all' );


		$widget_id 		= 'sgr-widget-'.$this->generateRandomString();
		$location_info 	= $this->mybusiness->location->getLocation();
		$preview 		= (boolean) (isset($atts['preview']) && $atts['preview'] === "true") ?? false;
		$type 			= (string) $atts['type'] ?? "basic";
		$theme 			= (string) $atts['theme'] ?? "light";
		$logo 			= (boolean) (isset($atts['logo']) && $atts['logo'] === "true") ?? false;
		$stars 			= (boolean) (isset($atts['stars']) && $atts['stars'] === "true") ?? false;
		$link 			= $this->linkAttribute($atts['link'], $location_info);

		$background 	 = (string) $atts['background'] ?? "transparent";
		$score_formatted = $this->svgScore($location_info);
		
		if(!$location_info){
			
			return "<div class='sgr-widget-notice error'>" . __('No Google My Business Account connected!') . "</div>";

		}	
		
		ob_start();

		include 'partials/skeps-googlereviews-widget-'.$type.'.php';
		
		if(!$preview){
			include_once 'shared/skeps-googlereviews-stars.php';
		}

		$output_string = ob_get_contents();
		ob_end_clean();

		return $output_string;
		

	}
	
	private function linkAttribute($link, $location_info) {

		switch($link){

			case "location":
				return $location_info['location']['maps_url'];
			break;

			case "review":
				return $location_info['location']['review_url'];
			break;

			default:
				return false;
			break;

		}

	}

	private function svgScore($location_info){
		
		$score = $location_info['reviews_summary']['average_rating'];
		$score = round($score / 0.5) * 0.5;
		$score = number_format($score,1, '.', '');

		return str_replace('.', '-', $score);

	}

	private function generateRandomString($length = 4) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}


}
