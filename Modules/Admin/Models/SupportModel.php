<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class SupportModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'complaints';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"id", "module_id", "booking_id","description","created_on","users_id"
	];

	// Dates
	protected $useTimestamps        = false;
// 	protected $dateFormat           = 'datetime';
// 	protected $createdField         = 'created_at';
// 	protected $updatedField         = 'updated_at';
// 	protected $deletedField         = 'deleted_at';

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


	public function add_userplans($name,$amount,$period,$posts_per_month,$proposals_per_post,$premium_tag,$customer_support,$description)
	{

		$arrray = [
			"name" => $name,
			"amount" => $amount,
			"period" => $period,
			"posts_per_month" => $posts_per_month,
			"proposals_per_post" => $proposals_per_post,
			"premium_tag" => $premium_tag,
			"customer_support" => $customer_support,
			"description" => $description
			
			
		];

		$res = $this->insert($arrray);

		if ($res) {
			return "Success";
		} else {
			return "Fail";
		}
	}

	

	
}
