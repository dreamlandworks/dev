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
		$validate_user_id = $this->request->getVar('users_id');
		if($validate_key == "" && $validate_user_id == "") {
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
    		    $misc_model = new MiscModel();
        		$res = $common->get_table_details_dynamically('user_plans', 'id', 'ASC');
        		
        		$res_plan = $misc_model->get_user_plan_details($validate_user_id);
        
        		if ($res != 'failure') {
        			return $this->respond([
        			    "activated_plan" => ($res_plan != 'failure') ? $res_plan['plans_id'] : 0,
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
    //---------------------------------------------------------GET LIST of Goals HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function goals_list()
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
        		$res = $common->get_table_details_dynamically('goals', 'goal_id', 'ASC');
        
        		if ($res != 'failure') {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Goals to Show"
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
	//---------------------------------------------------------GET LIST of Complaint modules HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function complaint_modules_list()
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
        		$res = $common->get_table_details_dynamically('complaint_module', 'id', 'ASC');
        
        		if ($res != 'failure') {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Modules to Show"
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
	//---------------------------------------------------------Add Complaints HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function post_complaints()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            
            if(!array_key_exists('module_id',$json) || !array_key_exists('booking_id',$json) || !array_key_exists('description',$json) || !array_key_exists('created_on',$json) 
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
    		        $common = new CommonModel();
    		        
    		        //Insert into complaints table
    		        $arr_complaints = array(
        		          'module_id' => $json->module_id,
        		          'booking_id' => $json->booking_id,
                          'description' => $json->description,
                          'created_on' => $json->created_on,
                          'users_id' => $json->users_id,
                    );
                    $complaint_id = $common->insert_records_dynamically('complaints', $arr_complaints);
                    
                    if ($complaint_id > 0) {
                        return $this->respond([
            			    "complaint_id" => $complaint_id,
            				"status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to create Complaint"
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
	//---------------------------------------------------------Add Feedback HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function post_feedback()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            
            if(!array_key_exists('description',$json) || !array_key_exists('created_on',$json) 
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
    		        $common = new CommonModel();
    		        
    		        //Insert into feedback table
    		        $arr_feedback = array(
        		          'description' => $json->description,
                          'created_on' => $json->created_on,
                          'users_id' => $json->users_id,
                    );
                    $feedback_id = $common->insert_records_dynamically('feedback', $arr_feedback);
                    
                    if ($feedback_id > 0) {
                        return $this->respond([
            			    "feedback_id" => $feedback_id,
            				"status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to create Feedback"
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
	//--------------------------------------------------DELETE Attachments START------------------------------------------------------------

    public function delete_attachment()
    {
        
        $json = $this->request->getJSON();
        if(!array_key_exists('id',$json) || !array_key_exists('key',$json)) {
    		    return $this->respond([
        				'status' => 403,
                        'message' => 'Invalid Parameters'
        		]);
    		}
        else
        {
            $id = $this->request->getJsonVar('id');
            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
    		    
    		$apiconfig = new \Config\ApiConfig();
    		
        	$api_key = $apiconfig->user_key;
    		$common = new CommonModel();
		        
		    if($key == $api_key)
        	{
                $id = $json->id;
                $common->delete_records_dynamically('attachments', 'id', $id);
                
                return $this->respond([
                    "status" => 200,
                    "message" =>  "Successfully Deleted"
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
    
//--------------------------------------------------DELETE USER ADDRESS END------------------------------------------------------------
//---------------------------------------------------------GET LIST of Offers HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function offers_list()
	{
		$json = $this->request->getJSON();
		
		$validate_key = $json->key;
		$validate_offer_type_id = $json->offer_type_id;
		$users_id = $json->users_id;
		
		if($validate_key == "" && $validate_offer_type_id == "") {
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
    		    
    		    $data = array();
    		    
        		$res = $misc_model->get_offers_list($validate_offer_type_id);
        		if($res != 'failure') {
        		    foreach($res as $key => $res_data) {
        		        $data[$key]["id"] = $res_data["id"];
        		        $data[$key]["name"] = $res_data["name"];
        		        $data[$key]["coupon_code"] = $res_data["coupon_code"];
        		        $data[$key]["valid_till"] = $res_data["valid_till"];
        		        $data[$key]["value_type_id"] = $res_data["value_type_id"];
        		        $data[$key]["value"] = $res_data["value"];
        		        $data[$key]["offer_type_id"] = $res_data["offer_type_id"];
        		        $data[$key]["offer_image"] = $res_data["offer_image"];
        		        $data[$key]["offer_type_name"] = $res_data["offer_type_name"];
        		        $data[$key]["value_type_name"] = $res_data["value_type_name"];
        		    }
        		}
        		
        		$offers_count = (count($data) > 0) ?  count($data) : 0; //Increment the key
        		
        		if($users_id > 0) {
        		    $res_select_list = $misc_model->get_offers_selection_list($users_id);
            		if($res_select_list != 'failure') {
            		    foreach($res_select_list as $res_data) {
            		        $data[$offers_count]["id"] = $res_data["id"];
            		        $data[$offers_count]["name"] = $res_data["name"];
            		        $data[$offers_count]["coupon_code"] = $res_data["coupon_code"];
            		        $data[$offers_count]["valid_till"] = $res_data["valid_till"];
            		        $data[$offers_count]["value_type_id"] = $res_data["value_type_id"];
            		        $data[$offers_count]["value"] = $res_data["value"];
            		        $data[$offers_count]["offer_type_id"] = $res_data["offer_type_id"];
            		        $data[$offers_count]["offer_image"] = $res_data["offer_image"];
            		        $data[$offers_count]["offer_type_name"] = $res_data["offer_type_name"];
            		        $data[$offers_count]["value_type_name"] = $res_data["value_type_name"];
            		        $offers_count++;
            		    }
            		}
        		}
        		
        		$res_location_country = $misc_model->get_offers_location_list(1,$country_id);
        		if($res_location_country != 'failure') {
        		    foreach($res_location_country as $res_data) {
        		        $data[$offers_count]["id"] = $res_data["id"];
        		        $data[$offers_count]["name"] = $res_data["name"];
        		        $data[$offers_count]["coupon_code"] = $res_data["coupon_code"];
        		        $data[$offers_count]["valid_till"] = $res_data["valid_till"];
        		        $data[$offers_count]["value_type_id"] = $res_data["value_type_id"];
        		        $data[$offers_count]["value"] = $res_data["value"];
        		        $data[$offers_count]["offer_type_id"] = $res_data["offer_type_id"];
        		        $data[$offers_count]["offer_image"] = $res_data["offer_image"];
        		        $data[$offers_count]["offer_type_name"] = $res_data["offer_type_name"];
        		        $data[$offers_count]["value_type_name"] = $res_data["value_type_name"];
        		        $offers_count++;
        		    }
        		}
        		
        		$res_location_state = $misc_model->get_offers_location_list(2,$state_id);
        		if($res_location_state != 'failure') {
        		    foreach($res_location_state as $res_data) {
        		        $data[$offers_count]["id"] = $res_data["id"];
        		        $data[$offers_count]["name"] = $res_data["name"];
        		        $data[$offers_count]["coupon_code"] = $res_data["coupon_code"];
        		        $data[$offers_count]["valid_till"] = $res_data["valid_till"];
        		        $data[$offers_count]["value_type_id"] = $res_data["value_type_id"];
        		        $data[$offers_count]["value"] = $res_data["value"];
        		        $data[$offers_count]["offer_type_id"] = $res_data["offer_type_id"];
        		        $data[$offers_count]["offer_image"] = $res_data["offer_image"];
        		        $data[$offers_count]["offer_type_name"] = $res_data["offer_type_name"];
        		        $data[$offers_count]["value_type_name"] = $res_data["value_type_name"];
        		        $offers_count++;
        		    }
        		}
        		
        		$res_location_city = $misc_model->get_offers_location_list(3,$city_id);
        		if($res_location_city != 'failure') {
        		    foreach($res_location_city as $res_data) {
        		        $data[$offers_count]["id"] = $res_data["id"];
        		        $data[$offers_count]["name"] = $res_data["name"];
        		        $data[$offers_count]["coupon_code"] = $res_data["coupon_code"];
        		        $data[$offers_count]["valid_till"] = $res_data["valid_till"];
        		        $data[$offers_count]["value_type_id"] = $res_data["value_type_id"];
        		        $data[$offers_count]["value"] = $res_data["value"];
        		        $data[$offers_count]["offer_type_id"] = $res_data["offer_type_id"];
        		        $data[$offers_count]["offer_image"] = $res_data["offer_image"];
        		        $data[$offers_count]["offer_type_name"] = $res_data["offer_type_name"];
        		        $data[$offers_count]["value_type_name"] = $res_data["value_type_name"];
        		        $offers_count++;
        		    }
        		}
        		
        		$res_location_zipcode = $misc_model->get_offers_location_list(4,$zip_id);
        		if($res_location_zipcode != 'failure') {
        		    foreach($res_location_zipcode as $res_data) {
        		        $data[$offers_count]["id"] = $res_data["id"];
        		        $data[$offers_count]["name"] = $res_data["name"];
        		        $data[$offers_count]["coupon_code"] = $res_data["coupon_code"];
        		        $data[$offers_count]["valid_till"] = $res_data["valid_till"];
        		        $data[$offers_count]["value_type_id"] = $res_data["value_type_id"];
        		        $data[$offers_count]["value"] = $res_data["value"];
        		        $data[$offers_count]["offer_type_id"] = $res_data["offer_type_id"];
        		        $data[$offers_count]["offer_image"] = $res_data["offer_image"];
        		        $data[$offers_count]["offer_type_name"] = $res_data["offer_type_name"];
        		        $data[$offers_count]["value_type_name"] = $res_data["value_type_name"];
        		        $offers_count++;
        		    }
        		}
        
        		if (count($data) > 0) {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $data
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Offers to Show"
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
    //---------------------------------------------------------Add SP reviews HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function post_sp_review()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            
            if(!array_key_exists('overall_rating',$json) || !array_key_exists('professionalism',$json) || !array_key_exists('skill',$json) 
                || !array_key_exists('behaviour',$json)  || !array_key_exists('satisfaction',$json) || !array_key_exists('feedback',$json) 
                || !array_key_exists('booking_id',$json) || !array_key_exists('sp_id',$json) || !array_key_exists('key',$json)
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
    		        $common = new CommonModel();
    		        
    		        //Insert into user_review table
    		        $arr_user_review = array(
    		              'overall_rating' => $json->overall_rating,
    		              'professionalism' => $json->professionalism,
    		              'skill' => $json->skill,
        		          'behaviour' => $json->behaviour,
                          'satisfaction' => $json->satisfaction,
                          'feedback' => $json->feedback,
                          'booking_id' => $json->booking_id,
                          'sp_id' => $json->sp_id,
                    );
                    $review_id = $common->insert_records_dynamically('user_review', $arr_user_review);
                    
                    if ($review_id > 0) {
                        return $this->respond([
            			    "review_id" => $review_id,
            				"status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to create Review"
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
	//---------------------------------------------------------GET LIST of Complaints HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function complaints_requests_list()
	{
		$json = $this->request->getJSON();
		
		$validate_key = $json->key;
		$users_id = $json->users_id;
		
		if($validate_key == "" && $users_id == "") {
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
    		    $data = array();
    		    $temp_data = array();
    		    $temp_replies_data = array();
    		    $arr_main_data = array();
    		    
        		$res = $misc_model->get_complaints_details($users_id);
        		if($res != 'failure') {
        		    foreach($res as $key => $res_data) {
        		        if(!array_key_exists($res_data["id"],$arr_main_data)) {
        		            $cnt = 0;
        		            
        		            $arr_main_data[$res_data["id"]] = $res_data["id"];
        		            $temp_data[$res_data["id"]]["id"] = $res_data["id"];
        		            $temp_data[$res_data["id"]]["description"] = $res_data["description"];
        		            $temp_data[$res_data["id"]]["status"] = ($res_data["status"] != "") ? $res_data["status"] : "";
        		            $temp_data[$res_data["id"]]['replies'] = array();
        		            
        		            if($res_data["complaint_status_id"] > 0) {
        		                $temp_data[$res_data["id"]]['replies'][$cnt]['action_taken'] = ($res_data["action_taken"] != "") ? $res_data["action_taken"] : "";
            		            $temp_data[$res_data["id"]]['replies'][$cnt]['status'] = ($res_data["status"] != "") ? $res_data["status"] : "";
            		            $temp_data[$res_data["id"]]['replies'][$cnt]["created_on"] = ($res_data["complaint_status_date"] != "") ? $res_data["complaint_status_date"] : "";
            		        }
        		        }
        		        else {
        		            $temp_data[$res_data["id"]]["status"] = $res_data["status"];
        		            if($res_data["complaint_status_id"] > 0) {
        		                $temp_replies_data[$res_data["id"]]['replies']['action_taken'] = ($res_data["action_taken"] != "") ? $res_data["action_taken"] : "";
            		            $temp_replies_data[$res_data["id"]]['replies']['status'] = ($res_data["status"] != "") ? $res_data["status"] : "";
            		            $temp_replies_data[$res_data["id"]]['replies']["created_on"] = ($res_data["complaint_status_date"] != "") ? $res_data["complaint_status_date"] : "";
            		            array_push($temp_data[$res_data["id"]]['replies'],$temp_replies_data[$res_data["id"]]['replies']);
        		            }
        		        }
        		    }
        		    array_push($data,$temp_data);
        	    }
        	    
        	    $arr_requests = $misc_model->get_request_details($users_id);
        	    
        		//echo "<pre>";
        		//print_r($temp_data);
        		//print_r($data[0]);
        		//print_r(array_values($data[0]));
        		//echo "</pre>";
        		//exit;
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"complaints" => (count($data) > 0) ? array_values($data[0]) : array(),
        				"requests" => ($arr_requests != 'failure') ? $arr_requests : array(),
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
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
}
