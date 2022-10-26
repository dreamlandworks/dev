<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\Attendence;
use App\Models\PerformanceReport;
use App\Models\RelieveLetter;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AttendenceController extends Controller
{
    //// attendence
	public function view_attendence()
    {
        $employee=Employee::where('deleted_at',NULL)->get();
        $employee_attendence=Attendence::groupBy('emp_id')->get();
        return view('attendence-list',compact('employee','employee_attendence'));
    }
    public function view_each_attendence()
    {
        $employee_attendence=Attendence::where('date',date('Y-m-d'))->get();
        $present_employee=Attendence::where('date',date('Y-m-d'))->where('status','Present')->count();
        $absent_employee=Attendence::where('date',date('Y-m-d'))->where('status','Absent')->count();
        return view('each-date-attendence',compact('employee_attendence','present_employee','absent_employee'));
    }
    public function each_date_attendence(Request $request)
    {
        $employee_attendence=Attendence::where('date',$request->select_date)->get();
        $present_employee=Attendence::where('date',$request->select_date)->where('status','Present')->count();
        $absent_employee=Attendence::where('date',$request->select_date)->where('status','Absent')->count();
        $employee_attendence_detail=array();
        foreach($employee_attendence as $key=>$value)
        {
            $employee_det=Employee::where('deleted_at',NULL)->where('id',$value->emp_id)->first();
            $employee_attendence_detail[$key]['employee_id']=$employee_det->employee_id;
            $employee_attendence_detail[$key]['name']=$employee_det->name;
            $employee_attendence_detail[$key]['document_path']=$employee_det->document_path;
            $employee_attendence_detail[$key]['photo']=$employee_det->photo;
            $employee_attendence_detail[$key]['date']=$value->date;
            $employee_attendence_detail[$key]['status']=$value->status;
        }
        return compact('employee_attendence_detail','present_employee','absent_employee');
    }
    public function each_attendence($emp_id)
    {
        $employee_attendence=Attendence::where('emp_id',$emp_id)->get();
        if(count($employee_attendence)>0)
        {
            return view('each-attendence-list',compact('employee_attendence'));
        }
        else
        {
            return redirect()->back()->with('error','No records found !');
        }
    }
    public function create_attendence()
    {
        $employee_detail=Employee::where('deleted_at',NULL)->get();
        return view('create-attendence',compact('employee_detail'));
    }
    public function store_attendence(Request $request)
    {
        try
        {
            $counter=0;
            $check_date=Attendence::where('date',$request->today_date)->get();
            foreach(($check_date) as $key=>$value)
            {
                if(($value->date)==$request->today_date)
                {
                    $counter++;
                    $emp_status="status_$key";
                    $attendence=Attendence::find($value->id);
                    $attendence->emp_id=$request->id[$key];
                    $attendence->date=$request->today_date;
                    $attendence->status=$request->$emp_status;
                    $attendence->type_of_leave=$request->type_of_leave[$key];
                    $attendence->reason=$request->reason[$key];
                    $attendence->save();
                }
            }
            if($counter==0)
            {   
                foreach(($request->id) as $key=>$value)
                {
                    $emp_status="status_$key";
                    $attendence=new Attendence;
                    $attendence->emp_id=$request->id[$key];
                    $attendence->date=$request->today_date;
                    $attendence->status=$request->$emp_status;
                    $attendence->type_of_leave=$request->type_of_leave[$key];
                    $attendence->reason=$request->reason[$key];
                    $attendence->save();
                }
            }
            if($attendence)
            {
                return redirect('/attendence/list')->with('success','Attendence marked successfully!');
            }
            else
            {
                return redirect()->back()->with('error','Failed to mark attendence!');
            }
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
    public function filter_attendence(Request $request)
    {
        $filter_data=Attendence::where('date','like','%'.$request->select_date.'%')->where('emp_id',$request->emp_id)->get();
        return $filter_data;
    }
    ///end attendence


    // employee performance

    public function fetchEmpDet(Request $request)
    {
        $employee_detail=Employee::where('deleted_at',NULL)->where('id',$request->emp_id)->first();
        $department=Designation::where('id',$employee_detail->department)->first();
        $employee_id=$employee_detail->employee_id;
        $empDepartment='<option value='.$employee_detail->department.' selected>'.$department->department_name.'</option>';
        $empDesignation='<option value='.$employee_detail->designation.' selected>'.$employee_detail->designation.'</option>';
        $joining_date=$employee_detail->date_of_joining;

        return compact('employee_id','empDepartment','empDesignation','joining_date');
    }
    public function view_performance()
    {
        $performance_list=PerformanceReport::where('deleted_at',NULL)->get();
        
        return view('perf-report-list',compact('performance_list'));
    }
    public function create_performance()
    {
        $employee_detail=Employee::where('deleted_at',NULL)->get();
        $department=Designation::where('deleted_at',NULL)->get();
        return view('create-perf-report',compact('department','employee_detail'));
    }
    public function edit_performance($performance_id)
    {
        $employeePerformance=PerformanceReport::where('id',$performance_id)->where('deleted_at',NULL)->first();
        $employee_detail=Employee::where('deleted_at',NULL)->get();
        $department=Designation::where('deleted_at',NULL)->get();
        return view('edit-perf-report',compact('department','employee_detail','employeePerformance'));
    }
    public function delete_performance($performance_id)
    {
        $employee_delete=PerformanceReport::find($performance_id);
        $employee_delete->deleted_at=Carbon::now();
        $employee_delete->save();
        return redirect('/performance/list')->with('success','Performance report Deleted successfully.');
    }
    
    public function storePreformanceReport(Request $request)
    {
        $request->validate([
            'employee_name' =>'required',
            'employee_id' =>'required',
            'department' =>'required',
            'designation' =>'required',
            'joining_date' =>'required',
            'period_from' =>'required',
            'period_to' =>'required',
        ]);
        try
        {
            //$check_report=PerformanceReport::where('employee_name',$request->employee_name)->where('period_from',$request->period_from)->where('period_to',$request->period_to)->where('deleted_at',NULL)->first();
            $checking_report=PerformanceReport::where('employee_name',$request->employee_name)->where('deleted_at',NULL)->get();
            foreach($checking_report as $new_val)
            {
                $check_report=PerformanceReport::where('employee_name',$request->employee_name)->whereBetween('period_from',[$new_val->period_from,$request->period_from])->whereBetween('period_to',[$request->period_to,$new_val->period_to])->where('deleted_at',NULL)->first();

                if(!empty($check_report))
                {
                    if($request->employee_name==$check_report->employee_name)
                    {
                        return redirect()->back()->with('error','Report already submitted.');
                    }
                }
                
            }
            $performance=new PerformanceReport;
            $performance->employee_name=$request->employee_name;
            $performance->employee_id=$request->employee_id;
            $performance->department=$request->department;
            $performance->designation=$request->designation;
            $performance->joining_date=$request->joining_date;
            $performance->period_from=$request->period_from;
            $performance->period_to=$request->period_to;
            $performance->reviewer_name=$request->reviewer_name;
            $performance->date_of_review=$request->date_of_review;
            $performance->preformance_in_brief=$request->preformance_in_brief;
            $performance->work_to_full_potential=$request->work_feedback;
            $performance->communication=$request->communication_feedback;
            $performance->productivity=$request->productive_feedback;
            $performance->punctuality=$request->punctuality_feedback;
            $performance->attendence=$request->attendence_feedback;
            $performance->technical_Skills=$request->tech_skill_feedback;
            $performance->save();

            if($performance)
            {
                return redirect('/performance/list')->with('success','Performance report created successfully!');
            }
            else
            {
                return redirect()->back()->with('error', "Failed to created Performance report");
            } 
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function update_performance(Request $request)
    {
        $request->validate([
            'employee_name' => 'required',
            'employee_id' =>'required',
            'department' =>'required',
            'designation' =>'required',
            'joining_date' =>'required',
            'period_from' =>'required',
            'period_to' =>'required',
        ]);
        try
        {
            //$check_report=PerformanceReport::where('employee_name',$request->employee_name)->where('period_from',$request->period_from)->where('period_to',$request->period_to)->where('deleted_at',NULL)->where('id','!=',$request->performance_id)->first();
            $checking_report=PerformanceReport::where('employee_name',$request->employee_name)->where('deleted_at',NULL)->get();
            foreach($checking_report as $new_val)
            {
                $check_report=PerformanceReport::where('employee_name',$request->employee_name)->whereBetween('period_from',[$new_val->period_from,$request->period_from])->whereBetween('period_to',[$request->period_to,$new_val->period_to])->where('deleted_at',NULL)->where('id','!=',$request->performance_id)->first();

                if(!empty($check_report))
                {
                    if($request->employee_name==$check_report->employee_name)
                    {
                        return redirect()->back()->with('error','Report already submitted.');
                    }
                }
            }

            $performance=PerformanceReport::find($request->performance_id);
            $performance->employee_name=$request->employee_name;
            $performance->employee_id=$request->employee_id;
            $performance->department=$request->department;
            $performance->designation=$request->designation;
            $performance->joining_date=$request->joining_date;
            $performance->period_from=$request->period_from;
            $performance->period_to=$request->period_to;
            $performance->reviewer_name=$request->reviewer_name;
            $performance->date_of_review=$request->date_of_review;
            $performance->preformance_in_brief=$request->preformance_in_brief;
            $performance->work_to_full_potential=$request->work_feedback;
            $performance->communication=$request->communication_feedback;
            $performance->productivity=$request->productive_feedback;
            $performance->punctuality=$request->punctuality_feedback;
            $performance->attendence=$request->attendence_feedback;
            $performance->technical_Skills=$request->tech_skill_feedback;
            $performance->save();

            if($performance)
            {
                return redirect('/performance/list')->with('success','Performance report updated successfully!');
            }
            else
            {
                return redirect()->back()->with('error', "Failed to update Performance report");
            } 
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error',$bug);
        }
    }
    ///end performance report
    public function filter(Request $request)
    {
        $designation_value=Designation::where('deleted_at',NULL)->where('id',$request->designation_id)->first();
        return $designation_value->designation;
    }
     //////  relieve letter 

    public function view_relieve()
    {
        $employee_relieve=RelieveLetter::where('deleted_at',NULL)->get();
        $relieved_employee=array();
        foreach($employee_relieve as $key=>$relieve)
        {
            $employee_detail=Employee::where('id',$relieve->employee_name)->first();
            $department=Designation::where('id',$employee_detail->department)->first();
            $relieved_employee[$key]['id']=$relieve->id;
            $relieved_employee[$key]['employee_id']=$employee_detail->employee_id;
            $relieved_employee[$key]['employee_name']=$employee_detail->name;
            $relieved_employee[$key]['designation']=$employee_detail->designation;
            $relieved_employee[$key]['department']=$department->department_name;
            $relieved_employee[$key]['date_of_relieving']=$relieve->date_of_relieving;
        }
        return view('employee-relieve-list',compact('relieved_employee'));
    }
    public function create_relieve()
    {
        $employee_detail=Employee::where('deleted_at',NULL)->get();
        $department=Designation::where('deleted_at',NULL)->get();
        return view('create-emp-relieve',compact('department','employee_detail'));
    }
    public function edit_relieve($relieve_id)
    {
        $employee_detail=Employee::where('deleted_at',NULL)->get();
        $department=Designation::where('deleted_at',NULL)->get();
        $employee_relieve=RelieveLetter::where('id',$relieve_id)->where('deleted_at',NULL)->first();
        return view('edit-emp-relieve',compact('department','employee_detail','employee_relieve'));
    }
    public function store_relieve(Request $request)
    {
        $request->validate([
            'employee_name'    => 'required',
            'date_of_relieving'  => 'required',

        ]);
        try
        {
            $relieve=new RelieveLetter;
            $relieve->employee_name=$request->employee_name;
            $relieve->employee_id=$request->employee_id;
            $relieve->department=$request->department;
            $relieve->designation=$request->designation;
            $relieve->joining_date=$request->joining_date;
            $relieve->date_of_relieving=$request->date_of_relieving;

            $random_no=rand('000000','111111');
            if($request->hasFile('resignation_letter'))
            {
                $file=$request->file('resignation_letter');
                $file_name='relieve'.$random_no.'.'.$file->extension();
                $file->move(public_path().'/employee/relieve/',$file_name);
                $relieve->resignation_letter=$file_name;    
            }

            $relieve->relieve_content=$request->relieve_content;
            $relieve->save();

            if($relieve)
            {
                return redirect('/relieve/list')->with('success','Relieve letter created successfully!');
            }
            else
            {
                return redirect()->back()->with('error','Failed to create!');
            }
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error',$bug);
        }
    }
    public function update_relieve(Request $request)
    {
        $request->validate([
            'employee_name'    => 'required',
            'date_of_relieving'  => 'required',

        ]);
        try
        {
            $relieve=RelieveLetter::find($request->emp_relieve_id);
            $relieve->employee_name=$request->employee_name;
            $relieve->employee_id=$request->employee_id;
            $relieve->department=$request->department;
            $relieve->designation=$request->designation;
            $relieve->joining_date=$request->joining_date;
            $relieve->date_of_relieving=$request->date_of_relieving;

            $random_no=rand('000000','111111');
            if($request->hasFile('resignation_letter'))
            {
                $file=$request->file('resignation_letter');
                $file_name='relieve'.$random_no.'.'.$file->extension();
                $file->move(public_path().'/employee/relieve/',$file_name);
                $relieve->resignation_letter=$file_name;    
            }

            $relieve->relieve_content=$request->relieve_content;
            $relieve->save();

            if($relieve)
            {
                return redirect('/relieve/list')->with('success','Relieve letter Updated successfully!');
            }
            else
            {
                return redirect()->back()->with('error','Failed to update!');
            }
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error',$bug);
        }
    }
    public function delete_relieve($relieve_id)
    {
        $delete_relieve=RelieveLetter::find($relieve_id);
        $delete_relieve->deleted_at=Carbon::now();
        $delete_relieve->save();
        return redirect('/relieve/list')->with('success','Relieved Employee Deleted successfully!');
    }
    
    /// end relieve letter
    
}
