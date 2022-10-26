<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\spQualification;

class QualificationController extends Controller
{
    
    public function index()
    {      
        $qualification = spQualification::all();
        return view('qualifications',['qualifications'=>$qualification]);
    }
    public function create()
    {

        try
        { 
            return view('create-qual');    

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);

        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'qualification' => 'required',
            
            ]);
        try
        {
                $qualification = new spQualification;
                $qualification->qualification = $request->qualification;
                $qualification->save();
                           
            if($qualification){
                return redirect('qualifications')->with('success', 'Qualification Create Successfully !');
            }else{
                return redirect('qualifications')->with('error', 'Failed to create Qualification ! Try again.');
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
            $qualification  = spQualification::find($id);
            return view('edit-qualification',compact('qualification'));

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            // dd($bug);
            return redirect()->back()->with('error', $bug);
        }
    }
    public function update(Request $request)
    {
         $request->validate([
            'id'       => 'required',
        ]);
                 
        try{

            $qualification = spQualification::where('id',$request->id)->first();
            $qualification->qualification = $request->qualification;            
            $qualification->save();

            if($qualification){
                return redirect('qualifications')->with('success', 'Qualification updated succesfully!');
            }else{
                return redirect('qualifications')->with('success', 'Qualification updated Failed!');
            }
           
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);

        }
    }
    public function delete($id)
    {
        $qualification   = spQualification::find($id);
        if($qualification){
            $qualification->delete();
            return redirect('qualifications')->with('success', 'Qualification removed!');
        }else{
            return redirect('qualifications')->with('error', 'Qualification not found');
        }
    }
}
