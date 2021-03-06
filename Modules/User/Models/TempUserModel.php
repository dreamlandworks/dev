<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class TempUserModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'temp_user';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"id", "fname", "lname", "mobile", "otp", "datetime"
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

	//Require an Array with fname,lname,mobile,otp fields
	//Return Id
	public function add_temp_user($array)
	{

		if (($this->insert($array)) != null) {
			return $this->getInsertID();
		} else {
			return null;
		}
	}

	public function search_by_mobile($mobile)
	{

		$res = $this->where("mobile", $mobile)->first();
		if ($res) {
			return $res;
		} else {
			return null;
		}
	}

	public function update_data($id, $array)
	{
		if ($this->update($id, $array)) {
			return 1;
		} else {
			return 0;
		}
	}

	public function delete_temp($mobile)
	{

		$db      = \Config\Database::connect();
		$builder = $db->table('temp_user');

		if($builder->delete(["mobile"=>$mobile])){
			return 1;
		}else{
			return 0;
		}
		

	}
}