<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class keywordModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'keywords';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
			"id","category","image"
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

	
// 	public function add_category($category,$image){
		
// 		$arrray = [
// 			"category"=>$category,
// 			"image" => $image
// 		];

// 		$res = $this->insert($arrray);
	
// 		if($res){
// 			return "Success";	
// 		}
// 		else{
// 			return "Fail";
// 		}

	
// 	}
	
	public function showAll($subcategories_id = NULL){
	    if($subcategories_id != NULL) {
	        return $this->where('subcategories_id', $subcategories_id)->where('status', 'Active')->findAll();
	    }
	    else {
	        return $this->findAll();
	    }
		
	}
	
	public function get_keywords(){
	    $db      = \Config\Database::connect();
	    
	    $builder = $db->table('keywords');
	    $builder->select('keyword,sub_name');
	    $builder->join('subcategories', 'subcategories.id = keywords.subcategories_id');
	    $builder->where('keywords.status', 'Active');
        $query   = $builder->get();
        $result = $query->getResult();
        $count = $builder->countAllResults();
	    
	    if($count > 0) {
            return $result; 
        }
	    else {
	        return 'failure'; 
	    }
    }


}
