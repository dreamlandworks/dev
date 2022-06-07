<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;
use Modules\Admin\Models\MiscAccountsModel;

class Accounts extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function receipts()
	{
	    $misc_model = new MiscAccountsModel();
		
		$arr_receipts =  $misc_model->showAllReceipts(); 
		$data['arr_receipts'] = $arr_receipts;
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\accounts\receipts',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function receiptsDue()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\accounts\receiptsDue');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function paymentRequests()
	{
	    $misc_model = new MiscAccountsModel();
		
		$arr_paymentrequest =  $misc_model->showAllPaymentRequest(); 
		$data['arr_paymentrequest'] = $arr_paymentrequest;
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\accounts\paymentRequests',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function paymentDone()
	{
	    
	    $misc_model = new MiscAccountsModel();
		
		$arr_paymentdone =  $misc_model->showAllPaymentDone(); 
		$data['arr_paymentdone'] = $arr_paymentdone;
	    
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2');
        echo view('\Modules\Admin\Views\accounts\paymentDone', $data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
