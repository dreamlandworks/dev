<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Attendence;
use App\Models\Leads;
use App\Models\MarketPlan;
use App\Models\Booking;
use App\Models\PostJob;
use App\Models\PerformanceReport;
use App\Models\WithdrawRequest;
use App\Models\Transaction;
use App\Models\Ticket;


use Carbon\Carbon;

class DashboardController extends Controller
{
    //
    public function dashboard()
    {
    	$user = auth()->user();
    	if($user->user_type=="HR")
    	{
    		$employee_array=array();
    		$top_performer=array();
    		$temp_array=array();
    		$Unsatisfactory=1;
    		$Satisfactory=2;
    		$Good=3;
    		$Excellent=4;

    		//maximum performance point(4)* total no.of performance factor(6)=24(total count) 
    		$total_count=24;

    		$total_employee=Employee::where('deleted_at',NULL)->count();
    		$present_employee=Attendence::where('date',date('Y-m-d'))->where('status','Present')->count();
    		$absent_employee=Attendence::where('date',date('Y-m-d'))->where('status','Absent')->count();
    		$employee=Employee::where('deleted_at',NULL)->OrderBy('id','DESC')->get();
    		foreach($employee as $key=>$value)
    		{
    			$performance1=0;
	    		$performance2=0;
	    		$performance3=0;
	    		$performance4=0;
	    		$performance5=0;
	    		$performance6=0;
	    		$employee_array[$key]['performance']="Not Found";
	    		$employee_array[$key]['created_at']='';

    			$employee_array[$key]['id']=$value->id;
    			$employee_array[$key]['document_path']=$value->document_path;
    			$employee_array[$key]['photo']=$value->photo;
    			$employee_array[$key]['name']=$value->name;
    			$employee_array[$key]['designation']=$value->designation;
    			$emp_performance=PerformanceReport::where('deleted_at',NULL)->where('employee_name',$value->id)->OrderBy('id','DESC')->first();
    			
    			// ${$variable_name} this is reference variable
    			if(isset($emp_performance->employee_name))
    			{
    				if(isset($emp_performance->work_to_full_potential))
    				{
    					$work_to_full_potential=$emp_performance->work_to_full_potential;
    					$performance1=${$work_to_full_potential};
    				}
    				if(isset($emp_performance->communication))
    				{
    					$communication=$emp_performance->communication;
    					$performance2=${$communication};
    				}
    				if(isset($emp_performance->productivity))
    				{
    					$productivity=$emp_performance->productivity;
    					$performance3=${$productivity};
    				}
    				if(isset($emp_performance->punctuality))
    				{
    					$punctuality=$emp_performance->punctuality;
    					$performance4=${$punctuality};
    				}
    				if(isset($emp_performance->attendence))
    				{
    					$attendence=$emp_performance->attendence;
    					$performance5=${$attendence};
    				}
    				if(isset($emp_performance->technical_Skills))
    				{
    					$technical_Skills=$emp_performance->technical_Skills;
    					$performance6=${$technical_Skills};
    				}
    				$performance=floor((($performance1+$performance2+$performance3+$performance4+$performance5+$performance6)/$total_count)*100);

    				$top_performer[$emp_performance->employee_name]=$performance;
    				$temp_array[$performance]=$emp_performance->employee_name;
    				asort($top_performer,SORT_NUMERIC);


					$employee_array[$key]['performance']=$performance;

					$employee_array[$key]['created_at']=$emp_performance->created_at;

    			}
    		}
    		return view('hr-dashboard',compact('employee','total_employee','present_employee','absent_employee','employee_array','total_count','emp_performance','top_performer','temp_array'));
    	}
    	if($user->user_type=="Marketing")
    	{
    		$leads=Leads::where('deleted_at',NULL)->count();
    		$today_leads=Leads::where('deleted_at',NULL)->where('created_at','LIKE',date("Y-m-d").'%')->count();
    		//$datewise_leads=Leads::where('deleted_at',NULL)->count();
    		$campaign=MarketPlan::where('deleted_at',NULL)->count();
    		return view('marketing-dashboard',compact('leads','campaign','today_leads'));
    	}
    	if($user->user_type=="Account")
    	{
    		$pending_withdraw=WithdrawRequest::where('status','Pending')->count();
    		$completed_withdraw=WithdrawRequest::where('status','Completed')->count();
    		$rejected_withdraw=WithdrawRequest::where('status','')->count();
    		$today_income=Transaction::where('date',date('Y-m-d'))->where('type_id',1)->sum('amount');
    		$total_income=Transaction::where('type_id',1)->sum('amount');
    		$today_expenditure=Transaction::where('date',date('Y-m-d'))->where('type_id',2)->sum('amount');
    		$total_expenditure=Transaction::where('type_id',2)->sum('amount');
    		$booking_income=Transaction::where('type_id',1)->where('name_id',2)->sum('amount');
    		$subscription_income=Transaction::where('type_id',1)->where('name_id',11)->sum('amount');
    		$misc_income=Transaction::where('type_id',1)->where('name_id','!=',2)->where('name_id','!=',11)->sum('amount');
    		$booking_expenditure=Transaction::where('type_id',2)->where('name_id',2)->sum('amount');
    		$subscription_expenditure=Transaction::where('type_id',2)->where('name_id',11)->sum('amount');
    		$misc_expenditure=Transaction::where('type_id',2)->where('name_id','!=',2)->where('name_id','!=',11)->sum('amount');
    		$this_month_income=Transaction::where('date','LIKE',date('Y-m').'%')->where('type_id',1)->sum('amount');
    		$this_month_expenditure=Transaction::where('date','LIKE',date('Y-m').'%')->where('type_id',2)->sum('amount');
    		return view('account-dashboard',compact('pending_withdraw','completed_withdraw','rejected_withdraw','today_income','today_expenditure','total_income','total_expenditure','booking_income','subscription_income','misc_income','booking_expenditure','subscription_expenditure','misc_expenditure','this_month_income','this_month_expenditure'));
    	}
    	if($user->user_type=="Support")
    	{
    		$pending_ticket=Ticket::where('deleted_at',NULL)->where('present_status','Pending')->count();
    		$inprogress_ticket=Ticket::where('deleted_at',NULL)->where('present_status','Inprogress')->count();
    		$resolved_ticket=Ticket::where('deleted_at',NULL)->where('present_status','Resolved')->count();
    		$overdue_ticket=Ticket::where('deleted_at',NULL)->where('present_status','Overdue')->count();
    		$overdue_ticket_list=Ticket::where('deleted_at',NULL)->where('present_status','Overdue')->get();
    		return view('support-dashboard',compact('pending_ticket','inprogress_ticket','resolved_ticket','overdue_ticket','overdue_ticket_list'));
    	}
    	if(($user->user_type=="Super Admin") ||($user->user_type=="Operation"))
    	{
    		$total_employee=Employee::where('deleted_at',NULL)->count();
    		$total_single_booking=Booking::where('category_id',1)->count();
    		$total_blue_collor_booking=Booking::where('category_id',2)->count();
    		$today_income=Transaction::where('date',date('Y-m-d'))->where('type_id',1)->sum('amount');
    		$total_income=Transaction::where('type_id',1)->sum('amount');
    		$today_expenditure=Transaction::where('date',date('Y-m-d'))->where('type_id',2)->sum('amount');
    		$total_expenditure=Transaction::where('type_id',2)->sum('amount');
    		$present_employee=Attendence::where('date',date('Y-m-d'))->where('status','Present')->count();
    		$absent_employee=Attendence::where('date',date('Y-m-d'))->where('status','Absent')->count();
    		return view('dashboard',compact('total_employee','total_single_booking','total_blue_collor_booking','today_income','total_income','today_expenditure','total_expenditure','present_employee','absent_employee'));
    	}

    	
    }

}
