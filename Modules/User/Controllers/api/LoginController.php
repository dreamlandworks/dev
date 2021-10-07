<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\User\Models\UsersModel;
use Modules\User\Models\MiscModel;

class LoginController extends ResourceController
{
	 
	/**
	 * User Login Function
	 * 
	 * Function used to login user using various methods
	 * like google, facebook and Login Form
	 * @param mixed $type @param mixed $username @param mixed $password
	 * @method POST
	 * @return array JSON 200-User Exists|400-User Not Found 
	 */
	public function login()
	{
		$json = $this->request->getJSON();
		
		if(!array_key_exists('type',$json) || !array_key_exists('username',$json) || !array_key_exists('password',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $type = $json->type;
    		$id = $json->username;
    		$pass = $json->password;
    		$key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    
        		$log = new UsersModel();
        		$var = $log->login_user($id, $type, $pass);
        
        		if ($var != null) {
        
        			$upd = new MiscModel();
        			$upd->create_login_activity($var['id']);
        			return $this->respond([
        				"status" => 200,
        				"message" => "User Exists",
        				"user id" => $var['id']
        			]);
        		} else {
        			return $this->respond([
        				"status" => 404,
        				"message" => "User Not Found"
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
	
	/**
	 * User Verification Function
	 * 
	 * Function used to verify user using email and mobile. Email is optional
	 * @param mixed $type @param mixed $email @param mixed $mobile
	 * @method POST
	 * @return array JSON 200-User Exists|400-User Not Found 
	 */
	public function verify()
	{
		$json = $this->request->getJSON();
		
		if(!array_key_exists('mobile',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $mobile = $json->mobile;
    		$email = (array_key_exists('email',$json)) ? $json->email : "";
    		$key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    
        		$users_model = new UsersModel();
        		
        		if($email != "" && $mobile == "") {
        		    $validate_user_email_exist = $users_model->validate_email($email);
        		    if($validate_user_email_exist != 'failure') {
        		        return $this->respond([
            				"status" => 200,
            				"message" => "Email Exists",
            				"user id" => $validate_user_email_exist->id
            			]);
        		    }  
        		    else {
            			return $this->respond([
            				"status" => 404,
            				"message" => "Email Not Found"
            			]);
            		}
        		}
        		else if($mobile != "" && $email == "") {
        		    $validate_user_mobile_exist = $users_model->validate_mobile($mobile);
        		    if($validate_user_mobile_exist != 'failure') {
        		        return $this->respond([
            				"status" => 200,
            				"message" => "Mobile Exists",
            				"user id" => $validate_user_mobile_exist->id
            			]);
        		    }
        		    else {
            			return $this->respond([
            				"status" => 404,
            				"message" => "Mobile Not Found"
            			]);
            		}
        		}
        		else if($mobile != "" && $email != "") {
        		    $email_exists = 0;
        		    $mobile_exists = 0;
        		    $user_id = 0;
        		    
        		    $validate_user_email_exist = $users_model->validate_email($email);
        		    if($validate_user_email_exist != 'failure') {
        		        $email_exists = 1;
        		        $user_id = $validate_user_email_exist->id; 
        		    }
        		    $validate_user_mobile_exist = $users_model->validate_mobile($mobile);
        		    if($validate_user_mobile_exist != 'failure') {
        		        $mobile_exists = 1;
        		        $user_id = $validate_user_mobile_exist->id;
        		    }
        		    
        		    if($email_exists == 1 && $mobile_exists == 1) {
        		        return $this->respond([
            				"status" => 200,
            				"message" => "Email & Mobile Exists",
            				"user id" => $user_id
            			]);
        		    }
        		    else if($email_exists == 1 || $mobile_exists == 1) {
        		        if($email_exists == 1) {
                            return $this->respond([
                				"status" => 200,
                				"message" => "Email Exists",
                				"user id" => $user_id
                			]);
                        }
                        if($mobile_exists == 1) {
                            return $this->respond([
                				"status" => 200,
                				"message" => "Mobile Exists",
                				"user id" => $user_id
                			]);
                        }
        		    }
        		    else {
            			return $this->respond([
            				"status" => 404,
            				"message" => "User Not Found"
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
	
}
