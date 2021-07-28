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
        		$validate_user_result = $users_model->validate_user($email,$mobile);
                //echo "<br> str ".$users_model->getLastQuery();exit;
                
                if($validate_user_result != 'failure') {
                    return $this->respond([
        				"status" => 200,
        				"message" => "User Exists",
        				"user id" => $validate_user_result->id
        			]);
                }
                else {
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
	
}
