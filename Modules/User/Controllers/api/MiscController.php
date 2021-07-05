<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Admin\Models\CategoriesModel;
use Modules\Admin\Models\SubcategoriesModel;

class MiscController extends ResourceController
{

	//------------------------------------------------------GET LIST OF SUB CATEGORIES HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the list of Categories
	 * 
	 * This function can be used to get the list of 
	 * categories.
	 * <code>
	 * getCat();
	 * </code>
	 */
	public function get_sub_by_cat()
	{
		$json = $this->request->getJSON();
		if(!array_key_exists('id',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    $id = $json->id;
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    		    $cat = new SubcategoriesModel();
        		$res = $cat->get_by_cat($id);
        
        		if ($res != null) {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
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


	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------


	//---------------------------------------------------------GET LIST CATEGORIES HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function getCat()
	{
		$validate_key = $this->request->getVar('key');
		if($validate_key == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
    		    $cat = new CategoriesModel();
        		$res = $cat->showAll();
        
        		if ($res != null) {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
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

	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

	
	
	public function getSub()
	{
		$validate_key = $this->request->getVar('key');
		if($validate_key == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->user_key;
    		
    		if($key == $api_key) {
		
        		$cat = new SubcategoriesModel();
        		$res = $cat->showAll();
        
        		if ($res != null) {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
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
