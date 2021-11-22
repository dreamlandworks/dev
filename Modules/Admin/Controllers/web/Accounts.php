<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;

class Accounts extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function receipts()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\accounts\receipts');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function receiptsDue()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\accounts\receiptsDue');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function paymentRequests()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\accounts\paymentRequests');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function paymentDone()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\accounts\paymentDone');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
