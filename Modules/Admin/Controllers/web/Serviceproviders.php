<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;

class Serviceproviders extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function activate_provider()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\serviceproviders\activateProvider');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function list_providers()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\serviceproviders\listServiceProviders');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_serviceproviders()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\serviceproviders\editServiceProviders');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
