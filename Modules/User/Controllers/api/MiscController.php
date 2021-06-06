<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Admin\Models\CategoriesModel;
use Modules\Admin\Models\SubcategoriesModel;

class MiscController extends ResourceController
{

	//------------------------------------------------------GET LIST OF SUB CATEGORIES HERE ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the list of Categories
	 * 
	 * This function can be used to get the list of 
	 * categories.
	 * <code>
	 * getCat();
	 * </code>
	 */
	public function get_sub_by_cat()
	{
		$id = $this->request->getJsonVar('id');
		$cat = new SubcategoriesModel();
		$res = $cat->get_by_cat($id);

		if ($res != null) {
			return $this->respond([
				"status" => 200,
				"message" => "Success",
				"data" => $res
			]);
		} else {
			return $this->respond([
				"status" => 200,
				"message" => "No Data to Show"
			]);
		}
	}


	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------


	//---------------------------------------------------------GET LIST CATEGORIES HERE -------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function getCat()
	{
		$cat = new CategoriesModel();
		$res = $cat->showAll();

		if ($res != null) {
			return $this->respond([
				"status" => 200,
				"message" => "Success",
				"data" => $res
			]);
		} else {
			return $this->respond([
				"status" => 200,
				"message" => "No Data to Show"
			]);
		}
	}

	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

	
	
	public function getSub()
	{
		$cat = new SubcategoriesModel();
		$res = $cat->showAll();

		if ($res != null) {
			return $this->respond([
				"status" => 200,
				"message" => "Success",
				"data" => $res
			]);
		} else {
			return $this->respond([
				"status" => 200,
				"message" => "No Data to Show"
			]);
		}
	}
}
