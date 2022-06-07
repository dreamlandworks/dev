<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class ProviderplanModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'sp_plans';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"id", "name", "description","amount","period","platform_fee_per_booking","premium_tag","bids_per_month","sealed_bids_per_month","customer_support"
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


	public function add_providerplan($name,$amount,$period,$platform_fee_per_booking,$premium_tag,$bids_per_month,$sealed_bids_per_month,$customer_support)
	{

		$arrray = [
			"name" => $name,
			"amount" => $amount,
			"period" => $period,
			"platform_fee_per_booking" => $platform_fee_per_booking,
			"premium_tag" => $premium_tag,
			"bids_per_month" => $bids_per_month,
			"sealed_bids_per_month" => $sealed_bids_per_month,
			"customer_support" => $customer_support
			
			
		];

		$res = $this->insert($arrray);

		if ($res) {
			return "Success";
		} else {
			return "Fail";
		}
	}

	
}
