<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class CountryModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'country';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"id","country"
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

	//Function to search ID by Country Name
	//Returns Country ID if available or else '0' if not available
	public function search_by_country($country)
	{
		$res = $this->where("country", ucwords($country))->first();
		if ($res) {
			return $res['id'];
		} else {
			return 0;
		}
	}

	//Function to search Country Name by ID
	//Returns Country Name if available or else '0' if not available
	public function search_by_country_id($id)
	{
		$res = $this->where("id", $id)->first();
		if ($res != null) {
			return $res['country'];
		} else {
			return 0;
		}
	}

	//Function to Create New Country Name
	//Creates New Country Name 
	public function create_country($country)
	{
		$data = ["country"=>$country];
		$res = $this->insert($data);
		$insertID = $this->getInsertID();
		
		if ($res) {
			return $insertID;
		} else {
			return 0;
		}

	}

}
