<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;

use Modules\Admin\Models\MiscModel;

class Bookings extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function create_booking()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\bookings\createNewBooking');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function list_booking()
	{
		$misc_model = new MiscModel();
		
		$arr_bookings =  $misc_model->showAllBookings(); 
		$data['arr_bookings'] = $arr_bookings;
		
		$arr_bookingStatusCount =  $misc_model->getBookingStatusCount(); 
		$data['arr_bookingStatusCount'] = $arr_bookingStatusCount;
		
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\bookings\listBooking', $data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function booking_inprogress()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\bookings\bookingsInProgress');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function booking_completed()
	{
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\bookings\bookingCompleted');
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	
	public function single_move_form()
	{
		$misc_model = new MiscModel();
		
        $data['arr_timeSlots'] = $misc_model->showAllTimeSlots();
		
		$data['arr_users'] = $misc_model->showAllUsers();
		
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\bookings\singleMoveForm', $data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function multi_move_form()
	{
		$misc_model = new MiscModel();
		
        $data['arr_timeSlots'] = $misc_model->showAllTimeSlots();
		
		$data['arr_users'] = $misc_model->showAllUsers();
		
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\bookings\multiMoveForm', $data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function blue_collor_form()
	{
		$misc_model = new MiscModel();
		
        $data['arr_timeSlots'] = $misc_model->showAllTimeSlots();
		
		$data['arr_users'] = $misc_model->showAllUsers();
		
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\bookings\blueCollorForm', $data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function list_booking_view($id = null)
	{
		$misc_model = new MiscModel();		
		$data['bookingDetail'] =  $misc_model->showBookingByID($id); 
		
		// echo view('\Modules\Admin\Views\_layout\header');
		// echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\_layout\\template2'); 
		echo view('\Modules\Admin\Views\bookings\listBookingView', $data);
		// echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function delete_booking()
	{
	     $misc_model = new MiscModel();
		
        $booking_id = service('request')->getPost('booking_id');
        $res = $misc_model->deleteBooking($booking_id);
        echo $booking_id;
    
	}
	
	public function create_singleMoveForm_submit()
	{
		//$session = \Config\Services::session();		
		$apiconfig = new \Config\ApiConfig();
		
        //JSON Objects declared into variables
		$data = array();
		$data['key'] = "BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL";//$apiconfig->user_key; 
		$data['users_id'] = $this->request->getVar('singleMoveForm_userID');
        $data['scheduled_date'] = $this->request->getVar('singleMoveForm_date');
		$data['time_slot_from'] = $this->request->getVar('singleMoveForm_time');
		$data['time_slot_to'] = date('H:i:s',strtotime('+1 hour',strtotime($data['time_slot_from'])));;
        $data['started_at'] = "0000-00-00 00:00:00";
		$data['amount'] = 0;
		$data['cgst'] = 0;
		$data['sgst'] = 0;
		$data['sp_id'] = 1;
		$data['created_on'] = date("Y-m-d H:i:s");
		$data['estimate_time'] = 1;
		$data['estimate_type_id'] = 1;		
		$data['job_description'] = $this->request->getVar('singleMoveForm_jobDescription');
		$data['address_id'] = 0;
		$data['temp_address_id'] = 0;		
		$data['address'] = $this->request->getVar('singleMoveForm_address');
		$data['postal_code'] = $this->request->getVar('singleMoveForm_zipCode');
		$data['city'] = $this->request->getVar('singleMoveForm_city');
		$data['state'] = $this->request->getVar('singleMoveForm_state');
		$data['country'] = $this->request->getVar('singleMoveForm_country');
		$data['user_lat'] = "";
		$data['user_long'] = "";
		 
		$attach = array();
		$attach[0] =	$this->request->getFile('singleMoveForm_attachments');
		
		$data['attachments'] = $attach;
		
		$url = "http://dev.satrango.com/user/single_move_booking";
		
		$postdata = json_encode($data);
			
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);
		//print_r ($result);
		
		$resData = json_decode($result);
		
        if($resData->message == "Success") 
		{
			return redirect('ct/listBooking');
		}
		else
		{
			print_r ($result);
			exit;
		}
	}
	
	
	public function create_blueCollorForm_submit()
	{
		//$session = \Config\Services::session();		
		$apiconfig = new \Config\ApiConfig();
 
        //JSON Objects declared into variables
		$data = array();
		$data['key'] = "BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL";//$apiconfig->user_key; 
		$data['users_id'] = $this->request->getVar('blueCollorForm_userID');
        $data['scheduled_date'] = $this->request->getVar('blueCollorForm_date');
		$data['time_slot_from'] = $this->request->getVar('blueCollorForm_time');
		$data['time_slot_to'] = date('H:i:s',strtotime('+1 hour',strtotime($data['time_slot_from'])));;
        $data['started_at'] = "0000-00-00 00:00:00";
		$data['amount'] = 0;
		$data['sp_id'] = 1;
		$data['created_on'] = date("Y-m-d H:i:s");
		$data['estimate_time'] = 1;
		$data['estimate_type_id'] = 1;
		$data['job_description'] = $this->request->getVar('blueCollorForm_jobDescription');
		$data['cgst'] = 0;
		$data['sgst'] = 0;	
		
		$attach = array();
		$attach[0] =	$this->request->getFile('blueCollorForm_attachments');		
		$data['attachments'] = $attach;
		
		$url = "http://dev.satrango.com/user/blue_collar_booking";
		
		$postdata = json_encode($data);
			
		$ch = curl_init($url); 
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		$result = curl_exec($ch);
		curl_close($ch);
		//print_r ($result);
		
		$resData = json_decode($result);
		
        if($resData->message == "Success") 
		{
			return redirect('ct/listBooking');
		}
		else
		{
			print_r ($result);
			exit;
		}
	}
	
	
	public function create_multiMoveForm_submit()
	{
		print_r($this->request);
		exit;
	}
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
