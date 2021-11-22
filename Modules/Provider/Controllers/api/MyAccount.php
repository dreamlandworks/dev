<?php

namespace Modules\Provider\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;
use Modules\User\Models\JobPostModel;

helper('Modules\User\custom');

class MyAccount extends ResourceController
{

	//---------------------------------------------------------My Account Details-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_sp_account_details()
	{
		$validate_key = $this->request->getVar('key');
        $sp_id = $this->request->getVar('sp_id');
        
		if($validate_key == "" || $sp_id == "") {
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
		       $job_post_model = new JobPostModel();
		       $misc_model = new MiscModel();
		       $common = new CommonModel();
		       
		       $total_wallet_balance = 0;
		       $total_wallet_blocked = 0;
		       
		       $arr_wallet_details = $common->get_details_dynamically('wallet_balance', 'users_id', $sp_id);
		       if($arr_wallet_details != 'failure') {
    	            //Get total amount 
    	            $total_wallet_balance = $arr_wallet_details[0]['amount'] - $arr_wallet_details[0]['amount_blocked'];
    	            $total_wallet_blocked = $arr_wallet_details[0]['amount_blocked'];
		       } 
		       
		       $total_bookings = 0;
		       $total_completed_bookings = 0;
		       $total_bids = 0;
		       $total_completed_bids = 0;
		       
		       $arr_bookings_list = $misc_model->get_total_sp_bookings($sp_id);
		       if($arr_bookings_list != 'failure') {
		           foreach($arr_bookings_list as $booking_data) {
		               $total_bookings += 1;
		               if($booking_data['status_id'] == 23) { //Completed status_id = 23; 
		                   $total_completed_bookings += 1;
		               }
		           }
		       }
		       
		       $arr_bids_list = $job_post_model->get_job_post_bids_report_by_sp_id($sp_id);
		       if($arr_bids_list != 'failure') {
		           foreach($arr_bids_list as $bids_data) {
		               $total_bids += 1;
		               if($bids_data['status_id'] == 23) { //Completed status_id = 23; 
		                   $total_completed_bids += 1;
		               }
		           }
		       }
		       
		       //Get total Referrals,commission_earned,total reviews
		       $total_referrals = $misc_model->get_total_referrals($sp_id);
		       $commission_earned = array('this_month' => 0, 'prev_month' => 0, 'change' => 0);
		       $total_reviews = $misc_model->get_sp_reviews_list($sp_id);
		       $res_plan = $misc_model->get_sp_plan_details($sp_id);
		       
	           return $this->respond([
		            "total_completed_bookings" => $total_completed_bookings,
		            "total_bookings" => $total_bookings,
		            "total_bids" => $total_bids,
		            "total_completed_bids" => $total_completed_bids,
		            "total_referrals" => $total_referrals,
		            "commission_earned" => $commission_earned,
		            "total_reviews" => $total_reviews,
		            "wallet_balance" => $total_wallet_balance,
		            "wallet_blocked_amount" => $total_wallet_blocked,
		            "activated_plan" => ($res_plan != 'failure') ? $res_plan['name'] : "Regular",
		            "status" => 200,
    				"message" => "Success",
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
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    //---------------------------------------------------------Review Details-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_sp_review_details()
	{
		$validate_key = $this->request->getVar('key');
        $sp_id = $this->request->getVar('sp_id');
        
		if($validate_key == "" || $sp_id == "") {
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
		       $job_post_model = new JobPostModel();
		       $misc_model = new MiscModel();
		       
		       //Get Reviews Details
		       $arr_reviews = $misc_model->get_sp_reviews_details($sp_id);
		       
	           return $this->respond([
		            "sp_reviews" => ($arr_reviews != 'failure') ? $arr_reviews : array(),
		            "status" => 200,
    				"message" => "Success",
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
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
    
}
