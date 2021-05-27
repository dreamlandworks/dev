<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class UserDetailsModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'user_details';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"id", "fname", "lname", "mobile",
		"dob", "profile_pic", "reg_status", "registered_on",
		"address_id", "referred_id", "points_count"
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


	//Function to search user details by ID
	//Returns address if available or else '0' if not available
	public function user_details_by_id($id)
	{
		$res = $this->where("id", $id)->first();
		if ($res) {
			return $res;
		} else {
			return 0;
		}
	}

	//Function to create User Details
	//Creates Address required fname,lname,mobile,dob,address_id
	public function create_user_details($array)
	{
		$data = [
			
			'fname' => $array['fname'],
			'lname' => $array['lname'],
			'mobile' => $array['mobile'],
			'dob' => $array['dob'],
			'reg_status' => $array['reg_status']
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
