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

helper('Modules\User\custom');

class BookingController extends ResourceController
{

	//---------------------------------------------------------Single move booking-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function single_move_booking()
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
            
            if(!array_key_exists('scheduled_date',$json) || !array_key_exists('time_slot_from',$json)  
                || !array_key_exists('started_at',$json) || !array_key_exists('job_description',$json) 
                || !array_key_exists('address_id',$json) || !array_key_exists('temp_address_id',$json)
                || !array_key_exists('amount',$json) || !array_key_exists('sp_id',$json) || !array_key_exists('created_on',$json) 
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
    		        
    		        $otp_start = $this->get_otp_token();
        		    $arr_booking = array(
        		        'users_id' => $json->users_id,
                        'category_id' => 1,
                        'scheduled_date' => $json->scheduled_date,
                        'time_slot_id' => $time_slot_id,
                        'started_at' => "",
                        'amount' => $json->amount,
                        'sp_id' => $json->sp_id,
                        'created_on' => $json->created_on,
                        'otp_start' => $otp_start,
                        'attachment_count' => count($attachments),
                        'status_id' => 1,
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                    );
                    $booking_id = $common->insert_records_dynamically('booking', $arr_booking);
                    
                    if ($booking_id > 0) {
                        
                        $address_id = $json->address_id;
                        if($address_id == 0 && $json->temp_address_id > 0 ) {
                            //Insert into address table
                            $arr_temp_address = $common->get_details_dynamically('user_temp_address', 'id', $json->temp_address_id);
                            
                            if($arr_temp_address != 'failure') {
                                $data_address = [
                                    'users_id' => $json->users_id,
                                    'name' => "",
                                    'flat_no' => "",
                                    'apartment_name' => "",
                                    'landmark' => "",
                                    'locality' => $arr_temp_address[0]['locality'],
                                    'latitude' => $arr_temp_address[0]['latitude'],
                                    'longitude' => $arr_temp_address[0]['longitude'],
                                    'city_id' => $arr_temp_address[0]['city_id'],
                                    'state_id' => $arr_temp_address[0]['state_id'],
                                    'country_id' => $arr_temp_address[0]['country_id'],
                                    'zipcode_id' => $arr_temp_address[0]['zipcode_id'],
                                ];
                                
                                $address_id = $common->insert_records_dynamically('address', $data_address);
                                if($address_id > 0) {
                                    //Delete temp address
                                    $common->delete_records_dynamically('user_temp_address', 'id', $json->temp_address_id);
                                }
                            }
                        }
                        
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
                        $arr_booking_status = array(
            		        'booking_id' => $booking_id,
                            'status_id' => 1,
                            'created_on' => $json->created_on
                        );
                        $common->insert_records_dynamically('booking_status', $arr_booking_status);
                    
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
            			    "booking_id" => $booking_id,
            			    "booking_ref_id" => str_pad($booking_id, 6, "0", STR_PAD_LEFT),
            				"status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to create Booking"
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
	
	//---------------------------------------------------------Blue Collar booking-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function blue_collar_booking()
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
            
            if(!array_key_exists('scheduled_date',$json) || !array_key_exists('time_slot_from',$json)  
                || !array_key_exists('started_at',$json) || !array_key_exists('job_description',$json) 
                || !array_key_exists('amount',$json) || !array_key_exists('sp_id',$json) || !array_key_exists('created_on',$json) 
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
    		        
    		        $otp_start = $this->get_otp_token();
        		    $arr_booking = array(
        		        'users_id' => $json->users_id,
                        'category_id' => 2,
                        'scheduled_date' => $json->scheduled_date,
                        'time_slot_id' => $time_slot_id,
                        'started_at' => "",
                        'amount' => $json->amount,
                        'sp_id' => $json->sp_id,
                        'created_on' => $json->created_on,
                        'otp_start' => $otp_start,
                        'attachment_count' => count($attachments),
                        'status_id' => 1,
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                    );
                    $booking_id = $common->insert_records_dynamically('booking', $arr_booking);
                    
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
                        $arr_booking_status = array(
            		        'booking_id' => $booking_id,
                            'status_id' => 1,
                            'created_on' => $json->created_on
                        );
                        $common->insert_records_dynamically('booking_status', $arr_booking_status);
                    
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
            			    "booking_id" => $booking_id,
            			    "booking_ref_id" => str_pad($booking_id, 6, "0", STR_PAD_LEFT),
            				"status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to create Booking"
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
	//---------------------------------------------------------Multi Move booking-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function multi_move_booking()
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
                || !array_key_exists('started_at',$json) || !array_key_exists('addresses',$json) 
                || !array_key_exists('amount',$json) || !array_key_exists('sp_id',$json) || !array_key_exists('created_on',$json) 
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
    		        
    		        $otp_start = $this->get_otp_token();
        		    $arr_booking = array(
        		        'users_id' => $json->users_id,
                        'category_id' => 3,
                        'scheduled_date' => $json->scheduled_date,
                        'time_slot_id' => $time_slot_id,
                        'started_at' => "",
                        'amount' => $json->amount,
                        'sp_id' => $json->sp_id,
                        'created_on' => $json->created_on,
                        'otp_start' => $otp_start,
                        'attachment_count' => count($attachments),
                        'status_id' => 1,
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                    );
                    $booking_id = $common->insert_records_dynamically('booking', $arr_booking);
                    
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
                        $arr_booking_status = array(
            		        'booking_id' => $booking_id,
                            'status_id' => 1,
                            'created_on' => $json->created_on
                        );
                        $common->insert_records_dynamically('booking_status', $arr_booking_status);
                    
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
            			    "booking_id" => $booking_id,
            			    "booking_ref_id" => str_pad($booking_id, 6, "0", STR_PAD_LEFT),
            				"status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to create Booking"
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
	//---------------------------------------------------------Booking Payments-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function booking_payments()
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
            
            if(!array_key_exists('booking_id',$json) || !array_key_exists('date',$json) || !array_key_exists('amount',$json) 
                || !array_key_exists('reference_id',$json) || !array_key_exists('payment_status',$json) 
                || !array_key_exists('time_slot_from',$json) || !array_key_exists('sp_id',$json)  
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
        		          'name_id' => 2, //Booking Amount
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
                    
                    if($transaction_id > 0) { //Insert into Booking Payments/booking_receipts
                        if($json->payment_status == 'Success') {
                            $arr_booking_payments_ins = array(
                		          'booking_id' => $json->booking_id,
                                  'transaction_id' => $transaction_id, 
                            );
                            //Insert into booking_receipts
                            $common->insert_records_dynamically('booking_receipts', $arr_booking_payments_ins);
                            
                            //Insert into sp_busy_slot
                            //Get master time slot
                            $arr_time_slots = array();
                            $arr_time_slot_details = $common->get_table_details_dynamically('time_slot', 'id', 'ASC');
            		        if($arr_time_slot_details != 'failure') {
            		            foreach($arr_time_slot_details as $time_data) {
            		                $arr_time_slots[$time_data['from']] = $time_data['id'];
            		            }
            		        }
            		        $time_slot_id = $arr_time_slots[$json->time_slot_from];
            		        
            		        if($time_slot_id > 0) {
            		            $arr_sp_busy_slot_ins = array(
                    		          'users_id' => $json->sp_id,
                                      'date' => $json->date,
                                      'time_slot_id' => $time_slot_id,
                                      'booking_id' => $json->booking_id,
                                      
                                );
                		        //Insert into booking_payments
                                $sp_busy_slot_id = $common->insert_records_dynamically('sp_busy_slot', $arr_sp_busy_slot_ins);
                            }
            		        else {
                    		    return $this->respond([
                					"status" => 404,
                					"message" => "Incorrect time format"
                				]);
                    		}
                        }
                        //Update booking and booking status
                        //Insert into booking status
                        $arr_booking_status = array(
            		        'booking_id' => $json->booking_id,
                            'status_id' => ($json->payment_status == 'Success') ? 8 : 30,
                        );
                        $common->insert_records_dynamically('booking_status', $arr_booking_status);
                        
        		        //Updatebooking
        		        $arr_booking = array(
            		        'status_id' => ($json->payment_status == 'Success') ? 8 : 30,
                        );
        		        $common->update_records_dynamically('booking', $arr_booking, 'id', $json->booking_id);
        		        
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
	//---------------------------------------------------------Booking details-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_booking_details()
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
            
            if(!array_key_exists('booking_id',$json) || !array_key_exists('category_id',$json) || !array_key_exists('users_id',$json) || !array_key_exists('key',$json)) {
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
    		       
    		       $category_id = $json->category_id;
    		       $booking_id = $json->booking_id;
    		       $users_id = $json->users_id;
    		       
    		       //Get Booking Details
    		       $arr_booking_details = $misc_model->get_booking_details($booking_id,$users_id); 
    		       
    		       $arr_response = array();
    		       $arr_booking = array();
    		       
    		       if($arr_booking_details != 'failure') {
    		           $arr_booking['fname'] = $arr_booking_details['fname'];
		               $arr_booking['lname'] = $arr_booking_details['lname'];
		               $arr_booking['mobile'] = $arr_booking_details['mobile'];
		               $arr_booking['scheduled_date'] = $arr_booking_details['scheduled_date'];
		               $arr_booking['started_at'] = $arr_booking_details['started_at'];
		               $arr_booking['from'] = $arr_booking_details['from'];
		               $arr_booking['estimate_time'] = $arr_booking_details['estimate_time'];
		               $arr_booking['estimate_type'] = $arr_booking_details['estimate_type'];
		               $arr_booking['amount'] = $arr_booking_details['amount'];
		               $arr_booking['sp_id'] = $arr_booking_details['sp_id'];
		               $arr_booking['fcm_token'] = $arr_booking_details['fcm_token'];
		               
		               $attachment_count = $arr_booking_details['attachment_count'];
		               
		               $arr_attachments = array();
		               $arr_job_details = array();
		               
		               if($attachment_count > 0) {
		                   $arr_attachment_details = $misc_model->get_attachment_details($booking_id);
		                   if($arr_attachment_details != 'failure') {
		                       foreach($arr_attachment_details as $attach_data) {
		                           $arr_attachments[] = array('file_name' => $attach_data['file_name'],'file_location' => $attach_data['file_location']);
		                       }
		                   }     
		               }
		               
    		           if($category_id == 1) { // Single Move 
        		            $arr_single_move_details = $misc_model->get_single_move_details($booking_id); 
        		            if($arr_single_move_details != 'failure') {
		                       foreach($arr_single_move_details as $single_move_data) {
		                           $arr_job_details[] = array('job_description' => $single_move_data['job_description'],
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
		                           $arr_job_details[] = array('sequence_no' => $multi_move_data['sequence_no'],
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
        		            "booking_details" => $arr_booking,
        		            "attachments" => $arr_attachments,
        		            "job_details" => $arr_job_details,
            			    "status" => 200,
            				"message" => "Success",
            			]);
    		       }
    		       else {
            		    return $this->respond([
            		        "booking_id" => $booking_id,
        					"status" => 404,
        					"message" => "Invalid Booking"
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
	//---------------------------------------------------------User Booking details-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_user_booking_details()
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
    		       
    		       $users_id = $json->users_id;
    		       
    		       //Get Single Move Booking Details
    		       $arr_single_move_booking_details = $misc_model->get_user_single_move_booking_details($users_id); 
    		       
    		       $arr_booking = array();
    		       $arr_booking_response = array();
    		       
    		       if($arr_single_move_booking_details != 'failure') {
    		           foreach($arr_single_move_booking_details as $key => $book_data) {
    		               $started_at = $book_data['started_at'];
    		               $completed_at = $book_data['completed_at'];
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
    		               
    		               $arr_booking[$key]['booking_id'] = $book_data['id'];
        		           $arr_booking[$key]['category_id'] = $book_data['category_id'];
        		           $arr_booking[$key]['fname'] = $book_data['fname'];
    		               $arr_booking[$key]['lname'] = $book_data['lname'];
    		               $arr_booking[$key]['mobile'] = $book_data['mobile'];
    		               $arr_booking[$key]['scheduled_date'] = $book_data['scheduled_date'];
    		               $arr_booking[$key]['started_at'] = $book_data['started_at'];
    		               $arr_booking[$key]['from'] = $book_data['from'];
    		               $arr_booking[$key]['estimate_time'] = $book_data['estimate_time'];
    		               $arr_booking[$key]['estimate_type'] = $book_data['estimate_type'];
    		               $arr_booking[$key]['amount'] = $book_data['amount'];
    		               $arr_booking[$key]['sp_id'] = $book_data['sp_id'];
    		               $arr_booking[$key]['profile_pic'] = $book_data['profile_pic'];
    		               /*$arr_booking[$key]['job_description'] = $book_data['job_description'];
        		           $arr_booking[$key]['locality'] = $book_data['locality'];
    		               $arr_booking[$key]['latitude'] = $book_data['latitude'];
    		               $arr_booking[$key]['longitude'] = $book_data['longitude'];
    		               $arr_booking[$key]['city'] = $book_data['city'];
        		           $arr_booking[$key]['state'] = $book_data['state'];
    		               $arr_booking[$key]['country'] = $book_data['country'];
    		               $arr_booking[$key]['zipcode'] = $book_data['zipcode'];*/
    		               $arr_booking[$key]['booking_status'] = $status;
    		               
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
    		       $arr_blue_collar_booking_details = $misc_model->get_user_blue_collar_booking_details($users_id); 
    		       
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
    		               $arr_booking[$booking_count]['started_at'] = $bc_book_data['started_at'];
    		               $arr_booking[$booking_count]['from'] = $bc_book_data['from'];
    		               $arr_booking[$booking_count]['estimate_time'] = $bc_book_data['estimate_time'];
    		               $arr_booking[$booking_count]['estimate_type'] = $bc_book_data['estimate_type'];
    		               $arr_booking[$booking_count]['amount'] = $bc_book_data['amount'];
    		               $arr_booking[$booking_count]['sp_id'] = $bc_book_data['sp_id'];
    		               $arr_booking[$booking_count]['profile_pic'] = $bc_book_data['profile_pic'];
    		               /*$arr_booking[$booking_count]['job_description'] = $bc_book_data['job_description'];
        		           $arr_booking[$booking_count]['locality'] = '';
    		               $arr_booking[$booking_count]['latitude'] = '';
    		               $arr_booking[$booking_count]['longitude'] = '';
    		               $arr_booking[$booking_count]['city'] = '';
        		           $arr_booking[$booking_count]['state'] = '';
    		               $arr_booking[$booking_count]['country'] = '';
    		               $arr_booking[$booking_count]['zipcode'] = '';*/
    		               $arr_booking[$booking_count]['booking_status'] = $status;
    		               
    		               $arr_booking[$booking_count]['details'][] = array('job_description' => $bc_book_data['job_description']);
    		               
    		               $booking_count++;
    		           }
        		   }
        		   
        		   $booking_count = (count($arr_booking) > 0) ?  count($arr_booking) : 0; //Increment the key
    		       
    		       //Get Multi Move Booking Details
    		       $arr_multi_move_booking_details = $misc_model->get_user_multi_move_booking_details($users_id); 
    		       
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
        		               $arr_booking[$booking_count]['started_at'] = $mm_book_data['started_at'];
        		               $arr_booking[$booking_count]['from'] = $mm_book_data['from'];
        		               $arr_booking[$booking_count]['estimate_time'] = $mm_book_data['estimate_time'];
        		               $arr_booking[$booking_count]['estimate_type'] = $mm_book_data['estimate_type'];
        		               $arr_booking[$booking_count]['amount'] = $mm_book_data['amount'];
        		               $arr_booking[$booking_count]['sp_id'] = $mm_book_data['sp_id'];
        		               $arr_booking[$booking_count]['profile_pic'] = $mm_book_data['profile_pic'];
        		               $arr_booking[$booking_count]['booking_status'] = $status;
        		               
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
	//---------------------------------------------------------API to capture SP response - Accept/Reject-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function sp_booking_response()
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
            
            if(!array_key_exists('booking_id',$json) || !array_key_exists('status_id',$json)  
                || !array_key_exists('amount',$json) || !array_key_exists('sp_id',$json) || !array_key_exists('created_on',$json)
                || !array_key_exists('description',$json) || !array_key_exists('key',$json)
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
    		        
    		        $booking_id = $json->booking_id;
    		        $sp_id = $json->sp_id;
    		        $status_id = $json->status_id;
    		        $description = $json->description;
    		        
    		        if ($booking_id > 0) {
                        
                        if($status_id == 5) { //'accept'
        		            $arr_booking_update = array(
                		        'amount' => $json->amount,
                                'sp_id' => $json->sp_id,
                                'status_id' => $status_id,
                            );
        		        }
        		        else { //'reject'
        		            $arr_booking_update = array(
                		        'status_id' => $status_id,
                            );
        		        }
        		        
        		        $common->update_records_dynamically('booking', $arr_booking_update, 'id', $booking_id);
                        
                        //Insert into booking status
                        $arr_booking_status = array(
            		        'booking_id' => $booking_id,
                            'status_id' => $status_id,
                            'sp_id' => $sp_id,
                            'description' => $description,
                            'created_on' => $json->created_on
                        );
                        $common->insert_records_dynamically('booking_status', $arr_booking_status);
                    
                        return $this->respond([
            			    "booking_id" => $booking_id,
            				"status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to update status"
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
	
	public function get_otp_token($length = 4) {
        return rand(
            ((int) str_pad(1, $length, 0, STR_PAD_RIGHT)),
            ((int) str_pad(9, $length, 9, STR_PAD_RIGHT))
        );
    }
}
