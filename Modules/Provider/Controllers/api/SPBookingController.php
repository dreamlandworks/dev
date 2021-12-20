<?php

namespace Modules\Provider\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;
use Modules\User\Models\JobPostModel;
use Modules\User\Models\SmsTemplateModel;

helper('Modules\User\custom');

class SPBookingController extends ResourceController
{

	//--------------------------------------------------Extra Demand STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------
    public function post_sp_extra_demand()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            
            if( !array_key_exists('booking_id',$json) || !array_key_exists('created_on',$json) || !array_key_exists('material_advance',$json) 
            || !array_key_exists('technician_charges',$json) || !array_key_exists('key',$json)
                            ) {
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
    		        $misc_model = new MiscModel();
    		        
    		        $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);
    		        $sp_name = "";
    		        $sp_id = 0;
    		        $user_id = 0;
    		        
    		        $arr_sp_details = $misc_model->get_sp_name_by_booking($json->booking_id);
    		        if($arr_sp_details != "failure") {
    		            $sp_name = $arr_sp_details['fname']." ".$arr_sp_details['lname'];
    		            $sp_id = $arr_sp_details['sp_id'];
    		            $user_id = $arr_sp_details['users_id'];
    		        }
    		        
    		        $arr_extra_demand_details =  $common->get_details_dynamically('extra_demand', 'booking_id', $json->booking_id);
    		        if($arr_extra_demand_details == 'failure') {
        		        $arr_extra_demand = array(
                                'booking_id' => $json->booking_id,
                                'booking_heads_id' => 2,
                                'amount' => $json->amount,
            		            'material_advance' => $json->material_advance,
            		            'technician_charges' => $json->technician_charges,
            		            'created_on' => $json->created_on,
                        );
        		        
        		        $extra_demand_id = $common->insert_records_dynamically('extra_demand', $arr_extra_demand);
        		        
        		        //Insert into booking status
                        $arr_booking_status = array(
            		        'booking_id' => $json->booking_id,
                            'status_id' => 37, //Extra demand added
                            'description' => "Sp added extra demand for Booking ".$booking_ref_id,
                            'created_on' => date('Y-m-d H:i:s')
                        );
                        $common->insert_records_dynamically('booking_status', $arr_booking_status);
                        
                        //Insert into alert_details table
                        $arr_alerts = array(
            		          'alert_id' => 7, 
                              'description' => "You raised an Extra Demand of Rs. $json->amount for Booking ($booking_ref_id).",
                              'action' => 1,
                              'created_on' => date("Y-m-d H:i:s"), 
                              'status' => 1,
                              'sp_id' => $sp_id,
                              'booking_id' => $json->booking_id
                        );
                        $common->insert_records_dynamically('alert_details', $arr_alerts);
                        
            	        $arr_alerts = array(
            		          'alert_id' => 7, 
                              'description' => $sp_name." raised an Extra Demand of Rs. $json->amount for Booking ($booking_ref_id). Would you accept?",
                              'action' => 2,
                              'created_on' => date("Y-m-d H:i:s"), 
                              'status' => 1,
                              'users_id' => $user_id,
                              'booking_id' => $json->booking_id
                        );
                        $common->insert_records_dynamically('alert_details', $arr_alerts);
    		        }
    		        else {
    		            $arr_extra_demand = array(
                                'amount' => $json->amount,
            		            'material_advance' => $json->material_advance,
            		            'technician_charges' => $json->technician_charges,
            		    );
                        $common->update_records_dynamically('extra_demand', $arr_extra_demand, 'booking_id', $json->booking_id);
        		        
        		        $extra_demand_id = $arr_extra_demand_details[0]['id'];
    		        }
                    
