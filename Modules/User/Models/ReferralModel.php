<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class ReferralModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'referral';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = ["id","referral_id","referred_by","user_id"];

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

	public function creat_ref($array){
		
		$res = $this->insert($array);
		$insertID = $this->getInsertID();

		if ($res) {
			return ['id' => $insertID,'referral_id'=>$array['referral_id']];
		} else {
			return 0;
		}
	}

	public function get_details($id){
		
		$res = $this->where('id', $id)->first();
		if($res != null){
			return $res;
		}
		else{
			return null;
		}
		
		}
	
}
