<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;

use Modules\Admin\Models\MiscModel;

class Charges extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function cancellation_charges()
	{
		$misc_model = new MiscModel();
		
		$arr_cancellationCharges =  $misc_model->showAllCancellationCharges(); 
		$data['arr_cancellationCharges'] = $arr_cancellationCharges;
		
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\charges\cancellationCharges',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function user_plans()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\charges\userPlans');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function provider_plans()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\charges\providerPlans');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function add_cancellation_charge()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\charges\addCancellationCharge');
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
	
	public function add_providerplan()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\charges\addProviderPlan');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_cancellation_charge($id = null)
	{
		$misc_model = new MiscModel();		
		$data['cancellationCharges'] =  $misc_model->getCancellationCharges($id); 
		
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\charges\editCancellationCharge', $data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_userplan()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\charges\editUserPlan');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_providerplan()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\charges\editProviderPlan');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function delete_cancellationCharges()
	{
	     $misc_model = new MiscModel();
		
        $cancellationCharges_id = service('request')->getPost('cancellationCharges_id');
        $res = $misc_model->deleteCancellationCharges($cancellationCharges_id);
        echo $cancellationCharges_id;
    
	}	
	
	public function create_cancellationCharge_submit()
	{
		//$session = \Config\Services::session();
		
        //JSON Objects declared into variables
		$data = array();
        $data['cancellationCharges_name'] = $this->request->getVar('cancellationCharges_name');
        $data['cancellationCharges_percentage'] = $this->request->getVar('cancellationCharges_percentage');
		$data['cancellationCharges_amount'] = $this->request->getVar('cancellationCharges_amount');
		$data['cancellationCharges_description'] = $this->request->getVar('cancellationCharges_description');
       
        $misc_model = new MiscModel();       
        $res = $misc_model->add_cancellationCharges($data);
        return redirect('ct/cancellationCharges');
	}
	
	public function edit_cancellationCharge_submit()
	{
		//JSON Objects declared into variables
		$cancellationCharges_id = $this->request->getVar('cancellationCharges_id');
        
        $data = array();
        $data['name'] = $this->request->getVar('cancellationCharges_name');
        $data['percentage'] = $this->request->getVar('cancellationCharges_percentage');
		$data['amount'] = $this->request->getVar('cancellationCharges_amount');
		$data['description'] = $this->request->getVar('cancellationCharges_description');
		
        $misc_model = new MiscModel();
        
        $res = $misc_model->updateCancellationCharges($cancellationCharges_id, $data);
        return redirect('ct/cancellationCharges');
	}

	
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