                    if ($extra_demand_id > 0) {
                        return $this->respond([
            			   	"status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to create Extra Demand"
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
    //--------------------------------------------------FUNCTION ENDS------------------------------------------------------------
	//---------------------------------------------------------SP Booking details-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_sp_booking_details()
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
            
            if(!array_key_exists('sp_id',$json) || !array_key_exists('key',$json)) {
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
    		       $misc_model = new MiscModel();
    		       
    		       $users_id = 0;
    		       $sp_id = $json->sp_id;
    		       
    		       //Get Single Move Booking Details
    		       $arr_single_move_booking_details = $misc_model->get_user_single_move_booking_details($users_id,$sp_id); 
    		       
    		       $arr_booking = array();
    		       $arr_booking_response = array();
    		       
    		       if($arr_single_move_booking_details != 'failure') {
    		           foreach($arr_single_move_booking_details as $key => $book_data) {
    		               $started_at = $book_data['started_at'];
    		               $completed_at = $book_data['completed_at'];
    		               
    		               if($started_at == "" || $started_at == "0000-00-00 00:00:00") {
    		                   $status = "Pending";
    		               }
    		               else {
    		                 if($completed_at == "" || $completed_at == "0000-00-00 00:00:00") {
        		                   $status = "Inprogress";
        		             }  
        		             else {
        		                 $status = "Completed";
        		             } 
    		               }
    		               
    		               $arr_booking[$key]['booking_id'] = $book_data['id'];
    		               $arr_booking[$key]['category_id'] = $book_data['category_id'];
        		           $arr_booking[$key]['fname'] = $book_data['fname'];
    		               $arr_booking[$key]['lname'] = $book_data['lname'];
    		               $arr_booking[$key]['mobile'] = $book_data['mobile'];
    		               $arr_booking[$key]['scheduled_date'] = $book_data['scheduled_date'];
    		               $arr_booking[$key]['time_slot_id'] = $book_data['time_slot_id'];
    		               $arr_booking[$key]['started_at'] = $book_data['started_at'];
    		               $arr_booking[$key]['from'] = $book_data['from'];
    		               $arr_booking[$key]['estimate_time'] = $book_data['estimate_time'];
    		               $arr_booking[$key]['estimate_type'] = $book_data['estimate_type'];
    		               $arr_booking[$key]['amount'] = $book_data['amount'];
    		               $arr_booking[$key]['sp_id'] = $book_data['sp_id'];
    		               $arr_booking[$key]['users_id'] = $book_data['users_id'];
    		               $arr_booking[$key]['profile_pic'] = $book_data['profile_pic'];
    		               $arr_booking[$key]['booking_status'] = $status;
    		               $arr_booking[$key]['pause_status'] = ($book_data['status_id'] == 15) ? "Yes" : "No";
    		               
    		               $arr_booking[$key]['otp'] = $book_data['otp'];
    		               $arr_booking[$key]['extra_demand_total_amount'] = $book_data['extra_demand_total_amount'];
    		               $arr_booking[$key]['material_advance'] = $book_data['material_advance'];
    		               $arr_booking[$key]['technician_charges'] = $book_data['technician_charges'];
    		               $arr_booking[$key]['expenditure_incurred'] = $book_data['expenditure_incurred'];
    		               
    		               $arr_booking[$key]['details'][] = array('job_description' => $book_data['job_description'],
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
        		       //print_r($arr_booking_details);
        		       //print_r($arr_booking);
        		       //echo "</pre>";
        		       //exit;
        		   }
    		       
    		       $booking_count = (count($arr_booking) > 0) ?  count($arr_booking) : 0; //Increment the key
    		       
    		       //Get Blue Collar Booking Details
    		       $arr_blue_collar_booking_details = $misc_model->get_user_blue_collar_booking_details($users_id,$sp_id); 
    		       
    		       if($arr_blue_collar_booking_details != 'failure') {
    		           foreach($arr_blue_collar_booking_details as $bc_book_data) {
    		               $started_at = $bc_book_data['started_at'];
    		               $completed_at = $bc_book_data['completed_at'];
    		               $status = "";
    		               if($started_at == "" || $started_at == "0000-00-00 00:00:00") {
    		                   $status = "Pending";
    		               }
    		               else {
    		                 if($completed_at == "" || $completed_at == "0000-00-00 00:00:00") {
        		                   $status = "Inprogress";
        		             }  
        		             else {
        		                 $status = "Completed";
        		             } 
    		               }
    		               
    		               $arr_booking[$booking_count]['booking_id'] = $bc_book_data['id'];
        		           $arr_booking[$booking_count]['category_id'] = $bc_book_data['category_id'];
        		           $arr_booking[$booking_count]['fname'] = $bc_book_data['fname'];
    		               $arr_booking[$booking_count]['lname'] = $bc_book_data['lname'];
    		               $arr_booking[$booking_count]['mobile'] = $bc_book_data['mobile'];
    		               $arr_booking[$booking_count]['scheduled_date'] = $bc_book_data['scheduled_date'];
    		               $arr_booking[$booking_count]['time_slot_id'] = $bc_book_data['time_slot_id'];
    		               $arr_booking[$booking_count]['started_at'] = $bc_book_data['started_at'];
    		               $arr_booking[$booking_count]['from'] = $bc_book_data['from'];
    		               $arr_booking[$booking_count]['estimate_time'] = $bc_book_data['estimate_time'];
    		               $arr_booking[$booking_count]['estimate_type'] = $bc_book_data['estimate_type'];
    		               $arr_booking[$booking_count]['amount'] = $bc_book_data['amount'];
    		               $arr_booking[$booking_count]['sp_id'] = $bc_book_data['sp_id'];
    		               $arr_booking[$booking_count]['users_id'] = $bc_book_data['users_id'];
    		               $arr_booking[$booking_count]['profile_pic'] = $bc_book_data['profile_pic'];
    		               $arr_booking[$booking_count]['booking_status'] = $status;
    		               $arr_booking[$booking_count]['pause_status'] = ($bc_book_data['status_id'] == 15) ? "Yes" : "No";
    		               $arr_booking[$booking_count]['otp'] = $bc_book_data['otp'];
    		               $arr_booking[$booking_count]['extra_demand_total_amount'] = $bc_book_data['extra_demand_total_amount'];
    		               $arr_booking[$booking_count]['material_advance'] = $bc_book_data['material_advance'];
    		               $arr_booking[$booking_count]['technician_charges'] = $bc_book_data['technician_charges'];
    		               $arr_booking[$booking_count]['expenditure_incurred'] = $bc_book_data['expenditure_incurred'];
    		               
    		               $arr_booking[$booking_count]['details'][] = array('job_description' => $bc_book_data['job_description']);
    		               
    		               $booking_count++;
    		           }
        		   }
        		   
        		   $booking_count = (count($arr_booking) > 0) ?  count($arr_booking) : 0; //Increment the key
    		       
    		       //Get Multi Move Booking Details
    		       $arr_multi_move_booking_details = $misc_model->get_user_multi_move_booking_details($users_id,$sp_id); 
    		       
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
    		                   $started_at = $mm_book_data['started_at'];
        		               $completed_at = $mm_book_data['completed_at'];
        		               $status = "";
        		               if($started_at == "" || $started_at == "0000-00-00 00:00:00") {
        		                   $status = "Pending";
        		               }
        		               else {
        		                 if($completed_at == "" || $completed_at == "0000-00-00 00:00:00") {
            		                   $status = "Inprogress";
            		             }  
            		             else {
            		                 $status = "Completed";
            		             } 
    		                    }
    		               
        		               $arr_booking[$booking_count]['booking_id'] = $mm_book_data['id'];
            		           $arr_booking[$booking_count]['category_id'] = $mm_book_data['category_id'];
            		           $arr_booking[$booking_count]['fname'] = $mm_book_data['fname'];
        		               $arr_booking[$booking_count]['lname'] = $mm_book_data['lname'];
        		               $arr_booking[$booking_count]['mobile'] = $mm_book_data['mobile'];
        		               $arr_booking[$booking_count]['scheduled_date'] = $mm_book_data['scheduled_date'];
        		               $arr_booking[$booking_count]['time_slot_id'] = $mm_book_data['time_slot_id'];
        		               $arr_booking[$booking_count]['started_at'] = $mm_book_data['started_at'];
        		               $arr_booking[$booking_count]['from'] = $mm_book_data['from'];
        		               $arr_booking[$booking_count]['estimate_time'] = $mm_book_data['estimate_time'];
        		               $arr_booking[$booking_count]['estimate_type'] = $mm_book_data['estimate_type'];
        		               $arr_booking[$booking_count]['amount'] = $mm_book_data['amount'];
        		               $arr_booking[$booking_count]['sp_id'] = $mm_book_data['sp_id'];
        		               $arr_booking[$booking_count]['users_id'] = $mm_book_data['users_id'];
        		               $arr_booking[$booking_count]['profile_pic'] = $mm_book_data['profile_pic'];
        		               $arr_booking[$booking_count]['booking_status'] = $status;
        		               $arr_booking[$booking_count]['pause_status'] = ($mm_book_data['status_id'] == 15) ? "Yes" : "No";
        		               $arr_booking[$booking_count]['otp'] = $mm_book_data['otp'];
        		               $arr_booking[$booking_count]['extra_demand_total_amount'] = $mm_book_data['extra_demand_total_amount'];
        		               $arr_booking[$booking_count]['material_advance'] = $mm_book_data['material_advance'];
        		               $arr_booking[$booking_count]['technician_charges'] = $mm_book_data['technician_charges'];
        		               $arr_booking[$booking_count]['expenditure_incurred'] = $mm_book_data['expenditure_incurred'];
        		               
        		               foreach($arr_details[$mm_book_data['id']] as $key => $val) {
        		                   $arr_booking[$booking_count]['details'][$key] = $arr_details[$mm_book_data['id']][$key];
        		               }
        		               
        		               $arr_exists[$mm_book_data['id']] = $mm_book_data['id'];
        		               
        		               $booking_count++;
    		               }
    		           }
        		   }
        		   
        		   //echo "<pre>";
        		   //print_r($arr_booking_details);
        		   //print_r($arr_booking);
        		   //echo "</pre>";
        		   //exit;
        		   if(count($arr_booking) > 0) {
        		       return $this->respond([
        		            "booking_details" => $arr_booking,
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
	//--------------------------------------------------Update Extra demand status STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------
    public function update_final_expenditure()
    {

        $json = $this->request->getJSON();
        if(!array_key_exists('booking_id',$json) || !array_key_exists('expenditure_incurred',$json) || !array_key_exists('key',$json) ) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else{
        $common = new CommonModel();
        
        $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		$apiconfig = new \Config\ApiConfig();
		
    	$api_key = $apiconfig->provider_key;
    		
    	if($key == $api_key)
    	{
            $expenditure_incurred = $json->expenditure_incurred; 
            $booking_id = $json->booking_id;
            
            //Mark the status
            $arr_extra_demand = array(
		        'expenditure_incurred' => $expenditure_incurred,
            );
            $common->update_records_dynamically('extra_demand', $arr_extra_demand, 'booking_id', $booking_id);
            
            return $this->respond([
                "status" => 200,
                "message" =>  "Expenditure Incurred updated Successfully"
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
    //---------------------------------------------------------Booking Work Summary-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_booking_work_summary()
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
            
            if(!array_key_exists('booking_id',$json) || !array_key_exists('key',$json)) {
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
    		       $misc_model = new MiscModel();
    		       
    		       $booking_id = $json->booking_id;
    		       
    		       //Get Booking Details
    		       $arr_booking_details = $misc_model->get_booking_work_summary($booking_id); 
    		       
    		       $arr_booking_transactions = array();
    		       $arr_booking = array();
    		       
    		       if($arr_booking_details != 'failure') {
    		               
    		           $arr_booking['booking_id'] = $booking_id;
    		           $arr_booking['scheduled_date'] = $arr_booking_details['scheduled_date'];
    		           $arr_booking['scheduled_time'] = $arr_booking_details['from'];
		               $arr_booking['started_at'] = $arr_booking_details['started_at'];
		               $arr_booking['completed_at'] = $arr_booking_details['completed_at'];
		               $arr_booking['estimate_time'] = $arr_booking_details['estimate_time'];
		               $arr_booking['estimate_type'] = $arr_booking_details['estimate_type'];
		               $arr_booking['amount'] = $arr_booking_details['amount'];
		               $arr_booking['extra_demand_total_amount'] = $arr_booking_details['extra_demand_total_amount'];
		               $arr_booking['material_advance'] = $arr_booking_details['material_advance'];
		               $arr_booking['technician_charges'] = $arr_booking_details['technician_charges'];
		               $arr_booking['expenditure_incurred'] = $arr_booking_details['expenditure_incurred'];
		               
		               //Get booking transactions
		               $arr_booking_transactions = $misc_model->get_booking_transaction_history($booking_id);
		          }
		          return $this->respond([
    		            "booking_details" => $arr_booking,
    		            "booking_paid_transactions" => ($arr_booking_transactions != 'failure') ? $arr_booking_transactions : array(),
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
	}
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
	//---------------------------------------------------------Goals/Installments-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_goals_installments_list()
	{
		$validate_key = $this->request->getVar('key');
		$validate_post_job_id = $this->request->getVar('post_job_id');
		
		if($validate_key == "" || $validate_post_job_id == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		} else {
            $key = md5($validate_key); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->provider_key;
    		
    		if($key == $api_key) {
    		    $job_post_model = new JobPostModel();
    		       
    		       $post_job_id = $validate_post_job_id;
    		       
    		       //Get Goals/Installments
    		       $arr_goals_installments = $job_post_model->get_goals_installments_list($post_job_id);
    		       
    		       if($arr_goals_installments != 'failure') {
    		          
    		          return $this->respond([
        		            "goals_installments_details" => $arr_goals_installments,
        		            "status" => 200,
            				"message" => "Success",
            			]);
    		       }
    		       else {
            		    return $this->respond([
            		        "booking_id" => $booking_id,
        					"status" => 404,
        					"message" => "No Goals/Installments found"
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
	//---------------------------------------------------------Job Post Request Installments-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function job_post_request_installment()
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
            || !array_key_exists('sp_id',$json)  || !array_key_exists('key',$json)) 
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
    		        $misc_model = new MiscModel();
    		        
    		        $inst_no = 0;
    		        
    		        $arr_inst_details = $common->get_details_dynamically('installment_det', 'id', $json->inst_id);
    		        if($arr_inst_details != 'failure') {
    		            $inst_no = $arr_inst_details[0]['inst_no'];
    		        }
    		        
    		        $arr_user_details = $common->get_details_dynamically('users', 'users_id', $json->users_id);
    		        $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);
            
                    $sp_name = "";
        	        $sp_id = 0;
        	        $user_id = 0;
        	        
        	        $arr_sp_details = $misc_model->get_sp_name_by_booking($booking_id);
        	        if($arr_sp_details != "failure") {
        	            $sp_name = $arr_sp_details['fname']." ".$arr_sp_details['lname'];
        	            $sp_id = $arr_sp_details['sp_id'];
        	            $user_id = $arr_sp_details['users_id'];
        	        }
    		        
    		        $arr_installment_det = array(
                            'inst_request_status_id' => 33,
        		    );
                    $common->update_records_dynamically('installment_det', $arr_installment_det, 'id', $json->inst_id);
                    
                    //Insert into booking status
                    $arr_booking_status = array(
        		        'booking_id' => $json->booking_id,
                        'status_id' => 33, //Installment Requested
                        'sp_id' => $json->sp_id,
                        'description' => "Sp requested Installment for inst_id ".$json->inst_id,
                        'created_on' => date('Y-m-d H:i:s')
                    );
                    $common->insert_records_dynamically('booking_status', $arr_booking_status);
                    
                    //Insert into alerts
                    $arr_alerts = array(
        		          'alert_id' => 2, 
                          'description' => $sp_name." has requested for $inst_no Installment as he completed the (Condition) in Booking $booking_ref_id.",
                          'action' => 2,
                          'created_on' => date("Y-m-d H:i:s"), 
                          'status' => 1,
                          'users_id' => $user_id,
                          'booking_id' => $json->booking_id
                    );
                    $common->insert_records_dynamically('alert_details', $arr_alerts);
                    
                    $arr_alerts = array(
        		          'alert_id' => 2, 
                          'description' => "you have requested for $inst_no Installment as (Condition) is completed in Booking $booking_ref_id.",
                          'action' => 2,
                          'created_on' => date("Y-m-d H:i:s"), 
                          'status' => 1,
                          'sp_id' => $sp_id,
                          'booking_id' => $json->booking_id
                    );
                    $common->insert_records_dynamically('alert_details', $arr_alerts);
    		        
    		        return $this->respond([
    		            "user_fcm_token" => ($arr_user_details != 'failure') ? $arr_user_details[0]['fcm_token'] : "",
        			    "status" => 200,
        				"message" => "Installment request sent Successfully",
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
	//--------------------------------------------------Pause Booking STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------
    public function pause_booking()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            
            if( !array_key_exists('booking_id',$json) || !array_key_exists('sp_id',$json) || !array_key_exists('paused_at',$json) || !array_key_exists('key',$json)
                            ) {
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
    		        
    		        //Insert into booking status
                    $arr_booking_status = array(
        		        'booking_id' => $json->booking_id,
        		        'sp_id' => $json->sp_id, 
                        'status_id' => 15, //Booking Paused
                        'description' => "Paused for booking_id ".$json->booking_id,
                        'created_on' => $json->paused_at
                    );
                    $booking_status_id = $common->insert_records_dynamically('booking_status', $arr_booking_status);
    		        
                    if ($booking_status_id > 0) {
                        //Update Booking
                        $arr_booking_update = array(
                                'status_id' => 15,
            		    );
                        $common->update_records_dynamically('booking', $arr_booking_update, 'id', $json->booking_id);
                        
                        return $this->respond([
            			   	"status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to pause the booking"
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
    //--------------------------------------------------FUNCTION ENDS------------------------------------------------------------
    //--------------------------------------------------Resume Booking STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------
    public function resume_booking()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            
            if( !array_key_exists('booking_id',$json) || !array_key_exists('sp_id',$json) || !array_key_exists('resumed_at',$json) || !array_key_exists('key',$json)
                            ) {
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
    		        
    		        //Insert into booking status
                    $arr_booking_status = array(
        		        'booking_id' => $json->booking_id,
        		        'sp_id' => $json->sp_id, 
                        'status_id' => 16, //Booking Resumed
                        'description' => "Resumed for booking_id ".$json->booking_id,
                        'created_on' => $json->resumed_at
                    );
                    $booking_status_id = $common->insert_records_dynamically('booking_status', $arr_booking_status);
    		        
                    if ($booking_status_id > 0) {
                        //Update Booking
                        $arr_booking_update = array(
                                'status_id' => 16,
            		    );
                        $common->update_records_dynamically('booking', $arr_booking_update, 'id', $json->booking_id);
                        
                        return $this->respond([
            			   	"status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to resume the booking"
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
    //--------------------------------------------------FUNCTION ENDS------------------------------------------------------------
    //---------------------------------------------------------Job Post Bids-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_sp_job_post_bids_list()
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
            
            if(!array_key_exists('sp_id',$json) || !array_key_exists('key',$json)) {
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
    		       $job_post_model = new JobPostModel();
    		       
    		       $sp_id = $json->sp_id;
    		       
    		       $arr_bid_list = array();
    		       $arr_sp_jobs_completed = array();
    		       
    		       $category_id = 0;
    		       
    		       //Get sp details
    		       $arr_sp_details = $job_post_model->get_sp_details($sp_id);
    		       if($arr_sp_details != 'failure') {
    		           $category_id = $arr_sp_details[0]['category_id'];
    		       }
    		       
    		       $arr_job_post_bids = array();
    		       $arr_multimove_details = array();
    		       
    		       //Get Bids
    		       $arr_bid_details = $job_post_model->get_job_post_bid_details_by_sp_id($sp_id);
    		       
    		       //echo " category_id ".$category_id;exit;
    		       //echo "<pre>";
    		       //print_r($arr_sp_details);
    		       //print_r($arr_bid_details);
    		       //echo "</pre>";
    		       //exit;
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
    		               if($bid_data['users_id'] == $sp_id) {
    		                   $arr_job_post_bids[$bid_data['post_job_id']]['sp_bid_amount'] = $bid_data['amount'];
    		                   $arr_job_post_bids[$bid_data['post_job_id']]['bid_id'] = $bid_data['id'];
    		               }
    		          }
    		       }
    		       
    		       if($category_id == 3) { // Multi Move 
		               $arr_multi_move_list = $job_post_model->get_job_post_multi_move_details($sp_id);
		               if($arr_multi_move_list != 'failure') {
		                   foreach($arr_multi_move_list as $multi_move_data) {
	                           $arr_multimove_details[$multi_move_data['booking_id']][] = array('id' => $multi_move_data['id'],
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
	                       
	                       /*echo "<pre>";
            		       print_r($arr_multimove_details);
            		       echo "</pre>";
            		       exit;*/
		               }
	                } 
    		       
    		       //Get Booking Details
    		       $arr_booking_list = $job_post_model->get_job_post_details_by_sp_id($sp_id,$category_id);
    		       
    		       $arr_response = array();
    		       $arr_booking = array();
    		       $current_date = date('Y-m-d H:i:s');
    		       
    		       //echo "<pre>";
    		       //print_r($arr_booking_list);
    		       //print_r($arr_multi_move_list);
    		       //echo "</pre>";
    		       //exit;
    		       
    		       if($arr_booking_list != 'failure') {
    		           foreach($arr_booking_list as $key => $arr_booking_details) {
        		           $status = $arr_booking_details['status'];
    		               $total_bids = (array_key_exists($arr_booking_details['post_job_id'],$arr_job_post_bids)) ? $arr_job_post_bids[$arr_booking_details['post_job_id']]['bids'] : 0;
    		               $total_bids_amount = (array_key_exists($arr_booking_details['post_job_id'],$arr_job_post_bids)) ? $arr_job_post_bids[$arr_booking_details['post_job_id']]['bid_amount'] : 0;
    		               $average_bids_amount = ($total_bids > 0) ? (string)round(($total_bids_amount/$total_bids),2) : 0;
    		               $bid_end_date = date('Y-m-d H:i:s', strtotime('+'.$arr_booking_details['bids_period'].' day', strtotime($arr_booking_details['created_dts'])));
    		               
    		               $expires_in = ($current_date < $bid_end_date) ? $this->calc_days_hrs_mins($bid_end_date,$current_date) : 0;
    		               if($expires_in <= 0) {
    		                   $bid_type = "Expired";
    		               }
    		               else {
    		                   if($arr_booking_details['sp_id'] == 0) {
        		                   $bid_type = "Open";
        		               }
        		               else {
        		                   if($arr_booking_details['sp_id'] == $sp_id) {
        		                        $bid_type = "Awarded";
        		                   }
        		                   else {
        		                       $bid_type = "Not Awarded";
        		                   }
        		               } 
    		               }
    		               
        		           $arr_booking[$key]['booking_id'] = $arr_booking_details['booking_id'];
        		           $arr_booking[$key]['post_job_id'] = $arr_booking_details['post_job_id'];
            		       $arr_booking[$key]['post_job_ref_id'] = str_pad($arr_booking_details['post_job_id'], 6, "0", STR_PAD_LEFT);
            		       $arr_booking[$key]['category_id'] = $category_id;
        		           $arr_booking[$key]['fname'] = $arr_booking_details['fname'];
    		               $arr_booking[$key]['lname'] = $arr_booking_details['lname'];
    		               $arr_booking[$key]['mobile'] = $arr_booking_details['mobile'];
    		               $arr_booking[$key]['scheduled_date'] = $arr_booking_details['scheduled_date'];
    		               $arr_booking[$key]['started_at'] = $arr_booking_details['started_at'];
    		               $arr_booking[$key]['from'] = $arr_booking_details['from'];
    		               $arr_booking[$key]['estimate_time'] = $arr_booking_details['estimate_time'];
    		               $arr_booking[$key]['estimate_type'] = $arr_booking_details['estimate_type'];
    		               $arr_booking[$key]['bid_id'] = $arr_job_post_bids[$arr_booking_details['post_job_id']]['bid_id'];
    		               $arr_booking[$key]['amount'] = $arr_job_post_bids[$arr_booking_details['post_job_id']]['sp_bid_amount'];
    		               $arr_booking[$key]['title'] = $arr_booking_details['title'];
    		               $arr_booking[$key]['bid_range_name'] = $arr_booking_details['bid_range_name'];
    		               $arr_booking[$key]['range_slots'] = $arr_booking_details['range_slots'];
    		               $arr_booking[$key]['booking_status'] = $arr_booking_details['status'];
    		               $arr_booking[$key]['bids_period'] = $arr_booking_details['bids_period']; 
    		               $arr_booking[$key]['bid_per'] = $arr_booking_details['bid_per']; //in days, 1,3,7
    		               $arr_booking[$key]['sp_id'] = $arr_booking_details['sp_id'];
    		               $arr_booking[$key]['booking_user_id'] = $arr_booking_details['booking_user_id'];
    		               $arr_booking[$key]['fcm_token'] = $arr_booking_details['fcm_token'];
    		               $arr_booking[$key]['post_created_on'] = $arr_booking_details['created_dts'];
    		               //Calculate bid end date
    		               $arr_booking[$key]['bid_end_date'] = $bid_end_date;
    		               $arr_booking[$key]['current_date'] = $current_date;
    		               $arr_booking[$key]['expires_in'] = ($current_date < $arr_booking[$key]['bid_end_date']) ? $this->calc_days_hrs_mins($arr_booking[$key]['bid_end_date'],$current_date) : "0";
    		               $arr_booking[$key]['total_bids'] = $total_bids;
    		               $arr_booking[$key]['average_bids_amount'] = $average_bids_amount;
    		               $arr_booking[$key]['bid_type'] = $bid_type;
    		               
    		                if($category_id == 1) { // Single Move 
        		               $arr_booking[$key]['job_post_description'][] = array(
                                                           'id' => $arr_booking_details['single_move_id'],
                                                           'address_id' => $arr_booking_details['address_id'],
                                                           'job_description' => $arr_booking_details['job_description'],
                                                           'locality' => $arr_booking_details['locality'],
                                                           'latitude' => $arr_booking_details['latitude'],
                                                           'longitude' => $arr_booking_details['longitude'],
                                                           'city' => $arr_booking_details['city'],
                                                           'state' => $arr_booking_details['state'],
                                                           'country' => $arr_booking_details['country'],
                                                           'zipcode' => $arr_booking_details['zipcode'],
                                                           );
    		                } 
    		                if($category_id == 2) { // Blue Collar
        		               $arr_booking[$key]['job_post_description'][] = array(
                                                           'id' => $arr_booking_details['blue_collar_id'],
                                                           'job_description' => $arr_booking_details['job_description'],
                                                           );
    		                }
    		                if($category_id == 3) { // Multi move
    		                    if(array_key_exists($arr_booking_details['booking_id'],$arr_multimove_details)) {
    		                        $arr_booking[$key]['job_post_description'] = $arr_multimove_details[$arr_booking_details['booking_id']];
    		                    }
    		                }
            		       //echo "<pre>";
            		       //print_r($arr_booking_details);
            		       //print_r($arr_response);
            		       //echo "</pre>";
            		       //exit;
    		           }
        		       return $this->respond([
        		            "job_post_details" => $arr_booking,
        		            "status" => 200,
            				"message" => "Success",
            			]);
    		       }
    		       else {
            		    return $this->respond([
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
	//---------------------------------------------------------SP Job Posts-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_sp_job_post_list()
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
            
            if(!array_key_exists('sp_id',$json) || !array_key_exists('key',$json)) {
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
    		       $job_post_model = new JobPostModel();
    		       
    		       $sp_id = $json->sp_id;
    		       
    		       $arr_bid_list = array();
    		       $arr_sp_jobs_completed = array();
    		       
    		       $category_id = 0;
    		       
    		       //Get sp details
    		       $arr_sp_details = $job_post_model->get_sp_location_details($sp_id);
    		       if($arr_sp_details != 'failure') {
    		           $category_id = $arr_sp_details[0]['category_id'];
    		           $arr_sp_keywords_id = explode(",",$arr_sp_details[0]['keywords_id']);
    		           $sp_city = $arr_sp_details[0]['city'];
    		           $sp_latitude = $arr_sp_details[0]['latitude'];
    		           $sp_longitude = $arr_sp_details[0]['longitude'];
    		       }
    		       
    		       $arr_job_post_bids = array();
    		       $arr_multimove_details = array();
    		       
    		       //Get Bids
    		       $arr_bid_details = $job_post_model->get_job_post_bid_details_by_category($sp_id,$category_id);
    		       
    		       //echo " category_id ".$category_id;exit;
    		       //echo "<pre>";
    		       //print_r($arr_sp_details);
    		       //print_r($arr_bid_details);
    		       //echo "</pre>";
    		       //exit;
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
    		       
    		       if($category_id == 3) { // Multi Move 
		               $arr_multi_move_list = $job_post_model->get_job_post_multi_move_details_by_category($category_id,$sp_id);
		               if($arr_multi_move_list != 'failure') {
		                   foreach($arr_multi_move_list as $multi_move_data) {
	                           $arr_multimove_details[$multi_move_data['booking_id']][] = array('id' => $multi_move_data['id'],
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
    		       
    		       //Get Booking Details
    		       $arr_booking_list = $job_post_model->get_job_post_list($sp_id,$category_id,$arr_sp_keywords_id,$sp_city,$sp_latitude,$sp_longitude);
    		       
    		       $arr_response = array();
    		       $arr_booking = array();
    		       $current_date = date('Y-m-d H:i:s');
    		       
    		       //echo "<pre>";
    		       //print_r($arr_booking_list);
    		       //print_r($arr_multi_move_list);
    		       //echo "</pre>";
    		       //exit;
    		       
    		       if($arr_booking_list != 'failure') {
    		           foreach($arr_booking_list as $key => $arr_booking_details) {
        		           $status = $arr_booking_details['status'];
    		               $total_bids = (array_key_exists($arr_booking_details['post_job_id'],$arr_job_post_bids)) ? $arr_job_post_bids[$arr_booking_details['post_job_id']]['bids'] : 0;
    		               $total_bids_amount = (array_key_exists($arr_booking_details['post_job_id'],$arr_job_post_bids)) ? $arr_job_post_bids[$arr_booking_details['post_job_id']]['bid_amount'] : 0;
    		               $average_bids_amount = ($total_bids > 0) ? (string)round(($total_bids_amount/$total_bids),2) : 0;
    		               $bid_end_date = date('Y-m-d H:i:s', strtotime('+'.$arr_booking_details['bids_period'].' day', strtotime($arr_booking_details['created_dts'])));
    		               
    		               $arr_booking[$key]['booking_id'] = $arr_booking_details['booking_id'];
        		           $arr_booking[$key]['post_job_id'] = $arr_booking_details['post_job_id'];
            		       $arr_booking[$key]['post_job_ref_id'] = str_pad($arr_booking_details['post_job_id'], 6, "0", STR_PAD_LEFT);
            		       $arr_booking[$key]['category_id'] = $category_id;
        		           $arr_booking[$key]['fname'] = $arr_booking_details['fname'];
    		               $arr_booking[$key]['lname'] = $arr_booking_details['lname'];
    		               $arr_booking[$key]['mobile'] = $arr_booking_details['mobile'];
    		               $arr_booking[$key]['scheduled_date'] = $arr_booking_details['scheduled_date'];
    		               $arr_booking[$key]['started_at'] = $arr_booking_details['started_at'];
    		               $arr_booking[$key]['from'] = $arr_booking_details['from'];
    		               $arr_booking[$key]['estimate_time'] = $arr_booking_details['estimate_time'];
    		               $arr_booking[$key]['estimate_type'] = $arr_booking_details['estimate_type'];
    		               $arr_booking[$key]['amount'] = 0;
    		               $arr_booking[$key]['title'] = $arr_booking_details['title'];
    		               $arr_booking[$key]['bid_range_name'] = $arr_booking_details['bid_range_name'];
    		               $arr_booking[$key]['range_slots'] = $arr_booking_details['range_slots'];
    		               $arr_booking[$key]['booking_status'] = $arr_booking_details['status'];
    		               $arr_booking[$key]['bids_period'] = $arr_booking_details['bids_period']; 
    		               $arr_booking[$key]['bid_per'] = $arr_booking_details['bid_per']; //in days, 1,3,7
    		               $arr_booking[$key]['sp_id'] = $arr_booking_details['sp_id'];
    		               $arr_booking[$key]['booking_user_id'] = $arr_booking_details['booking_user_id'];
    		               $arr_booking[$key]['fcm_token'] = $arr_booking_details['fcm_token'];
    		               $arr_booking[$key]['post_created_on'] = $arr_booking_details['created_dts'];
    		               //Calculate bid end date
    		               $arr_booking[$key]['bid_end_date'] = $arr_booking_details['bid_end_date'];
    		               $arr_booking[$key]['current_date'] = $current_date;
    		               $arr_booking[$key]['expires_in'] = ($current_date < $arr_booking[$key]['bid_end_date']) ? $this->calc_days_hrs_mins($arr_booking[$key]['bid_end_date'],$current_date) : "0";
    		               $arr_booking[$key]['total_bids'] = $total_bids;
    		               $arr_booking[$key]['average_bids_amount'] = $average_bids_amount;
    		               $arr_booking[$key]['distance_miles'] =  ($category_id == 2) ? 0 : $arr_booking_details['distance_miles'];
    		               
    		                if($category_id == 1) { // Single Move 
        		               $arr_booking[$key]['job_post_description'][] = array(
                                                           'id' => $arr_booking_details['single_move_id'],
                                                           'address_id' => $arr_booking_details['address_id'],
                                                           'job_description' => $arr_booking_details['job_description'],
                                                           'locality' => $arr_booking_details['locality'],
                                                           'latitude' => $arr_booking_details['latitude'],
                                                           'longitude' => $arr_booking_details['longitude'],
                                                           'city' => $arr_booking_details['city'],
                                                           'state' => $arr_booking_details['state'],
                                                           'country' => $arr_booking_details['country'],
                                                           'zipcode' => $arr_booking_details['zipcode'],
                                                           
                                                           );
    		                } 
    		                if($category_id == 2) { // Blue Collar
        		               $arr_booking[$key]['job_post_description'][] = array(
                                                           'id' => $arr_booking_details['blue_collar_id'],
                                                           'job_description' => $arr_booking_details['job_description'],
                                                           );
    		                }
    		                if($category_id == 3) { // Multi move
    		                    if(array_key_exists($arr_booking_details['booking_id'],$arr_multimove_details)) {
    		                        $arr_booking[$key]['job_post_description'] = $arr_multimove_details[$arr_booking_details['booking_id']];
    		                    }
    		                }
            		       //echo "<pre>";
            		       //print_r($arr_booking_details);
            		       //print_r($arr_response);
            		       //echo "</pre>";
            		       //exit;
    		           }
        		       return $this->respond([
        		            "job_post_details" => $arr_booking,
        		            "status" => 200,
            				"message" => "Success",
            			]);
    		       }
    		       else {
            		    return $this->respond([
            		        "status" => 404,
        					"message" => "No Jobs found"
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
	//---------------------------------------------------------SP post bid-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function sp_post_bid()
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
            
            if(!array_key_exists('post_job_id',$json) || !array_key_exists('booking_id',$json) || !array_key_exists('amount',$json)  || !array_key_exists('proposal',$json) 
                || !array_key_exists('bid_type',$json) || !array_key_exists('attachments',$json) || !array_key_exists('estimate_time',$json) 
                || !array_key_exists('estimate_type_id',$json) || !array_key_exists('sp_id',$json) || !array_key_exists('key',$json)
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
    		        $attachments = $json->attachments;
    		        
    		        $common = new CommonModel();
    		        $misc_model = new MiscModel();
    		        
    		        $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);
    		        $sp_name = "";
    		        $sp_id = $json->sp_id;
    		        $sp_mobile = "";
    		        $user_id = 0;
    		        $job_title = "";
    		        $points_count = 0;
    		        
    		        $arr_sp_details = $misc_model->get_sp_name_by_booking($json->booking_id);
    		        if($arr_sp_details != "failure") {
    		            $sp_name = $arr_sp_details['fname']." ".$arr_sp_details['lname'];
    		            $sp_id = $arr_sp_details['sp_id'];
    		            $sp_mobile = $arr_sp_details['mobile'];
    		            $user_id = $arr_sp_details['users_id'];
    		            $job_title = $arr_sp_details['title'];
    		            $points_count = $arr_sp_details['points_count']; 
    		        }
    		        
    		        $arr_user_details = $misc_model->get_user_name_by_booking($json->booking_id, $user_id);
        	        if($arr_user_details != "failure") {
        	            $user_name = $arr_user_details['fname']." ".$arr_user_details['lname'];
                        $user_id = $arr_user_details['users_id'];
        	            $job_title = $arr_user_details['title'];
        	            $sp_id = $arr_user_details['sp_id'];
        	            $user_mobile = $arr_user_details['mobile'];
        	        }
    		        
    		        $arr_bid_det = array(
        		        'post_job_id' => $json->post_job_id,
        		        'users_id' => $json->sp_id,
                        'amount' => $json->amount,
                        'esimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                        'proposal' => $json->proposal,
                        'attachment_count' => count($attachments),
                        'bid_type' => $json->bid_type,
                        'status_id' => 40,
                    );
                    $bid_det_id = $common->insert_records_dynamically('bid_det', $arr_bid_det);
                    
                    if ($bid_det_id > 0) {
                        //Calculate points
                        $sp_points = 1; //1 point for bid submission
                        
                        $total_points = $points_count + $sp_points;
                            
                        $arr_update_user_data = array(
    		                'points_count' => $total_points,
            		    );
                        $common->update_records_dynamically('user_details', $arr_update_user_data, 'id', $json->sp_id);
                        
                        //Insert into booking status
                        $arr_job_post_status = array(
            		        'booking_id' => $json->booking_id,
                            'status_id' => 40,
                            'created_on' => date("Y-m-d H:i:s")
                        );
                        $common->insert_records_dynamically('booking_status', $arr_job_post_status);
                        
                        //Create and save atatchments
                        if(count($attachments) > 0) {
                            foreach($attachments as $attach_key => $arr_file) {
                                foreach($arr_file as $attach_name => $file) {
                                    if ($file != null) {
                                        $image = generateDynamicImage("images/attachments",$file);
                                        
                                        $arr_post_attach = array(
                                                'file_name' => $image,
                                                'file_location' => 'images/attachments',
                                                'created_on' => date("Y-m-d H:i:s"),
                                                'bid_id' => $bid_det_id,
                                            );
                                        $common->insert_records_dynamically('post_attach', $arr_post_attach);
                                    }
                                }
                            }
                        }
                        
                        //Insert into alert_details table
        		        $arr_alerts = array(
            		          'alert_id' => 8, 
                              'description' => "You have successfully submitted a bid for job $job_title with $booking_ref_id on ".date("Y-m-d H:i:s"),
                              'action' => 1,
                              'created_on' => date("Y-m-d H:i:s"), 
                              'status' => 1,
                              'sp_id' => $sp_id,
                              'booking_id' => $json->booking_id,
                              'post_job_id' => $json->post_job_id,
                              'bid_id' => $bid_det_id,
                              'bid_sp_id' => $json->sp_id
                        );
                        $common->insert_records_dynamically('alert_details', $arr_alerts);
                        
                        //Insert into alert_details table
        		        $arr_alerts = array(
            		          'alert_id' => 8, 
                              'description' => $sp_name." has submitted a bid on post $job_title.",
                              'action' => 2,
                              'created_on' => date("Y-m-d H:i:s"), 
                              'status' => 1,
                              'users_id' => $json->sp_id,
                              'booking_id' => $json->booking_id,
                              'post_job_id' => $json->post_job_id,
                              'bid_id' => $bid_det_id,
                              'bid_sp_id' => $json->sp_id
                        );
                        $common->insert_records_dynamically('alert_details', $arr_alerts);
                        
                        //Send SMS
                        $sms_model = new SmsTemplateModel();
                        
                	 	$data = [
            				"name" => "propo_submit",
            				"mobile" => $sp_mobile,
            				"dat" => [
            					"var" => $sp_name,
            					"var1" => $job_title,
            					"var2" => "",
            				]
            			];
            			
            			$sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);
            			//Send to user
            			$data = [
            				"name" => "new_bid",
            				"mobile" => $user_mobile,
            				"dat" => [
            					"var" => $user_name,
            					"var1" => $job_title,
            					"var2" => "",
            				]
            			];
            			
            			$sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);
                        
            			return $this->respond([
            			    "post_job_id" => $json->post_job_id,
            			    "bid_det_id" => $bid_det_id,
            			    "status" => 200,
            				"message" => "Success",
            			]);
            			
            			
            		}
            		else {
            		    return $this->respond([
            		        "status" => 404,
        					"message" => "Failed to create Bid"
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
	//---------------------------------------------------------SP post bid-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function sp_edit_bid()
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
            
            if(!array_key_exists('bid_det_id',$json) || !array_key_exists('amount',$json)  || !array_key_exists('proposal',$json) 
                || !array_key_exists('bid_type',$json) || !array_key_exists('attachments',$json) || !array_key_exists('estimate_time',$json) 
                || !array_key_exists('estimate_type_id',$json) || !array_key_exists('key',$json)
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
    		        $attachments = $json->attachments;
    		        
    		        $common = new CommonModel();
    		        
    		        $bid_det_id = $json->bid_det_id;
    		        
    		        $arr_bid_det = array(
        		        'amount' => $json->amount,
                        'esimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                        'proposal' => $json->proposal,
                        'attachment_count' => count($attachments),
                        'bid_type' => $json->bid_type,
                    );
                    $common->update_records_dynamically('bid_det', $arr_bid_det, 'id', $json->bid_det_id);
                    
                    if ($bid_det_id > 0) {
                        
                        //Create and save atatchments
                        if(count($attachments) > 0) {
                            foreach($attachments as $attach_key => $arr_file) {
                                foreach($arr_file as $attach_name => $file) {
                                    if ($file != null) {
                                        $image = generateDynamicImage("images/attachments",$file);
                                        
                                        $arr_post_attach = array(
                                                'file_name' => $image,
                                                'file_location' => 'images/attachments',
                                                'created_on' => date("Y-m-d H:i:s"),
                                                'bid_id' => $bid_det_id,
                                            );
                                        $common->insert_records_dynamically('post_attach', $arr_post_attach);
                                    }
                                }
                            }
                        }
                        
            			return $this->respond([
            			    "bid_det_id" => $bid_det_id,
            			    "status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
            		        "status" => 404,
        					"message" => "Failed to update Bid"
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

    public function delete_bid_attachment()
    {
        
        $json = $this->request->getJSON();
        if(!array_key_exists('bid_attach_id',$json) || !array_key_exists('key',$json)) {
    		    return $this->respond([
        				'status' => 403,
                        'message' => 'Invalid Parameters'
        		]);
    		}
        else
        {
            $id = $this->request->getJsonVar('bid_attach_id');
            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
    		    
    		$apiconfig = new \Config\ApiConfig();
    		
        	$api_key = $apiconfig->provider_key;
    		$common = new CommonModel();
		        
		    if($key == $api_key)
        	{
                $id = $json->bid_attach_id;
                $common->delete_records_dynamically('post_attach', 'id', $id);
                
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
//--------------------------------------------------Function to calculate date time difference START------------------------------------------------------------
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
    //---------------------------------------------------------SP Booking details-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_sp_upcoming_booking_details()
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
            
            if(!array_key_exists('sp_id',$json) || !array_key_exists('key',$json)) {
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
    		       $misc_model = new MiscModel();
    		       
    		       $users_id = 0;
    		       $sp_id = $json->sp_id;
    		       
    		       //Get Single Move Booking Details
    		       $arr_single_move_booking_details = $misc_model->get_user_upcoming_single_move_booking_details($users_id,$sp_id); 
    		       
    		       $arr_booking = array();
    		       $arr_booking_response = array();
    		       
    		       if($arr_single_move_booking_details != 'failure') {
    		           foreach($arr_single_move_booking_details as $key => $book_data) {
    		               $started_at = $book_data['started_at'];
    		               $completed_at = $book_data['completed_at'];
    		               
    		               if($started_at == "" || $started_at == "0000-00-00 00:00:00") {
    		                   $status = "Pending";
    		               }
    		               else {
    		                 if($completed_at == "" || $completed_at == "0000-00-00 00:00:00") {
        		                   $status = "Inprogress";
        		             }  
        		             else {
        		                 $status = "Completed";
        		             } 
    		               }
    		               
    		               $arr_booking[$key]['booking_id'] = $book_data['id'];
    		               $arr_booking[$key]['category_id'] = $book_data['category_id'];
        		           $arr_booking[$key]['fname'] = $book_data['fname'];
    		               $arr_booking[$key]['lname'] = $book_data['lname'];
    		               $arr_booking[$key]['mobile'] = $book_data['mobile'];
    		               $arr_booking[$key]['scheduled_date'] = $book_data['scheduled_date'];
    		               $arr_booking[$key]['time_slot_id'] = $book_data['time_slot_id'];
    		               $arr_booking[$key]['started_at'] = $book_data['started_at'];
    		               $arr_booking[$key]['from'] = $book_data['from'];
    		               $arr_booking[$key]['estimate_time'] = $book_data['estimate_time'];
    		               $arr_booking[$key]['estimate_type'] = $book_data['estimate_type'];
    		               $arr_booking[$key]['amount'] = $book_data['amount'];
    		               $arr_booking[$key]['sp_id'] = $book_data['sp_id'];
    		               $arr_booking[$key]['users_id'] = $book_data['users_id'];
    		               $arr_booking[$key]['profile_pic'] = $book_data['profile_pic'];
    		               $arr_booking[$key]['booking_status'] = $status;
    		               $arr_booking[$key]['pause_status'] = ($book_data['status_id'] == 15) ? "Yes" : "No";
    		               
    		               $arr_booking[$key]['otp'] = $book_data['otp'];
    		               $arr_booking[$key]['extra_demand_total_amount'] = $book_data['extra_demand_total_amount'];
    		               $arr_booking[$key]['material_advance'] = $book_data['material_advance'];
    		               $arr_booking[$key]['technician_charges'] = $book_data['technician_charges'];
    		               $arr_booking[$key]['expenditure_incurred'] = $book_data['expenditure_incurred'];
    		               
    		               $arr_booking[$key]['details'][] = array('job_description' => $book_data['job_description'],
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
        		       //print_r($arr_booking_details);
        		       //print_r($arr_booking);
        		       //echo "</pre>";
        		       //exit;
        		   }
    		       
    		       $booking_count = (count($arr_booking) > 0) ?  count($arr_booking) : 0; //Increment the key
    		       
    		       //Get Blue Collar Booking Details
    		       $arr_blue_collar_booking_details = $misc_model->get_user_upcoming_blue_collar_booking_details($users_id,$sp_id); 
    		       
    		       if($arr_blue_collar_booking_details != 'failure') {
    		           foreach($arr_blue_collar_booking_details as $bc_book_data) {
    		               $started_at = $bc_book_data['started_at'];
    		               $completed_at = $bc_book_data['completed_at'];
    		               $status = "";
    		               if($started_at == "" || $started_at == "0000-00-00 00:00:00") {
    		                   $status = "Pending";
    		               }
    		               else {
    		                 if($completed_at == "" || $completed_at == "0000-00-00 00:00:00") {
        		                   $status = "Inprogress";
        		             }  
        		             else {
        		                 $status = "Completed";
        		             } 
    		               }
    		               
    		               $arr_booking[$booking_count]['booking_id'] = $bc_book_data['id'];
        		           $arr_booking[$booking_count]['category_id'] = $bc_book_data['category_id'];
        		           $arr_booking[$booking_count]['fname'] = $bc_book_data['fname'];
    		               $arr_booking[$booking_count]['lname'] = $bc_book_data['lname'];
    		               $arr_booking[$booking_count]['mobile'] = $bc_book_data['mobile'];
    		               $arr_booking[$booking_count]['scheduled_date'] = $bc_book_data['scheduled_date'];
    		               $arr_booking[$booking_count]['time_slot_id'] = $bc_book_data['time_slot_id'];
    		               $arr_booking[$booking_count]['started_at'] = $bc_book_data['started_at'];
    		               $arr_booking[$booking_count]['from'] = $bc_book_data['from'];
    		               $arr_booking[$booking_count]['estimate_time'] = $bc_book_data['estimate_time'];
    		               $arr_booking[$booking_count]['estimate_type'] = $bc_book_data['estimate_type'];
    		               $arr_booking[$booking_count]['amount'] = $bc_book_data['amount'];
    		               $arr_booking[$booking_count]['sp_id'] = $bc_book_data['sp_id'];
    		               $arr_booking[$booking_count]['users_id'] = $bc_book_data['users_id'];
    		               $arr_booking[$booking_count]['profile_pic'] = $bc_book_data['profile_pic'];
    		               $arr_booking[$booking_count]['booking_status'] = $status;
    		               $arr_booking[$booking_count]['pause_status'] = ($bc_book_data['status_id'] == 15) ? "Yes" : "No";
    		               $arr_booking[$booking_count]['otp'] = $bc_book_data['otp'];
    		               $arr_booking[$booking_count]['extra_demand_total_amount'] = $bc_book_data['extra_demand_total_amount'];
    		               $arr_booking[$booking_count]['material_advance'] = $bc_book_data['material_advance'];
    		               $arr_booking[$booking_count]['technician_charges'] = $bc_book_data['technician_charges'];
    		               $arr_booking[$booking_count]['expenditure_incurred'] = $bc_book_data['expenditure_incurred'];
    		               
    		               $arr_booking[$booking_count]['details'][] = array('job_description' => $bc_book_data['job_description']);
    		               
    		               $booking_count++;
    		           }
        		   }
        		   
        		   $booking_count = (count($arr_booking) > 0) ?  count($arr_booking) : 0; //Increment the key
    		       
    		       //Get Multi Move Booking Details
    		       $arr_multi_move_booking_details = $misc_model->get_user_upcoming_multi_move_booking_details($users_id,$sp_id); 
    		       
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
    		                   $started_at = $mm_book_data['started_at'];
        		               $completed_at = $mm_book_data['completed_at'];
        		               $status = "";
        		               if($started_at == "" || $started_at == "0000-00-00 00:00:00") {
        		                   $status = "Pending";
        		               }
        		               else {
        		                 if($completed_at == "" || $completed_at == "0000-00-00 00:00:00") {
            		                   $status = "Inprogress";
            		             }  
            		             else {
            		                 $status = "Completed";
            		             } 
    		                    }
    		               
        		               $arr_booking[$booking_count]['booking_id'] = $mm_book_data['id'];
            		           $arr_booking[$booking_count]['category_id'] = $mm_book_data['category_id'];
            		           $arr_booking[$booking_count]['fname'] = $mm_book_data['fname'];
        		               $arr_booking[$booking_count]['lname'] = $mm_book_data['lname'];
        		               $arr_booking[$booking_count]['mobile'] = $mm_book_data['mobile'];
        		               $arr_booking[$booking_count]['scheduled_date'] = $mm_book_data['scheduled_date'];
        		               $arr_booking[$booking_count]['time_slot_id'] = $mm_book_data['time_slot_id'];
        		               $arr_booking[$booking_count]['started_at'] = $mm_book_data['started_at'];
        		               $arr_booking[$booking_count]['from'] = $mm_book_data['from'];
        		               $arr_booking[$booking_count]['estimate_time'] = $mm_book_data['estimate_time'];
        		               $arr_booking[$booking_count]['estimate_type'] = $mm_book_data['estimate_type'];
        		               $arr_booking[$booking_count]['amount'] = $mm_book_data['amount'];
        		               $arr_booking[$booking_count]['sp_id'] = $mm_book_data['sp_id'];
        		               $arr_booking[$booking_count]['users_id'] = $mm_book_data['users_id'];
        		               $arr_booking[$booking_count]['profile_pic'] = $mm_book_data['profile_pic'];
        		               $arr_booking[$booking_count]['booking_status'] = $status;
        		               $arr_booking[$booking_count]['pause_status'] = ($mm_book_data['status_id'] == 15) ? "Yes" : "No";
        		               $arr_booking[$booking_count]['otp'] = $mm_book_data['otp'];
        		               $arr_booking[$booking_count]['extra_demand_total_amount'] = $mm_book_data['extra_demand_total_amount'];
        		               $arr_booking[$booking_count]['material_advance'] = $mm_book_data['material_advance'];
        		               $arr_booking[$booking_count]['technician_charges'] = $mm_book_data['technician_charges'];
        		               $arr_booking[$booking_count]['expenditure_incurred'] = $mm_book_data['expenditure_incurred'];
        		               
        		               foreach($arr_details[$mm_book_data['id']] as $key => $val) {
        		                   $arr_booking[$booking_count]['details'][$key] = $arr_details[$mm_book_data['id']][$key];
        		               }
        		               
        		               $arr_exists[$mm_book_data['id']] = $mm_book_data['id'];
        		               
        		               $booking_count++;
    		               }
    		           }
        		   }
        		   
        		   //echo "<pre>";
        		   //print_r($arr_booking_details);
        		   //print_r($arr_booking);
        		   //echo "</pre>";
        		   //exit;
        		   if(count($arr_booking) > 0) {
        		       return $this->respond([
        		            "booking_details" => $arr_booking,
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
}
