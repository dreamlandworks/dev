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
				$user = $this->where('userid', $id)->first();
				break;
		}
			return $user;
	}

	//Model for Creating New User
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

	//Model for Searching User based on Email
	public function search_email($id){
	
		$res = $this->where("email", $id)->first();
		
		if ($res==null) {
			return null;
		} else {
			return $res;
		}
	
	}

	//Model for Searching User based on Mobile
	public function search_mobile($id){
	
		$res = $this->where("userid", $id)->first();

		if ($res==null) {
			return null;
		} else {
			return $res;
		}
	
	}

	//Model for Searching User based on ID
	public function search_user($id){
	
		return $this->where("id", $id)->first();

			}

	//Model for Updating Password
	public function update_pass($id,$pass){
		
		if($this->update($id,["password"=>$pass])){
			return 1;
		}	
		else{
			return 0;
		}

	}

	public function update_email($id,$email){
		if($this->update($id,['email'=> $email])){
			$res = $this->search_user($id);
			return $res['users_id'];
		}
		else{
			return 0;
		}
	}
	
	public function search_by_email_mobile($email,$mobile){
	    $db      = \Config\Database::connect();
	    
        $builder = $db->table('users');
        $query = $builder->select('*')
                ->where('email', $email)
                ->orWhere('userid', $mobile)
                 ->get();
        if($query->getRow() != '') {
            return $query->getRow(); 
        }
	    else {
	        return 'failure'; 
	    }
    }
    
    public function validate_user($email,$mobile){
	    $db      = \Config\Database::connect();
	    
        $builder = $db->table('users');
        $builder->select('id');
        $builder->where('userid', $mobile);
        if($email != "") {
            $builder->where('email', $email);
        }    
        $query = $builder->get();
                
        if($query->getRow() != '') {
            return $query->getRow(); 
        }
	    else {
	        return 'failure'; 
	    }
    }
    
    public function validate_email($email){
	    $db      = \Config\Database::connect();
	    
        $builder = $db->table('users');
        $builder->select('id');
        $builder->where('email', $email);    
        $query = $builder->get();
                
        if($query->getRow() != '') {
            return $query->getRow(); 
        }
	    else {
	        return 'failure'; 
	    }
    }
    
    public function validate_mobile($mobile){
	    $db      = \Config\Database::connect();
	    
        $builder = $db->table('users');
        $builder->select('id');
        $builder->where('userid', $mobile);  
        $query = $builder->get();
                
        if($query->getRow() != '') {
            return $query->getRow(); 
        }
	    else {
	        return 'failure'; 
	    }
    }
    
    public function create_user_default($array){

		$data=[
			'userid'=> $array['mobile'],
			'password'=> $array['password'], 
			'email'=> $array['email'], 
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
		
}
