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
		       
		       //Get total Job Posts,Referrals,Bookings
		       $total_bookings = $misc_model->get_total_bookings($users_id);
		       $total_job_posts = $misc_model->get_total_job_posts($users_id);
		       $total_referrals = $misc_model->get_total_referrals($users_id);
		       $commission_earned = array('this_month' => 0, 'prev_month' => 0, 'change' => 0);
		       $res_plan = $misc_model->get_user_plan_details($users_id);
		       
	           return $this->respond([
		            "total_bookings" => $total_bookings,
		            "total_job_posts" => $total_job_posts,
		            "total_referrals" => $total_referrals,
		            "commission_earned" => $commission_earned,
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
