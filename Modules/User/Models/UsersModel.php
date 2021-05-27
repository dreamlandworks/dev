<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'users';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"id", "userid", "password", "email", "facebook_id", "twitter_id", "users_id", "online_status_id"
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

	//Function to search whether user exists and his credentials are valid

	public function login_user($id, $type, $pass)
	{
		switch ($type) {
			case 'facebook':
				$user = $this->where('facebook_id', $id)->first();
				break;
			case 'google':
				$user = $this->where('email', $id)->first();
				break;
			case 'login':
				$user = $this->where('userid', $id)->where('password', $pass)->first();
				break;
		}
			return $user;
	}

	public function create_user($array){

		$data=[
			'userid'=> $array['mobile'],
			'password'=> $array['password'], 
			'email'=> $array['email'], 
			'facebook_id'=> $array['facebook_id'], 
			'twitter_id'=> $array['twitter_id'],
			'users_id' => $array['users_id']
			];
		
		$res = $this->insert($data);
		$insertID = $this->getInsertID();

		if ($res!=null) {
			return $insertID;
		} else {
			return 0;
		}

	}

	public function search_email($id){
	
		$res = $this->where("email", $id)->first();
		
		if ($res==null) {
			$rep = 1;
			return $rep;
		} else {
			$rep = 0;
			return $rep;
		}
	
	}

	public function search_mobile($id){
	
		$res = $this->where("userid", $id)->first();

		if ($res==null) {
			$rep = 1;
			return $rep;
		} else {
			$rep = 0;
			return $rep;
		}
	
	}

	public function search_user($id){
	
		return $this->where("id", $id)->first();

			}


		
}
