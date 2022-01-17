<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class MiscModel extends Model
{
    //---------------------------------------------------ADD PROFESSION STARTS-----------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function add_profession($name)
    {
        $builder = $this->db->table('list_profession');
        $builder->insert(['name'=>$name]);
        $query = $this->db->insertID();
        
        if ($query != null) {
            return $query;
        } else {
            return null;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Users STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_users_list()
    {
    
        $builder = $this->db->table('user_details');
        $builder->select('*');
        $builder->join('users', 'users.users_id = user_details.id');
        //$builder->where('online_status_id',1);
        $result = $builder->get()->getResultArray();
        $builder->orderBy('id','DESC');
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);
                
        if($count > 0) {
            return $result; 
        }
        else {
            return 'failure'; 
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    

}