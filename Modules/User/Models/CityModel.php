<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class CityModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'city';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ["id","city","state_id"];

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

	//Function to search ID by City Name
	//Returns City ID if available or else '0' if not available
	public function search_by_city($city)
	{
		$res = $this->where("city", ucwords($city))->first();
		if ($res != null) {
			return $res['id'];
		} else {
			return 0;
		}
	}

	//Function to search City Name by ID
	//Returns City Name if available or else '0' if not available
	public function search_by_city_id($id)
	{
		$res = $this->where("id", $id)->first();
		if ($res != null) {
			return $res['city'];
		} else {
			return 0;
		}
	}

	//Function to Create New City Name
	//Creates New City Name 
	public function create_city($city, $state_id)
	{
		$data = [
			"city"=>$city,
			"state_id"=>$state_id
		];
		$res = $this->insert($data);
		$insertID = $this->getInsertID();	
		
		if ($res) {
			return $insertID;
		} else {
			return 0;
		}

	}
}
