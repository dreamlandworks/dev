<?php

namespace Modules\Provider\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\CommonModel;
use Modules\Provider\Models\ServiceProviderModel;

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
            
            if(!array_key_exists('user_id',$json) || !array_key_exists('experience',$json) || !array_key_exists('about_me',$json) 
                            || !array_key_exists('tariff_per_hour',$json) || !array_key_exists('tariff_per_day',$json) || !array_key_exists('tariff_min_charges',$json)
                            || !array_key_exists('tariff_extra_charges',$json) || !array_key_exists('id_proof',$json) 
                            || !array_key_exists('profession_responses',$json) || !array_key_exists('qualification_responses',$json) || !array_key_exists('lang_responses',$json)
                            || !array_key_exists('keywords_responses',$json) || !array_key_exists('timeslot_responses',$json) || !array_key_exists('key',$json)
                            ) {
    		    return $this->respond([
        				'status' => 403,
                        'message' => 'Invalid Parameters'
        		]);
    		}
            else {
                $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
                $apiconfig = new \Config\ApiConfig();
		
    		    $api_key = $apiconfig->provider_key;
    		    
    		    if($key == $api_key) {
    		        $common = new CommonModel();
    		        $sp = new ServiceProviderModel();
    		        
    		        $sp_det_id = 0;
    			    $tariff_id = 0;
    			    $sp_verify_id = 0;
    		        
    		        //Query all the tables to check whether data exists:: Save/Update operation
    		        $sp_dtails = $sp->get_sp_activation_details($json['user_id']);
    		        if ($sp_dtails != 'failure') {
            			foreach($sp_dtails as $details) {
            			    $sp_det_id = $details['sp_det_id'];
            			    $tariff_id = $details['tariff_id'];
            			    $sp_verify_id = $details['sp_verify_id'];
            			}
            		}
    		        
    		        //Check whether Profession exists in list_profession, if not create
    		        if($json['profession_responses'][0]['prof_id'] == 0) {
    		            $arr_ins_profession_det = array(
    		                'name' => $json['profession_responses'][0]['name'],
							'subcategory_id' => 0
        		        );
        		        $json['profession_responses'][0]['prof_id'] = $common->insert_records_dynamically('list_profession', $arr_ins_profession_det);
    		        }
    		        
    		        //Check whether Qualification exists in sp_qual, if not create
    		        if($json['qualification_responses'][0]['qual_id'] == 0) {
    		            $arr_ins_qual_det = array(
    		                'qualification' => $json['qualification_responses'][0]['name']
        		        );
        		        $json['qualification_responses'][0]['qual_id'] = $common->insert_records_dynamically('sp_qual', $arr_ins_qual_det);
    		        }
    		        
    		        //Build data Array
		            $arr_sp_det = array(
		                'profession_id' => $json['profession_responses'][0]['prof_id'],
		                'qual_id' => $json['qualification_responses'][0]['qual_id'],
		                'exp_id' => $json['experience'],
		                'about_me' => $json['about_me'],
    		        );
    		        
    		        if($sp_det_id == 0){
    		            $arr_sp_det['users_id'] = $json['user_id'];
    		            $sp_det_id = $common->insert_records_dynamically('sp_det', $arr_sp_det);
    		        }
    		        else { //Update
    		            $common->update_records_dynamically('sp_det', $arr_sp_det, 'users_id', $json['user_id']);
    		        }
                    //echo '<br> sp_det_id  '.$sp_det_id;
                    
                    //******************Languages
                    
                    $common->delete_records_dynamically('user_lang_list', 'users_id', $json['user_id']);
                    
                    foreach($json['lang_responses'] as $lang_key => $lang_data) {
                        $lang_id = $lang_data['lang_id'];
                        if($lang_data['lang_id'] == 0) { //Insert into user_lang_list ::	language_id	users_id
                            //Check whether language exists in language, if not create
            		        $arr_ins_lang_master_det = array(
        		                'name' => $lang_data['name']
            		        );
            		        /*echo "<pre>";
            		        print_r($arr_ins_lang_master_det);
            		        echo "</pre>";*/
            		        
            		        $lang_id = $common->insert_records_dynamically('language', $arr_ins_lang_master_det);
                        }
                        
                        //Build data Array
    		            $arr_lang_det = array(
    		                'users_id' => $json['user_id'],
    		                'language_id' => $lang_id,
    		            );
        		        
        		        $user_lang_list_id = $common->insert_records_dynamically('user_lang_list', $arr_lang_det);
                        //echo '<br> user_lang_list_id  '.$user_lang_list_id;
                    }
                    
                    //*******************Keywords
                    
                    $common->delete_records_dynamically('sp_skill', 'users_id', $json['user_id']);
                    
                    foreach($json['keywords_responses'] as $keywords_key => $keywords_data) {
                        $keyword_id = $keywords_data['keyword_id'];
                        if($keywords_data['keyword_id'] == 0) { //Insert into keywords :: keyword,subcategories_id

                            //Check whether keyword exists in keywords, if not create
            		        $arr_ins_keywords_master_det = array(
        		                'keyword' => $keywords_data['name'],
        		                'profession_id' => $json['profession_responses'][0]['prof_id'],
								//'subcategories_id' => 6, //Temporary subvategory, needs admin approval
        		                'status' => 'Inactive'
            		        );
            		        /*echo "<pre>";
            		        print_r($arr_ins_keywords_master_det);
            		        echo "</pre>";*/
            		        
            		        $keyword_id = $common->insert_records_dynamically('keywords', $arr_ins_keywords_master_det);
            		        //echo "<br> keyword id ".$keyword_id;
                        }
                        
                        //Build data Array
    		            $arr_keyword_det = array(
    		                'users_id' => $json['user_id'],
    		                'keywords_id' => $keyword_id,
    		            );
        		        
        		        $sp_skill_id = $common->insert_records_dynamically('sp_skill', $arr_keyword_det);
                        
                        /*echo "<pre>";
        		        print_r($arr_ins_keyword_det);
        		        echo "</pre>";*/
        		        //echo '<br> user_keyword_list_id  '.$user_keyword_list_id;
                    }
                    
                    //*********************Tariff
                    //Insert into tariff ::	per_hour,per_day,min_charges,extra_charge,users_id

    		        $arr_tariff_det = array(
		                'users_id' => $json['user_id'],
		                'per_hour' => $json['tariff_per_hour'],
		                'per_day' => $json['tariff_per_day'],
		                'min_charges' => $json['tariff_min_charges'],
		                'extra_charge' => $json['tariff_extra_charges'],
    		        );
    		        /*echo "<pre>";
    		        print_r($arr_ins_tariff_det);
    		        echo "</pre>";*/
    		        //exit;
    		        
    		        if($tariff_id == 0) {
    		            $arr_tariff_det['users_id'] = $json['user_id'];
    		            
    		            $tariff_id = $common->insert_records_dynamically('tariff', $arr_tariff_det);
    		        }
    		        else { //Update
        		        $common->update_records_dynamically('tariff', $arr_tariff_det, 'users_id', $json['user_id']);
        		    }
                        
                    
                    //echo "<br>".$common->getLastQuery();
                    //echo '<br> sp_tariff_id  '.$sp_tariff_id;
                    
                    //*****************user_time_slot
                    
                    $common->delete_records_dynamically('user_time_slot', 'users_id', $json['user_id']);
                    
                    foreach($json['timeslot_responses'] as $timeslot_key => $timeslot_data) {
                        $arr_days = explode(",",$timeslot_data['days']);
                        foreach($arr_days as $day_id) {
                            $arr_ins_timeslot_det[] = array(
        		                'users_id' => $json['user_id'],
        		                'day_slot' => $day_id,
        		                'time_slot_from' => $timeslot_data['from'],
        		                'time_slot_to' => $timeslot_data['to'],
        		            );
                        }
                    }
                    /*echo "<pre>";
    		        print_r($arr_ins_timeslot_det);
    		        echo "</pre>";
    		        exit;*/
    		        
    		        $user_timeslot_list_id = $common->batch_insert_records_dynamically('user_time_slot', $arr_ins_timeslot_det);
                    //echo '<br> user_timeslot_list_id  '.$user_timeslot_list_id;
                    
                    //*********************ID Proof
                    $id_proof_file = $json['id_proof'];
                    if ($id_proof_file != null) {
                        $image = generateDynamicImage("images/id_proof",$id_proof_file);
                            
                        $arr_verify_det = array(
    		                'users_id' => $json['user_id'],
    		                'id_card' => $image,
    		            );
    		            
    		            if($sp_verify_id == 0) {
    		                $arr_verify_det['users_id'] = $json['user_id'];
    		                $user_id_proof_id = $common->insert_records_dynamically('sp_verify', $arr_verify_det);
    		            }
                        else { //Update
            		        $common->update_records_dynamically('sp_verify', $arr_verify_det, 'users_id', $json['user_id']);
            		    }
                        
                        //echo '<br> user_id_proof_id  '.$user_id_proof_id;
                    }
                    
                    return $this->respond([
    					"status" => 200,
    					"message" => "Success"
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

	/**
	 * Create a new resource object, from "posted" parameters
	 *
	 * @return mixed
	 */
	public function create()
	{
		//
	}

	/**
	 * Return the editable properties of a resource object
	 *
	 * @return mixed
	 */
	public function edit($id = null)
	{
		//
	}

	/**
	 * Add or update a model resource, from "posted" properties
	 *
	 * @return mixed
	 */
	public function update($id = null)
	{
		//
	}

	/**
	 * Delete the designated resource object from the model
	 *
	 * @return mixed
	 */
	public function delete($id = null)
	{
		//
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
	    
	    if($key == $api_key) {
            $common = new CommonModel();
            
            $video_no = $post['video_no'];
            
            $file = $this->request->getFile('video_record');
                
            // Generate a new secure name
            $name = $post['users_id'].'_video_record_'.$video_no.'_'.$file->getRandomName();
        
            // Move the file to it's new home
            $file->move("./videos/", $name);
            
            $arr_update = array('video_record_'.$video_no => $name);
            
            //update into sp_verify
            $common->update_records_dynamically('sp_verify', $arr_update, 'users_id', $post['users_id']);
            
            if($post['video_no'] == 3) {
                //update users and activate the SP
                $arr_users_update = array('sp_activated' => 3);
                
                $common->update_records_dynamically('users', $arr_users_update, 'users_id', $post['users_id']);
            }    
            
            return $this->respond([
				"status" => 200,
				"message" => "Success"
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
