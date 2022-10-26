<?php

namespace Modules\Provider\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\CommonModel;
use Modules\User\Models\ZipcodeModel;
use Modules\User\Models\CityModel;
use Modules\User\Models\StateModel;
use Modules\User\Models\CountryModel;

helper('Modules\User\custom');

class Location extends ResourceController
{
	//-----------------------------------------------LOCATION STARTS----------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to Update SP Location
     * 
     */
    public function update_location()
    {

        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            
            if(!property_exists($json, 'city') || !property_exists($json, 'state') || !property_exists($json, 'country') || !property_exists($json, 'postal_code') 
                            || !property_exists($json, 'address') || !property_exists($json, 'user_lat') || !property_exists($json, 'user_long')
                            || !property_exists($json, 'users_id') || !property_exists($json, 'online_status_id') || !property_exists($json, 'key')
                            ) {
    		    return $this->respond([
        				'status' => 403,
                        'message' => 'Invalid Parameters'
        		]);
    		}
            else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();
		
    		    $api_key = $apiconfig->provider_key;
    		    
    		    if($key == $api_key) {
    		        //creating New Models
                    $common = new CommonModel();
                    $zip_model = new ZipcodeModel();
                    $city_model = new CityModel();
                    $state_model = new StateModel();
                    $country_model = new CountryModel();
                    
                    //JSON Objects declared into variables
                    $city = $json->city;
                    $state = $json->state;
                    $country = $json->country;
                    $zip = $json->postal_code;
                    $address = $json->address;
                    $latitude = $json->user_lat;
                    $longitude = $json->user_long;
                    $users_id = $json->users_id;
                    $online_status_id = $json->online_status_id;
                    $sp_location_id = '';

                    
                    $country_id = $country_model->search_by_country($country);
                    if ($country_id == 0) {
                        $country_id = $country_model->create_country($country);
                    }
                    $state_id = $state_model->search_by_state($state);
                    if ($state_id == 0) {
                        $state_id = $state_model->create_state($state, $country_id);
                    } 
                    $city_id = $city_model->search_by_city($city);
                    if ($city_id == 0) {
                        $city_id = $city_model->create_city($city, $state_id);
                    }    
                    $zip_id = $zip_model->search_by_zipcode($zip);
                    if ($zip_id == 0) {
                        $zip_id = $zip_model->create_zip($zip, $city_id);
                    }
                    
                    $search_arr = [
                        'users_id' => $users_id,
                        'latitude' => $latitude,
                        'longitude' => $longitude
                    ];

                    $loc_data = $common->get_details_with_multiple_where('sp_location', $search_arr);
                    
                    if($loc_data != 'failure'){

                        $sp_loc_id = $loc_data[0]['id'];
                        
                        $delete_sp_location = $common->delete_records_dynamically('sp_location','id',$sp_loc_id);

                    }
                    
                    $sp_location_data = [
                        'users_id' => $users_id,
                        'address' => $address,
                        'city' => $city_id,
                        'state' => $state_id,
                        'country' => $country_id,
                        'postcode' => $zip_id,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        
                        ];
    
                    $sp_location_id = $common->insert_records_dynamically('sp_location', $sp_location_data);
                    
                    //Update users Online Status
                    $arr_users_update = array('online_status_id' => $online_status_id);
                    
                    $common->update_records_dynamically('users', $arr_users_update, 'users_id', $users_id);
        
                    if ($sp_location_id > 0) {
        
                        return $this->respond([
                            "status" => 200,
    					    "message" => "Success"
                        ]);
                    }        
                }
    		    else {
        		    return $this->respond([
            				'status' => 403,
                            'message' => 'Access Denied ! Authentication Failed'
            			]);
        		}
            }
        }    
    }

    //-----------------------------------------------LOCATION ENDS------------------------------------------------------------
    //-------------------------------------------------Updat SP online status STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to go offline
     * 
     * Call to this function updates the offline status
     * @param int $id
     * @return [JSON]
     */
    public function update_sp_online_status()
	{
		$json = $this->request->getJSON();
		if(!property_exists($json, 'key') || !property_exists($json, 'sp_id') || !property_exists($json, 'online_status_id')) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($json->key); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
		    $apiconfig = new \Config\ApiConfig();
		    
    		$api_key = $apiconfig->provider_key;
    		
    		if($key == $api_key) {
    		    $common = new CommonModel();
    		    $arr_update_sp_data = array(
	                'online_status_id' => $json->online_status_id,
    		    );
                $common->update_records_dynamically('users', $arr_update_sp_data, 'users_id', $json->sp_id);
        
        		return $this->respond([
    				"status" => 200,
    				"message" => "Success",
    		    ]);
    		}
    		else {
    		    return $this->respond([
        				'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
        			]);
    		}
		}
	}
    //--------------------------------------------------GET USER DETAILS ENDS------------------------------------------------------------
}
