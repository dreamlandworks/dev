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
            
            
            if(!array_key_exists('search_phrase_id',$json) || !array_key_exists('city',$json) //keyword_id == search_phrase_id
                || !array_key_exists('state',$json) || !array_key_exists('country',$json) || !array_key_exists('postal_code',$json) 
                || !array_key_exists('address',$json) || !array_key_exists('user_lat',$json) || !array_key_exists('user_long',$json) 
                || !array_key_exists('subcat_id',$json) || !array_key_exists('offer_id',$json) || !array_key_exists('users_id',$json) || !array_key_exists('key',$json)
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
    		        
                    //JSON Objects declared into variables
                    $search_phrase_id = $json->search_phrase_id; //SEarch_phrase is sent from app instead of keyword
                    $subcat_id = $json->subcat_id;
                    $keyword_id = 0;
                    //echo "<br> search_phrase_id  ".$search_phrase_id;
                    if($search_phrase_id != "0") {
                        //echo "<br> here  ".$search_phrase_id;exit;
                        //Fetch keyword_id
                        $keyword_id = $misc_model->get_keywords_id($search_phrase_id,$subcat_id);
                    }
                    //echo "<br> keyword_id  ".$keyword_id;
                    //exit;
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
                    
                    //Check whether any SP is available, if yes process the details
                    $arr_search_result_list = $misc_model->get_search_results($keyword_id,$city,$json->user_lat,$json->user_long,$subcat_id);
                    $ar_sp_id = array();
                    $arr_preferred_time_slots = array();
                    $arr_temp = array();
                    $arr_temp_blocked = array();
                    $arr_slots_data = array();
                    $arr_slots_single_data = array();
                    $arr_search_result = array();
                    $CGST_amount = 0;
					$SGST_amount = 0;
					$arr_sp_key = array();
                    
                    if($arr_search_result_list != 'failure') {
                        foreach($arr_search_result_list as $key => $search_data) {
                            $arr_search_result[$key]["id"] =  $search_data['id'];
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
                            $arr_search_result[$key]["distance_miles"] =  round($search_data['distance_miles'],2);
                            $arr_search_result[$key]["distance_kms"] =  round($search_data['distance_miles'] * 1.60934,2);
                            $arr_search_result[$key]["SGST_percentage"] = $SGST;
                            $arr_search_result[$key]["CGST_percentage"] = $CGST;
                            
                            $minimum_charges = round($arr_search_result[$key]["min_charges"],2);
                            $amount = 0;
                            $calc_per_km_charge = 0;
                            
                            if($arr_search_result[$key]["category_id"] == 3) { //Multimove
                                //Calculate cost
                                $calc_per_km_charge = $charge_per_km * $arr_search_result[$key]["distance_kms"];
                                
								//$total_charge = $minimum_charges + $calc_per_km_charge;
								$total_charge = $minimum_charges < $calc_per_km_charge ? $calc_per_km_charge : $minimum_charges;
								
								$CGST_amount = ($total_charge * $CGST)/100;
								$SGST_amount = ($total_charge * $SGST)/100;
								
                                $gst = ($total_charge * $GST)/100;
                                $amount = $total_charge + $gst;
                                if($value_type_id == 2) { // %
            		                $discount = ($total_charge * $value)/100; 
            		            } 
            		            else {
            		               $discount = $value; 
            		            }
                                
                            }
                            else { //Single move/Blue Collar
                                //Calculate cost
                                
                                $CGST_amount = ($minimum_charges * $CGST)/100;
								$SGST_amount = ($minimum_charges * $SGST)/100;
                                
                                $gst = ($minimum_charges * $GST)/100;
                                $amount = $minimum_charges + $gst;
                                if($value_type_id == 2) { // %
            		                $discount = ($minimum_charges * $value)/100; 
            		            } 
            		            else {
            		               $discount = $value; 
            		            }
                                
                            }
                            $arr_search_result[$key]["actual_amount"] =  $amount;
                            $arr_search_result[$key]["discount"] =  $discount;
                            $arr_search_result[$key]["final_amount"] =  ($amount > $discount) ? $amount - $discount : 0;
                            $arr_search_result[$key]["SGST_amount"] = $SGST_amount;
                            $arr_search_result[$key]["CGST_amount"] = $CGST_amount;
                            
                            $arr_sp_key[$search_data['users_id']] = $key;

                            $ar_sp_id[$search_data['users_id']] = $search_data['users_id'];
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
                                if(!array_key_exists($slot_data['users_id'],$arr_temp)) {
                                    $i = 0;
                                }
                                
                                $arr_temp[$slot_data['users_id']][$i]['day_slot'] = $slot_data['day_slot'];
                                $arr_temp[$slot_data['users_id']][$i]['time_slot_from'] = $slot_data['time_slot_from'];
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
                                if(!array_key_exists($blocked_data['users_id'],$arr_temp_blocked)) {
                                    $j = 0;
                                }
                                
                                $arr_temp_blocked[$blocked_data['users_id']][$j]['time_slot_from'] = $blocked_data['from'];
                                $arr_temp_blocked[$blocked_data['users_id']][$j]['date'] = $blocked_data['date'];
                                $j++;
                            }
                        }
                        
                        if(count($ar_sp_id) > 0) {
                            foreach($ar_sp_id as $sp_id) {
                                if(array_key_exists($sp_id,$arr_temp)) {
                                    array_push($arr_slots_data,array("user_id" => $sp_id,"preferred_time_slots" => $arr_temp[$sp_id],
                                                                        "blocked_time_slots" => (array_key_exists($sp_id,$arr_temp_blocked)) ? $arr_temp_blocked[$sp_id] : array()));
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
                    $data = [
                        'keywords_id' => ($keyword_id > 0) ? $keyword_id : 0,
                        'search_query' => ($keyword_id > 0) ? "" : $keyword_id,
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
                    
                    if ($arr_search_result != 'failure') {
                        return $this->respond([
            				"status" => 200,
            				"message" => "Success",
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
