<?php

namespace Modules\Provider\Models;

use CodeIgniter\Model;

class CommonModel extends Model
{
	public function get_details_dynamically($table_name, $where_field, $field_value, $order_by_field = NULL, $oder_by = NULL) {
	    $db      = \Config\Database::connect();
	    
        $builder = $db->table($table_name);
        $builder->select("*");
        $builder->where($where_field, $field_value);
        if ($order_by_field != NULL) {
            $builder->orderBy($order_by_field, $oder_by);
        }
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;      
        $count = $builder->countAllResults();
          
        if($count > 0) {
            return $result; 
        }
	    else {
	        return 'failure'; 
	    }
    }
    
    public function get_table_details_dynamically($table_name, $order_by_field = NULL, $oder_by = NULL) {
        $db      = \Config\Database::connect();
	    
        $builder = $db->table($table_name);
        $builder->select("*");
        if ($order_by_field != NULL) {
            $builder->orderBy($order_by_field, $oder_by);
        }
        $result = $builder->get()->getResultArray();
        $count = $builder->countAllResults();
                
        if($count > 0) {
            return $result; 
        }
	    else {
	        return 'failure'; 
	    }
    }
    
    public function insert_records_dynamically($table_name, $data) {
        $db  = \Config\Database::connect();
        
        $builder = $db->table($table_name);
        $builder->insert($data);
        
        return $db->insertID();
    }
	
    public function update_records_dynamically($table_name, $data, $where_field, $field_value) {
        $db  = \Config\Database::connect();
        
        $builder = $db->table($table_name);
        $builder->where($where_field, $field_value);
        $builder->update($data);
    }
	
    public function delete_records_dynamically($table_name, $where_field, $field_value) {
        $db  = \Config\Database::connect();
        
        $builder = $db->table($table_name);
        $builder->where($where_field, $field_value);
        $builder->delete();
        //echo "<br> str ".$this->db->getLastQuery();exit;  
    }
    
    public function batch_insert_records_dynamically($table_name, $data) {
        $db  = \Config\Database::connect();
        
        $builder = $db->table($table_name);
        $builder->insertBatch($data);
        
        return $db->insertID();
    }

    
}
