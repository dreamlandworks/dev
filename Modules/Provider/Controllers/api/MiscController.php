<?php

namespace Modules\Provider\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\CommonModel;


class MiscController extends ResourceController
{

	//------------------------------------------------------GET LIST OF Professions HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the list of Professions
	 * 
	 * This function can be used to get the list of 
	 * Professions for SP.
	 * <code>
	 * get_profession_list();
	 * @param key
	 * </code>
	 */
	public function get_profession_list()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json)) {
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
        		$res = $common->get_table_details_dynamically('list_profession', 'name', 'ASC');
        
        		if ($res != 'failure') {
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
	
	//------------------------------------------------------GET LIST OF Qualification HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the list of Qualifications
	 * 
	 * This function can be used to get the list of 
	 * Qualifications for SP.
	 * 
	 */
	public function get_qualification_list()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json)) {
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
        		$res = $common->get_table_details_dynamically('sp_qual', 'qualification', 'ASC');
        
        		if ($res != 'failure') {
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
	
	//------------------------------------------------------GET LIST OF Experience HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the list of Experience
	 * 
	 * This function can be used to get the list of 
	 * Experience for SP.
	 * <code>
	 * getCat();
	 * </code>
	 */
	public function get_experience_list()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json)) {
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
        		$res = $common->get_table_details_dynamically('sp_exp', 'id', 'ASC');
        
        		if ($res != 'failure') {
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
	
	//------------------------------------------------------GET LIST OF Language HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the list of Language
	 * 
	 * This function can be used to get the list of 
	 * Language for SP.
	 * <code>
	 * getCat();
	 * </code>
	 */
	public function get_language_list()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json)) {
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
        		$res = $common->get_table_details_dynamically('language', 'name', 'ASC');
        
        		if ($res != 'failure') {
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
	
	//------------------------------------------------------GET LIST OF Day slot HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the day slot lits
	 * 
	 * This function can be used to get the list of 
	 * day slots for SP.
	 */
	public function get_day_slot_list()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json)) {
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
        		$res = $common->get_table_details_dynamically('day_slot', 'id', 'ASC');
        
        		if ($res != 'failure') {
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
	
	//------------------------------------------------------GET LIST OF All services HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the list of All
	 * 
	 * This function can be used to get the list of 
	 * All for SP.
	 * <code>
	 * getCat();
	 * </code>
	 */
	public function get_initialization_list()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
		    $apiconfig = new \Config\ApiConfig();
		    
    		$api_key = $apiconfig->provider_key;
    		
    		$res = array();
    		
    		if($key == $api_key) {
    		    $common = new CommonModel();
        		$res['list_profession'] = $common->get_table_details_dynamically('list_profession', 'name', 'ASC');
        		$res['qualification'] = $common->get_table_details_dynamically('sp_qual', 'qualification', 'ASC');
        		$res['experience'] = $common->get_table_details_dynamically('sp_exp', 'id', 'ASC');
        		$res['language'] = $common->get_table_details_dynamically('language', 'name', 'ASC');
        		
        		if ($res != 'failure') {
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
	//---------------------------------------------------------GET LIST of SP Faq HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function sp_faq()
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
		
    		$api_key = $apiconfig->provider_key;
    		
    		if($key == $api_key) {
    		    $common = new CommonModel();
        		$res = $common->get_table_details_dynamically('faq_sp', 'id', 'ASC');
        
        		if ($res != 'failure') {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $res
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Faq to Show"
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
}
