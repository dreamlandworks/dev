<?php

namespace Modules\Provider\Models;

use CodeIgniter\Model;

class ServiceProviderModel extends Model
{
	public function get_sp_activation_details($user_id) {
	    $db      = \Config\Database::connect();
	    
	    $builder = $db->table('users');
        $builder->select('users.id,sp_det.id as sp_det_id,tariff.id as tariff_id,sp_verify.id as sp_verify_id');
        $builder->join('sp_det', 'sp_det.users_id = users.id','LEFT');
        $builder->join('tariff', 'tariff.users_id = users.id','LEFT');
        $builder->join('sp_verify', 'sp_verify.users_id = users.id','LEFT');
        
        $builder->where('users.id', $user_id);
        $result = $builder->get()->getResultArray();
        $count = $builder->countAllResults();
                
        if($count > 0) {
            return $result; 
        }
	    else {
	        return 'failure'; 
	    }
    }
    
    public function get_sp_professional_details($user_id) {
	    $db      = \Config\Database::connect();
	    
	    $builder = $db->table('users');
        $builder->select('users.id,category_id,sp_det.id as sp_det_id,tariff.id as tariff_id,list_profession.name as profession_name,sp_qual.qualification,sp_exp.exp,about_me,
                            per_hour as tariff_per_hour,per_day as tariff_per_day,min_charges as tariff_min_charges,extra_charge as tariff_extra_charges');
        $builder->join('sp_det', 'sp_det.users_id = users.id','LEFT');
        $builder->join('tariff', 'tariff.users_id = users.id','LEFT');
        $builder->join('list_profession', 'list_profession.id = sp_det.profession_id');
        $builder->join('sp_qual', 'sp_qual.id = sp_det.qual_id');
        $builder->join('sp_exp', 'sp_exp.id = sp_det.exp_id');
        
        $builder->where('users.id', $user_id);
        $result = $builder->get()->getResultArray();
        $count = $builder->countAllResults();
                
        if($count > 0) {
            return $result; 
        }
	    else {
	        return 'failure'; 
	    }
    }
    
}
