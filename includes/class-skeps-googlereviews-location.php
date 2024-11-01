<?php

/**
 * Skeps_GoogleReviews_Location
 *
 * @since 1.0.0
 */


if ( !class_exists( 'Skeps_GoogleReviews_Location' ) ):

class Skeps_GoogleReviews_Location {

    const CACHE_LIFETIME = 86400;

    private $plugin_name;
    private $version;
    private $skeps_connector;
    public $location_id;
    

	public function __construct( $plugin_name, $version ) {

        $this->location_id = get_option('sgr_location_id');
        $this->skeps_connector = new Skeps_Connector_API;

    }

    /**
     * Get location object
     * 
     * @param string $id optional location id
     * @return object location
     */

    public function getLocation($id = null){

        if($id){
            return $this->fetchLocation($id);
        } 

        return json_decode(get_option('sgr_location_info'), true);

    }

    /**
     * Fetch location object from API
     * 
     * @param string $id optional location id
     * @return object location
     */

    public function fetchLocation($id = null) {

        $location_id = $id ?? $this->location_id;

        $body = array(
            'location_id' => $location_id,
        );

        return $this->skeps_connector->fetchAPI('my-business/locations', 'POST', array(), $body);
    
    }

    /**
     * Set location object as option, used for CRON events
     * 
     * @return void
     */

    public function updateLocation() : void {

        if(!$this->location_id) return;

        $location = $this->fetch_location($this->location_id);
        update_option('sgr_location_info', json_encode($location));

    }


}

endif;