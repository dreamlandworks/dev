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
            
            if(!array_key_exists('first_name',$json) || !array_key_exists('last_name',$json) || !array_key_exists('mobile_no',$json) 
                            || !array_key_exists('email_id',$json) || !array_key_exists('dob',$json) || !array_key_exists('gender',$json)
                            || !array_key_exists('facebook_id',$json) || !array_key_exists('twitter_id',$json) 
                            || !array_key_exists('google_id',$json) || !array_key_exists('password',$json) || !array_key_exists('city',$json)
                            || !array_key_exists('state',$json) || !array_key_exists('country',$json) || !array_key_exists('postal_code',$json) 
                            || !array_key_exists('address',$json) || !array_key_exists('user_lat',$json) || !array_key_exists('user_long',$json)
                            || !array_key_exists('referral_id',$json) || !array_key_exists('key',$json)
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
                    $alert_model = new AlertModel();
                
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
                                $ale = $alert_model->create_record([
                                    "alert_id" => 4,
                                    "sub_id" => 1,
                                    "users_id" => $user_id
                                ]);
        
                                if ($aa != 0 && $bb != null && $cc != 0 && $dd != null && $ale != null) {
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
        if(!array_key_exists('id',$json) || !array_key_exists('password',$json) || !array_key_exists('key',$json)) {
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
    		        
    		        //Insert into alert_details table
    		        $arr_alerts = array(
        		          'alert_id' => 4, 
                          'description' => "You have successfully reset your password",
                          'action' => 1,
                          'created_on' => date("Y-m-d H:i:s"), 
                          'status' => 1,
                          'users_id' => $id,
                    );
                    $common->insert_records_dynamically('alert_details', $arr_alerts);
                    
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
        if(!array_key_exists('id',$json) || !array_key_exists('type',$json) || !array_key_exists('status',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $id = $json->id;
    		$type = $json->type;
    		$status = $json->status;
    		$key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    
        		$alert = new AlertModel();
                
                $res = $alert->all_alerts($id, $type,$status);
        
                if ($res != null) {
                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $res
                    ]);
                } else {
                    return $this->respond([
                        "status" => 404,
                        "message" => "No Data to show"
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


    //---------------------------------------------------------UPDATE ALERTS STATUS HERE ------------------------------------------------- 

    public function update_alert()
    {
        $json = $this->request->getJSON();
        
        if(!array_key_exists('id',$json) || !array_key_exists('type',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $id = $json->id;
		    $type = $json->type;
		    $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    
        		$alerts = new AlertModel();

                $date = date('Y-m-d H:m:s', time());
                $res = $alerts->update_alert($id, $date,$type);
        
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
