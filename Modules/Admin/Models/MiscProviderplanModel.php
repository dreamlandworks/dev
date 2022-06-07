<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class MiscProviderplanModel extends Model
{
    
    public function showAllProviderPlans()
	{
		$builder = $this->db->table('sp_plans');
        $builder->select('*');
        $result = $builder->get()->getResultArray();
        //$builder->orderBy('id','DESC');
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);
                
        if($count > 0) {
            return $result; 
        }
        else {
            return 'failure'; 
        }
	}
	
	public function getProviderPlans($id)
	{
		$builder = $this->db->table('sp_plans');
        $builder->select('*');
        $builder->where('id', $id);
        $result = $builder->get()->getRow();
        //$query = $this->db->getLastQuery();
        //echo (string)$query;
        if($result) {
            return $result; 
        }
        else {
            return 'failure'; 
        }
	}
	
	public function updateProviderPlans($id,$data)
	{
		$builder = $this->db->table('sp_plans');
        $builder->where('id', $id);
        return $builder->update($data);
	}
	
	
	public function deleteProviderPlans($id)
	{
		$builder = $this->db->table('sp_plans');
        $builder->where('id', $id);
        return $builder->delete();
	}
	
}