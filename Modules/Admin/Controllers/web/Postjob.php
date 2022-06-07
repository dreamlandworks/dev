<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;

class Postjob extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function new_jobs()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\postjobs\newJobs');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function post_job()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\postjobs\postJob');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function view_newjobs()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\postjobs\viewNewjobs');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
