<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class StateModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'state';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ["id", "state", "country_id"];

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

	//Function to search ID by State Name
	//Returns State ID if available or else '0' if not available
	public function search_by_state($state)
	{
		$res = $this->where("state", ucwords($state))->first();
		if ($res) {
			return $res['id'];
		} else {
			return 0;
		}
	}

	//Function to search State Name by ID
	//Returns State Name if available or else '0' if not available
	public function search_by_state_id($id)
	{
		$res = $this->where("id", $id)->first();
		if ($res != null) {
			return $res['state'];
		} else {
			return 0;
		}
	}

	//Function to Create New State Name
	//Creates New State Name 
	public function create_state($state, $country_id)
	{
		$data = [
			"state" => $state,
			"country_id" => $country_id
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
