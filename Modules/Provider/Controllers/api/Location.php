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
            
            if(!array_key_exists('city',$json) || !array_key_exists('state',$json) || !array_key_exists('country',$json) || !array_key_exists('postal_code',$json) 
                            || !array_key_exists('address',$json) || !array_key_exists('user_lat',$json) || !array_key_exists('user_long',$json)
                            || !array_key_exists('users_id',$json) || !array_key_exists('online_status_id',$json) || !array_key_exists('key',$json)
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
}
