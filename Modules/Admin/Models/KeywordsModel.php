<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class KeywordsModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'keywords';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"keyword","subcategories_id"
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

	public function add($keyword, $sub_id)
	{

		$arrray = [
			"keyword" => $keyword,
			"subcategories_id" => $sub_id
		];

		$res = $this->insert($arrray);

		if ($res) {
			return "Success";
		} else {
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
			return Null;
		}
	}

	public function search_by_name($name)
	{
		if(($res = $this->where('keyword', $name)->first()) != null){
			return $res;
		}
		else{
			return Null;
		}
	}


	public function update_keyword($id,$array){

		if($this->update($id,$array)){
			return "Success";
		}
		else{
			return "Fail";
		}

	}

	public function delete_key($id){
		if($this->delete($id)){
			return "Success";
		}
		else{
			return "Fail";
		}
	}


}
