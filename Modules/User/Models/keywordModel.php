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
	
	public function showAll($profession_id = NULL){
	    if($profession_id > 0) {
	        return $this->where('profession_id', $profession_id)->where('status', 'Active')->findAll();
	    }
	    else {
	        return $this->where('status', 'Active')->findAll();
	    }
		
	}
	
	public function get_keywords($category_id = 0){
	    $db      = \Config\Database::connect();
	    
	    $builder = $db->table('keywords');
	    $builder->select('keywords.id as keyword_id,keyword,name,subcategory_id,category_id,keywords.profession_id');
	    $builder->join('list_profession', 'list_profession.id = keywords.profession_id');
	    $builder->where('keywords.status', 'Active');
	    if($category_id > 0) {
	        $builder->where('list_profession.category_id', $category_id);
	    }
        $query   = $builder->get();
        //echo "<br> str ".$this->db->getLastQuery();exit;
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
