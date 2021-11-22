<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;

class Blogs extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function view_posts()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\blogs\viewPosts');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function create_newpost()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\blogs\createNewPost');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
