<?php

namespace Modules\Provider\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\CommonModel;
use Modules\Provider\Models\AlertModel;
use Modules\User\Models\MiscModel;

class MiscController extends ResourceController
{

	//------------------------------------------------------GET LIST OF Professions HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the list of Professions
	 * 
	 * This function can be used to get the list of 
	 * Professions for SP.
	 * <code>
	 * get_profession_list();
	 * @param key
	 * </code>
	 */
	public function get_profession_list()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
		    $apiconfig = new \Config\ApiConfig();
		    
    		$api_key = $apiconfig->provider_key;
    		
    		if($key == $api_key) {
    		    $common = new CommonModel();
        		$res = $common->get_table_details_dynamically('list_profession', 'name', 'ASC');
        
        		if ($res != 'failure') {
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
	
	//------------------------------------------------------GET LIST OF Qualification HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the list of Qualifications
	 * 
	 * This function can be used to get the list of 
	 * Qualifications for SP.
	 * 
	 */
	public function get_qualification_list()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
		    $apiconfig = new \Config\ApiConfig();
		    
    		$api_key = $apiconfig->provider_key;
    		
    		if($key == $api_key) {
    		    $common = new CommonModel();
        		$res = $common->get_table_details_dynamically('sp_qual', 'qualification', 'ASC');
        
        		if ($res != 'failure') {
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
	
	//------------------------------------------------------GET LIST OF Experience HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the list of Experience
	 * 
	 * This function can be used to get the list of 
	 * Experience for SP.
	 * <code>
	 * getCat();
	 * </code>
	 */
	public function get_experience_list()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
		    $apiconfig = new \Config\ApiConfig();
		    
    		$api_key = $apiconfig->provider_key;
    		
    		if($key == $api_key) {
    		    $common = new CommonModel();
        		$res = $common->get_table_details_dynamically('sp_exp', 'id', 'ASC');
        
        		if ($res != 'failure') {
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
	
	//------------------------------------------------------GET LIST OF Language HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the list of Language
	 * 
	 * This function can be used to get the list of 
	 * Language for SP.
	 * <code>
	 * getCat();
	 * </code>
	 */
	public function get_language_list()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
		    $apiconfig = new \Config\ApiConfig();
		    
    		$api_key = $apiconfig->provider_key;
    		
    		if($key == $api_key) {
    		    $common = new CommonModel();
        		$res = $common->get_table_details_dynamically('language', 'name', 'ASC');
        
        		if ($res != 'failure') {
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
	
	//------------------------------------------------------GET LIST OF Day slot HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the day slot lits
	 * 
	 * This function can be used to get the list of 
	 * day slots for SP.
	 */
	public function get_day_slot_list()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
		    $apiconfig = new \Config\ApiConfig();
		    
    		$api_key = $apiconfig->provider_key;
    		
    		if($key == $api_key) {
    		    $common = new CommonModel();
        		$res = $common->get_table_details_dynamically('day_slot', 'id', 'ASC');
        
        		if ($res != 'failure') {
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
	
	//------------------------------------------------------GET LIST OF All services HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the list of All
	 * 
	 * This function can be used to get the list of 
	 * All for SP.
	 * <code>
	 * getCat();
	 * </code>
	 */
	public function get_initialization_list()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
		    $apiconfig = new \Config\ApiConfig();
		    
    		$api_key = $apiconfig->provider_key;
    		
    		$res = array();
    		
    		if($key == $api_key) {
    		    $common = new CommonModel();
        		$res['list_profession'] = $common->get_table_details_dynamically('list_profession', 'name', 'ASC');
        		$res['qualification'] = $common->get_table_details_dynamically('sp_qual', 'qualification', 'ASC');
        		$res['experience'] = $common->get_table_details_dynamically('sp_exp', 'id', 'ASC');
        		$res['language'] = $common->get_table_details_dynamically('language', 'name', 'ASC');
        		$res['keywords'] = $common->get_table_details_dynamically('keywords', 'keyword', 'ASC');
        		
        		if ($res != 'failure') {
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
	//---------------------------------------------------------GET LIST of SP Faq HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function sp_faq()
	{
		$validate_key = $this->request->getVar('key');
		if($validate_key == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->provider_key;
    		
    		if($key == $api_key) {
    		    $common = new CommonModel();
        		$res = $common->get_table_details_dynamically('faq_sp', 'id', 'ASC');
        
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
	//---------------------------------------------------------Add user reviews HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function post_user_review()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            
            if(!array_key_exists('overall_rating',$json) || !array_key_exists('user_rating',$json) || !array_key_exists('booking_rating',$json) 
                || !array_key_exists('app_review',$json)  || !array_key_exists('job_satisfaction',$json) || !array_key_exists('feedback',$json) 
                || !array_key_exists('booking_id',$json) || !array_key_exists('user_id',$json) || !array_key_exists('key',$json)
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
    		    
    		    if($key == $api_key) { //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
    		        $common = new CommonModel();
    		        $misc_model = new MiscModel();
    		        
    		        $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);
    		        
    		        //Insert into user_review table
    		        $arr_sp_review = array(
    		              'overall_rating' => $json->overall_rating,
    		              'user_rating' => $json->user_rating,
    		              'booking_rating' => $json->booking_rating,
        		          'app_review' => $json->app_review,
                          'job_satisfaction' => $json->job_satisfaction,
                          'feedback' => $json->feedback,
                          'booking_id' => $json->booking_id,
                          'user_id' => $json->user_id,
                    );
                    $review_id = $common->insert_records_dynamically('sp_review', $arr_sp_review);
                    
                    if ($review_id > 0) {
                        $arr_sp_details = $misc_model->get_sp_name_by_booking($json->booking_id);
        		        if($arr_sp_details != "failure") {
        		            $sp_name = $arr_sp_details['fname']." ".$arr_sp_details['lname'];
        		            $sp_id = $arr_sp_details['sp_id'];
        		            $job_title = $arr_sp_details['title'];
        		        }
            		        
                        //Insert into alert_details table
        		        $arr_alerts = array(
            		          'alert_id' => 1, 
                              'description' => $sp_name." has posted a review for booking $booking_ref_id",
                              'action' => 1,
                              'created_on' => date("Y-m-d H:i:s"), 
                              'status' => 1,
                              'users_id' => $json->user_id,
                        );
                        $common->insert_records_dynamically('alert_details', $arr_alerts);
                        
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
	//---------------------------------------------------------RETRIEVE SP ALERTS HERE ------------------------------------------------- 

    /**
     * Retrieves SP Alerts based on ID & TYPE
     * 
     * This function will be used to get alerts based on user id & action type
     * @param int $id = SP Id
     * @param int $type = 1|2 => 1 for Non Actionable & 2 for Actionable
     * @return string [JSON] => ID, Alert Type, Description, Created ons
     */
    public function get_sp_alerts()
    {
        $json = $this->request->getJSON();
        if(!array_key_exists('sp_id',$json) || !array_key_exists('type',$json) || !array_key_exists('status',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $id = $json->sp_id;
    		$type = $json->type;
    		$status = $json->status;
    		$user_type = "SP";
    		$key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->provider_key;
    		
    		if($key == $api_key) {
    
        		$alert = new AlertModel();
                
                $res = $alert->all_alerts($id, $type,$status,$user_type);
        
                if ($res != null) {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 404,
                        "message" => "No Data to show"
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
    //-------------------------------------------------------------FUNCTION ENDS ---------------------------------------------------------
    //---------------------------------------------------------UPDATE ALERTS STATUS HERE ------------------------------------------------- 

    public function update_sp_alert()
    {
        $json = $this->request->getJSON();
        
        if(!array_key_exists('id',$json) || !array_key_exists('type',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $id = $json->id;
		    $type = $json->type;
    		$key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->provider_key;
    		
    		if($key == $api_key) {
    
        		$alerts = new AlertModel();

                $date = date('Y-m-d H:m:s', time());
                $res = $alerts->update_alert($id, $date,$type);
        
                if ($res == "Success") {
                    return $this->respond([
                        "id" => 200,
                        "message" => "Successfully Updated"
                    ]);
                } else {
                    return $this->respond([
                        "id" => 400,
                        "message" => "Failed to Update"
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
    //-------------------------------------------------------------FUNCTION ENDS ---------------------------------------------------------
    //---------------------------------------------------------GET LIST of SP plans HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function sp_plans()
	{
		$validate_key = $this->request->getVar('key');
		$validate_user_id = $this->request->getVar('sp_id');
		if($validate_key == "" && $validate_user_id == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->provider_key;
    		
    		if($key == $api_key) {
    		    $common = new CommonModel();
    		    $misc_model = new MiscModel();
        		$res = $common->get_table_details_dynamically('sp_plans', 'id', 'ASC');
        		
        		$res_plan = $misc_model->get_sp_plan_details($validate_user_id);
        
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
}
