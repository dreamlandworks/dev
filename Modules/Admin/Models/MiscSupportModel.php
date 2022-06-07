<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class MiscSupportModel extends Model
{
    
    public function showAllSupport()
	{
		$builder = $this->db->table('complaints');
		$builder->select('complaint_module.module_name,complaints.id,complaints.booking_id,complaints.description,complaints.priority,complaints.created_on,complaint_status.complaints_id,complaint_status.assigned_to,
		complaint_status.action_taken,complaint_status.status,complaint_status.created_on As createdOn,staff.staff_name,user_details.fname,user_details.lname,booking.id as bookingId');
        $builder->join('complaint_module', 'complaint_module.id = complaints.module_id','left');
        $builder->join('complaint_status', 'complaint_status.complaints_id = complaints.id','left');
        $builder->join('staff', 'staff.staff_id = complaint_status.assigned_to','left');
        $builder->join('user_details', 'user_details.id = complaints.users_id','left');
        $builder->join('booking', 'booking.id = complaints.booking_id','left');
        
        //$builder->select('*');
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
	
	public function showAllCompliantModule()
	{
		$builder = $this->db->table('complaint_module');
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
	
	public function showAllUsers()
	{
		$builder = $this->db->table('user_details');
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
	
	public function showAllStaffs()
	{
		$builder = $this->db->table('staff');
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
	
	public function showAllBooking()
	{
		$builder = $this->db->table('booking');
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
	
	public function getCompliant($id)
	{
		$builder = $this->db->table('complaints');
		$builder->select('complaint_module.id,complaint_module.module_name,complaints.id,complaints.users_id,complaints.description,complaints.priority,complaints.created_on,complaints.module_id,complaint_status.complaints_id,complaint_status.assigned_to,
		complaint_status.action_taken,complaint_status.status,complaint_status.created_on As createdOn,staff.staff_name,booking.id as bookingId');
        $builder->join('complaint_module', 'complaint_module.id = complaints.module_id','left');
        $builder->join('complaint_status', 'complaint_status.complaints_id = complaints.id','left');
        $builder->join('staff', 'staff.staff_id = complaint_status.assigned_to','left');
        $builder->join('booking', 'booking.id = complaints.booking_id','left');
        //$builder->join('user_details', 'user_details.id = complaints.users_id','left');
        //$builder->select('*');
        $builder->where('complaints.id', $id);
        $result = $builder->get()->getRow();
        // $query = $this->db->getLastQuery();
        // echo (string)$query;
        if($result) {
            return $result; 
        }
        else {
            return 'failure'; 
        }
	}
	
	public function updateCompliant($id,$data)
	{
		$builder = $this->db->table('complaints');
        $builder->where('id', $id);
        return $builder->update($data);
	}
	
	public function updateCompliant_status($id,$data)
	{
		$builder = $this->db->table('complaint_status');
        $builder->where('complaints_id', $id);
        return $builder->update($data);
	}
	
	
	public function deleteCompliant($id)
	{
		$builder = $this->db->table('complaints');
        $builder->where('id', $id);
        return $builder->delete();
	}
	
	public function deleteCompliantStatus($id)
	{
		$builder = $this->db->table('complaint_status');
        $builder->where('complaints_id', $id);
        return $builder->delete();
	}
	
	function add_compliant($created_on,$booking,$description,$module,$priority)
    {
        $builder = $this->db->table('complaints');

        
        $arrray = [
	     	"booking_id" => $booking,
			"created_on" => $created_on,
			//"users_id" => $created_by,
			"description" => $description,
			"module_id" => $module,
			"priority" => $priority,
		//	"status" => $status,
		];

        $builder->insert($arrray);
         //echo "<br> str ".$this->db->getLastQuery();exit;
        $query = $this->db->insertID();
        
        if ($query != null) {
            return $query;
        } else {
            return null;
        }
    }
	
	
	function add_compliant_status($compliant_id,$assign_to,$status,$created_on)
    {
        $builder = $this->db->table('complaint_status');

        
        $arrray = [
			"complaints_id" => $compliant_id,
			"created_on" => $created_on,
			"assigned_to" => $assign_to,
			"status" => $status
		];

        $builder->insert($arrray);
         //echo "<br> str ".$this->db->getLastQuery();exit;
        $query = $this->db->insertID();
        
        if ($query != null) {
            return $query;
        } else {
            return null;
        }
    }
    
    
    public function showAllPendingTicketCount()
	{
		$arrStatus = array("Pending", "In Progress" ,"Resloved");
		
		$builder = $this->db->table('complaint_status');
		
	    $builder->select("COUNT(if(complaint_status.status='Pending',1,NULL)) as Pending,COUNT(if(complaint_status.status='In Progress',1,NULL)) as InProgress,COUNT(if(complaint_status.status='Resolved',1,NULL)) as Resolved");
		$builder->join('complaints', 'complaints.id = complaint_status.complaints_id');
		
        //$builder->whereIn('complaint_status.status', $arrStatus);
		
		//$builder->groupBy('complaint_status.status_id');
		 
        $result = $builder->get()->getResultArray();
        
        //echo "<br> str ".$this->db->getLastQuery();
        $count = count($result);
                
        if($count > 0) {
            return $result; 
        }
        else {
            return 'failure'; 
        }
	}
}