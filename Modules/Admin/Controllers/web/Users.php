<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;

class Users extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function create_user()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\users\createNewUser');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function list_users()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\users\listUsers');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_users()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\users\editUsers');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
