<?php

namespace Modules\Provider\Models;

use CodeIgniter\Model;

class AlertModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'alert_details';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = false;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"id", "alert_id", "sub_id", "reference_id", "created_on", "status", "users_id", "sp_id"
	];

	//---------------------------------------------------------CREATE ALERTS STARTS---------------------------------------------------------
	//-----------------------------------------------------------***************------------------------------------------------------------    

	/**
	 * Creates Alert Record
	 * 
	 * @param mixed $array
	 * Fields required in the array are
	 * "alert_id", "created_on","status","alert_sub","reference_id","users_id","sp_id"
	 * 
	 * @return int|null -> Returns ID of the created record
	 */
	public function create_record($array)
	{

		if ($this->insert($array)) {
			$res = $this->getInsertID();
			return $res;
		} else {
			return null;
		}
	}

	//--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------


	//---------------------------------------------------------CREATE SUB ALERTS STARTS-----------------------------------------------------
	//-----------------------------------------------------------***************------------------------------------------------------------    
	/**
	 * Create Sub Alerts based on Alert Type
	 * 
	 * Required array should contain 'description','alert_id','action'
	 * @param mixed $array
	 * 
	 * @return int|null -> Created Alert Subdetails ID
	 */
	function create_alert_sub($array)
	{

		$builder = $this->db->table('alert_sub');
		$builder->insert($array);

		if (($query = $this->db->insertID()) != null) {
			return $query;
		} else {
			return null;
		}
	}
	//--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------



	//--------------------------------------------------------GET UNREAD ALERTS STARTS---------------------------------------------------
	//-----------------------------------------------------------***************------------------------------------------------------------    

	public function unread_alerts($id, $type)
	{

		$builder = $this->db->table('alert_details');
		$builder->select('alert_details.id,alert.alert_type,description,alert_details.created_on');
		$builder->join('alert', 'alert_details.alert_id = alert.id');
		//$builder->join('alert_sub', 'alert_details.sub_id = alert_sub.id');
		$builder->where('sp_id', $id);
		$builder->where('status', 1);
		$builder->where('action', $type);
		$query = $builder->get();

		$res = $query->getResultArray();

		if ($res != null) {
			return $res;
		} else {
			return null;
		}
	}


	//--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

  
	//--------------------------------------------------------UPDATE ALERT STATUS STARTS---------------------------------------------------
	//-----------------------------------------------------------***************------------------------------------------------------------    

	public function update_alert($id,$date,$type){

		$builder = $this->db->table('alert_details');
		$builder->where('sp_id',$id);
		$builder->where('action', $type);
		$builder->where('created_on <',$date);
		$builder->update(['status'=>2]);
		$query = $builder->get();

		if($query){
			return "Success";
		}else{
			return "Fail";
		}

	}
	
	//--------------------------------------------------------GET ALL ALERTS STARTS---------------------------------------------------
	//-----------------------------------------------------------***************------------------------------------------------------------    

	public function all_alerts($id, $type,$status)
	{

		$builder = $this->db->table('alert_details');
		$builder->select('alert_details.id,alert.alert_type,status,description,alert_details.created_on');
		$builder->join('alert', 'alert_details.alert_id = alert.id');
		//$builder->join('alert_sub', 'alert_details.sub_id = alert_sub.id');
		$builder->where('sp_id', $id);
		if($status > 0) {
		    $builder->where('status', $status); // 1 >> Unread, 2 >> Read
		}
		
		$builder->where('action', $type);
		$query = $builder->get();

		$res = $query->getResultArray();

		if ($res != null) {
			return $res;
		} else {
			return null;
		}
	}


	//--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------


}
