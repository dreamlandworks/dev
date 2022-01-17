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
use Modules\User\Models\SmsTemplateModel;

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
                || !array_key_exists('city',$json) 
                || !array_key_exists('state',$json) || !array_key_exists('country',$json) || !array_key_exists('postal_code',$json) 
                || !array_key_exists('address',$json) || !array_key_exists('user_lat',$json) || !array_key_exists('user_long',$json)
                || !array_key_exists('amount',$json) || !array_key_exists('sp_id',$json) || !array_key_exists('created_on',$json) 
                || !array_key_exists('attachments',$json) || !array_key_exists('estimate_time',$json) || !array_key_exists('estimate_type_id',$json)
                || !array_key_exists('users_id',$json) || !array_key_exists('key',$json) || $json->users_id == $json->sp_id
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
    		        
    		        $arr_booking = array(
        		        'users_id' => $json->users_id,
                        'category_id' => 1,
                        'scheduled_date' => $json->scheduled_date,
                        'time_slot_id' => $time_slot_id,
                        'started_at' => "",
                        'amount' => $json->amount,
                        'sp_id' => $json->sp_id,
                        'created_on' => $json->created_on,
                        'attachment_count' => count($attachments),
                        'status_id' => 1,
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                    );
                    $booking_id = $common->insert_records_dynamically('booking', $arr_booking);
                    
                    if ($booking_id > 0) {
                        
                        $address_id = $json->address_id;
                        if($address_id == 0) {
                            //Insert into address table
                            
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
                            $data_address = [
                                'users_id' => $json->users_id,
                                'name' => "",
                                'flat_no' => "",
                                'apartment_name' => "",
                                'landmark' => "",
                                'locality' => $json->address,
                                'latitude' => $json->user_lat,
                                'longitude' => $json->user_long,
                                'city_id' => $city_id,
                                'state_id' => $state_id,
                                'country_id' => $country_id,
                                'zipcode_id' => $zip_id,
                            ];
                            
                            $address_id = $common->insert_records_dynamically('address', $data_address);
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
                                    $pos = strpos($file, 'firebasestorage');
                                    
                                    if ($pos !== false) { //URL
                                        $url = $file;
    
                                        list($path,$token) = explode('?',$url);
                                        
                                        $type = pathinfo($path, PATHINFO_EXTENSION);
                                        $data = file_get_contents($url);
                                        $base64_file = base64_encode($data);
                                        
                                        $file = $base64_file;
                                    }
                                    else {
                                        $type = "png";
                                    }
                                    
                                    $image = generateDynamicImage("images/attachments",$file,$type);
                                        
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
                        
                        $otp = $this->get_otp_token();
            		    $booking_ref_id = str_pad($booking_id, 6, "0", STR_PAD_LEFT);
            		    $users_id = $json->users_id;
            		    
            		    //Insert into alert_details table
        		        $arr_alerts = array(
            		          'alert_id' => 1, 
                              'description' => "Your OTP to Start Booking $booking_ref_id is $otp. Please provide it to your service provider to start booking.",
                              'action' => 1,
                              'created_on' => date("Y-m-d H:i:s"), 
                              'status' => 1,
                              'users_id' => $users_id,
                        );
                        $common->insert_records_dynamically('alert_details', $arr_alerts);
            		    
            		    $arr_booking_update = array(
                            'otp' => $otp,
                            'otp_raised_by' => $users_id
            		    );
            		    /*echo "<pre>";
            		    print_r($arr_booking_update);
            		    echo "</pre>";
            		    exit;*/
            		    $common->update_records_dynamically('booking', $arr_booking_update, 'id', $booking_id);
                        
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
    		        
    		        $arr_booking = array(
        		        'users_id' => $json->users_id,
                        'category_id' => 2,
                        'scheduled_date' => $json->scheduled_date,
                        'time_slot_id' => $time_slot_id,
                        'started_at' => "",
                        'amount' => $json->amount,
                        'sp_id' => $json->sp_id,
                        'created_on' => $json->created_on,
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
                                    $pos = strpos($file, 'firebasestorage');
                                    
                                    if ($pos !== false) { //URL
                                        $url = $file;
    
                                        list($path,$token) = explode('?',$url);
                                        
                                        $type = pathinfo($path, PATHINFO_EXTENSION);
                                        $data = file_get_contents($url);
                                        $base64_file = base64_encode($data);
                                        
                                        $file = $base64_file;
                                    }
                                    else {
                                        $type = "png";
                                    }
                                    
                                    $image = generateDynamicImage("images/attachments",$file,$type);
                                        
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
                        
                        $otp = $this->get_otp_token();
            		    $booking_ref_id = str_pad($booking_id, 6, "0", STR_PAD_LEFT);
            		    $users_id = $json->users_id;
            		    
            		    //Insert into alert_details table
        		        $arr_alerts = array(
            		          'alert_id' => 1, 
                              'description' => "Your OTP to Start Booking $booking_ref_id is $otp. Please provide it to your service provider to start booking.",
                              'action' => 1,
                              'created_on' => date("Y-m-d H:i:s"), 
                              'status' => 1,
                              'users_id' => $users_id,
                        );
                        $common->insert_records_dynamically('alert_details', $arr_alerts);
            		    
            		    $arr_booking_update = array(
                            'otp' => $otp,
            		    );
            		    /*echo "<pre>";
            		    print_r($arr_booking_update);
            		    echo "</pre>";
            		    exit;*/
            		    $common->update_records_dynamically('booking', $arr_booking_update, 'id', $booking_id);
                        
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
    		        
    		        $arr_booking = array(
        		        'users_id' => $json->users_id,
                        'category_id' => 3,
                        'scheduled_date' => $json->scheduled_date,
                        'time_slot_id' => $time_slot_id,
                        'started_at' => "",
                        'amount' => $json->amount,
                        'sp_id' => $json->sp_id,
                        'created_on' => $json->created_on,
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
                                //Check if existing address is given if not create a new one.
                                $address_id = $arr_address->address_id;
                                if($address_id == 0) {
                                    //Insert into address table
                                    
                                    $city = $arr_address->city;
                            
                                    $zip_model = new ZipcodeModel();
                                    $city_model = new CityModel();
                                    $state_model = new StateModel();
                                    $country_model = new CountryModel();
                                    
                                    $country_id = $country_model->search_by_country($arr_address->country);
                    		        $state_id = $state_model->search_by_state($arr_address->state);
                    		        $city_id = $city_model->search_by_city($arr_address->city);
                    		        $zip_id = $zip_model->search_by_zipcode($arr_address->postal_code);
                        
                                    if ($country_id == 0) {
                                        $country_id = $country_model->create_country($arr_address->country);
                                    }
                    		        if ($state_id == 0) {
                                        $state_id = $state_model->create_state($arr_address->state, $country_id);
                                    }
                    		        if ($city_id == 0) {
                    		            $city_id = $city_model->create_city($arr_address->city, $state_id);
                                    }
                                    if ($zip_id == 0) {
                                        $zip_id = $zip_model->create_zip($arr_address->postal_code, $city_id);
                                    }
                                    //JSON Objects declared into variables
                                    $data_address = [
                                        'users_id' => $json->users_id,
                                        'name' => "",
                                        'flat_no' => "",
                                        'apartment_name' => "",
                                        'landmark' => "",
                                        'locality' => $arr_address->address,
                                        'latitude' => $arr_address->user_lat,
                                        'longitude' => $arr_address->user_long,
                                        'city_id' => $city_id,
                                        'state_id' => $state_id,
                                        'country_id' => $country_id,
                                        'zipcode_id' => $zip_id,
                                    ];
                                    
                                    $address_id = $common->insert_records_dynamically('address', $data_address);
                                }
                                
                                //Insert into multi_move table
                                $arr_multi_move[] = array(
                                        'booking_id' => $booking_id,
                                        'sequence_no' => $arr_address->sequence_no,
                                        'address_id' => $address_id,
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
                                    $pos = strpos($file, 'firebasestorage');
                                    
                                    if ($pos !== false) { //URL
                                        $url = $file;
    
                                        list($path,$token) = explode('?',$url);
                                        
                                        $type = pathinfo($path, PATHINFO_EXTENSION);
                                        $data = file_get_contents($url);
                                        $base64_file = base64_encode($data);
                                        
                                        $file = $base64_file;
                                    }
                                    else {
                                        $type = "png";
                                    }
                                    
                                    $image = generateDynamicImage("images/attachments",$file,$type);
                                        
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
                        
                        $otp = $this->get_otp_token();
            		    $booking_ref_id = str_pad($booking_id, 6, "0", STR_PAD_LEFT);
            		    $users_id = $json->users_id;
            		    
            		    //Insert into alert_details table
        		        $arr_alerts = array(
            		          'alert_id' => 1, 
                              'description' => "Your OTP to Start Booking $booking_ref_id is $otp. Please provide it to your service provider to start booking.",
                              'action' => 1,
                              'created_on' => date("Y-m-d H:i:s"), 
                              'status' => 1,
                              'users_id' => $users_id,
                        );
                        $common->insert_records_dynamically('alert_details', $arr_alerts);
            		    
            		    $arr_booking_update = array(
                            'otp' => $otp,
            		    );
            		    /*echo "<pre>";
            		    print_r($arr_booking_update);
            		    echo "</pre>";
            		    exit;*/
            		    $common->update_records_dynamically('booking', $arr_booking_update, 'id', $booking_id);
                        
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
                            
                            //Make entry in to wallet for users payment
                            //Check if the wallet is created
                            /*$arr_wallet_details = $common->get_details_dynamically('wallet_balance', 'users_id', $json->users_id);
            		        if($arr_wallet_details != 'failure') {
            		            //Get total amount and blocked amount
            		            $wallet_amount = $arr_wallet_details[0]['amount'] + $json->amount;
            		            $wallet_amount_blocked = $arr_wallet_details[0]['amount_blocked'] + $json->amount;
            		            
            		            $arr_update_wallet_data = array(
            		                'amount' => $wallet_amount,
                    		        'amount_blocked' => $wallet_amount_blocked
                                );
                                $common->update_records_dynamically('wallet_balance', $arr_update_wallet_data, 'users_id', $json->users_id);
            		        }
            		        else {
            		            $arr_wallet_data = array(
            		                'users_id' => $json->users_id,
                    		        'amount' => $json->amount,
                    		        'amount_blocked' => $json->amount
                                );
                                $common->insert_records_dynamically('wallet_balance', $arr_wallet_data);
            		        }*/
            		        
            		        //Make entry in to wallet for sp payment
                            //Check if the wallet is created
                            $arr_wallet_details = $common->get_details_dynamically('wallet_balance', 'users_id', $json->sp_id);
            		        if($arr_wallet_details != 'failure') {
            		            //Get total amount and blocked amount
            		            $wallet_amount = $arr_wallet_details[0]['amount'] + $json->amount;
            		            $wallet_amount_blocked = $arr_wallet_details[0]['amount_blocked'] + $json->amount;
            		            
            		            $arr_update_wallet_data = array(
            		                'amount' => $wallet_amount,
                    		        'amount_blocked' => $wallet_amount_blocked
                                );
                                $common->update_records_dynamically('wallet_balance', $arr_update_wallet_data, 'users_id', $json->sp_id);
            		        }
            		        else {
            		            $arr_wallet_data = array(
            		                'users_id' => $json->sp_id,
                    		        'amount' => $json->amount,
                    		        'amount_blocked' => $json->amount
                                );
                                $common->insert_records_dynamically('wallet_balance', $arr_wallet_data);
            		        }
            		        
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
    		           $started_at = $arr_booking_details['started_at'];
		               $completed_at = $arr_booking_details['completed_at'];
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
		               
		               $reschedule_status = "";
		               if($arr_booking_details['reschedule_status_id'] == 11) {
		                   $reschedule_status = "Reschedule Rejected";
		               }
		               else if($arr_booking_details['reschedule_status_id'] == 12) {
		                   $reschedule_status = "Reschedule Accepted";
		               }
    		               
    		           $arr_booking['booking_id'] = $booking_id;
    		           $arr_booking['fname'] = $arr_booking_details['fname'];
		               $arr_booking['lname'] = $arr_booking_details['lname'];
		               $arr_booking['mobile'] = $arr_booking_details['mobile'];
		               $arr_booking['scheduled_date'] = $arr_booking_details['scheduled_date'];
		               $arr_booking['time_slot_id'] = $arr_booking_details['time_slot_id'];
		               $arr_booking['started_at'] = $arr_booking_details['started_at'];
		               $arr_booking['from'] = $arr_booking_details['from'];
		               $arr_booking['estimate_time'] = $arr_booking_details['estimate_time'];
		               $arr_booking['estimate_type'] = $arr_booking_details['estimate_type'];
		               $arr_booking['amount'] = $arr_booking_details['amount'];
		               $arr_booking['sp_id'] = $arr_booking_details['sp_id'];
		               $arr_booking['fcm_token'] = $arr_booking_details['fcm_token'];
		               $arr_booking['otp'] = $arr_booking_details['otp'];
		               $arr_booking['booking_status'] = $status;
		               $arr_booking['extra_demand_total_amount'] = ($arr_booking_details['extra_demand_total_amount'] > 0) ? $arr_booking_details['extra_demand_total_amount'] : 0;
		               $arr_booking['material_advance'] = ($arr_booking_details['material_advance'] > 0) ? $arr_booking_details['material_advance'] : 0;
		               $arr_booking['technician_charges'] = ($arr_booking_details['technician_charges'] > 0) ? $arr_booking_details['technician_charges'] : 0;
		               $arr_booking['expenditure_incurred'] = ($arr_booking_details['expenditure_incurred'] > 0) ? $arr_booking_details['expenditure_incurred'] : 0;
		               $arr_booking['extra_demand_status'] = ($arr_booking_details['extra_demand_status'] != "") ? $arr_booking_details['extra_demand_status'] : 0;
		               $arr_booking['post_job_id'] = ($arr_booking_details['post_job_id'] > 0) ? $arr_booking_details['post_job_id'] : 0;
		               $arr_booking['reschedule_status'] = $reschedule_status;
		               $arr_booking['otp_raised_by'] = $arr_booking_details['otp_raised_by'];
		               
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
    		       $common = new CommonModel();
    		       
    		       $users_id = $json->users_id;
    		       
    		       $current_date = date('Y-m-d H:i:s');
    		       
    		       $arr_user_details = $common->get_details_dynamically('users', 'users_id', $users_id);
    		       if($arr_user_details != 'failure') {
    		           $user_fcm_token = $arr_user_details[0]['fcm_token'];
    		       }
    		       
    	           //Get Single Move Booking Details
    		       $arr_single_move_booking_details = $misc_model->get_user_single_move_booking_details($users_id); 
    		       
    		       $arr_booking = array();
    		       $arr_booking_response = array();
    		       
    		       if($arr_single_move_booking_details != 'failure') {
    		           foreach($arr_single_move_booking_details as $key => $book_data) {
    		               $started_at = $book_data['started_at'];
    		               $completed_at = $book_data['completed_at'];
    		               $scheduled_date = $book_data['scheduled_date']." ".$book_data['from'];
    		               $booking_end_date = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($scheduled_date)));
    		               $current_date_time = date('Y-m-d H:i:s');
    		               $remaining_days = 0; 
		                   $remaining_hours = 0;
		                   $remaining_minutes = 0;
    		               
    		               if($current_date_time < $scheduled_date) {
    		                   $dateDiff = intval((strtotime($scheduled_date) - strtotime($current_date_time)) / 60);
    		                   $remaining_days = intval($dateDiff/(60*24)); 
    		                   $remaining_hours = intval($dateDiff / 60);
    		                   $remaining_minutes = $dateDiff % 60;
    		               }
    		               
                           $status_id = $book_data['status_id'];
    		               
    		               $status = "";
    		               
    		               if($status_id == '24' || $status_id == '25') { //Cancelled by user/sp
    		                   $status = "Cancelled";
    		               }
    		               else if($started_at == "0000-00-00 00:00:00" && $current_date > $booking_end_date){
    		                    $status = "Expired";
    		               }
    		               else {
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
    		               $arr_booking[$key]['otp'] = $book_data['otp'];
    		               $arr_booking[$key]['extra_demand_total_amount'] = $book_data['extra_demand_total_amount'];
    		               $arr_booking[$key]['material_advance'] = $book_data['material_advance'];
    		               $arr_booking[$key]['technician_charges'] = $book_data['technician_charges'];
    		               $arr_booking[$key]['expenditure_incurred'] = $book_data['expenditure_incurred'];
    		               $arr_booking[$key]['booking_end_date'] = $booking_end_date;
    		               $arr_booking[$key]['remaining_days_to_start'] = $remaining_days;
    		               $arr_booking[$key]['remaining_hours_to_start'] = $remaining_hours;
    		               $arr_booking[$key]['remaining_minutes_to_start'] = $remaining_minutes;
    		               $arr_booking[$key]['sp_fcm_token'] = $book_data['fcm_token'];
    		               $arr_booking[$key]['user_fcm_token'] = $user_fcm_token;
    		               
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
    		               
    		               $scheduled_date = $bc_book_data['scheduled_date']." ".$bc_book_data['from'];
    		               $booking_end_date = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($scheduled_date)));
    		               $current_date_time = date('Y-m-d H:i:s');
    		               $remaining_days = 0; 
		                   $remaining_hours = 0;
		                   $remaining_minutes = 0;
    		               
    		               if($current_date_time < $scheduled_date) {
    		                   $dateDiff = intval((strtotime($scheduled_date) - strtotime($current_date_time)) / 60);
    		                   $remaining_days = intval($dateDiff/(60*24)); 
    		                   $remaining_hours = intval($dateDiff / 60);
    		                   $remaining_minutes = $dateDiff % 60;
    		               }
    		               $status_id = $bc_book_data['status_id'];
    		               
    		               $status = "";
    		               
    		               if($status_id == '24' || $status_id == '25') { //Cancelled by user/sp
    		                   $status = "Cancelled";
    		               }
    		               else if($started_at == "0000-00-00 00:00:00" && $current_date > $booking_end_date){
        		                    $status = "Expired";
    		               }
    		               else {
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
    		               $arr_booking[$booking_count]['profile_pic'] = $bc_book_data['profile_pic'];
    		               $arr_booking[$booking_count]['booking_status'] = $status;
    		               $arr_booking[$booking_count]['otp'] = $bc_book_data['otp'];
    		               $arr_booking[$booking_count]['extra_demand_total_amount'] = $bc_book_data['extra_demand_total_amount'];
    		               $arr_booking[$booking_count]['material_advance'] = $bc_book_data['material_advance'];
    		               $arr_booking[$booking_count]['technician_charges'] = $bc_book_data['technician_charges'];
    		               $arr_booking[$booking_count]['expenditure_incurred'] = $bc_book_data['expenditure_incurred'];
    		               $arr_booking[$booking_count]['booking_end_date'] = $booking_end_date;
    		               $arr_booking[$booking_count]['remaining_days_to_start'] = $remaining_days;
    		               $arr_booking[$booking_count]['remaining_hours_to_start'] = $remaining_hours;
    		               $arr_booking[$booking_count]['remaining_minutes_to_start'] = $remaining_minutes;
    		               $arr_booking[$booking_count]['sp_fcm_token'] = $bc_book_data['fcm_token'];
    		               $arr_booking[$booking_count]['user_fcm_token'] = $user_fcm_token;
    		               
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
        		               $scheduled_date = $mm_book_data['scheduled_date']." ".$mm_book_data['from'];
    		                   $booking_end_date = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($scheduled_date)));
    		                   $current_date_time = date('Y-m-d H:i:s');
    		                   $remaining_days = 0; 
    		                   $remaining_hours = 0;
    		                   $remaining_minutes = 0;
        		               
        		               if($current_date_time < $scheduled_date) {
        		                   $dateDiff = intval((strtotime($scheduled_date) - strtotime($current_date_time)) / 60);
        		                   $remaining_days = intval($dateDiff/(60*24)); 
        		                   $remaining_hours = intval($dateDiff / 60);
        		                   $remaining_minutes = $dateDiff % 60;
        		               }
        		               $status_id = $mm_book_data['status_id'];
    		               
        		               $status = "";
        		               
        		               if($status_id == '24' || $status_id == '25') { //Cancelled by user/sp
        		                   $status = "Cancelled";
        		               }
        		               else if($started_at == "0000-00-00 00:00:00" && $current_date > $booking_end_date){
        		                    $status = "Expired";
        		               }
        		               else {
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
        		               $arr_booking[$booking_count]['profile_pic'] = $mm_book_data['profile_pic'];
        		               $arr_booking[$booking_count]['booking_status'] = $status;
        		               $arr_booking[$booking_count]['otp'] = $mm_book_data['otp'];
        		               $arr_booking[$booking_count]['extra_demand_total_amount'] = $mm_book_data['extra_demand_total_amount'];
        		               $arr_booking[$booking_count]['material_advance'] = $mm_book_data['material_advance'];
        		               $arr_booking[$booking_count]['technician_charges'] = $mm_book_data['technician_charges'];
        		               $arr_booking[$booking_count]['expenditure_incurred'] = $mm_book_data['expenditure_incurred'];
        		               $arr_booking[$booking_count]['booking_end_date'] = $booking_end_date;
        		               $arr_booking[$booking_count]['remaining_days_to_start'] = $remaining_days;
        		               $arr_booking[$booking_count]['remaining_hours_to_start'] = $remaining_hours;
        		               $arr_booking[$booking_count]['remaining_minutes_to_start'] = $remaining_minutes;
        		               $arr_booking[$booking_count]['sp_fcm_token'] = $mm_book_data['fcm_token'];
        		               $arr_booking[$booking_count]['user_fcm_token'] = $user_fcm_token;
        		               
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
            
            if(!array_key_exists('booking_id',$json) || !array_key_exists('status_id',$json)  || !array_key_exists('users_id',$json)
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
    		        $booking_ref_id = str_pad($booking_id, 6, "0", STR_PAD_LEFT);
    		        $users_id = $json->users_id;
    		        $sp_name = "";
    		        $user_mobile = "";
    		        
    		        $arr_sp_details = $common->get_details_dynamically('user_details', 'id', $sp_id);
    		        if($arr_sp_details != 'failure') {
    		            $sp_name = $arr_sp_details[0]['fname']." ".$arr_sp_details[0]['lname'];
    		        }
    		        
    		        $arr_user_details = $common->get_details_dynamically('user_details', 'id', $users_id);
    		        if($arr_user_details != 'failure') {
    		            $user_name = $arr_user_details[0]['fname']." ".$arr_user_details[0]['lname'];
    		            $user_mobile = $arr_user_details[0]['mobile'];
    		        }
    		        
    		        if ($booking_id > 0) {
                        
                        if($status_id == 5) { //'accept'
                            //Insert into alert_details table
            		        $arr_alerts = array(
                		          'alert_id' => 1, 
                                  'description' => "You have succesfully scheduled a booking $booking_ref_id at ".date('d-m-Y H:i:s')." with $sp_name",
                                  'action' => 1,
                                  'created_on' => date("Y-m-d H:i:s"), 
                                  'status' => 1,
                                  'users_id' => $users_id,
                            );
                            $common->insert_records_dynamically('alert_details', $arr_alerts);
                            
                            //Insert into alert_details table
            		        $arr_alerts = array(
                		          'alert_id' => 1, 
                                  'description' => "You have succesfully scheduled a booking $booking_ref_id at ".date('d-m-Y H:i:s')." with $user_name",
                                  'action' => 1,
                                  'created_on' => date("Y-m-d H:i:s"), 
                                  'status' => 1,
                                  'sp_id' => $sp_id,
                            );
                            $common->insert_records_dynamically('alert_details', $arr_alerts);
                            
                            //Send SMS
                            $sms_model = new SmsTemplateModel();
                            
                    	 	$data = [
                				"name" => "us_schedule",
                				"mobile" => $user_mobile,
                				"dat" => [
                					"var" => date('H:i:s'),
                					"var1" => date('d-m-Y'),
                					"var2" => "",
                				]
                			];
            			
            			    $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);
                        
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
	//---------------------------------------------------------GET OTP HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function generate_otp()
	{
		$validate_key = $this->request->getVar('key');
		$validate_booking_id = $this->request->getVar('booking_id');
		$user_type = $this->request->getVar('user_type');
		
		if($validate_key == "" || $validate_booking_id == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		$common = new CommonModel();
    		
    		if($key == $api_key) {
    		    $otp = $this->get_otp_token();
    		    $booking_ref_id = str_pad($validate_booking_id, 6, "0", STR_PAD_LEFT);
    		    $users_id = 0;
    		    $sp_id = 0;
    		    
    		    //Get data from booking table
                $arr_booking_details = $common->get_details_dynamically('booking', 'id', $validate_booking_id);
                if($arr_booking_details != 'failure') {
                    $users_id = $arr_booking_details[0]['users_id'];
                    $sp_id = $arr_booking_details[0]['sp_id'];
                }
    		    
    		    /*if($user_type == 'User') {
        		    //Insert into alert_details table
    		        $arr_alerts = array(
        		          'alert_id' => 1, 
                          'description' => "Your OTP to Start Booking $booking_ref_id is $otp. Please provide it to your service provider to start booking.",
                          'action' => 1,
                          'created_on' => date("Y-m-d H:i:s"), 
                          'status' => 1,
                          'users_id' => $users_id,
                    );
                    $common->insert_records_dynamically('alert_details', $arr_alerts);
    		    }*/
    		    if($user_type == 'SP') {
        		    //Insert into alert_details table
    		        $arr_alerts = array(
        		          'alert_id' => 1, 
                          'description' => "Your OTP to Complete Booking $booking_ref_id is $otp. Please provide it to your user to close booking.",
                          'action' => 1,
                          'created_on' => date("Y-m-d H:i:s"), 
                          'status' => 1,
                          'sp_id' => $sp_id,
                    );
                    $common->insert_records_dynamically('alert_details', $arr_alerts);
    		    }
    		    
    		    $arr_booking_update = array(
                    'otp' => $otp,
                    'otp_raised_by' => $sp_id
    		    );
    		    /*echo "<pre>";
    		    print_r($arr_booking_update);
    		    echo "</pre>";
    		    exit;*/
    		    $common->update_records_dynamically('booking', $arr_booking_update, 'id', $validate_booking_id);
    		    
		        return $this->respond([
        		    "otp" => $otp,
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
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
	//---------------------------------------------------------GET OTP HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function validate_otp()
	{
		$validate_key = $this->request->getVar('key');
		$validate_booking_id = $this->request->getVar('booking_id');
		$validate_sp_id = $this->request->getVar('sp_id');
		
		if($validate_key == "" || $validate_booking_id == "") {
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
    		    
    		    $booking_ref_id = str_pad($validate_booking_id, 6, "0", STR_PAD_LEFT);
    		    $users_id = 0;
    		    $sp_id = 0;
    		    $user_mobile = 0;
    		    
    		    //Get data from booking table
                $arr_booking_details = $common->get_details_dynamically('booking', 'id', $validate_booking_id);
                if($arr_booking_details != 'failure') {
                    $users_id = $arr_booking_details[0]['users_id'];
                    $sp_id = $arr_booking_details[0]['sp_id'];
                    
                    $arr_user_details = $common->get_details_dynamically('user_details', 'id', $users_id);
    		        if($arr_user_details != 'failure') {
    		            $user_name = $arr_user_details[0]['fname']." ".$arr_user_details[0]['lname'];
    		            $user_mobile = $arr_user_details[0]['mobile'];
    		        }
                }
    		    
    		    if($validate_sp_id > 0) { //Booking Started
    		        //Insert into alert_details table
    		        $arr_alerts = array(
        		          'alert_id' => 1, 
                          'description' => "Your booking $booking_ref_id is succesfully started on ".date('d-m-Y H:i:s'),
                          'action' => 1,
                          'created_on' => date("Y-m-d H:i:s"), 
                          'status' => 1,
                          'users_id' => $users_id,
                    );
                    $common->insert_records_dynamically('alert_details', $arr_alerts);
                    
                    $arr_alerts = array(
        		          'alert_id' => 1, 
                          'description' => "Your booking $booking_ref_id is succesfully started on ".date('d-m-Y H:i:s'),
                          'action' => 1,
                          'created_on' => date("Y-m-d H:i:s"), 
                          'status' => 1,
                          'sp_id' => $sp_id,
                    );
                    $common->insert_records_dynamically('alert_details', $arr_alerts);
                    
                    //Send SMS
                    $sms_model = new SmsTemplateModel();
                    
            	 	$data = [
        				"name" => "us_started",
        				"mobile" => $user_mobile,
        				"dat" => [
        					"var" => $booking_ref_id,
        					"var1" => "",
        					"var2" => "",
        				]
        			];
    			
    			    $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);
    		    
    		        $status_id = 13; //Inprogress
    		        //Updatebooking
                    $arr_booking_update = array(
                        'status_id' => $status_id,
        		        'started_at' => date("Y-m-d H:i:s")
                    );
    		    }
    		    else if($validate_sp_id == 0) { //Booking Completed
    		        //Calculate points
                    $sp_points = 3; //3 points for job completed
                    
                    $arr_user_details = $common->get_details_dynamically('user_details', 'id', $sp_id);
                    if($arr_user_details != 'failure') {
                        $points_count = $arr_user_details[0]['points_count']; 
                        
                        $total_points = $points_count + $sp_points;
                        
                        $arr_update_user_data = array(
    		                'points_count' => $total_points,
            		    );
                        $common->update_records_dynamically('user_details', $arr_update_user_data, 'id', $sp_id);
                    }
    		    
    		        //Insert into alert_details table
    		        $arr_alerts = array(
        		          'alert_id' => 1, 
                          'description' => "Your booking $booking_ref_id is succesfully completed.",
                          'action' => 1,
                          'created_on' => date("Y-m-d H:i:s"), 
                          'status' => 1,
                          'users_id' => $users_id,
                    );
                    $common->insert_records_dynamically('alert_details', $arr_alerts);
                    
                    //Insert into alert_details table
    		        $arr_alerts = array(
        		          'alert_id' => 1, 
                          'description' => "Your booking $booking_ref_id is succesfully completed.",
                          'action' => 1,
                          'created_on' => date("Y-m-d H:i:s"), 
                          'status' => 1,
                          'sp_id' => $sp_id,
                    );
                    $common->insert_records_dynamically('alert_details', $arr_alerts);
                    
                    //Send SMS
                    $sms_model = new SmsTemplateModel();
                    
            	 	$data = [
        				"name" => "us_complete",
        				"mobile" => $user_mobile,
        				"dat" => [
        					"var" => $booking_ref_id,
        					"var1" => "",
        					"var2" => "",
        				]
        			];
    			
    			    $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);
    		        
    		        $status_id = 23; //Completed
    		        //Updatebooking
                    $arr_booking_update = array(
                        'status_id' => $status_id,
        		        'completed_at' => date("Y-m-d H:i:s")
                    );
    		    }
    		    /*echo "<pre>";
    		    print_r($arr_booking_update);
    		    echo "</pre>";
    		    exit;*/
    		    $common->update_records_dynamically('booking', $arr_booking_update, 'id', $validate_booking_id);
		        
		        //Insert to booking status
                $arr_booking_status['booking_id'] = $validate_booking_id;
                $arr_booking_status['status_id'] = $status_id;
                $arr_booking_status['sp_id'] = $validate_sp_id;
                $arr_booking_status['description'] = ($validate_sp_id > 0) ? "Job Started" : "Job Completed";
                $common->insert_records_dynamically('booking_status', $arr_booking_status);
    		    
    		    return $this->respond([
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
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
	//---------------------------------------------------------Reschedule booking-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------
    public function reschedule_booking()
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
            
            if( !array_key_exists('booking_id',$json)  || !array_key_exists('scheduled_date',$json) || !array_key_exists('scheduled_time_slot_id',$json)  
                || !array_key_exists('rescheduled_date',$json) || !array_key_exists('rescheduled_time_slot_from',$json) || !array_key_exists('user_type',$json)
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
    		        $misc_model = new MiscModel();
    		        $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);
    		        
    		        $arr_time_slot_details = $common->get_details_dynamically('time_slot', 'from', $json->rescheduled_time_slot_from);
    		        if($arr_time_slot_details != 'failure') {
    		            $rescheduled_time_slot_id = $arr_time_slot_details[0]['id'];
    		        }
    		        else {
    		            $arr_time_slot = array(
            		        'from' => $json->rescheduled_time_slot_from
                        );
                        $rescheduled_time_slot_id = $common->insert_records_dynamically('time_slot', $arr_time_slot);
    		        }
    		        
    		        $arr_reschedule_booking = array(
        		        'booking_id' => $json->booking_id,
                        'scheduled_date' => $json->scheduled_date,
                        'scheduled_time_slot_id' => $json->scheduled_time_slot_id,
                        'rescheduled_date' => $json->rescheduled_date,
                        'rescheduled_time_slot_id' => $rescheduled_time_slot_id,
                        'req_raised_by_id' => $json->users_id,
                        'status_id' => 10,
                    );
                    $reschedule_id = $common->insert_records_dynamically('re_schedule', $arr_reschedule_booking);
                    
                    if ($reschedule_id > 0) {
                            $arr_booking = array(
            		        'reschedule_id' => $reschedule_id,
                            'reschedule_status_id' => 10,
                        );
                        $common->update_records_dynamically('booking', $arr_booking, 'id', $json->booking_id);
                        
                        //Get data from booking table
                        $arr_booking_details = $common->get_details_dynamically('booking', 'id', $json->booking_id);
                        if($arr_booking_details != 'failure') {
                            $arr_booking_status['booking_id'] = $json->booking_id;
                            $arr_booking_status['status_id'] = 10;
                            $arr_booking_status['sp_id'] = $arr_booking_details[0]['sp_id'];
                            $category_id = $arr_booking_details[0]['category_id'];
                            
                            $common->insert_records_dynamically('booking_status', $arr_booking_status);
                        }
                        
                        $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);
                        $scheduled_time_slot = ($json->scheduled_time_slot_id != 25) ? $json->scheduled_time_slot_id."00:00" : "00:00:00";
                        
                        if($json->user_type == 'User') {
                            $arr_user_details = $misc_model->get_user_name_by_booking($json->booking_id, $json->users_id);
            		        if($arr_user_details != "failure") {
            		            $user_name = $arr_user_details['fname']." ".$arr_user_details['lname'];
	                            $user_id = $arr_user_details['users_id'];
            		            $job_title = $arr_user_details['title'];
            		            $sp_id = $arr_user_details['sp_id'];
            		        }
                            
                            //Insert into alert_details table
                            $arr_alerts = array(
                		          'alert_id' => 9, 
                                  'description' => $user_name." placed a re-schedule request for booking $booking_ref_id 
                                   from ".date('d-m-Y',strtotime($json->scheduled_date))." ".$scheduled_time_slot." 
                                   to ".date('d-m-Y',strtotime($json->rescheduled_date))." ".$json->rescheduled_time_slot_from,
                                  'action' => 2,
                                  'created_on' => date("Y-m-d H:i:s"), 
                                  'status' => 1,
                                  'sp_id' => $sp_id,
                                  'booking_id' => $json->booking_id,
                                  'category_id' => $category_id,
                                  'booking_id' => $json->booking_id,
                                  'category_id' => $category_id,
                                  'reschedule_user_id' => $json->users_id,
                                  'reschedule_id' => $reschedule_id,
                            );
                            $common->insert_records_dynamically('alert_details', $arr_alerts);
                            
                            //Insert into alert_details table - Excel row 26
                            $arr_alerts = array(
                		          'alert_id' => 9, 
                                  'description' => "You have placed a re-schedule request for booking $booking_ref_id 
                                   from ".date('d-m-Y',strtotime($json->scheduled_date))." ".$scheduled_time_slot." 
                                   to ".date('d-m-Y',strtotime($json->rescheduled_date))." ".$json->rescheduled_time_slot_from,
                                  'action' => 2,
                                  'created_on' => date("Y-m-d H:i:s"), 
                                  'status' => 1,
                                  'users_id' => $sp_id,
                                  'booking_id' => $json->booking_id,
                                  'category_id' => $category_id,
                                  'reschedule_user_id' => $json->users_id,
                                  'reschedule_id' => $reschedule_id,
                            );
                            $common->insert_records_dynamically('alert_details', $arr_alerts);
                        }
                        else if($json->user_type == 'SP') {
                            $arr_sp_details = $misc_model->get_sp_name_by_booking($json->booking_id, $json->users_id);
            		        if($arr_sp_details != "failure") {
            		            $sp_name = $arr_sp_details['fname']." ".$arr_sp_details['lname'];
            		            $sp_id = $arr_sp_details['sp_id'];
            		            $job_title = $arr_sp_details['title'];
            		        }
                            
                            $arr_alerts = array(
                		          'alert_id' => 10, 
                                  'description' => $sp_name." placed a re-schedule request for booking $booking_ref_id 
                                   from ".date('d-m-Y',strtotime($json->scheduled_date))." ".$scheduled_time_slot." 
                                   to ".date('d-m-Y',strtotime($json->rescheduled_date))." ".$json->rescheduled_time_slot_from,
                                  'action' => 2,
                                  'created_on' => date("Y-m-d H:i:s"), 
                                  'status' => 1,
                                  'users_id' => $user_id,
                                  'booking_id' => $json->booking_id,
                                  'category_id' => $category_id,
                                  'reschedule_user_id' => $sp_id,
                                  'reschedule_id' => $reschedule_id,
                            );
                            $common->insert_records_dynamically('alert_details', $arr_alerts);
                            
                            //Insert into alert_details table - Excel row 59
                            $arr_alerts = array(
                		          'alert_id' => 10, 
                                  'description' => "You have placed a re-schedule request for booking $booking_ref_id 
                                   from ".date('d-m-Y',strtotime($json->scheduled_date))." ".$scheduled_time_slot." 
                                   to ".date('d-m-Y',strtotime($json->rescheduled_date))." ".$json->rescheduled_time_slot_from,
                                  'action' => 2,
                                  'created_on' => date("Y-m-d H:i:s"), 
                                  'status' => 1,
                                  'sp_id' => $sp_id,
                                  'booking_id' => $json->booking_id,
                                  'category_id' => $category_id,
                                  'reschedule_user_id' => $sp_id,
                                  'reschedule_id' => $reschedule_id,
                            );
                            $common->insert_records_dynamically('alert_details', $arr_alerts);
                        }
                        
            			return $this->respond([
            			    "booking_id" => $json->booking_id,
            			    "reschedule_id" => $reschedule_id,
            				"status" => 200,
            				"message" => "Success",
            			]);
            		}
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to Reschedule Booking"
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
	//--------------------------------------------------UPDATE Reschedule Status STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------
    public function update_reschedule_status_by_sp()
    {

        $json = $this->request->getJSON();
        if(!array_key_exists('booking_id',$json) || !array_key_exists('reschedule_id',$json) || !array_key_exists('status_id',$json) || !array_key_exists('user_type',$json)
           || !array_key_exists('sp_id',$json) || !array_key_exists('key',$json) ) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else{
        $common = new CommonModel();
        $misc_model = new MiscModel();
        $sms_model = new SmsTemplateModel();
    	
        $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		$apiconfig = new \Config\ApiConfig();
		
    	$api_key = $apiconfig->user_key;
    		
    	if($key == $api_key)
    	{
            $reschedule_id = $json->reschedule_id;
            $status_id = $json->status_id;
            $booking_id = $json->booking_id;
            $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);
            
            //Mark the status
            $upd_reschedule_status = [
                'status_id' => $status_id, //11 - Reschedule Rejected/12 - Reschedule Accepted/24 - Reschedule Cancelled By User/ 25 - Reschedule Cancelled by Service Provider
            ];
            $common->update_records_dynamically('re_schedule', $upd_reschedule_status, 'reschedule_id', $reschedule_id);
            
            $arr_booking = array(
		        'reschedule_status_id' => $status_id,
            );
            
            $scheduled_date = "";
            $scheduled_time_slot = "";
            
            if($status_id == 12) { //12 - Reschedule Accepted
                //Get data from re_schedule table
                $arr_reschedule_details = $common->get_details_dynamically('re_schedule', 'reschedule_id', $reschedule_id);
                if($arr_reschedule_details != 'failure') {
                    $scheduled_date = $arr_reschedule_details[0]['scheduled_date'];
                    $scheduled_time_slot = ($arr_reschedule_details[0]['scheduled_time_slot_id']) ? $arr_reschedule_details[0]['scheduled_time_slot_id']."00:00" : "00:00:00";
                    
                    $arr_booking['scheduled_date'] = $arr_reschedule_details[0]['rescheduled_date'];
                    $arr_booking['time_slot_id'] = $arr_reschedule_details[0]['rescheduled_time_slot_id'];
                    $rescheduled_time_slot = ($arr_reschedule_details[0]['rescheduled_time_slot_id']) ? $arr_reschedule_details[0]['rescheduled_time_slot_id']."00:00" : "00:00:00";
                }
            }
            $common->update_records_dynamically('booking', $arr_booking, 'id', $json->booking_id);
            
            $arr_booking_status['booking_id'] = $json->booking_id;
            $arr_booking_status['status_id'] = $status_id;
            $arr_booking_status['sp_id'] = $json->sp_id;
            
            $common->insert_records_dynamically('booking_status', $arr_booking_status);
            
            $arr_user_details = $misc_model->get_user_name_by_booking($json->booking_id, $json->users_id);
	        if($arr_user_details != "failure") {
	            $user_name = $arr_user_details['fname']." ".$arr_user_details['lname'];
                $user_id = $arr_user_details['users_id'];
	            $job_title = $arr_user_details['title'];
	            $sp_id = $arr_user_details['sp_id'];
	            $user_mobile = $arr_user_details['mobile'];
	        }
	        
	        $arr_sp_details = $common->get_details_dynamically('user_details', 'id', $json->sp_id);
	        if($arr_sp_details != 'failure') {
	            $sp_name = $arr_sp_details[0]['fname']." ".$arr_sp_details[0]['lname'];
	            $sp_mobile = $arr_sp_details[0]['mobile'];
	        }
            
            if($json->user_type == 'User') {
                //Insert into alert_details table
                $arr_alerts = array(
    		          'alert_id' => 1, 
                      'description' => ($status_id == 12) ? "Your booking $booking_ref_id is successfully rescheduled 
                                      from ".date('d-m-Y',strtotime($scheduled_date))." ".$scheduled_time_slot." 
                                      to ".date('d-m-Y',strtotime($arr_booking['scheduled_date']))." ".$rescheduled_time_slot : 
                                      "Your request for reschedule under booking $booking_ref_id is not accepted by $user_name due to his non availability.",
                      'action' => 1,
                      'created_on' => date("Y-m-d H:i:s"), 
                      'status' => 1,
                      'sp_id' => $json->sp_id,
                );
                $common->insert_records_dynamically('alert_details', $arr_alerts);
                
                if($status_id == 12) {
                    //Send SMS
                    $data = [
        				"name" => "sp_reschedule",
        				"mobile" => $sp_mobile,
        				"dat" => [
        					"var" => $sp_name,
        					"var1" => $booking_ref_id,
        					"var2" => $scheduled_time_slot,
        					"var3" => $scheduled_date,
        				]
        			];
    			
    			    $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);
                }
                else {
                    $data = [
        				"name" => "sp_cancel",
        				"mobile" => $sp_mobile,
        				"dat" => [
        					"var" => $sp_name,
        					"var1" => $booking_ref_id,
        					"var2" => "his non availability",
        				]
        			];
    			
    			    $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);
                }
            }
            else if($json->user_type == 'SP') {
                $arr_sp_details = $misc_model->get_sp_name_by_booking($json->booking_id, $json->users_id);
    	        if($arr_sp_details != "failure") {
    	            $sp_name = $arr_sp_details['fname']." ".$arr_sp_details['lname'];
    	            $sp_id = $arr_sp_details['sp_id'];
    	            $job_title = $arr_sp_details['title'];
    	        }
    	        
    	        $arr_alerts = array(
    		          'alert_id' => 1, 
                      'description' => ($status_id == 12) ? "Your booking $booking_ref_id is successfully rescheduled 
                                      from ".date('d-m-Y',strtotime($scheduled_date))." ".$scheduled_time_slot." 
                                      to ".date('d-m-Y',strtotime($arr_booking['scheduled_date']))." ".$rescheduled_time_slot : 
                                      "Your request for reschedule under booking $booking_ref_id is not accepted by $sp_name due to technical reasons.",
                      'action' => 1,
                      'created_on' => date("Y-m-d H:i:s"), 
                      'status' => 1,
                      'users_id' => $user_id,
                );
                $common->insert_records_dynamically('alert_details', $arr_alerts);
                
                if($status_id == 12) {
                    //Send SMS
                    $data = [
        				"name" => "sp_reschedule",
        				"mobile" => $user_mobile,
        				"dat" => [
        					"var" => $user_name,
        					"var1" => $booking_ref_id,
        					"var2" => $scheduled_time_slot,
        					"var3" => $scheduled_date,
        				]
        			];
    			
    			    $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);
    			    
    			    $data = [
        				"name" => "sp_booking",
        				"mobile" => $sp_mobile,
        				"dat" => [
        					"var" => $sp_name,
        					"var1" => "",
        				]
        			];
    			
    			    $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);
                }
                else {
                    $data = [
        				"name" => "sp_cancel",
        				"mobile" => $user_mobile,
        				"dat" => [
        					"var" => $user_name,
        					"var1" => $booking_ref_id,
        					"var2" => "technical reasons",
        				]
        			];
    			
    			    $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);
                }
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
    //--------------------------------------------------Cancel Booking Status STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------
    public function cancel_booking()
    {

        $json = $this->request->getJSON();
        if(!array_key_exists('booking_id',$json) || !array_key_exists('status_id',$json) || !array_key_exists('reasons',$json) 
           || !array_key_exists('cancelled_by',$json) || !array_key_exists('key',$json) ) {
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
            $status_id = $json->status_id;
            $booking_id = $json->booking_id;
            
            //Insert into cancel_booking
            $arr_cancel_booking = array(
                'booking_id' => $booking_id,
                'reasons' => $json->reasons,
                'cancelled_by' => $json->cancelled_by,
                'status_id' => $status_id,
            );
            $common->insert_records_dynamically('cancel_booking', $arr_cancel_booking);
            
            //Mark the status
            $arr_booking = array(
		        'status_id' => $status_id,
            );
            $common->update_records_dynamically('booking', $arr_booking, 'id', $booking_id);
            
            //Insert to booking status
            $arr_booking_status['booking_id'] = $booking_id;
            $arr_booking_status['status_id'] = $status_id;
            $common->insert_records_dynamically('booking_status', $arr_booking_status);
            
            return $this->respond([
                "status" => 200,
                "message" =>  "Booking Cancelled Successfully"
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
	//---------------------------------------------------------GET SP's booking Slots -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_sp_slots()
	{
		$validate_key = $this->request->getVar('key');
		$sp_id = $this->request->getVar('sp_id');
		if($validate_key == "" || $sp_id == "") {
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
    		    
        		$ar_sp_id = array();
        		$arr_slots_data = array();
        		$arr_temp = array();
        		$arr_temp_blocked = array();
        		
        		$ar_sp_id[$sp_id] = $sp_id;
        		
        		//Get SP's preferred day/timeslot data
                $arr_preferred_time_slots_list = $misc_model->get_sp_preferred_time_slot($ar_sp_id);
                if($arr_preferred_time_slots_list != 'failure') {
                    foreach($arr_preferred_time_slots_list as $key => $slot_data) {
                        $arr_temp[$slot_data['users_id']][$key]['day_slot'] = $slot_data['day_slot'];
                        $arr_temp[$slot_data['users_id']][$key]['time_slot_from'] = $slot_data['time_slot_from'];
                        $arr_temp[$slot_data['users_id']][$key]['time_slot_to'] = $slot_data['time_slot_to'];
                    }
                }
                
                //Get SP's blocked data
                $arr_blocked_time_slots_list = $misc_model->get_sp_blocked_time_slot($ar_sp_id);
                if($arr_blocked_time_slots_list != 'failure') {
                    foreach($arr_blocked_time_slots_list as $key => $blocked_data) {
                        $arr_temp_blocked[$slot_data['users_id']][$key]['time_slot_from'] = $blocked_data['from'];
                        $arr_temp_blocked[$slot_data['users_id']][$key]['date'] = $blocked_data['date'];
                    }
                }
                
                if(count($ar_sp_id) > 0) {
                    foreach($ar_sp_id as $sp_id) {
                        if(array_key_exists($sp_id,$arr_temp)) {
                            $arr_slots_data["preferred_time_slots"] = $arr_temp[$slot_data['users_id']];
                            $arr_slots_data["blocked_time_slots"] = (array_key_exists($slot_data['users_id'],$arr_temp_blocked)) ? $arr_temp_blocked[$slot_data['users_id']] : array();
                            //array_push($arr_slots_data,array("preferred_time_slots" => $arr_temp[$slot_data['users_id']],
                            //                                    "blocked_time_slots" => $arr_temp_blocked[$slot_data['users_id']]));
                        }
                    }
                }
        
        		if (count($arr_slots_data) > 0) {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"slots_data" => $arr_slots_data,
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Slots to Show"
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
	public function get_otp_token($length = 4) {
        return rand(
            ((int) str_pad(1, $length, 0, STR_PAD_RIGHT)),
            ((int) str_pad(9, $length, 9, STR_PAD_RIGHT))
        );
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //--------------------------------------------------Update Extra demand status STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------
    public function update_extra_demand_status()
    {

        $json = $this->request->getJSON();
        if(!array_key_exists('booking_id',$json) || !array_key_exists('status_id',$json) || !array_key_exists('key',$json) ) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else{
        $common = new CommonModel();
        $misc_model = new MiscModel();
        
        $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		$apiconfig = new \Config\ApiConfig();
		
    	$api_key = $apiconfig->user_key;
    		
    	if($key == $api_key)
    	{
            $status_id = $json->status_id; //status_id = 1 for accepted and 2 for rejected
            $booking_id = $json->booking_id;
            $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);
            
            $user_name = "";
	        $sp_id = 0;
	        $user_id = 0;
	        
	        $arr_user_details = $misc_model->get_user_name_by_booking($booking_id);
	        if($arr_user_details != "failure") {
	            $user_name = $arr_user_details['fname']." ".$arr_user_details['lname'];
	            $user_id = $arr_user_details['users_id'];
	            $sp_id = $arr_user_details['sp_id'];
	        }
            
            //Mark the status
            $arr_extra_demand = array(
		        'status' => $status_id,
            );
            $common->update_records_dynamically('extra_demand', $arr_extra_demand, 'booking_id', $booking_id);
            
            $booking_status_id = ($status_id == 1) ? 38 : 39; //extra demand accepted/extra demand rejected
            
            
            //Insert into booking status
            $arr_booking_status = array(
		        'booking_id' => $json->booking_id,
                'status_id' => $booking_status_id, //extra demand accepted/extra demand rejected
                'description' => "User updated extra demand for booking_id ".$json->booking_id,
                'created_on' => date('Y-m-d H:i:s')
            );
            $common->insert_records_dynamically('booking_status', $arr_booking_status);
            
            if($status_id == 1) {
                $arr_alerts = array(
    		          'alert_id' => 2, 
                      'description' => "You have accepted the extra demand for booking $booking_ref_id and work is resumed.",
                      'action' => 1,
                      'created_on' => date("Y-m-d H:i:s"), 
                      'status' => 1,
                      'users_id' => $user_id,
                );
                $common->insert_records_dynamically('alert_details', $arr_alerts);
                
                $arr_alerts = array(
    		          'alert_id' => 2, 
                      'description' => $user_name." has accepted the extra demand for booking $booking_ref_id and work is resumed.",
                      'action' => 1,
                      'created_on' => date("Y-m-d H:i:s"), 
                      'status' => 1,
                      'sp_id' => $sp_id,
                );
                $common->insert_records_dynamically('alert_details', $arr_alerts);
            }
            else {
                $arr_alerts = array(
    		          'alert_id' => 2, 
                      'description' => "You have rejected the extra demand for booking $booking_ref_id and work is resumed.",
                      'action' => 1,
                      'created_on' => date("Y-m-d H:i:s"), 
                      'status' => 1,
                      'users_id' => $user_id,
                );
                $common->insert_records_dynamically('alert_details', $arr_alerts);
                
                $arr_alerts = array(
    		          'alert_id' => 2, 
                      'description' => $user_name." has Rejected the extra demand for booking $booking_ref_id.",
                      'action' => 1,
                      'created_on' => date("Y-m-d H:i:s"), 
                      'status' => 1,
                      'sp_id' => $sp_id,
                );
                $common->insert_records_dynamically('alert_details', $arr_alerts);
            }
            
            return $this->respond([
                "status" => 200,
                "message" =>  "Status updated Successfully"
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
    //---------------------------------------------------------Goals/Installments-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_goals_installments_requested_list()
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
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    		    $job_post_model = new JobPostModel();
    		       
    		       $post_job_id = $validate_post_job_id;
    		       
    		       //Get Goals/Installments
    		       $arr_goals_installments = $job_post_model->get_goals_installments_requested_list($post_job_id);
    		       
    		       if($arr_goals_installments != 'failure') {
    		          
    		          return $this->respond([
        		            "goals_installments_details" => $arr_goals_installments,
        		            "status" => 200,
            				"message" => "Success",
            			]);
    		       }
    		       else {
            		    return $this->respond([
            		        "job_post_id" => $validate_post_job_id,
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
	//---------------------------------------------------------Booking Status list-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_booking_status_list()
	{
		$validate_key = $this->request->getVar('key');
		$validate_booking_id = $this->request->getVar('booking_id');
		
		if($validate_key == "" || $validate_booking_id == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		} else {
            $key = md5($validate_key); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    		       $misc_model = new MiscModel();
    		       
    		       $booking_id = $validate_booking_id;
    		       
    		       //Get booking statuses
    		       $arr_booking_status = $misc_model->get_booking_status_list($booking_id);
    		       
    		       if($arr_booking_status != 'failure') {
    		          
    		          return $this->respond([
        		            "booking_status_details" => $arr_booking_status,
        		            "status" => 200,
            				"message" => "Success",
            			]);
    		       }
    		       else {
            		    return $this->respond([
            		        "booking_id" => $booking_id,
        					"status" => 404,
        					"message" => "No Status found"
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
