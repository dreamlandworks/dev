<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function index()
	{
        
		echo view('\Modules\Admin\Views\dashboard');
		
	}
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

    public function login(){
        echo view('\Modules\Admin\Views\loginView');
    }
}
