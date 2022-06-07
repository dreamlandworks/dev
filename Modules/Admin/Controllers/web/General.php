<?php

namespace Modules\Admin\Controllers\web;

use Modules\Admin\Models\MiscModel;
use Modules\Admin\Models\CategoriesModel;
use Modules\Admin\Models\SubcategoriesModel;
use Modules\Admin\Models\KeywordsModel;
use App\Controllers\BaseController;

class General extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function categories()
	{
	    $misc_model = new MiscModel();
		
		$arr_categories =  $misc_model->showAllCategories(); 
		/*echo "<pre>";
		print_r($arr_categories);
		echo "</pre>";
		exit;*/
		$data['arr_categories'] = $arr_categories;
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\categories',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function subcategories()
	{
	    $misc_model = new MiscModel();
		
		$arr_subcategories =  $misc_model->showAllSubCategories(); 
		/*echo "<pre>";
		print_r($arr_subcategories);
		echo "</pre>";
		exit;*/
		$data['arr_subcategories'] = $arr_subcategories;
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\subcategories',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function keywords()
	{
	    $misc_model = new MiscModel();
		
		$data['keywords'] =  $misc_model->showAllKeywords(); 
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\keywords',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function languages()
	{
	    $misc_model = new MiscModel();
		
		$data['languages'] =  $misc_model->showAllLanguages();
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\languages',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function professions()
	{
	    $misc_model = new MiscModel();
	    $cateModel = new CategoriesModel();
	    $subcateModel = new SubcategoriesModel();
		$data['professions'] =  $misc_model->showAllProfessions();
		$data['categories'] =  $cateModel->showAll(); 
		$data['subcategories'] =  $subcateModel->showAll(); 
		//echo "<pre>";print_r($data['professions']);exit;
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\general\professions',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function qualifications()
	{
	    $misc_model = new MiscModel();
		$data['qualifications'] =  $misc_model->showAllQualifications();
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\general\qualifications',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function add_category()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\general\addCategory');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function add_sub_category()
	{
	    $cateModel = new CategoriesModel();
		
		$data['categories'] =  $cateModel->showAll(); 
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\general\addSubCategory',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function add_keywords()
	{
	    $misc_model = new MiscModel();
		
		$data['professions'] =  $misc_model->getprofession(); 
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\general\addKeywords',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_subcategory($id)
	{
	    $misc_model = new MiscModel();
		$cateModel = new CategoriesModel();
		
		$data['categories'] =  $cateModel->showAll(); 
		$data['subcategory'] =  $misc_model->getSubCategory($id);
		//echo "<pre>";print_r($data['subcategory']);exit;
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\general\editSubCategory',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_keywords($id)
	{
	    $misc_model = new MiscModel();
		
		$data['professions'] =  $misc_model->getprofession();
		$data['keyword'] =  $misc_model->getKeywords($id);
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\general\editKeywords',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function delete_category()
	{
	     $misc_model = new MiscModel();
		
        $cat_id = service('request')->getPost('cat_id');
        $res = $misc_model->deleteCategories($cat_id);
        echo $cat_id;
    
	}
	public function edit_status()
	{
	     $misc_model = new MiscModel();
		
        $cat_id = service('request')->getPost('cat_id');
        $cat_status = service('request')->getPost('status');
        $data = [
            'status' => $cat_status
        ];
        $res = $misc_model->updateCategories($cat_id, $data);
        echo $res;
    
	}
	
	public function edit_category($id = null)
	{
	    //print_r(service('request')->getVar());
	    //$request->getPost();
	    //echo $request->getGet();
	    //echo $id;
	    $misc_model = new MiscModel();
		
		$data['category'] =  $misc_model->getCategory($id); 
		//echo "<pre>"; print_r($data['category']);exit;
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\general\editCategories',$data);
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function create_category_submit()
	{
		//$session = \Config\Services::session();
		
        //JSON Objects declared into variables
        $category = $this->request->getVar('category_name');
        $image = '';
        
       $img = $this->request->getFile('category_image');
       //echo $img->getName();
       if($img->getName()){
        if (! $img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move('./images/categories',$newName);
            $image = '/images/categories/'.$newName;
        }
       }
        $cateModel = new CategoriesModel();
        $res = $cateModel->add_category($category, $image);
        return redirect('ct/categories');
	}
	
	public function edit_category_submit()
	{
		//JSON Objects declared into variables
		$category_id = $this->request->getVar('category_id');
        $category_name = $this->request->getVar('category_name');
        $category_status = $this->request->getVar('category_status');
        $image = '';
        
       $img = $this->request->getFile('category_image');
       //echo $img->getName();
       if($img->getName()){
        if (! $img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move('./images/categories',$newName);
            $image = '/images/categories/'.$newName;
            $data = [
            'category' => $category_name,
            'status' => $category_status,
            'image' => $image
         ];
        }  }else {
            $data = [
            'category' => $category_name,
            'status' => $category_status
            ];
        }
        $misc_model = new MiscModel();
        
        $res = $misc_model->updateCategories($category_id, $data);
        return redirect('ct/categories');
	}
	
	public function create_subcategory_submit()
	{
        //JSON Objects declared into variables
        $subcategory = $this->request->getVar('subcategory_name');
        $category_id = $this->request->getVar('category_id');
        $image = '';
        
       $img = $this->request->getFile('subcategory_image');
       //echo $img->getName();
       if($img->getName()){
        if (! $img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move('./images/subcategories',$newName);
            $image = '/images/subcategories/'.$newName;
        }
       }
        $subcateModel = new SubcategoriesModel();
        $res = $subcateModel->add($subcategory, $image,$category_id);
        //echo $res;
        
        return redirect()->to(base_url().'/ct/subcategories');
	}
	
	public function edit_subcategory_status()
	{
	     $misc_model = new MiscModel();
		
        $sub_cat_id = service('request')->getPost('sub_cat_id');
        $sub_cat_status = service('request')->getPost('status');
        $data = [
            'status' => $sub_cat_status
        ];
        $res = $misc_model->updateSubCategories($sub_cat_id, $data);
        echo $res;
    
	}
	
	public function edit_subcategory_submit()
	{
		//JSON Objects declared into variables
		$subcategory_id = $this->request->getVar('subcategory_id');
        $subcategory_name = $this->request->getVar('subcategory_name');
        $subcategory_status = $this->request->getVar('subcategory_status');
        $category_id = $this->request->getVar('category_id');
        $image = '';
        
       $img = $this->request->getFile('subcategory_image');
       //echo $img->getName();
       if($img->getName()){
        if (! $img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move('./images/categories',$newName);
            $image = '/images/categories/'.$newName;
            $data = [
            'sub_name' => $subcategory_name,
            'category_id' => $category_id,
            'status' => $subcategory_status,
            'image' => $image
         ];
        }  }else {
            $data = [
            'sub_name' => $subcategory_name,
            'category_id' => $category_id,
            'status' => $subcategory_status
            ];
        }
        $misc_model = new MiscModel();
        
        $res = $misc_model->updateSubCategories($subcategory_id, $data);
        return redirect()->to(base_url().'/ct/subcategories');
	}
	
	public function delete_subcategory()
	{
	     $misc_model = new MiscModel();
		
        $subcat_id = service('request')->getPost('subcat_id');
        $res = $misc_model->deleteSubCategories($subcat_id);
        echo $res;
    
	}
	public function create_keyword_submit()
	{
        //JSON Objects declared into variables
        $keyword = $this->request->getVar('keyword');
        $profession_id = $this->request->getVar('profession_id');
        
       
        $misc_model = new MiscModel();
        $res = $misc_model->add_keyword($keyword, $profession_id);
        return redirect()->to(base_url().'/ct/keywords');
	}
	
	public function edit_keyword_status()
	{
	     $misc_model = new MiscModel();
		
        $keyword_id = service('request')->getPost('keyword_id');
        $keyword_status = service('request')->getPost('status');
        $data = [
            'status' => $keyword_status
        ];
        $res = $misc_model->updateKeyword($keyword_id, $data);
        echo $res;
    
	}
	public function delete_keyword()
	{
	     $misc_model = new MiscModel();
		
        $keyword_id = service('request')->getPost('keyword_id');
        $res = $misc_model->deleteKeyword($keyword_id);
        echo $res;
    
	}
	
	public function edit_keyword_submit()
	{
		//JSON Objects declared into variables
		$keyword_id = $this->request->getVar('keyword_id');
        $keyword = $this->request->getVar('keyword');
        $keyword_status = $this->request->getVar('keyword_status');
        $profession_id = $this->request->getVar('profession_id');
       
            $data = [
            'keyword' => $keyword,
            'profession_id' => $profession_id,
            'status' => $keyword_status
            ];
        
        $misc_model = new MiscModel();
        
        $res = $misc_model->updateKeyword($keyword_id, $data);
        return redirect()->to(base_url().'/ct/keywords');
	}
	
	
	public function create_language_submit()
	{
		//JSON Objects declared into variables
        $language_name = service('request')->getPost('language_name');
        $misc_model = new MiscModel();
        $res = $misc_model->add_language($language_name);
        echo $res;
        //return redirect()->to(base_url().'/ct/languages');
	}
	
	
	public function edit_language_submit()
	{
		//JSON Objects declared into variables
		$language_id = service('request')->getPost('language_id');
        $language_name = service('request')->getPost('language_name');
        
            $data = [
            'name' => $language_name
            ];
        
        $misc_model = new MiscModel();
        
        $res = $misc_model->updateLanguage($language_id, $data);
        echo $res;
        //return redirect()->to(base_url().'/ct/keywords');
	}
	
	public function delete_language()
	{
	     $misc_model = new MiscModel();
		
        $language_id = service('request')->getPost('language_id');
        $res = $misc_model->deleteLanguage($language_id);
        echo $res;
    
	}
	
	public function create_profession_submit()
	{
        //JSON Objects declared into variables
        $name = $this->request->getVar('profession_name');
        $category_id = $this->request->getVar('category_id');
        $subcategory_id = $this->request->getVar('subcategory_id');
       
        $misc_model = new MiscModel();
        $res = $misc_model->add_professions($name,$category_id,$subcategory_id);
        return redirect()->to(base_url().'/ct/professions');
	}
	
	public function edit_profession_submit()
	{
		$name = $this->request->getVar('editprofession_name');
        $category_id = $this->request->getVar('editcategory_id');
        $subcategory_id = $this->request->getVar('editsubcategory_id');
        $profession_id = $this->request->getVar('editprofession_id');
            $data = [
            'name' => $name,
            'category_id' => $category_id,
            'subcategory_id' => $subcategory_id,
            ];
        
        $misc_model = new MiscModel();
        
        $res = $misc_model->updateProfession($profession_id, $data);
        //echo $res;
        return redirect()->to(base_url().'/ct/professions');
	}
	
	public function delete_profession()
	{
	     $misc_model = new MiscModel();
		
        $profession_id = service('request')->getPost('profession_id');
        $res = $misc_model->deleteProfession($profession_id);
        echo $res;
    
	}
	
	public function create_qualification_submit()
	{
        //JSON Objects declared into variables
        $qualification = $this->request->getVar('addqualification_name');
        
       
        $misc_model = new MiscModel();
        $res = $misc_model->add_qualification($qualification);
        return redirect()->to(base_url().'/ct/qualifications');
	}
	
	
	public function edit_qualification_submit()
	{
		$qualification = $this->request->getVar('editqualification_name');
        $qualification_id = $this->request->getVar('editqualification_id');
            $data = [
            'qualification' => $qualification
            ];
        
        $misc_model = new MiscModel();
        
        $res = $misc_model->updateQualification($qualification_id, $data);
        //echo $res;
        return redirect()->to(base_url().'/ct/qualifications');
	}
	
	public function delete_qualification()
	{
	     $misc_model = new MiscModel();
		
        $qualification_id = service('request')->getPost('qualification_id');
        $res = $misc_model->deleteQualification($qualification_id);
        echo $res;
    
	}
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
// 