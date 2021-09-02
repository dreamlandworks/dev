<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Admin\Models\CategoriesModel;
use Modules\Admin\Models\SubcategoriesModel;
use Modules\User\Models\keywordModel;
use Modules\User\Models\AddressModel;
use Modules\User\Models\ZipcodeModel;
use Modules\User\Models\CityModel;
use Modules\User\Models\StateModel;
use Modules\User\Models\CountryModel;

use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;

class MiscController extends ResourceController
{

	//------------------------------------------------------GET LIST OF SUB CATEGORIES HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the list of Categories
	 * 
	 * This function can be used to get the list of 
	 * categories.
	 * <code>
	 * getCat();
	 * </code>
	 */
	public function get_sub_by_cat()
	{
		$json = $this->request->getJSON();
		if(!array_key_exists('id',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    $id = $json->id;
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    		    $cat = new SubcategoriesModel();
        		$res = $cat->get_by_cat($id);
        
        		if ($res != null) {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Data to Show"
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


	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------


	//---------------------------------------------------------GET LIST CATEGORIES HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function getCat()
	{
		$validate_key = $this->request->getVar('key');
		if($validate_key == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    		    $cat = new CategoriesModel();
        		$res = $cat->showAll();
        
        		if ($res != null) {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Data to Show"
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

	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

	
	
	public function getSub()
	{
		$validate_key = $this->request->getVar('key');
		if($validate_key == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
		
        		$cat = new SubcategoriesModel();
        		$res = $cat->showAll();
        
        		if ($res != null) {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Data to Show"
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
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    public function get_keywords()
	{
		$validate_key = $this->request->getVar('key');
		$profession_id = $this->request->getVar('profession_id');
		if($validate_key == "" || $profession_id == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
		        
        		$keyword = new keywordModel();
        		$res = $keyword->showAll($profession_id);
        
        		if ($res != null) {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Data to Show",
        				"data" => array()
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
	
	public function get_keywords_autocomplete()
	{
		$validate_key = $this->request->getVar('key');
		if($validate_key == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
		
        		$keyword = new keywordModel();
        		$res = $keyword->get_keywords();
        
        		if ($res != null) {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Data to Show"
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
	//---------------------------------------------------------GET LIST of Faq HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function user_faq()
	{
		$validate_key = $this->request->getVar('key');
		if($validate_key == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    		    $common = new CommonModel();
        		$res = $common->get_table_details_dynamically('faq_users', 'id', 'ASC');
        
        		if ($res != 'failure') {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Faq to Show"
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

	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
	//---------------------------------------------------------Change Address HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function change_address()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            
            if(!array_key_exists('name',$json) || !array_key_exists('flat',$json) || !array_key_exists('apartment',$json) || !array_key_exists('landmark',$json) 
                || !array_key_exists('state',$json) || !array_key_exists('country',$json) || !array_key_exists('postal_code',$json) 
                || !array_key_exists('address',$json) || !array_key_exists('user_lat',$json) || !array_key_exists('user_long',$json)
                || !array_key_exists('users_id',$json) || !array_key_exists('keyword_id',$json) || !array_key_exists('key',$json)
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
    		    
    		    $zip_model = new ZipcodeModel();
                $city_model = new CityModel();
                $state_model = new StateModel();
                $country_model = new CountryModel();
    		    
    		    if($key == $api_key) {
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
                        'name' => $json->name,
                        'flat_no' => $json->flat,
                        'apartment_name' => $json->apartment,
                        'landmark' => $json->landmark,
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
                    $id = $common->insert_records_dynamically('user_temp_address', $data);
                    
                    if ($id > 0) {
                        //JSON Objects declared into variables
                        $keyword_id = $json->keyword_id ;
                        $city = $json->city;
                        
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
                        $common = new CommonModel();
                        $search_results_id = $common->insert_records_dynamically('search_results', $data);
                        
                        if ($arr_search_result != 'failure') {
                            return $this->respond([
                				"status" => 200,
                				"message" => "Success",
                				"data" => $arr_search_result,
                				"temp_address_id" => $id
                			]);
                		} else {
                			return $this->respond([
                				"status" => 200,
                				"message" => "No Data to Show",
                				"temp_address_id" => $id
                			]);
                		}
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
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
	//---------------------------------------------------------GET LIST of Users Addresses HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function user_temp_address()
	{
		$validate_key = $this->request->getVar('key');
		$users_id = $this->request->getVar('users_id');
		
		if($validate_key == "" || $users_id == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    		    $misc_model = new MiscModel();
        		$res = $misc_model->get_temp_address_by_user_id($id);
        
        		if ($res != 'failure') {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Faq to Show"
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

	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
	//---------------------------------------------------------GET LIST of Users Addresses HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Function used to get list of search phrases
	 * 
	 * @param key
	 * @return [mixed]
	 */
	public function get_search_phrase()
	{
		$validate_key = $this->request->getVar('key');
		if($validate_key == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
		
        		$misc_model = new MiscModel();
        		$res = $misc_model->get_search_phrase();
        
        		if ($res != null) {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Data to Show"
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

//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
//---------------------------------------------------------Add Address HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function add_address()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            
            if(!array_key_exists('name',$json) || !array_key_exists('flat',$json) || !array_key_exists('apartment',$json) || !array_key_exists('landmark',$json) 
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
    		    
    		    $zip_model = new ZipcodeModel();
                $city_model = new CityModel();
                $state_model = new StateModel();
                $country_model = new CountryModel();
    		    
    		    if($key == $api_key) {
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
                        'name' => $json->name,
                        'flat_no' => $json->flat,
                        'apartment_name' => $json->apartment,
                        'landmark' => $json->landmark,
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
                    $id = $common->insert_records_dynamically('address', $data);
                    
                    if ($id > 0) {
                        return $this->respond([
            				"status" => 200,
            				"message" => "Success",
            				"address_id" => $id
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
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
	//--------------------------------------------------UPDATE FCM TOKEN STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to update Fcm Token
     * 
     * JSON data is passed into this function to update user profile using
     * @method POST with 
     * @param mixed $user_id, @param string $fname, @param string $lname,
     * @param mixed $email, @param mixed $dob, @param string $image [Base64 encoded]  
     * @return [JSON] Success|Fail
     */
    public function update_token()
    {

        $json = $this->request->getJSON();
        if(!array_key_exists('user_id',$json) || !array_key_exists('fcm_token',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else{
        $common = new CommonModel();
        
        $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		$apiconfig = new \Config\ApiConfig();
		
    	$api_key = $apiconfig->user_key;
    		
    	if($key == $api_key)
    	{
    
            $id = $json->user_id;
            $fcm_token = $json->fcm_token;
            
            $upd_fcm_token = [
                "fcm_token" =>  $fcm_token,
            ];
            
            $common->update_records_dynamically('users', $upd_fcm_token, 'users_id', $id);
    
            return $this->respond([
                "status" => 200,
                "message" =>  "Successfully Updated"
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


//--------------------------------------------------UPDATE USER PROFILE ENDS------------------------------------------------------------
//---------------------------------------------------------GET LIST of Addresses for autocomplete HERE -------------------------------------------------
//-------------------------------------------------------------**************** -----------------------------------------------------

	public function autocomplete_address()
	{
		$validate_key = $this->request->getVar('key');
		
		if($validate_key == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    		    $misc_model = new MiscModel();
        		$res = $misc_model->get_all_addresses();
        
        		if ($res != 'failure') {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Addresses to Show"
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
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------GET LIST of User plans HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function user_plans()
	{
		$validate_key = $this->request->getVar('key');
		if($validate_key == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    		    $common = new CommonModel();
        		$res = $common->get_table_details_dynamically('user_plans', 'id', 'ASC');
        
        		if ($res != 'failure') {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Plans to Show"
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

	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
	//---------------------------------------------------------GET LIST of Bid Ranges HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function bid_range()
	{
		$validate_key = $this->request->getVar('key');
		if($validate_key == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    		    $common = new CommonModel();
        		$res = $common->get_table_details_dynamically('bid_range', 'bid_range_id', 'ASC');
        
        		if ($res != 'failure') {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Plans to Show"
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

	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
}
