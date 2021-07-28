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
    
}
