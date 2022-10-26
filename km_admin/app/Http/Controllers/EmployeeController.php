<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\UserDetails;
use App\Models\User;

use File;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    //
    public function index()
    {
        $employee_detail=Employee::where('deleted_at',NULL)->get();
        $department_name=Designation::where('deleted_at',NULL)->get();
    	return view('employee-list',compact('employee_detail','department_name'));
    }
    public function create_employee()
    {
        $department=Designation::where('deleted_at',NULL)->get();
    	return view('create-employee',compact('department'));
    }
    public function edit_employee($emp_id)
    {
        $emp_det=Employee::where('id',$emp_id)->first();
        $department=Designation::where('deleted_at',NULL)->get();
        return view('edit-employee',compact('emp_det','department'));
    }
    public function delete($id)
    {
        $deleteemployee=Employee::find($id);
        $deleteemployee->deleted_at=Carbon::now();
        $deleteemployee->save();
        return redirect('/employee/list')->with('success','Employee Deleted successfully.');
    }
    public function store_employee(Request $request)
    {
        $request->validate([
            'name'                   => 'required',
            'father_name'            => 'required',
            'date_of_birth'          => 'required',
            'gender'                 => 'required',
            'mobile_no'              =>[
                    'required',
                    'digits:10',
                    'numeric',
                    Rule::unique('employee')
                ],
            'local_address'          => 'required',
            'permanent_address'      => 'required',
            'email'              =>[
                    'required',
                    'email',
                    'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/',
                    Rule::unique('employee')
                ],
            'password'               => 'required|min:8',
            'employee_id'            => 'required|unique:employee'
            // 'date_of_joining'        => 'required',
            // 'department'             => 'required',
            // 'designation'            => 'required',
            // 'joining_salery'         => 'required',
            // 'account_holder_name'    => 'required',
            // 'account_number'         => 'required',
            // 'bank_name'              => 'required',
            // 'ifsc_code'              => 'required',
            // 'pan_number'             => 'required',
            // 'branch'                 => 'required'
        ]);
        try
        {
            $employee=new Employee;
            $employee->name=$request->name;
            $employee->father_name=$request->father_name;
            $employee->date_of_birth=$request->date_of_birth;
            $employee->gender=$request->gender;
            $employee->mobile_no=$request->mobile_no;
            $employee->local_address=$request->local_address;
            $employee->permanent_address=$request->permanent_address;
            $employee->status=$request->status;
            $employee->email=$request->email;
            $employee->password=Hash::make($request->password);
            $employee->employee_id=$request->employee_id;
            $employee->date_of_joining=$request->date_of_joining;
            $employee->department=$request->department;
            $employee->designation=$request->designation;
            $employee->joining_salery=$request->joining_salery;
            $employee->account_holder_name=$request->account_holder_name;
            $employee->account_number=$request->account_number;
            $employee->bank_name=$request->bank_name;
            $employee->ifsc_code=$request->ifsc_code;
            $employee->pan_number=$request->pan_number;
            $employee->branch=$request->branch;

            $random_no=rand('000000','111111');
            $path= "employee/document";
            if($request->hasFile('photo'))
            {
                $photo = $request->file('photo');
                $photo_name='photo'.$random_no.'.'.$photo->extension();
                $photo->move(public_path().'/employee/document/',$photo_name);
                $employee->photo=$photo_name;
            }
            if($request->hasFile('resume'))
            {
                $resume = $request->file('resume');
                $resume_name='resume'.$random_no.'.'.$resume->extension();
                $resume->move(public_path().'/employee/document/',$resume_name);
                $employee->resume=$resume_name;
            }
            if($request->hasFile('offer_letter'))
            {
                $offer_letter = $request->file('offer_letter');
                $offer_letter_name='offer_letter'.$random_no.'.'.$offer_letter->extension();
                $offer_letter->move(public_path().'/employee/document/',$offer_letter_name);
                $employee->offer_letter=$offer_letter_name;
            }
            if($request->hasFile('joining_letter'))
            {
                $joining_letter = $request->file('joining_letter');
                $joining_letter_name='joining_letter'.$random_no.'.'.$joining_letter->extension();
                $joining_letter->move(public_path().'/employee/document/',$joining_letter_name);
                $employee->joining_letter=$joining_letter_name;
            }
            if($request->hasFile('contract_and_agreement'))
            {
                $contract_and_agreement = $request->file('contract_and_agreement');
                $contract_and_agreement_name='contract_and_agreement'.$random_no.'.'.$contract_and_agreement->extension();
                $contract_and_agreement->move(public_path().'/employee/document/',$contract_and_agreement_name);
                $employee->contract_and_agreement=$contract_and_agreement_name;
            }
            if($request->hasFile('id_proof'))
            {
                $id_proof = $request->file('id_proof');
                $id_proof_name='id_proof'.$random_no.'.'.$id_proof->extension();
                $id_proof->move(public_path().'/employee/document/',$id_proof_name);
                $employee->id_proof=$id_proof_name;   
            }
            $employee->document_path=$path;
            $employee->save();
            
            /// for employee login 
            
            $user_detail=new UserDetails;
            $user_detail->fname=$request->name;
            $user_detail->mobile=$request->mobile_no;
            $user_detail->dob=$request->date_of_birth;
            $user_detail->gender=$request->gender;
            
            if($request->hasFile('photo'))
            { 
                File::copy(public_path('/employee/document/'.$photo_name), public_path('/images/user_profile/'.$photo_name));
                $user_detail->profile_pic=$photo_name;
            }
            $user_detail->save();

            $emp_department_name=Designation::where('deleted_at',NULL)->where('id',$request->department)->first();

            $user=new User;
            $user->userid=$request->mobile_no;
            $user->password=Hash::make($request->password);
            $user->email=$request->email;
            $user->user_type=$emp_department_name->user_type;
            $user->business_id=$employee->id;
            $user->users_id=$user_detail->id;
            $user->save();

            /// end employee login
            
            if($employee)
            {
                return redirect('/employee/list')->with('success','Employee Created successfully.');
            }
            else
            {
                return redirect()->back()->with('error', "Failed to create employee profile.");
            }
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
    public function update_employee(Request $request)
    {
        $request->validate([
            'name'                   => 'required',
            'father_name'            => 'required',
            'date_of_birth'          => 'required',
            'gender'                 => 'required',
            'mobile_no'              =>[
                    'required',
                    'digits:10',
                    'numeric',
                    Rule::unique('employee')->ignore($request->id)
                ],
            'local_address'          => 'required',
            'permanent_address'      => 'required',
            'email'              =>[
                    'required',
                    'email',
                    'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/',
                    Rule::unique('employee')->ignore($request->id)
                ],
            //'password'               => 'required|min:8',
            'employee_id'            => [
                    'required',
                    Rule::unique('employee')->ignore($request->id)
                ]
            // 'date_of_joining'        => 'required',
            // 'department'             => 'required',
            // 'designation'            => 'required',
            // 'joining_salery'         => 'required',
            // 'account_holder_name'    => 'required',
            // 'account_number'         => 'required',
            // 'bank_name'              => 'required',
            // 'ifsc_code'              => 'required',
            // 'pan_number'             => 'required',
            // 'branch'                 => 'required'
        ]);

        try
        {
            $employee=Employee::find($request->id);
            $employee->name=$request->name;
            $employee->father_name=$request->father_name;
            $employee->date_of_birth=$request->date_of_birth;
            $employee->gender=$request->gender;
            $employee->mobile_no=$request->mobile_no;
            $employee->local_address=$request->local_address;
            $employee->permanent_address=$request->permanent_address;
            $employee->status=$request->status;
            $employee->email=$request->email;
            if(isset($request->password))
            {
                $employee->password=Hash::make($request->password);
            }
            $employee->employee_id=$request->employee_id;
            $employee->date_of_joining=$request->date_of_joining;
            $employee->department=$request->department;
            $employee->designation=$request->designation;
            $employee->joining_salery=$request->joining_salery;
            $employee->account_holder_name=$request->account_holder_name;
            $employee->account_number=$request->account_number;
            $employee->bank_name=$request->bank_name;
            $employee->ifsc_code=$request->ifsc_code;
            $employee->pan_number=$request->pan_number;
            $employee->branch=$request->branch;

            $random_no=rand('000000','111111');
            $path= "employee/document";
            if($request->hasFile('photo'))
            {
                $photo = $request->file('photo');
                $photo_name='photo'.$random_no.'.'.$photo->extension();
                $photo->move(public_path().'/employee/document/',$photo_name);
                $employee->photo=$photo_name;
            }
            if($request->hasFile('resume'))
            {
                $resume = $request->file('resume');
                $resume_name='resume'.$random_no.'.'.$resume->extension();
                $resume->move(public_path().'/employee/document/',$resume_name);
                $employee->resume=$resume_name;
            }
            if($request->hasFile('offer_letter'))
            {
                $offer_letter = $request->file('offer_letter');
                $offer_letter_name='offer_letter'.$random_no.'.'.$offer_letter->extension();
                $offer_letter->move(public_path().'/employee/document/',$offer_letter_name);
                $employee->offer_letter=$offer_letter_name;
            }
            if($request->hasFile('joining_letter'))
            {
                $joining_letter = $request->file('joining_letter');
                $joining_letter_name='joining_letter'.$random_no.'.'.$joining_letter->extension();
                $joining_letter->move(public_path().'/employee/document/',$joining_letter_name);
                $employee->joining_letter=$joining_letter_name;
            }
            if($request->hasFile('contract_and_agreement'))
            {
                $contract_and_agreement = $request->file('contract_and_agreement');
                $contract_and_agreement_name='contract_and_agreement'.$random_no.'.'.$contract_and_agreement->extension();
                $contract_and_agreement->move(public_path().'/employee/document/',$contract_and_agreement_name);
                $employee->contract_and_agreement=$contract_and_agreement_name;
            }
            if($request->hasFile('id_proof'))
            {
                $id_proof = $request->file('id_proof');
                $id_proof_name='id_proof'.$random_no.'.'.$id_proof->extension();
                $id_proof->move(public_path().'/employee/document/',$id_proof_name);
                $employee->id_proof=$id_proof_name;
                
            }
            $employee->document_path=$path;
            $employee->save();
            
            /// for employee login
            $getuser= User::where('business_id',$request->id)->first();
            if(!empty($getuser))
            {
                $user_detail=UserDetails::find($getuser->users_id);
                $user_detail->fname=$request->name;
                $user_detail->mobile=$request->mobile_no;
                $user_detail->dob=$request->date_of_birth;
                $user_detail->gender=$request->gender;
                
                if($request->hasFile('photo'))
                { 
                    File::copy(public_path('/employee/document/'.$photo_name), public_path('/images/user_profile/'.$photo_name));
                    $user_detail->profile_pic=$photo_name;
                }
                $user_detail->save();
            }
            else
            {
                $user_detail=new UserDetails;
                $user_detail->fname=$request->name;
                $user_detail->mobile=$request->mobile_no;
                $user_detail->dob=$request->date_of_birth;
                $user_detail->gender=$request->gender;
                
                if($request->hasFile('photo'))
                { 
                    File::copy(public_path('/employee/document/'.$photo_name), public_path('/images/user_profile/'.$photo_name));
                    $user_detail->profile_pic=$photo_name;
                }
                $user_detail->save(); 
            }

            $emp_department_name=Designation::where('deleted_at',NULL)->where('id',$request->department)->first();


            $user=User::where('business_id',$request->id)->first();
            if(!empty($user))
            {
                $user->userid=$request->mobile_no;
                if(isset($request->password))
                {
                    $user->password=Hash::make($request->password);
                }
                $user->email=$request->email;
                $user->user_type=$emp_department_name->user_type;
                $user->save();
            }
            else
            {
                $user=new User;
                $user->userid=$request->mobile_no;
                $user->password=Hash::make($request->password);
                $user->email=$request->email;
                $user->user_type=$emp_department_name->user_type;
                $user->business_id=$employee->id;
                $user->users_id=$user_detail->id;
                $user->save();
            }

            /// end employee login
            
            if($employee)
            {
                return redirect('/employee/list')->with('success','Employee updated successfully.');
            }
            else
            {
                return redirect()->back()->with('error', "Failed to update employee profile.");
            }    
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
    public function filter(Request $request)
    {
        $designation_value=Designation::where('deleted_at',NULL)->where('id',$request->designation_id)->first();
        return $designation_value->designation;
    }
    public function create_attendence()
    {
        $employee_detail=Employee::get();
        return view('create-attendence',compact('employee_detail'));
    }
    public function view_attendence()
    {
        return view('attendence-list');
    }
}
