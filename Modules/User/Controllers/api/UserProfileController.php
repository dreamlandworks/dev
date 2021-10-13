<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\User\Models\UsersModel;
use Modules\User\Models\UserDetailsModel;
use Modules\User\Models\AddressModel;
use Modules\User\Models\ReferralModel;
use Modules\Provider\Models\CommonModel;


helper('Modules\User\custom');

class UserProfileController extends ResourceController
{


    //--------------------------------------------------GET USER DETAILS STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to show user profile details
     * 
     * Call to this function outputs user details
     * @param int $id
     * @return [JSON]
     */
    public function show_user()
    {
        $json = $this->request->getJSON();
        if(!array_key_exists('id',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		
		else{
		///$id = $this->request->getJsonVar('id');
		$id = $json->id;
        $con = new UsersModel();
        $con1 = new UserDetailsModel();
        $con2 = new AddressModel();
        $con3 = new ReferralModel();

        
        //$data = $this->request->getJSON();
        $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		$apiconfig = new \Config\ApiConfig();
		
    	$api_key = $apiconfig->user_key;
    		
    	if($key == $api_key)
    	{
        //Check whether User Exists or Not
        if (($user = $con->search_user($id)) != null) {

            $email = $user['email'];
            $sp_activated = $user['sp_activated'];
            $fcm_token = $user['fcm_token'];

            //Get User Details
            if (($res = $con1->user_details_by_id($id)) != 0) {
                $fname = $res['fname'];
                $lname = $res['lname'];
                $mobile = $res['mobile'];
                $gender = $res['gender'];
                $dob = $res['dob'];
                $profile_pic = $res['profile_pic'];
                $ref_id = $res['referral_id'];
            } else {
                return $this->respond([
                    "status" => 400,
                    "message" => "Failed to Retrieve User Details"
                ]);
            }

            //Get Address Details

            if (($add = $con2->get_by_user_id($id)) != null) {
                $address = $add;
            } else {
                $address = null;
            }

            //Get Referral ID

            if (($ref = $con3->get_details($ref_id)) != null) {
                $referral_id = $ref['referral_id'];
            } else {
                $referral_id = null;
            }

            $array = [
                "fname" => $fname,
                "lname" => $lname,
                "mobile" => $mobile,
                "gender" => $gender,
                "email_id" => $email,
                "dob" => $dob,
                "profile_pic" => $profile_pic,
                "referral_id" => $referral_id,
                "address" => $address,
                "sp_activated" => $sp_activated,
                "fcm_token" => $fcm_token
            ];

            return $this->respond([
                "status" => 200,
                "message" => "Success",
                "data" => $array
            ]);
        }
        else {
    		    return $this->respond([
                    "status" => 400,
                    "message" => "User doesnt exist"
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

    //--------------------------------------------------GET USER DETAILS ENDS------------------------------------------------------------




    //--------------------------------------------------UPDATE USER PROFILE STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to update User Profile
     * 
     * JSON data is passed into this function to update user profile using
     * @method POST with 
     * @param mixed $user_id, @param string $fname, @param string $lname,
     * @param mixed $email, @param mixed $dob, @param string $image [Base64 encoded]  
     * @return [JSON] Success|Fail
     */
    public function update_profile()
    {

        $json = $this->request->getJSON();
        if(!array_key_exists('user_id',$json) || !array_key_exists('fname',$json) || !array_key_exists('lname',$json) || !array_key_exists('email',$json) 
        || !array_key_exists('dob',$json) || !array_key_exists('image',$json) || !array_key_exists('gender',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else{
        $con = new UsersModel();
        $con1 = new UserDetailsModel();

        //$data = $this->request->getJSON();
        $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		$apiconfig = new \Config\ApiConfig();
		
    	$api_key = $apiconfig->user_key;
    		
    	if($key == $api_key)
    	{
    
        $id = $json->user_id;
        $fname = $json->fname;
        $lname = $json->lname;
        $email = $json->email;
        $dob = $json->dob;
        $gender = $json->gender;
        $file = $json->image;
        $image = '';
        if ($file != null) {

            $image = generateImage($file);
            
            $array = [
                "fname" =>  $fname,
                "lname" =>  $lname,
                "dob" =>  $dob,
                "gender" =>  $gender,
                "profile_pic" =>  $image
            ];
            
            $common = new CommonModel();
    		        
	    }else{

            $array = [
                "fname" =>  $fname,
                "lname" =>  $lname,
                "dob" =>  $dob,
                "gender" =>  $gender,
            ];
        }

        if (($res = $con->update_email($id, $email)) != 0) {

            $users_id = $res;

            
            if ($con1->update_user_details($users_id, $array) != null) {
                if($image != "") {
                    //Insert into alert_details table
        	        $arr_alerts = array(
        		          'alert_id' => 4, 
                          'description' => "You have succesfully updated your profile picture",
                          'action' => 1,
                          'created_on' => date("Y-m-d H:i:s"), 
                          'status' => 1,
                          'users_id' => $id,
                    );
                    $common->insert_records_dynamically('alert_details', $arr_alerts);
                }
                
                //Insert into alert_details table
    	        $arr_alerts = array(
    		          'alert_id' => 4, 
                      'description' => "You have succesfully updated your profile",
                      'action' => 1,
                      'created_on' => date("Y-m-d H:i:s"), 
                      'status' => 1,
                      'users_id' => $id,
                );
                $common->insert_records_dynamically('alert_details', $arr_alerts);
                
                
                return $this->respond([
                    "status" => 200,
                    "message" =>  "Successfully Updated"
                ]);
            }
            else {

                return $this->respond([
                    "status" => 400,
                    "message" =>  "Failed to Update"
                ]);
            }
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


//--------------------------------------------------UPDATE USER PROFILE ENDS------------------------------------------------------------


//--------------------------------------------------DELETE USER ADDRESS START------------------------------------------------------------

public function delete_address()
{
    
    $json = $this->request->getJSON();
    if(!array_key_exists('id',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
    else
    {
        $id = $this->request->getJsonVar('id');
        $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		$apiconfig = new \Config\ApiConfig();
		
    	$api_key = $apiconfig->user_key;
    		$con = new AddressModel();
        	if($key == $api_key)
        	{
            
            $id = $json->id;
            if($con->delete_address($id) != 0){
            return $this->respond([
                "status" => 200,
                "message" =>  "Successfully Deleted"
            ]);
           }
            else{
            return $this->respond([
                        "status" => 400,
                        "message" =>  "Failed to delete"
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
//--------------------------------------------------DELETE USER ADDRESS END------------------------------------------------------------