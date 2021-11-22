<?php

namespace Modules\Admin\Controllers\web;

use App\Controllers\BaseController;

class Bookings extends BaseController
{
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function create_booking()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\bookings\createNewBooking');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function list_booking()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\bookings\listBooking');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function booking_inprogress()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\bookings\bookingsInProgress');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function booking_completed()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\bookings\bookingCompleted');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	
	public function single_move_form()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\bookings\singleMoveForm');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function multi_move_form()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\bookings\multiMoveForm');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function blue_collor_form()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\bookings\blueCollorForm');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
