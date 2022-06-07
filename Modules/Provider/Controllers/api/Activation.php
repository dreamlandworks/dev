<?php

namespace Modules\Provider\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\CommonModel;
use Modules\Provider\Models\ServiceProviderModel;
use Modules\Provider\Models\ActivationModel;
use Modules\User\Models\MiscModel;
use Modules\User\Models\SmsTemplateModel;

helper('Modules\User\custom');

class Activation extends ResourceController
{


    /**
     * Register Service Provider
     *
     * @return mixed
     */
    public function confirm_activation()
    {

        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON(true);

            if (
                !isset($json['user_id']) || !isset($json['about_me']) 
                /*|| !array_key_exists('tariff_per_hour',$json) || !array_key_exists('tariff_per_day',$json) || !array_key_exists('tariff_min_charges',$json)
                            || !array_key_exists('tariff_extra_charges',$json) || !array_key_exists('id_proof',$json) */
                || !isset($json['profession_responses']) || !isset($json['qualification_responses']) || !isset($json['lang_responses'])
                || !isset($json['timeslot_responses']) || !isset($json['key'])
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->provider_key;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $sp = new ServiceProviderModel();
                    $misc_model = new MiscModel();

                    $sp_det_id = 0;
                    $tariff_id = 0;
                    $sp_verify_id = 0;

                    //Query all the tables to check whether data exists:: Save/Update operation
                    $sp_dtails = $sp->get_sp_activation_details($json['user_id']);
                    if ($sp_dtails != 'failure') {
                        foreach ($sp_dtails as $details) {
                            $sp_det_id = $details['sp_det_id'];
                            $sp_verify_id = $details['sp_verify_id'];
                        }
                    }

                    //Check whether Profession exists in list_profession, if not create

                    /*echo "<pre>";
    		        print_r($json['profession_responses']);
    		        echo "</pre>";
    		        exit;*/
                    if (count($json['profession_responses']) > 0) {
                        //Delete the old professions
                        $common->delete_records_dynamically('sp_profession', 'users_id', $json['user_id']);
                        $common->delete_records_dynamically('sp_skill', 'users_id', $json['user_id']);
                        $common->delete_records_dynamically('tariff', 'users_id', $json['user_id']);

                        foreach ($json['profession_responses'] as $pkey => $arr_prof_data) {
                            $prof_id = $arr_prof_data['prof_id'];
                            $name = $arr_prof_data['name'];
                            $exp_id = $arr_prof_data['experience'];
                            $subcategory_id = $arr_prof_data['subcategory_id'];
                            $category_id = $arr_prof_data['category_id'];

                            /*echo "<pre>";
            		        print_r($arr_prof_data['keywords_responses']);
            		        echo "</pre>";
            		        exit;*/

                            if ($prof_id == 0) {
                                $arr_ins_profession_det = array(
                                    'name' => $name,
                                    'subcategory_id' => $subcategory_id,
                                    'category_id' => $category_id
                                );

                                $prof_id = $common->insert_records_dynamically('list_profession', $arr_ins_profession_det);
                            }

                            $arr_ins_sp_profession = array(
                                'users_id' => $json['user_id'],
                                'profession_id' => $prof_id,
                                'exp_id' => $exp_id
                            );

                            $common->insert_records_dynamically('sp_profession', $arr_ins_sp_profession);
                            //echo "<br> prof_id ".$prof_id;



                            //*******************Keywords
                            //Insert into keywords

                            foreach ($arr_prof_data['keywords_responses'] as $keywords_key => $keywords_data) {
                                $keyword_id = $keywords_data['keyword_id'];
                                $key_res = $misc_model->get_keywords($keywords_data['name'],$prof_id);
                                if ($key_res == 'failure') { //Insert into keywords :: keyword,subcategories_id

                                    //Check whether keyword exists in keywords, if not create
                                    $arr_ins_keywords_master_det = array(
                                        'keyword' => $keywords_data['name'],
                                        'profession_id' => $prof_id,
                                        'status' => 'Active'
                                    );
                                    /*echo "<pre>";
                        		        print_r($arr_ins_keywords_master_det);
                        		        echo  "</pre>";*/

                                    $keyword_id = $common->insert_records_dynamically('keywords', $arr_ins_keywords_master_det);
                                    //echo "<br> keyword id ".$keyword_id;
                                } else {
                                    $keyword_id = $key_res[0]['id'];
                                }

                                //Build data Array
                                $arr_keyword_det = array(
                                    'users_id' => $json['user_id'],
                                    'keywords_id' => $keyword_id,
                                    'profession_id' => $prof_id,
                                );

                                $sp_skill_id = $common->insert_records_dynamically('sp_skill', $arr_keyword_det);
                            }

                         
                            

                            //*********************Tariff
                            //Insert into tariff ::	per_hour,per_day,min_charges,extra_charge,users_id
                            $arr_tariff_det = array(
                                'users_id' => $json['user_id'],
                                'per_hour' => $arr_prof_data['tariff_per_hour'],
                                'per_day' => $arr_prof_data['tariff_per_day'],
                                'min_charges' => $arr_prof_data['tariff_min_charges'],
                                'extra_charge' => $arr_prof_data['tariff_extra_charges'],
                                'profession_id' => $prof_id
                            );
                            /*echo                            "<pre>";
            		        print_r($arr_ins_tariff_det);
            		        echo                              "</pre>";*/
                            //exit;

                            $tariff_id = $common->insert_records_dynamically('tariff', $arr_tariff_det);
                            //echo "<br>".$common->getLastQuery();
                            //echo '<br> sp_tariff_id  '.$sp_tariff_id;    
                        }
                    }

                    //Check whether Qualification exists in sp_qual, if not create

                    if ($json['qualification_responses'][0]['qual_id'] == 0) {

                        $qual_res = $common->get_details_dynamically('sp_qual', 'qualification', $json['qualification_responses'][0]['name']);

                        if ($qual_res == 'failure') {
                            $arr_ins_qual_det = array(
                                'qualification' => $json['qualification_responses'][0]['name']
                            );

                            $json['qualification_responses'][0]['qual_id'] = $common->insert_records_dynamically('sp_qual', $arr_ins_qual_det);
                        } else {

                            $json['qualification_responses'][0]['qual_id'] = $qual_res[0]['id'];
                        }
                    }


                    //Build data Array
                    $arr_sp_det = array(
                        //'profession_id' => $json['profession_responses'][0]['prof_id'],
                        'qual_id' => $json['qualification_responses'][0]['qual_id'],
                        //'exp_id' => $json['experience'],
                        'about_me' => $json['about_me'],
                    );

                    if ($sp_det_id == 0) {
                        $arr_sp_det['users_id'] = $json['user_id'];
                        $sp_det_id = $common->insert_records_dynamically('sp_det', $arr_sp_det);
                    } else { //Update
                        $common->update_records_dynamically('sp_det', $arr_sp_det, 'users_id', $json['user_id']);
                    }
                    //echo '<br> sp_det_id  '.$sp_det_id;

                    //******************Languages

                    $common->delete_records_dynamically('user_lang_list', 'users_id', $json['user_id']);

                    foreach ($json['lang_responses'] as $lang_key => $lang_data) {
                        $lang_id = $lang_data['lang_id'];
                        if ($lang_data['lang_id'] == 0) {
                            $lang_res = $common->get_details_dynamically('language', 'name', $lang_data['name']);
                            if ($lang_res == 'failure') { //Insert into user_lang_list ::	language_id	users_id
                                //Check whether language exists in language, if not create
                                $arr_ins_lang_master_det = array(
                                    'name' => $lang_data['name']
                                );
                                /*echo "<pre>";
                		        print_r($arr_ins_lang_master_det);
                		        echo "</pre>";*/

                                $lang_id = $common->insert_records_dynamically('language', $arr_ins_lang_master_det);
                            } else {
                                $lang_id = $lang_res[0]['id'];
                            }
                        }

                        //Build data Array
                        $arr_lang_det = array(
                            'users_id' => $json['user_id'],
                            'language_id' => $lang_id,
                        );

                        $user_lang_list_id = $common->insert_records_dynamically('user_lang_list', $arr_lang_det);
                        //echo '<br> user_lang_list_id  '.$user_lang_list_id;
                    }

                    //*****************user_time_slot
                    //Get master time slot
                    $arr_time_slots = array();
                    $arr_time_slots_24 = array();

                    $arr_time_slot_details = $common->get_table_details_dynamically('time_slot', 'id', 'ASC');
                    if ($arr_time_slot_details != 'failure') {
                        foreach ($arr_time_slot_details as $time_data) {
                            $arr_time_slots[$time_data['from']] = $time_data['id'];
                        }
                    }
                    $common->delete_records_dynamically('user_time_slot', 'users_id', $json['user_id']);

                    $arr_main_time_slots = array();
                    $arr_ins_timeslot_det = array();

                    foreach ($json['timeslot_responses'] as $timeslot_key => $timeslot_data) {
                        $from_slot_id = $arr_time_slots[$timeslot_data['from']];
                        $to_slot_id = $arr_time_slots[$timeslot_data['to']];

                        $arr_days = explode(",", $timeslot_data['days']);

                        if ($from_slot_id < $to_slot_id) {
                            foreach ($arr_days as $day_id) {
                                for ($i = $from_slot_id; $i <= $to_slot_id; $i++) { //Loop time per hour basis
                                    $arr_main_time_slots[$day_id][$i] = $i;
                                }
                            }
                        } else { //Midnight is overlapped - split from id till midnit 12 and start from 1 to toid
                            foreach ($arr_days as $day_id) {
                                for ($i = $from_slot_id; $i <= 24; $i++) { //Loop time per hour basis , 24 is for 00:00:00
                                    $arr_main_time_slots[$day_id][$i] = $i;
                                }
                                for ($i = 1; $i <= $to_slot_id; $i++) { //Loop time per hour basis 
                                    $arr_main_time_slots[$day_id][$i] = $i;
                                }
                            }
                        }
                    }

                    if (count($arr_main_time_slots) > 0) {
                        foreach ($arr_main_time_slots as $day_id => $arr_data) {
                            foreach ($arr_data as $i) {
                                if ($i <= 22) {
                                    $time_slot_to = ($i + 1) . ":00:00";
                                } else if ($i == 23) {
                                    $time_slot_to = "00:00:00";
                                } else if ($i == 24) {
                                    $time_slot_to = "01:00:00";
                                }

                                //echo "<br> day_id ".$day_id." ".$i;
                                $arr_ins_timeslot_det[] = array(
                                    'users_id' => $json['user_id'],
                                    'day_slot' => $day_id,
                                    'time_slot_id' => $i,
                                    'time_slot_from' => ($i <= 23) ? $i . ":00:00" : "00:00:00",
                                    'time_slot_to' => $time_slot_to,
                                );
                            }
                        }
                    }

                    //echo "<pre>";
                    //print_r($arr_main_time_slots);
                    //print_r($arr_ins_timeslot_det);
                    //echo "</pre>";
                    //exit;
                    if (count($arr_ins_timeslot_det) > 0) {
                        $user_timeslot_list_id = $common->batch_insert_records_dynamically('user_time_slot', $arr_ins_timeslot_det);
                        //echo '<br> user_timeslot_list_id  '.$user_timeslot_list_id;
                    }

                    //update users activation code
                    //$arr_users_update = array('activation_code' => 1);

                    //$common->update_records_dynamically('users', $arr_users_update, 'users_id', $json['user_id']);

                    return $this->respond([
                        "status" => 200,
                        "message" => "Success"
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

    /**
     * Capture video verification
     *
     * @return mixed
     */
    public function video_verification()
    {
        //getting POST data from API
        $post = $this->request->getPost();
        
        $key = md5($post['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
        $apiconfig = new \Config\ApiConfig();

        $api_key = $apiconfig->provider_key;

        if ($key == $api_key) {
            $common = new CommonModel();

            $video_no = $post['video_no'];

            $file = $this->request->getFile('video_record');

            // Generate a new secure name
            $name = $post['users_id'] . '_video_record_' . $video_no . '_' . $file->getRandomName();
            
            // Move the file to it's new home
            // $file->move("./videos/", $name);
            $s3_file = generateS3Video($name,$file);

            print_r($s3_file);
            exit;
            
            $arr_update = array('video_record_' . $video_no => $s3_file);

            //update into sp_verify
            $common->update_records_dynamically('sp_verify', $arr_update, 'users_id', $post['users_id']);

            if ($post['video_no'] == 3) {
                //update users and activate the SP
                $arr_users_update = array('sp_activated' => 2, 'activation_code' => ($video_no + 1));

                $common->update_records_dynamically('users', $arr_users_update, 'users_id', $post['users_id']);

                $sp_name = "";
                $sp_mobile = "";

                $arr_sp_details = $common->get_details_dynamically('user_details', 'id', $post['users_id'], 'id', 'ASC');
                if ($arr_sp_details != "failure") {
                    $sp_name = $arr_sp_details[0]['fname'];
                    $sp_mobile = $arr_sp_details[0]['mobile'];
                }

                //Send SMS
                $sms_model = new SmsTemplateModel();

                $data = [
                    "name" => "sp_create",
                    "mobile" => $sp_mobile,
                    "dat" => [
                        "var" => $sp_name,
                    ]
                ];

                $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);


                //Insert into alert_regular_user

                $date = date('Y-m-s H:i:s');
                $arr_alerts = array(
                    'type_id' => 4,
                    'description' => "You have succesfully activated Service Provider Account on " . $date,
                    'user_id' => $post['users_id'],
                    'profile_pic_id' => $post['users_id'],
                    'status' => 2,
                    'created_on' => $date,
                    'updated_on' => $date,
                );

                $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                //Insert into alert_regular_sp

                $arr_alerts1 = array(
                    'type_id' => 4,
                    'description' => "Your Service Provider Account is activated on " . $date . " and pending for approval",
                    'user_id' => $post['users_id'],
                    'profile_pic_id' => $post['users_id'],
                    'status' => 2,
                    'created_on' => $date,
                    'updated_on' => $date,
                );

                $common->insert_records_dynamically('alert_regular_sp', $arr_alerts1);
            } else {
                //update users activation code
                $arr_users_update = array('activation_code' => ($video_no + 1));
                $common->update_records_dynamically('users', $arr_users_update, 'users_id', $post['users_id']);
            }

            return $this->respond([
                "status" => 200,
                "message" => "Success"
            ]);
        } else {
            return $this->respond([
                'status' => 403,
                'message' => 'Access Denied ! Authentication Failed'
            ]);
        }
    }

    public function get_sp_professional_details()
    {

        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON(true);

            if (
                !isset($json['sp_id']) || !isset($json['key'])
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->provider_key;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $sp = new ServiceProviderModel();
                    $misc_model = new MiscModel();
                    $sp_id = $json['sp_id'];
                    $ar_sp_id[$sp_id] = $sp_id;
                    $total_days = 0;
                    $weekend_check = 0;
                    $slot_selection =  "";

                    //Query all the tables to check whether data exists:: Save/Update operation
                    $sp_details = $sp->get_sp_details($sp_id);

                    //Get Professional details

                    $arr_professional_details = array();
                    $arr_skills_details = array();

                    //Get Skills details
                    $arr_skills_list = $sp->get_sp_professional_skills($sp_id);
                    if ($arr_skills_list != 'failure') {
                        foreach ($arr_skills_list as $skey => $skill_data) {
                            $arr_skills_details[$skill_data['profession_id']][$skill_data['keywords_id']] = $skill_data['keyword'];
                        }
                    }

                    /*echo "<pre>";
	                print_r($arr_skills_details);
	                echo "</pre>";*/

                    $arr_professional_list = $sp->get_sp_professional_details($sp_id);
                    if ($arr_professional_list != 'failure') {
                        foreach ($arr_professional_list as $key => $prof_data) {
                            $arr_professional_details[$key]['profession_id'] = $prof_data['profession_id'];
                            $arr_professional_details[$key]['category_id'] = $prof_data['category_id'];
                            $arr_professional_details[$key]['tariff_id'] = $prof_data['tariff_id'];
                            $arr_professional_details[$key]['profession_name'] = $prof_data['profession_name'];
                            $arr_professional_details[$key]['exp'] = $prof_data['exp'];
                            $arr_professional_details[$key]['tariff_per_hour'] = $prof_data['tariff_per_hour'];
                            $arr_professional_details[$key]['tariff_per_day'] = $prof_data['tariff_per_day'];
                            $arr_professional_details[$key]['tariff_min_charges'] = $prof_data['tariff_min_charges'];
                            $arr_professional_details[$key]['tariff_extra_charges'] = $prof_data['tariff_extra_charges'];
                            $arr_professional_details[$key]['skills'] = array();

                            if (array_key_exists($prof_data['profession_id'], $arr_skills_details)) {
                                foreach ($arr_skills_details[$prof_data['profession_id']] as $keywords_id => $keyword) {
                                    $arr_professional_details[$key]['skills'][] = array('keywords_id' => $keywords_id, 'keyword' => $keyword);
                                }

                                /*echo "<br> profession_id ".$prof_data['profession_id'];
	                            echo "<pre>";
            	                print_r($arr_skills_details[$prof_data['profession_id']]);
            	                echo "</pre>";*/
                            }
                        }
                    }

                    //Get Language details
                    $arr_language_details = $misc_model->get_sp_lang($sp_id);

                    $arr_day_time_slots = array();
                    $arr_preferred_time_slots = array();

                    //Get SP's preferred day/timeslot data
                    $arr_preferred_time_slots_list = $misc_model->get_sp_preferred_day_time_slot($sp_id);
                    if ($arr_preferred_time_slots_list != 'failure') {
                        foreach ($arr_preferred_time_slots_list as $slots) {
                            $arr_day_time_slots[$slots['time_slot_id']]['day_slots'][] =  $slots['day_slot'];
                            $arr_day_time_slots[$slots['time_slot_id']]['time_slot_from'] =  $slots['time_slot_from'];
                            $arr_day_time_slots[$slots['time_slot_id']]['time_slot_to'] =  $slots['time_slot_to'];
                        }
                    }

                    $i = 0;
                    if (count($arr_day_time_slots) > 0) {
                        foreach ($arr_day_time_slots as $time_slot_id => $sdata) {
                            $arr_preferred_time_slots[$i]['time_slot_id'] = $time_slot_id;
                            $arr_preferred_time_slots[$i]['day_slots'] = implode(",", $sdata['day_slots']);
                            $arr_preferred_time_slots[$i]['time_slot_from'] = $sdata['time_slot_from'];
                            $arr_preferred_time_slots[$i]['time_slot_to'] = $sdata['time_slot_to'];

                            $i++;
                        }
                    }

                    /*echo "<pre>";
	                print_r($arr_day_time_slots);
	                print_r($arr_preferred_time_slots);
	                echo "</pre>";
	                exit;*/
                    /*$arr_preferred_time_slots_list = $misc_model->get_sp_preferred_time_slot($ar_sp_id);
                    if($arr_preferred_time_slots_list != 'failure') {
                        foreach($arr_preferred_time_slots_list as $slots) {
                            if($slots['day_slot'] == 1) {
                                $weekend_check = 1;
                            }
                            
                            $total_days += $slots['day_slot'];
                        }
                    }
                    
                    if($total_days == 8 && $weekend_check == 1) {
                        $slot_selection = "Weekends";
                    }
                    else if($total_days == 28 && $weekend_check == 0) {
                        $slot_selection = "Everyday";
                    }
                    else if($total_days == 20 && $weekend_check == 0) {
                        $slot_selection = "Weekday";
                    }*/

                    if ($sp_details != 'failure') {
                        return $this->respond([
                            "sp_details" => $sp_details[0],
                            "profession" => $arr_professional_details,
                            //"skills" => ($arr_skills_details != 'failure') ? $arr_skills_details : array(),
                            "language" => ($arr_language_details != 'failure') ? $arr_language_details : array(),
                            "preferred_time_slots" => $arr_preferred_time_slots,
                            //"slot_selection" => $slot_selection,
                            "status" => 200,
                            "message" => "Success"
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

    public function update_sp_prof_details()
    {

        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON(true);

            if (
                !isset($json['user_id']) || !isset($json['about_me'])
                || !isset($json['profession_responses']) || !isset($json['qualification_responses']) || !isset($json['lang_responses'])
                || !isset($json['key'])
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->provider_key;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $sp = new ServiceProviderModel();
                    $misc_model = new MiscModel();

                    $sp_det_id = 0;
                    $tariff_id = 0;
                    $sp_verify_id = 0;

                    //Query all the tables to check whether data exists:: Save/Update operation
                    $sp_dtails = $sp->get_sp_activation_details($json['user_id']);
                    if ($sp_dtails != 'failure') {
                        foreach ($sp_dtails as $details) {
                            $sp_det_id = $details['sp_det_id'];
                            $sp_verify_id = $details['sp_verify_id'];
                        }
                    }

                    /*echo "<pre>";
            		print_r($sp_dtails);
            		echo "</pre>";
            		exit;*/

                    //Check whether Profession exists in list_profession, if not create

                    /*echo "<pre>";
    		        print_r($json['profession_responses']);
    		        echo "</pre>";
    		        exit;*/
                    if (count($json['profession_responses']) > 0) {
                        //Delete the old professions
                        $common->delete_records_dynamically('sp_profession', 'users_id', $json['user_id']);
                        $common->delete_records_dynamically('sp_skill', 'users_id', $json['user_id']);
                        $common->delete_records_dynamically('tariff', 'users_id', $json['user_id']);

                        foreach ($json['profession_responses'] as $pkey => $arr_prof_data) {
                            $prof_id = $arr_prof_data['prof_id'];
                            $name = $arr_prof_data['name'];
                            $exp_id = $arr_prof_data['experience'];

                            /*echo "<pre>";
            		        print_r($arr_prof_data['keywords_responses']);
            		        echo "</pre>";
            		        exit;*/

                            if ($prof_id == 0) {
                                $arr_ins_profession_det = array(
                                    'name' => $name,
                                    'profession_id' => $prof_id,
                                    'subcategory_id' => 0
                                );

                                $prof_id = $common->insert_records_dynamically('list_profession', $arr_ins_profession_det);
                            }

                            $arr_ins_sp_profession = array(
                                'users_id' => $json['user_id'],
                                'profession_id' => $prof_id,
                                'exp_id' => $exp_id
                            );

                            $common->insert_records_dynamically('sp_profession', $arr_ins_sp_profession);
                            //echo "<br> prof_id ".$prof_id;


                            //*******************Keywords
                            //Insert into keywords
                            foreach ($arr_prof_data['keywords_responses'] as $keywords_key => $keywords_data) {
                                $keyword_id = $keywords_data['keyword_id'];
                                $key_res = $misc_model->get_keywords($keywords_data['name'],$prof_id);
                                if ($key_res == 'failure') { //Insert into keywords :: keyword,subcategories_id

                                    //Check whether keyword exists in keywords, if not create
                                    $arr_ins_keywords_master_det = array(
                                        'keyword' => $keywords_data['name'],
                                        'profession_id' => $prof_id,
                                        'status' => 'Inactive'
                                    );
                                    /*echo "<pre>";
                        		        print_r($arr_ins_keywords_master_det);
                        		        echo  "</pre>";*/

                                    $keyword_id = $common->insert_records_dynamically('keywords', $arr_ins_keywords_master_det);
                                    //echo "<br> keyword id ".$keyword_id;
                                } else {
                                    $keyword_id = $key_res[0]['id'];
                                }

                                //Build data Array
                                $arr_keyword_det = array(
                                    'users_id' => $json['user_id'],
                                    'keywords_id' => $keyword_id,
                                    'profession_id' => $prof_id,
                                );

                                $sp_skill_id = $common->insert_records_dynamically('sp_skill', $arr_keyword_det);
                            }

                            //*********************Tariff
                            //Insert into tariff ::	per_hour,per_day,min_charges,extra_charge,users_id
                            $arr_tariff_det = array(
                                'users_id' => $json['user_id'],
                                'per_hour' => $arr_prof_data['tariff_per_hour'],
                                'per_day' => $arr_prof_data['tariff_per_day'],
                                'min_charges' => $arr_prof_data['tariff_min_charges'],
                                'extra_charge' => $arr_prof_data['tariff_extra_charges'],
                                'profession_id' => $prof_id
                            );
                            /*echo "<pre>";
            		        print_r($arr_ins_tariff_det);
            		        echo "</pre>";*/
                            //exit;

                            $tariff_id = $common->insert_records_dynamically('tariff', $arr_tariff_det);
                            //echo "<br>".$common->getLastQuery();
                            //echo '<br> sp_tariff_id  '.$sp_tariff_id;    
                        }
                    }

                    //Check whether Qualification exists in sp_qual, if not create
                    if ($json['qualification_responses'][0]['qual_id'] == 0) {
                        $arr_ins_qual_det = array(
                            'qualification' => $json['qualification_responses'][0]['name']
                        );
                        $json['qualification_responses'][0]['qual_id'] = $common->insert_records_dynamically('sp_qual', $arr_ins_qual_det);
                    }

                    //Build data Array
                    $arr_sp_det = array(
                        'qual_id' => $json['qualification_responses'][0]['qual_id'],
                        'about_me' => $json['about_me'],
                    );

                    if ($sp_det_id == 0) {
                        $arr_sp_det['users_id'] = $json['user_id'];
                        $sp_det_id = $common->insert_records_dynamically('sp_det', $arr_sp_det);
                    } else { //Update
                        $common->update_records_dynamically('sp_det', $arr_sp_det, 'users_id', $json['user_id']);
                    }
                    //echo '<br> sp_det_id  '.$sp_det_id;

                    //******************Languages

                    $common->delete_records_dynamically('user_lang_list', 'users_id', $json['user_id']);

                    foreach ($json['lang_responses'] as $lang_key => $lang_data) {
                        $lang_id = $lang_data['lang_id'];
                        if ($lang_data['lang_id'] == 0) { //Insert into user_lang_list ::	language_id	users_id
                            //Check whether language exists in language, if not create
                            $arr_ins_lang_master_det = array(
                                'name' => $lang_data['name']
                            );
                            /*echo "<pre>";
            		        print_r($arr_ins_lang_master_det);
            		        echo                      "</pre>";*/

                            $lang_id = $common->insert_records_dynamically('language', $arr_ins_lang_master_det);
                        }

                        //Build data Array
                        $arr_lang_det = array(
                            'users_id' => $json['user_id'],
                            'language_id' => $lang_id,
                        );

                        $common->insert_records_dynamically('user_lang_list', $arr_lang_det);
                        //echo '<br> user_lang_list_id  '.$user_lang_list_id;
                    }

                    //Insert into alert_regular_sp

                    $date = date('Y-m-s H:i:s');
                    $arr_alerts = array(
                        'type_id' => 4,
                        'description' => "Your Service Provider Profile is successfully updated on " . $date,
                        'user_id' => $json['user_id'],
                        'profile_pic_id' => $json['user_id'],
                        'status' => 2,
                        'created_on' => $date,
                        'updated_on' => $date
                    );

                    $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);


                    return $this->respond([
                        "status" => 200,
                        "message" => "Success"
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

    public function update_sp_tariff_time_slot()
    {

        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON(true);

            if (
                !property_exists($json, 'user_id')
                /*|| !array_key_exists('tariff_per_hour',$json) || !array_key_exists('tariff_per_day',$json) || !array_key_exists('tariff_min_charges',$json)
                            || !array_key_exists('tariff_extra_charges',$json)*/
                || !property_exists($json, 'timeslot_responses') || !property_exists($json, 'key')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->provider_key;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    /*$sp = new ServiceProviderModel();
    		        
    		        $sp_det_id = 0;
    			    $tariff_id = 0;
    			    $sp_verify_id = 0;
    		        
    		        //Query all the tables to check whether data exists:: Save/Update operation
    		        $sp_dtails = $sp->get_sp_activation_details($json['user_id']);
    		        if ($sp_dtails != 'failure') {
            			foreach($sp_dtails as $details) {
            			    $sp_det_id = $details['sp_det_id'];
            			    $tariff_id = $details['tariff_id'];
            			}
            		}
    		        
    		        //*********************Tariff
                    //Insert into tariff ::	per_hour,per_day,min_charges,extra_charge,users_id

    		        $arr_tariff_det = array(
		                'users_id' => $json['user_id'],
		                'per_hour' => $json['tariff_per_hour'],
		                'per_day' => $json['tariff_per_day'],
		                'min_charges' => $json['tariff_min_charges'],
		                'extra_charge' => $json['tariff_extra_charges'],
    		        );*/
                    /*echo                            "<pre>";
    		        print_r($arr_ins_tariff_det);
    		        echo                              "</pre>";*/
                    //exit;

                    /*if($tariff_id == 0) {
    		            $arr_tariff_det['users_id'] = $json['user_id'];
    		            
    		            $tariff_id = $common->insert_records_dynamically('tariff', $arr_tariff_det);
    		        }
    		        else { //Update
        		        $common->update_records_dynamically('tariff', $arr_tariff_det, 'users_id', $json['user_id']);
        		    }*/


                    //echo "<br>".$common->getLastQuery();
                    //echo '<br> sp_tariff_id  '.$sp_tariff_id;

                    //*****************user_time_slot
                    //Get master time slot
                    $arr_time_slots = array();
                    $arr_time_slot_details = $common->get_table_details_dynamically('time_slot', 'id', 'ASC');
                    if ($arr_time_slot_details != 'failure') {
                        foreach ($arr_time_slot_details as $time_data) {
                            $arr_time_slots[$time_data['from']] = $time_data['id'];
                        }
                    }
                    $common->delete_records_dynamically('user_time_slot', 'users_id', $json['user_id']);

                    foreach ($json['timeslot_responses'] as $timeslot_key => $timeslot_data) {
                        $arr_days = explode(",", $timeslot_data['days']);
                        foreach ($arr_days as $day_id) {
                            $arr_ins_timeslot_det[] = array(
                                'users_id' => $json['user_id'],
                                'day_slot' => $day_id,
                                'time_slot_id' => $arr_time_slots[$timeslot_data['from']],
                                'time_slot_from' => $timeslot_data['from'],
                                'time_slot_to' => $timeslot_data['to'],
                            );
                        }
                    }
                    /*echo                            "<pre>";
    		        print_r($arr_ins_timeslot_det);
    		        echo                              "</pre>";
    		        exit;*/

                    $common->batch_insert_records_dynamically('user_time_slot', $arr_ins_timeslot_det);
                    //echo '<br> user_timeslot_list_id  '.$user_timeslot_list_id;


                    //Insert into alert_regular_sp

                    $date = date('Y-m-s H:i:s');
                    $arr_alerts = array(
                        'type_id' => 4,
                        'description' => "Your Service Provider Tariff is successfully updated on " . $date,
                        'user_id' => $json['user_id'],
                        'profile_pic_id' => $json['user_id'],
                        'status' => 2,
                        'created_on' => $date,
                        'updated_on' => $date
                    );

                    $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);

                    return $this->respond([
                        "status" => 200,
                        "message" => "Success"
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

    public function id_proof()
    {

        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON(true);

            /*echo "<pre>";
	        print_r($json);
	        echo "</pre>";
	        exit;*/

            if (
                !isset($json['user_id']) || !isset($json['id_proof']) || !isset($json['key'])
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->provider_key;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $sp = new ServiceProviderModel();
                    $misc_model = new MiscModel();

                    $sp_verify_id = 0;

                    //Query all the tables to check whether data exists:: Save/Update operation
                    $sp_dtails = $sp->get_sp_activation_details($json['user_id']);
                    if ($sp_dtails != 'failure') {
                        foreach ($sp_dtails as $details) {
                            $sp_det_id = $details['sp_det_id'];
                            $sp_verify_id = $details['sp_verify_id'];
                        }
                    }

                    //*********************ID Proof
                    $id_proof_file = $json['id_proof'];
                    if ($id_proof_file != null) {
                      //  $image = generateDynamicImage("images/id_proof", $id_proof_file);
                        $image = generateS3Object("images",$id_proof_file,"png");
                        $arr_verify_det = array(
                            'users_id' => $json['user_id'],
                            'id_card' => $image,
                        );

                        if ($sp_verify_id == 0) {
                            $arr_verify_det['users_id'] = $json['user_id'];
                            $user_id_proof_id = $common->insert_records_dynamically('sp_verify', $arr_verify_det);
                        } else { //Update
                            $common->update_records_dynamically('sp_verify', $arr_verify_det, 'users_id', $json['user_id']);
                        }

                        //echo '<br> user_id_proof_id  '.$user_id_proof_id;
                    }

                    //update users activation code
                    $arr_users_update = array('activation_code' => 1);

                    $common->update_records_dynamically('users', $arr_users_update, 'users_id', $json['user_id']);

                    return $this->respond([
                        "status" => 200,
                        "message" => "Success"
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
}
