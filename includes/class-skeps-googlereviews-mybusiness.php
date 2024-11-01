<?php

/**
 * Skeps_GoogleReviews_MyBusiness
 *
 * @since 1.0.0
 */


if ( !class_exists( 'Skeps_GoogleReviews_MyBusiness' ) ):

class Skeps_GoogleReviews_MyBusiness {

    const CACHE_LIFETIME = 86400;
    const MAX_SCORE = 10;

    private $plugin_name;
    private $version;

    public $table_name;
    public $skeps_connector;
    public $site_token;

	public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->skeps_connector = new Skeps_Connector_API;
        $this->location = new Skeps_GoogleReviews_Location($plugin_name, $version);

        $this->site_token = get_option('sgr_site_token');

    }

    /**
     * Authorize with Google MyBusiness Service via our middleware
     *
     * @since 1.0.0
     * @return redirect to login_url
     */
    function status()
    {

        $status = $this->site_token ? 'authorized' : 'unauthorized';
        if($this->location->location_id){ $status = 'location_set'; }
    
        $response = [
            'status' => $status,
            'data' => $this->location->getLocation()
        ];

        return wp_send_json($response);

    }

    
    /**
     * Authorize with Google MyBusiness Service via our middleware
     * 
     * @since 1.0.0
     * @return redirect to login_url
     */
    function authorize() {
		
		if(!current_user_can("manage_options")){
			wp_die(__('No permission', 'skeps-googlereviews'));
        }
        
        delete_transient('sgr_accounts_cache');

		$query_args = array(
			'redirect_url' => admin_url('admin-post.php?action=sgr_authorize_response'),
			'nonce' => wp_create_nonce('sgr_nonce_authenticate'),
        );

        $response = $this->skeps_connector->fetchAPI('my-business/authorize', 'POST', $query_args);

		wp_redirect($response->login);

		exit;

    }
    
    /**
     *  Callback after authorizing Google Account
     * 
     * @since   1.0.0
     * @return  redirect to admin page
     */
	public function authorizeResponse(){

		if(!current_user_can("manage_options")){
			wp_die(__('No permission', 'skeps-googlereviews'));
		}

		if(!wp_verify_nonce(sanitize_key($_REQUEST['nonce']), 'sgr_nonce_authenticate')){ 
			wp_die(__('Invalid nonce', 'skeps-googlereviews')); 
		}
        
		update_option('sgr_site_token', sanitize_key($_REQUEST['site_token']));

		wp_safe_redirect(admin_url('admin.php?page=skeps-googlereviews'));

		exit;
    }

    /**
     * Deauthorize Google Account
     * 
     * @since   1.0.0
     * @return  redirect to admin page
     */
    function deauthorize() {
		
		if(!current_user_can("manage_options")){
			wp_die(__('No permission', 'skeps-googlereviews'));
		}

        $response = $this->skeps_connector->fetchAPI('my-business/deauthorize', 'POST');

        if($response->status){

            delete_option('sgr_site_token');
            delete_option('sgr_location_id');
            delete_option('sgr_location_info');
            delete_transient('sgr_accounts_cache');
            
        }

        wp_safe_redirect(admin_url('admin.php?page=skeps-googlereviews'));

		exit;

    }


    /**
     * Fetch accounts from Google Service
     * 
     * @since   1.0.0
     * @return  json Google MyBusiness locations
     */
    
	public function fetchAccountLocations(){

        check_ajax_referer( 'sgr_nonce', 'sgr_nonce' );

        $accounts_cache = get_transient('sgr_accounts_cache');
        
        if($accounts_cache){

            $locations = $accounts_cache;

        } else {

            $locations = $this->skeps_connector->fetchAPI('my-business/accounts', 'POST');
            set_transient('sgr_accounts_cache', $locations, self::CACHE_LIFETIME);

        }
        
        $response = [
            'status' => 'success',
            'data' => $locations
        ];

        return wp_send_json($response);
		
    }


    /**
     * Set account location 
     * 
     * @since   1.0.0
     * @var location_id ID of the location to set
     * @return  json Account settings with location
     */
    
	public function setAccountLocation($location_id){

        $body = array(
            'location_id' => $location_id
        );
        
        $response = $this->skeps_connector->fetchAPI('my-business/locations/set', 'POST', array(), $body);
        
        if($response){

            update_option( 'sgr_location_id', $location_id );
            update_option( 'sgr_location_info', json_encode($response));
            delete_transient('sgr_accounts_cache');

            return $this->status();

        }    
		
    }


}

endif;
