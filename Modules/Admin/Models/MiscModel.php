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


    

}