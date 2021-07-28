<?php

namespace Modules\Admin\Controllers\api;

use CodeIgniter\RESTful\ResourceController;

use Modules\Admin\Models\CategoriesModel;
use Modules\Admin\Models\SubcategoriesModel;
use Modules\Admin\Models\KeywordsModel;

helper('Modules\User\custom');


class CategoryController extends ResourceController
{


	//------------------------------------------- CATEGORY PART START ---------------------------------------------------------------------

	/**
	 * Add New Category
	 * 
	 * This function is Create New categories.
	 * <code>
	 * 	add_category($category,$image)
	 * </code>
	 * @param name = "Category Name" & @param image = Image File
	 * @return JSON
	 * 
	 */
	public function add_category()
	{ 
        $json = $this->request->getJSON();
		if(!array_key_exists('name',$json) || !array_key_exists('image',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($json->key); //JXQ3txpXH34txjLfwnpnrVAF78zZEH27
		    $name = $json->name;
		    $file = $json->image;
            $image = '';
            
            $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->admin_key;
    		
    		if($key == $api_key) {
    		    if ($file != null) {
                    $image = generateDynamicImage("images/categories",$file);
                }
                
                $cat = new CategoriesModel();
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
        	}
    		else {
    		    return $this->respond([
        				'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
        			]);
    		}
		}
	}

	/**
	 * Show All Categories
	 * 
	 * This function is used to display all the categories.
	 * <code>
	 * 	showCat()
	 * </code>
	 * 
	 * @return JSON
	 * 
	 */
	public function showCat()
	{
        $json = $this->request->getJSON();
		if(!array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    
		    $key = md5($json->key); //JXQ3txpXH34txjLfwnpnrVAF78zZEH27
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->admin_key;
    
        if($key == $api_key) {
    		$cat = new CategoriesModel();
    		$res = $cat->showAll();
    
    		return $this->respond([
    			"status" => 200,
    			"message" => "Success",
    			"data" => $res
    		]);
        }
        
        else {
    		    return $this->respond([
        				'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
        			]);
    		}
		}
}
	/**
	 * Update Categories
	 * 
	 * Function takes @param 'Category ID" as 'id', 'Category Name' as 'name' /'image'
	 * @return "Success" or "Failure".
	 * @method 'POST' 
	 * 
	 */
	public function updateCat()
	{
        $json = $this->request->getJSON();
		if(!array_key_exists('id',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($json->key); //JXQ3txpXH34txjLfwnpnrVAF78zZEH27
		    $id = $json->id;
		    $name = "";
		    $file = "";
            $image = '';
            
            $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->admin_key;
    		
    		if($key == $api_key) {
    		    if (array_key_exists('image',$json)) {
                    $file = $json->image;
                }
                if (array_key_exists('name',$json)) {
                    $name = $json->name;
                }
            
    		    $cat = new CategoriesModel();
    		    $category =$cat->search($id);
    		  //  $existing_image = $category['image'];
    		  //  $path=$_SERVER['SERVER_NAME'];
    		  //  $path = $path.$existing_image;
    		  //  unlink('dev.satrango.com/images/categories/2021071460eef2ac8d288.png');
    		  //  exit;
    		    if ($category != null) {
    		       
    		        if ($file != null) {
                        $image = generateDynamicImage("images/categories",$file);
                    }
                    
                    if ($image == null && $name != null) {
                        $array = [
        					"category" => $name
        				];
        			} elseif ($name == null && $image != null) {
        				$array = [
        					"image" => $image
        				];
        			} elseif ($image != null && $name !== null) {
        				$array = [
        					"category" => $name,
        					"image" => $image
        				];
        			}
    
    			    $res = $cat->update_cat($id, $array);
            
        			if ($res == "Succesfully Updated") {
                        return $this->respond([
        					"status" => 200,
        					"message" => $res
        				]);
        			} else {
        				return $this->respond([
        					"status" => 400,
        					"message" => $res
        				]);
        			}
    		    }
    		    else {
    		        return $this->respond([
        				"status" => 404,
        				"message" => "Category Not Found"
        			]);
    		    }
        	}
    		else {
    		    return $this->respond([
        				'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
        			]);
    		}
		}
	}

	/**
	 * Delete Categories
	 * 
	 * Function takes @param 'Category ID" as 'id'
	 * @return [JSON] value is "Success" or "Failure".
	 * @method 'POST' 
	 * 
	 * 
	 */

	public function deleteCat()
	{
	    $json = $this->request->getJSON();
		if(!array_key_exists('id',$json) || !array_key_exists('key',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    
		    $key = md5($json->key); //JXQ3txpXH34txjLfwnpnrVAF78zZEH27
		    
		    $apiconfig = new \Config\ApiConfig();
		
    		$api_key = $apiconfig->admin_key;
            if($key == $api_key) {
            $id = $json->id;
		    $cat = new CategoriesModel();
		    $subcat = new SubcategoriesModel();
		    
		    //$id = $this->request->getVar('id');
            
    		if ($cat->search($id) != null) {
                if ($subcat->search_catid($id) != null) {
                if (($res = $subcat->delete_by_cat($id)) == "Successfully Sub category Deleted") {
                    if (($res = $cat->delete_cat($id)) == "Successfully category Deleted") {
    				return $this->respond([
    					"status" => 200,
    					"message" => $res
    				]);
    			} else {
    				return $this->respond([
    					"status" => 400,
    					"message" => $res
    				]);
    			}
    			
    		} 
    		}
    		else {
                if (($res = $cat->delete_cat($id)) == "Successfully category Deleted") {
    			return $this->respond([
    					"status" => 200,
    					"message" => $res
    			]);
    		    }
    			
            }
    		}
            else {
    
    			return $this->respond([
    				"status" => 400,
    				"message" => "No Category Found with this ID"
    			]);
    		}
            }
        else {
    		    return $this->respond([
        				'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
        			]);
    		}
		}
	}


	//------------------------------------------- CATEGORY PART END ---------------------------------------------------------------------
	//--------------------------------------------*****************----------------------------------------------------------------------



	//------------------------------------------- SUB-CATEGORY PART START ---------------------------------------------------------------------
	/**
	 * Add New Sub Category
	 * 
	 * This function is Create New categories.
	 * <code>
	 * 	add_category($category,$image)
	 * </code>
	 * @param name = "Category Name" & @param image = Image File & @param cat_id = Category ID
	 * @return JSON
	 * 
	 */

	function add_subcat()
	{

		$cat = new CategoriesModel();
		$sub = new subcategoriesModel();

		$name = $this->request->getVar('name');
		$file = $this->request->getFile('image');
		$cat_id = $this->request->getVar('cat_id');
		$image_name = $file->getName();

		if ($cat->search($cat_id) != null) {
			if ($sub->search_by_name($name) == null) {

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

							$image = "/images/" . date("Y-m-d") . "_" . $image_name;
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
			} else {

				return $this->respond([
					"status" => 406,
					"message" => "Sub Category Exists with this Name"
				]);
			}
		} else {
			return $this->respond([
				"status" => 404,
				"message" => "No Category Exists with this ID"
			]);
		}
	}

	/**
	 * Function to show all sub categories
	 * 
	 * @param No Params needed
	 * @return [JSON]
	 */
	public function showSubCat()
	{
		$sub = new SubCategoriesModel();
		if (($res = $sub->showAll()) != null) {

			return $this->respond([
				"status" => 200,
				"message" => "Success",
				"data" => $res
			]);
		} else {

			return $this->respond([
				"status" => 404,
				"message" => "No Data Found",
				"data" => $res
			]);
		}
	}


	/**
	 * Function to update sub categories
	 * 
	 * Call this function to update any subcategory
	 * @param 'SubCategory ID" as 'id'
	 * @param 'Sub-name" as 'name'
	 * @param 'Image' as 'image'
	 * @param 'Category_id' as 'cat_id'
	 * @return [JSON]
	 */
	public function updateSubCat()
	{
		$sub = new SubCategoriesModel();
		$cat = new CategoriesModel();

		$id = $this->request->getVar('id');
		$cat_id = $this->request->getVar('cat_id');

		if (($sub->search($id) != null)) {

			$name = $this->request->getVar('name');
			$file = $this->request->getFile('image');
			$image_name = $file->getName();
			$cat_id = $this->request->getVar('cat_id');

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

						$image = "/images/" . date("Y-m-d") . "_" . $image_name;
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
			}

			if ($name != null) {
				if ($image != null) {
					if ($cat_id != null) {
						if ($cat->search($cat_id) != null) {
							$array = ["sub_name" => $name, 'image' => $image, "category_id" => $cat_id];
						} else {
							return $this->respond([
								"status" => 404,
								"message" => "No Category Found with this ID"
							]);
						}
					} else {
						$array = ["sub_name" => $name, 'image' => $image];
					}
				} else {
					if ($cat_id != null) {
						if ($cat->search($cat_id) != null) {
							$array = ["sub_name" => $name, "category_id" => $cat_id];
						} else {
							return $this->respond([
								"status" => 404,
								"message" => "No Category Found with this ID"
							]);
						}
					}
				}
			} else {

				if ($image != null) {
					if ($cat_id != null) {
						if ($cat->search($cat_id) != null) {
							$array = ['image' => $image, "category_id" => $cat_id];
						} else {
							return $this->respond([
								"status" => 404,
								"message" => "No Category Found with this ID"
							]);
						}
					} else {
						$array = ['image' => $image];
					}
				} else {
					if ($cat_id != null) {
						if ($cat->search($cat_id) != null) {
							$array = ["category_id" => $cat_id];
						} else {
							return $this->respond([
								"status" => 404,
								"message" => "No Category Found with this ID"
							]);
						}
					}
				}
			}


			$res = $sub->update_sub($id, $array);

			if ($res == "Success") {
				return $this->respond([
					"status" => 200,
					"message" => "Successfully Updated"
				]);
			} else {

				return $this->respond([
					"status" => 400,
					"message" => "Failed to Update"
				]);
			}
		} else {
			return $this->respond([
				"status" => 404,
				"message" => "Sub Category not found with ID"
			]);
		}
	}

	/**
	 * Function to delete Sub Category by ID
	 * 
	 * @param id
	 * @method Get
	 * @return [JSON]
	 */
	public function deleteSubCat()
	{
		$sub = new SubcategoriesModel();
		$id = $this->request->getVar('id');

		if (($res = $sub->delete_sub($id)) == "Success") {
			return $this->respond([
				"status" => 200,
				"message" => "Successfully Deleted"
			]);
		} else {
			return $this->respond([
				"status" => 400,
				"message" => $res
			]);
		}
	}

	//------------------------------------------- SUB-CATEGORY PART END ---------------------------------------------------------------------
	//--------------------------------------------*****************----------------------------------------------------------------------


	//------------------------------------------- KEYWORD PART START ---------------------------------------------------------------------

	/**
	 * Function to Add New Keyword for Subcategories
	 * 
	 * <code>
	 * 	add_keyword($keyword,$subcategories_id)
	 * </code>
	 * @param keyword and @param subcategories_id
	 * @method POST
	 * @return [JSON]
	 * 
	 */
	function add_keyword()
	{

		$sub = new KeywordsModel();
		$cat = new SubcategoriesModel();

		$name = $this->request->getVar('keyword');
		$cat_id = $this->request->getVar('subcategories_id');

		if ($cat->search($cat_id) != null) {

			if ($sub->search_by_name($name) == null) {

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
			} else {
				return $this->respond([
					"status" => 406,
					"message" => "Keyword Already Exists"
				]);
			}
		} else {
			return $this->respond([
				"status" => 404,
				"message" => "No SubCategory Exists with this ID"
			]);
		}
	}


	/**
	 * Function to Show Keywords
	 * 
	 * This function is used to show keywords from DB
	 * @param Nothing
	 * @method GET
	 * @return [JSON]
	 *  
	 */
	public function showKey()
	{
		$key = new KeywordsModel();
		if (($res = $key->showAll()) != null) {

			return $this->respond([
				"status" => 200,
				"message" => "Success",
				"data" => $res
			]);
		} else {

			return $this->respond([
				"status" => 404,
				"message" => "No Data Found",
				"data" => $res
			]);
		}
	}

	/**
	 * Function to Update Keywords
	 * 
	 * This function is used to update any keywords
	 * @param keyword @param subcategory_id
	 * @param id required
	 * @method POST
	 * @return [type]
	 */
	public function updateKey()
	{
		$key = new KeywordsModel();
		$sub = new SubcategoriesModel();

		$id = $this->request->getVar('id');
		$keyword = $this->request->getVar('keyword');
		$sub_id = $this->request->getVar('subcategory_id');

		if ($key->search($id) != null) {


			if ($sub_id != null) {
				if ($sub->search($sub_id) != null) {
					$array = ["subcategories_id" => $sub_id];

					if ($keyword != null) {
						$array = [
							"subcategories_id" => $sub_id,
							"keyword" => $keyword
						];
					}
				} else {
					return $this->respond([
						"status" => 404,
						"message" => "No Sub Category Found with Provided ID"
					]);
				}
			} elseif ($keyword != null) {
				$array = [
					"keyword" => $keyword
				];
			} elseif ($keyword == null) {
				return $this->respond([
					"status" => 400,
					"message" => "Please enter atlease one value to update"
				]);
			}
		} else {
			return $this->respond([
				"status" => 404,
				"message" => "Keyword Not Found"
			]);
		}


		if (isset($array)) {

			if (($res = $key->update_keyword($id, $array)) == "Success") {
				return $this->respond([
					"status" => 200,
					"message" => "Successfully Updated"
				]);
			} else {
				return $this->respond([
					"status" => 400,
					"message" => "Failed to Update"
				]);
			}
		}
	}


	/**
	 * Function to delete Keywords
	 * 
	 * This function can be called to delete keywords.
	 * @param id | required
	 * @method GET
	 * @return [JSON]
	 */
	public function deleteKey()
	{
		$key = new KeywordsModel();
		$id = $this->request->getVar('id');

		if (($res = $key->delete_key($id)) == "Success") {
			return $this->respond([
				"status" => 200,
				"message" => "Successfully Deleted"
			]);
		} else {
			return $this->respond([
				"status" => 400,
				"message" => "Failed to Delete Keyword"
			]);
		}
	}
}
