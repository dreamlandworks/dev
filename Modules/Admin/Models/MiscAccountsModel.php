<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class MiscAccountsModel extends Model
{
    
    public function showAllReceipts()
	{
		$builder = $this->db->table('transaction');
        $builder->select('transaction.amount as Amount,transaction.id,reference_id,user_details.fname,user_details.lname,transaction_name.name,transaction_methods.name as methodName,transaction_methods.description,booking.id as booking_id');
        $builder->join('user_details', 'user_details.id = transaction.users_id','left');
        $builder->join('booking', 'booking.id = transaction.booking_id','left');
        $builder->join('transaction_methods', 'transaction_methods.id = transaction.method_id','left');
        $builder->join('transaction_name', 'transaction_name.id = transaction.name_id','left');
        
        $builder->where('type_id', 1);
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
	
	
	public function showAllPaymentDone()
	{
		$builder = $this->db->table('transaction');
        $builder->select('transaction.amount as Amount,transaction.id,transaction.date,transaction.payment_status,reference_id,user_details.fname,user_details.lname,transaction_name.name,transaction_methods.name as methodName,transaction_methods.description,booking.id as booking_id');
        $builder->join('user_details', 'user_details.id = transaction.users_id','left');
        $builder->join('booking', 'booking.id = transaction.booking_id','left');
        $builder->join('transaction_methods', 'transaction_methods.id = transaction.method_id','left');
        $builder->join('transaction_name', 'transaction_name.id = transaction.name_id','left');
        
        $builder->where('type_id', 2);
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
	
	
	public function showAllPaymentRequest()
	{
		$builder = $this->db->table('withdraw_request');
        $builder->select('withdraw_request.amount as Amount,transaction.id,transaction.date,reference_id,user_details.fname,user_details.lname,transaction_name.name,transaction_methods.name as methodName,transaction_methods.description,withdraw_request.status');
        $builder->join('user_details', 'user_details.id = withdraw_request.users_id','left');
        $builder->join('transaction', 'transaction.id = withdraw_request.transaction_id','left');
        $builder->join('booking', 'booking.id = transaction.booking_id','left');
        $builder->join('transaction_methods', 'transaction_methods.id = transaction.method_id','left');
        $builder->join('transaction_name', 'transaction_name.id = transaction.name_id','left');
        
        $builder->where('withdraw_request.status', 'Pending');
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
	
	
}