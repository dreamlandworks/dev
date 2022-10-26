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

            if (
                !property_exists($json,'scheduled_date') || !property_exists($json,'time_slot_from')  || !property_exists($json,'job_description')
                || !property_exists($json,'bids_period') || !property_exists($json,'bid_per') || !property_exists($json,'bid_range_id')
                || !property_exists($json,'address_id') || !property_exists($json,'city')
                || !property_exists($json,'state') || !property_exists($json,'country') || !property_exists($json,'postal_code')
                || !property_exists($json,'address') || !property_exists($json,'user_lat') || !property_exists($json,'user_long')
                || !property_exists($json,'title') || !property_exists($json,'lang_responses')
                || !property_exists($json,'bid_range_id') || !property_exists($json,'keywords_responses') || !property_exists($json,'created_on')
                || !property_exists($json,'attachments') || !property_exists($json,'estimate_time') || !property_exists($json,'estimate_type_id')
                || !property_exists($json,'users_id') || !property_exists($json,'key') 
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

                    $arr_time_slot_details = $common->get_details_dynamically('time_slot', 'from', $json->time_slot_from);
                    if ($arr_time_slot_details != 'failure') {
                        $time_slot_id = $arr_time_slot_details[0]['id'];
                    } else {
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
                        'status_id' => 26,
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                    );
                    $booking_id = $common->insert_records_dynamically('booking', $arr_job_post);

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
                            'status_id' => 26,
                            'bids_period' => $json->bids_period,
                            'title' => $json->title,
                            'bid_per' => $json->bid_per,
                            'bid_range_id' => $json->bid_range_id,
                        );

                        $post_job_id = $common->insert_records_dynamically('post_job', $arr_post_job);

                        if ($post_job_id > 0) {

                            //******************Languages

                            $common->delete_records_dynamically('post_req_lang', 'post_job_id', $post_job_id);

                            foreach ($json->lang_responses as $lang_key => $lang_data) {
                                $lang_id = $lang_data->lang_id;
                                if ($lang_id == 0) { //Insert into user_lang_list ::	language_id	users_id
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

                            foreach ($json->keywords_responses as $keywords_key => $keywords_data) {
                                $keyword_id = $keywords_data->keyword_id;
                                if ($keyword_id == 0) { //Insert into keywords :: keyword,subcategories_id

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

                        //Insert into alert_regular_user table
                        $arr_alerts = array(
                            'type_id' => 2,
                            'description' => "You have successfully posted a new job '" . $json->title . "' with " . $post_job_id . " on " . $json->created_on,
                            'user_id' => $json->users_id,
                            'profile_pic_id' => $json->users_id,
                            'status' => 2,
                            'created_on' => $json->created_on,
                            'updated_on' => $json->created_on
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts);

                        $arr_user_details = $common->get_details_dynamically('user_details', 'id', $json->users_id);
                        if ($arr_user_details != 'failure') {
                            $user_name = $arr_user_details[0]['fname'] . " " . $arr_user_details[0]['lname'];
                            $user_mobile = $arr_user_details[0]['mobile'];
                        }

                        //Send SMS
                        $sms_model = new SmsTemplateModel();

                        $data = [
                            "name" => "job_create",
                            "mobile" => $user_mobile,
                            "dat" => [
                                "var" => $user_name,
                                "var1" => $json->title,
                                "var2" => str_pad($post_job_id, 6, '0', STR_PAD_LEFT),
                            ]
                        ];

                        $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);

                        return $this->respond([
                            "post_job_id" => $post_job_id,
                            "post_job_ref_id" => str_pad($post_job_id, 6, "0", STR_PAD_LEFT),
                            "user_plan_id" => $user_plan_id,
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to create Job Post"
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

            if (
                !property_exists($json,'scheduled_date') || !property_exists($json,'time_slot_from')  || !property_exists($json,'job_description')
                || !property_exists($json,'bids_period') || !property_exists($json,'bid_per') || !property_exists($json,'bid_range_id')
                || !property_exists($json,'title') || !property_exists($json,'lang_responses')
                || !property_exists($json,'bid_range_id') || !property_exists($json,'keywords_responses') || !property_exists($json,'created_on')
                || !property_exists($json,'attachments') || !property_exists($json,'estimate_time') || !property_exists($json,'estimate_type_id')
                || !property_exists($json,'users_id') || !property_exists($json,'key')
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
                        'status_id' => 26,
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
                            'status_id' => 26,
                            'bids_period' => $json->bids_period,
                            'title' => $json->title,
                            'bid_per' => $json->bid_per,
                            'bid_range_id' => $json->bid_range_id,
                        );

                        $post_job_id = $common->insert_records_dynamically('post_job', $arr_post_job);

                        if ($post_job_id > 0) {

                            //******************Languages
                            $common->delete_records_dynamically('post_req_lang', 'post_job_id', $post_job_id);

                            foreach ($json->lang_responses as $lang_key => $lang_data) {
                                $lang_id = $lang_data->lang_id;
                                if ($lang_id == 0) { //Insert into user_lang_list ::	language_id	users_id
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

                            foreach ($json->keywords_responses as $keywords_key => $keywords_data) {
                                $keyword_id = $keywords_data->keyword_id;
                                if ($keyword_id == 0) { //Insert into keywords :: keyword,subcategories_id

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
                        if (count($attachments) > 0) {
                            foreach ($attachments as $attach_key => $arr_file) {
                               
                            //    print_r($file[$attach_key]);
                            //    exit;

                               $pos = strpos($arr_file->file, 'firebasestorage');
                
                                if ($pos !== false) { //URL
                                    $url = $arr_file->file;
                
                                    list($path, $token) = explode('?', $url);
                
                                    $type = pathinfo($path, PATHINFO_EXTENSION);
                                    $data = file_get_contents($url);
                                    $base64_file = base64_encode($data);
                
                                    $data = $base64_file;
                                    
                                } else {
                                    $type = $arr_file->type;
                                   
                                }

                                    // $image = generateDynamicImage("images/attachments", $file[$attach_key], $type[$attach_key]);
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
                                        'file_location' => 'images/attachments',
                                        'created_on' => $json->created_on,
                                        'created_by' => $json->users_id,
                                        'status_id' => 44
                                    );
                                    $common->insert_records_dynamically('attachments', $arr_attach);
                                
                            }
                        }

                        //Insert into alert_regular_user table
                        $arr_alerts = array(
                            'type_id' => 2,
                            'description' => "You have successfully posted a new job '" . $json->title . "' with " . $post_job_id . " on " . $json->created_on,
                            'user_id' => $json->users_id,
                            'profile_pic_id' => $json->users_id,
                            'status' => 2,
                            'created_on' => $json->created_on,
                            'updated_on' => $json->created_on
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts);

                        return $this->respond([
                            "post_job_id" => $post_job_id,
                            "post_job_ref_id" => str_pad($post_job_id, 6, "0", STR_PAD_LEFT),
                            "user_plan_id" => $user_plan_id,
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to create Job Post"
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

            if (
                !property_exists($json,'scheduled_date') || !property_exists($json,'time_slot_from')
                || !property_exists($json,'bids_period') || !property_exists($json,'bid_per') || !property_exists($json,'bid_range_id')
                || !property_exists($json,'addresses') || !property_exists($json,'title') || !property_exists($json,'lang_responses')
                || !property_exists($json,'bid_range_id') || !property_exists($json,'keywords_responses') || !property_exists($json,'created_on')
                || !property_exists($json,'attachments') || !property_exists($json,'estimate_time') || !property_exists($json,'estimate_type_id')
                || !property_exists($json,'users_id') || !property_exists($json,'key')
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
                        'status_id' => 26,
                        'estimate_time' => $json->estimate_time,
                        'estimate_type_id' => $json->estimate_type_id,
                    );
                    $booking_id = $common->insert_records_dynamically('booking', $arr_job_post);

                    if ($booking_id > 0) {
                        $addresses = $json->addresses;

                        if (count($addresses) > 0) {
                            foreach ($addresses as $address_key => $arr_address) {
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
                            'status_id' => 26,
                            'bids_period' => $json->bids_period,
                            'title' => $json->title,
                            'bid_per' => $json->bid_per,
                            'bid_range_id' => $json->bid_range_id,
                        );

                        $post_job_id = $common->insert_records_dynamically('post_job', $arr_post_job);

                        if ($post_job_id > 0) {

                            //******************Languages

                            $common->delete_records_dynamically('post_req_lang', 'post_job_id', $post_job_id);

                            foreach ($json->lang_responses as $lang_key => $lang_data) {
                                $lang_id = $lang_data->lang_id;
                                if ($lang_id == 0) { //Insert into user_lang_list ::	language_id	users_id
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

                            foreach ($json->keywords_responses as $keywords_key => $keywords_data) {
                                $keyword_id = $keywords_data->keyword_id;
                                if ($keyword_id == 0) { //Insert into keywords :: keyword,subcategories_id

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
                        //Create and save atatchments
                        if (count($attachments) > 0) {
                            foreach ($attachments as $attach_key => $arr_file) {
                               
                            //    print_r($file[$attach_key]);
                            //    exit;

                               $pos = strpos($arr_file->file, 'firebasestorage');
                
                                if ($pos !== false) { //URL
                                    $url = $arr_file->file;
                
                                    list($path, $token) = explode('?', $url);
                
                                    $type = pathinfo($path, PATHINFO_EXTENSION);
                                    $data = file_get_contents($url);
                                    $base64_file = base64_encode($data);
                
                                    $data = $base64_file;
                                    
                                } else {
                                    $type = $arr_file->type;
                                   
                                }

                                    // $image = generateDynamicImage("images/attachments", $file[$attach_key], $type[$attach_key]);
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
                                        'file_location' => 'images/attachments',
                                        'created_on' => $json->created_on,
                                        'created_by' => $json->users_id,
                                        'status_id' => 44
                                    );
                                    $common->insert_records_dynamically('attachments', $arr_attach);
                                
                            }
                        }

                        //Insert into alerts_regular_user table
                        $arr_alerts = array(
                            'type_id' => 2,
                            'description' => "You have successfully posted a new job '" . $json->title . "' with " . $post_job_id . " on " . $json->created_on,
                            'user_id' => $json->users_id,
                            'profile_pic_id' => $json->users_id,
                            'status' => 2,
                            'created_on' => $json->created_on,
                            'updated_on' => $json->created_on
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts);

                        return $this->respond([
                            "post_job_id" => $post_job_id,
                            "post_job_ref_id" => str_pad($post_job_id, 6, "0", STR_PAD_LEFT),
                            "user_plan_id" => $user_plan_id,
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to create Job Post"
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
            
            // echo "<pre>";
            // print_r($json);
            // echo "</pre>";
            // exit;

            if (!property_exists($json,'users_id') || !property_exists($json,'key')) {
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
                    $job_post_model = new JobPostModel();
                    $common = new CommonModel();

                    $users_id = $json->users_id;

                    $arr_job_post_bids = array();

                    //Get Bids
                    $arr_bid_details = $job_post_model->get_job_post_bid_details($users_id);

                    if ($arr_bid_details != 'failure') {
                        foreach ($arr_bid_details as $bid_data) {
                            if (!isset($arr_job_post_bids[$bid_data['post_job_id']])) {
                                $arr_job_post_bids[$bid_data['post_job_id']]['bids'] = 1;
                                $arr_job_post_bids[$bid_data['post_job_id']]['bid_amount'] = $bid_data['amount'];
                            } else {
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
                    

                    if ($arr_single_move_booking_details != 'failure') {
                        foreach ($arr_single_move_booking_details as $key => $book_data) {
                            $status = ($book_data['status'] == 'Open' ? "Pending" : $book_data['status']);
                            $total_bids = (isset($arr_job_post_bids[$book_data['post_job_id']])) ? $arr_job_post_bids[$book_data['post_job_id']]['bids'] : 0;
                            $total_bids_amount = (isset($arr_job_post_bids[$book_data['post_job_id']])) ? $arr_job_post_bids[$book_data['post_job_id']]['bid_amount'] : 0;
                            $average_bids_amount = ($total_bids > 0) ? (string)round(($total_bids_amount / $total_bids), 2) : 0;

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
                            $arr_job_post[$key]['bids_period'] = $book_data['bids_period']; //in days, 1,3,7
                            $arr_job_post[$key]['post_created_on'] = $book_data['created_dts'];
                            //Calculate bid end date
                            $arr_job_post[$key]['bid_end_date'] = date('Y-m-d H:i:s', strtotime('+' . $arr_job_post[$key]['bids_period'] . ' day', strtotime($arr_job_post[$key]['post_created_on'])));

                            $expires_in = ($current_date < $arr_job_post[$key]['bid_end_date']) ? $this->calc_days_hrs_mins($arr_job_post[$key]['bid_end_date'], $current_date) : "Expired";

                            $arr_job_post[$key]['booking_status'] = ($expires_in == "Expired" && $status == 'Open') ? $expires_in : $status;
                            $arr_job_post[$key]['current_date'] = $current_date;
                            $arr_job_post[$key]['expires_in'] = ($current_date < $arr_job_post[$key]['bid_end_date']) ? $this->calc_days_hrs_mins($arr_job_post[$key]['bid_end_date'], $current_date) : 0;
                            $arr_job_post[$key]['expired_on'] = ($expires_in == "Expired" ? $arr_job_post[$key]['bid_end_date'] : "");

                            //Get Name of Awarded Bidder
                            if ($status == "Awarded") {
                                $details = $job_post_model->get_sp_details_bid_awarded($book_data['post_job_id']);

                                if($details !='failure'){
                                    $arr_job_post[$key]['awarded_to'] = $details['fname'] . " " . $details['lname'];
                                    $arr_job_post[$key]['awarded_to_sp_profile_pic'] = $details['profile_pic'];
                                }else{
                                    $arr_job_post[$key]['awarded_to'] = "";
                                    $arr_job_post[$key]['awarded_to_sp_profile_pic'] = "";
                                }
                                
                            } else {
                                $arr_job_post[$key]['awarded_to'] = "";
                                $arr_job_post[$key]['awarded_to_sp_profile_pic'] = "";
                            }


                            $arr_job_post[$key]['total_bids'] = $total_bids;
                            $arr_job_post[$key]['average_bids_amount'] = $average_bids_amount;

                            $arr_job_post[$key]['details'][] = array(
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
                        //print_r($arr_job_post_details);
                        //print_r($arr_job_post);
                        //echo "</pre>";
                        //exit;
                    }

                    $booking_count = (count($arr_job_post) > 0) ?  count($arr_job_post) : 0; //Increment the key

                    
                    //Get Blue Collar Booking Details
                    $arr_blue_collar_booking_details = $job_post_model->get_user_blue_collar_job_post_details($users_id);

                    
                    if ($arr_blue_collar_booking_details != 'failure') {
                        foreach ($arr_blue_collar_booking_details as $bc_book_data) {
                            $status = ($bc_book_data['status'] == "Open" ? "Pending" : $bc_book_data['status']);
                            $total_bids = (isset($arr_job_post_bids[$bc_book_data['post_job_id']])) ? $arr_job_post_bids[$bc_book_data['post_job_id']]['bids'] : 0;
                            $total_bids_amount = (isset($arr_job_post_bids[$bc_book_data['post_job_id']])) ? $arr_job_post_bids[$bc_book_data['post_job_id']]['bid_amount'] : 0;
                            $average_bids_amount = ($total_bids > 0) ? (string)round(($total_bids_amount / $total_bids), 2) : 0;

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
                            $arr_job_post[$booking_count]['bids_period'] = $bc_book_data['bids_period']; //in days, 1,3,7
                            $arr_job_post[$booking_count]['post_created_on'] = $bc_book_data['created_dts'];
                            //Calculate bid end date
                            $arr_job_post[$booking_count]['bid_end_date'] = date('Y-m-d H:i:s', strtotime('+' . $arr_job_post[$booking_count]['bids_period'] . ' day', strtotime($arr_job_post[$booking_count]['post_created_on'])));

                            $expires_in = ($current_date < $arr_job_post[$booking_count]['bid_end_date']) ? $this->calc_days_hrs_mins($arr_job_post[$booking_count]['bid_end_date'], $current_date) : "Expired";
                            $arr_job_post[$booking_count]['booking_status'] = ($expires_in == "Expired" && $status == 'Open') ? $expires_in : $status;

                            $arr_job_post[$booking_count]['current_date'] = $current_date;
                            $arr_job_post[$booking_count]['expires_in'] = ($current_date < $arr_job_post[$booking_count]['bid_end_date']) ? $this->calc_days_hrs_mins($arr_job_post[$booking_count]['bid_end_date'], $current_date) : 0;
                            $arr_job_post[$booking_count]['expired_on'] = ($expires_in == "Expired" ? $arr_job_post[$booking_count]['bid_end_date'] : "");

                            // print_r($status);
                            // exit;

                            //Get Name of Awarded Bidder
                            if ($status == "Awarded") {

                                $details = $job_post_model->get_sp_details_bid_awarded($bc_book_data['post_job_id']);

                                if($details != 'failure'){
                                   $arr_job_post[$booking_count]['awarded_to'] = $details[0]['fname'] . " " . $details[0]['lname'];
                                   $arr_job_post[$booking_count]['awarded_to_sp_profile_pic'] = $details[0]['profile_pic'];
                                    } else {
                                        $arr_job_post[$booking_count]['awarded_to'] = "";
                                        $arr_job_post[$booking_count]['awarded_to_sp_profile_pic'] = "";
                                    }
                                }                        
                             else {
                                $arr_job_post[$booking_count]['awarded_to'] = "";
                                $arr_job_post[$booking_count]['awarded_to_sp_profile_pic'] = "";
                            }

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
                            if (!property_exists($mm_book_data['id'], $arr_exists)) {
                                $status = ($mm_book_data['status'] == "Open" ? "Pending" : $mm_book_data['status']);
                                $total_bids = (property_exists($mm_book_data['post_job_id'], $arr_job_post_bids)) ? $arr_job_post_bids[$mm_book_data['post_job_id']]['bids'] : 0;
                                $total_bids_amount = (property_exists($mm_book_data['post_job_id'], $arr_job_post_bids)) ? $arr_job_post_bids[$mm_book_data['post_job_id']]['bid_amount'] : 0;
                                $average_bids_amount = ($total_bids > 0) ? (string)round(($total_bids_amount / $total_bids), 2) : 0;

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
                                $arr_job_post[$booking_count]['bids_period'] = $mm_book_data['bids_period']; //in days, 1,3,7
                                $arr_job_post[$booking_count]['post_created_on'] = $mm_book_data['created_dts'];
                                //Calculate bid end date
                                $arr_job_post[$booking_count]['bid_end_date'] = date('Y-m-d H:i:s', strtotime('+' . $arr_job_post[$booking_count]['bids_period'] . ' day', strtotime($arr_job_post[$booking_count]['post_created_on'])));

                                $expires_in = ($current_date < $arr_job_post[$booking_count]['bid_end_date']) ? $this->calc_days_hrs_mins($arr_job_post[$booking_count]['bid_end_date'], $current_date) : "Expired";
                                $arr_job_post[$booking_count]['booking_status'] = ($expires_in == "Expired" && $status == 'Open') ? $expires_in : $status;

                                $arr_job_post[$booking_count]['current_date'] = $current_date;
                                $arr_job_post[$booking_count]['expires_in'] = ($current_date < $arr_job_post[$booking_count]['bid_end_date']) ? $this->calc_days_hrs_mins($arr_job_post[$booking_count]['bid_end_date'], $current_date) : 0;
                                $arr_job_post[$booking_count]['expired_on'] = ($expires_in == "Expired" ? $arr_job_post[$booking_count]['bid_end_date'] : "");

                                //Get Name of Awarded Bidder
                                if ($status == "Awarded") {
                                    $details = $job_post_model->get_sp_details_bid_awarded($mm_book_data['post_job_id']);

                                    $arr_job_post[$booking_count]['awarded_to'] = $details[0]['fname'] . " " . $details[0]['lname'];
                                    $arr_job_post[$booking_count]['awarded_to_sp_profile_pic'] = $details[0]['profile_pic'];
                                } else {
                                    $arr_job_post[$booking_count]['awarded_to'] = "";
                                    $arr_job_post[$booking_count]['awarded_to_sp_profile_pic'] = "";
                                }

                                $arr_job_post[$booking_count]['total_bids'] = $total_bids;
                                $arr_job_post[$booking_count]['average_bids_amount'] = $average_bids_amount;

                                foreach ($arr_details[$mm_book_data['id']] as $key => $val) {
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
                    if (count($arr_job_post) > 0) {
                        return $this->respond([
                            "job_post_details" => $arr_job_post,
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

            if (
                !property_exists($json, 'booking_id') || !property_exists($json, 'category_id') || !property_exists($json, 'post_job_id')
                || !property_exists($json, 'users_id') || !property_exists($json, 'key')
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
                    if ($arr_post_keyword_details != 'failure') {
                        foreach ($arr_post_keyword_details as $keywords) {
                            $arr_keywords[] = $keywords['keyword'];
                        }
                    }

                    
                    //Get Language
                    $arr_post_lang_details = $job_post_model->get_job_post_language($post_job_id);
                    if ($arr_post_lang_details != 'failure') {
                        foreach ($arr_post_lang_details as $language) {
                            $arr_language[] = $language['name'];
                        }
                    }

                    $arr_job_post_bids = array();

                    //Get Bids
                    $arr_bid_details = $job_post_model->get_job_post_bid_details($users_id, $post_job_id);

                    // print_r($arr_bid_details[0]);
                    // exit;

                    if ($arr_bid_details != 'failure' && count($arr_bid_details) > 1) {
                        foreach ($arr_bid_details as $bid_data) {
                    
                            if (!isset($arr_job_post_bids[$bid_data['post_job_id']])) {
                                $arr_job_post_bids[$bid_data['post_job_id']]['bids'] = 1;
                                $arr_job_post_bids[$bid_data['post_job_id']]['bid_amount'] = $bid_data['amount'];
                            } else {
                                $arr_job_post_bids[$bid_data['post_job_id']]['bids']++;
                                $arr_job_post_bids[$bid_data['post_job_id']]['bid_amount'] += $bid_data['amount'];
                            }
                        }
                    }elseif($arr_bid_details != 'failure' && count($arr_bid_details) == 1){
                    
                        $bid_data = $arr_bid_details;
                        
                        if (!isset($bid_data['post_job_id'], $arr_job_post_bids)) {
                    
                            $arr_job_post_bids[$bid_data[0]['post_job_id']]['bids'] = 1;
                            $arr_job_post_bids[$bid_data[0]['post_job_id']]['bid_amount'] = $bid_data[0]['amount'];
                        } else {
                            $arr_job_post_bids[$bid_data[0]['post_job_id']]['bids']++;
                            $arr_job_post_bids[$bid_data[0]['post_job_id']]['bid_amount'] += $bid_data[0]['amount'];
                        }
                    
                    }

                    
                    //Get Booking Details
                    $arr_booking_details = $job_post_model->get_job_post_details($booking_id, $post_job_id, $users_id);

                    // print_r($arr_booking_details); 
                    // exit;

                    $arr_response = array();
                    $arr_booking = array();
                    $current_date = date('Y-m-d H:i:s');

                    if ($arr_booking_details != 'failure') {
                        $status = $arr_booking_details['status'];
                        $total_bids = (isset($arr_job_post_bids[$arr_booking_details['post_job_id']])) ? $arr_job_post_bids[$arr_booking_details['post_job_id']]['bids'] : 0;
                        $total_bids_amount = (isset($arr_job_post_bids[$arr_booking_details['post_job_id']])) ? $arr_job_post_bids[$arr_booking_details['post_job_id']]['bid_amount'] : 0;
                        $average_bids_amount = ($total_bids > 0) ? (string)round(($total_bids_amount / $total_bids), 2) : 0;

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
                        $arr_booking['bid_end_date'] = date('Y-m-d H:i:s', strtotime('+' . $arr_booking['bids_period'] . ' day', strtotime($arr_booking['post_created_on'])));
                        $arr_booking['current_date'] = $current_date;
                        $expires_in = ($current_date < $arr_booking['bid_end_date']) ? $this->calc_days_hrs_mins($arr_booking['bid_end_date'], $current_date) : "Expired";
                        // $arr_booking['expires_in'] = ($current_date < $arr_booking['bid_end_date']) ? $this->calc_days_hrs_mins($arr_booking['bid_end_date'], $current_date) : 0;;
                        $arr_booking['expires_in'] = ($current_date < $arr_booking['bid_end_date']) ? $this->calc_days_hrs_mins($arr_booking['bid_end_date'], $current_date) : 0;
                        $arr_booking['expired_on'] = ($expires_in == "Expired" ? $arr_booking['bid_end_date'] : "");

                        //Get Name of Awarded Bidder
                        if ($status == "Awarded") {
                            $details = $job_post_model->get_sp_details_bid_awarded($arr_booking['post_job_id']);
                            
                            $arr_booking['awarded_to'] = $details['fname'] . " " . $details['lname'];
                            $arr_booking['awarded_to_sp_profile_pic'] = $details['profile_pic'];
                        } else {
                            $arr_booking['awarded_to'] = "";
                            $arr_booking['awarded_to_sp_profile_pic'] = "";
                        }

                        $arr_booking['total_bids'] = $total_bids;
                        $arr_booking['average_bids_amount'] = $average_bids_amount;

                        $attachment_count = $arr_booking_details['attachment_count'];

                        $arr_attachments = array();
                        $arr_job_details = array();

                        if ($attachment_count > 0) {
                            $arr_attachment_details = $misc_model->get_attachment_details($booking_id);
                            if ($arr_attachment_details != 'failure') {
                                foreach ($arr_attachment_details as $attach_data) {

                                    $file_name_array = explode(".", $attach_data['file_name']);
                                    $type = end($file_name_array);

                                    $arr_attachments[] = array(
                                        'id' => $attach_data['id'], 
                                        'file_name' => $attach_data['file_name'], 
                                        'file_location' => $attach_data['file_location'],
                                        'file_type' => $type
                                        );
                                }
                            }
                        }

                        if ($category_id == 1) { // Single Move 
                            $arr_single_move_details = $misc_model->get_single_move_details($booking_id);
                            if ($arr_single_move_details != 'failure') {
                                foreach ($arr_single_move_details as $single_move_data) {
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
                                        'id' => $multi_move_data['id'],
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
                    } else {
                        return $this->respond([
                            "booking_id" => $booking_id,
                            "status" => 404,
                            "message" => "Invalid Job Post"
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

            if (!property_exists($json, 'post_job_id') || !property_exists($json, 'key')) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
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
                    if ($arr_jobs_completed != 'failure') {
                        foreach ($arr_jobs_completed as $jobs_data) {
                            $arr_sp_jobs_completed[$jobs_data['users_id']] = $jobs_data['jobs_completed'];
                            $job_title = $jobs_data['title'];
                        }
                    }

                    //Get Bids
                    $arr_bid_details = $job_post_model->get_job_post_bid_details_by_jobpost_id($post_job_id);
                    // print_r($arr_bid_details);
                    // exit;


                    if ($arr_bid_details != 'failure') {
                        foreach ($arr_bid_details as $bid_data) {
                            $arr_bid_list[] = array(
                                'bid_id' => $bid_data['id'],
                                'bid_type' => $bid_data['bid_type'],
                                'sp_id' => $bid_data['users_id'],
                                'users_id' => $bid_data['posted_by_id'],
                                'sp_fname' => $bid_data['fname'],
                                'sp_lname' => $bid_data['lname'],
                                'sp_mobile' => $bid_data['mobile'],
                                'sp_profile' => $bid_data['profile_pic'],
                                'sp_fcm_token' => $bid_data['fcm_token'],
                                'amount' => intval($bid_data['amount']) . "",
                                'esimate_time' => $bid_data['esimate_time'],
                                'estimate_type' => $bid_data['name'],
                                'proposal'  => $bid_data['proposal'],
                                'about_me'  => $bid_data['about_me'],
                                'job_title'  => $job_title,
                                'jobs_completed' => (isset($arr_sp_jobs_completed[$bid_data['users_id']])) ? $arr_sp_jobs_completed[$bid_data['users_id']] : 0,
                                'bid_status' => $bid_data['status']
                            );
                        }
                        return $this->respond([
                            "bid_details" => $arr_bid_list,
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "booking_id" => $booking_id,
                            "status" => 404,
                            "message" => "No Bids found"
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

            if (!property_exists($json, 'bid_id') || !property_exists($json, 'sp_id') || !property_exists($json, 'key')) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $job_post_model = new JobPostModel();
                    $misc_model = new MiscModel();

                    $bid_id = $json->bid_id;
                    $sp_id = $json->sp_id;

                    $arr_bid_details = array();
                    $arr_attachments = array();

                    //Get Jobs completed count
                    $arr_jobs_completed = $job_post_model->get_sp_jobs_completed_count($sp_id);

                    //Get Bid details
                    $arr_bid_list = $job_post_model->get_bid_details($bid_id, $sp_id);

                    if ($arr_bid_list != 'failure') {
                        foreach ($arr_bid_list as $bid_data) {
                            $arr_bid_details = array(
                                'bid_id' => $bid_data['id'],
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
                                'amount' => intval($bid_data['amount']) . "",
                                'esimate_time' => $bid_data['esimate_time'],
                                'estimate_type' => $bid_data['estimate_type'],
                                'proposal'  => $bid_data['proposal'],
                                'attachment_count' => $bid_data['attachment_count'],
                                'jobs_completed' => ($arr_jobs_completed != 'failure') ? $arr_jobs_completed : 0,
                                'job_title'  => $bid_data['title'],
                                'languages' => $bid_data['name'],
                                'place' => $bid_data['sp_address']
                            );

                            if ($bid_data['attachment_count'] > 0) {
                                $arr_attachment_details = $job_post_model->get_bid_attachment_details($bid_id);
                                if ($arr_attachment_details != 'failure') {
                                    foreach ($arr_attachment_details as $attach_data) {
                                        
                                        $f = explode('.',$attach_data['file_name']);
                                                                                
                                        $arr_attachments[] = array(
                                            'id' => $attach_data['id'],
                                            'bid_attach_id' => $attach_data['id'], 
                                            'file_name' => $attach_data['file_name'], 
                                            'file_location' => $attach_data['file_location'],
                                            'file_type' => end($f)
                                        );
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
                    } else {
                        return $this->respond([
                            "booking_id" => $booking_id,
                            "status" => 404,
                            "message" => "No Bids found"
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

    public function calc_days_hrs_mins($start_date, $end_date)
    {
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

            if (
                !property_exists($json, 'post_job_id') || !property_exists($json,'booking_id')  || !property_exists($json,'data') || !property_exists($json,'key'   )
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
                    $job_post_model = new JobPostModel();
                    //Delete Previous Records erroneously entered
                    $common->delete_records_dynamically('installment_det', 'post_job_id', $json->post_job_id);

                    //Create New Records
                    $arr_data = $json->data;
                    /*echo "<pre>";
    		        print_r($arr_data);
    		        echo "</pre>";
    		        exit;*/
                    $total_rows = 0;

                    if (count($arr_data) > 0) {
                        foreach ($arr_data as $data_val) {
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

                    
                    $bal = $job_post_model->get_user_wallet_balance_by_post_id($json->post_job_id);
                    
                    if($bal != 'failure'){
                        $wal_bal = $bal['amount'];
                        $wal_bal_blocked = $bal['amount_blocked'];
                    }else{
                        $wal_bal = 0;
                        $wal_bal_blocked = 0;
                    }

                    if (count($arr_data) == $total_rows) {
                        return $this->respond([
                            "status" => 200,
                            "message" => "Success",
                            "wallet_balance" => $wal_bal,
                            "wallet_balance_blocked" => $wal_bal_blocked
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to create Job Post Installment"
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

            if (
                !property_exists($json,'booking_id') || !property_exists($json,'bid_id') || !property_exists($json,'sp_id')
                || !property_exists($json,'date') || !property_exists($json,'amount')
                || !property_exists($json,'reference_id') || !property_exists($json,'payment_status')
                || !property_exists($json,'users_id') || !property_exists($json,'key')
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
                    $misc_model = new MiscModel();
                    $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);
                    $sp_name = "";
                    $sp_id = 0;
                    $sp_mobile = "";
                    $user_id = 0;
                    $job_title = "";

                    $arr_sp_details = $misc_model->get_sp_name_by_booking($json->booking_id);
                    if ($arr_sp_details != "failure") {
                        $sp_name = $arr_sp_details['fname'] . " " . $arr_sp_details['lname'];
                        $sp_id = $arr_sp_details['sp_id'];
                        $sp_mobile = $arr_sp_details['mobile'];
                        $user_id = $arr_sp_details['users_id'];
                        $job_title = $arr_sp_details['title'];
                    }

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

                    if ($transaction_id > 0) {
                        if ($json->payment_status == 'Success') {

                            //Awarded => making booking status as Pending
                            $upd_booking_status = [
                                "sp_id" =>  $json->sp_id,
                                "status_id" =>  9,
                            ];
                            $common->update_records_dynamically('booking', $upd_booking_status, 'id', $json->booking_id);

                            //Insert into booking status
                            $arr_booking_status = [
                                [
                                    'booking_id' => $json->booking_id,
                                    'status_id' => 32, //Installment Added
                                    'created_on' => date('Y-m-d H:i:s')
                                ], 
                                [
                                    'booking_id' => $json->booking_id,
                                    'status_id' => 9, //Booking In Pending
                                    'created_on' => date('Y-m-d H:i:s')
                                ]
                            ];
                            
                            $common->batch_insert_records_dynamically('booking_status', $arr_booking_status);

                            //update status as awarded in  post_job table
                            $upd_post_job_status = [
                                "status_id" =>  27, //Awarded
                            ];
                            $common->update_records_dynamically('post_job', $upd_post_job_status, 'booking_id', $json->booking_id);

                            //Mark Bid Awarded
                            $common->update_records_dynamically('bid_det',['status_id' => 27],'id',$json->bid_id);

                            //Mark the other bids as Rejected
                            $misc_model->mark_other_bids_expired($json->booking_id, $json->bid_id);

                            //Make entry in to wallet
                            //Check if the wallet is created
                            $arr_wallet_details = $common->get_details_dynamically('wallet_balance', 'users_id', $json->users_id);
                            if ($arr_wallet_details != 'failure') {
                                //Get total amount and blocked amount
                                $wallet_amount = $arr_wallet_details[0]['amount'];
                                $wallet_amount_blocked = $arr_wallet_details[0]['amount_blocked'] + $json->amount;

                                $arr_update_wallet_data = array(
                                    'amount' => $wallet_amount,
                                    'amount_blocked' => $wallet_amount_blocked
                                );
                                $common->update_records_dynamically('wallet_balance', $arr_update_wallet_data, 'users_id', $json->users_id);
                            } else {
                                $arr_wallet_data = array(
                                    'users_id' => $json->users_id,
                                    'amount' => 0,
                                    'amount_blocked' => $json->amount
                                );
                                $common->insert_records_dynamically('wallet_balance', $arr_wallet_data);
                            }


                            $user_profile = $misc_model->user_info($json->users_id);
                            $sp_profile = $misc_model->user_info($json->sp_id);
                            $date = date('Y-m-d H:i:s');

                            //Insert into alert_regular_user table Users
                            $arr_alerts = array(
                                'type_id' => 2,
                                'description' => "You have successfully awarded post '" . $job_title . "' to " . $sp_name . " under Booking ID " . $json->booking_id . " on " . $date,
                                'user_id' => $json->users_id,
                                'profile_pic_id' => $json->sp_id,
                                'status' => 2,
                                'created_on' => $date,
                                'updated_on' => $date
                            );

                            $common->insert_records_dynamically('alert_regular_user', $arr_alerts);

                            //Insert into alert_regular_sp table SP

                            $arr_alerts = array(
                                'type_id' => 2,
                                'description' => "Your bid has been successfully awarded for post '" . $job_title . "' by " . $user_profile[0]['fname'] . " " . $user_profile[0]['lname'] . "with Booking ID " . $json->booking_id . " on " . $date,
                                'user_id' => $json->sp_id,
                                'profile_pic_id' => $json->users_id,
                                'status' => 2,
                                'created_on' => $date,
                                'updated_on' => $date
                            );
                            $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);

                            //Send SMS
                            $sms_model = new SmsTemplateModel();

                            $data = [
                                "name" => "bid_chose",
                                "mobile" => $sp_mobile,
                                "dat" => [
                                    "var" => $sp_name,
                                    "var1" => $job_title,
                                    "var2" => "",
                                ]
                            ];

                            $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);
                        }

                        return $this->respond([
                            "transaction_id" => $transaction_id,
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to create Payment"
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
    //--------------------------------------------------Job Post Reject Status STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------
    public function update_post_job_status()
    {

        $json = $this->request->getJSON();
        if (
            !property_exists($json,'booking_id') || !property_exists($json,'post_job_id') || !property_exists($json,'bid_id')
            || !property_exists($json,'status_id') || !property_exists($json,'key')
        ) {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $common = new CommonModel();
            $misc_model = new MiscModel();
            $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);
            $sp_name = "";
            $sp_id = 0;
            $users_id = 0;
            $job_title = "";

            $arr_sp_details = $misc_model->get_sp_name_by_booking($json->booking_id);
            if ($arr_sp_details != "failure") {
                $sp_name = $arr_sp_details['fname'] . " " . $arr_sp_details['lname'];
                $sp_id = $arr_sp_details['sp_id'];
                $users_id = $arr_sp_details['users_id'];
                $job_title = $arr_sp_details['title'];
            }

            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                $post_job_id = $json->post_job_id;
                $status_id = $json->status_id;
                $booking_id = $json->booking_id;
                //$sp_name = $json->sp_name;
                //$job_title = $json->job_title;

                $date = date('Y-m-s H:i:s');
                $user_profile = $misc_model->user_info($users_id);
                $sp_profile = $misc_model->user_info($sp_id);

                if ($status_id == 29) {
                    //Insert into alert_regular_user table

                    $arr_alerts = array(
                        'type_id' => 2,
                        'description' => "You have rejected bid of " . $sp_name . " for post " . $job_title . " on " . $date,
                        'user_id' => $users_id,
                        'profile_pic_id' => $sp_id,
                        'status' => 2,
                        'created_on' => $date,
                        'updated_on' => $date
                    );

                    $common->insert_records_dynamically('alert_regular_user', $arr_alerts);

                    //Insert into alert_regular_sp table

                    $arr_alerts1 = array(
                        'type_id' => 2,
                        'description' => "Your bid has been rejected by " . $user_profile[0]['fname'] . " " . $user_profile[0]['lname'] . " for post " . $job_title . " on " . $date,
                        'user_id' => $json->sp_id,
                        'profile_pic_id' => $users_id,
                        'status' => 2,
                        'created_on' => $date,
                        'updated_on' => $date
                    );

                    $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);


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
            } else {
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

            if (
                !property_exists($json, 'booking_id') || !property_exists($json, 'post_job_id') || !property_exists($json, 'scheduled_date')
                || !property_exists($json, 'time_slot_from')  || !property_exists($json, 'job_description')
                || !property_exists($json, 'bids_period') || !property_exists($json, 'bid_per') || !property_exists($json, 'bid_range_id')
                || !property_exists($json, 'address_id') || !property_exists($json, 'title') || !property_exists($json, 'lang_responses')
                || !property_exists($json, 'bid_range_id') || !property_exists($json, 'keywords_responses') || !property_exists($json, 'created_on')
                || !property_exists($json, 'attachments') || !property_exists($json, 'estimate_time') || !property_exists($json, 'estimate_type_id')
                || !property_exists($json, 'users_id') || !property_exists($json, 'key') || !property_exists($json,'city')
                || !property_exists($json,'state') || !property_exists($json,'country') || !property_exists($json,'postal_code')
                || !property_exists($json,'address') || !property_exists($json,'user_lat') || !property_exists($json,'user_long')
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

                    $arr_time_slot_details = $common->get_details_dynamically('time_slot', 'from', $json->time_slot_from);
                    if ($arr_time_slot_details != 'failure') {
                        $time_slot_id = $arr_time_slot_details[0]['id'];
                    } else {
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

                        if ($json->post_job_id > 0) {

                            //******************Languages

                            $common->delete_records_dynamically('post_req_lang', 'post_job_id', $json->post_job_id);

                            foreach ($json->lang_responses as $lang_key => $lang_data) {
                                $lang_id = $lang_data->lang_id;
                                if ($lang_id == 0) { //Insert into user_lang_list ::	language_id	users_id
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

                            foreach ($json->keywords_responses as $keywords_key => $keywords_data) {
                                $keyword_id = $keywords_data->keyword_id;
                                if ($keyword_id == 0) { //Insert into keywords :: keyword,subcategories_id

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

                                //Insert into post_req_keyword table
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
                        if (count($attachments) > 0) {
                             foreach ($attachments as $attach_key => $arr_file) {
                                
                                $pos = strpos($arr_file->file, 'firebasestorage');
                    
                                    if ($pos !== false) { //URL
                                        $url = $arr_file->file;

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
                                        'booking_id' => $json->booking_id,
                                        'file_name' => $file,
                                        'file_location' => 'elasticbeanstalk-ap-south-1-702440578175/'.$folder,
                                        'created_on' => $json->created_on,
                                        'created_by' => $json->users_id,
                                        'status_id' => 44
                                    );
                                    $common->insert_records_dynamically('attachments', $arr_attach);
                                }
                        }

                        //Insert into alerts_regular_user

                        $arr_alerts = array(
                            'type_id' => 2,
                            'description' => "Your post '" . $json->title . "' is successfully updated on " . $json->created_on,
                            'user_id' => $json->users_id,
                            'profile_pic_id' => $json->users_id,
                            'status' => 2,
                            'created_on' => $json->created_on,
                            'updated_on' => $json->created_on
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                        return $this->respond([
                            "post_job_id" => $json->post_job_id,
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to update Job Post"
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

            if (
                !property_exists($json, 'booking_id') || !property_exists($json, 'post_job_id') || !property_exists($json, 'time_slot_from')  || !property_exists($json, 'job_description')
                || !property_exists($json, 'bids_period') || !property_exists($json, 'bid_per') || !property_exists($json, 'bid_range_id')
                || !property_exists($json, 'title') || !property_exists($json, 'lang_responses')
                || !property_exists($json, 'bid_range_id') || !property_exists($json, 'keywords_responses') || !property_exists($json, 'created_on')
                || !property_exists($json, 'attachments') || !property_exists($json, 'estimate_time') || !property_exists($json, 'estimate_type_id')
                || !property_exists($json, 'users_id') || !property_exists($json, 'key')
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
                    $booking_id = $json->booking_id;
                    $post_job_id = $json->post_job_id;

                    $attachments = $json->attachments;

                    $common = new CommonModel();
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

                        if ($post_job_id > 0) {

                            //******************Languages
                            $common->delete_records_dynamically('post_req_lang', 'post_job_id', $post_job_id);

                            foreach ($json->lang_responses as $lang_key => $lang_data) {
                                $lang_id = $lang_data->lang_id;
                                if ($lang_id == 0) { //Insert into user_lang_list ::	language_id	users_id
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

                            foreach ($json->keywords_responses as $keywords_key => $keywords_data) {
                                $keyword_id = $keywords_data->keyword_id;
                                if ($keyword_id == 0) { //Insert into keywords :: keyword,subcategories_id

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

                        //Insert into alerts_regular_user

                        $arr_alerts = array(
                            'type_id' => 2,
                            'description' => "Your post '" . $json->title . "' is successfully updated on " . $json->created_on,
                            'user_id' => $json->users_id,
                            'profile_pic_id' => $json->users_id,
                            'status' => 2,
                            'created_on' => $json->created_on,
                            'updated_on' => $json->created_on
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts);

                        return $this->respond([
                            "post_job_id" => $post_job_id,
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to update Job Post"
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

            if (
                !property_exists($json, 'booking_id') || !property_exists($json, 'post_job_id') || !property_exists($json, 'scheduled_date') || !property_exists($json, 'time_slot_from')
                || !property_exists($json, 'bids_period') || !property_exists($json, 'bid_per') || !property_exists($json, 'bid_range_id')
                || !property_exists($json, 'addresses') || !property_exists($json, 'title') || !property_exists($json, 'lang_responses')
                || !property_exists($json, 'bid_range_id') || !property_exists($json, 'keywords_responses') || !property_exists($json, 'created_on')
                || !property_exists($json, 'attachments') || !property_exists($json, 'estimate_time') || !property_exists($json, 'estimate_type_id')
                || !property_exists($json, 'users_id') || !property_exists($json, 'key')
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
                    $booking_id = $json->booking_id;
                    $post_job_id = $json->post_job_id;

                    $common = new CommonModel();

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

                        if (count($addresses) > 0) {
                            foreach ($addresses as $address_key => $arr_address) {
                                if ($arr_address->id == 0) {
                                    //Insert into multi_move table
                                    $arr_multi_move[] = array(
                                        'booking_id' => $booking_id,
                                        'sequence_no' => $arr_address->sequence_no,
                                        'address_id' => $arr_address->address_id,
                                        'job_description' => $arr_address->job_description,
                                        'weight_type' => $arr_address->weight_type,
                                    );
                                } else {
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
                            if (count($arr_multi_move) > 0) {
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

                        if ($post_job_id > 0) {

                            //******************Languages

                            $common->delete_records_dynamically('post_req_lang', 'post_job_id', $post_job_id);

                            foreach ($json->lang_responses as $lang_key => $lang_data) {
                                $lang_id = $lang_data->lang_id;
                                if ($lang_id == 0) { //Insert into user_lang_list ::	language_id	users_id
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

                            foreach ($json->keywords_responses as $keywords_key => $keywords_data) {
                                $keyword_id = $keywords_data->keyword_id;
                                if ($keyword_id == 0) { //Insert into keywords :: keyword,subcategories_id

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
                        
                        //Insert into alerts_regular_user

                        $arr_alerts = array(
                            'type_id' => 2,
                            'description' => "Your post '" . $json->title . "' is successfully updated on " . $json->created_on,
                            'user_id' => $json->users_id,
                            'profile_pic_id' => $json->users_id,
                            'status' => 2,
                            'created_on' => $json->created_on,
                            'updated_on' => $json->created_on
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                        return $this->respond([
                            "post_job_id" => $post_job_id,
                            "status" => 200,
                            "message" => "Success",
                        ]);
                    } else {
                        return $this->respond([
                            "status" => 404,
                            "message" => "Failed to update Job Post"
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

            if (
                !property_exists($json, 'booking_id')  || !property_exists($json, 'users_id')  || !property_exists($json, 'inst_id')
                || !property_exists($json, 'sp_id') || !property_exists($json, 'status_id')  || !property_exists($json, 'key')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->provider_key;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $misc_model = new MiscModel();
                    $date = date('Y-m-s H:i:s');

                    $arr_user_details = $common->get_details_dynamically('users', 'users_id', $json->sp_id);

                    $arr_installment_det = array(
                        'inst_status_id' => $json->status_id, //34 - approved,35 - rejected
                    );
                    
                    $common->update_records_dynamically('installment_det', $arr_installment_det, 'id', $json->inst_id);

                    //Insert into booking status
                    $arr_booking_status = array(
                        'booking_id' => $json->booking_id,
                        'status_id' => $json->status_id, //34 - approved,35 - rejected
                        'sp_id' => $json->sp_id,
                        'description' => ($json->status_id == 34) ? "User approved Installment for inst_id " . $json->inst_id : "User rejected Installment for inst_id " . $json->inst_id,
                        'created_on' => date('Y-m-d H:i:s')
                    );
                    $common->insert_records_dynamically('booking_status', $arr_booking_status);

                    $arr_user_details = $misc_model->get_user_name_by_booking($json->booking_id, $json->users_id);
                    
                    if ($arr_user_details != "failure") {
                        $user_name = $arr_user_details['fname'] . " " . $arr_user_details['lname'];
                        $user_id = $arr_user_details['users_id'];
                        $sp_id = $arr_user_details['sp_id'];
                    }

                    $inst_no = 0;

                    $arr_inst_details = $common->get_details_dynamically('installment_det', 'id', $json->inst_id);
                    if ($arr_inst_details != 'failure') {
                        $inst_no = $arr_inst_details[0]['inst_no'];
                        $amount = $arr_inst_details[0]['amount'];
                    }

                    // print_r($arr_inst_details);
                    // exit;

                    $booking_ref_id = str_pad($json->booking_id, 6, "0", STR_PAD_LEFT);

                    if ($json->status_id == 34) { //approved
                        //Make debit in to users wallet
                        $arr_wallet_details = $common->get_details_dynamically('wallet_balance', 'users_id', $json->users_id);
                        if ($arr_wallet_details != 'failure') {
                            //Get total amount and blocked amount
                            $wallet_amount = $arr_wallet_details[0]['amount'];
                            $wallet_amount_blocked = $arr_wallet_details[0]['amount_blocked'] - $amount;

                            $arr_update_wallet_data = array(
                                'amount' => $wallet_amount,
                                'amount_blocked' => $wallet_amount_blocked
                            );
                            $common->update_records_dynamically('wallet_balance', $arr_update_wallet_data, 'users_id', $json->users_id);
                        }

                        //Make entry in to SP's wallet
                        //Check if the wallet is created
                        $arr_wallet_details = $common->get_details_dynamically('wallet_balance', 'users_id', $json->sp_id);
                        if ($arr_wallet_details != 'failure') {
                            //Get total amount and blocked amount
                            $wallet_amount = $arr_wallet_details[0]['amount'] + $amount;

                            $arr_update_wallet_data = array(
                                'amount' => $wallet_amount,
                            );
                            $common->update_records_dynamically('wallet_balance', $arr_update_wallet_data, 'users_id', $json->sp_id);
                        } else {
                            $arr_wallet_data = array(
                                'users_id' => $json->sp_id,
                                'amount' => $amount,
                            );
                            $common->insert_records_dynamically('wallet_balance', $arr_wallet_data);
                        }

                        //Insert into alerts_regular_user

                        
                        $user_profile = $misc_model->user_info($json->users_id);
                        $sp_profile = $misc_model->user_info($json->sp_id);

                        $arr_alerts = array(
                            'type_id' => 2,
                            'description' => "You have approved '" . $inst_no . "' Installment for Booking '" . $booking_ref_id . "' on " . $date,
                            'user_id' => $user_id,
                            'profile_pic_id' => $json->sp_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                        //Insert into alerts_regular_SP
                        $arr_alerts1 = array(
                            'type_id' => 2,
                            'description' => $user_name . " has approved '" . $inst_no . "' Installment for Booking '" . $booking_ref_id . "' on " . $date,
                            'user_id' => $sp_id,
                            'profile_pic_id' => $user_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);
                        
                    }

                    if ($json->status_id == 35) { //rejected

                        //Insert into alerts_regular_user
                        $arr_alerts = array(
                            'type_id' => 2,
                            'description' => "You have rejected '" . $inst_no . "' Installment for Booking '" . $booking_ref_id . "' on " . $date,
                            'user_id' => $user_id,
                            'profile_pic_id' => $sp_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_user', $arr_alerts);

                        //Insert into alerts_regular_SP
                        $arr_alerts1 = array(
                            'type_id' => 2,
                            'description' => $user_name . " has rejected '" . $inst_no . "' Installment for Booking '" . $booking_ref_id . "' on " . $date,
                            'user_id' => $sp_id,
                            'profile_pic_id' => $user_id,
                            'status' => 2,
                            'created_on' => $date,
                            'updated_on' => $date
                        );

                        $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);
                    }

                    return $this->respond([
                        "sp_fcm_token" => ($arr_user_details != 'failure') ? $arr_user_details['fcm_token'] : "",
                        "status" => 200,
                        "message" => "Installment request updated Successfully",
                    ]);
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
}
