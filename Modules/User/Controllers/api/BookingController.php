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
    		        $arr_time_slot = array(
        		        'from' => $json->time_slot_from
                    );
                    $time_slot_id = $common->insert_records_dynamically('time_slot', $arr_time_slot);
    		        
    		        $otp_start = $this->get_otp_token();
        		    $arr_booking = array(
        		        'users_id' => $json->users_id,
                        'category_id' => 1,
                        'scheduled_date' => $json->scheduled_date,
                        'time_slot_id' => $time_slot_id,
                        'started_at' => $json->started_at,
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
	public function get_otp_token($length = 4) {
        return rand(
            ((int) str_pad(1, $length, 0, STR_PAD_RIGHT)),
            ((int) str_pad(9, $length, 9, STR_PAD_RIGHT))
        );
    }
}
