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
use Modules\User\Models\JobPostModel;

helper('Modules\User\custom');

class PostjobController extends ResourceController
{

	//---------------------------------------------------------Single move job post-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function single_move_job_post()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/
            
            if(!array_key_exists('scheduled_date',$json) || !array_key_exists('time_slot_from',$json)  || !array_key_exists('job_description',$json) 
                || !array_key_exists('bids_period',$json) || !array_key_exists('bid_per',$json) || !array_key_exists('bid_range_id',$json) 
                || !array_key_exists('address_id',$json) || !array_key_exists('title',$json) || !array_key_exists('lang_responses',$json)
                || !array_key_exists('bid_range_id',$json) || !array_key_exists('keywords_responses',$json) || !array_key_exists('created_on',$json)
                || !array_key_exists('attachments',$json) || !array_key_exists('estimate_time',$json) || !array_key_exists('estimate_type_id',$json)
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
    		        $attachments = $json->attachments;
    		        
    		        $common = new CommonModel();
    		        
    		        $arr_time_slot_details = $common->get_details_dynamically('time_slot', 'from', $json->time_slot_from);
    		        if($arr_time_slot_details != 'failure') {
    		            $time_slot_id = $arr_time_slot_details[0]['id'];
    		        }
    		        else {
    		            $arr_time_slot = array(
            		        'from' => $json->time_slot_from
                        );
                        $time_slot_id = $common->insert_records_dynamically('time_slot', $arr_time_slot);
    		        }
    		        
    		        $arr_job_post = array(
        		        'users_id' => $json->users_id,
                        'category_id' => 1,
                        'scheduled_date' => $json->scheduled_date,
                        'time_slot_id' => $time_slot_id,
                        'started_at' => "",
                        'amount' => 0,
                        'sp_id' => 0,
                        'created_on' => $json->created_on,
                        'otp' => "",
                        'attachment_count' => count($attachments),
                        'status_id' => 1,
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                    );
                    $booking_id = $common->insert_records_dynamically('booking', $arr_job_post);
                    
                    if ($booking_id > 0) {
                        
                        $address_id = $json->address_id;
                        
                        //Insert into Single move table
                        $arr_single_move = array(
                                'booking_id' => $booking_id,
                                'address_id' => $address_id,
                                'job_description' => $json->job_description,
                            );
                        /*echo "<pre>";
                        print_r($arr_single_move);
                        echo "</pre>";    */
                        
                        $common->insert_records_dynamically('single_move', $arr_single_move);
                        
                        //Insert into booking status
                        $arr_job_post_status = array(
            		        'booking_id' => $booking_id,
                            'status_id' => 1,
                            'created_on' => $json->created_on
                        );
                        $common->insert_records_dynamically('booking_status', $arr_job_post_status);
                        
                        //Get Plan id
                        $res = $common->get_details_dynamically('subs_plan', 'users_id', $json->users_id);
                        $user_plan_id = ($res != 'failure') ? $res[0]['subs_id'] : 0;
                        
                        //Insert into post_job table
                        $arr_post_job = array(
                                'booking_id' => $booking_id,
                                'user_plan_id' => $user_plan_id,
                                'status_id' => 9,
                                'bids_period' => $json->bids_period,
                                'title' => $json->title,
                                'bid_per' => $json->bid_per,
                                'bid_range_id' => $json->bid_range_id,
                            );
                        
                        $post_job_id = $common->insert_records_dynamically('post_job', $arr_post_job);
                        
                        if($post_job_id > 0) {
                        
                            //******************Languages
                        
                            $common->delete_records_dynamically('post_req_lang', 'post_job_id', $post_job_id);
                            
                            foreach($json->lang_responses as $lang_key => $lang_data) {
                                $lang_id = $lang_data->lang_id;
                                if($lang_id == 0) { //Insert into user_lang_list ::	language_id	users_id
                                    //Check whether language exists in language, if not create
                    		        $arr_ins_lang_master_det = array(
                		                'name' => $lang_data->name
                    		        );
                    		        /*echo "<pre>";
                    		        print_r($arr_ins_lang_master_det);
                    		        echo "</pre>";*/
                    		        
                    		        $lang_id = $common->insert_records_dynamically('language', $arr_ins_lang_master_det);
                                }
                                
                                //Insert into post_req_lang table
                                $arr_post_req_lang = array(
                                        'post_job_id' => $post_job_id,
                                        'language_id' => $lang_id,
                                        'status' => 'Active',
                                    );
                                
                                $post_req_id = $common->insert_records_dynamically('post_req_lang', $arr_post_req_lang);
                            }
                            //*******************Keywords
                            
                            $common->delete_records_dynamically('post_req_keyword', 'post_job_id', $post_job_id);
                            
                            foreach($json->keywords_responses as $keywords_key => $keywords_data) {
                                $keyword_id = $keywords_data->keyword_id;
                                if($keyword_id == 0) { //Insert into keywords :: keyword,subcategories_id
        
                                    //Check whether keyword exists in keywords, if not create
                    		        $arr_ins_keywords_master_det = array(
                		                'keyword' => $keywords_data->name,
                		                'profession_id' => 0,
        								'status' => 'Inactive'
                    		        );
                    		        /*echo "<pre>";
                    		        print_r($arr_ins_keywords_master_det);
                    		        echo "</pre>";*/
                    		        
                    		        $keyword_id = $common->insert_records_dynamically('keywords', $arr_ins_keywords_master_det);
                    		        //echo "<br> keyword id ".$keyword_id;
                                }
                                
                                //Insert into post_req_lang table
                                $arr_post_req_keyword = array(
                                        'post_job_id' => $post_job_id,
                                        'keywords_id' => $keyword_id,
                                        'status' => 'Active',
                                    );
                                
                                $post_req_id = $common->insert_records_dynamically('post_req_keyword', $arr_post_req_keyword);
                                
                                /*echo "<pre>";
                		        print_r($arr_ins_keyword_det);
                		        echo "</pre>";*/
                		        //echo '<br> user_keyword_list_id  '.$user_keyword_list_id;
                            }
                        }
                        //Create and save atatchments
                        if(count($attachments) > 0) {
                            foreach($attachments as $attach_key => $arr_file) {
                                foreach($arr_file as $attach_name => $file) {
                                    if ($file != null) {
                                        $image = generateDynamicImage("images/attachments",$file);
                                        
                                        $arr_attach = array(
                                                'booking_id' => $booking_id,
                                                'file_name' => $image,
                                                'file_location' => 'images/attachments',
                                                'created_on' => $json->created_on,
                                                'created_by' => $json->users_id,
                                                'status_id' => 1
                                            );
                                        $common->insert_records_dynamically('attachments', $arr_attach);
                                    }
                                }
                            }
                        }
                        
            			return $this->respond([
            			    "post_job_id" => $post_job_id,
            			    "post_job_ref_id" => str_pad($post_job_id, 6, "0", STR_PAD_LEFT),
            			    "user_plan_id" => $user_plan_id,
            				"status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
            		        "status" => 404,
        					"message" => "Failed to create Job Post"
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
	//---------------------------------------------------------Blue Collar Job Post-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function blue_collar_job_post()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/
            
            if(!array_key_exists('scheduled_date',$json) || !array_key_exists('time_slot_from',$json)  || !array_key_exists('job_description',$json) 
                || !array_key_exists('bids_period',$json) || !array_key_exists('bid_per',$json) || !array_key_exists('bid_range_id',$json) 
                || !array_key_exists('title',$json) || !array_key_exists('lang_responses',$json)
                || !array_key_exists('bid_range_id',$json) || !array_key_exists('keywords_responses',$json) || !array_key_exists('created_on',$json)
                || !array_key_exists('attachments',$json) || !array_key_exists('estimate_time',$json) || !array_key_exists('estimate_type_id',$json)
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
    		        $attachments = $json->attachments;
    		        
    		        $common = new CommonModel();
    		        //Get master time slot
                    $arr_time_slot_details = $common->get_details_dynamically('time_slot', 'from', $json->time_slot_from);
    		        if($arr_time_slot_details != 'failure') {
    		            $time_slot_id = $arr_time_slot_details[0]['id'];
    		        }
    		        else {
    		            $arr_time_slot = array(
            		        'from' => $json->time_slot_from
                        );
                        $time_slot_id = $common->insert_records_dynamically('time_slot', $arr_time_slot);
    		        }
    		        
    		        $arr_job_post = array(
        		        'users_id' => $json->users_id,
                        'category_id' => 2,
                        'scheduled_date' => $json->scheduled_date,
                        'time_slot_id' => $time_slot_id,
                        'started_at' => "",
                        'amount' => 0,
                        'sp_id' => 0,
                        'created_on' => $json->created_on,
                        'otp' => "",
                        'attachment_count' => count($attachments),
                        'status_id' => 1,
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                    );
                    $booking_id = $common->insert_records_dynamically('booking', $arr_job_post);
    		        
    		        if ($booking_id > 0) {
                        
                        //Insert into blue_collar table
                        $arr_blue_collar = array(
                                'booking_id' => $booking_id,
                                'job_description' => $json->job_description,
                            );
                        /*echo "<pre>";
                        print_r($arr_blue_collar);
                        echo "</pre>";    */
                        
                        $common->insert_records_dynamically('blue_collar', $arr_blue_collar);
                        
                        //Insert into booking status
                        $arr_job_post_status = array(
            		        'booking_id' => $booking_id,
                            'status_id' => 1,
                            'created_on' => $json->created_on
                        );
                        $common->insert_records_dynamically('booking_status', $arr_job_post_status);
                        
                        //Get Plan id
                        $res = $common->get_details_dynamically('subs_plan', 'users_id', $json->users_id);
                        $user_plan_id = ($res != 'failure') ? $res[0]['subs_id'] : 0;
                        
                        //Insert into post_job table
                        $arr_post_job = array(
                                'booking_id' => $booking_id,
                                'user_plan_id' => $user_plan_id,
                                'status_id' => 9,
                                'bids_period' => $json->bids_period,
                                'title' => $json->title,
                                'bid_per' => $json->bid_per,
                                'bid_range_id' => $json->bid_range_id,
                            );
                        
                        $post_job_id = $common->insert_records_dynamically('post_job', $arr_post_job);
                        
                        if($post_job_id > 0) {
                        
                            //******************Languages
                            $common->delete_records_dynamically('post_req_lang', 'post_job_id', $post_job_id);
                            
                            foreach($json->lang_responses as $lang_key => $lang_data) {
                                $lang_id = $lang_data->lang_id;
                                if($lang_id == 0) { //Insert into user_lang_list ::	language_id	users_id
                                    //Check whether language exists in language, if not create
                    		        $arr_ins_lang_master_det = array(
                		                'name' => $lang_data->name
                    		        );
                    		        /*echo "<pre>";
                    		        print_r($arr_ins_lang_master_det);
                    		        echo "</pre>";*/
                    		        
                    		        $lang_id = $common->insert_records_dynamically('language', $arr_ins_lang_master_det);
                                }
                                
                                //Insert into post_req_lang table
                                $arr_post_req_lang = array(
                                        'post_job_id' => $post_job_id,
                                        'language_id' => $lang_id,
                                        'status' => 'Active',
                                    );
                                
                                $post_req_id = $common->insert_records_dynamically('post_req_lang', $arr_post_req_lang);
                            }
                            //*******************Keywords
                            
                            $common->delete_records_dynamically('post_req_keyword', 'post_job_id', $post_job_id);
                            
                            foreach($json->keywords_responses as $keywords_key => $keywords_data) {
                                $keyword_id = $keywords_data->keyword_id;
                                if($keyword_id == 0) { //Insert into keywords :: keyword,subcategories_id
        
                                    //Check whether keyword exists in keywords, if not create
                    		        $arr_ins_keywords_master_det = array(
                		                'keyword' => $keywords_data->name,
                		                'profession_id' => 0,
        								'status' => 'Inactive'
                    		        );
                    		        /*echo "<pre>";
                    		        print_r($arr_ins_keywords_master_det);
                    		        echo "</pre>";*/
                    		        
                    		        $keyword_id = $common->insert_records_dynamically('keywords', $arr_ins_keywords_master_det);
                    		        //echo "<br> keyword id ".$keyword_id;
                                }
                                
                                //Insert into post_req_lang table
                                $arr_post_req_keyword = array(
                                        'post_job_id' => $post_job_id,
                                        'keywords_id' => $keyword_id,
                                        'status' => 'Active',
                                    );
                                
                                $post_req_id = $common->insert_records_dynamically('post_req_keyword', $arr_post_req_keyword);
                                
                                /*echo "<pre>";
                		        print_r($arr_ins_keyword_det);
                		        echo "</pre>";*/
                		        //echo '<br> user_keyword_list_id  '.$user_keyword_list_id;
                            }
                        }
                    
                        //Create and save atatchments
                        if(count($attachments) > 0) {
                            foreach($attachments as $attach_key => $arr_file) {
                                foreach($arr_file as $attach_name => $file) {
                                    if ($file != null) {
                                        $image = generateDynamicImage("images/attachments",$file);
                                        
                                        $arr_attach = array(
                                                'booking_id' => $booking_id,
                                                'file_name' => $image,
                                                'file_location' => 'images/attachments',
                                                'created_on' => $json->created_on,
                                                'created_by' => $json->users_id,
                                                'status_id' => 1
                                            );
                                        $common->insert_records_dynamically('attachments', $arr_attach);
                                    }
                                }
                            }
                        }
                        
                        return $this->respond([
            			    "post_job_id" => $post_job_id,
            			    "post_job_ref_id" => str_pad($post_job_id, 6, "0", STR_PAD_LEFT),
            			    "user_plan_id" => $user_plan_id,
            				"status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to create Job Post"
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
	//---------------------------------------------------------Multi Move Job Post-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function multi_move_job_post()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";*/
            //exit;
            
            if(!array_key_exists('scheduled_date',$json) || !array_key_exists('time_slot_from',$json)   
                || !array_key_exists('bids_period',$json) || !array_key_exists('bid_per',$json) || !array_key_exists('bid_range_id',$json) 
                || !array_key_exists('addresses',$json) || !array_key_exists('title',$json) || !array_key_exists('lang_responses',$json)
                || !array_key_exists('bid_range_id',$json) || !array_key_exists('keywords_responses',$json) || !array_key_exists('created_on',$json)
                || !array_key_exists('attachments',$json) || !array_key_exists('estimate_time',$json) || !array_key_exists('estimate_type_id',$json)
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
    		        $attachments = $json->attachments;
    		        
    		        $common = new CommonModel();
    		        
    		        //Get master time slot
                    $arr_time_slot_details = $common->get_details_dynamically('time_slot', 'from', $json->time_slot_from);
    		        if($arr_time_slot_details != 'failure') {
    		            $time_slot_id = $arr_time_slot_details[0]['id'];
    		        }
    		        else {
    		            $arr_time_slot = array(
            		        'from' => $json->time_slot_from
                        );
                        $time_slot_id = $common->insert_records_dynamically('time_slot', $arr_time_slot);
    		        }
    		        
    		        $arr_job_post = array(
        		        'users_id' => $json->users_id,
                        'category_id' => 3,
                        'scheduled_date' => $json->scheduled_date,
                        'time_slot_id' => $time_slot_id,
                        'started_at' => "",
                        'amount' => 0,
                        'sp_id' => 0,
                        'created_on' => $json->created_on,
                        'otp' => "",
                        'attachment_count' => count($attachments),
                        'status_id' => 1,
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                    );
                    $booking_id = $common->insert_records_dynamically('booking', $arr_job_post);
    		        
    		        if ($booking_id > 0) {
                        $addresses = $json->addresses;
                        
                        if(count($addresses) > 0) {
                            foreach($addresses as $address_key => $arr_address) {
                                //Insert into multi_move table
                                $arr_multi_move[] = array(
                                        'booking_id' => $booking_id,
                                        'sequence_no' => $arr_address->sequence_no,
                                        'address_id' => $arr_address->address_id,
                                        'job_description' => $arr_address->job_description,
                                        'weight_type' => $arr_address->weight_type,
                                    );
                            }
                            /*echo "<pre>";
                            print_r($arr_multi_move);
                            echo "</pre>";
                            exit;*/
                            $common->batch_insert_records_dynamically('multi_move', $arr_multi_move);
                        }
                        
                        //Insert into booking status
                        $arr_job_post_status = array(
            		        'booking_id' => $booking_id,
                            'status_id' => 1,
                            'created_on' => $json->created_on
                        );
                        $common->insert_records_dynamically('booking_status', $arr_job_post_status);
                        
                        //Get Plan id
                        $res = $common->get_details_dynamically('subs_plan', 'users_id', $json->users_id);
                        $user_plan_id = ($res != 'failure') ? $res[0]['subs_id'] : 0;
                        
                        //Insert into post_job table
                        $arr_post_job = array(
                                'booking_id' => $booking_id,
                                'user_plan_id' => $user_plan_id,
                                'status_id' => 9,
                                'bids_period' => $json->bids_period,
                                'title' => $json->title,
                                'bid_per' => $json->bid_per,
                                'bid_range_id' => $json->bid_range_id,
                            );
                        
                        $post_job_id = $common->insert_records_dynamically('post_job', $arr_post_job);
                        
                        if($post_job_id > 0) {
                        
                            //******************Languages
                        
                            $common->delete_records_dynamically('post_req_lang', 'post_job_id', $post_job_id);
                            
                            foreach($json->lang_responses as $lang_key => $lang_data) {
                                $lang_id = $lang_data->lang_id;
                                if($lang_id == 0) { //Insert into user_lang_list ::	language_id	users_id
                                    //Check whether language exists in language, if not create
                    		        $arr_ins_lang_master_det = array(
                		                'name' => $lang_data->name
                    		        );
                    		        /*echo "<pre>";
                    		        print_r($arr_ins_lang_master_det);
                    		        echo "</pre>";*/
                    		        
                    		        $lang_id = $common->insert_records_dynamically('language', $arr_ins_lang_master_det);
                                }
                                
                                //Insert into post_req_lang table
                                $arr_post_req_lang = array(
                                        'post_job_id' => $post_job_id,
                                        'language_id' => $lang_id,
                                        'status' => 'Active',
                                    );
                                
                                $post_req_id = $common->insert_records_dynamically('post_req_lang', $arr_post_req_lang);
                            }
                            //*******************Keywords
                            
                            $common->delete_records_dynamically('post_req_keyword', 'post_job_id', $post_job_id);
                            
                            foreach($json->keywords_responses as $keywords_key => $keywords_data) {
                                $keyword_id = $keywords_data->keyword_id;
                                if($keyword_id == 0) { //Insert into keywords :: keyword,subcategories_id
        
                                    //Check whether keyword exists in keywords, if not create
                    		        $arr_ins_keywords_master_det = array(
                		                'keyword' => $keywords_data->name,
                		                'profession_id' => 0,
        								'status' => 'Inactive'
                    		        );
                    		        /*echo "<pre>";
                    		        print_r($arr_ins_keywords_master_det);
                    		        echo "</pre>";*/
                    		        
                    		        $keyword_id = $common->insert_records_dynamically('keywords', $arr_ins_keywords_master_det);
                    		        //echo "<br> keyword id ".$keyword_id;
                                }
                                
                                //Insert into post_req_lang table
                                $arr_post_req_keyword = array(
                                        'post_job_id' => $post_job_id,
                                        'keywords_id' => $keyword_id,
                                        'status' => 'Active',
                                    );
                                
                                $post_req_id = $common->insert_records_dynamically('post_req_keyword', $arr_post_req_keyword);
                                
                                /*echo "<pre>";
                		        print_r($arr_ins_keyword_det);
                		        echo "</pre>";*/
                		        //echo '<br> user_keyword_list_id  '.$user_keyword_list_id;
                            }
                        }
                    
                        //Create and save atatchments
                        if(count($attachments) > 0) {
                            foreach($attachments as $attach_key => $arr_file) {
                                foreach($arr_file as $attach_name => $file) {
                                    if ($file != null) {
                                        $image = generateDynamicImage("images/attachments",$file);
                                        
                                        $arr_attach = array(
                                                'booking_id' => $booking_id,
                                                'file_name' => $image,
                                                'file_location' => 'images/attachments',
                                                'created_on' => $json->created_on,
                                                'created_by' => $json->users_id,
                                                'status_id' => 1
                                            );
                                        $common->insert_records_dynamically('attachments', $arr_attach);
                                    }
                                }
                            }
                        }
                        
                        return $this->respond([
            			    "post_job_id" => $post_job_id,
            			    "post_job_ref_id" => str_pad($post_job_id, 6, "0", STR_PAD_LEFT),
            			    "user_plan_id" => $user_plan_id,
            				"status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to create Job Post"
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
	//---------------------------------------------------------User Job Post details-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_user_job_post_details()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/
            
            if(!array_key_exists('users_id',$json) || !array_key_exists('key',$json)) {
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
    		       $misc_model = new MiscModel();
    		       $job_post_model = new JobPostModel();
    		       $common = new CommonModel();
    		        
    		       $users_id = $json->users_id;
    		       
    		       $arr_job_post_bids = array();
    		       
    		       //Get Bids
    		       $arr_bid_details = $job_post_model->get_job_post_bid_details($users_id);
    		       
    		       if($arr_bid_details != 'failure') {
    		           foreach($arr_bid_details as $bid_data) {
    		               if(!array_key_exists($bid_data['post_job_id'],$arr_job_post_bids)) {
    		                   $arr_job_post_bids[$bid_data['post_job_id']]['bids'] = 1;
    		                   $arr_job_post_bids[$bid_data['post_job_id']]['bid_amount'] = $bid_data['amount'];
    		               }
    		               else {
    		                   $arr_job_post_bids[$bid_data['post_job_id']]['bids']++;
    		                   $arr_job_post_bids[$bid_data['post_job_id']]['bid_amount'] += $bid_data['amount'];
    		               }
    		               
    		          }
    		       }
    		       /*echo "<pre>";
    		       print_r($arr_job_post_bids);
    		       echo "</pre>";
    		       exit;*/
    		       //Get Single Move Booking Details
    		       $arr_single_move_booking_details = $job_post_model->get_user_single_move_job_post_details($users_id); 
    		       
    		       $arr_job_post = array();
    		       $arr_job_post_response = array();
    		       $current_date = date('Y-m-d H:i:s');
    		       
    		       if($arr_single_move_booking_details != 'failure') {
    		           foreach($arr_single_move_booking_details as $key => $book_data) {
    		               $status = $book_data['status'];
    		               $total_bids = (array_key_exists($book_data['post_job_id'],$arr_job_post_bids)) ? $arr_job_post_bids[$book_data['post_job_id']]['bids'] : 0;
    		               $total_bids_amount = (array_key_exists($book_data['post_job_id'],$arr_job_post_bids)) ? $arr_job_post_bids[$book_data['post_job_id']]['bid_amount'] : 0;
    		               $average_bids_amount = ($total_bids > 0) ? (string)round(($total_bids_amount/$total_bids),2) : 0;
    		               
    		               $arr_job_post[$key]['booking_id'] = $book_data['booking_id'];
    		               $arr_job_post[$key]['post_job_id'] = $book_data['post_job_id'];
    		               $arr_job_post[$key]['post_job_ref_id'] = str_pad($book_data['post_job_id'], 6, "0", STR_PAD_LEFT);
    		               $arr_job_post[$key]['category_id'] = $book_data['category_id'];
        		           $arr_job_post[$key]['fname'] = $book_data['fname'];
    		               $arr_job_post[$key]['lname'] = $book_data['lname'];
    		               $arr_job_post[$key]['mobile'] = $book_data['mobile'];
    		               $arr_job_post[$key]['scheduled_date'] = $book_data['scheduled_date'];
    		               $arr_job_post[$key]['started_at'] = $book_data['started_at'];
    		               $arr_job_post[$key]['from'] = $book_data['from'];
    		               $arr_job_post[$key]['estimate_time'] = $book_data['estimate_time'];
    		               $arr_job_post[$key]['estimate_type'] = $book_data['estimate_type'];
    		               $arr_job_post[$key]['amount'] = $book_data['amount'];
    		               $arr_job_post[$key]['sp_id'] = $book_data['sp_id'];
    		               $arr_job_post[$key]['profile_pic'] = $book_data['profile_pic'];
    		               $arr_job_post[$key]['title'] = $book_data['title'];
    		               $arr_job_post[$key]['bid_range_name'] = $book_data['bid_range_name'];
    		               $arr_job_post[$key]['range_slots'] = $book_data['range_slots'];
    		               $arr_job_post[$key]['booking_status'] = $status;
    		               $arr_job_post[$key]['bids_period'] = $book_data['bids_period']; //in days, 1,3,7
    		               $arr_job_post[$key]['post_created_on'] = $book_data['created_dts'];
    		               //Calculate bid end date
    		               $arr_job_post[$key]['bid_end_date'] = date('Y-m-d H:i:s', strtotime('+'.$arr_job_post[$key]['bids_period'].' day', strtotime($arr_job_post[$key]['post_created_on'])));
    		               $arr_job_post[$key]['current_date'] = $current_date;
    		               $arr_job_post[$key]['expires_in'] = ($current_date < $arr_job_post[$key]['bid_end_date']) ? $this->calc_days_hrs_mins($arr_job_post[$key]['bid_end_date'],$current_date) : 0;
    		               $arr_job_post[$key]['total_bids'] = $total_bids;
    		               $arr_job_post[$key]['average_bids_amount'] = $average_bids_amount;
    		               
    		               $arr_job_post[$key]['details'][] = array('job_description' => $book_data['job_description'],
		                                                       'locality' => $book_data['locality'],
		                                                       'latitude' => $book_data['latitude'],
		                                                       'longitude' => $book_data['longitude'],
		                                                       'city' => $book_data['city'],
		                                                       'state' => $book_data['state'],
		                                                       'country' => $book_data['country'],
		                                                       'zipcode' => $book_data['zipcode'],
		                                                       );
		               }
    		           
    		           //echo "<pre>";
        		       //print_r($arr_job_post_details);
        		       //print_r($arr_job_post);
        		       //echo "</pre>";
        		       //exit;
        		   }
    		       
    		       $booking_count = (count($arr_job_post) > 0) ?  count($arr_job_post) : 0; //Increment the key
    		       
    		       
    		       //Get Blue Collar Booking Details
    		       $arr_blue_collar_booking_details = $job_post_model->get_user_blue_collar_job_post_details($users_id); 
    		       
    		       if($arr_blue_collar_booking_details != 'failure') {
    		           foreach($arr_blue_collar_booking_details as $bc_book_data) {
    		               $status = $bc_book_data['status'];
    		               $total_bids = (array_key_exists($bc_book_data['post_job_id'],$arr_job_post_bids)) ? $arr_job_post_bids[$bc_book_data['post_job_id']]['bids'] : 0;
    		               $total_bids_amount = (array_key_exists($bc_book_data['post_job_id'],$arr_job_post_bids)) ? $arr_job_post_bids[$bc_book_data['post_job_id']]['bid_amount'] : 0;
    		               $average_bids_amount = ($total_bids > 0) ? (string)round(($total_bids_amount/$total_bids),2) : 0;
    		               
    		               $arr_job_post[$booking_count]['booking_id'] = $bc_book_data['booking_id'];
    		               $arr_job_post[$booking_count]['post_job_id'] = $bc_book_data['post_job_id'];
    		               $arr_job_post[$booking_count]['post_job_ref_id'] = str_pad($bc_book_data['post_job_id'], 6, "0", STR_PAD_LEFT);
        		           $arr_job_post[$booking_count]['category_id'] = $bc_book_data['category_id'];
        		           $arr_job_post[$booking_count]['fname'] = $bc_book_data['fname'];
    		               $arr_job_post[$booking_count]['lname'] = $bc_book_data['lname'];
    		               $arr_job_post[$booking_count]['mobile'] = $bc_book_data['mobile'];
    		               $arr_job_post[$booking_count]['scheduled_date'] = $bc_book_data['scheduled_date'];
    		               $arr_job_post[$booking_count]['started_at'] = $bc_book_data['started_at'];
    		               $arr_job_post[$booking_count]['from'] = $bc_book_data['from'];
    		               $arr_job_post[$booking_count]['estimate_time'] = $bc_book_data['estimate_time'];
    		               $arr_job_post[$booking_count]['estimate_type'] = $bc_book_data['estimate_type'];
    		               $arr_job_post[$booking_count]['amount'] = $bc_book_data['amount'];
    		               $arr_job_post[$booking_count]['sp_id'] = $bc_book_data['sp_id'];
    		               $arr_job_post[$booking_count]['profile_pic'] = $bc_book_data['profile_pic'];
    		               $arr_job_post[$booking_count]['title'] = $bc_book_data['title'];
    		               $arr_job_post[$booking_count]['bid_range_name'] = $bc_book_data['bid_range_name'];
    		               $arr_job_post[$booking_count]['range_slots'] = $bc_book_data['range_slots'];
    		               $arr_job_post[$booking_count]['booking_status'] = $status;
    		               $arr_job_post[$booking_count]['bids_period'] = $bc_book_data['bids_period']; //in days, 1,3,7
    		               $arr_job_post[$booking_count]['post_created_on'] = $bc_book_data['created_dts'];
    		               //Calculate bid end date
    		               $arr_job_post[$booking_count]['bid_end_date'] = date('Y-m-d H:i:s', strtotime('+'.$arr_job_post[$booking_count]['bids_period'].' day', strtotime($arr_job_post[$booking_count]['post_created_on'])));
    		               $arr_job_post[$booking_count]['current_date'] = $current_date;
    		               $arr_job_post[$booking_count]['expires_in'] = ($current_date < $arr_job_post[$booking_count]['bid_end_date']) ? $this->calc_days_hrs_mins($arr_job_post[$booking_count]['bid_end_date'],$current_date) : 0;
    		               $arr_job_post[$booking_count]['total_bids'] = $total_bids;
    		               $arr_job_post[$booking_count]['average_bids_amount'] = $average_bids_amount;
    		               
    		               $arr_job_post[$booking_count]['details'][] = array('job_description' => $bc_book_data['job_description']);
    		               
    		               $booking_count++;
    		           }
        		   }
        		   
        		   $booking_count = (count($arr_job_post) > 0) ?  count($arr_job_post) : 0; //Increment the key
    		       
    		       //Get Multi Move Booking Details
    		       $arr_multi_move_booking_details = $job_post_model->get_user_multi_move_job_post_details($users_id); 
    		       
    		       $arr_exists = array();
    		       $arr_details = array();
    		       
    		       if($arr_multi_move_booking_details != 'failure') {
    		           foreach($arr_multi_move_booking_details as $mm_book_data) {
    		               $arr_details[$mm_book_data['id']][] = array('sequence_no' => $mm_book_data['sequence_no'],
		                                                       'job_description' => $mm_book_data['job_description'], 
		                                                       'weight_type' => $mm_book_data['weight_type'], 
		                                                       'locality' => $mm_book_data['locality'],
		                                                       'latitude' => $mm_book_data['latitude'],
		                                                       'longitude' => $mm_book_data['longitude'],
		                                                       'city' => $mm_book_data['city'],
		                                                       'state' => $mm_book_data['state'],
		                                                       'country' => $mm_book_data['country'],
		                                                       'zipcode' => $mm_book_data['zipcode'],
		                                                       );
    		           }
    		           foreach($arr_multi_move_booking_details as $mm_book_data) {
    		               if(!array_key_exists($mm_book_data['id'],$arr_exists)) {
    		                   $status = $mm_book_data['status'];
        		               $total_bids = (array_key_exists($mm_book_data['post_job_id'],$arr_job_post_bids)) ? $arr_job_post_bids[$mm_book_data['post_job_id']]['bids'] : 0;
        		               $total_bids_amount = (array_key_exists($mm_book_data['post_job_id'],$arr_job_post_bids)) ? $arr_job_post_bids[$mm_book_data['post_job_id']]['bid_amount'] : 0;
        		               $average_bids_amount = ($total_bids > 0) ? (string)round(($total_bids_amount/$total_bids),2) : 0;
        		               
        		               $arr_job_post[$booking_count]['booking_id'] = $mm_book_data['booking_id'];
        		               $arr_job_post[$booking_count]['post_job_id'] = $mm_book_data['post_job_id'];
        		               $arr_job_post[$booking_count]['post_job_ref_id'] = str_pad($mm_book_data['post_job_id'], 6, "0", STR_PAD_LEFT);
    		                   $arr_job_post[$booking_count]['category_id'] = $mm_book_data['category_id'];
            		           $arr_job_post[$booking_count]['fname'] = $mm_book_data['fname'];
        		               $arr_job_post[$booking_count]['lname'] = $mm_book_data['lname'];
        		               $arr_job_post[$booking_count]['mobile'] = $mm_book_data['mobile'];
        		               $arr_job_post[$booking_count]['scheduled_date'] = $mm_book_data['scheduled_date'];
        		               $arr_job_post[$booking_count]['started_at'] = $mm_book_data['started_at'];
        		               $arr_job_post[$booking_count]['from'] = $mm_book_data['from'];
        		               $arr_job_post[$booking_count]['estimate_time'] = $mm_book_data['estimate_time'];
        		               $arr_job_post[$booking_count]['estimate_type'] = $mm_book_data['estimate_type'];
        		               $arr_job_post[$booking_count]['amount'] = $mm_book_data['amount'];
        		               $arr_job_post[$booking_count]['sp_id'] = $mm_book_data['sp_id'];
        		               $arr_job_post[$booking_count]['profile_pic'] = $mm_book_data['profile_pic'];
        		               $arr_job_post[$booking_count]['title'] = $mm_book_data['title'];
        		               $arr_job_post[$booking_count]['bid_range_name'] = $mm_book_data['bid_range_name'];
        		               $arr_job_post[$booking_count]['range_slots'] = $mm_book_data['range_slots'];
        		               $arr_job_post[$booking_count]['booking_status'] = $status;
        		               $arr_job_post[$booking_count]['bids_period'] = $mm_book_data['bids_period']; //in days, 1,3,7
        		               $arr_job_post[$booking_count]['post_created_on'] = $mm_book_data['created_dts'];
        		               //Calculate bid end date
        		               $arr_job_post[$booking_count]['bid_end_date'] = date('Y-m-d H:i:s', strtotime('+'.$arr_job_post[$booking_count]['bids_period'].' day', strtotime($arr_job_post[$booking_count]['post_created_on'])));
        		               $arr_job_post[$booking_count]['current_date'] = $current_date;
        		               $arr_job_post[$booking_count]['expires_in'] = ($current_date < $arr_job_post[$booking_count]['bid_end_date']) ? $this->calc_days_hrs_mins($arr_job_post[$booking_count]['bid_end_date'],$current_date) : 0;
        		               $arr_job_post[$booking_count]['total_bids'] = $total_bids;
        		               $arr_job_post[$booking_count]['average_bids_amount'] = $average_bids_amount;
        		               
        		               foreach($arr_details[$mm_book_data['id']] as $key => $val) {
        		                   $arr_job_post[$booking_count]['details'][$key] = $arr_details[$mm_book_data['id']][$key];
        		               }
        		               
        		               $arr_exists[$mm_book_data['id']] = $mm_book_data['id'];
        		               
        		               $booking_count++;
    		               }
    		           }
        		   }
        		   
        		   //echo "<pre>";
        		   //print_r($arr_job_post_details);
        		   //print_r($arr_job_post);
        		   //echo "</pre>";
        		   //exit;
        		   if(count($arr_job_post) > 0) {
        		       return $this->respond([
        		            "job_post_details" => $arr_job_post,
        		            "status" => 200,
            				"message" => "Success",
            			]);
        		   }
    		       else {
            		    return $this->respond([
            		        "status" => 404,
        					"message" => "No Bookings"
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
	//---------------------------------------------------------Job Post details-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_job_post_details()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/
            
            if(!array_key_exists('booking_id',$json) || !array_key_exists('category_id',$json) || !array_key_exists('post_job_id',$json) 
                || !array_key_exists('users_id',$json) || !array_key_exists('key',$json)) {
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
    		       $misc_model = new MiscModel();
    		       $job_post_model = new JobPostModel();
    		       $common = new CommonModel();
    		       
    		       $category_id = $json->category_id;
    		       $booking_id = $json->booking_id;
    		       $post_job_id = $json->post_job_id;
    		       $users_id = $json->users_id;
    		       $arr_keywords = array();
    		       $arr_lang = array();
    		       
    		       //Get Keywords
    		       $arr_post_keyword_details = $job_post_model->get_job_post_keywords($post_job_id);
    		       if($arr_post_keyword_details != 'failure') {
    		           foreach($arr_post_keyword_details as $keywords) {
    		               $arr_keywords[] = $keywords['keyword'];
    		           }
    		       }
    		       
    		       //Get Language
    		       $arr_post_lang_details = $job_post_model->get_job_post_language($post_job_id);
    		       if($arr_post_lang_details != 'failure') {
    		           foreach($arr_post_lang_details as $language) {
    		               $arr_language[] = $language['name'];
    		           }
    		       }
    		       
    		       $arr_job_post_bids = array();
    		       
    		       //Get Bids
    		       $arr_bid_details = $job_post_model->get_job_post_bid_details($users_id,$post_job_id);
    		       
    		       if($arr_bid_details != 'failure') {
    		           foreach($arr_bid_details as $bid_data) {
    		               if(!array_key_exists($bid_data['post_job_id'],$arr_job_post_bids)) {
    		                   $arr_job_post_bids[$bid_data['post_job_id']]['bids'] = 1;
    		                   $arr_job_post_bids[$bid_data['post_job_id']]['bid_amount'] = $bid_data['amount'];
    		               }
    		               else {
    		                   $arr_job_post_bids[$bid_data['post_job_id']]['bids']++;
    		                   $arr_job_post_bids[$bid_data['post_job_id']]['bid_amount'] += $bid_data['amount'];
    		               }
    		          }
    		       }
    		       
    		       //Get Booking Details
    		       $arr_booking_details = $job_post_model->get_job_post_details($booking_id,$post_job_id,$users_id); 
    		       
    		       $arr_response = array();
    		       $arr_booking = array();
    		       $current_date = date('Y-m-d H:i:s');
    		       
    		       if($arr_booking_details != 'failure') {
    		           $status = $arr_booking_details['status'];
		               $total_bids = (array_key_exists($arr_booking_details['post_job_id'],$arr_job_post_bids)) ? $arr_job_post_bids[$arr_booking_details['post_job_id']]['bids'] : 0;
		               $total_bids_amount = (array_key_exists($arr_booking_details['post_job_id'],$arr_job_post_bids)) ? $arr_job_post_bids[$arr_booking_details['post_job_id']]['bid_amount'] : 0;
		               $average_bids_amount = ($total_bids > 0) ? (string)round(($total_bids_amount/$total_bids),2) : 0;
    		           
    		           $arr_booking['booking_id'] = $booking_id;
    		           $arr_booking['post_job_id'] = $arr_booking_details['post_job_id'];
        		       $arr_booking['post_job_ref_id'] = str_pad($arr_booking_details['post_job_id'], 6, "0", STR_PAD_LEFT);
    		           $arr_booking['fname'] = $arr_booking_details['fname'];
		               $arr_booking['lname'] = $arr_booking_details['lname'];
		               $arr_booking['mobile'] = $arr_booking_details['mobile'];
		               $arr_booking['scheduled_date'] = $arr_booking_details['scheduled_date'];
		               $arr_booking['started_at'] = $arr_booking_details['started_at'];
		               $arr_booking['from'] = $arr_booking_details['from'];
		               $arr_booking['estimate_time'] = $arr_booking_details['estimate_time'];
		               $arr_booking['estimate_type'] = $arr_booking_details['estimate_type'];
		               $arr_booking['amount'] = $arr_booking_details['amount'];
		               $arr_booking['title'] = $arr_booking_details['title'];
		               $arr_booking['bid_range_name'] = $arr_booking_details['bid_range_name'];
		               $arr_booking['range_slots'] = $arr_booking_details['range_slots'];
		               $arr_booking['booking_status'] = $arr_booking_details['status'];
		               $arr_booking['bids_period'] = $arr_booking_details['bids_period']; 
		               $arr_booking['bid_per'] = $arr_booking_details['bid_per']; //in days, 1,3,7
		               $arr_booking['post_created_on'] = $arr_booking_details['created_dts'];
		               $arr_booking['sp_id'] = $arr_booking_details['sp_id'];
		               $arr_booking['fcm_token'] = $arr_booking_details['fcm_token'];
		               $arr_booking['post_created_on'] = $arr_booking_details['created_dts'];
		               //Calculate bid end date
		               $arr_booking['bid_end_date'] = date('Y-m-d H:i:s', strtotime('+'.$arr_booking['bids_period'].' day', strtotime($arr_booking['post_created_on'])));
		               $arr_booking['current_date'] = $current_date;
		               $arr_booking['expires_in'] = ($current_date < $arr_booking['bid_end_date']) ? $this->calc_days_hrs_mins($arr_booking['bid_end_date'],$current_date) : 0;;
		               $arr_booking['total_bids'] = $total_bids;
		               $arr_booking['average_bids_amount'] = $average_bids_amount;
		               
		               $attachment_count = $arr_booking_details['attachment_count'];
		               
		               $arr_attachments = array();
		               $arr_job_details = array();
		               
		               if($attachment_count > 0) {
		                   $arr_attachment_details = $misc_model->get_attachment_details($booking_id);
		                   if($arr_attachment_details != 'failure') {
		                       foreach($arr_attachment_details as $attach_data) {
		                           $arr_attachments[] = array('id' => $attach_data['id'],'file_name' => $attach_data['file_name'],'file_location' => $attach_data['file_location']);
		                       }
		                   }     
		               }
		               
    		           if($category_id == 1) { // Single Move 
        		            $arr_single_move_details = $misc_model->get_single_move_details($booking_id); 
        		            if($arr_single_move_details != 'failure') {
		                       foreach($arr_single_move_details as $single_move_data) {
		                           $arr_job_details[] = array(
		                                                       'id' => $single_move_data['id'],
		                                                       'address_id' => $single_move_data['address_id'],
		                                                       'job_description' => $single_move_data['job_description'],
		                                                       'locality' => $single_move_data['locality'],
		                                                       'latitude' => $single_move_data['latitude'],
		                                                       'longitude' => $single_move_data['longitude'],
		                                                       'city' => $single_move_data['city'],
		                                                       'state' => $single_move_data['state'],
		                                                       'country' => $single_move_data['country'],
		                                                       'zipcode' => $single_move_data['zipcode'],
		                                                       );
		                       }
		                   }  
        		       }
        		       if($category_id == 2) { // Blue Collar 
        		            $arr_blue_collar_details = $misc_model->get_blue_collar_details($booking_id); 
        		            if($arr_blue_collar_details != 'failure') {
		                       foreach($arr_blue_collar_details as $blue_collar_data) {
		                           $arr_job_details[] = array('job_description' => $blue_collar_data['job_description']);
		                       }
		                   }  
        		       }
        		       if($category_id == 3) { // Multi move
        		            $arr_multi_move_details = $misc_model->get_multi_move_details($booking_id); 
        		            if($arr_multi_move_details != 'failure') {
		                       foreach($arr_multi_move_details as $multi_move_data) {
		                           $arr_job_details[] = array('id' => $multi_move_data['id'],
		                                                        'address_id' => $multi_move_data['address_id'],
		                                                        'sequence_no' => $multi_move_data['sequence_no'],
		                                                       'job_description' => $multi_move_data['job_description'], 
		                                                       'weight_type' => $multi_move_data['weight_type'], 
		                                                       'locality' => $multi_move_data['locality'],
		                                                       'latitude' => $multi_move_data['latitude'],
		                                                       'longitude' => $multi_move_data['longitude'],
		                                                       'city' => $multi_move_data['city'],
		                                                       'state' => $multi_move_data['state'],
		                                                       'country' => $multi_move_data['country'],
		                                                       'zipcode' => $multi_move_data['zipcode'],
		                                                       );
		                       }
		                   }  
        		       }
        		       
        		       //array_push($arr_response,array("attachments" => $arr_attachments,"job_details" => $arr_job_details));
        		       
        		       //echo "<pre>";
        		       //print_r($arr_booking_details);
        		       //print_r($arr_response);
        		       //echo "</pre>";
        		       //exit;
        		       
        		       return $this->respond([
        		            "job_post_details" => $arr_booking,
        		            "attachments" => $arr_attachments,
        		            "job_details" => $arr_job_details,
        		            "keywords" => $arr_keywords,
        		            "languages" => $arr_language,
            			    "status" => 200,
            				"message" => "Success",
            			]);
    		       }
    		       else {
            		    return $this->respond([
            		        "booking_id" => $booking_id,
        					"status" => 404,
        					"message" => "Invalid Job Post"
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
	//---------------------------------------------------------Job Post Bids-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_job_post_bids_list()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/
            
            if(!array_key_exists('post_job_id',$json) || !array_key_exists('key',$json)) {
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
    		       $job_post_model = new JobPostModel();
    		       
    		       $post_job_id = $json->post_job_id;
    		       
    		       $arr_bid_list = array();
    		       $arr_sp_jobs_completed = array();
    		       $job_title = "";
    		       
    		       //Get completed jobs count
    		       $arr_jobs_completed = $job_post_model->get_sp_jobs_completed_count_by_jobpost_id($post_job_id);
    		       /*echo "<pre>";
    		       print_r($arr_jobs_completed);
    		       echo "</pre>";
    		       exit;*/
    		       if($arr_jobs_completed != 'failure') {
    		           foreach($arr_jobs_completed as $jobs_data) {
    		               $arr_sp_jobs_completed[$jobs_data['users_id']] = $jobs_data['jobs_completed']; 
    		               $job_title = $jobs_data['title']; 
    		           }     
    		       }
    		       
    		       //Get Bids
    		       $arr_bid_details = $job_post_model->get_job_post_bid_details_by_jobpost_id($post_job_id);
    		       
    		       if($arr_bid_details != 'failure') {
    		           foreach($arr_bid_details as $bid_data) {
    		                $arr_bid_list[] = array('bid_id' => $bid_data['id'],
    		                                        'bid_type' => $bid_data['bid_type'],
                                                    'sp_id' => $bid_data['users_id'],
                                                   'sp_fname' => $bid_data['fname'],
                                                   'sp_lname' => $bid_data['lname'],
                                                   'sp_mobile' => $bid_data['mobile'],
                                                   'sp_profile' => $bid_data['profile_pic'],
                                                   'sp_fcm_token' => $bid_data['fcm_token'],
                                                   'amount' => $bid_data['amount'],
                                                   'esimate_time' => $bid_data['esimate_time'],
                                                   'estimate_type' => $bid_data['name'],
                                                   'proposal'  => $bid_data['proposal'],
                                                   'about_me'  => $bid_data['about_me'],
                                                   'job_title'  => $job_title,
                                                   'jobs_completed' => (array_key_exists($bid_data['users_id'],$arr_sp_jobs_completed)) ? $arr_sp_jobs_completed[$bid_data['users_id']] : 0,
                                                   );
                      }
    		          return $this->respond([
        		            "bid_details" => $arr_bid_list,
        		            "status" => 200,
            				"message" => "Success",
            			]);
    		       }
    		       else {
            		    return $this->respond([
            		        "booking_id" => $booking_id,
        					"status" => 404,
        					"message" => "No Bids found"
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
	//---------------------------------------------------------Job Post Bid Details-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_job_post_bid_details()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/
            
            if(!array_key_exists('bid_id',$json) || !array_key_exists('sp_id',$json) || !array_key_exists('key',$json)) {
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
    		       $job_post_model = new JobPostModel();
    		       $misc_model = new MiscModel();
    		       
    		       $bid_id = $json->bid_id;
    		       $sp_id = $json->sp_id;
    		       
    		       $arr_bid_details = array();
    		       $arr_attachments = array();
    		       
    		       //Get Jobs completed count
    		       $arr_jobs_completed = $job_post_model->get_sp_jobs_completed_count($sp_id);
    		       
    		       //Get Bid details
    		       $arr_bid_list = $job_post_model->get_bid_details($bid_id,$sp_id);
    		       
    		       if($arr_bid_list != 'failure') {
    		           foreach($arr_bid_list as $bid_data) {
    		               $arr_bid_details = array('bid_id' => $bid_data['id'],
                                                   'sp_id' => $bid_data['users_id'],
                                                   'sp_fname' => $bid_data['fname'],
                                                   'sp_lname' => $bid_data['lname'],
                                                   'sp_mobile' => $bid_data['mobile'],
                                                   'sp_profile' => $bid_data['profile_pic'],
                                                   'sp_gender' => $bid_data['gender'],
                                                   'about_me' => $bid_data['about_me'],
                                                   'qualification' => $bid_data['qualification'],
                                                   'profession' => $bid_data['profession'],
                                                   'exp' => $bid_data['exp'],
                                                   'sp_fcm_token' => $bid_data['fcm_token'],
                                                   'amount' => $bid_data['amount'],
                                                   'esimate_time' => $bid_data['esimate_time'],
                                                   'estimate_type' => $bid_data['name'],
                                                   'proposal'  => $bid_data['proposal'],
                                                   'attachment_count' => $bid_data['attachment_count'],
                                                   'jobs_completed' => ($arr_jobs_completed != 'failure') ? $arr_jobs_completed : 0,
                                                   'job_title'  => $bid_data['title'],
                                                   );
                            
    		               if($bid_data['attachment_count'] > 0) {
    		                   $arr_attachment_details = $job_post_model->get_bid_attachment_details($bid_id);
    		                   if($arr_attachment_details != 'failure') {
    		                       foreach($arr_attachment_details as $attach_data) {
    		                           $arr_attachments[] = array('bid_attach_id' => $attach_data['id'],'file_name' => $attach_data['file_name'],'file_location' => $attach_data['file_location']);
    		                       }
    		                   }     
    		               } 
    		               
    		               //Get Skills details
    		               $arr_skills_details = $misc_model->get_sp_skills($sp_id);
    		               //Get Language details
    		               $arr_language_details = $misc_model->get_sp_lang($sp_id);
    		               
    		          }
    		          return $this->respond([
        		            "bid_details" => $arr_bid_details,
        		            "attachments" => $arr_attachments,
        		            "skills" => ($arr_skills_details != 'failure') ? $arr_skills_details : array(),
        		            "language" => ($arr_language_details != 'failure') ? $arr_language_details : array(),
        		            "status" => 200,
            				"message" => "Success",
            			]);
    		       }
    		       else {
            		    return $this->respond([
            		        "booking_id" => $booking_id,
        					"status" => 404,
        					"message" => "No Bids found"
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
	
	public function calc_days_hrs_mins($start_date,$end_date) {
	   $start = new \DateTime($end_date);
       $end = new \DateTime($start_date);
       $diff = $end->diff($start);
        
       $daysInSecs = $diff->format('%r%a') * 24 * 60 * 60;
       $hoursInSecs = $diff->h * 60 * 60;
       $minsInSecs = $diff->i * 60;
       
       $seconds = $daysInSecs + $hoursInSecs + $minsInSecs + $diff->s;
       
       $dtF = new \DateTime('@0');
       $dtT = new \DateTime("@$seconds");
       return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes'); // and %s seconds
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------Job Post Installments-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function job_post_installments()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/
            
            if(!array_key_exists('post_job_id',$json) || !array_key_exists('booking_id',$json)  || !array_key_exists('data',$json) || !array_key_exists('key',$json)
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
    		        
    		        $arr_data = $json->data;
    		        /*echo "<pre>";
    		        print_r($arr_data);
    		        echo "</pre>";
    		        exit;*/
    		        $total_rows = 0;
    		        
    		        if(count($arr_data) > 0) {
    		            foreach($arr_data as $data_val) {
    		                $arr_job_post_inst = array(
                		        'inst_no' => $data_val->inst_no,
                                'amount' => $data_val->amount,
                                'post_job_id' => $json->post_job_id,
                                'booking_id' => $json->booking_id,
                                'goal_id' => $data_val->goal_id,
                            );
                            $installment_det_id = $common->insert_records_dynamically('installment_det', $arr_job_post_inst);
                            if ($installment_det_id > 0) {
                                $total_rows++;
                            }    
    		            }
    		        }
    		        
    		        if (count($arr_data) == $total_rows) {
                        return $this->respond([
            			    "status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to create Job Post Installment"
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
	//---------------------------------------------------------Installment Payments-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function job_post_installments_payments()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/
            
            if(!array_key_exists('booking_id',$json) || !array_key_exists('bid_id',$json) || !array_key_exists('sp_id',$json)
                || !array_key_exists('date',$json) || !array_key_exists('amount',$json) 
                || !array_key_exists('reference_id',$json) || !array_key_exists('payment_status',$json) 
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
    		        
    		        //Insert into Transaction table
    		        $arr_transaction = array(
        		          'name_id' => 12, //Installment Payment
                          'date' => $json->date,
                          'amount' => $json->amount,
                          'type_id' => 1, //Receipt/Credit
                          'users_id' => $json->users_id,
                          'method_id' => 1, //Online Payment
                          'reference_id' => $json->reference_id,
                          'booking_id' => $json->booking_id,
                          'payment_status' => $json->payment_status, //'Success', 'Failure'
                    );
                    $transaction_id = $common->insert_records_dynamically('transaction', $arr_transaction);
                    
                    if($transaction_id > 0) { 
                        if($json->payment_status == 'Success') {
                            $arr_booking_payments_ins = array(
                		          'booking_id' => $json->booking_id,
                                  'transaction_id' => $transaction_id, 
                            );
                            //Insert into booking_receipts
                            $common->insert_records_dynamically('booking_receipts', $arr_booking_payments_ins);
                            
                            $arr_inst = array(
                		          'transaction_id' => $transaction_id, 
                		          'inst_paid_status' => "Paid",
                            );
                            //Update installment_det
                            $common->update_records_dynamically('installment_det', $arr_inst, 'booking_id', $json->booking_id);
                            
                            //Awarded => making booking status as Pending
                            $upd_booking_status = [
                                "sp_id" =>  $json->sp_id,
                                "status_id" =>  9,
                            ];
                            $common->update_records_dynamically('booking', $upd_booking_status, 'id', $json->booking_id);
                            
                            //Insert into booking status
                            $arr_booking_status = array(
                		        'booking_id' => $json->booking_id,
                                'status_id' => 32, //Installment Added
                                'created_on' => date('Y-m-d H:i:s')
                            );
                            $common->insert_records_dynamically('booking_status', $arr_booking_status);
                            
                            //update status are awarded in  post_job table
                            $upd_post_job_status = [
                                "status_id" =>  27, //Awarded
                            ];
                            $common->update_records_dynamically('post_job', $upd_post_job_status, 'booking_id', $json->booking_id);
                            
                            //Mark the bid as deal sealed
                            $upd_bid_det_status = [
                                "bid_type" =>  1, //Sealed
                            ];
                            $common->update_records_dynamically('bid_det', $upd_bid_det_status, 'id', $json->bid_id);
                        }    
                        
        		        return $this->respond([
            			    "transaction_id" => $transaction_id,
            				"status" => 200,
            				"message" => "Success",
            			]);
                    }
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to create Payment"
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
	//--------------------------------------------------UPDATE Job Post Award/Reject Status STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------
    public function update_post_job_status()
    {

        $json = $this->request->getJSON();
        if(!array_key_exists('booking_id',$json) || !array_key_exists('post_job_id',$json) || !array_key_exists('bid_id',$json) 
        || !array_key_exists('status_id',$json) || !array_key_exists('key',$json)) {
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
            $post_job_id = $json->post_job_id;
            $status_id = $json->status_id;
            $booking_id = $json->booking_id;
            $sp_name = $json->sp_name;
            $job_title = $json->job_title;
            
            if($status_id == 29) {
                //Insert into alert_details table
		        $arr_alerts = array(
    		          'alert_id' => 2, 
                      'description' => "You have rejected bid of $sp_name for post $job_title.",
                      'action' => 1,
                      'created_on' => date("Y-m-d H:i:s"), 
                      'status' => 1,
                      'users_id' => $users_id,
                );
                $common->insert_records_dynamically('alert_details', $arr_alerts);
                
                //Mark the bid as Rejected
                $upd_bid_det_status = [
                    "bid_type" =>  2, //Rejected
                ];
                $common->update_records_dynamically('bid_det', $upd_bid_det_status, 'id', $json->bid_id);
            }
            
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
//--------------------------------------------------FUNCTION ENDS------------------------------------------------------------
//---------------------------------------------------------Single move job post update-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function update_single_move_job_post()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/
            
            if(!array_key_exists('booking_id',$json) || !array_key_exists('post_job_id',$json) || !array_key_exists('scheduled_date',$json) 
                || !array_key_exists('time_slot_from',$json)  || !array_key_exists('job_description',$json) 
                || !array_key_exists('bids_period',$json) || !array_key_exists('bid_per',$json) || !array_key_exists('bid_range_id',$json) 
                || !array_key_exists('address_id',$json) || !array_key_exists('title',$json) || !array_key_exists('lang_responses',$json)
                || !array_key_exists('bid_range_id',$json) || !array_key_exists('keywords_responses',$json) || !array_key_exists('created_on',$json)
                || !array_key_exists('attachments',$json) || !array_key_exists('estimate_time',$json) || !array_key_exists('estimate_type_id',$json)
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
    		        $attachments = $json->attachments;
    		        
    		        $common = new CommonModel();
    		        
    		        $arr_time_slot_details = $common->get_details_dynamically('time_slot', 'from', $json->time_slot_from);
    		        if($arr_time_slot_details != 'failure') {
    		            $time_slot_id = $arr_time_slot_details[0]['id'];
    		        }
    		        else {
    		            $arr_time_slot = array(
            		        'from' => $json->time_slot_from
                        );
                        $time_slot_id = $common->insert_records_dynamically('time_slot', $arr_time_slot);
    		        }
    		        
    		        $arr_job_post = array(
        		        'scheduled_date' => $json->scheduled_date,
                        'time_slot_id' => $time_slot_id,
                        'attachment_count' => count($attachments),
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                    );
                    $common->update_records_dynamically('booking', $arr_job_post, 'id', $json->booking_id);
                    
                    if ($json->booking_id > 0) {
                        
                        $address_id = $json->address_id;
                        
                        //Update Single move table
                        $arr_single_move = array(
                                'address_id' => $address_id,
                                'job_description' => $json->job_description,
                            );
                        /*echo "<pre>";
                        print_r($arr_single_move);
                        echo "</pre>";    */
                        
                        $common->update_records_dynamically('single_move', $arr_single_move, 'booking_id', $json->booking_id);
                        
                        //Update post_job table
                        $arr_post_job = array(
                                'bids_period' => $json->bids_period,
                                'title' => $json->title,
                                'bid_per' => $json->bid_per,
                                'bid_range_id' => $json->bid_range_id,
                            );
                        
                        $common->update_records_dynamically('post_job', $arr_post_job, 'id', $json->post_job_id);
                        
                        if($json->post_job_id > 0) {
                        
                            //******************Languages
                        
                            $common->delete_records_dynamically('post_req_lang', 'post_job_id', $json->post_job_id);
                            
                            foreach($json->lang_responses as $lang_key => $lang_data) {
                                $lang_id = $lang_data->lang_id;
                                if($lang_id == 0) { //Insert into user_lang_list ::	language_id	users_id
                                    //Check whether language exists in language, if not create
                    		        $arr_ins_lang_master_det = array(
                		                'name' => $lang_data->name
                    		        );
                    		        /*echo "<pre>";
                    		        print_r($arr_ins_lang_master_det);
                    		        echo "</pre>";*/
                    		        
                    		        $lang_id = $common->insert_records_dynamically('language', $arr_ins_lang_master_det);
                                }
                                
                                //Insert into post_req_lang table
                                $arr_post_req_lang = array(
                                        'post_job_id' => $json->post_job_id,
                                        'language_id' => $lang_id,
                                        'status' => 'Active',
                                    );
                                
                                $post_req_id = $common->insert_records_dynamically('post_req_lang', $arr_post_req_lang);
                            }
                            //*******************Keywords
                            
                            $common->delete_records_dynamically('post_req_keyword', 'post_job_id', $json->post_job_id);
                            
                            foreach($json->keywords_responses as $keywords_key => $keywords_data) {
                                $keyword_id = $keywords_data->keyword_id;
                                if($keyword_id == 0) { //Insert into keywords :: keyword,subcategories_id
        
                                    //Check whether keyword exists in keywords, if not create
                    		        $arr_ins_keywords_master_det = array(
                		                'keyword' => $keywords_data->name,
                		                'profession_id' => 0,
        								'status' => 'Inactive'
                    		        );
                    		        /*echo "<pre>";
                    		        print_r($arr_ins_keywords_master_det);
                    		        echo "</pre>";*/
                    		        
                    		        $keyword_id = $common->insert_records_dynamically('keywords', $arr_ins_keywords_master_det);
                    		        //echo "<br> keyword id ".$keyword_id;
                                }
                                
                                //Insert into post_req_lang table
                                $arr_post_req_keyword = array(
                                        'post_job_id' => $json->post_job_id,
                                        'keywords_id' => $keyword_id,
                                        'status' => 'Active',
                                    );
                                
                                $post_req_id = $common->insert_records_dynamically('post_req_keyword', $arr_post_req_keyword);
                                
                                /*echo "<pre>";
                		        print_r($arr_ins_keyword_det);
                		        echo "</pre>";*/
                		        //echo '<br> user_keyword_list_id  '.$user_keyword_list_id;
                            }
                        }
                        //Create and save atatchments
                        if(count($attachments) > 0) {
                            foreach($attachments as $attach_key => $arr_file) {
                                foreach($arr_file as $attach_name => $file) {
                                    if ($file != null) {
                                        $image = generateDynamicImage("images/attachments",$file);
                                        
                                        $arr_attach = array(
                                                'booking_id' => $json->booking_id,
                                                'file_name' => $image,
                                                'file_location' => 'images/attachments',
                                                'created_on' => $json->created_on,
                                                'created_by' => $json->users_id,
                                                'status_id' => 1
                                            );
                                        $common->insert_records_dynamically('attachments', $arr_attach);
                                    }
                                }
                            }
                        }
                        
            			return $this->respond([
            			    "post_job_id" => $json->post_job_id,
            			    "status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
            		        "status" => 404,
        					"message" => "Failed to update Job Post"
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
	//---------------------------------------------------------Update Blue Collar Job Post-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function update_blue_collar_job_post()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/
            
            if(!array_key_exists('booking_id',$json) || !array_key_exists('post_job_id',$json) || !array_key_exists('time_slot_from',$json)  || !array_key_exists('job_description',$json) 
                || !array_key_exists('bids_period',$json) || !array_key_exists('bid_per',$json) || !array_key_exists('bid_range_id',$json) 
                || !array_key_exists('title',$json) || !array_key_exists('lang_responses',$json)
                || !array_key_exists('bid_range_id',$json) || !array_key_exists('keywords_responses',$json) || !array_key_exists('created_on',$json)
                || !array_key_exists('attachments',$json) || !array_key_exists('estimate_time',$json) || !array_key_exists('estimate_type_id',$json)
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
    		        $booking_id = $json->booking_id;
    		        $post_job_id = $json->post_job_id;
    		        
    		        $attachments = $json->attachments;
    		        
    		        $common = new CommonModel();
    		        //Get master time slot
                    $arr_time_slot_details = $common->get_details_dynamically('time_slot', 'from', $json->time_slot_from);
    		        if($arr_time_slot_details != 'failure') {
    		            $time_slot_id = $arr_time_slot_details[0]['id'];
    		        }
    		        else {
    		            $arr_time_slot = array(
            		        'from' => $json->time_slot_from
                        );
                        $time_slot_id = $common->insert_records_dynamically('time_slot', $arr_time_slot);
    		        }
    		        
    		        $arr_job_post = array(
        		        'scheduled_date' => $json->scheduled_date,
                        'time_slot_id' => $time_slot_id,
                        'attachment_count' => count($attachments),
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                    );
                    $common->update_records_dynamically('booking', $arr_job_post, 'id', $booking_id);
    		        
    		        if ($booking_id > 0) {
                        
                        //Insert into blue_collar table
                        $arr_blue_collar = array(
                                'job_description' => $json->job_description,
                            );
                        /*echo "<pre>";
                        print_r($arr_blue_collar);
                        echo "</pre>";    */
                        
                        $common->update_records_dynamically('blue_collar', $arr_blue_collar, 'booking_id', $booking_id);
                        
                        //Update post_job table
                        $arr_post_job = array(
                                'bids_period' => $json->bids_period,
                                'title' => $json->title,
                                'bid_per' => $json->bid_per,
                                'bid_range_id' => $json->bid_range_id,
                            );
                        
                        $common->update_records_dynamically('post_job', $arr_post_job, 'id', $post_job_id);
                        
                        if($post_job_id > 0) {
                        
                            //******************Languages
                            $common->delete_records_dynamically('post_req_lang', 'post_job_id', $post_job_id);
                            
                            foreach($json->lang_responses as $lang_key => $lang_data) {
                                $lang_id = $lang_data->lang_id;
                                if($lang_id == 0) { //Insert into user_lang_list ::	language_id	users_id
                                    //Check whether language exists in language, if not create
                    		        $arr_ins_lang_master_det = array(
                		                'name' => $lang_data->name
                    		        );
                    		        /*echo "<pre>";
                    		        print_r($arr_ins_lang_master_det);
                    		        echo "</pre>";*/
                    		        
                    		        $lang_id = $common->insert_records_dynamically('language', $arr_ins_lang_master_det);
                                }
                                
                                //Insert into post_req_lang table
                                $arr_post_req_lang = array(
                                        'post_job_id' => $post_job_id,
                                        'language_id' => $lang_id,
                                        'status' => 'Active',
                                    );
                                
                                $post_req_id = $common->insert_records_dynamically('post_req_lang', $arr_post_req_lang);
                            }
                            //*******************Keywords
                            
                            $common->delete_records_dynamically('post_req_keyword', 'post_job_id', $post_job_id);
                            
                            foreach($json->keywords_responses as $keywords_key => $keywords_data) {
                                $keyword_id = $keywords_data->keyword_id;
                                if($keyword_id == 0) { //Insert into keywords :: keyword,subcategories_id
        
                                    //Check whether keyword exists in keywords, if not create
                    		        $arr_ins_keywords_master_det = array(
                		                'keyword' => $keywords_data->name,
                		                'profession_id' => 0,
        								'status' => 'Inactive'
                    		        );
                    		        /*echo "<pre>";
                    		        print_r($arr_ins_keywords_master_det);
                    		        echo "</pre>";*/
                    		        
                    		        $keyword_id = $common->insert_records_dynamically('keywords', $arr_ins_keywords_master_det);
                    		        //echo "<br> keyword id ".$keyword_id;
                                }
                                
                                //Insert into post_req_lang table
                                $arr_post_req_keyword = array(
                                        'post_job_id' => $post_job_id,
                                        'keywords_id' => $keyword_id,
                                        'status' => 'Active',
                                    );
                                
                                $post_req_id = $common->insert_records_dynamically('post_req_keyword', $arr_post_req_keyword);
                                
                                /*echo "<pre>";
                		        print_r($arr_ins_keyword_det);
                		        echo "</pre>";*/
                		        //echo '<br> user_keyword_list_id  '.$user_keyword_list_id;
                            }
                        }
                    
                        //Create and save atatchments
                        if(count($attachments) > 0) {
                            foreach($attachments as $attach_key => $arr_file) {
                                foreach($arr_file as $attach_name => $file) {
                                    if ($file != null) {
                                        $image = generateDynamicImage("images/attachments",$file);
                                        
                                        $arr_attach = array(
                                                'booking_id' => $booking_id,
                                                'file_name' => $image,
                                                'file_location' => 'images/attachments',
                                                'created_on' => $json->created_on,
                                                'created_by' => $json->users_id,
                                                'status_id' => 1
                                            );
                                        $common->insert_records_dynamically('attachments', $arr_attach);
                                    }
                                }
                            }
                        }
                        
                        return $this->respond([
            			    "post_job_id" => $post_job_id,
            			    "status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to update Job Post"
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
	//---------------------------------------------------------Update Multi Move Job Post-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function update_multi_move_job_post()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";*/
            //exit;
            
            if(!array_key_exists('booking_id',$json) || !array_key_exists('post_job_id',$json) || !array_key_exists('scheduled_date',$json) || !array_key_exists('time_slot_from',$json)   
                || !array_key_exists('bids_period',$json) || !array_key_exists('bid_per',$json) || !array_key_exists('bid_range_id',$json) 
                || !array_key_exists('addresses',$json) || !array_key_exists('title',$json) || !array_key_exists('lang_responses',$json)
                || !array_key_exists('bid_range_id',$json) || !array_key_exists('keywords_responses',$json) || !array_key_exists('created_on',$json)
                || !array_key_exists('attachments',$json) || !array_key_exists('estimate_time',$json) || !array_key_exists('estimate_type_id',$json)
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
    		        $attachments = $json->attachments;
    		        $booking_id = $json->booking_id;
    		        $post_job_id = $json->post_job_id;
    		        
    		        $common = new CommonModel();
    		        
    		        //Get master time slot
                    $arr_time_slot_details = $common->get_details_dynamically('time_slot', 'from', $json->time_slot_from);
    		        if($arr_time_slot_details != 'failure') {
    		            $time_slot_id = $arr_time_slot_details[0]['id'];
    		        }
    		        else {
    		            $arr_time_slot = array(
            		        'from' => $json->time_slot_from
                        );
                        $time_slot_id = $common->insert_records_dynamically('time_slot', $arr_time_slot);
    		        }
    		        
    		        $arr_booking = array(
        		        'scheduled_date' => $json->scheduled_date,
                        'time_slot_id' => $time_slot_id,
                        'attachment_count' => count($attachments),
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                    );
                    $common->update_records_dynamically('booking', $arr_booking, 'id', $booking_id);
    		        
    		        if ($booking_id > 0) {
                        $addresses = $json->addresses;
                        $arr_multi_move = array();
                        
                        if(count($addresses) > 0) {
                            foreach($addresses as $address_key => $arr_address) {
                                if($arr_address->id == 0) {
                                    //Insert into multi_move table
                                    $arr_multi_move[] = array(
                                            'booking_id' => $booking_id,
                                            'sequence_no' => $arr_address->sequence_no,
                                            'address_id' => $arr_address->address_id,
                                            'job_description' => $arr_address->job_description,
                                            'weight_type' => $arr_address->weight_type,
                                    );
                                }
                                else {
                                    //Update post_job table
                                    $arr_multi_move_update = array(
                                            'sequence_no' => $arr_address->sequence_no,
                                            'address_id' => $arr_address->address_id,
                                            'job_description' => $arr_address->job_description,
                                            'weight_type' => $arr_address->weight_type,
                                        );
                                    
                                    $common->update_records_dynamically('multi_move', $arr_multi_move_update, 'id', $arr_address->id); 
                                }
                            }
                            /*echo "<pre>";
                            print_r($arr_multi_move);
                            echo "</pre>";
                            exit;*/
                            if(count($arr_multi_move) > 0) {
                                $common->batch_insert_records_dynamically('multi_move', $arr_multi_move);
                            }
                            
                        }
                        
                        //Update post_job table
                        $arr_post_job = array(
                                'bids_period' => $json->bids_period,
                                'title' => $json->title,
                                'bid_per' => $json->bid_per,
                                'bid_range_id' => $json->bid_range_id,
                            );
                        
                        $common->update_records_dynamically('post_job', $arr_post_job, 'id', $post_job_id);
                        
                        if($post_job_id > 0) {
                        
                            //******************Languages
                        
                            $common->delete_records_dynamically('post_req_lang', 'post_job_id', $post_job_id);
                            
                            foreach($json->lang_responses as $lang_key => $lang_data) {
                                $lang_id = $lang_data->lang_id;
                                if($lang_id == 0) { //Insert into user_lang_list ::	language_id	users_id
                                    //Check whether language exists in language, if not create
                    		        $arr_ins_lang_master_det = array(
                		                'name' => $lang_data->name
                    		        );
                    		        /*echo "<pre>";
                    		        print_r($arr_ins_lang_master_det);
                    		        echo "</pre>";*/
                    		        
                    		        $lang_id = $common->insert_records_dynamically('language', $arr_ins_lang_master_det);
                                }
                                
                                //Insert into post_req_lang table
                                $arr_post_req_lang = array(
                                        'post_job_id' => $post_job_id,
                                        'language_id' => $lang_id,
                                        'status' => 'Active',
                                    );
                                
                                $post_req_id = $common->insert_records_dynamically('post_req_lang', $arr_post_req_lang);
                            }
                            //*******************Keywords
                            
                            $common->delete_records_dynamically('post_req_keyword', 'post_job_id', $post_job_id);
                            
                            foreach($json->keywords_responses as $keywords_key => $keywords_data) {
                                $keyword_id = $keywords_data->keyword_id;
                                if($keyword_id == 0) { //Insert into keywords :: keyword,subcategories_id
        
                                    //Check whether keyword exists in keywords, if not create
                    		        $arr_ins_keywords_master_det = array(
                		                'keyword' => $keywords_data->name,
                		                'profession_id' => 0,
        								'status' => 'Inactive'
                    		        );
                    		        /*echo "<pre>";
                    		        print_r($arr_ins_keywords_master_det);
                    		        echo "</pre>";*/
                    		        
                    		        $keyword_id = $common->insert_records_dynamically('keywords', $arr_ins_keywords_master_det);
                    		        //echo "<br> keyword id ".$keyword_id;
                                }
                                
                                //Insert into post_req_lang table
                                $arr_post_req_keyword = array(
                                        'post_job_id' => $post_job_id,
                                        'keywords_id' => $keyword_id,
                                        'status' => 'Active',
                                    );
                                
                                $post_req_id = $common->insert_records_dynamically('post_req_keyword', $arr_post_req_keyword);
                                
                                /*echo "<pre>";
                		        print_r($arr_ins_keyword_det);
                		        echo "</pre>";*/
                		        //echo '<br> user_keyword_list_id  '.$user_keyword_list_id;
                            }
                        }
                    
                        //Create and save atatchments
                        if(count($attachments) > 0) {
                            foreach($attachments as $attach_key => $arr_file) {
                                foreach($arr_file as $attach_name => $file) {
                                    if ($file != null) {
                                        $image = generateDynamicImage("images/attachments",$file);
                                        
                                        $arr_attach = array(
                                                'booking_id' => $booking_id,
                                                'file_name' => $image,
                                                'file_location' => 'images/attachments',
                                                'created_on' => $json->created_on,
                                                'created_by' => $json->users_id,
                                                'status_id' => 1
                                            );
                                        $common->insert_records_dynamically('attachments', $arr_attach);
                                    }
                                }
                            }
                        }
                        
                        return $this->respond([
            			    "post_job_id" => $post_job_id,
            			    "status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to update Job Post"
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
	//---------------------------------------------------------Job Post Approve/Reject Installments-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function job_post_approve_reject_installment()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/
            
            if(!array_key_exists('booking_id',$json)  || !array_key_exists('users_id',$json)  || !array_key_exists('inst_id',$json) 
            || !array_key_exists('sp_id',$json) || !array_key_exists('status_id',$json)  || !array_key_exists('key',$json)) 
            {
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
    		        $common = new CommonModel();
    		        
    		        $arr_user_details = $common->get_details_dynamically('users', 'users_id', $json->sp_id);
    		        
    		        $arr_installment_det = array(
                            'inst_request_status_id' => $json->status_id, //34 - approved,35 - rejected
        		    );
                    $common->update_records_dynamically('installment_det', $arr_installment_det, 'id', $json->inst_id);
                    
                    //Insert into booking status
                    $arr_booking_status = array(
        		        'booking_id' => $json->booking_id,
                        'status_id' => $json->status_id, //34 - approved,35 - rejected
                        'sp_id' => $json->sp_id,
                        'description' => ($json->status_id == 34) ? "User approved Installment for inst_id ".$json->inst_id : "User rejected Installment for inst_id ".$json->inst_id,
                        'created_on' => date('Y-m-d H:i:s')
                    );
                    $common->insert_records_dynamically('booking_status', $arr_booking_status);
    		        
    		        return $this->respond([
    		            "sp_fcm_token" => ($arr_user_details != 'failure') ? $arr_user_details[0]['fcm_token'] : "",
        			    "status" => 200,
        				"message" => "Installment request updated Successfully",
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
	}
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
}
