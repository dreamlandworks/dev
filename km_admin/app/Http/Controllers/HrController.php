<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HrController extends Controller
{
    //
    public function index()
    {
        $designation_data=Designation::where('deleted_at',NULL)->get();
        return view('designation-list',['designation'=>$designation_data]);
    }
    public function create_designation()
    {
        return view('create-designation');
    }
    public function edit_designation($designation)
    {
        $edit_designation=Designation::find($designation);

        return view('edit-designation',compact('edit_designation'));
    }
    public function store_designation(Request $request)
    {
        
    	$request->validate([
    		'department'=>'required',
    		'user_type'=>'required',
    		'pay'=>'required',
            'no_of_leave'=>'required',
            'designation'=>'required|array',
            'designation.0'=>'required|string',
    	   ],
           [
            'designation.0.required'=>'Please add atleast one designation.'
           ]
        );
        try
        {
            if(!empty($request->designation_id))
            {
                $desg_add='';
                foreach($request->designation as $new_desg)
                {
                    if(!empty($new_desg))
                    {
                        $desg_ar=trim($new_desg,' ');
                        $desg_add.=$desg_ar.',';
                    }
                }
                $editdesignation=Designation::find($request->designation_id);
                $editdesignation->department_name=$request->department;
                $editdesignation->user_type=$request->user_type;
                $editdesignation->pay=$request->pay;
                $editdesignation->no_of_leave=$request->no_of_leave;
                $editdesignation->designation=trim($desg_add,',');
                $editdesignation->save();
                return redirect('/hr')->with('success','Designation updated successfully.');
            }
            else
            {
                $desg_add='';
                foreach($request->designation as $new_desg)
                {
                    if(!empty($new_desg))
                    {
                        $desg_ar=trim($new_desg,' ');
                        $desg_add.=$desg_ar.',';
                    }
                }
                $new_desg=implode(',',$request->designation);
                $designation=new Designation;
                $designation->department_name=$request->department;
                $designation->user_type=$request->user_type;
                $designation->pay=$request->pay;
                $designation->no_of_leave=$request->no_of_leave;
                $designation->designation=trim($desg_add,',');
                $designation->save();
                return redirect('/hr')->with('success','Designation created successfully.');
            }

        }catch (\Exception $e) 
        {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    	
    }
    public function delete_designation($designation)
    {
        $deletedesignation=Designation::find($designation);
        $deletedesignation->deleted_at=Carbon::now();
        $deletedesignation->save();
        return redirect('/hr')->with('success','Designation Deleted successfully.');
    }

}
