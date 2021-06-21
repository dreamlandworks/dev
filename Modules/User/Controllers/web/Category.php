<?php

namespace Modules\User\Controllers\web;

use App\Controllers\BaseController;
use Modules\Admin\Models\SubcategoriesModel;

class Category extends BaseController
{
	public function index()
	{

		$single = $this->get_sub_by_cat(1);
		$blue = $this->get_sub_by_cat(2);
		$multi = $this->get_sub_by_cat(3);


		return view('Modules\User\Views\categories',[
			'single' => $single,
			'blue' => $blue,
			'multi' => $multi
		]);
	}


	/**
	 * Call this Function to get Sub Categories by Category ID
	 * 
	 * @param int $id [category ID]
	 * @method GET
	 * @return array [Sub Categories Data]
	 */
	public function get_sub_by_cat($id=null)
	{
		$cat = new SubcategoriesModel();
		$res = $cat->get_by_cat($id);

		if ($res != null) {
			return $res;
		} else {
			return null;
		}
	}
}
