<?php

namespace App\Http\Controllers;

use App\Models\Leads;
use App\Models\spQualification;
use Illuminate\Http\Request;
use Carbon\Carbon;


class LeadsController extends Controller
{
    public function index()
    {
        $leads = Leads::where('deleted_at',NULL)->get();
        $qualifications = spQualification::get();
        return view('leads-list',["leads"=>$leads,"qualification"=>$qualifications]);
    }
    public function create()
    {
        try
        {
            $qual = spQualification::get();
            return view('create-lead',["qualifications"=>$qual]);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);

        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required | email',
            'mobile' => 'required|numeric',
            'city' => 'required',
            'gender' => 'required',
            'age_group' => 'required'
        ]);
        try
        {

            $leads = new Leads;
            $leads->fname = $request->fname;
            $leads->lname = $request->lname;
            $leads->email = $request->email;
            $leads->mobile = $request->mobile;
            $leads->city = $request->city;
            $leads->occupation = $request->occupation;
            $leads->qualification = json_encode($request->qualification);
            $leads->gender = $request->gender;
            $leads->age_group = $request->age_group;
            $leads->hobbies = $request->hobbies;
            $leads->save();

            if($leads){
                return redirect('leads-list')->with('success', 'Leads Create Successfully !');
            }else{
                return redirect('leads-list')->with('error', 'Failed to create Leads ! Try again.');
            }

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);
        }

    }

    public function edit($id)
    {
        try
        {
            $qualifications = spQualification::get();
            $leads  = Leads::find($id);
            return view('edit-lead',compact('leads','qualifications'));

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'       => 'required',
        ]);
        try
        {
            $leads = Leads::find($request->id);
            $leads->fname = $request->fname;
            $leads->lname = $request->lname;
            $leads->email = $request->email;
            $leads->mobile = $request->mobile;
            $leads->city = $request->city;
            $leads->occupation = $request->occupation;
            $leads->qualification = json_encode($request->qualification);
            $leads->gender = $request->gender;
            $leads->age_group = $request->age_group;
            $leads->hobbies = $request->hobbies;
            $leads->save();

            if($leads){
                return redirect('leads-list')->with('success', 'Leads Updated Successfully !');
            }else{
                return redirect('leads-list')->with('error', 'Failed to Update Leads ! Try again.');
            }

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);
        }
    }
    public function delete($id)
    {
        $delete_leads=Leads::find($id);
        $delete_leads->deleted_at=Carbon::now();
        $delete_leads->save();
        
        if($delete_leads)
        {
            return redirect('leads-list')->with('success', 'Leads Deleted Successfully !');
        }
        else
        {
            return redirect('leads-list')->with('error', 'Failed to Delete Leads ! Try again.');
        }
    }
}
