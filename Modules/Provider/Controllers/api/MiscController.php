<?php

namespace Modules\Provider\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\CommonModel;
use Modules\User\Models\AlertModel;
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
		if(!isset($json['key'])) {
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
		if(!isset($json['key'])) {
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
		if(!isset($json['key'])) {
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
		if(!isset($json['key'])) {
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
		if(!isset($json['key'])) {
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
		if(!isset($json['key'])) {
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
            
            if(!property_exists($json, 'overall_rating') || !property_exists($json,'user_rating') || !property_exists($json,'booking_rating') 
                || !property_exists($json,'app_review')  || !property_exists($json,'job_satisfaction') || !property_exists($json,'feedback') 
                || !property_exists($json,'booking_id') || !property_exists($json,'user_id') || !property_exists($json,'key')
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
        if(!property_exists($json, 'id') || !property_exists($json, 'key')) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $id = $json->id;
    		$key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->provider_key;
    		
    		if($key == $api_key) {
    
        		$alert = new AlertModel();
                
                //Regular Alerts
                $res = $alert->all_alerts($id,3);
                        
                if ($res != null) {
                   $alert_regular = $res;
                   
                } else {
                    $alert_regular = [];
                }

                //Actionable Alerts

                $res = $alert->all_alerts($id,4);
                
                if ($res != null) {
                   //$alert_action = $res;
                  foreach($res as $key=>$dat){
                     
                     $alert_action[$key]['id'] = $dat['id'];
                     $alert_action[$key]['type_id'] = $dat['type_id'];
                     $alert_action[$key]['user_id'] = $dat['users_id'];
                     $alert_action[$key]['sp_id'] = $dat['user_id'];
                     $alert_action[$key]['profile_pic'] = $dat['profile_pic'];
                     $alert_action[$key]['description'] = $dat['description'];
                     $alert_action[$key]['status'] = $dat['status'];
                     $alert_action[$key]['api'] = $dat['api'];
                     $alert_action[$key]['accept_text'] = $dat['accept_text'];
                     $alert_action[$key]['reject_text'] = $dat['reject_text'];
                     $alert_action[$key]['accept_response'] = $dat['accept_response'];
                     $alert_action[$key]['reject_response'] = $dat['reject_response'];
                     $alert_action[$key]['created_on'] = $dat['created_on'];
                     $alert_action[$key]['updated_on'] = $dat['updated_on'];
                     $alert_action[$key]['booking_id'] = $dat['booking_id'];
                     $alert_action[$key]['post_id'] = $dat['post_id'];
                     $alert_action[$key]['reschedule_id'] = $dat['reschedule_id'];
                     $alert_action[$key]['status_code_id'] = $dat['status_code_id'];
                     $alert_action[$key]['req_raised_by_id'] = (is_null($dat['req_raised_by_id']) ? "" : $dat['req_raised_by_id']);
                     $alert_action[$key]['category_id'] = $dat['category_id'];
                     $alert_action[$key]['bid_id'] = (is_null($dat['bid_id']) ? "" : $dat['bid_id']);
                     $alert_action[$key]['bid_user_id'] = (is_null($dat['bid_user_id']) ? "" : $dat['bid_user_id']);

                }
               
                } else {
                    $alert_action = [];
                }

                return $this->respond([
                    'status' => 200,
                    'message' => 'Success',
                    'regular' => $alert_regular,
                    'action' =>  $alert_action
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
    //-------------------------------------------------------------FUNCTION ENDS ---------------------------------------------------------
    //---------------------------------------------------------UPDATE ALERTS STATUS HERE ------------------------------------------------- 

    public function update_sp_alert()
    {
        $json = $this->request->getJSON();
        
        if(!property_exists($json, 'id') || !property_exists($json, 'type') || !property_exists($json, 'key')) {
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

                $date = date('Y-m-d H:i:s');
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
        		$resu = $common->get_table_details_dynamically('sp_plans', 'id', 'ASC');
        		
        		$res_plan = $misc_model->get_sp_plan_details($validate_user_id);
                
                foreach($resu as $key=>$r){
                    $res[$key]['id'] = $r['id'];
                    $res[$key]['name'] = $r['name'];
                    $res[$key]['description'] = $r['description'];
                    $res[$key]['amount'] = intval($r['amount'])."";
                    $res[$key]['premium_tag'] = $r['premium_tag'];
                    $res[$key]['period'] = $r['period'];
                    $res[$key]['platform_fee_per_booking'] = intval($r['platform_fee_per_booking'])."";
                    $res[$key]['bids_per_month'] = $r['bids_per_month'];
                    $res[$key]['sealed_bids_per_month'] = $r['sealed_bids_per_month'];
                    $res[$key]['customer_support'] = $r['customer_support'];

                }


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

	//-------------------------------------------------------------Get Training Videos---------------------------------------------------------
	public function get_training_list()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json) && !array_key_exists('sp_id',$json)) {
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
    		    $misc_model = new MiscModel();
    		    $common = new CommonModel();
    		    
    		    $recent_videos = array();
    		    $watched_videos = array();
    		    $recommended_videos = array();
    		    $total_points = 0;
    		    $points_earned = 0;
    		    $total_videos = 0;
    		    $watched_videos_cnt = 0;
    		    $arr_subcategories = array();
    		    
    		    //Get SP sub category
    		    $arr_sp_prof_list = $misc_model->get_sp_prof_cat($json['sp_id']);
    		    if($arr_sp_prof_list != 'failure') {
        		    foreach($arr_sp_prof_list as $prof_data) {
    		            $arr_subcategories[$prof_data['subcategory_id']] = $prof_data['subcategory_id'];
        		    }
        		}
    		    
    		    //Get sp watched videos
    		    $arr_watched_videos = $misc_model->get_watched_videos($json['sp_id']);
        		
        		if($arr_watched_videos != 'failure') {
        		    foreach($arr_watched_videos as $wkey => $wvideo_data) {
    		            $watched_videos[$wkey]["id"] = $wvideo_data["id"];
        		        $watched_videos[$wkey]["name"] = $wvideo_data["name"];
        		        $watched_videos[$wkey]["description"] = $wvideo_data["description"];
        		        $watched_videos[$wkey]["url"] = $wvideo_data["url"];
        		        $watched_videos[$wkey]["video_categories_id"] = $wvideo_data["video_categories_id"];
        		        $watched_videos[$wkey]["subcategories_id"] = $wvideo_data["subcategories_id"];
        		        $watched_videos[$wkey]["points"] = $wvideo_data["points"];
        		        $watched_videos[$wkey]["created_on"] = $wvideo_data["created_on"];
        		        
        		        $points_earned += $wvideo_data["points"];
        		        $watched_videos_cnt ++;
        		    }
        		}    
    		    
        		$res = $misc_model->get_training_videos($arr_subcategories);
        		if($res != 'failure') {
        		    $rec_key = 0;
        		    foreach($res as $key => $video_data) {
        		        if($key < 5) {
        		            $recent_videos[$key]["id"] = $video_data["id"];
            		        $recent_videos[$key]["name"] = $video_data["name"];
            		        $recent_videos[$key]["description"] = $video_data["description"];
            		        $recent_videos[$key]["url"] = $video_data["url"];
            		        $recent_videos[$key]["video_categories_id"] = $video_data["video_categories_id"];
            		        $recent_videos[$key]["subcategories_id"] = $video_data["subcategories_id"];
            		        $recent_videos[$key]["points"] = $video_data["points"];
            		        $recent_videos[$key]["created_on"] = $video_data["created_on"];
        		        }
        		        
        		        if(array_key_exists($video_data["subcategories_id"],$arr_subcategories)) {
        		            $recommended_videos[$rec_key]["id"] = $video_data["id"];
            		        $recommended_videos[$rec_key]["name"] = $video_data["name"];
            		        $recommended_videos[$rec_key]["description"] = $video_data["description"];
            		        $recommended_videos[$rec_key]["url"] = $video_data["url"];
            		        $recommended_videos[$rec_key]["video_categories_id"] = $video_data["video_categories_id"];
            		        $recommended_videos[$rec_key]["subcategories_id"] = $video_data["subcategories_id"];
            		        $recommended_videos[$rec_key]["points"] = $video_data["points"];
            		        $recommended_videos[$rec_key]["created_on"] = $video_data["created_on"];
            		        
            		        $rec_key++;
        		        }
        		        
        		        $total_points += $video_data["points"];
        		        $total_videos ++;
        		    }
        		}
        		
        		
        		
        		if ($res != 'failure') {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"recent_videos" => $recent_videos,
        				"watched_videos" => $watched_videos,
        				"recommended_videos" => $recommended_videos,
        				"points_earned" => $points_earned,
        				"total_points" => $total_points,
        				"watched_videos_count" => $watched_videos_cnt,
        				"total_videos" => $total_videos,
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
	//-------------------------------------------------------------Update SP watched Training Videos---------------------------------------------------------
	public function update_sp_watched_video()
	{
		$json = $this->request->getVar();
		if(!isset($json['key']) && !isset($json['video_id']) && !isset($json['sp_id']) && !isset($json['points'])) {
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
    		    $misc_model = new MiscModel();
    		    $common = new CommonModel();
    		    
    		    //Check whether the user has already watched the videos
    		    
        		$arr_watched_videos = $misc_model->get_watched_videos($json['sp_id'],$json['video_id']);
        		
        		if($arr_watched_videos == 'failure') {
        		    //Insert and allot points
        		    $arr_video_watch = array(
                        'list_videos_id' => $json['video_id'],
                        'users_id' => $json['sp_id'],
                    );
    		        
    		        $video_watch_id = $common->insert_records_dynamically('video_watch', $arr_video_watch);
    		        if($video_watch_id > 0) {
    		            $arr_user_details = $common->get_details_dynamically('user_details', 'id', $json['sp_id']);
                        if($arr_user_details != 'failure') {
                            $points_count = $arr_user_details[0]['points_count']; 
                            
                            $total_points = $points_count + $json['points'];
                            
                            $arr_update_user_data = array(
        		                'points_count' => $total_points,
                		    );
                            $common->update_records_dynamically('user_details', $arr_update_user_data, 'id', $json['sp_id']);
                        }
    		        }
        		}
        		
        		return $this->respond([
                    "id" => 200,
                    "message" => "Successfully Updated"
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
