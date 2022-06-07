<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;

use Modules\Admin\Models\MiscModel;
use Modules\Admin\Models\MiscProviderplanModel;
use Modules\Admin\Models\ProviderplanModel;

class Providerplan extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------
	
	public function provider_plans()
	{
	    $misc_model = new MiscProviderplanModel();
	    $arr_providerplan  =  $misc_model->showAllProviderPlans(); 
		$data['arr_providerplan']= $arr_providerplan;
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\charges\providerPlans',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	
	
	public function add_providerplan()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\charges\addProviderPlan');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	
	
	
	public function create_providerplan_submit()
	{
		
        $name = $this->request->getVar('name');
        $description = $this->request->getVar('description');
        $amount = $this->request->getVar('amount');
        $period = $this->request->getVar('period');
        $platform_fee_per_booking = $this->request->getVar('platform_fee_per_booking');
        $bids_per_month = $this->request->getVar('bids_per_month');
        $premium_tag = $this->request->getVar('premium_tag');
        $sealed_bids_per_month = $this->request->getVar('sealed_bids_per_month');
        $customer_support = $this->request->getVar('customer_support');
       
       
        $providerPlan = new ProviderplanModel();
        $res = $providerPlan->add_providerplan($name,$amount,$period,$platform_fee_per_booking,$bids_per_month,$premium_tag,$sealed_bids_per_month,$customer_support);
        return redirect('ct/providerPlans');
	}
	
	
	public function edit_providerplan($id = null)
	{
	    
	    $misc_model = new MiscProviderplanModel();
		
		$data['providerplan'] =  $misc_model->getProviderplans($id); 
		//echo "<pre>"; print_r($data['category']);exit;
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\charges\editProviderPlan', $data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_providerplan_submit()
	{
	    $id = $this->request->getVar('providerplan_id');
		//JSON Objects declared into variables
		$name = $this->request->getVar('name');
        $description = $this->request->getVar('description');
        $amount = $this->request->getVar('amount');
        $period = $this->request->getVar('period');
        $platform_fee_per_booking = $this->request->getVar('platform_fee_per_booking');
        $bids_per_month = $this->request->getVar('bids_per_month');
        $premium_tag = $this->request->getVar('premium_tag');
        $sealed_bids_per_month = $this->request->getVar('sealed_bids_per_month');
        $customer_support = $this->request->getVar('customer_support');
       
       $data = [
            'name' => $name,
            'description' => $description,
            'amount' => $amount,
            'period' => $period,
            'platform_fee_per_booking' => $platform_fee_per_booking,
            'bids_per_month' => $bids_per_month,
            'premium_tag' => $premium_tag,
            'sealed_bids_per_month' => $sealed_bids_per_month,
            'customer_support' => $customer_support
            ];
        $misc_model = new MiscProviderplanModel();
        
        $res = $misc_model->updateProviderPlans($id, $data);
        return redirect('ct/providerPlans');
	}

    
    public function providerplan_delete()
	{
	    $misc_model = new MiscProviderplanModel();
		
        $providerplan_id = service('request')->getPost('providerplan_id');
        $res = $misc_model->deleteProviderPlans($providerplan_id);
        echo $providerplan_id;
    
	}
	
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
