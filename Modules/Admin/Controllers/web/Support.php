<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;
use Modules\Admin\Models\MiscSupportModel;

class Support extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function create_tickets()
	{
	    
	    $misc_model = new MiscSupportModel();
	    $arr_compliant_module  =  $misc_model->showAllCompliantModule(); 
		$data['arr_compliant_module']= $arr_compliant_module;
		$arr_users  =  $misc_model->showAllUsers(); 
		$data['arr_users']= $arr_users;
		$arr_staffs  =  $misc_model->showAllStaffs(); 
		$data['arr_staffs']= $arr_staffs;
		$arr_booking  =  $misc_model->showAllBooking(); 
		$data['arr_booking']= $arr_booking;
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\support\createTickets',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function create_ticket_submit()
	{
		
        //$complaint_id = $this->request->getVar('complaint_id');
        $created_on = $this->request->getVar('created_on');
        $booking = $this->request->getVar('booking');
        $description = $this->request->getVar('description');
        $module = $this->request->getVar('module');
        $priority = $this->request->getVar('priority');
        $assign_to = $this->request->getVar('assign_to');
        $status = $this->request->getVar('status');
       
       
        $tickets = new MiscSupportModel();
        $compliant_id = $tickets->add_compliant($created_on,$booking,$description,$module,$priority);
        // echo $compliant_id;
        // exit;
        
           $res = $tickets->add_compliant_status($compliant_id,$assign_to,$status,$created_on); 
    
        
        return redirect('ct/listAllTickets');
	}
	
	public function list_tickets()
	{
	    $misc_model = new MiscSupportModel();
	    $arr_supports  =  $misc_model->showAllSupport(); 
		$data['arr_supports']= $arr_supports;
		$arr_pending = $misc_model->showAllPendingTicketCount(); 
		$data['arr_pending']= $arr_pending;
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\support\listAllTickets',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function view_tickets()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\support\viewTickets');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	
	public function edit_tickets($id = null)
	{
	    $misc_model = new MiscSupportModel();
	    $arr_compliant_module  =  $misc_model->showAllCompliantModule(); 
		$data['arr_compliant_module']= $arr_compliant_module;
		$arr_users  =  $misc_model->showAllUsers(); 
		$data['arr_users']= $arr_users;
		$arr_staffs  =  $misc_model->showAllStaffs(); 
		$data['arr_staffs']= $arr_staffs;
		
		$arr_booking  =  $misc_model->showAllBooking(); 
		$data['arr_booking']= $arr_booking;
		
		$data['compliant'] =  $misc_model->getCompliant($id); 
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\support\editTickets',$data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
	
	public function edit_ticket_submit()
	{
	    $id = $this->request->getVar('compliant_id');
		//JSON Objects declared into variables
		$created_on = $this->request->getVar('created_on');
        $booking = $this->request->getVar('booking');
        $description = $this->request->getVar('description');
        $module = $this->request->getVar('module');
        $priority = $this->request->getVar('priority');
        $assign_to = $this->request->getVar('assign_to');
        $status = $this->request->getVar('status');
       
       $data = [
            'created_on' => $created_on,
            'booking_id' => $booking,
            'description' => $description,
            'module_id' => $module,
            'priority' => $priority
            ];
        $data2 = [
            'assigned_to' => $assign_to,
            'status' => $status,
            'created_on' => $created_on
            ];
        
        $misc_model = new MiscSupportModel();
        $res = $misc_model->updateCompliant($id, $data);
        $res = $misc_model->updateCompliant_status($id, $data2);
        return redirect('ct/listAllTickets');
	}
	
	public function delete_tickets()
	{
	    $misc_model = new MiscSupportModel();
		
        $compliant_id = service('request')->getPost('compliant_id');
        $res = $misc_model->deleteCompliant($compliant_id);
        $res = $misc_model->deleteCompliantStatus($compliant_id);
        echo $compliant_id;
    
	}


}
