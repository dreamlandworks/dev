<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Config\Mimes;

use Modules\User\Models\keywordModel;
use Modules\User\Models\AddressModel;
use Modules\User\Models\ZipcodeModel;
use Modules\User\Models\CityModel;
use Modules\User\Models\StateModel;
use Modules\User\Models\CountryModel;
use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;

use function PHPUnit\Framework\isEmpty;

helper('Modules\User\custom');

class SearchProvider extends ResourceController
{

    //-----------------------------------------------Search STARTS----------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to Search Service Provider
     * 
     * Call to this function will Search Service Provider
     */
    public function search_result()
    {

        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            
            
            if(!property_exists($json, 'city') //keyword_id == search_phrase_id
                || !property_exists($json, 'state') || !property_exists($json, 'country') || !property_exists($json, 'postal_code') || !property_exists($json, 'search_phrase') 
                || !property_exists($json, 'address') || !property_exists($json, 'user_lat') || !property_exists($json, 'user_long') 
                || !property_exists($json, 'offer_id') || !property_exists($json, 'users_id') || !property_exists($json, 'key')
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
    		        
                    // //JSON Objects declared into variables
                    
                    $offer_id = $json->offer_id;
                    $discount = 0;
                    $value_type_id = 0;
                    $value = 0;
                    $CGST = 0;
                    $charge_per_km = 0;
                    $SGST = 0;
                    $GST = 0;
                    
                    //Get offer details
                    if($offer_id > 0) {
                        $arr_offer_details = $common->get_details_dynamically('offer', 'id', $offer_id);
        		        if($arr_offer_details != 'failure') {
        		            $value_type_id = $arr_offer_details[0]['value_type_id'];
        		            $value = $arr_offer_details[0]['value'];
        		        }
        		    }
        		    
        		    //Get Charges
                    $arr_charges = $common->get_table_details_dynamically('tax_cancel_charges');
                    if($arr_charges != 'failure') {
                        foreach($arr_charges as $charge_data) {
                            $name = $charge_data['name'];
                            $amount = ($charge_data['amount'] > 0) ? $charge_data['amount'] : $charge_data['percentage'];
                            
                            if($name == "CGST") {
                                $CGST = $amount;
                            }
                            if($name == "SGST") {
                                $SGST = $amount;
                            }
                            if($name == "charge_per_km") {
                                $charge_per_km = $amount;
                            }
                        }
                    }
                    $GST = $CGST + $SGST;
                    
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
                    $temp = $misc_model->get_temp_address($json->user_lat,$json->user_long,$json->users_id);
                    
                    if($temp == 'failure'){

                        $data = [
                            'locality' => $json->address,
                            'latitude' => $json->user_lat,
                            'longitude' => $json->user_long,
                            'city_id' => $city_id,
                            'state_id' => $state_id,
                            'country_id' => $country_id,
                            'zipcode_id' => $zip_id,
                            'users_id' => $json->users_id
                        ];
                        
                        $temp_address_id = $common->insert_records_dynamically('user_temp_address', $data);

                     }else{

                        $temp_address_id = $temp['id'];
                     }

                                        
                    
					//User Wallet Balance
					
					$arr_wallet_details = $common->get_details_dynamically('wallet_balance', 'users_id', $json->users_id);
								
								if($arr_wallet_details != 'failure') {
                		            //Get total amount and blocked amount
                		            $wallet_amount = intval($arr_wallet_details[0]['amount']);
                		                           		                            		            
								}else{
									
									$wallet_amount = "0";
								}
					
                    
                    if(empty($json->search_phrase)){

                        //Get Keywords ID by subcat_id
					$keywords_data = $misc_model->get_keyword_by_subcat_id($json->subcat_id);

                    }else{

                    //Get Keywords ID by search string
                    $keywords_data = $misc_model->get_keyword_by_search_string($json->search_phrase); 

                    }

                    // print_r($keywords_data);
                    // exit;                                        
                    
                    $keyword_id = array();
                    $cat_id = array();

                    if($keywords_data != 'failure'){
                        foreach($keywords_data as $key=>$data){
                            if($data['category_id'] != 0){
                               
                                $k = explode(",",$data['id']);
                                foreach($k as $l){
                                    array_push($keyword_id,$l);
                                }
                                $cat_id[$key] = $data['category_id'];
                            }
                        }
                    }
                                        
					$arr_search_result_list = array();
                    

                    foreach ($cat_id as $cat){
                                               
                            $arr_search_result = $misc_model->get_search_results($keyword_id,$city,$json->user_lat,$json->user_long,$json->users_id,$cat);
                            
                            if($cat_id != 'failure' && $arr_search_result != 'failure'){
                              
                                foreach($arr_search_result as $arr_search){
                                    array_push($arr_search_result_list,$arr_search);
                                }
                            }
                                                    
                        }
                    
                    
                    //Check whether any SP is available, if yes process the details
                    // $arr_search_result_list = $misc_model->get_search_results($keyword_id,$city,$json->user_lat,$json->user_long,$json->users_id,$subcat_id);
                    
                    // $arr_search_result_list = $misc_model->get_search_results($keyword_id,$city,$json->user_lat,$json->user_long,$json->users_id);



                    $ar_sp_id = array();
                    $arr_preferred_time_slots = array();
                    $arr_temp = array();
                    $arr_temp_blocked = array();
                    $arr_slots_data = array();
                    $arr_slots_single_data = array();
                    // $arr_search_result = array();
                    $CGST_amount = 0;
					$SGST_amount = 0;
					$arr_sp_key = array();
					$arr_sp_ranking_key = array();
					
                                            
					if(!empty($arr_search_result_list)) {
                        foreach($arr_search_result_list as $key => $search_data) {
                            $arr_search_result[$key]["id"] =  $search_data['id'];
                            $arr_search_result[$key]["present_status"] =  ($search_data['online_status_id'] = 1 ? "Available" : "Busy");
                            $arr_search_result[$key]["users_id"] =  $search_data['users_id'];
                            $arr_search_result[$key]["address"] =  $search_data['address'];
                            $arr_search_result[$key]["city"] =  $search_data['city'];
                            $arr_search_result[$key]["state"] =  $search_data['state'];
                            $arr_search_result[$key]["country"] =  $search_data['country'];
                            $arr_search_result[$key]["postcode"] =  $search_data['postcode'];
                            $arr_search_result[$key]["latitude"] =  $search_data['latitude'];
                            $arr_search_result[$key]["longitude"] =  $search_data['longitude'];
                            $arr_search_result[$key]["created_dts"] =  $search_data['created_dts'];
                            $arr_search_result[$key]["fname"] =  $search_data['fname'];
                            $arr_search_result[$key]["lname"] =  $search_data['lname'];
                            $arr_search_result[$key]["mobile"] =  $search_data['mobile'];
                            $arr_search_result[$key]["dob"] =  $search_data['dob'];
                            $arr_search_result[$key]["gender"] =  $search_data['gender'];
                            $arr_search_result[$key]["profile_pic"] =  $search_data['profile_pic'];
                            $arr_search_result[$key]["reg_status"] =  $search_data['reg_status'];
                            $arr_search_result[$key]["registered_on"] =  $search_data['registered_on'];
                            $arr_search_result[$key]["referral_id"] =  $search_data['referral_id'];
                            $arr_search_result[$key]["points_count"] = $search_data["points_count"];
                            $arr_search_result[$key]["about_me"] =  $search_data['about_me'];
                            $arr_search_result[$key]["qualification"] =  $search_data['qualification'];
                            $arr_search_result[$key]["profession_id"] =  $search_data['profession_id'];
                            $arr_search_result[$key]["profession"] =  $search_data['profession'];
                            $arr_search_result[$key]["exp"] =  $search_data['exp'];
                            $arr_search_result[$key]["languages_known"] =  $search_data['languages_known'];
                            $arr_search_result[$key]["per_hour"] =  $search_data['per_hour'];
                            $arr_search_result[$key]["per_day"] =  $search_data['per_day'];
                            $arr_search_result[$key]["min_charges"] =  $search_data['min_charges'];
                            $arr_search_result[$key]["extra_charge"] =  $search_data['extra_charge'];
                            $arr_search_result[$key]["category_id"] =  $search_data['category_id'];
                            $arr_search_result[$key]["subcategory_id"] =  $search_data['subcategory_id'];
                            $arr_search_result[$key]["fcm_token"] =  $search_data['fcm_token'];
                            $arr_search_result[$key]["distance_miles"] =  strval(round($search_data['distance_miles'],2));
                            $arr_search_result[$key]["distance_kms"] =  strval(round($search_data['distance_miles'] * 1.60934,2)); 
                            $arr_search_result[$key]["SGST_percentage"] = $SGST;
                            $arr_search_result[$key]["CGST_percentage"] = $CGST;
                            
                            $arr_search_result[$key]["rank"] = 0;
    		                $arr_search_result[$key]["rating"] = 0;
    		                $arr_search_result[$key]["total_people"] = 0;
    		                $arr_search_result[$key]["jobs_count"] = 0;
                            
                            $minimum_charges = round($arr_search_result[$key]["min_charges"],2);
                            $amount = 0;
                            $calc_per_km_charge = 0;
                            
                            if($arr_search_result[$key]["category_id"] == 3) { //Multimove
                                //Calculate cost
                                $calc_per_km_charge = $charge_per_km * $arr_search_result[$key]["distance_kms"];
                                
								//$total_charge = $minimum_charges + $calc_per_km_charge; 
								$total_charge = round($minimum_charges < $calc_per_km_charge ? $calc_per_km_charge : $minimum_charges,2);
								
								$CGST_amount = round(($total_charge * $CGST)/100,2);
								$SGST_amount = round(($total_charge * $SGST)/100,2);
								
                                //$gst = ($total_charge * $GST)/100;
                                //$amount = $total_charge + $gst;
								$amount = number_format($total_charge + $CGST_amount + $SGST_amount,2,'.','');
                                if($value_type_id == 2) { // %
            		                $discount = round(($total_charge * $value)/100,2); 
            		            } 
            		            else {
            		               $discount = $value; 
            		            }
                                
                            }
                            else { //Single move/Blue Collar
                                //Calculate cost
                                
                                $CGST_amount = number_format(round(($minimum_charges * $CGST/100),2),2,'.','');
								$CGST_amount = ($CGST_amount < 1 ? "1.00" : $CGST_amount);
								$SGST_amount = number_format(round(($minimum_charges * $SGST/100),2),2,'.','');
								$SGST_amount = ($SGST_amount < 1 ? "1.00" : $SGST_amount);
                                
                                //$gst = ($minimum_charges * $GST)/100;
                                //$amount = $minimum_charges + $gst;
								
								$total_charge = $minimum_charges;
								$amount = number_format($total_charge + $CGST_amount + $SGST_amount,2,'.','');
                                if($value_type_id == 2) { // %
            		                $discount = round(($minimum_charges * $value)/100,2); 
            		            } 
            		            else {
            		               $discount = $value; 
            		            }
                                
                            }
                            $arr_search_result[$key]["minimum_amount"] =  intval($total_charge);
							$arr_search_result[$key]["SGST_amount"] = $SGST_amount;
                            $arr_search_result[$key]["CGST_amount"] = $CGST_amount;
							$arr_search_result[$key]["discount"] =  $discount;
                            $arr_search_result[$key]["final_amount"] =  (($amount > $discount) ? intval($amount - $discount) : 0);
                            
                            
                            $arr_sp_key[$search_data['users_id']] = $key;

                            $ar_sp_id[$search_data['users_id']] = $search_data['users_id'];
                            
                            $arr_sp_ranking_key[$search_data['users_id']] = $search_data['users_id'];
                        }
                        
                        $rank_key = 0;
                        
                        $res = $misc_model->get_sp_search_ranking_details($city_id,$keyword_id);
                		if($res != 'failure') {
                		    foreach($res as $key => $rdata) {
                		        if(isset($arr_sp_key[$rdata['users_id']])) {
                		            $sp_key = $arr_sp_key[$rdata['users_id']];
                		            
                		            $arr_search_result[$sp_key]["points_count"] = $rdata["points_count"];
                		            $arr_search_result[$sp_key]["rank"] = ($key + 1);
                		            $rank_key++;
                		            
                		            unset($arr_sp_ranking_key[$rdata['users_id']]);
                		        }
                		    }
                		}
                		
                		//Assign ranks even though points is 0
                		if(count($arr_sp_ranking_key) > 0) {
                		    foreach($arr_sp_ranking_key as $ruser_id) {
                		        $sp_key = $arr_sp_key[$ruser_id];
                		        
                		        $arr_search_result[$sp_key]["rank"] = ($rank_key + 1);
                		        unset($arr_sp_ranking_key[$ruser_id]);
                		    }
                		}
                        
                        //Get reviews

                        
                		$arr_reviews = $misc_model->get_sp_review_data($ar_sp_id);
                		if($arr_reviews != 'failure') {
                		    foreach($arr_reviews as $rev_data) {
                		        $rating = $rev_data['sum_average_review']/$rev_data['total_people'];
                                                		        
                		        if(isset($arr_sp_key[$rev_data['sp_id']])) {
                		            $sp_key = $arr_sp_key[$rev_data['sp_id']];
                		            
                		            $arr_search_result[$sp_key]["rating"] = number_format($rating,1,'.','')."";
                		            $arr_search_result[$sp_key]["total_people"] = number_format($rev_data['total_people'],1,'.','');
                                    $arr_search_result[$sp_key]["professionalism"] = number_format($rev_data['avg_professionalism'],1,'.','');
                                    $arr_search_result[$sp_key]["skill"] = number_format($rev_data['avg_skill'],1,'.','');
                                    $arr_search_result[$sp_key]["behaviour"] = number_format($rev_data['avg_behaviour'],1,'.','');
                                    $arr_search_result[$sp_key]["satisfaction"] = number_format($rev_data['avg_satisfaction'],1,'.','');

                		        }
                		    }
                		}
                        
                        //Get Sp's keywords
                        $arr_keywords_list = $misc_model->get_sp_keywords($ar_sp_id);
                        if($arr_keywords_list != 'failure') {
                            foreach($arr_keywords_list as $key => $keyword_data) {
                                //Get Sp key 
                                $sp_key = $arr_sp_key[$keyword_data['users_id']];
                                
                                $arr_search_result[$sp_key]["keywords"] = $keyword_data['keywords'];
                            }
                        }
                        
                        //Get SP's preferred day/timeslot data
                        $arr_preferred_time_slots_list = $misc_model->get_sp_preferred_time_slot($ar_sp_id);
                        if($arr_preferred_time_slots_list != 'failure') {
                            $i = 0;
                            foreach($arr_preferred_time_slots_list as $key => $slot_data) {
                                if(!isset($arr_temp[$slot_data['users_id']])) {
                                    $i = 0;
                                }
                                
                                $arr_temp[$slot_data['users_id']][$i]['day_slot'] = $slot_data['day_slot'];
                                $arr_temp[$slot_data['users_id']][$i]['time_slot_from'] = $slot_data['time_slot_from'];
                                $arr_temp[$slot_data['users_id']][$i]['time_slot_to'] = $slot_data['time_slot_to'];
                                $i++;
                            }
                        }
                        
                        //Get SP's blocked data
                        $arr_blocked_time_slots_list = $misc_model->get_sp_blocked_time_slot($ar_sp_id);
                        /*echo "<pre>";
                        print_r($arr_blocked_time_slots_list);
                        echo "</pre>";
                        exit;*/
                        if($arr_blocked_time_slots_list != 'failure') {
                            $j = 0;
                            foreach($arr_blocked_time_slots_list as $key => $blocked_data) {
                                if(!isset($arr_temp_blocked[$blocked_data['users_id']])) {
                                    $j = 0;
                                }
                                
                                $arr_temp_blocked[$blocked_data['users_id']][$j]['time_slot_from'] = $blocked_data['from'];
                                $arr_temp_blocked[$blocked_data['users_id']][$j]['date'] = $blocked_data['date'];
                                $j++;
                            }
                        }
                        
                        //Get SP completed jobs count
                		$arr_completed_jobs = $misc_model->get_sp_jobs_booking_completed($ar_sp_id);
                		if($arr_completed_jobs != 'failure') {
                		    foreach($arr_completed_jobs as $comp_data) {
                		        if(isset($arr_sp_key[$comp_data['sp_id']])) {
                		            $sp_key = $arr_sp_key[$comp_data['sp_id']];
                		            $arr_search_result[$sp_key]["jobs_count"] = $comp_data['jobs_count'];
                		        }
                		    }
                		}
                        
                        if(count($ar_sp_id) > 0) {
                            foreach($ar_sp_id as $sp_id) {
                                if(isset($arr_temp[$sp_id])) {
                                    array_push($arr_slots_data,array("user_id" => $sp_id,"preferred_time_slots" => $arr_temp[$sp_id],
                                                                        "blocked_time_slots" => (isset($arr_temp_blocked[$sp_id])) ? $arr_temp_blocked[$sp_id] : array()));
                                }
                            }
                        }
                        
                        //echo "<pre>";
                        //print_r($arr_temp);
                        //print_r($arr_slots_data);
                        //print_r($arr_temp_blocked);
                        //echo "</pre>";
                        //exit;
                    }
                    
                    
                    //Save to search_results
                    //JSON Objects declared into variables
                    foreach ($keyword_id as $keyword){

                        $data = [
                            'keywords_id' => ($keyword > 0) ? $keyword : 0,
                            'search_query' => ($keyword > 0) ? "" : $keyword,
                            'results_show' => ($arr_search_result != 'failure') ? count($arr_search_result) : 0,
                            'latitude' => $json->user_lat,
                            'longitude' => $json->user_long,
                            'users_id' => $json->users_id,
                            'city' => $city,
                            'state' => $json->state,
                            'country' => $json->country,
                            'postal_code' => $json->postal_code,
                            'address' => $json->address,
                        ];
                        $search_results_id = $common->insert_records_dynamically('search_results', $data);
                    }
                    
                    
                    if ($arr_search_result != 'failure') {
                        return $this->respond([
            				"status" => 200,
            				"message" => "Success",
							"wallet_balance" => $wallet_amount,
            				"data" => $arr_search_result,
            				//"sp_ids" => $ar_sp_id,
            				"slots_data" => $arr_slots_data,
            				"search_results_id" => $search_results_id,
            				"temp_address_id" => $temp_address_id,
            				"charges" => ($arr_charges != 'failure') ? $arr_charges : array()
            			]);
            		} else {
            			return $this->respond([
            				"status" => 200,
            				"data" => array(),
            				"message" => "No Data to Show",
            				"slots_data" => array(),
            				"search_results_id" => $search_results_id,
            				"temp_address_id" => $temp_address_id,
            				"charges" => array()
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

    //-----------------------------------------------SEARCH RESULT ENDS------------------------------------------------------------

    
}
