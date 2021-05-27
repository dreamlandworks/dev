<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class ZipcodeModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'zipcode';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ["id","zipcode","city_id"];

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

	//Function to search ID by Zip Code
	//Returns ZIP ID if available or else '0' if not available
	public function search_by_zipcode($zip)
	{
		$res = $this->where("zipcode", $zip)->first();
		if ($res) {
			return $res['id'];
		} else {
			return 0;
		}
	}

	//Function to search ZIP Code by ID
	//Returns ZIP Code if available or else '0' if not available
	public function search_by_zip($id)
	{
		$res = $this->where("id", $id)->first();
		if ($res != null) {
			return $res['zipcode'];
		} else {
			return 0;
		}
	}

	//Function to create New ZIP Code
	//Creates ZIP Code 
	public function create_zip($zipcode, $city_id)
	{
		$data = [
			"zipcode" => $zipcode,
			"city_id"=>$city_id
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
