<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;

use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;
use Modules\User\Models\JobPostModel;
use Modules\User\Models\SmsTemplateModel;

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
            
            if(!property_exists($json, 'post_job_id') || !property_exists($json,'comment') || !property_exists($json,'attachments') 
            || !property_exists($json,'created_on') || !property_exists($json,'user_type')
            || !property_exists($json,'users_id') || !property_exists($json,'key')
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
                                $pos = strpos($arr_file->file, 'firebasestorage');
                    
                                if ($pos !== false) { //URL
                                    $url = $arr_file;

                                    list($path, $token) = explode('?', $url);

                                    $type = pathinfo($path, PATHINFO_EXTENSION);
                                    $data = file_get_contents($url);
                                    $base64_file = base64_encode($data);

                                    $file = $base64_file;
                                } else {
                                    $type = $arr_file->type;
                                }

                                // $image = generateDynamicImage("images/attachments", $file, $type);

                                //---------Code for S3 Object Create Starts
                                $images = ['png','jpeg','jpg','gif','tiff'];
                                $video = ['mp4','mp3','mpeg','mpeg4','3gp','wav','mov'];

                                if(in_array($arr_file->type,$images)){
                                    $folder = "images";
                                }elseif(in_array($arr_file->type,$video)){
                                    $folder = 'videos';
                                }else{
                                    $folder = 'documents';
                                }

                                // print_r($arr_file->type);
                                // exit;

                                $file = generateS3Object($folder,$arr_file->file,$arr_file->type); 

                                //----------Code for S3 Object Create Ends Here
                                        
                                        $arr_attach = array(
                                                'file_name' => $file,
                                                'file_location' => 'elasticbeanstalk-ap-south-1-702440578175/'.$folder,
                                                'disc_id' => $discussion_tbl_id,
                                                'created_on' => $json->created_on,
                                                'created_by' => $json->users_id,
                                            );
                                        $common->insert_records_dynamically('post_attach_disc_chat', $arr_attach);
                                    }
                                }
                            
                        
                        $sp_name = "";
        		        $user_name = "";
        		        $job_title = "";
        		        $user_id = 0;
                        $date = date("Y-m-d H:i:s");

                        if($json->user_type == 'User') {
                            $arr_user_details = $misc_model->get_user_name_by_post($json->post_job_id, $json->users_id);
            		        if($arr_user_details != "failure") {
            		            $user_name = $arr_user_details['fname']." ".$arr_user_details['lname'];
	                            $user_id = $arr_user_details['users_id'];
            		            $job_title = $arr_user_details['title'];
            		            $user_mobile = $arr_user_details['mobile'];
            		        }
                            
                            //Insert into alerts_regular_user table
                                                      
                            $arr_alerts = array(
                                'type_id' => 2,
                                'description' => "You have posted a message in discussion board of post ".$job_title." on ".$date,
                                'user_id' => $user_id,
                                'profile_pic_id' => $user_id,
                                'status' => 2,
                                'created_on' => $date,
                                'updated_on'=>$date
                            );
                            
                            $common->insert_records_dynamically('alert_regular_user', $arr_alerts);

                            
                            //Send SMS
                            $sms_model = new SmsTemplateModel();
                            
                    	 	$data = [
                				"name" => "new_comment",
                				"mobile" => $user_mobile,
                				"dat" => [
                					"var" => $user_name,
                					"var1" => str_pad($json->post_job_id, 6, '0', STR_PAD_LEFT),
                				]
                			];
                			
                			$sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);
                        }
                        else if($json->user_type == 'SP') {
                            $arr_sp_details = $common->get_details_dynamically('user_details','id',$json->users_id);
                            $arr_post_details = $misc_model->get_user_name_by_post($json->post_job_id);

                            // print_r($arr_post_details);
                            // exit;

            		        if($arr_sp_details != "failure" && $arr_post_details != 'failure') {
            		            $sp_name = $arr_sp_details[0]['fname']." ".$arr_sp_details[0]['lname'];
            		            $sp_id = $arr_sp_details[0]['id'];
                                $sp_mobile = $arr_sp_details[0]['mobile'];
                                $user_id = $arr_post_details['users_id'];
            		            $job_title = $arr_post_details['title'];
            		            
            		        }
                            
                            

                            $sp_profile = $misc_model->user_info($json->users_id);

                             //Insert into alerts_regular_user table
                                                      
                             $arr_alerts = array(
                                'type_id' => 2,
                                'description' => $sp_name."has posted a message in discussion board of post ".$job_title." on ".$date,
                                'user_id' => $user_id,
                                'profile_pic_id' => $sp_id,
                                'status' => 2,
                                'created_on' => $date,
                                'updated_on'=>$date
                            );
                            
                            $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                            //Insert into alerts_regular_sp table
                                                      
                            $arr_alerts1 = array(
                                'type_id' => 2,
                                'description' => "you have posted a message in discussion board of post ".$job_title." on ".$date,
                                'user_id' => $sp_id,
                                'profile_pic_id' => $sp_id,
                                'status' => 2,
                                'created_on' => $date,
                                'updated_on'=>$date
                            );
                            
                            $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);    

                            
                            //Send SMS
                            $sms_model = new SmsTemplateModel();
                            
                    	 	$data = [
                				"name" => "new_comment",
                				"mobile" => $sp_mobile,
                				"dat" => [
                					"var" => $sp_name,
                					"var1" => str_pad($json->post_job_id, 6, '0', STR_PAD_LEFT),
                				]
                			];
                			
                			$sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);
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
            
            if(!property_exists($json,'discussion_tbl_id') || !property_exists($json,'created_on') || !property_exists($json,'users_id') || !property_exists($json,'key')) {
    		    return $this->respond([
        				'status' => 403,
                        'message' => 'Invalid Parameters'
        		]);
    		}
            else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();
		
    		    $api_key = $apiconfig->user_key;
    		    
                $date = $json->created_on;
    		    if($key == $api_key) {
    		        $common = new CommonModel();
    		        $job_post_model = new JobPostModel();
    		        
    		        $arr_like = array(
        		        'discussion_tbl_id' => $json->discussion_tbl_id,
                        'users_id' => $json->users_id,
                        'created_on' => $date,
                    );

                    $arr_like_id = $common->insert_records_dynamically('disc_like', $arr_like);

                    
                    //Getting Both User Details
                    $posted_user = $job_post_model->get_user_by_discussion_table($json->discussion_tbl_id);
                    $liked_user = $common->get_details_dynamically('user_details','id',$json->users_id);

                    //Update Discussion table with like count
                    $likes_count = $job_post_model->get_discussion_like_count($json->discussion_tbl_id);
                    $arr_like_count = array('likes_count' => $likes_count);
                    
                    // print_r($liked_user);
                    // exit;

                    
                    $common->update_records_dynamically('discussion_tbl', $arr_like_count,'id', $json->discussion_tbl_id);
                    
                    if ($arr_like_id > 0) {
                    
                        //Insert into alert_regular_sp tbl of liked user
                        
                        $arr_alerts = array(
                            'type_id' => 8,
                            'description' => "You liked the comment '".$posted_user[0]['comment']." posted by ".$posted_user[0]['fname']." ".$posted_user[0]['lname'],
                            'user_id' => $json->users_id,
                            'profile_pic_id' => $json->users_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);    
                    
                        
                        //Insert into alert_regular_sp tbl of discussion posted User
                    
                        $arr_alerts = array(
                            'type_id' => 8,
                            'description' => "Your comment '".$posted_user[0]['comment']." is liked by ".$liked_user[0]['fname']." ".$liked_user[0]['lname'],
                            'user_id' => $posted_user[0]['users_id'],
                            'profile_pic_id' => $json->users_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);
                    
                    
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
            
            if(!property_exists($json,'post_job_id') || !property_exists($json,'key')) {
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
