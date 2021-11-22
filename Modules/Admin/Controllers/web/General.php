<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;

class General extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function categories()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\categories');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function subcategories()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\subcategories');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function keywords()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\keywords');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function languages()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\languages');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function professions()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\professions');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function qualifications()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\qualifications');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function add_category()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\addCategory');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function add_sub_category()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\addSubCategory');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function add_keywords()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\addKeywords');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_subcategory()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\editSubCategory');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_keywords()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\editKeywords');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
