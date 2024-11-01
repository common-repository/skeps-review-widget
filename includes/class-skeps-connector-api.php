<?php

/**
 * Skeps_Connector_API
 *
 * @since 1.0.0
 * @copyright 2020 SKEPS Internetbureau
 */

if ( !class_exists( 'Skeps_Connector_API' ) ):

class Skeps_Connector_API {

    /**
     * @var string site_
     */

    const CACHE_LIFETIME = 86400;

    protected $site_token;
    protected $account_id;

    public $api_url;

    public function __construct() {
        
        $this->api_url = apply_filters('socialwidget_auth', 'https://mybusiness.skeps.io/api/v1/');
        $this->site_token = get_option('sgr_site_token');

    }

    /**
     * Fetches remote API
     * 
     * @param string    $endpoint requedted Endpoint
     * @param string    $method requested Method
     * @param array     $query_args additional query parameters
     * @param array     $body addition body content for POST requests
     * 
     * @return object output from endpoint
     */

    public function fetchAPI($endpoint, $method = 'POST', $query_args = array(), $body = array()){
        
        if($this->site_token){
            $body['site_token'] = $this->site_token;
        }

        if($query_args){
            $url = add_query_arg($query_args, $this->api_url.$endpoint);
        } else {
            $url = $this->api_url.$endpoint;
        }

        $response = wp_remote_post($url, 
            array(
                'method' 	=> $method,
                'headers'	=> array('Content-Type' => 'application/json'),
                'body' 		=> json_encode($body),
            )
        );


        if(is_wp_error($response)){

            $error_message = $response->get_error_message();
            set_transient('skeps_connector_api_error', $error_message, self::CACHE_LIFETIME);	
            return $error_message;

        } else {
            
            $data = json_decode($response['body']);

            if(!isset($data->error)){	
                
                return $data;

            } else {

                set_transient('skeps_connector_api_error', (string) $data->error, self::CACHE_LIFETIME);
                return (string) $data->error;
            }
        }	

    }
    

}

endif;