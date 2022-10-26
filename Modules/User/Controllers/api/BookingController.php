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
use Modules\User\Models\AlertModel;
use Modules\User\Models\SmsTemplateModel;
use Modules\User\Models\PaytmModel;


use DateTime;

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

            if (
                !property_exists($json, 'scheduled_date') || !property_exists($json, 'time_slot_from')
                || !property_exists($json, 'started_at') || !property_exists($json, 'job_description')
                || !property_exists($json, 'address_id') || !property_exists($json, 'temp_address_id')
                || !property_exists($json, 'city') 
                || !property_exists($json, 'state') || !property_exists($json, 'country') || !property_exists($json, 'postal_code')
                || !property_exists($json, 'address') || !property_exists($json, 'user_lat') || !property_exists($json, 'user_long')
                || !property_exists($json, 'amount') || !property_exists($json, 'sp_id') || !property_exists($json, 'created_on')
                || !property_exists($json, 'sgst') || !property_exists($json, 'cgst')
                || !property_exists($json, 'attachments') || !property_exists($json, 'estimate_time') || !property_exists($json, 'estimate_type_id')
                || !property_exists($json, 'users_id') || !property_exists($json, 'key') || ($json->users_id == $json->sp_id)
                || !property_exists($json, 'profession_id')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    
                    $attachments = $json->attachments;

                    $common = new CommonModel();
                    $paytm = new PaytmModel();

                    $arr_time_slot_details = $common->get_details_dynamically('time_slot', 'from', $json->time_slot_from);
                    if ($arr_time_slot_details != 'failure') {
                        $time_slot_id = $arr_time_slot_details[0]['id'];
                    } else {
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
                        'cgst' => $json->cgst,
                        'sgst' => $json->sgst,
                        'sp_id' => $json->sp_id,
                        'created_on' => $json->created_on,
                        'attachment_count' => count($attachments),
                        'status_id' => 3,
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                        'profession_id' => $json->profession_id
                    );
                    $booking_id = $common->insert_records_dynamically('booking', $arr_booking);

                    if ($booking_id > 0) {

                        $address_id = $json->address_id;
                        if ($address_id == 0) {
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
                            'status_id' => 3,
                            'created_on' => $json->created_on
                        );
                        $common->insert_records_dynamically('booking_status', $arr_booking_status);

                        //Create and save atatchments
                        if (count($attachments) > 0) {
                            foreach ($attachments as $attach_key => $arr_file) {
                                
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
                                        'booking_id' => $booking_id,
                                        'file_name' => $file,
                                        'file_location' => 'elasticbeanstalk-ap-south-1-702440578175/'.$folder,
                                        'created_on' => $json->created_on,
                                        'created_by' => $json->users_id,
                                        'status_id' => 44
                                    );
                                    $common->insert_records_dynamically('attachments', $arr_attach);
                                }
                        }

                        $otp = $this->get_otp_token();
                        $booking_ref_id = str_pad($booking_id, 6, "0", STR_PAD_LEFT);
                        $users_id = $json->users_id;
                        // $order_id = "BKN_" . date('Ymd_his_U');

                        $arr_booking_update = array(
                            'otp' => $otp,
                            'otp_raised_by' => $users_id
                        );
                        $common->update_records_dynamically('booking', $arr_booking_update, 'id', $booking_id);

                        //Get Paytm TXNNo for the Booking
                        // $result = $paytm->gettxn($order_id, $json->amount, $json->users_id);
                        // $result = json_decode($result, true);

                        // echo "<pre>";
                        // print_r($result);
                        // echo "</pre>";
                        // exit;


                        return $this->respond([
                            "booking_id" => $booking_id,
                            "booking_ref_id" => str_pad($booking_id, 6, "0", STR_PAD_LEFT),
                            // "order_id" => $order_id,
                            // "txn_id" => (!isset($result['body']['txnToken']) ? "" : $result['body']['txnToken']),
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to create Booking"
                        ]);
                    }
                } else {
                    return $this->respond([
                        'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
                    ]);
                }
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    
    
    //---------------------------------------------------------Get TXN No. --------------------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------
    public function get_txn(){

        $json = $this->request->getJSON();
        
        $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

        if ($key == $api_key) {
        
        

        $paytm = new PaytmModel();

        if($json->type == 1){ //Booking Amount
            $order_id = "BKN_" . date('Ymd_his_U');
        }elseif($json->type == 2){ //Final Amount of Booking
            $order_id = "FNL_" . date('Ymd_his_U');
        }elseif($json->type == 3){ //User Plan
            $order_id = "PLNU_" . date('Ymd_his_U');
        }elseif($json->type == 4){ // SP Plan
            $order_id = "PLNS_" . date('Ymd_his_U');
        }elseif($json->type == 5){ // JOB Post Installment
            $order_id = "JOB_" . date('Ymd_his_U');
        }
        

        //Get Paytm TXN Code
        $result = $paytm->gettxn($order_id, $json->amount, $json->users_id);
        $result = json_decode($result, true);

        return $this->respond([
            
            "order_id" => $order_id,
            "txn_id" => (!isset($result['body']['txnToken']) ? "" : $result['body']['txnToken']),
            "status" => 200,
            "message" => "Success",
        ]);
    }else{

        return $this->respond([
            'status' => 403,
            'message' => 'Access Denied ! Authentication Failed'
        ]);

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

            if (
                !property_exists($json, 'scheduled_date') || !property_exists($json, 'time_slot_from')
                || !property_exists($json, 'started_at') || !property_exists($json, 'job_description')
                || !property_exists($json, 'amount') || !property_exists($json, 'sp_id') || !property_exists($json, 'created_on')
                || !property_exists($json, 'sgst') || !property_exists($json, 'cgst')
                || !property_exists($json, 'attachments') || !property_exists($json, 'estimate_time') || !property_exists($json, 'estimate_type_id')
                || !property_exists($json, 'users_id') || !property_exists($json, 'key') || !property_exists($json, 'profession_id')

            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $attachments = $json->attachments;

                    $common = new CommonModel();
                    $paytm = new PaytmModel();
                    //Get master time slot
                    $arr_time_slot_details = $common->get_details_dynamically('time_slot', 'from', $json->time_slot_from);
                    if ($arr_time_slot_details != 'failure') {
                        $time_slot_id = $arr_time_slot_details[0]['id'];
                    } else {
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
                        'cgst' => $json->cgst,
                        'sgst' => $json->sgst,
                        'sp_id' => $json->sp_id,
                        'created_on' => $json->created_on,
                        'attachment_count' => count($attachments),
                        'status_id' => 3,
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                        'profession_id' => $json->profession_id
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
                            'status_id' => 3,
                            'created_on' => $json->created_on
                        );
                        $common->insert_records_dynamically('booking_status', $arr_booking_status);

                        //Create and save atatchments
                        if (count($attachments) > 0) {
                            foreach ($attachments as $attach_key => $arr_file) {
                                
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
                                        'booking_id' => $booking_id,
                                        'file_name' => $file,
                                        'file_location' => 'elasticbeanstalk-ap-south-1-702440578175/'.$folder,
                                        'created_on' => $json->created_on,
                                        'created_by' => $json->users_id,
                                        'status_id' => 44
                                    );
                                    $common->insert_records_dynamically('attachments', $arr_attach);
                                }
                        }

                        $otp = $this->get_otp_token();
                        $booking_ref_id = str_pad($booking_id, 6, "0", STR_PAD_LEFT);
                        $users_id = $json->users_id;
                        // $order_id = "BKN_" . date('Ymd_his_U');

                        $arr_booking_update = array(
                            'otp' => $otp,
                        );
                        /*echo "<pre>";
            		    print_r($arr_booking_update);
            		    echo "</pre>";
            		    exit;*/
                        $common->update_records_dynamically('booking', $arr_booking_update, 'id', $booking_id);

                        //Get Paytm TXNNo for the Booking
                        // $result = $paytm->gettxn($order_id, $json->amount, $json->users_id);
                        // $result = json_decode($result, true);

                        // echo "<pre>";
                        // print_r($result);
                        // echo "</pre>";
                        // exit;


                        return $this->respond([
                            "booking_id" => $booking_id,
                            "booking_ref_id" => str_pad($booking_id, 6, "0", STR_PAD_LEFT),
                            // "order_id" => $order_id,
                            // "txn_id" => (!isset($result['body']['txnToken']) ? "" : $result['body']['txnToken']),
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to create Booking"
                        ]);
                    }
                } else {
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

            if (
                !property_exists($json, 'scheduled_date') || !property_exists($json, 'time_slot_from')
                || !property_exists($json, 'started_at') || !property_exists($json, 'addresses')
                || !property_exists($json, 'amount') || !property_exists($json, 'sp_id') || !property_exists($json, 'created_on')
                || !property_exists($json, 'sgst') || !property_exists($json, 'cgst')
                || !property_exists($json, 'attachments') || !property_exists($json, 'estimate_time') || !property_exists($json, 'estimate_type_id')
                || !property_exists($json, 'users_id') || !property_exists($json, 'key') || !property_exists($json, 'profession_id')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $attachments = $json->attachments;

                    $common = new CommonModel();
                    $paytm = new PaytmModel();

                    //Get master time slot
                    $arr_time_slot_details = $common->get_details_dynamically('time_slot', 'from', $json->time_slot_from);
                    if ($arr_time_slot_details != 'failure') {
                        $time_slot_id = $arr_time_slot_details[0]['id'];
                    } else {
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
                        'cgst' => $json->cgst,
                        'sgst' => $json->sgst,
                        'sp_id' => $json->sp_id,
                        'created_on' => $json->created_on,
                        'attachment_count' => count($attachments),
                        'status_id' => 3,
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                        'profession_id' => $json->profession_id
                    );
                    $booking_id = $common->insert_records_dynamically('booking', $arr_booking);

                    if ($booking_id > 0) {
                        $addresses = $json->addresses;

                        if (count($addresses) > 0) {
                            foreach ($addresses as $address_key => $arr_address) {
                                //Check if existing address is given if not create a new one.
                                $address_id = $arr_address->address_id;
                                if ($address_id == 0) {
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
                        if (count($attachments) > 0) {
                            foreach ($attachments as $attach_key => $arr_file) {
                                
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
                                        'booking_id' => $booking_id,
                                        'file_name' => $file,
                                        'file_location' => 'elasticbeanstalk-ap-south-1-702440578175/'.$folder,
                                        'created_on' => $json->created_on,
                                        'created_by' => $json->users_id,
                                        'status_id' => 44
                                    );
                                    $common->insert_records_dynamically('attachments', $arr_attach);
                                }
                        }

                        $otp = $this->get_otp_token();
                        $booking_ref_id = str_pad($booking_id, 6, "0", STR_PAD_LEFT);
                        $users_id = $json->users_id;
                        // $order_id = "BKN_" . date('Ymd_his_U');

                        //Get Paytm TXNNo for the Booking
                        // $result = $paytm->gettxn($order_id, $json->amount, $json->users_id);
                        // $result = json_decode($result, true);


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
                            // "order_id" => $order_id,
                            // "txn_id" => (!isset($result['body']['txnToken']) ? "" : $result['body']['txnToken']),
                            "status" => 200,
                            "message" => "Success"
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to create Booking"
                        ]);
                    }
                } else {
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

            if (
                !property_exists($json, 'booking_id') || !property_exists($json, 'date') || !property_exists($json, 'booking_amount')
                || !property_exists($json, 'cgst') || !property_exists($json, 'order_id')
                || !property_exists($json, 'time_slot_from') || !property_exists($json, 'sp_id') || !property_exists($json, 'sgst')
                || !property_exists($json, 'users_id') || !property_exists($json, 'key') || !property_exists($json, 'w_amount')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key != $api_key) {
                    return $this->respond([
                        'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
                    ]);
                } else {

                    $common = new CommonModel();
                    $misc_model = new MiscModel();
                    $paytm = new PaytmModel();


                    $check = $common->get_details_dynamically('transaction', 'order_id', $json->order_id);
                                        
                    // if ($check != 'failure' && $check[0]['payment_status'] != "TXN_FAILURE") {
                    //     return $this->respond([
                    //         'status' => 404,
                    //         'message' => 'Order ID already Used'
                    //     ]);
                    // } else {


                        $result = $paytm->verify_txn($json->order_id);
                        $result = json_decode($result, true);

                        if ($json->booking_amount != 0) {
                            $payment_status = ($result['body']['resultInfo']['resultStatus'] == 'TXN_FAILURE' ? "TXN_FAILURE" : "TXN_SUCCESS");
                        } else {
                            $payment_status = "TXN_SUCCESS";
                        }


                        // print_r($result);
                        // exit;

                        $arr_transaction = array();

                        // print_r($result);
                        // exit;

                        if ($json->booking_amount != 0 && $result['body']['resultInfo']['resultStatus'] == 'TXN_FAILURE') {

                            $arr_transaction['payment_status'] = $result['body']['resultInfo']['resultStatus'];
                            $arr_transaction['txnId'] = $result['body']['txnId'];

                        } elseif ($json->booking_amount != 0 && $result['body']['resultInfo']['resultStatus'] == 'TXN_SUCCESS') {

                            $arr_transaction['payment_status'] = $result['body']['resultInfo']['resultStatus'];
                            $arr_transaction['txnId'] = $result['body']['txnId'];
                            $arr_transaction["bankTxnId"] =  $result['body']['bankTxnId'];
                            $arr_transaction["txnType"] = $result['body']['txnType'];
                            $arr_transaction["gatewayName"] =  $result['body']['gatewayName'];
                            $arr_transaction["bankName"] = (isset($result['body']['bankName']) ? $result['body']['bankName'] : "");
                            $arr_transaction["paymentMode"] = $result['body']['paymentMode'];
                            $arr_transaction["refundAmt"] = $result['body']['refundAmt'];
                        }



                        if ($json->w_amount == 0) {

                            //Insert into Transaction table
                            $arr_transaction['name_id'] = 2; //Booking Amount
                            $arr_transaction['date'] = $json->date;
                            $arr_transaction['amount'] = $json->booking_amount;
                            $arr_transaction['type_id'] = 1; //Receipt/Credit
                            $arr_transaction['users_id'] = $json->users_id;
                            $arr_transaction['method_id'] = 1; //Online Payment
                            $arr_transaction['booking_id'] = $json->booking_id;
                            $arr_transaction['order_id'] = $json->order_id;


                            $transaction_id = $common->insert_records_dynamically('transaction', $arr_transaction);
                        } elseif ($json->w_amount != 0 && $json->booking_amount == 0) {

                            //Insert into Transaction table
                            $arr_transaction1 = array(
                                'name_id' => 2, //Booking Amount
                                'date' => $json->date,
                                'amount' => $json->w_amount,
                                'type_id' => 1, //Receipt/Credit
                                'users_id' => $json->users_id,
                                'method_id' => 2, //Wallet Transfer
                                'reference_id' => "W-" . rand(1, 999999),
                                'booking_id' => $json->booking_id,
                                'order_id' => $json->order_id,
                                'payment_status' => $payment_status,
                                'created_dts' => date('Y-m-d H:i:s')
                            );
                            $transaction_id = $common->insert_records_dynamically('transaction', $arr_transaction1);
                        } elseif ($json->w_amount != 0 && $json->booking_amount != 0) {

                            //Insert into Transaction table

                            //Wallet Transfer Entry
                            $arr_transaction1 = array(
                                'name_id' => 2, //Booking Amount
                                'date' => $json->date,
                                'amount' => $json->w_amount,
                                'type_id' => 1, //Receipt/Credit
                                'users_id' => $json->users_id,
                                'method_id' => 2, //Wallet Transfer
                                'reference_id' => "W-" . rand(1, 999999),
                                'booking_id' => $json->booking_id,
                                'order_id' => $json->order_id,
                                'payment_status' => $payment_status, //'Success', 'Failure'
                                'created_dts' => date('Y-m-d H:i:s')
                            );
                            $transaction_id = $common->insert_records_dynamically('transaction', $arr_transaction1);


                            //Bank Transfer Entry

                            $arr_transaction['name_id'] = 2; //Booking Amount
                            $arr_transaction['date'] = $json->date;
                            $arr_transaction['amount'] = $json->booking_amount;
                            $arr_transaction['type_id'] = 1; //Receipt/Credit
                            $arr_transaction['users_id'] = $json->users_id;
                            $arr_transaction['method_id'] = 1; //Online Payment
                            $arr_transaction['booking_id'] = $json->booking_id;
                            $arr_transaction['order_id'] = $json->order_id;

                            $transaction_id1 = $common->insert_records_dynamically('transaction', $arr_transaction);


                            //Wallet Add Entry
                            $arr_transaction2 = array(
                                'name_id' => 10, //Wallet
                                'date' => $json->date,
                                'amount' => $json->booking_amount + $json->w_amount,
                                'type_id' => 1, //Receipt/Credit
                                'users_id' => $json->users_id,
                                'method_id' => 2, //Online Payment
                                'reference_id' => "W-" . rand(1, 999999),
                                'booking_id' => $json->booking_id,
                                'order_id' => $json->order_id,
                                'payment_status' => $payment_status //'Success', 'Failure'
                            );
                            $transaction_id2 = $common->insert_records_dynamically('transaction', $arr_transaction2);
                        }

                        // print_r($arr_transaction);
                        // exit;


                        //Prepare data for insertion
                        if ($transaction_id > 0) { //Insert into Booking Payments/booking_receipts 
                            if ($payment_status == 'TXN_SUCCESS') {


                                //Make entry in to wallet for sp payment
                                //Check if the wallet is created
                                $arr_wallet_details = $common->get_details_dynamically('wallet_balance', 'users_id', $json->users_id);

                                if ($arr_wallet_details != 'failure') {
                                    //Get total amount and blocked amount
                                    $wallet_amount = $arr_wallet_details[0]['amount'] - ($json->w_amount);
                                    $wallet_amount_blocked = $arr_wallet_details[0]['amount_blocked'] + $json->booking_amount + $json->w_amount;

                                    $arr_update_wallet_data = array(
                                        'amount' => $wallet_amount,
                                        'amount_blocked' => $wallet_amount_blocked
                                    );
                                    $common->update_records_dynamically('wallet_balance', $arr_update_wallet_data, 'users_id', $json->users_id);
                                } else {
                                    $arr_wallet_data = array(
                                        'users_id' => $json->users_id,
                                        'amount' => 0,
                                        'amount_blocked' => $json->booking_amount + $json->w_amount
                                    );
                                    $common->insert_records_dynamically('wallet_balance', $arr_wallet_data);
                                }

                                //Get master time slot
                                $arr_time_slots = array();
                                $arr_time_slot_details = $common->get_table_details_dynamically('time_slot', 'id', 'ASC');
                                if ($arr_time_slot_details != 'failure') {
                                    foreach ($arr_time_slot_details as $time_data) {
                                        $arr_time_slots[$time_data['from']] = $time_data['id'];
                                    }
                                }
                                $time_slot_id = $arr_time_slots[$json->time_slot_from];

                                //Insert into sp_busy_slot

                                if ($time_slot_id > 0) {
                                    $arr_sp_busy_slot_ins = array(
                                        'users_id' => $json->sp_id,
                                        'date' => $json->date,
                                        'time_slot_id' => $time_slot_id,
                                        'booking_id' => $json->booking_id,
                                        'created_on' => date('Y-m-d H:i:s')
                                    );
                                    //Insert into booking_payments
                                    $sp_busy_slot_id = $common->insert_records_dynamically('sp_busy_slot', $arr_sp_busy_slot_ins);
                                } else {

                                    return $this->respond([
                                        "status" => 404,
                                        "message" => "Incorrect time format"
                                    ]);
                                }

                                //Update booking and booking status
                                //Insert into booking status
                                $arr_booking_status = array(
                                    'booking_id' => $json->booking_id,
                                    'status_id' => ($payment_status == 'TXN_SUCCESS') ? 9 : 30,
                                    'created_on' => date('Y-m-d H:i:s')
                                );
                                $common->insert_records_dynamically('booking_status', $arr_booking_status);

                                //Updatebooking
                                $arr_booking = array(
                                    'status_id' => ($payment_status == 'TXN_SUCCESS') ? 9 : 30,
                                );
                                $common->update_records_dynamically('booking', $arr_booking, 'id', $json->booking_id);


                                //Insert into alerts_regular_user table

                                $user_profile = $misc_model->user_info($json->users_id);
                                $sp_profile = $misc_model->user_info($json->sp_id);
                                $booking_details = $common->get_details_dynamically('booking', 'id', $json->booking_id);

                                $date = date('Y-m-d H:i:s');


                                $alert_desc = "Your booking ID " . $json->booking_id . " is successfully scheduled on " . $json->date . " " . $json->time_slot_from . " with "
                                    . $sp_profile[0]['fname'] . " " . $sp_profile[0]['lname'];

                                $arr_alerts = array(
                                    'type_id' => 1,
                                    'description' => $alert_desc,
                                    'user_id' => $json->users_id,
                                    'profile_pic_id' => $json->sp_id,
                                    'status' => 2,
                                    'created_on' => $date,
                                    'updated_on' => $date
                                );

                                $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                                //Insert into alerts_regular_sp table

                                $alert_desc1 = "Your booking ID " . $json->booking_id . " is successfully scheduled on " . $json->date . " " . $json->time_slot_from . " by "
                                    . $user_profile[0]['fname'] . " " . $user_profile[0]['lname'];

                                $arr_alerts1 = array(
                                    'type_id' => 1,
                                    'description' => $alert_desc1,
                                    'user_id' => $json->sp_id,
                                    'profile_pic_id' => $json->users_id,
                                    'status' => 2,
                                    'created_on' => $date,
                                    'updated_on' => $date
                                );

                                $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);


                                //Insert into alerts_regular_user table

                                $alert_desc2 = "Your OTP to Start Booking " . $json->booking_id . " is " . $booking_details[0]['otp'] . "Please provide 
                           it to service provider to start booking.";

                                $arr_alerts2 = array(
                                    'type_id' => 1,
                                    'description' => $alert_desc2,
                                    'user_id' => $json->users_id,
                                    'profile_pic_id' => $json->users_id,
                                    'status' => 2,
                                    'created_on' => $date,
                                    'updated_on' => $date
                                );

                                $common->insert_records_dynamically('alert_regular_user', $arr_alerts2);


                                return $this->respond([
                                    "transaction_id" => $transaction_id,
                                    "status" => 200,
                                    "message" => "Success",
                                ]);
                            } //Action after Payment Success
                        }
                    // }
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

            if (!property_exists($json, 'booking_id') || !property_exists($json,'category_id') || !property_exists($json,'users_id') || !property_exists($json,'key')) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $misc_model = new MiscModel();
                    $common = new CommonModel();

                    $category_id = $json->category_id;
                    $booking_id = $json->booking_id;
                    $users_id = $json->users_id;
                    $current_date = date('Y-m-d H:i:s');

                    //Get Booking Details
                    $arr_booking_details = $misc_model->get_booking_details($booking_id, $users_id);

                    $arr_response = array();
                    $arr_booking = array();
                    $sp_fcm_token = "";


                    // print_r($arr_booking_details);
                    // exit;

                    if ($arr_booking_details != 'failure') {
                        $started_at = $arr_booking_details['started_at'];
                        $completed_at = $arr_booking_details['completed_at'];
                        $status = "";
                        if ($started_at == "" || $started_at == "0000-00-00 00:00:00") {
                            $status = "Pending";
                        } else {
                            if ($completed_at == "" || $completed_at == "0000-00-00 00:00:00") {
                                $status = "Inprogress";
                            } else {
                                $status = "Completed";
                            }
                        }

                        $reschedule_id = $arr_booking_details['reschedule_id'];
                        $reschedule_status_id = $arr_booking_details['reschedule_status_id'];

                        $reschedule = $common->get_details_dynamically('re_schedule', 'reschedule_id', $reschedule_id);
                        if ($reschedule != 'failure') {
                            $reschedule_date = $reschedule[0]['rescheduled_date'];
                            $reschedule_time_id = $reschedule[0]['rescheduled_time_slot_id'];

                            $re_time = $common->get_details_dynamically('time_slot', 'id', $reschedule_time_id);
                            $reschedule_time = $re_time[0]['from'];
                        } else {
                            $reschedule_date = "";
                            $reschedule_time = "";
                        }

                        $reschedule_status = "";
                        if ($reschedule_status_id == 11) {
                            $reschedule_status = "Reschedule Rejected";
                        } else if ($reschedule_status_id == 12) {
                            $reschedule_status = "Reschedule Accepted";
                        } elseif ($reschedule_status_id == 10) {
                            $reschedule_status = "Reschedule Requested";
                        }

                        // print_r($arr_booking_details['completed_at']);
                        // exit;

                        $arr_booking_details['completed_at'] = (is_null($arr_booking_details['completed_at']) ? "0000-00-00 00:00:00" : $arr_booking_details['completed_at']);
                        $arr_booking_details['profile_pic'] = (is_null($arr_booking_details['profile_pic']) ? "" : $arr_booking_details['profile_pic']);
                        

                        $arr_booking['booking_id'] = $booking_id;
                        $arr_booking['fname'] = $arr_booking_details['fname'];
                        $arr_booking['lname'] = $arr_booking_details['lname'];
                        $arr_booking['mobile'] = $arr_booking_details['mobile'];
                        $arr_booking['scheduled_date'] = $arr_booking_details['scheduled_date'];
                        $arr_booking['time_slot_id'] = $arr_booking_details['time_slot_id'];
                        $arr_booking['started_at'] = ($arr_booking_details['started_at'] == '0000-00-00 00:00:00') ? "00-00-0000 00:00:00"  : date('d-m-Y h:i:sa', strtotime($arr_booking_details['started_at']));
                        $arr_booking['completed_at'] = ($arr_booking_details['completed_at'] == '0000-00-00 00:00:00') ? $arr_booking_details['completed_at'] : date('d-m-Y h:i:sa', strtotime($arr_booking_details['completed_at']));
                        $arr_booking['from'] = $arr_booking_details['from'];
                        $arr_booking['estimate_time'] = $arr_booking_details['estimate_time'];
                        $arr_booking['estimate_type'] = $arr_booking_details['estimate_type'];
                        $arr_booking['amount'] = $arr_booking_details['amount'];
                        $arr_booking['sp_id'] = $arr_booking_details['sp_id'];
                        $arr_booking['sp_profession'] = $arr_booking_details['profession'];
                        $arr_booking['fcm_token'] = $arr_booking_details['fcm_token'];
                        $arr_booking['otp'] = $arr_booking_details['otp'];
                        $arr_booking['booking_status'] = $status;
                        $arr_booking['extra_demand_total_amount'] = ($arr_booking_details['extra_demand_total_amount'] > 0) ? $arr_booking_details['extra_demand_total_amount'] : "0";
                        $arr_booking['material_advance'] = ($arr_booking_details['material_advance'] > 0) ? $arr_booking_details['material_advance'] : "0";
                        $arr_booking['technician_charges'] = ($arr_booking_details['technician_charges'] > 0) ? $arr_booking_details['technician_charges'] : "0";
                        $arr_booking['expenditure_incurred'] = (!is_null($arr_booking_details['expenditure_incurred'])) ? intval($arr_booking_details['expenditure_incurred']) : "";
                        $arr_booking['extra_demand_status'] = ($arr_booking_details['extra_demand_status'] != "") ? $arr_booking_details['extra_demand_status'] : "0";
                        $arr_booking['post_job_id'] = ($arr_booking_details['post_job_id'] > 0) ? $arr_booking_details['post_job_id'] : "0";
                        $arr_booking['reschedule_status'] = $reschedule_status;
                        $arr_booking['reschedule_date'] = $reschedule_date;
                        $arr_booking['reschedule_time'] = $reschedule_time;
                        $arr_booking['otp_raised_by'] = $arr_booking_details['otp_raised_by'];
                        $arr_booking['user_profile_pic'] = $arr_booking_details['profile_pic'];


                        $remaining_days = "";
                        $remaining_hours = "";
                        $remaining_minutes = "";

                        if ($status == "Completed") {

                            //Time Interval Calculation					  
                            $started = new DateTime($arr_booking['started_at']);
                            $end = new DateTime($arr_booking_details['completed_at']);
                            $diff = date_diff($started, $end);

                            $days = $diff->format('%a');
                            $hours = $diff->format('%H');

                            if ($days > 0) {
                                $time_lapsed = $diff->format("%a D %H H %I M");
                            } elseif ($days == 0 && $hours == 0) {
                                $time_lapsed = $diff->format("%I M");
                            } elseif ($days == 0 && $hours > 0) {
                                $time_lapsed = $diff->format("%H H %I M");
                            }
                        } elseif ($status == "Inprogress") {

                            //Time Interval Calculation					  
                            $started = new DateTime($arr_booking['started_at']);
                            $end = new DateTime($current_date);
                            $diff = date_diff($started, $end);

                            $days = $diff->format('%a');
                            $hours = $diff->format('%H');

                            if ($days > 0) {
                                $time_lapsed = $diff->format("%a D %H H %I M");
                            } elseif ($days == 0 && $hours == 0) {
                                $time_lapsed = $diff->format("%I M");
                            } elseif ($days == 0 && $hours > 0) {
                                $time_lapsed = $diff->format("%H H %I M");
                            }
                        } elseif ($status == "Pending") {

                            $time_lapsed = "";
                            //Time Interval Calculation					  
                            $start = new DateTime($current_date);
                            $end = new DateTime($arr_booking_details['scheduled_date'] . " " . $arr_booking_details['from']);
                            $diff = date_diff($start, $end);

                            $remaining_days = $diff->format('%a');
                            $remaining_hours = $diff->format('%H');
                            $remaining_minutes = $diff->format('%I');
                        }

                        $arr_booking['time_lapsed'] = $time_lapsed;
                        $arr_booking['remaining_days_to_start'] = $remaining_days;
                        $arr_booking['remaining_hours_to_start'] = $remaining_hours;
                        $arr_booking['remaining_minutes_to_start'] = $remaining_minutes;

                        $user_info = $misc_model->user_info($arr_booking['sp_id']);
                        if ($user_info != Null) {
                            $arr_booking['sp_fname'] = $user_info[0]['fname'];
                            $arr_booking['sp_lname'] = $user_info[0]['lname'];
                            $arr_booking['sp_fcm_token'] = $user_info[0]['fcm_token'];
                            $arr_booking['sp_profile_pic'] = (is_null($user_info[0]['profile_pic']) ? "" : $user_info[0]['profile_pic']);
                        }

                        $attachment_count = $arr_booking_details['attachment_count'];

                        $arr_attachments = array();
                        $arr_job_details = array();

                        if ($attachment_count > 0) {
                            $arr_attachment_details = $misc_model->get_attachment_details($booking_id);
                            if ($arr_attachment_details != 'failure') {
                                foreach ($arr_attachment_details as $attach_data) {
                                    $arr_attachments[] = array('file_name' => $attach_data['file_name'], 'file_location' => $attach_data['file_location']);
                                }
                            }
                        }

                        if ($category_id == 1) { // Single Move 
                            $arr_single_move_details = $misc_model->get_single_move_details($booking_id);
                            if ($arr_single_move_details != 'failure') {
                                foreach ($arr_single_move_details as $single_move_data) {
                                    $arr_job_details[] = array(
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
                        if ($category_id == 2) { // Blue Collar 
                            $arr_blue_collar_details = $misc_model->get_blue_collar_details($booking_id);
                            if ($arr_blue_collar_details != 'failure') {
                                foreach ($arr_blue_collar_details as $blue_collar_data) {
                                    $arr_job_details[] = array('job_description' => $blue_collar_data['job_description']);
                                }
                            }
                        }
                        if ($category_id == 3) { // Multi move
                            $arr_multi_move_details = $misc_model->get_multi_move_details($booking_id);
                            if ($arr_multi_move_details != 'failure') {
                                foreach ($arr_multi_move_details as $multi_move_data) {
                                    $arr_job_details[] = array(
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
                            "booking_details" => $arr_booking,
                            "attachments" => $arr_attachments,
                            "job_details" => $arr_job_details,
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "booking_id" => $booking_id,
                            "status" => 404,
                            "message" => "Invalid Booking"
                        ]);
                    }
                } else {
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

            if (!property_exists($json,'users_id') || !property_exists($json, 'key')) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $misc_model = new MiscModel();
                    $common = new CommonModel();

                    $users_id = $json->users_id;

                    $current_date = date('Y-m-d H:i:s');

                    $arr_user_details = $common->get_details_dynamically('users', 'users_id', $users_id);
                    if ($arr_user_details != 'failure') {
                        $user_fcm_token = $arr_user_details[0]['fcm_token'];
                    }

                    //Get Single Move Booking Details
                    $arr_single_move_booking_details = $misc_model->get_user_single_move_booking_details($users_id);
                   
                //    print_r($arr_single_move_booking_details);
                //    exit;

                                    
                    $arr_booking = array();
                    $arr_booking_response = array();

                    if ($arr_single_move_booking_details != 'failure') {
                        foreach ($arr_single_move_booking_details as $key => $book_data) {
                            $started_at = $book_data['started_at'];
                            $completed_at = $book_data['completed_at'];
                            $scheduled_date = $book_data['scheduled_date'] . " " . $book_data['from'];
                            $booking_end_date = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($scheduled_date)));
                            $current_date_time = date('Y-m-d H:i:s');
                            $remaining_days = 0;
                            $remaining_hours = 0;
                            $remaining_minutes = 0;

                            //Check if this booking is created from Post Job
                            $post_job = $common->get_details_dynamically('post_job','booking_id',$book_data['id']);
                            if($post_job != 'failure'){
                                $post_job_id = $post_job[0]['id'];
                            }else{
                                $post_job_id = "0";
                            }
                            $arr_booking[$key]['post_job_id'] = $post_job_id;

                            if ($current_date_time < $scheduled_date) {

                                $dateDiff = date_diff(date_create($scheduled_date), date_create($current_date_time));
                                $remaining_days = intval($dateDiff->format("%D"));
                                $remaining_hours = intval($dateDiff->format("%H"));
                                $remaining_minutes = intval($dateDiff->format("%I"));

                                // $dateDiff = intval((strtotime($scheduled_date) - strtotime($current_date_time)) / 60);
                                // $remaining_days = intval($dateDiff / (60 * 24));
                                // $remaining_hours = intval($dateDiff / 60);
                                // $remaining_minutes = $dateDiff % 60;
                            }

                            $status_id = $book_data['status_id'];

                            $status = "";

                            if ($status_id == '24' || $status_id == '25') { //Cancelled by user/sp
                                $status = "Cancelled";
                            }  else {
                                if ($started_at == "" || $started_at == "0000-00-00 00:00:00") {
                                    $status = "Pending";
                                } else {
                                    if ($completed_at == "" || $completed_at == "0000-00-00 00:00:00") {
                                        $status = "Inprogress";
                                    } else {
                                        $status = "Completed";
                                    }
                                }
                            }

                            $reschedule_id = $book_data['reschedule_id'];
                            $reschedule_status = $book_data['reschedule_status_id'];

                            $reschedule = $misc_model->reschedule_data($reschedule_id, 1);
                            if ($reschedule != 'failure') {
                                $reschedule_date = (is_null($reschedule[0]['rescheduled_date']) ? "" : $reschedule[0]['rescheduled_date']);
                                $reschedule_time = (is_null($reschedule[0]['from']) ? "" : $reschedule[0]['from']);
                                $reschedule_description = (is_null($reschedule[0]['description']) ? "" : $reschedule[0]['description']);
                            } else {
                                $reschedule_date = "";
                                $reschedule_time = "";
                                $reschedule_description = "";
                            }

                            $sp_details = $common->get_details_dynamically('user_details','id',$book_data['sp_id']);

                            //  print_r($arr_single_move_booking_details);
                            //  exit;

                            $arr_booking[$key]['booking_id'] = $book_data['id'];
                            $arr_booking[$key]['category_id'] = $book_data['category_id'];
                            $arr_booking[$key]['users_id'] = $json->users_id . "";
                            $arr_booking[$key]['fname'] = $book_data['fname'];
                            $arr_booking[$key]['lname'] = $book_data['lname'];
                            $arr_booking[$key]['mobile'] = $book_data['mobile'];
                            $arr_booking[$key]['profile_pic'] = $book_data['profile_pic'];

                            $arr_booking[$key]['scheduled_date'] = $book_data['scheduled_date'];
                            $arr_booking[$key]['time_slot_id'] = $book_data['time_slot_id'];
                            $arr_booking[$key]['started_at'] = $book_data['started_at'];
                            $arr_booking[$key]['completed_at'] = $book_data['completed_at'];
                            $arr_booking[$key]['from'] = $book_data['from'];
                            $arr_booking[$key]['estimate_time'] = $book_data['estimate_time'];
                            $arr_booking[$key]['estimate_type'] = $book_data['estimate_type'];
                            $arr_booking[$key]['amount'] = $book_data['amount'];
                            $arr_booking[$key]['sp_id'] = $book_data['sp_id'];
                            $arr_booking[$key]['sp_fname'] = $sp_details[0]['fname'];
                            $arr_booking[$key]['sp_lname'] = $sp_details[0]['lname'];
                            $arr_booking[$key]['sp_mobile'] = $sp_details[0]['mobile'];
                            $arr_booking[$key]['sp_profile_pic'] = $sp_details[0]['profile_pic'];
                            $arr_booking[$key]['pause_status'] = ($book_data['status_id'] == 15) ? "Yes" : "No";
                                                            

                            $arr_booking[$key]['booking_status'] = $status;

                            $arr_booking[$key]['reschedule_id'] = $reschedule_id;
                            $arr_booking[$key]['reschedule_status'] = $reschedule_status;
                            $arr_booking[$key]['reschedule_date'] = $reschedule_date;
                            $arr_booking[$key]['reschedule_time'] = $reschedule_time;
                            $arr_booking[$key]['reschedule_description'] = $reschedule_description;

                            $reschedule_data = $common->get_details_dynamically('re_schedule', 'reschedule_id', $reschedule_id);

                            $arr_booking[$key]['req_raised_by'] = ($reschedule_data != 'failure' ? $reschedule_data[0]['req_raised_by_id'] : "");


                            $arr_booking[$key]['otp'] = (is_null($book_data['otp']) ? "" : $book_data['otp']);
                            $arr_booking[$key]['extra_demand_total_amount'] = (is_null($book_data['extra_demand_total_amount']) ? "" : $book_data['extra_demand_total_amount']);
                            $arr_booking[$key]['material_advance'] = (is_null($book_data['material_advance']) ? "" : $book_data['material_advance']);
                            $arr_booking[$key]['technician_charges'] = (is_null($book_data['technician_charges']) ? "" : $book_data['technician_charges']);
                            $arr_booking[$key]['expenditure_incurred'] = (is_null($book_data['expenditure_incurred'])  ? "" : intval($book_data['expenditure_incurred']));
                            $arr_booking[$key]['booking_end_date'] = $booking_end_date;
                            $arr_booking[$key]['remaining_days_to_start'] = $remaining_days;
                            $arr_booking[$key]['remaining_hours_to_start'] = $remaining_hours;
                            $arr_booking[$key]['remaining_minutes_to_start'] = $remaining_minutes;
                            $arr_booking[$key]['sp_fcm_token'] = $book_data['fcm_token'];
                            $arr_booking[$key]['user_fcm_token'] = $user_fcm_token;

                            $arr_booking[$key]['details'][] = array(
                                'job_description' => $book_data['job_description'],
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

                    if ($arr_blue_collar_booking_details != 'failure') {
                        foreach ($arr_blue_collar_booking_details as $bc_book_data) {
                            $started_at = $bc_book_data['started_at'];
                            $completed_at = $bc_book_data['completed_at'];

                            $scheduled_date = $bc_book_data['scheduled_date'] . " " . $bc_book_data['from'];
                            $booking_end_date = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($scheduled_date)));
                            $current_date_time = date('Y-m-d H:i:s');
                            $remaining_days = 0;
                            $remaining_hours = 0;
                            $remaining_minutes = 0;

                            if ($current_date_time < $scheduled_date) {
                                $dateDiff = intval((strtotime($scheduled_date) - strtotime($current_date_time)) / 60);
                                $remaining_days = intval($dateDiff / (60 * 24));
                                $remaining_hours = intval($dateDiff / 60);
                                $remaining_minutes = $dateDiff % 60;
                            }
                            $status_id = $bc_book_data['status_id'];

                            $status = "";

                            if ($status_id == '24' || $status_id == '25') { //Cancelled by user/sp
                                $status = "Cancelled";
                            } 
                            // else if ($started_at == "0000-00-00 00:00:00" && $current_date > $booking_end_date) {
                            //     $status = "Expired";
                            // } 
                            else {
                                if ($started_at == "" || $started_at == "0000-00-00 00:00:00") {
                                    $status = "Pending";
                                } else {
                                    if ($completed_at == "" || $completed_at == "0000-00-00 00:00:00") {
                                        $status = "Inprogress";
                                    } else {
                                        $status = "Completed";
                                    }
                                }
                            }

                            //Check if this booking is created from Post Job
                            $post_job = $common->get_details_dynamically('post_job','booking_id',$book_data['id']);
                            if($post_job != 'failure'){
                                $post_job_id = $post_job[0]['id'];
                            }else{
                                $post_job_id = "0";
                            }
                            $arr_booking[$booking_count]['post_job_id'] = $post_job_id;


                            $bc_reschedule_id = $bc_book_data['reschedule_id'];
                            $bc_reschedule_status = $bc_book_data['reschedule_status_id'];

                            $bc_reschedule = $misc_model->reschedule_data($bc_reschedule_id, 1);
                            if ($bc_reschedule != 'failure') {
                                $bc_reschedule_date = (is_null($bc_reschedule[0]['rescheduled_date']) ? "" : $bc_reschedule[0]['rescheduled_date']);
                                $bc_reschedule_time = (is_null($bc_reschedule[0]['from']) ? "" : $bc_reschedule[0]['from']);
                                $bc_reschedule_description = (is_null($bc_reschedule[0]['description']) ? "" : $bc_reschedule[0]['description']);
                            } else {
                                $bc_reschedule_date = "";
                                $bc_reschedule_time = "";
                                $bc_reschedule_description = "";
                            }

                            $sp_details = $common->get_details_dynamically('user_details','id',$bc_book_data['sp_id']);

                            $arr_booking[$booking_count]['booking_id'] = $bc_book_data['id'];
                            $arr_booking[$booking_count]['category_id'] = $bc_book_data['category_id'];
                            $arr_booking[$booking_count]['users_id'] = $json->users_id . "";
                            $arr_booking[$booking_count]['profile_pic'] = $bc_book_data['profile_pic'];
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
                            $arr_booking[$booking_count]['sp_fname'] = $sp_details[0]['fname'];
                            $arr_booking[$booking_count]['sp_lname'] = $sp_details[0]['lname'];
                            $arr_booking[$booking_count]['sp_mobile'] = $sp_details[0]['mobile'];
                            $arr_booking[$booking_count]['sp_profile_pic'] = $sp_details[0]['profile_pic'];
                            $arr_booking[$booking_count]['pause_status'] = ($bc_book_data['status_id'] == 15) ? "Yes" : "No";
                            


                            $arr_booking[$booking_count]['booking_status'] = $status;

                            $arr_booking[$booking_count]['reschedule_id'] = $bc_reschedule_id;
                            $arr_booking[$booking_count]['reschedule_status'] = $bc_reschedule_status;
                            $arr_booking[$booking_count]['reschedule_date'] = $bc_reschedule_date;
                            $arr_booking[$booking_count]['reschedule_time'] = $bc_reschedule_time;
                            $arr_booking[$booking_count]['reschedule_description'] = $bc_reschedule_description;

                            $bc_reschedule_data = $common->get_details_dynamically('re_schedule', 'reschedule_id', $bc_reschedule_id);

                            $arr_booking[$booking_count]['req_raised_by'] = ($bc_reschedule_data != 'failure' ? $bc_reschedule_data[0]['req_raised_by_id'] : "");;

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

                    if ($arr_multi_move_booking_details != 'failure') {
                        foreach ($arr_multi_move_booking_details as $mm_book_data) {
                            $arr_details[$mm_book_data['id']][] = array(
                                'sequence_no' => $mm_book_data['sequence_no'],
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
                        foreach ($arr_multi_move_booking_details as $mm_book_data) {
                            if (!array_key_exists($mm_book_data['id'], $arr_exists)) {
                                $started_at = $mm_book_data['started_at'];
                                $completed_at = $mm_book_data['completed_at'];
                                $scheduled_date = $mm_book_data['scheduled_date'] . " " . $mm_book_data['from'];
                                $booking_end_date = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($scheduled_date)));
                                $current_date_time = date('Y-m-d H:i:s');
                                $remaining_days = 0;
                                $remaining_hours = 0;
                                $remaining_minutes = 0;

                                if ($current_date_time < $scheduled_date) {
                                    $dateDiff = intval((strtotime($scheduled_date) - strtotime($current_date_time)) / 60);
                                    $remaining_days = intval($dateDiff / (60 * 24));
                                    $remaining_hours = intval($dateDiff / 60);
                                    $remaining_minutes = $dateDiff % 60;
                                }
                                $status_id = $mm_book_data['status_id'];

                                $status = "";

                                if ($status_id == '24' || $status_id == '25') { //Cancelled by user/sp
                                    $status = "Cancelled";
                                } else if ($started_at == "0000-00-00 00:00:00" && $current_date > $booking_end_date) {
                                    $status = "Expired";
                                } else {
                                    if ($started_at == "" || $started_at == "0000-00-00 00:00:00") {
                                        $status = "Pending";
                                    } else {
                                        if ($completed_at == "" || $completed_at == "0000-00-00 00:00:00") {
                                            $status = "Inprogress";
                                        } else {
                                            $status = "Completed";
                                        }
                                    }
                                }

                                //Check if this booking is created from Post Job
                                $post_job = $common->get_details_dynamically('post_job','booking_id',$book_data['id']);
                                if($post_job != 'failure'){
                                    $post_job_id = $post_job[0]['id'];
                                }else{
                                    $post_job_id = "0";
                                }
                                $arr_booking[$booking_count]['post_job_id'] = $post_job_id;

                                $mm_reschedule_id = $mm_book_data['reschedule_id'];
                                $mm_reschedule_status = $mm_book_data['reschedule_status_id'];

                                $mm_reschedule = $misc_model->reschedule_data($mm_reschedule_id, 1);
                                if ($mm_reschedule != 'failure') {
                                    $mm_reschedule_date = (is_null($mm_reschedule[0]['rescheduled_date']) ? "" : $mm_reschedule[0]['rescheduled_date']);
                                    $mm_reschedule_time = (is_null($mm_reschedule[0]['from']) ? "" : $mm_reschedule[0]['from']);
                                    $mm_reschedule_description = (is_null($mm_reschedule[0]['description']) ? "" : $mm_reschedule[0]['description']);
                                } else {
                                    $mm_reschedule_date = "";
                                    $mm_reschedule_time = "";
                                    $mm_reschedule_description = "";
                                }

                                $sp_details = $common->get_details_dynamically('user_details','id',$mm_book_data['sp_id']);

                                $arr_booking[$booking_count]['booking_id'] = $mm_book_data['id'];
                                $arr_booking[$booking_count]['category_id'] = $mm_book_data['category_id'];
                                $arr_booking[$booking_count]['users_id'] = $json->users_id . "";
                                $arr_booking[$booking_count]['fname'] = $mm_book_data['fname'];
                                $arr_booking[$booking_count]['lname'] = $mm_book_data['lname'];
                                $arr_booking[$booking_count]['mobile'] = $mm_book_data['mobile'];
                                $arr_booking[$booking_count]['profile_pic'] = $mm_book_data['profile_pic'];
                                $arr_booking[$booking_count]['scheduled_date'] = $mm_book_data['scheduled_date'];
                                $arr_booking[$booking_count]['time_slot_id'] = $mm_book_data['time_slot_id'];
                                $arr_booking[$booking_count]['started_at'] = $mm_book_data['started_at'];
                                $arr_booking[$booking_count]['from'] = $mm_book_data['from'];
                                $arr_booking[$booking_count]['estimate_time'] = $mm_book_data['estimate_time'];
                                $arr_booking[$booking_count]['estimate_type'] = $mm_book_data['estimate_type'];
                                $arr_booking[$booking_count]['amount'] = $mm_book_data['amount'];
                                $arr_booking[$booking_count]['sp_id'] = $mm_book_data['sp_id'];
                                $arr_booking[$booking_count]['sp_fname'] = $sp_details[0]['fname'];
                                $arr_booking[$booking_count]['sp_lname'] = $sp_details[0]['lname'];
                                $arr_booking[$booking_count]['sp_mobile'] = $sp_details[0]['mobile'];
                                $arr_booking[$booking_count]['sp_profile_pic'] = $sp_details[0]['profile_pic'];
                                $arr_booking[$booking_count]['pause_status'] = ($mm_book_data['status_id'] == 15) ? "Yes" : "No";
                                
                                $arr_booking[$booking_count]['booking_status'] = $status;

                                $arr_booking[$booking_count]['reschedule_id'] = $mm_reschedule_id;
                                $arr_booking[$booking_count]['reschedule_status'] = $mm_reschedule_status;
                                $arr_booking[$booking_count]['reschedule_date'] = $mm_reschedule_date;
                                $arr_booking[$booking_count]['reschedule_time'] = $mm_reschedule_time;
                                $arr_booking[$booking_count]['reschedule_description'] = $mm_reschedule_description;

                                $mm_reschedule_data = $common->get_details_dynamically('re_schedule', 'reschedule_id', $mm_reschedule_id);
                                $arr_booking[$booking_count]['req_raised_by'] = ($mm_reschedule_data != 'failure' ? $mm_reschedule_data[0]['req_raised_by_id'] : "");;

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

                                foreach ($arr_details[$mm_book_data['id']] as $key => $val) {
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
                    if (count($arr_booking) > 0) {
                        return $this->respond([
                            "booking_details" => $arr_booking,
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "No Bookings"
                        ]);
                    }
                } else {
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

            if (
                !property_exists($json, 'booking_id') || !property_exists($json,'status_id')  || !property_exists($json,'users_id')
                || !property_exists($json, 'amount') || !property_exists($json,'sp_id') || !property_exists($json,'created_on')
                || !property_exists($json,'description') || !property_exists($json,'key')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {

                    
                    $common = new CommonModel();
                    $misc = new MiscModel();

                    $booking_id = $json->booking_id;
                    $sp_id = $json->sp_id;
                    $status_id = $json->status_id;
                    $description = $json->description;
                    $booking_ref_id = str_pad($booking_id, 6, "0", STR_PAD_LEFT);
                    $users_id = $json->users_id;
                    $sp_name = "";
                    $user_mobile = "";

                    $arr_sp_details = $common->get_details_dynamically('user_details', 'id', $sp_id);
                    if ($arr_sp_details != 'failure') {
                        $sp_name = $arr_sp_details[0]['fname'] . " " . $arr_sp_details[0]['lname'];
                        $sp_profile_pic = $arr_sp_details[0]['profile_pic'];
                    }

                    $arr_user_details = $common->get_details_dynamically('user_details', 'id', $users_id);
                    if ($arr_user_details != 'failure') {
                        $user_name = $arr_user_details[0]['fname'] . " " . $arr_user_details[0]['lname'];
                        $user_mobile = $arr_user_details[0]['mobile'];
                        $user_profile_pic = $arr_user_details[0]['profile_pic'];
                    }

                    if ($booking_id > 0) {

                        $booking_details = $misc->get_booking_details($booking_id, $users_id);
                        
                        // print_r($booking_details);
                        // exit;

                        if($booking_details['sp_id'] == 0){

                            $tax = $common->get_table_details_dynamically('tax_cancel_charges');
                            $sgst_percentage = 0;
                            $cgst_percentage = 0;
                                                        
                            foreach($tax as $t){

                                if($t['id'] == 1){
                                    $cgst_percentage = $t['percentage'];
                                }elseif($t['id'] == 3){
                                    $sgst_percentage = $t['percentage'];
                                }
                            }
                            
                            $profession_id = $booking_details['profession_id'];
                            
                            $tariff = $common->get_details_with_multiple_where('tariff',['users_id' => $json->sp_id,'profession_id'=>$profession_id]);

                            if($tariff == 'failure'){

                                return $this->respond([
                                    
                                    "status" => 404,
                                    "message" => "Tariff Not Found",
                                ]);

                            }else{
                            
                            $amount = $tariff[0]['min_charges'];
                            $cgst = round($amount * $cgst_percentage/100);
                            $sgst = round($amount * $sgst_percentage/100);

                            $total = $amount + $sgst + $cgst;

                            $arr_update = [
                                'amount' => $total,
                                'sgst' => $sgst,
                                'cgst' => $cgst,
                                'sp_id' => $json->sp_id
                            ];

                            $update_amount = $common->update_records_dynamically('booking',$arr_update,'id',$json->booking_id);
                        }

                        }

                        if ($status_id == 5) { //'accept'

                            //Insert into alerts_regular_user table

                            $arr_alerts = array(
                                'type_id' => 1,
                                'description' => "Your booking with ID $booking_ref_id scheduled on " . $booking_details['scheduled_date'] .
                                    " " . $booking_details['from'] . " is accepted by $sp_name.",
                                'user_id' => $users_id,
                                'profile_pic_id' => $sp_id,
                                'status' => 2,
                                'created_on' => $json->created_on,
                                'updated_on' => $json->created_on
                            );

                            $common->insert_records_dynamically('alert_regular_user', $arr_alerts);

                            //Insert into alerts_regular_sp table

                            $arr_alerts1 = array(
                                'type_id' => 1,
                                'description' => "You have successfully accepted booking with ID $booking_ref_id scheduled on " . $booking_details['scheduled_date'] . " "
                                    . $booking_details['from'] . " created by $user_name.",
                                'user_id' => $sp_id,
                                'profile_pic_id' => $sp_id,
                                'status' => 2,
                                'created_on' => $json->created_on,
                                'updated_on' => $json->created_on
                            );

                            $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);


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
                                // 'amount' => $json->amount,
                                // 'sp_id' => $json->sp_id,
                                'status_id' => $status_id,
                            );
                        } elseif ($status_id == 6) { //Not Responded


                            //Insert into alert_regular_sp table
                            $date = date('Y-m-d H:i:s');
                            $arr_alerts = array(
                                'type_id' => 1,
                                'description' => "You have missed booking $booking_ref_id at " . date('d-m-Y H:i:s') . " with " . $user_name . " on " . $date,
                                'user_id' => $sp_id,
                                'profile_pic_id' => $sp_id,
                                'status' => 2,
                                'created_on' => $json->created_on,
                                'updated_on' => $json->created_on
                            );

                            $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);

                            $arr_booking_update = array(
                                // 'amount' => $json->amount,
                                // 'sp_id' => $json->sp_id,
                                'status_id' => $status_id,
                            );
                        } else { //'reject'

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
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to update status"
                        ]);
                    }
                } else {
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

        if ($validate_key == "" || $validate_booking_id == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            $common = new CommonModel();

            if ($key == $api_key) {
                $otp = $this->get_otp_token();
                $booking_ref_id = str_pad($validate_booking_id, 6, "0", STR_PAD_LEFT);
                $users_id = 0;
                $sp_id = 0;

                //Get data from booking table
                $arr_booking_details = $common->get_details_dynamically('booking', 'id', $validate_booking_id);
                if ($arr_booking_details != 'failure') {
                    $users_id = $arr_booking_details[0]['users_id'];
                    $sp_id = $arr_booking_details[0]['sp_id'];
                }


                if ($user_type == 'SP') {


                    //Insert into alerts_regular_sp table

                    $date = date('Y-m-d H:i:s');
                    $arr_alerts = array(
                        'type_id' => 1,
                        'description' => "Your OTP to Complete Booking ID: $booking_ref_id is $otp. Please provide it to your user to mark booking completed.",
                        'user_id' => $sp_id,
                        'profile_pic_id' => $sp_id,
                        'status' => 2,
                        'created_on' => $date,
                        'updated_on' => $date
                    );

                    $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);
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
            } else {
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

        if ($validate_key == "" || $validate_booking_id == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $common = new CommonModel();

                $booking_ref_id = str_pad($validate_booking_id, 6, "0", STR_PAD_LEFT);
                $users_id = 0;
                $sp_id = 0;
                $user_mobile = 0;

                //Get data from booking table
                $arr_booking_details = $common->get_details_dynamically('booking', 'id', $validate_booking_id);
                if ($arr_booking_details != 'failure') {
                    $users_id = $arr_booking_details[0]['users_id'];
                    $sp_id = $arr_booking_details[0]['sp_id'];

                    $arr_user_details = $common->get_details_dynamically('user_details', 'id', $users_id);
                    if ($arr_user_details != 'failure') {
                        $user_name = $arr_user_details[0]['fname'] . " " . $arr_user_details[0]['lname'];
                        $user_mobile = $arr_user_details[0]['mobile'];
                    }
                }

                if ($validate_sp_id > 0) { //Booking Started

                    //Insert into alerts_regular_user table

                    $date = date('Y-m-d H:i:s');
                    $arr_alerts = array(
                        'type_id' => 1,
                        'description' => "Your booking ID: $booking_ref_id is succesfully started on " . $date,
                        'user_id' => $users_id,
                        'profile_pic_id' => $users_id,
                        'status' => 2,
                        'created_on' => $date,
                        'updated_on' => $date
                    );

                    $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                    //Insert into alerts_regular_sp table

                    $arr_alerts1 = array(
                        'type_id' => 1,
                        'description' => "booking ID: $booking_ref_id is succesfully started on " . $date,
                        'user_id' => $sp_id,
                        'profile_pic_id' => $sp_id,
                        'status' => 2,
                        'created_on' => $date,
                        'updated_on' => $date
                    );

                    $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);


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
                } else if ($validate_sp_id == 0) { //Booking Completed
                    //Calculate points
                    $sp_points = 3; //3 points for job completed

                    $arr_user_details = $common->get_details_dynamically('user_details', 'id', $sp_id);
                    if ($arr_user_details != 'failure') {
                        $points_count = $arr_user_details[0]['points_count'];

                        $total_points = $points_count + $sp_points;

                        $arr_update_user_data = array(
                            'points_count' => $total_points,
                        );
                        $common->update_records_dynamically('user_details', $arr_update_user_data, 'id', $sp_id);
                    }

                    //Insert into alerts_regular_user table

                    $date = date('Y-m-d H:i:s');
                    $arr_alerts = array(
                        'type_id' => 1,
                        'description' => "booking ID: $booking_ref_id is succesfully completed on " . $date,
                        'user_id' => $users_id,
                        'profile_pi_id' => $users_id,
                        'status' => 2,
                        'created_on' => $date,
                        'updated_on' => $date
                    );

                    $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                    //Insert into alerts_regular_sp table

                    $arr_alerts1 = array(
                        'type_id' => 1,
                        'description' => "booking ID: $booking_ref_id is succesfully completed on " . $date,
                        'user_id' => $sp_id,
                        'profile_pic_id' => $sp_id,
                        'status' => 2,
                        'created_on' => $date,
                        'updated_on' => $date
                    );

                    $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);



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

                    $status_id = 42; //OTP Verified and Payment Pending
                    //Updatebooking
                    $arr_booking_update = array(
                        'status_id' => $status_id,
                        'completed_at' => $date
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
                $arr_booking_status['description'] = ($validate_sp_id > 0) ? "OTP Verified and Booking Started" : "OTP Verified and Payment Pending";
                $arr_booking_status['created_on'] = $date;
                $common->insert_records_dynamically('booking_status', $arr_booking_status);

                return $this->respond([
                    "status" => 200,
                    "message" => "Success",
                ]);
            } else {
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

            if (
                !property_exists($json, 'booking_id')  || !property_exists($json, 'scheduled_date') || !property_exists($json, 'scheduled_time_slot_id')
                || !property_exists($json, 'rescheduled_date') || !property_exists($json, 'rescheduled_time_slot_from') || !property_exists($json, 'user_type')
                || !property_exists($json, 'users_id') || !property_exists($json, 'key')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();
                $date = date('Y-m-d H:i:s');

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $misc_model = new MiscModel();
                    $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);

                    $arr_time_slot_details = $common->get_details_dynamically('time_slot', 'from', $json->rescheduled_time_slot_from);
                    if ($arr_time_slot_details != 'failure') {
                        $rescheduled_time_slot_id = $arr_time_slot_details[0]['id'];
                    } else {
                        $arr_time_slot = array(
                            'from' => $json->rescheduled_time_slot_from
                        );
                        $rescheduled_time_slot_id = $common->insert_records_dynamically('time_slot', $arr_time_slot);
                    }

                    //Getting Reschedule iD if any already existing
                    $common->delete_records_dynamically_multiple_where('re_schedule', ['booking_id' => $json->booking_id, 'status_id' => 10]);

                    $arr_reschedule_booking = array(
                        'booking_id' => $json->booking_id,
                        'scheduled_date' => $json->scheduled_date,
                        'scheduled_time_slot_id' => $json->scheduled_time_slot_id,
                        'rescheduled_date' => $json->rescheduled_date,
                        'rescheduled_time_slot_id' => $rescheduled_time_slot_id,
                        'req_raised_by_id' => $json->users_id,
                        'status_id' => 10,
                        'created_on' => $date
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

                        if ($arr_booking_details != 'failure') {
                            $arr_booking_status['booking_id'] = $json->booking_id;
                            $arr_booking_status['status_id'] = 10;
                            $arr_booking_status['sp_id'] = $arr_booking_details[0]['sp_id'];
                            $arr_booking_status['created_on'] = $date;
                            $category_id = $arr_booking_details[0]['category_id'];

                            $common->insert_records_dynamically('booking_status', $arr_booking_status);
                        }

                        $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);
                        $scheduled_time_slot = ($json->scheduled_time_slot_id != 25) ? $json->scheduled_time_slot_id . ":00:00" : "00:00:00";

                        if ($json->user_type == 'User') {
                            $arr_user_details = $misc_model->get_user_name_by_booking($json->booking_id, $json->users_id);
                            if ($arr_user_details != "failure") {
                                $user_name = $arr_user_details['fname'] . " " . $arr_user_details['lname'];
                                $user_id = $arr_user_details['users_id'];
                                $job_title = $arr_user_details['title'];
                                $sp_id = $arr_user_details['sp_id'];
                            }

                            $sp_details = $misc_model->get_sp_name_by_booking($json->booking_id, $sp_id);

                            //Delete Old Alert
                            $common->delete_records_dynamically_multiple_where('alert_regular_user', ['type_id' => 9, 'status' => 2, 'user_id' => $json->users_id]);

                            //Create New Alert
                            $alert_part_1 = "placed a re-schedule request for booking ID: " . $booking_ref_id . " from";
                            $alert_part_2 = date('d-m-Y', strtotime($json->scheduled_date)) . " " . $scheduled_time_slot . " to " . date('d-m-Y', strtotime($json->rescheduled_date)) . " " . $json->rescheduled_time_slot_from;
                            //Insert into alert_regular_user
                            $arr_alerts = array(
                                'type_id' => 9,
                                'description' => "You have " . $alert_part_1 . " " . $alert_part_2,
                                'user_id' => $json->users_id,
                                'profile_pic_id' => $json->users_id,
                                'status' => 2,
                                'created_on' => $date,
                                'updated_on' => $date
                            );

                            $common->insert_records_dynamically('alert_regular_user', $arr_alerts);

                            //Delete Old Alert
                            $common->delete_records_dynamically_multiple_where('alert_action_sp', ['type_id' => 9, 'status' => 2, 'booking_id' => $booking_ref_id, 'user_id' => $sp_id]);

                            //Insert into alert_action_sp
                            $arr_alerts1 = array(
                                'type_id' => 9,
                                'description' => $user_name . " " . $alert_part_1 . " " . $alert_part_2,
                                'user_id' => $sp_id,
                                'profile_pic_id' => $json->users_id,
                                'status' => 2,
                                'created_on' => $date,
                                'api' => 'user/update_reschedule_status_by_sp',
                                'accept_text' => 'Acccept',
                                'reject_text' => 'Reject',
                                'accept_response' => 12,
                                'reject_response' => 13,
                                'updated_on' => $date,
                                'booking_id' => $booking_ref_id,
                                'post_id' => 'Null',
                                'status_code_id' => 10,
                                'reschedule_id' => $reschedule_id,
                                'created_on' => $date,
                                'expiry' => date('Y-m-d H:i:s', strtotime($json->rescheduled_date . " " . $json->rescheduled_time_slot_from))
                            );

                            $common->insert_records_dynamically('alert_action_sp', $arr_alerts1);
                        } else if ($json->user_type == 'SP') {
                            $arr_sp_details = $misc_model->get_sp_name_by_booking($json->booking_id, $json->users_id);
                            if ($arr_sp_details != "failure") {
                                $sp_name = $arr_sp_details['fname'] . " " . $arr_sp_details['lname'];
                                $sp_id = $arr_sp_details['sp_id'];
                                $job_title = $arr_sp_details['title'];
                                $user_id = $arr_sp_details['users_id'];
                            }

                            $user_details = $misc_model->get_user_name_by_booking($json->booking_id, $user_id);

                            //Delete Old Alert
                            $common->delete_records_dynamically_multiple_where('alert_regular_sp', ['type_id' => 9, 'status' => 2, 'user_id' => $sp_id]);

                            //Insert into alert_regular_sp
                            $alert_part_1 = "placed a re-schedule request for booking ID: " . $booking_ref_id . " from";
                            $alert_part_2 = date('d-m-Y', strtotime($json->scheduled_date)) . " " . $scheduled_time_slot . " to " . date('d-m-Y', strtotime($json->rescheduled_date)) . " " . $json->rescheduled_time_slot_from;
                            $arr_alerts = array(
                                'type_id' => 9,
                                'description' => "You have " . $alert_part_1 . " " . $alert_part_2,
                                'user_id' => $sp_id,
                                'profile_pic_id' => $sp_id,
                                'status' => 2,
                                'created_on' => $date,
                                'updated_on' => $date
                            );

                            $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);


                            //Delete Old Alert
                            $common->delete_records_dynamically_multiple_where('alert_action_user', ['type_id' => 9, 'status' => 2, 'booking_id' => $booking_ref_id, 'user_id' => $user_id]);

                            //Insert into alert_action_user
                            $arr_alerts1 = [
                                'type_id' => 9,
                                'description' => $sp_name . " " . $alert_part_1 . " " . $alert_part_2,
                                'user_id' => $user_id,
                                'profile_pic_id' => $sp_id,
                                'status' => 2,
                                'created_on' => $date,
                                'api' => 'user/update_reschedule_status_by_sp',
                                'accept_text' => 'Acccept',
                                'reject_text' => 'Reject',
                                'accept_response' => 12,
                                'reject_response' => 13,
                                'updated_on' => $date,
                                'booking_id' => $booking_ref_id,
                                'post_id' => 'Null',
                                'reschedule_id' => $reschedule_id,
                                'status_code_id' => 10,
                                'created_on' => $date,
                                'expiry' => date('Y-m-d H:i:s', strtotime($json->rescheduled_date . " " . $json->rescheduled_time_slot_from))
                            ];

                            $common->insert_records_dynamically('alert_action_user', $arr_alerts1);
                        }

                        return $this->respond([
                            "booking_id" => $json->booking_id,
                            "reschedule_id" => $reschedule_id,
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to Reschedule Booking"
                        ]);
                    }
                } else {
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
        if (
            !property_exists($json, 'booking_id') || !property_exists($json, 'reschedule_id') || !property_exists($json, 'status_id') || !property_exists($json, 'user_type')
            || !property_exists($json, 'sp_id') || !property_exists($json, 'key')
        ) {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $common = new CommonModel();
            $misc_model = new MiscModel();
            $sms_model = new SmsTemplateModel();
            $date = date('Y-m-d H:i:s');

            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
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

                //Get data from re_schedule table
                $arr_reschedule_details = $common->get_details_dynamically('re_schedule', 'reschedule_id', $reschedule_id);

                if ($arr_reschedule_details != 'failure') {

                    $scheduled_date = $arr_reschedule_details[0]['scheduled_date'];
                    $scheduled_time_slot = ($arr_reschedule_details[0]['scheduled_time_slot_id']) ? $arr_reschedule_details[0]['scheduled_time_slot_id'] . ":00:00" : "00:00:00";
                    $rescheduled_date = $arr_reschedule_details[0]['rescheduled_date'];
                    $rescheduled_time_slot_id = $arr_reschedule_details[0]['rescheduled_time_slot_id'];
                    $rescheduled_time_slot = ($arr_reschedule_details[0]['rescheduled_time_slot_id']) ? $arr_reschedule_details[0]['rescheduled_time_slot_id'] . ":00:00" : "00:00:00";


                    if ($status_id == 12) { //12 - Reschedule Accepted

                        $arr_booking['scheduled_date'] = $arr_reschedule_details[0]['rescheduled_date'];
                        $arr_booking['time_slot_id'] = $arr_reschedule_details[0]['rescheduled_time_slot_id'];

                        //Remove the sp from the sp_busy_slot
                        $common->delete_records_dynamically('sp_busy_slot', 'booking_id', $booking_id);

                        //Create SP Busy Slot Again
                        $busy_slot = [
                            'users_id' => $json->sp_id,
                            'date' => $rescheduled_date,
                            'time_slot_id' => $rescheduled_time_slot_id,
                            'booking_id' => $booking_id,
                            'created_on' => $date
                        ];

                        $common->insert_records_dynamically('sp_busy_slot', $busy_slot);
                    }
                }


                $common->update_records_dynamically('booking', $arr_booking, 'id', $json->booking_id);

                $arr_booking_status['booking_id'] = $json->booking_id;
                $arr_booking_status['status_id'] = $status_id;
                $arr_booking_status['sp_id'] = $json->sp_id;
                $arr_booking_status['created_on'] = $date;

                $common->insert_records_dynamically('booking_status', $arr_booking_status);

                $arr_user_details = $misc_model->get_user_name_by_booking($json->booking_id, $json->users_id);
                if ($arr_user_details != "failure") {
                    $user_name = $arr_user_details['fname'] . " " . $arr_user_details['lname'];
                    $user_id = $arr_user_details['users_id'];
                    $job_title = $arr_user_details['title'];
                    $sp_id = $arr_user_details['sp_id'];
                    $user_mobile = $arr_user_details['mobile'];
                    $user_profile_pic = $arr_user_details['profile_pic'];
                }

                $arr_sp_details = $common->get_details_dynamically('user_details', 'id', $json->sp_id);
                if ($arr_sp_details != 'failure') {
                    $sp_name = $arr_sp_details[0]['fname'] . " " . $arr_sp_details[0]['lname'];
                    $sp_mobile = $arr_sp_details[0]['mobile'];
                }

                $alert_accept = "succesfully accepted the reschedule request for Booking ID: " . $booking_ref_id . " from";
                $alert_reject = "rejected the reschedule request for Booking ID: " . $booking_ref_id . " from";
                $alert_part_2 = date('d-m-Y', strtotime($scheduled_date)) . " " . $scheduled_time_slot . " to " . date('d-m-Y', strtotime($rescheduled_date)) . " " . $rescheduled_time_slot;


                if ($json->user_type == 'User') {
                    if ($status_id == 12) {
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

                        //Insert into alert_regular_user

                        $arr_alerts = array(
                            'type_id' => 9,
                            'description' => "You have " . $alert_accept . " " . $alert_part_2,
                            'user_id' => $user_id,
                            'profile_pic_id' => $user_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                        //Mark Previous alert in alert_action_user as read

                        $where = [
                            'booking_id' => $booking_ref_id,
                            'type_id' => 9,
                            'post_id' => 0,
                            'user_id' => $user_id,
                            'status_code_id' => 10,
                            'status' => 2
                        ];


                        $al = $common->get_details_with_multiple_where('alert_action_user', $where);

                        if ($al != 'failure') {
                            $alert_id = $al[0]['id'];

                            $common->update_records_dynamically('alert_action_user', ['status' => 1, 'updated_on' => $date], 'id', $alert_id);
                        }

                        //Insert into alert_regular_sp

                        $arr_alerts1 = array(
                            'type_id' => 9,
                            'description' => $user_name . " has " . $alert_accept . " " . $alert_part_2,
                            'user_id' => $sp_id,
                            'profile_pic_id' => $user_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);
                    } else {
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


                        //Insert into alert_regular_user
                        $date = date('Y-m-d H:i:s');

                        $arr_alerts = array(
                            'type_id' => 9,
                            'description' => "You have " . $alert_reject . " " . $alert_part_2,
                            'user_id' => $user_id,
                            'profile_pic_id' => $user_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                        //Mark Previous alert in alert_action_user as read

                        $where = [
                            'booking_id' => $booking_ref_id,
                            'type_id' => 9,
                            'post_id' => 0,
                            'user_id' => $user_id,
                            'status_code_id' => 10,
                            'status' => 2
                        ];

                        $al = $common->get_details_with_multiple_where('alert_action_user', $where);

                        if ($al != 'failure') {
                            $alert_id = $al[0]['id'];

                            $common->update_records_dynamically('alert_action_user', ['status' => 1, 'updated_on' => $date], 'id', $alert_id);
                        }

                        //Insert into alert_regular_sp

                        $arr_alerts1 = array(
                            'type_id' => 9,
                            'description' => $user_name . " has " . $alert_reject . " " . $alert_part_2,
                            'user_id' => $sp_id,
                            'profile_pic_id' => $user_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);
                    }
                } else if ($json->user_type == 'SP') {
                    $arr_sp_details = $misc_model->get_sp_name_by_booking($json->booking_id, $json->sp_id);
                    if ($arr_sp_details != "failure") {
                        $sp_name = $arr_sp_details['fname'] . " " . $arr_sp_details['lname'];
                        $sp_id = $arr_sp_details['sp_id'];
                        $job_title = $arr_sp_details['title'];
                        $sp_profile_pic = $arr_sp_details['profile_pic'];
                    }


                    if ($status_id == 12) {
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


                        //Insert into alert_regular_sp

                        $arr_alerts = array(
                            'type_id' => 9,
                            'description' => "You have " . $alert_accept . " " . $alert_part_2,
                            'user_id' => $sp_id,
                            'profile_pic_id' => $sp_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);


                        //Mark Previous alert in alert_action_sp as read

                        $where = [
                            'booking_id' => $booking_ref_id,
                            'type_id' => 9,
                            'post_id' => 0,
                            'user_id' => $sp_id,
                            'status_code_id' => 10,
                            'status' => 2
                        ];

                        $al = $common->get_details_with_multiple_where('alert_action_sp', $where);
                        if ($al != 'failure') {
                            $alert_id = $al[0]['id'];

                            $common->update_records_dynamically('alert_action_sp', ['status' => 1, 'updated_on' => $date], 'id', $alert_id);
                        }
                        //Insert into alert_regular_user

                        $arr_alerts1 = array(
                            'type_id' => 9,
                            'description' => $sp_name . " has " . $alert_accept . " " . $alert_part_2,
                            'user_id' => $user_id,
                            'profile_pic_id' => $sp_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts1);
                    } else {
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


                        //Insert into alert_regular_sp

                        $arr_alerts = array(
                            'type_id' => 9,
                            'description' => "You have " . $alert_reject . " " . $alert_part_2,
                            'user_id' => $sp_id,
                            'profile_pic_id' => $sp_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);


                        //Mark Previous alert in alert_action_sp as read

                        $where = [
                            'booking_id' => $booking_ref_id,
                            'type_id' => 9,
                            'post_id' => 0,
                            'user_id' => $sp_id,
                            'status_code_id' => 10,
                            'status' => 2
                        ];

                        $al = $common->get_details_with_multiple_where('alert_action_sp', $where);
                        if ($al != 'failure') {
                            $alert_id = $al[0]['id'];
                            $common->update_records_dynamically('alert_action_sp', ['status' => 1, 'updated_on' => $date], 'id', $alert_id);
                        }


                        //Insert into alert_regular_user

                        $arr_alerts1 = array(
                            'type_id' => 9,
                            'description' => $sp_name . " has " . $alert_reject . " " . $alert_part_2,
                            'user_id' => $user_id,
                            'profile_pic_id' => $sp_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts1);
                    }
                }

                return $this->respond([
                    "status" => 200,
                    "message" =>  "Successfully Updated"
                ]);
            } else {
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
        if (
            !property_exists($json, 'booking_id') || !property_exists($json,'status_id') || !property_exists($json,'reasons')
            || !property_exists($json,'cancelled_by') || !property_exists($json,'key')
        ) {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $common = new CommonModel();
            $misc = new MiscModel();
            $date = date('Y-m-d H:i:s');

            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $status_id = $json->status_id;
                $booking_id = $json->booking_id;


                $booking_data = $misc->booking_with_time_slot($booking_id);
                $users_id = $booking_data[0]['users_id'];
                $sp_id = $booking_data[0]['sp_id'];

                $booking_amount = $booking_data[0]['amount'];
                $tot_amount = $booking_data[0]['amount'] + $booking_data[0]['cgst'] + $booking_data[0]['sgst'];

                //Check whether the booking is still pending
                if ($booking_data[0]['status_id'] >= 22 && $booking_data[0]['status_id'] <= 25) {

                    return $this->respond([
                        "status" => 403,
                        "message" =>  "Booking is either cancelled or completed"
                    ]);
                } else {

                    //Calculation of Cancellation Charges
                    $created_on = new DateTime($booking_data[0]['created_on']);

                    $sch_date = $booking_data[0]['scheduled_date'];
                    $sch_time = $booking_data[0]['from'];

                    $schedule_on = new DateTime($sch_date . ' ' . $sch_time);
                    $now = new DateTime(date('Y-m-d H:i:s'));

                    
                    //Difference between created and Scheduled Times
                    $diff = $created_on->diff($schedule_on);
                    $diff_days = $diff->format('%a');
                    $diff_hr = $diff->format('%H');
                    $diff_min = $diff->format('%I');

                    //Difference between scheduled and Cancellation Timings
                    $diff1 = $schedule_on->diff($now);
                    $hr_diff = $diff1->format('%H');
                    $min_diff = $diff1->format('%I');
                    


                    $ch = $common->get_table_details_dynamically('tax_cancel_charges');

                    foreach ($ch as $c) {
                        if ($c['id'] == 4) {
                            $ch_percentage_15 = $c['percentage'];
                            $ch_amount_15 = $c['amount'];
                        } elseif ($c['id'] == 5) {
                            $ch_percentage_30 = $c['percentage'];
                            $ch_amount_30 = $c['amount'];
                        } elseif ($c['id'] == 6) {
                            $ch_percentage = $c['percentage'];
                            $ch_amount = $c['amount'];
                        }
                    }


                    if (($diff_days > 0) || ($diff_days == 0 && $diff_hr >= 1)) {
                        
                        if ($status_id == 24) {
                            //cancel_charges_common to user wallet	
                            // $cancel_charges = ($ch_percentage == 0 || ($ch_percentage * $booking_amount / 100) > $ch_amount ? $ch_amount : ($ch_percentage * $booking_amount / 100));
                            $cancel_charges = 0;
                        }elseif ($status_id == 25) {
                            //cancel_charges_common to sp wallet
                            $cancel_charges = ($ch_percentage == 0 || ($ch_percentage * $booking_amount / 100) > $ch_amount ? $ch_amount : ($ch_percentage * $booking_amount / 100));
                            
                        }

                    } else {
                        
                        if ($status_id == 24) {
                            //Charges based on time difference to user wallet	
                            if ($min_diff < 15) {

                                $cancel_charges = ($ch_percentage_15 == 0 || ($ch_percentage_15 * $booking_amount / 100) > $ch_amount_15 ? $ch_amount_15 : ($ch_percentage_15 * $booking_amount / 100));
                            } elseif ($min_diff < 30) {

                                $cancel_charges = ($ch_percentage_30 == 0 || ($ch_percentage_30 * $booking_amount / 100) > $ch_amount_30 ? $ch_amount_30 : ($ch_percentage_30 * $booking_amount / 100));
                            } else {
                                $cancel_charges = ($ch_percentage == 0 || ($ch_percentage * $booking_amount / 100) > $ch_amount ? $ch_amount : ($ch_percentage * $booking_amount / 100));
                            }
                        }

                        if ($status_id == 25) {
                            //cancel_charges_common to sp wallet
                            $cancel_charges = ($ch_percentage == 0 || ($ch_percentage * $booking_amount / 100) > $ch_amount ? $ch_amount : ($ch_percentage * $booking_amount / 100));
                        }
                    }

                    $cancel = number_format(ceil($cancel_charges), 2, '.', '');

                    //Insert into Transaction Table

                    if ($status_id == 24) {

                        $user_refund = $tot_amount - $cancel;
                        $cancelled_by = $users_id;
                    } elseif ($status_id == 25) {

                        $user_refund = $tot_amount;
                        $cancelled_by = $sp_id;
                    }

                    $arr = [
                        [
                            'name_id' => 4,
                            'date' => date('Y-m-d'),
                            'amount' => ($cancel <= 0 ? 0 : $cancel),
                            'type_id' => 2,
                            'users_id' => $cancelled_by,
                            'method_id' => 2,
                            'reference_id' => "W-" . rand(1, 99999),
                            'booking_id' => $booking_id,
                            'payment_status' => "Success",
                            'created_dts' => $date
                        ],
                        [
                            'name_id' => 8,
                            'date' => date('Y-m-d'),
                            'amount' => ($user_refund <= 0 ? 0 : $user_refund),
                            'type_id' => 1,
                            'users_id' => $users_id,
                            'method_id' => 2,
                            'reference_id' => "W-" . rand(1, 99999),
                            'booking_id' => $booking_id,
                            'payment_status' => "Success",
                            'created_dts' => $date
                        ]
                    ];


                    $common->batch_insert_records_dynamically('transaction', $arr);



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
                        'amount' => 0,
                        'cgst' => 0,
                        'sgst' => 0
                    );
                    $common->update_records_dynamically('booking', $arr_booking, 'id', $booking_id);

                    //Remove the sp from the sp_busy_slot
                    $common->delete_records_dynamically('sp_busy_slot', 'booking_id', $booking_id);

                    //Insert to booking status
                    $arr_booking_status['booking_id'] = $booking_id;
                    $arr_booking_status['status_id'] = $status_id;
                    $arr_booking_status['created_on'] = $date;
                    $common->insert_records_dynamically('booking_status', $arr_booking_status);


                    //Wallet Balance release and deduction of cancel charges
                    $arr_wallet_details_user = $common->get_details_dynamically('wallet_balance', 'users_id', $users_id);
                    $arr_wallet_details_sp = $common->get_details_dynamically('wallet_balance', 'users_id', $sp_id);

                    if ($status_id == 24) {

                        if ($arr_wallet_details_user != 'failure') {
                            //Get total amount and blocked amount
                            $wallet_amount = $arr_wallet_details_user[0]['amount'] + ($user_refund <= 0 ? 0 : $user_refund);
                            $wallet_amount_blocked = $arr_wallet_details_user[0]['amount_blocked'] - ($cancel <= 0 ? 0 : $cancel) - ($user_refund <= 0 ? 0 : $user_refund);

                            $arr_update_wallet_data = array(
                                'amount' => $wallet_amount,
                                'amount_blocked' => $wallet_amount_blocked
                            );
                            $common->update_records_dynamically('wallet_balance', $arr_update_wallet_data, 'users_id', $users_id);
                        } else {

                            return $this->respond([
                                "status" => 404,
                                "message" =>  "Unable to fetch wallet balance",
                            ]);
                        }
                    } elseif ($status_id == 25) {

                        if ($arr_wallet_details_user != 'failure') {
                            //Get total amount and blocked amount
                            $wallet_amount = $arr_wallet_details_user[0]['amount'] + ($user_refund <= 0 ? 0 : $user_refund);
                            $wallet_amount_blocked = $arr_wallet_details_user[0]['amount_blocked'] - ($user_refund <= 0 ? 0 : $user_refund);

                            $arr_update_wallet_data = array(
                                'amount' => $wallet_amount,
                                'amount_blocked' => $wallet_amount_blocked
                            );
                            $common->update_records_dynamically('wallet_balance', $arr_update_wallet_data, 'users_id', $users_id);
                        } else {

                            return $this->respond([
                                "status" => 404,
                                "message" =>  "Unable to fetch wallet balance",
                            ]);
                        }

                        if ($arr_wallet_details_sp != 'failure') {
                            //Get total amount and blocked amount
                            $wallet_amount = $arr_wallet_details_sp[0]['amount'] - ($cancel <= 0 ? 0 : $cancel);

                            $arr_update_wallet_data = array(
                                'amount' => $wallet_amount,
                                'amount_blocked' => $wallet_amount_blocked
                            );
                            $common->update_records_dynamically('wallet_balance', $arr_update_wallet_data, 'users_id', $users_id);
                        } else {

                            $arr2 = [
                                'sp_id' => $sp_id,
                                'amount' => $cancel,
                                'booking_id' => $booking_id
                            ];

                            $common->insert_records_dynamically('wallet_debts', $arr2);
                        }
                    }

                    //Insert into Alerts

                    $user_profile = $misc->user_info($users_id);
                    $sp_profile = $misc->user_info($sp_id);


                    if ($status_id == 24) {

                        //Insert into alert_regular_user
                        $arr_alerts = array(
                            'type_id' => 1,
                            'description' => "You have succesfully cancelled the booking ID:" . $booking_id,
                            'user_id' => $users_id,
                            'profile_pic_id' => $users_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts);

                        //Insert into alert_regular_sp
                        $arr_alerts1 = array(
                            'type_id' => 1,
                            'description' => $user_profile[0]['fname'] . " " . $user_profile[0]['lname'] . "has cancelled the booking ID:" . $booking_id,
                            'user_id' => $sp_id,
                            'profile_pic_id' => $sp_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);
                    } elseif ($status_id == 25) {

                        //Insert into alert_regular_sp
                        $arr_alerts = array(
                            'type_id' => 1,
                            'description' => "You have succesfully cancelled the booking ID:" . $booking_id,
                            'user_id' => $sp_id,
                            'profile_pic_id' => $sp_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);

                        //Insert into alert_regular_user
                        $arr_alerts1 = array(
                            'type_id' => 1,
                            'description' => $sp_profile[0]['fname'] . " " . $sp_profile[0]['lname'] . "has cancelled the booking ID:" . $booking_id,
                            'user_id' => $users_id,
                            'profile_pic_id' => $users_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts1);
                    }


                    return $this->respond([
                        "status" => 200,
                        "message" =>  "Booking Cancelled Successfully",

                    ]);
                }
            } else {
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
        if ($validate_key == "" || $sp_id == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $misc_model = new MiscModel();

                $ar_sp_id = array();
                $arr_slots_data = array();
                $arr_temp = array();
                $arr_temp_blocked = array();

                $ar_sp_id[$sp_id] = $sp_id;

                //Get SP's preferred day/timeslot data
                $arr_preferred_time_slots_list = $misc_model->get_sp_preferred_time_slot($ar_sp_id);
                if ($arr_preferred_time_slots_list != 'failure') {
                    foreach ($arr_preferred_time_slots_list as $key => $slot_data) {
                        $arr_temp[$slot_data['users_id']][$key]['day_slot'] = $slot_data['day_slot'];
                        $arr_temp[$slot_data['users_id']][$key]['time_slot_from'] = $slot_data['time_slot_from'];
                        $arr_temp[$slot_data['users_id']][$key]['time_slot_to'] = $slot_data['time_slot_to'];
                    }
                }

                //Get SP's blocked data
                $arr_blocked_time_slots_list = $misc_model->get_sp_blocked_time_slot($ar_sp_id);
                if ($arr_blocked_time_slots_list != 'failure') {
                    foreach ($arr_blocked_time_slots_list as $key => $blocked_data) {
                        $arr_temp_blocked[$slot_data['users_id']][$key]['time_slot_from'] = $blocked_data['from'];
                        $arr_temp_blocked[$slot_data['users_id']][$key]['date'] = $blocked_data['date'];
                    }
                }

                if (count($ar_sp_id) > 0) {
                    foreach ($ar_sp_id as $sp_id) {
                        if (isset($arr_temp[$sp_id])) {
                            $arr_slots_data["preferred_time_slots"] = $arr_temp[$slot_data['users_id']];
                            $arr_slots_data["blocked_time_slots"] = (isset($arr_temp_blocked[$slot_data['users_id']])) ? $arr_temp_blocked[$slot_data['users_id']] : array();
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
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    public function get_otp_token($length = 4)
    {
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
        if (!property_exists($json, 'booking_id') || !property_exists($json, 'status_id') || !property_exists($json, 'key')) {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $common = new CommonModel();
            $misc_model = new MiscModel();
            $date = date('Y-m-d H:i:s');

            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $status_id = $json->status_id; //status_id = 1 for accepted and 2 for rejected
                $booking_id = $json->booking_id;
                $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);


                $user_name = "";
                $sp_id = 0;
                $user_id = 0;

                $arr_user_details = $misc_model->get_user_name_by_booking($booking_id);
                if ($arr_user_details != "failure") {
                    $user_name = $arr_user_details['fname'] . " " . $arr_user_details['lname'];
                    $user_id = $arr_user_details['users_id'];
                    $sp_id = $arr_user_details['sp_id'];
                    $user_profile_pic = $arr_user_details['profile_pic'];
                }

                //Mark the status
                $arr_extra_demand = array(
                    'status' => $status_id,
                );
                $common->update_records_dynamically('extra_demand', $arr_extra_demand, 'booking_id', $booking_id);

                $booking_status_id = ($status_id == 1 ? 38 : 39); //38-extra demand accepted/39-extra demand rejected


                //Insert into booking status
                $arr_booking_status = array(
                    'booking_id' => $json->booking_id,
                    'status_id' => $booking_status_id, //extra demand accepted/extra demand rejected
                    'description' => ($booking_status_id == 39 ? "Extra Demand Rejected" : "Extra Demand Accepted"),
                    'created_on' => $date
                );

                if (($common->get_details_with_multiple_where('booking_status', $arr_booking_status)) == 'failure') {

                    $common->insert_records_dynamically('booking_status', $arr_booking_status);
                }


                if ($status_id == 38) {

                    //Insert into alert_regular_user

                    $arr_alerts = array(
                        'type_id' => 7,
                        'description' => "You have succesfully accepted the extra demand for Booking ID: " . $booking_ref_id . "on " . $date,
                        'user_id' => $user_id,
                        'profile_pic_id' => $user_id,
                        'status' => 2,
                        'created_on' => $date,
                        'updated_on' => $date
                    );

                    $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                    //Mark Previous alert in alert_action_user as read

                    $where = [
                        'booking_id' => $booking_ref_id,
                        'type_id' => 7,
                        'post_id' => Null,
                        'user_id' => $user_id,
                        'status_code_id' => 37
                    ];

                    $al = $common->get_details_with_multiple_where('alert_action_user', $where);
                    $alert_id = $al[0]['id'];

                    $common->update_records_dynamically('alert_action_user', ['status' => 1, 'updated_on' => $date], 'id', $alert_id);

                    //Insert into alert_regular_sp

                    $arr_alerts1 = array(
                        'type_id' => 9,
                        'description' => $user_name . " has accepted the extra demand for Booking ID: " . $booking_ref_id . "on " . $date,
                        'user_id' => $sp_id,
                        'profile_pic_id' => $user_id,
                        'status' => 2,
                        'created_on' => $date,
                        'updated_on' => $date
                    );

                    $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);
                } else {


                    //Insert into alert_regular_user

                    $arr_alerts = array(
                        'type_id' => 7,
                        'description' => "You have rejected the extra demand for Booking ID: " . $booking_ref_id . "on " . $date,
                        'user_id' => $user_id,
                        'profile_pic_id' => $user_id,
                        'status' => 2,
                        'created_on' => $date,
                        'updated_on' => $date
                    );

                    $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                    //Mark Previous alert in alert_action_user as read

                    $where = [
                        'booking_id' => $booking_ref_id,
                        'type_id' => 7,
                        'post_id' => 0,
                        'user_id' => $user_id,
                        'status_code_id' => 37
                    ];

                    $al = $common->get_details_with_multiple_where('alert_action_user', $where);
                    
                    $alert_id = $al[0]['id'];

                    $common->update_records_dynamically('alert_action_user', ['status' => 1, 'updated_on' => $date], 'id', $alert_id);

                    //Insert into alert_regular_sp

                    $arr_alerts1 = array(
                        'type_id' => 9,
                        'description' => $user_name . " has rejected the extra demand for Booking ID: " . $booking_ref_id . "on " . $date,
                        'user_id' => $sp_id,
                        'profile_pic_id' => $user_id,
                        'status' => 2,
                        'created_on' => $date,
                        'updated_on' => $date
                    );

                    $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);
                }

                return $this->respond([
                    "status" => 200,
                    "message" =>  "Status updated Successfully"
                ]);
            } else {
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

        if ($validate_key == "" || $validate_post_job_id == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $job_post_model = new JobPostModel();

                $post_job_id = $validate_post_job_id;

                //Get Goals/Installments
                $arr_goals_installments = $job_post_model->get_goals_installments_requested_list($post_job_id);

                if ($arr_goals_installments != 'failure') {

                    return $this->respond([
                        "goals_installments_details" => $arr_goals_installments,
                        "status" => 200,
                        "message" => "Success",
                    ]);
                } else {
                    return $this->respond([
                        "job_post_id" => $validate_post_job_id,
                        "status" => 404,
                        "message" => "No Goals/Installments found"
                    ]);
                }
            } else {
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

        if ($validate_key == "" || $validate_booking_id == "") {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($validate_key); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $misc_model = new MiscModel();

                $booking_id = $validate_booking_id;

                //Get booking statuses
                $arr_booking_status = $misc_model->get_booking_status_list($booking_id);

                if ($arr_booking_status != 'failure') {

                    return $this->respond([
                        "booking_status_details" => $arr_booking_status,
                        "status" => 200,
                        "message" => "Success",
                    ]);
                } else {
                    return $this->respond([
                        "booking_status_details" => [],
                        "status" => 200,
                        "message" => "Success",
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

    //---------------------------------------------------------Booking Complete API-------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    public function complete_booking()
    {
        if ($this->request->getMethod() != 'post') {

            return $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();


            if (
                !property_exists($json, 'booking_id') || !property_exists($json, 'users_id')  || !property_exists($json, 'sp_id') || !property_exists($json, 'order_id')
                || !property_exists($json, 'completed_at') || !property_exists($json, 'total_amount') || !property_exists($json, 'amount')
                || !property_exists($json, 'cgst') || !property_exists($json, 'sgst') || !property_exists($json, 'key') || !property_exists($json, 'w_amount')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();
                $date = date('Y-m-d H:i:s');

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $misc_model = new MiscModel();
                    $paytm = new PaytmModel();

                    $booking_id = $json->booking_id;

                    //Booking Completion code starts here

                    //Check whether Order ID is not Empty
                    if(!empty($json->order_id) && $json->amount != 0){

                        //update Booking table
                    $check = $common->get_details_dynamically('transaction', 'order_id', $json->order_id);

                    if ($check != 'failure' && $check[0]['payment_status'] != "TXN_FAILURE") {
                        return $this->respond([
                            'status' => 404,
                            'message' => 'Order ID already Used'
                        ]);
                    } else {

                        $result = $paytm->verify_txn($json->order_id);
                        $result = json_decode($result, true);

                        if ($json->amount != 0) {
                            $payment_status = ($result['body']['resultInfo']['resultStatus'] == 'TXN_FAILURE' ? "TXN_FAILURE" : "TXN_SUCCESS");
                        } else {
                            $payment_status = "TXN_SUCCESS";
                        }

                        $arr_transaction = array();

                        if ($json->amount != 0 && $result['body']['resultInfo']['resultStatus'] == 'TXN_FAILURE') {

                            $arr_payment_status = $result['body']['resultInfo']['resultStatus'];
                            $arr_txnId = $result['body']['txnId'];
                            $arr_bankTxnId = "";
                            $arr_txnType = "";
                            $arr_gatewayName =  "";
                            $arr_bankName = "";
                            $arr_paymentMode = "";
                            $arr_refundAmt = "";
                        } elseif ($json->amount != 0 && $result['body']['resultInfo']['resultStatus'] == 'TXN_SUCCESS') {

                            
                            $arr_payment_status = $result['body']['resultInfo']['resultStatus'];
                            $arr_txnId = $result['body']['txnId'];
                            $arr_bankTxnId =  $result['body']['bankTxnId'];
                            $arr_txnType = $result['body']['txnType'];
                            $arr_gatewayName =  $result['body']['gatewayName'];
                            $arr_bankName = (isset($result['body']['bankName']) ? $result['body']['bankName'] : "");
                            $arr_paymentMode = $result['body']['paymentMode'];
                            $arr_refundAmt = $result['body']['refundAmt'];
                        }

                        if ($payment_status == "TXN_SUCCESS") {


                            $booking_data = $common->get_details_dynamically('booking', 'id', $booking_id);
                            
                            if ($booking_data != "failure" && $booking_data[0]['status_id'] != 23) {

                                $cgst = $booking_data[0]['cgst'] + $json->cgst;
                                $sgst = $booking_data[0]['sgst'] + $json->sgst;
                                $amount = $booking_data[0]['amount'] + $json->amount + $json->w_amount - $sgst - $cgst;
                                $inv_amount = $amount + $cgst + $sgst;

                                $arr = array(

                                    'completed_at' => $date,
                                    'amount' => $inv_amount,
                                    'sgst' => $sgst,
                                    'cgst' => $cgst,
                                    'status_id' => 23
                                );

                                $common->update_records_dynamically('booking', $arr, 'id', $booking_id);

                                //Booking Status table update

                                $arr1 = array(
                                    'booking_id' => $booking_id,
                                    'status_id' => 23,
                                    'sp_id' => $json->sp_id
                                );

                                $arr2 = array(
                                    'booking_id' => $booking_id,
                                    'status_id' => 23,
                                    'sp_id' => $json->sp_id,
                                    'created_on' => $date,
                                    'description' => "Booking Completed"
                                );



                                if (($common->get_details_with_multiple_where('booking_status', $arr1)) == 'failure') {

                                    $common->insert_records_dynamically('booking_status', $arr2);
                                }


                                //Platform Fees & SP Amount Calculation

                                $fees = $common->get_table_details_dynamically('tax_cancel_charges');
                                foreach ($fees as $fe) {
                                    if ($fe['id'] == 7) {
                                        $tds_percentage = $fe['percentage'];
                                    }
                                    if ($fe['id'] == 8) {
                                        $platform_fee_percentage = $fe['percentage'];
                                    }
                                    if ($fe['id'] == 9) {
                                        $commission_percentage = $fe['percentage'];
                                    }
                                }

                                $platform_fees = ceil($amount * $platform_fee_percentage / 100);
                                $commission_ref = ceil($platform_fees * $commission_percentage / 100);
                                $sp_ref = $amount - $platform_fees;
                                $tds_amount = ceil($sp_ref * $tds_percentage / 100);
                                $sp_amount = $sp_ref - $tds_amount;

                                //Get referral of user & sp
                                $ref1 = $common->get_details_dynamically('referral', 'user_id', $json->users_id);
                                $user_ref = $ref1[0]['referred_by'];

                                $ref2 = $common->get_details_dynamically('referral', 'user_id', $json->sp_id);
                                $sp_ref = $ref2[0]['referred_by'];

                                //Transaction table update


                                $arr2 = [
                                    [
                                        'name_id' => 3, //Invoice Amount
                                        'date' => date('Y-m-d'),
                                        'amount' => $json->amount,
                                        'type_id' => 1, //Receipts
                                        'users_id' => $json->users_id,
                                        'method_id' => 1,
                                        'reference_id' => $arr_txnId,
                                        'booking_id' => $booking_id,
                                        'order_id' => $json->order_id,
                                        'payment_status' => $arr_payment_status,
                                        'created_dts' => $date,
                                        'txnId' => $arr_txnId,
                                        'bankTxnId' => $arr_bankTxnId,
                                        'txnType' => $arr_txnType,
                                        'gatewayName' => $arr_gatewayName,
                                        'bankName' => $arr_bankName,
                                        'paymentMode' => $arr_paymentMode,
                                        'refundAmt' => $arr_refundAmt
                                    ],
                                    [
                                        'name_id' => 3, //Invoice Amount
                                        'date' => date('Y-m-d'),
                                        'amount' => $json->w_amount,
                                        'type_id' => 1, //Receipts
                                        'users_id' => $json->users_id,
                                        'method_id' => 2,
                                        'reference_id' => "W-" . rand(1, 999999),
                                        'booking_id' => $booking_id,
                                        'order_id' => $json->order_id,
                                        'payment_status' => $payment_status,
                                        'created_dts' => $date,
                                        'txnId' => "",
                                        'bankTxnId' => "",
                                        'txnType' => "",
                                        'gatewayName' => "",
                                        'bankName' => "",
                                        'paymentMode' => "",
                                        'refundAmt' => ""
                                    ],
                                    [
                                        'name_id' => 10, //Add to Wallet User
                                        'date' => date('Y-m-d'),
                                        'amount' => $json->w_amount + $json->amount,
                                        'type_id' => 1, //Receipts
                                        'users_id' => $json->users_id,
                                        'method_id' => 2, //Wallet Transfer
                                        'reference_id' => "W-" . rand(1, 999999),
                                        'booking_id' => $booking_id,
                                        'order_id' => $json->order_id,
                                        'payment_status' => $payment_status,
                                        'created_dts' => $date,
                                        'txnId' => "",
                                        'bankTxnId' => "",
                                        'txnType' => "",
                                        'gatewayName' => "",
                                        'bankName' => "",
                                        'paymentMode' => "",
                                        'refundAmt' => ""
                                    ],
                                    [
                                        'name_id' => 3, //Invoice Amount remove from User Wallet
                                        'date' => date('Y-m-d'),
                                        'amount' => $inv_amount,
                                        'type_id' => 2, //Payments
                                        'users_id' => $json->users_id,
                                        'method_id' => 2, //Wallet Transfer
                                        'reference_id' => "W-" . rand(1, 999999),
                                        'booking_id' => $booking_id,
                                        'order_id' => $json->order_id,
                                        'payment_status' => $payment_status,
                                        'created_dts' => $date,
                                        'txnId' => "",
                                        'bankTxnId' => "",
                                        'txnType' => "",
                                        'gatewayName' => "",
                                        'bankName' => "",
                                        'paymentMode' => "",
                                        'refundAmt' => ""
                                    ],
                                    [
                                        'name_id' => 10, //Add to wallet SP
                                        'date' => date('Y-m-d'),
                                        'amount' => $sp_amount,
                                        'type_id' => 2,
                                        'users_id' => $json->sp_id,
                                        'method_id' => 2,
                                        'reference_id' => "W-" . rand(1, 999999),
                                        'booking_id' => $booking_id,
                                        'order_id' => $json->order_id,
                                        'payment_status' => $payment_status,
                                        'created_dts' => $date,
                                        'txnId' => "",
                                        'bankTxnId' => "",
                                        'txnType' => "",
                                        'gatewayName' => "",
                                        'bankName' => "",
                                        'paymentMode' => "",
                                        'refundAmt' => ""
                                    ],
                                    [
                                        'name_id' => 13, //Add to sp ref
                                        'date' => date('Y-m-d'),
                                        'amount' => $commission_ref,
                                        'type_id' => 1,
                                        'users_id' => ($user_ref == 'NoRef' ? 0 : $user_ref),
                                        'method_id' => 3, //Transfer Commission
                                        'reference_id' => "W-" . rand(1, 999999),
                                        'booking_id' => $booking_id,
                                        'order_id' => $json->order_id,
                                        'payment_status' => $payment_status,
                                        'created_dts' => $date,
                                        'txnId' => "",
                                        'bankTxnId' => "",
                                        'txnType' => "",
                                        'gatewayName' => "",
                                        'bankName' => "",
                                        'paymentMode' => "",
                                        'refundAmt' => ""
                                    ],
                                    [
                                        'name_id' => 13, //Add to sp ref
                                        'date' => date('Y-m-d'),
                                        'amount' => $commission_ref,
                                        'type_id' => 1,
                                        'users_id' => ($sp_ref == 'NoRef' ? 0 : $sp_ref),
                                        'method_id' => 3, //Transfer Commission
                                        'reference_id' => "W-" . rand(1, 999999),
                                        'booking_id' => $booking_id,
                                        'order_id' => $json->order_id,
                                        'payment_status' => $payment_status,
                                        'created_dts' => $date,
                                        'txnId' => "",
                                        'bankTxnId' => "",
                                        'txnType' => "",
                                        'gatewayName' => "",
                                        'bankName' => "",
                                        'paymentMode' => "",
                                        'refundAmt' => ""
                                    ]
                                ];

                                $tra = $common->batch_insert_records_dynamically('transaction', $arr2);


                                //Update Wallet Balances

                                $wal1 = $common->get_details_dynamically('wallet_balance', 'users_id', $json->users_id);

                                if ($wal1 != 'failure') {

                                    $dat1 = array(
                                        'amount' => $wal1[0]['amount'],
                                        'amount_blocked' => $wal1[0]['amount_blocked'] + $json->w_amount + $json->amount - $inv_amount
                                    );

                                    $common->update_records_dynamically('wallet_balance', $dat1, 'users_id', $json->users_id);
                                } else {
                                    return $this->respond([
                                        'status' => 404,
                                        'message' => 'Unable to fetch users wallet balance'
                                    ]);
                                }


                                $wal2 = $common->get_details_dynamically('wallet_balance', 'users_id', $json->sp_id);

                                if ($wal2 != 'failure') {
                                    $dat2 = array(
                                        'amount' => $wal2[0]['amount'],
                                        'amount_blocked' => $wal2[0]['amount_blocked'] + $sp_amount
                                    );

                                    $common->update_records_dynamically('wallet_balance', $dat2, 'users_id', $json->sp_id);
                                } else {
                                    return $this->respond([
                                        'status' => 404,
                                        'message' => 'Unable to fetch sp wallet balance'
                                    ]);
                                }


                                $wal3 = $common->get_details_dynamically('wallet_balance', 'users_id', $user_ref);

                                if ($wal3 != 'failure' &&  $user_ref != 0) {
                                    $dat3 = array(
                                        'amount' => $wal3[0]['amount'],
                                        'amount_blocked' => $wal3[0]['amount_blocked'] + $commission_ref
                                    );

                                    $common->update_records_dynamically('wallet_balance', $dat3, 'users_id', $user_ref);
                                } else {
                                    return $this->respond([
                                        'status' => 404,
                                        'message' => 'Unable to fetch user ref wallet balance'
                                    ]);
                                }

                                $wal4 = $common->get_details_dynamically('wallet_balance', 'users_id', $sp_ref);

                                if ($wal4 != 'failure' && $sp_ref != 0) {
                                    $dat4 = array(
                                        'amount' => $wal4[0]['amount'],
                                        'amount_blocked' => $wal4[0]['amount_blocked'] + $commission_ref
                                    );

                                    $common->update_records_dynamically('wallet_balance', $dat4, 'users_id', $sp_ref);
                                }

                                //Insert records into lien table

                                // $lien_s = date_create('now');
                                // date_add($lien_s, date_interval_create_from_date_string('24 Hours'));
                                // $lien_e = date_format($lien_s, "Y-m-d H:i:s");

                                // $lien_start = $lien_s->format('Y-m-d H:i:s');
                                // $lien_end = $lien_e;

                                $lien_start = $date;
                                $lien_e = strtotime($date) + (24 * 60 * 60);
                                $lien_end = date('Y-m-d H:i:s', $lien_e);

                                $lien_data = [
                                    [
                                        'lien_start' => $lien_start,
                                        'lien_end' => $lien_end,
                                        'amount' => $sp_amount,
                                        'user_id' => $json->sp_id,
                                        'booking_id' => $booking_id,
                                        'status' => 0
                                    ],
                                    [
                                        'lien_start' => $lien_start,
                                        'lien_end' => $lien_end,
                                        'amount' => $commission_ref,
                                        'user_id' => $user_ref,
                                        'booking_id' => $booking_id,
                                        'status' => 0
                                    ],
                                    [
                                        'lien_start' => $lien_start,
                                        'lien_end' => $lien_end,
                                        'amount' => $commission_ref,
                                        'user_id' => $sp_ref,
                                        'booking_id' => $booking_id,
                                        'status' => 0
                                    ]
                                ];

                                $common->batch_insert_records_dynamically('lien_table', $lien_data);

                                //update company account table

                                $data5 = [

                                    'platform_fees' => $platform_fees,
                                    'user_plan_subs' => 0,
                                    'sp_plan_subs' => 0,
                                    'cancellation_charges' => 0,
                                    'receipt_date' => date('Y-m-d'),
                                    'transaction_id' => $tra

                                ];

                                $common->insert_records_dynamically('company_account', $data5);


                                //update TDS table
                                $data6 = [

                                    'booking_id' => $booking_id,
                                    'tds_amount' => $tds_amount,
                                    'sp_id' => $json->sp_id,
                                    'collected_on' => $date

                                ];

                                $common->insert_records_dynamically('tds_table', $data6);


                                //Insert into alerts_regular_user

                                $sp_profile = $misc_model->user_info($json->sp_id);

                                $arr_alerts = array(
                                    'type_id' => 1,
                                    'description' => $sp_profile[0]['fname'] . " " . $sp_profile[0]['lname'] . "has succesfully Completed the Booking ID: " . $booking_id . " on " . $date,
                                    'user_id' => $json->users_id,
                                    'profile_pic_id' => $json->sp_id,
                                    'status' => 2,
                                    'created_on' => $date,
                                    'updated_on' => $date
                                );

                                $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                                //Insert into alerts_regular_sp
                                $arr_alerts1 = array(
                                    'type_id' => 1,
                                    'description' => "You have succesfully Completed the Booking ID: " . $booking_id . " on " . $date,
                                    'user_id' => $json->sp_id,
                                    'profile_pic_id' => $json->sp_id,
                                    'status' => 2,
                                    'created_on' => $date,
                                    'updated_on' => $date
                                );

                                $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);



                                return $this->respond([
                                    'status' => 200,
                                    'message' => 'Booking Successfully Completed',
                                ]);
                            } else {

                                return $this->respond([
                                    'status' => 404,
                                    'message' => 'Entry for failure status updated'
                                ]);
                            }
                        }
                    }
                    }else{

                        //If Order ID is Empty

                        $booking_data = $common->get_details_dynamically('booking', 'id', $json->booking_id);

                        // print_r($booking_data);
                        // exit;

                            if ($booking_data != "failure" && $booking_data[0]['status_id'] != 23) {

                                $cgst = $booking_data[0]['cgst'] + $json->cgst;
                                $sgst = $booking_data[0]['sgst'] + $json->sgst;
                                $amount = $booking_data[0]['amount'] + $json->amount + $json->w_amount - $sgst - $cgst;
                                $inv_amount = $amount + $cgst + $sgst;

                                $arr = array(

                                    'completed_at' => $date,
                                    'amount' => $inv_amount,
                                    'sgst' => $sgst,
                                    'cgst' => $cgst,
                                    'status_id' => 23
                                );

                                $common->update_records_dynamically('booking', $arr, 'id', $booking_id);

                                //Booking Status table update

                                $arr1 = array(
                                    'booking_id' => $booking_id,
                                    'status_id' => 23,
                                    'sp_id' => $json->sp_id
                                );

                                $arr2 = array(
                                    'booking_id' => $booking_id,
                                    'status_id' => 23,
                                    'sp_id' => $json->sp_id,
                                    'created_on' => $date,
                                    'description' => "Booking Completed"
                                );



                                if (($common->get_details_with_multiple_where('booking_status', $arr1)) == 'failure') {

                                    $common->insert_records_dynamically('booking_status', $arr2);
                                }


                                //Platform Fees & SP Amount Calculation

                                $fees = $common->get_table_details_dynamically('tax_cancel_charges');
                                foreach ($fees as $fe) {
                                    if ($fe['id'] == 7) {
                                        $tds_percentage = $fe['percentage'];
                                    }
                                    if ($fe['id'] == 8) {
                                        $platform_fee_percentage = $fe['percentage'];
                                    }
                                    if ($fe['id'] == 9) {
                                        $commission_percentage = $fe['percentage'];
                                    }
                                }

                                $platform_fees = ceil($amount * $platform_fee_percentage / 100);
                                $commission_ref = ceil($platform_fees * $commission_percentage / 100);
                                $sp_ref = $amount - $platform_fees;
                                $tds_amount = ceil($sp_ref * $tds_percentage / 100);
                                $sp_amount = $sp_ref - $tds_amount;

                                //Get referral of user & sp
                                $ref1 = $common->get_details_dynamically('referral', 'user_id', $json->users_id);
                                $user_ref = $ref1[0]['referred_by'];

                                $ref2 = $common->get_details_dynamically('referral', 'user_id', $json->sp_id);
                                $sp_ref = $ref2[0]['referred_by'];

                                //Transaction table update
                                $arr2 = [
                                    
                                    [
                                        'name_id' => 3, //Invoice Amount remove from User Wallet
                                        'date' => date('Y-m-d'),
                                        'amount' => $inv_amount,
                                        'type_id' => 2, //Payments
                                        'users_id' => $json->users_id,
                                        'method_id' => 2, //Wallet Transfer
                                        'reference_id' => "W-" . rand(1, 999999),
                                        'booking_id' => $booking_id,
                                        'order_id' => $json->order_id,
                                        'payment_status' => 'TXN_SUCCESS',
                                        'created_dts' => $date,
                                        'txnId' => "",
                                        'bankTxnId' => "",
                                        'txnType' => "",
                                        'gatewayName' => "",
                                        'bankName' => "",
                                        'paymentMode' => "",
                                        'refundAmt' => ""
                                    ],
                                    [
                                        'name_id' => 10, //Add to wallet SP
                                        'date' => date('Y-m-d'),
                                        'amount' => $sp_amount,
                                        'type_id' => 2,
                                        'users_id' => $json->sp_id,
                                        'method_id' => 2,
                                        'reference_id' => "W-" . rand(1, 999999),
                                        'booking_id' => $booking_id,
                                        'order_id' => $json->order_id,
                                        'payment_status' => 'TXN_SUCCESS',
                                        'created_dts' => $date,
                                        'txnId' => "",
                                        'bankTxnId' => "",
                                        'txnType' => "",
                                        'gatewayName' => "",
                                        'bankName' => "",
                                        'paymentMode' => "",
                                        'refundAmt' => ""
                                    ],
                                    [
                                        'name_id' => 13, //Add to sp ref
                                        'date' => date('Y-m-d'),
                                        'amount' => $commission_ref,
                                        'type_id' => 1,
                                        'users_id' => ($user_ref == 'NoRef' ? 0 : $user_ref),
                                        'method_id' => 3, //Transfer Commission
                                        'reference_id' => "W-" . rand(1, 999999),
                                        'booking_id' => $booking_id,
                                        'order_id' => $json->order_id,
                                        'payment_status' => 'TXN_SUCCESS',
                                        'created_dts' => $date,
                                        'txnId' => "",
                                        'bankTxnId' => "",
                                        'txnType' => "",
                                        'gatewayName' => "",
                                        'bankName' => "",
                                        'paymentMode' => "",
                                        'refundAmt' => ""
                                    ],
                                    [
                                        'name_id' => 13, //Add to sp ref
                                        'date' => date('Y-m-d'),
                                        'amount' => $commission_ref,
                                        'type_id' => 1,
                                        'users_id' => ($sp_ref == 'NoRef' ? 0 : $sp_ref),
                                        'method_id' => 3, //Transfer Commission
                                        'reference_id' => "W-" . rand(1, 999999),
                                        'booking_id' => $booking_id,
                                        'order_id' => $json->order_id,
                                        'payment_status' => 'TXN_SUCCESS',
                                        'created_dts' => $date,
                                        'txnId' => "",
                                        'bankTxnId' => "",
                                        'txnType' => "",
                                        'gatewayName' => "",
                                        'bankName' => "",
                                        'paymentMode' => "",
                                        'refundAmt' => ""
                                    ]
                                ];

                                $tra = $common->batch_insert_records_dynamically('transaction', $arr2);

                                //Update Wallet Balances

                                $wal1 = $common->get_details_dynamically('wallet_balance', 'users_id', $json->users_id);

                                if ($wal1 != 'failure') {

                                    $dat1 = array(
                                        'amount' => $wal1[0]['amount'],
                                        'amount_blocked' => $wal1[0]['amount_blocked'] + $json->w_amount + $json->amount - $inv_amount
                                    );

                                    $common->update_records_dynamically('wallet_balance', $dat1, 'users_id', $json->users_id);
                                } else {
                                    return $this->respond([
                                        'status' => 404,
                                        'message' => 'Unable to fetch users wallet balance'
                                    ]);
                                }


                                $wal2 = $common->get_details_dynamically('wallet_balance', 'users_id', $json->sp_id);

                                if ($wal2 != 'failure') {
                                    $dat2 = array(
                                        'amount' => $wal2[0]['amount'],
                                        'amount_blocked' => $wal2[0]['amount_blocked'] + $sp_amount
                                    );

                                    $common->update_records_dynamically('wallet_balance', $dat2, 'users_id', $json->sp_id);
                                } else {
                                    return $this->respond([
                                        'status' => 404,
                                        'message' => 'Unable to fetch sp wallet balance'
                                    ]);
                                }


                                $wal3 = $common->get_details_dynamically('wallet_balance', 'users_id', $user_ref);

                                if ($wal3 != 'failure' &&  $user_ref != 0) {
                                    $dat3 = array(
                                        'amount' => $wal3[0]['amount'],
                                        'amount_blocked' => $wal3[0]['amount_blocked'] + $commission_ref
                                    );

                                    $common->update_records_dynamically('wallet_balance', $dat3, 'users_id', $user_ref);
                                } else {
                                    return $this->respond([
                                        'status' => 404,
                                        'message' => 'Unable to fetch user ref wallet balance'
                                    ]);
                                }

                                $wal4 = $common->get_details_dynamically('wallet_balance', 'users_id', $sp_ref);

                                if ($wal4 != 'failure' && $sp_ref != 0) {
                                    $dat4 = array(
                                        'amount' => $wal4[0]['amount'],
                                        'amount_blocked' => $wal4[0]['amount_blocked'] + $commission_ref
                                    );

                                    $common->update_records_dynamically('wallet_balance', $dat4, 'users_id', $sp_ref);
                                }

                                //Insert records into lien table

                                // $lien_s = date_create('now');
                                // date_add($lien_s, date_interval_create_from_date_string('24 Hours'));
                                // $lien_e = date_format($lien_s, "Y-m-d H:i:s");

                                // $lien_start = $lien_s->format('Y-m-d H:i:s');
                                // $lien_end = $lien_e;

                                $lien_start = $date;
                                $lien_e = strtotime($date) + (24 * 60 * 60);
                                $lien_end = date('Y-m-d H:i:s', $lien_e);

                                $lien_data = [
                                    [
                                        'lien_start' => $lien_start,
                                        'lien_end' => $lien_end,
                                        'amount' => $sp_amount,
                                        'user_id' => $json->sp_id,
                                        'booking_id' => $booking_id,
                                        'status' => 0
                                    ],
                                    [
                                        'lien_start' => $lien_start,
                                        'lien_end' => $lien_end,
                                        'amount' => $commission_ref,
                                        'user_id' => $user_ref,
                                        'booking_id' => $booking_id,
                                        'status' => 0
                                    ],
                                    [
                                        'lien_start' => $lien_start,
                                        'lien_end' => $lien_end,
                                        'amount' => $commission_ref,
                                        'user_id' => $sp_ref,
                                        'booking_id' => $booking_id,
                                        'status' => 0
                                    ]
                                ];

                                $common->batch_insert_records_dynamically('lien_table', $lien_data);

                                //update company account table

                                $data5 = [

                                    'platform_fees' => $platform_fees,
                                    'user_plan_subs' => 0,
                                    'sp_plan_subs' => 0,
                                    'cancellation_charges' => 0,
                                    'receipt_date' => date('Y-m-d'),
                                    'transaction_id' => $tra

                                ];

                                $common->insert_records_dynamically('company_account', $data5);


                                //update TDS table
                                $data6 = [

                                    'booking_id' => $booking_id,
                                    'tds_amount' => $tds_amount,
                                    'sp_id' => $json->sp_id,
                                    'collected_on' => $date

                                ];

                                $common->insert_records_dynamically('tds_table', $data6);


                                //Insert into alerts_regular_user

                                $sp_profile = $misc_model->user_info($json->sp_id);

                                $arr_alerts = array(
                                    'type_id' => 1,
                                    'description' => $sp_profile[0]['fname'] . " " . $sp_profile[0]['lname'] . "has succesfully Completed the Booking ID: " . $booking_id . " on " . $date,
                                    'user_id' => $json->users_id,
                                    'profile_pic_id' => $json->sp_id,
                                    'status' => 2,
                                    'created_on' => $date,
                                    'updated_on' => $date
                                );

                                $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                                //Insert into alerts_regular_sp
                                $arr_alerts1 = array(
                                    'type_id' => 1,
                                    'description' => "You have succesfully Completed the Booking ID: " . $booking_id . " on " . $date,
                                    'user_id' => $json->sp_id,
                                    'profile_pic_id' => $json->sp_id,
                                    'status' => 2,
                                    'created_on' => $date,
                                    'updated_on' => $date
                                );

                                $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);



                                return $this->respond([
                                    'status' => 200,
                                    'message' => 'Booking Successfully Completed',
                                ]);
                            } else {

                                return $this->respond([
                                    'status' => 404,
                                    'message' => 'Entry for failure status updated'
                                ]);
                            }


                    }
                        
                } else {

                    return $this->respond([
                        'status' => 403,
                        'message' => 'Authentication Failed'
                    ]);


                    //return $this->respond([
                    //		'status' => 200,
                    //	'message' => 'Entries done for failure transaction' 
                    // ]);	
                }
            }
        }
    }


    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

    function process_txn()
    {

        $json = $this->request->getJson();

        $paytm = new PaytmModel();
        $order_id = "BKN_" . $json->booking_id;
        $txn_token = $json->txn_token;

        // //Get Paytm TXNNo for the Booking
        // $result = $paytm->gettxn($order_id, $json->amount, $json->users_id);
        // $result = json_decode($result, true);

        // $txn_token = $result['body']['txnToken'];    

        $data = $paytm->processTransaction($order_id, $txn_token);
        $data = json_decode($data, true);

        return $this->respond([
            'message' => 'Success',
            'txnToken' => $txn_token,
            'process_txn' => $data
        ]);
    }




    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

    function verify_txn($order_id)
    {

        $common = new CommonModel();


        // $order_id = $this->request->getVar('order_id');

        $paytm = new PaytmModel();
        $result = $paytm->verify_txn($order_id);
        $result = json_decode($result, true);

        if ($result['body']['resultInfo']['resultStatus'] == 'TXN_FAILURE') {
            $array = [
                'payment_status' => $result['body']['resultInfo']['resultStatus'],
                'txnId' => $result['body']['txnId']
            ];
            $common->update_records_dynamically('transaction', $array, 'order_id', $order_id);
        } elseif ($result['body']['resultInfo']['resultStatus'] == 'TXN_SUCCESS') {
            $array = [
                'payment_status' => $result['body']['resultInfo']['resultStatus'],
                'txnId' => $result['body']['txnId'],
                "bankTxnId" =>  $result['body']['bankTxnId'],
                "txnType" => $result['body']['txnType'],
                "gatewayName" =>  $result['body']['gatewayName'],
                "bankName" => $result['body']['bankName'],
                "paymentMode" => $result['body']['paymentMode'],
                "refundAmt" => $result['body']['refundAmt']
            ];
            $common->update_records_dynamically('transaction', $array, 'order_id', $order_id);
        }

        return $this->respond([
            'status' => 200,
            'txnId' => $result['body']['txnId'],
            'order_id' => $result['body']['orderId'],
            'message' => $result['body']['resultInfo']['resultStatus']
        ]);
    }
}
