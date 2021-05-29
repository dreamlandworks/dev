<?php

namespace Modules\Admin\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Modules\Admin\Models\CategoriesModel;
use Modules\Admin\Models\SubCategoriesModel;
use Modules\Admin\Models\KeywordsModel;

class CategoryController extends ResourceController
{
	function add_category()
	{

		$cat = new CategoriesModel();

		$name = $this->request->getVar('name');
		$file = $this->request->getFile('image');
		$image_name = $file->getName();

		//Process for security to change extension of uploaded file. 
		//If user uploads any file other than image file, validation will not proceed.

		$image = '';

		// (file_exists($file || is_uploaded_file($file))
		if (isset($file) && !empty($file->getPath())) {

			$type = $file->getMimeType();

			if (in_array($type, array(
				"image/jpg", "image/jpeg", "image/gif", "image/png"
			))) {

				if ($file->move("images", date("Y-m-d") . "_" . $image_name)) {

					$image = "/images/" . $image_name;
				} else {
					return $this->respond([
						"status" => 400,
						"message" => "Unable to upload Image"
					]);
				}
			} else {
				return $this->respond([
					"status" => 400,
					"message" => "Please upload valid image file"
				]);
			}

			$res = $cat->add_category($name, $image);

			if ($res == "Success") {
				return $this->respond([
					"status" => 200,
					"message" => "Category Successfully Created"
				]);
			} else {
				return $this->respond([
					"status" => 404,
					"message" => "Failed to create New Category"
				]);
			}
		} else {
			return $this->respond([
				"status" => 404,
				"message" => "Please upload Image"
			]);
		}
	}

	function add_subcat()
	{

		$sub = new SubCategoriesModel();

		$name = $this->request->getVar('name');
		$file = $this->request->getFile('image');
		$cat_id = $this->request->getVar('cat_id');
		$image_name = $file->getName();

		//Process for security to change extension of uploaded file. 
		//If user uploads any file other than image file, validation will not proceed.

		$image = '';

		// (file_exists($file || is_uploaded_file($file))
		if (isset($file) && !empty($file->getPath())) {

			$type = $file->getMimeType();

			if (in_array($type, array(
				"image/jpg", "image/jpeg", "image/gif", "image/png"
			))) {

				if ($file->move("images", date("Y-m-d") . "_" . $image_name)) {

					$image = "/images/" . $image_name;
				} else {
					return $this->respond([
						"status" => 400,
						"message" => "Unable to upload Image"
					]);
				}
			} else {
				return $this->respond([
					"status" => 400,
					"message" => "Please upload valid image file"
				]);
			}

			$res = $sub->add($name, $image, $cat_id);

			if ($res == "Success") {
				return $this->respond([
					"status" => 200,
					"message" => "New Sub Category Successfully Created"
				]);
			} else {
				return $this->respond([
					"status" => 404,
					"message" => "Failed to create New Sub Category"
				]);
			}
		} else {
			return $this->respond([
				"status" => 404,
				"message" => "Please upload Image"
			]);
		}
	}

	function add_keyword()
	{

		$sub = new KeywordsModel();

		$name = $this->request->getVar('keyword');
		$cat_id = $this->request->getVar('subcategories_id');

		$res = $sub->add($name, $cat_id);

		if ($res == "Success") {
			return $this->respond([
				"status" => 200,
				"message" => "New Keyword Successfully Created"
			]);
		} else {
			return $this->respond([
				"status" => 404,
				"message" => "Failed to create Keyword"
			]);
		}
	}
}
