<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class SubcategoriesModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'subcategories';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"id","sub_name","image","category_id"
	];

	// Dates
	protected $useTimestamps        = false;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];

	
	public function add($name,$image,$category_id){

		$array = [
			"sub_name" => $name,
			"image" => $image,
			"category_id" => $category_id
		];

		$res = $this->insert($array);
		if($res){
			return "Success";
		}
		else{
			return "Fail";
		}

	}

	public function showAll()
	{
		return $this->findAll();
	}


	public function search($id)
	{
		if(($res = $this->where('id', $id)->first()) != null){
			return $res;
		}
		else{
			return "No Record Found";
		}
	}


	public function update_sub($id,$array){

		if($this->update($id,$array)){
			return "Succesfull Updated";
		}
		else{
			return "Failed to Update Record";
		}

	}

	public function delete_sub($id){
		if($this->delete($id)){
			return "Successfully Deleted";
		}
		else{
			return "Failed to Delete";
		}
	}




}
