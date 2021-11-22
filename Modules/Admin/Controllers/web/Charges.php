<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;

class Charges extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function cancellation_charges()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\charges\cancellationCharges');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function user_plans()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\charges\userPlans');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function provider_plans()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\charges\providerPlans');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function add_cancellation_charge()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\charges\addCancellationCharge');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function add_userplan()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\charges\addUserPlan');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function add_providerplan()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\charges\addProviderPlan');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_cancellation_charge()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\charges\editCancellationCharge');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_userplan()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\charges\editUserPlan');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_userplan()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\charges\editProviderPlan');
		echo view('\Modules\Admin\Views\_layout\footer');
	}

	
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
