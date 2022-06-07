<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;

use Modules\Admin\Models\MiscModel;
use Modules\Admin\Models\MiscUserPlanModel;
use Modules\Admin\Models\UserPlanModel;

class Userplan extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------
	
	public function user_plans()
	{
	    $misc_model = new MiscUserPlanModel();
	    $arr_userplans  =  $misc_model->showAllUserPlans(); 
		$data['arr_userplans']= $arr_userplans;
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\charges\userPlans',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	
	
	public function add_userplan()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\charges\addUserPlan');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	
	
	
	public function create_userplan_submit()
	{
		
        $name = $this->request->getVar('name');
        $description = $this->request->getVar('description');
        $amount = $this->request->getVar('amount');
        $period = $this->request->getVar('period');
        $posts_per_month = $this->request->getVar('posts_per_month');
        $proposals_per_post = $this->request->getVar('proposals_per_post');
        $premium_tag = $this->request->getVar('premium_tag');
        $customer_support = $this->request->getVar('customer_support');
       
       
        $userPlan = new UserPlanModel();
        $res = $userPlan->add_userplans($name,$amount,$period,$posts_per_month,$proposals_per_post,$premium_tag,$customer_support,$description);
        return redirect('ct/userPlans');
	}
	
	
	public function edit_userplan($id = null)
	{
	    
	    $misc_model = new MiscUserPlanModel();
		
		$data['userplan'] =  $misc_model->getUserplan($id); 
		//echo "<pre>"; print_r($data['category']);exit;
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\charges\editUserPlan',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_userplan_submit()
	{
	    $id = $this->request->getVar('userplan_id');
		//JSON Objects declared into variables
		$name = $this->request->getVar('name');
        $description = $this->request->getVar('description');
        $amount = $this->request->getVar('amount');
        $period = $this->request->getVar('period');
        $posts_per_month = $this->request->getVar('posts_per_month');
        $proposals_per_post = $this->request->getVar('proposals_per_post');
        $premium_tag = $this->request->getVar('premium_tag');
        $customer_support = $this->request->getVar('customer_support');
       
       $data = [
            'name' => $name,
            'description' => $description,
            'amount' => $amount,
            'period' => $period,
            'posts_per_month' => $posts_per_month,
            'proposals_per_post' => $proposals_per_post,
            'premium_tag' => $premium_tag,
            'customer_support' => $customer_support
            ];
        $misc_model = new MiscUserPlanModel();
        
        $res = $misc_model->updateUserplan($id, $data);
        return redirect('ct/userPlans');
	}

    
    public function userplan_delete()
	{
	     $misc_model = new MiscUserPlanModel();
		
        $userplan_id = service('request')->getPost('userplan_id');
        $res = $misc_model->deleteUserplan($userplan_id);
        echo $userplan_id;
    
	}
	
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
