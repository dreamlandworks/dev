<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Admin\Models\CategoriesModel;
use Modules\Admin\Models\SubcategoriesModel;
use Modules\User\Models\keywordModel;
use Modules\User\Models\AddressModel;
use Modules\User\Models\ZipcodeModel;
use Modules\User\Models\CityModel;
use Modules\User\Models\StateModel;
use Modules\User\Models\CountryModel;
use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;
use Modules\User\Models\JobPostModel;

helper('Modules\User\custom');

class MyAccount extends ResourceController
{

	//---------------------------------------------------------My Account Details-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function get_account_details()
	{
		$validate_key = $this->request->getVar('key');
        $users_id = $this->request->getVar('users_id');
        
		if($validate_key == "" || $users_id == "") {
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
		       $job_post_model = new JobPostModel();
		       $misc_model = new MiscModel();
		       $common = new CommonModel();
		       
		       $total_wallet_balance = 0;
		       $total_wallet_blocked = 0;
		       
		       $arr_wallet_details = $common->get_details_dynamically('wallet_balance', 'users_id', $users_id);
		       if($arr_wallet_details != 'failure') {
    	            //Get total amount 
    	            $total_wallet_balance = $arr_wallet_details[0]['amount'];
    	            $total_wallet_blocked = $arr_wallet_details[0]['amount_blocked'];
		       }     
		       
		       //Get total Job Posts,Referrals,Bookings
		       $total_bookings = $misc_model->get_total_bookings($users_id);
		       $total_job_posts = $misc_model->get_total_job_posts($users_id);
		       $total_referrals = $misc_model->get_total_referrals($users_id);

			   //Getting Commissions Earned
			   			 
			   $lm = date('m')-1;
			   $lm_dt = date('Y-'.$lm.'-d');
			   $str_date_lm = date("Y-m-01", strtotime($lm_dt));
			   $end_date_lm = date("Y-m-t", strtotime($lm_dt));
			  

			   $dt = date('Y-m-d');
			   $str_date = date("Y-m-01", strtotime($dt));
			   $end_date = date("Y-m-t", strtotime($dt)); 

			   $commission_earned_this_month = $misc_model->get_commission($users_id,$str_date,$end_date);
			   $commission_earned_last_month = $misc_model->get_commission($users_id,$str_date_lm,$end_date_lm);
			   
			   $commission_earned_this_month = ($commission_earned_this_month != 'failure' ? $commission_earned_this_month : 0);
			   $commission_earned_last_month = ($commission_earned_last_month != 'failure' ? $commission_earned_last_month : 0);
			   $change_in_commission = $commission_earned_last_month - $commission_earned_this_month;

			   $commission_earned = [
				   'this_month' => $commission_earned_this_month, 
				   'prev_month' => $commission_earned_last_month, 
				   'change' => $change_in_commission
				];

		       $res_plan = $misc_model->get_user_plan_details($users_id);
		       
	           return $this->respond([
		            "total_bookings" => $total_bookings,
		            "total_job_posts" => $total_job_posts,
		            "total_referrals" => $total_referrals,
		            "commission_earned" => $commission_earned,
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

    
}
