<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class MiscModel extends Model
{
//---------------------------------------------------CREATE LOGIN ACTIVITY LOG STARTS---------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
    function create_login_activity($id)
    {
    
        $builder = $this->db->table('login_activity');
        if($builder->insert(["user_id" => $id])){
            return 1;
        }else{
            return 0;
        }
    }
//--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------


//---------------------------------------------------GET LAST LOGIN ACTIVITY STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_login_activity($id)
{

    $builder = $this->db->table('login_activity');
    $builder->where(['user_id'=>$id]);
    $builder->orderBy('id','DESC');
    $query = $builder->get(1);

    if($query->getResult() != null){
        return $query->getResultArray();
    }else{
        return null;
    }
}
//--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------







}
