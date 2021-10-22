<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;

use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;
use Modules\User\Models\JobPostModel;

helper('Modules\User\custom');

class PostDiscussion extends ResourceController
{

	//---------------------------------------------------------Post Discussion-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function post_discussion()
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
            
            if(!array_key_exists('post_job_id',$json) || !array_key_exists('comment',$json) || !array_key_exists('attachment_type',$json)
            || !array_key_exists('attachments',$json) || !array_key_exists('created_on',$json) || !array_key_exists('user_type',$json)
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
    		        $misc_model = new MiscModel();
    		        
    		        $arr_discussion = array(
        		        'post_job_id' => $json->post_job_id,
                        'users_id' => $json->users_id,
                        'comment' => $json->comment,
                        'attachment_count' => count($attachments),
                    );
                    $discussion_tbl_id = $common->insert_records_dynamically('discussion_tbl', $arr_discussion);
                    
                    if ($discussion_tbl_id > 0) {
                        //Create and save atatchments
                        if(count($attachments) > 0) {
                            foreach($attachments as $attach_key => $arr_file) {
                                foreach($arr_file as $attach_name => $file) {
                                    if ($file != null) {
                                        $image = generateDynamicImage("images/attachments",$file,$json->attachment_type);
                                        
                                        $arr_attach = array(
                                                'file_name' => $image,
                                                'file_location' => 'images/attachments',
                                                'disc_id' => $discussion_tbl_id,
                                                'created_on' => $json->created_on,
                                                'created_by' => $json->users_id,
                                            );
                                        $common->insert_records_dynamically('post_attach_disc_chat', $arr_attach);
                                    }
                                }
                            }
                        }
                        
                        $sp_name = "";
        		        $user_name = "";
        		        $job_title = "";
        		        $user_id = 0;
                        
                        if($json->user_type == 'User') {
                            $arr_user_details = $misc_model->get_user_name_by_post($json->post_job_id, $json->users_id);
            		        if($arr_user_details != "failure") {
            		            $user_name = $arr_user_details['fname']." ".$arr_user_details['lname'];
	                            $user_id = $arr_user_details['users_id'];
            		            $job_title = $arr_user_details['title'];
            		        }
                            
                            //Insert into alert_details table
                            $arr_alerts = array(
                		          'alert_id' => 2, 
                                  'description' => $user_name." posted a message in discussion board of post $job_title.",
                                  'action' => 1,
                                  'created_on' => date("Y-m-d H:i:s"), 
                                  'status' => 1,
                                  'users_id' => $user_id,
                            );
                            $common->insert_records_dynamically('alert_details', $arr_alerts);
                        }
                        else if($json->user_type == 'SP') {
                            $arr_sp_details = $misc_model->get_sp_name_by_post($json->post_job_id, $json->users_id);
            		        if($arr_sp_details != "failure") {
            		            $sp_name = $arr_sp_details['fname']." ".$arr_sp_details['lname'];
            		            $sp_id = $arr_sp_details['sp_id'];
            		            $job_title = $arr_sp_details['title'];
            		        }
                            
                            //Insert into alert_details table
                            $arr_alerts = array(
                		          'alert_id' => 2, 
                                  'description' => $sp_name." posted a message in discussion board of post $job_title.",
                                  'action' => 1,
                                  'created_on' => date("Y-m-d H:i:s"), 
                                  'status' => 1,
                                  'sp_id' => $sp_id,
                            );
                            $common->insert_records_dynamically('alert_details', $arr_alerts);
                        }
                        
                        return $this->respond([
            			    "discussion_tbl_id" => $discussion_tbl_id,
            			    "status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
            		        "status" => 404,
        					"message" => "Failed to create Discussion"
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
	//---------------------------------------------------------Like Post Discussion-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function like_post_discussion()
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
            
            if(!array_key_exists('discussion_tbl_id',$json) || !array_key_exists('created_on',$json) || !array_key_exists('users_id',$json) || !array_key_exists('key',$json)) {
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
    		        $job_post_model = new JobPostModel();
    		        
    		        $arr_like = array(
        		        'discussion_tbl_id' => $json->discussion_tbl_id,
                        'users_id' => $json->users_id,
                        'created_on' => $json->created_on,
                    );
                    $arr_like_id = $common->insert_records_dynamically('disc_like', $arr_like);
                    
                    //Update Discussion table with like count
                    $likes_count = $job_post_model->get_discussion_like_count($json->discussion_tbl_id);
                    $arr_like_count = array('likes_count' => $likes_count);
                    
                    $common->update_records_dynamically('discussion_tbl', $arr_like_count,'id', $json->discussion_tbl_id);
                    
                    if ($arr_like_id > 0) {
                        return $this->respond([
            			    "arr_like_id" => $arr_like_id,
            			    "status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
            		        "status" => 404,
        					"message" => "Failed to Like the discussion"
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
	//---------------------------------------------------------Job Post Discussion List-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_job_post_discussion_list()
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
    		       
    		       $arr_discussion_list = array();
    		       
    		       //Get Bids
    		       $arr_discussion_details = $job_post_model->get_discussion_details_by_jobpost_id($post_job_id);
    		       
    		       if($arr_discussion_details != 'failure') {
    		           return $this->respond([
        		            "discussion_details" => $arr_discussion_details,
        		            "status" => 200,
            				"message" => "Success",
            			]);
    		       }
    		       else {
            		    return $this->respond([
            		        "post_job_id" => $post_job_id,
        					"status" => 404,
        					"message" => "No Discussions found"
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
	
	
}
