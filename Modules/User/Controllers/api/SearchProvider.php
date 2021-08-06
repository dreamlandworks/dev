<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Config\Mimes;

use Modules\User\Models\keywordModel;
use Modules\User\Models\AddressModel;
use Modules\User\Models\ZipcodeModel;
use Modules\User\Models\CityModel;
use Modules\User\Models\StateModel;
use Modules\User\Models\CountryModel;
use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;

use function PHPUnit\Framework\isEmpty;

helper('Modules\User\custom');

class SearchProvider extends ResourceController
{

    //-----------------------------------------------Search STARTS----------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to Search Service Provider
     * 
     * Call to this function will Search Service Provider
     */
    public function search_result()
    {

        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            
            
            if(!array_key_exists('keyword_id',$json) || !array_key_exists('city',$json) //keyword_id == search_phrase_id
                || !array_key_exists('state',$json) || !array_key_exists('country',$json) || !array_key_exists('postal_code',$json) 
                || !array_key_exists('address',$json) || !array_key_exists('user_lat',$json) || !array_key_exists('user_long',$json)
                || !array_key_exists('users_id',$json) || !array_key_exists('key',$json)
                            ) {
    		    return $this->respond([
        				'status' => 403,
                        'message' => 'Invalid Parameters'
        		]);
    		}
            else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();
		
    		    $api_key = $apiconfig->user_key;
    		    
    		    if($key == $api_key) {
    		        
                    //JSON Objects declared into variables
                    $keyword_id = $json->keyword_id ;
                    $city = $json->city;
                    
                    $zip_model = new ZipcodeModel();
                    $city_model = new CityModel();
                    $state_model = new StateModel();
                    $country_model = new CountryModel();
                    
                    $country_id = $country_model->search_by_country($json->country);
    		        $state_id = $state_model->search_by_state($json->state);
    		        $city_id = $city_model->search_by_city($json->city);
    		        $zip_id = $zip_model->search_by_zipcode($json->postal_code);
        
                    if ($country_id == 0) {
                        $country_id = $country_model->create_country($json->country);
                    }
    		        if ($state_id == 0) {
                        $state_id = $state_model->create_state($json->state, $country_id);
                    }
    		        if ($city_id == 0) {
    		            $city_id = $city_model->create_city($json->city, $state_id);
                    }
                    if ($zip_id == 0) {
                        $zip_id = $zip_model->create_zip($json->postal_code, $city_id);
                    }
                    //JSON Objects declared into variables
                    $data = [
                        'locality' => $json->address,
                        'latitude' => $json->user_lat,
                        'longitude' => $json->user_long,
                        'city_id' => $city_id,
                        'state_id' => $state_id,
                        'country_id' => $country_id,
                        'zipcode_id' => $zip_id,
                        'users_id' => $json->users_id
                    ];
                    $common = new CommonModel();
                    $temp_address_id = $common->insert_records_dynamically('user_temp_address', $data);
                    
                    $misc_model = new MiscModel();
        
                    //Check whether any SP is available, if yes process the details
                    $arr_search_result = $misc_model->get_search_results($keyword_id,$city);
                    
                    //Save to search_results
                    //JSON Objects declared into variables
                    $data = [
                        'keywords_id' => ($keyword_id > 0) ? $keyword_id : 0,
                        'search_query' => ($keyword_id > 0) ? "" : $keyword_id,
                        'results_show' => ($arr_search_result != 'failure') ? count($arr_search_result) : 0,
                        'latitude' => $json->user_lat,
                        'longitude' => $json->user_long,
                        'users_id' => $json->users_id,
                        'city' => $city,
                        'state' => $json->state,
                        'country' => $json->country,
                        'postal_code' => $json->postal_code,
                        'address' => $json->address,
                    ];
                    $search_results_id = $common->insert_records_dynamically('search_results', $data);
                    
                    if ($arr_search_result != 'failure') {
                        return $this->respond([
            				"status" => 200,
            				"message" => "Success",
            				"data" => $arr_search_result,
            				"search_results_id" => $search_results_id,
            				"temp_address_id" => $temp_address_id
            			]);
            		} else {
            			return $this->respond([
            				"status" => 200,
            				"message" => "No Data to Show",
            				"search_results_id" => $search_results_id,
            				"temp_address_id" => $temp_address_id
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

    //-----------------------------------------------SEARCH RESULT ENDS------------------------------------------------------------

}
