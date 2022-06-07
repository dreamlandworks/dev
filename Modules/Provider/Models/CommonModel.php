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
        $count = count($result);
          
        if($count > 0) {
            return $result; 
        }
	    else {
	        return 'failure'; 
	    }
    }


   public function get_details_with_multiple_where($table_name, $where_array, $order_by_field = NULL, $oder_by = NULL) {
	    $db  = \Config\Database::connect();
	    
        $builder = $db->table($table_name);
        $builder->select("*");
                
        $builder->where($where_array);
        if ($order_by_field != NULL) {
            $builder->orderBy($order_by_field, $oder_by);
        }
        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;      
        $count = count($result);
          
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
        $count = count($result);
                
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
        // echo $this->db->getLastQuery();exit;
        
        return $db->insertID();
    }

    public function update_records_dynamically($table_name, $data, $where_field, $field_value) {
        $db  = \Config\Database::connect();
        
        $builder = $db->table($table_name);
        $builder->where($where_field, $field_value);
        $builder->update($data);
        //echo $this->db->getLastQuery();exit;
    }


    public function update_records_dynamically_multiple_where($table_name, $data, $where_array) {
        $db  = \Config\Database::connect();
        
        $builder = $db->table($table_name);
        $builder->where($where_array);
        $builder->update($data);
        //echo $this->db->getLastQuery();exit;
    }

    	
    public function delete_records_dynamically($table_name, $where_field, $field_value) {
        $db  = \Config\Database::connect();
        
        $builder = $db->table($table_name);
        $builder->where($where_field, $field_value);
        $builder->delete();
        //echo "<br> str ".$this->db->getLastQuery();exit;  
    }

    public function delete_records_dynamically_multiple_where($table_name, $where_array) {
        $db  = \Config\Database::connect();
        
        $builder = $db->table($table_name);
        $builder->where($where_array);
        $builder->delete();
        //echo "<br> str ".$this->db->getLastQuery();exit;  
    }
    
    public function batch_insert_records_dynamically($table_name, $data) {
        $db  = \Config\Database::connect();
        
        $builder = $db->table($table_name);
        $builder->insertBatch($data);
        // echo "<br> str ".$this->db->getLastQuery();exit; 
        
        return $db->insertID();
    }

    
} 
