<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Config\Mimes;
//Models required for registration
use Modules\User\Models\ZipcodeModel;
use Modules\User\Models\CityModel;
use Modules\User\Models\StateModel;
use Modules\User\Models\CountryModel;
use Modules\User\Models\AddressModel;
use Modules\User\Models\AlertModel;
use Modules\User\Models\ReferralModel;
use Modules\User\Models\TempUserModel;
use Modules\User\Models\UserDetailsModel;
use Modules\User\Models\UsersModel;
use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;
use Modules\User\Models\SmsTemplateModel;

use function PHPUnit\Framework\isEmpty;

class UsersController extends ResourceController
{

    //-----------------------------------------------NEW USER REGISTRATION STARTS----------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to Create New User
     * 
     * Call to this function will create new user.
     * @param mixed first_name, @param mixed last_name, @param mixed email
     * @param mixed mobile, @param mixed dob, @param mixed facebook_id, @param mixed twitter_id
     * @param mixed google_id, @param mixed password, @param mixed city, @param mixed state, @param mixed referral_id
     * @param string country, @param mixed zip, @param mixed address, @param double latitude, @param double longitude
     * @return [JSON] @var User ID & @var Referral ID
     */
    public function new_user()
    {

        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            
            if(!property_exists($json, 'first_name') || !property_exists($json, 'last_name') || !property_exists($json, 'mobile_no') 
                            || !property_exists($json, 'email_id') || !property_exists($json, 'dob') || !property_exists($json, 'gender')
                            || !property_exists($json, 'facebook_id') || !property_exists($json, 'twitter_id') 
                            || !property_exists($json, 'google_id') || !property_exists($json, 'password') || !property_exists($json, 'city')
                            || !property_exists($json, 'state') || !property_exists($json, 'country') || !property_exists($json, 'postal_code') 
                            || !property_exists($json, 'address') || !property_exists($json, 'user_lat') || !property_exists($json, 'user_long')
                            || !property_exists($json, 'referral_id') || !property_exists($json, 'key')
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
    		        //creating New Models
                    $zip_model = new ZipcodeModel();
                    $city_model = new CityModel();
                    $state_model = new StateModel();
                    $country_model = new CountryModel();
                    $address_model = new AddressModel();
                    $userdetails_model = new UserDetailsModel();
                    $users_model = new UsersModel();
                    $common = new CommonModel();
                
                    //JSON Objects declared into variables
                    $fname = $json->first_name;
                    $lname = $json->last_name;
                    $mobile = $json->mobile_no;
                    $email = $json->email_id;
                    $dob = $json->dob;
                    $gender = $json->gender;
                    $facebook_id = $json->facebook_id;
                    $twitter_id = $json->twitter_id;
                    $google_id = $json->google_id;
                    $password = $json->password;
                    $city = $json->city;
                    $state = $json->state;
                    $country = $json->country;
                    $zip = $json->postal_code;
                    $address = $json->address;
                    $latitude = $json->user_lat;
                    $longitude = $json->user_long;
                    $referral_id = $json->referral_id;
        
                    if (empty($referral_id)) {
                        $referral_id = "NoRef";
                    }else{
						$ref = $common->get_details_dynamically('users','userid',$referral_id);
							if($ref != 'failure'){
								$referral_id = $ref[0]['id'];
							}else{
								$referral_id = "NoRef";
							}
						}
                    
                    $validate_user_result = $users_model->search_by_email_mobile($email,$mobile);
                    //echo "<br> str ".$users_model->getLastQuery();exit;
                    
                    $existing_mobile = "";
                    $existing_email = "";
                    
                    if($validate_user_result != 'failure') {
                        $existing_mobile = $validate_user_result->userid;
                        $existing_email = $validate_user_result->email;
                    }
                    
                    /*echo "<pre>";
                    print_r($validate_user_result);
                    echo "</pre>";*/
                    /*exit;*/
                    //$re = $users_model->search_mobile($mobile);
        
                    if ($existing_mobile != $mobile) {
        
                        if ($existing_email != $email) {
                            $country_id = $country_model->search_by_country($country);
                            if ($country_id == 0) {
                                $country_id = $country_model->create_country($country);
                            }
                            $state_id = $state_model->search_by_state($state);
                            if ($state_id == 0) {
                                $state_id = $state_model->create_state($state, $country_id);
                            }  
                            $city_id = $city_model->search_by_city($city);
                            if ($city_id == 0) {
                                $city_id = $city_model->create_city($city, $state_id);
                            } 
                            $zip_id = $zip_model->search_by_zipcode($zip);
                            if ($zip_id == 0) {
                                $zip_id = $zip_model->create_zip($zip, $city_id);
                            }    
                            
                            //name,flatno,apartment_name,landmark will be added later 
                            //after observing the realtime data from google api
        
                            $data = [
                                'name' => "",
                                'flat' => "",
                                'apartment' => "",
                                'landmark' => "",
                                'locality' => $address,
                                'latitude' => $latitude,
                                'longitude' => $longitude,
                                'city_id' => $city_id,
                                'state_id' => $state_id,
                                'country_id' => $country_id,
                                'zipcode_id' => $zip_id
                                
                            ];
        
                            $address_id = $address_model->create_address($data);
        
                            if (empty($facebook_id)) {
        
                                if (empty($google_id)) {
        
                                    if (empty($twitter_id)) {
                                        $reg_status = 1;
                                    } else {
                                        $reg_status = 4;
                                    }
                                } else {
                                    $reg_status = 2;
                                }
                            } else {
                                $reg_status = 3;
                            }
        
                            $data1 = [
        
                                'fname' => $fname,
                                'lname' => $lname,
                                'mobile' => $mobile,
                                'dob' => $dob,
                                'gender'=>strtolower($gender),
                                'reg_status' => $reg_status,
                            ];
        
                            $users_id = $userdetails_model->create_user_details($data1);
        
                            $data2 = [
                                'mobile' => $mobile,
                                'password' => $password,
                                'email' => $email,
                                'facebook_id' => $facebook_id,
                                'twitter_id' => $twitter_id,
                                'users_id' => $users_id
                            ];
							
        
                            $user_id = $users_model->create_user($data2);
        
                            if ($user_id) {
        
                                $aa = $address_model->update_address_by_id($address_id, ["users_id" => $user_id]);
                                $bb = $this->create_ref($fname, $mobile, $referral_id, $user_id);
                                $cc = $this->delete_temp($mobile);
                                $dd = $userdetails_model->update_user_details($users_id, ['referral_id' => $bb['id']]);
                               
                                //Insert into alert_details table
                		        $arr_alerts = array(
                    		          'type_id' => 4, 
                                      'user_id' => $user_id,
                                      'profile_pic_id' => $user_id,
                                      'description' => 'Thanks for registering with us. Have a good day',
                                      'status' => 2,
                                      'created_on' => date('Y-m-d H:i:s'),
                                      'updated_on' => date('Y-m-d H:i:s')
                                );

                                $ale = $common->insert_records_dynamically('alert_regular_user', $arr_alerts);
                                
								//Insert into wallet balance

								$wal_data = [
								
								 'users_id' => $user_id,
								 'amount' => 0,
								 'amount_blocked' => 0
							
								];

								$wal = $common->insert_records_dynamically('wallet_balance', $wal_data);
								
                                if ($aa != 0 && !is_null($bb) && $cc != 0 && !is_null($dd) && $ale > 0) {
                                    //Send SMS
                                    $sms_model = new SmsTemplateModel();
                                    
                            	 	$data = [
                        				"name" => "reg_thanks",
                        				"mobile" => $mobile,
                        				"dat" => [
                        					"var" => $fname,
                        				]
                        			];
                        			
                        			$sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);
                                    
                                    return $this->respond([
                                        "status" => 200,
                                        "message" => "User Successfully Created",
                                        "user_id" => $user_id,
                                        "referral_id" => $bb['referral_id']
                                    ]);
                                } else {
        
                                    return $this->respond([
                                        "status" => 404,
                                        "message" => "There is problem with address or referral_id"
                                    ]);
                                }
                            }
                        } else {
                            $message = "Email Address Already Exists";
                            return $this->respond([
                                "status" => 409,
                                "message" => $message
                            ]);
                        }
                    } else {
                        $message = "User Already Exists with this Mobile Number";
                        return $this->respond([
                            "status" => 409,
                            "message" => $message
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

    //-----------------------------------------------NEW USER REGISTRATION ENDS------------------------------------------------------------


    //--------------------------------------------------CREATE REFERRAL ID STARTS------------------------------------------------------------

    /**
     * Function to Create Referral ID
     * 
     * @param mixed $fname
     * @param mixed $mobile
     * @param mixed $referred_by
     * @param mixed $user_id
     *  
     * @return [Array] -> Referral ID | Null
     */
    public function create_ref($fname, $mobile, $referred_by, $user_id)
    {
        //output -> referral_id (first four letters of fname + first four numbers of mobile) for uniqueness
        //		 -> referred_by (referral id of person referred)
        // 		 -> User_id for user
        $db = new ReferralModel();
        //$referral_id = substr($fname, 0, 4) . substr($mobile, 0, 4);
        $referral_id = $mobile;
        $data = [
            "referral_id" => $referral_id,
            "referred_by" => $referred_by,
            "user_id" => $user_id
        ];

        if (($res = $db->creat_ref($data)) != 0) {
            return $res;
        } else {
            return null;
        }
    }

    //--------------------------------------------------FUNCTION ENDS ---------------------------------------------------------------------

    //--------------------------------------------------DELETE TEMPORARY USER STARTS HERE ------------------------------------------------- 
    /**
     * Function to delete Temporary Users
     * 
     * Call this function with 'id' deletes temporary users
     * @param string $mobile
     * 
     * @return [Int] -> 0|1
     */
    public function delete_temp($mobile = null)
    {
        $new = new TempUserModel();
        $res = $new->delete_temp($mobile);
        if ($res != 0) {
            return $res;
        } else {
            return 0;
        }
    }


    //--------------------------------------------------FUNCTION ENDS ---------------------------------------------------------------------

    //--------------------------------------------------UPDATE USER PASSWORD STARTS HERE ------------------------------------------------- 


    /**
     * Function to update password
     * 
     * Call to this function to change user password
     * @param int $id, @param mixed $password
     * @method POST
     * @return [JSON]
     */
    public function update_pass()
    {
        $json = $this->request->getJSON();
        if(!property_exists($json, 'id') || !property_exists($json, 'password') || !property_exists($json, 'key')) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $id = $json->id;
    		$pass = $json->password;
    		$key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    
        		$new = new UsersModel();

                $res = $new->update_pass($id, $pass);
               
                if ($res != 0) {
                    $common = new CommonModel();
    		        $date = date('Y-m-s H:i:s');
    		        //Insert into alert_details table
    		        $arr_alerts = array(
                        'type_id' => 4, 
                        'description' => "You have succesfully reset your password on ".$date,
                        'user_id' => $id,
                        'profile_pic_id' => $id,
                        'status' => 2,
                        'created_on' => $date,
                        'updated_on' => $date
                  );

                  $common->insert_records_dynamically('alert_regular_user', $arr_alerts);
                    
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success"
                    ]);
                } else {
                    return $this->respond([
                        "status" => 404,
                        "message" => "Not able to update Password"
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

    //-------------------------------------------------------------FUNCTION ENDS ---------------------------------------------------------


    //---------------------------------------------------------RETRIEVE USER ALERTS HERE ------------------------------------------------- 

    /**
     * Retrieves User Alerts based on ID & TYPE
     * 
     * This function will be used to get alerts based on user id & action type
     * @param int $id = User Id
     * @param int $type = 1|2 => 1 for Non Actionable & 2 for Actionable
     * @return string [JSON] => ID, Alert Type, Description, Created ons
     */
    public function get_alerts()
    {
        $json = $this->request->getJSON();
        if(!property_exists($json, 'id') || !property_exists($json, 'key')) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $id = $json->id;
    		$key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    
        		$alert = new AlertModel();
                
                //Regular Alerts
                $res = $alert->all_alerts($id,1);
        
                if ($res != 'failure') {
                   $alert_regular = $res;
                                  
                } else {
                    $alert_regular = [];
                }

                //Actionable Alerts

                $res1 = $alert->all_alerts($id,2);
                // print_r($res);
                // print_r($res1);
                // exit;
                

                if ($res1 != 'failure') {
                
                    foreach($res1 as $key=>$dat){
                     
                        $alert_action[$key]['id'] = $dat['id'];
                        $alert_action[$key]['type_id'] = $dat['type_id'];
                        $alert_action[$key]['user_id'] = $dat['user_id'];
                        $alert_action[$key]['sp_id'] = $dat['sp_id'];
                        $alert_action[$key]['profile_pic'] = $dat['profile_pic'];
                        $alert_action[$key]['description'] = $dat['description'];
                        $alert_action[$key]['status'] = $dat['status'];
                        $alert_action[$key]['api'] = $dat['api'];
                        $alert_action[$key]['accept_text'] = $dat['accept_text'];
                        $alert_action[$key]['reject_text'] = $dat['reject_text'];
                        $alert_action[$key]['accept_response'] = $dat['accept_response'];
                        $alert_action[$key]['reject_response'] = $dat['reject_response'];
                        $alert_action[$key]['created_on'] = $dat['created_on'];
                        $alert_action[$key]['updated_on'] = $dat['updated_on'];
                        $alert_action[$key]['booking_id'] = $dat['booking_id'];
                        $alert_action[$key]['post_id'] = $dat['post_id'];
                        $alert_action[$key]['reschedule_id'] = $dat['reschedule_id'];
                        $alert_action[$key]['status_code_id'] = $dat['status_code_id'];
                        $alert_action[$key]['req_raised_by_id'] = (is_null($dat['req_raised_by_id']) ? "" : $dat['req_raised_by_id']);
                        $alert_action[$key]['category_id'] = $dat['category_id'];
                        $alert_action[$key]['bid_id'] = (is_null($dat['bid_id']) ? "" : $dat['bid_id']);
                        $alert_action[$key]['bid_user_id'] = (is_null($dat['bid_user_id']) ? "" : $dat['bid_user_id']);
   
                   }
                    // $alert_action = $res1;
               
                } else {
                    $alert_action = [];
                }

                return $this->respond([
                    'status' => 200,
                    'message' => 'Success',
                    'regular' => $alert_regular,
                    'action' =>  $alert_action
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
    //-------------------------------------------------------------FUNCTION ENDS ---------------------------------------------------------


    //---------------------------------------------------------UPDATE ALERTS STATUS HERE ------------------------------------------------- 

    public function update_alert()
    {
        $json = $this->request->getJSON();
        
        if(!property_exists($json, 'id') || !property_exists($json, 'last_alert_id') || !property_exists($json, 'user_type') || !property_exists($json, 'key')) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $id = $json->id;
		    $last_alert_id = $json->last_alert_id;
            $user_type = $json->user_type;

		    $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    
        		$alerts = new AlertModel();

                $res = $alerts->update_alert($id, $user_type,$last_alert_id);
        
                if ($res == "Success") {
                    return $this->respond([
                        "id" => 200,
                        "message" => "Successfully Updated"
                    ]);
                } else {
                    return $this->respond([
                        "id" => 400,
                        "message" => "Failed to Update"
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
