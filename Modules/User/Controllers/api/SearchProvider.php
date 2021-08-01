<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Config\Mimes;
//Models required for registration
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
            
            if(!array_key_exists('keyword_id',$json) || !array_key_exists('city',$json) 
                || !array_key_exists('state',$json) || !array_key_exists('country',$json) || !array_key_exists('postal_code',$json) 
                || !array_key_exists('address',$json) || !array_key_exists('user_lat',$json) || !array_key_exists('user_long',$json)
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
    		        
                    //JSON Objects declared into variables
                    $keyword_id = $json->keyword_id ;
                    $city = $json->city;
                    $latitude = $json->user_lat;
                    $longitude = $json->user_long;
                    $users_id= $json->users_id;
                    
                    $misc_model = new MiscModel();
        
                    //Check whether any SP is available, if yes process the details
                    $arr_search_result = $misc_model->get_search_results($keyword_id,$city);
                    
                    if ($arr_search_result != 'failure') {
            			return $this->respond([
            				"status" => 200,
            				"message" => "Success",
            				"data" => $arr_search_result
            			]);
            		} else {
            			return $this->respond([
            				"status" => 200,
            				"message" => "No Data to Show"
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
        
        if(!array_key_exists('id',$json) || !array_key_exists('key',$json)) {
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
    
        		$alerts = new AlertModel();

                $date = date('Y-m-d H:m:s', time());
                $res = $alerts->update_alert($id, $date);
        
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
