<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPlan;

class UserPlanController extends Controller
{
    public function index()
    {      
        $user_plans = UserPlan::get();
        return view('user-plans',['user_plans'=> $user_plans]);
    }
    public function create()
    {

        try
        { 
            return view('create-user-plan');    

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);

        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required',
            'period' => 'required',
            'premium_tag' => 'required',
            'posts_per_month' => 'required',
            'proposals_per_post' => 'required',
            'customer_support' => 'required',
            'desc' => 'required'
            ]);
        try
        {
            $user_plans = UserPlan::create([
                
                'name' => $request->name,
                'description' => $request->desc,
                'amount' => $request->amount,
                'period' => $request->period,
                'premium_tag' => $request->premium_tag,
                'posts_per_month' => $request->posts_per_month,
                'proposals_per_post' => $request->proposals_per_post,
                'customer_support' =>$request->customer_support,
                ]);
            
            if($user_plans){
                return redirect('user-plans')->with('success', 'User Plans Created Successfully !');
            }else{
                return redirect('user-plans')->with('error', 'Failed to create User Plans ! Try again.');
            }
        
            
        }catch (\Exception $e) {
            $bug = $e->getMessage();
           // dd($bug);
            return redirect()->back()->with('error', $bug);
        }
    }
    public function edit($id)
    {
        try
        {
            $user_plans  = UserPlan::find($id);
            return view('edit-user-plans',compact('user_plans'));

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);
        }
    }

    public function update(Request $request)
    {
        
         $request->validate([
            'id'       => 'required',
        ]);
        
        try{
            $user_plans = UserPlan::where('id',$request->id)->first();
            $update = $user_plans->update([
                'name' => $request->name,
                'description' => $request->desc,
                'amount' => $request->amount,
                'period' => $request->period,
                'premium_tag' => $request->premium_tag,
                'posts_per_month' => $request->posts_per_month,
                'proposals_per_post' => $request->proposals_per_post,
                'customer_support' =>$request->customer_support,  
                ]);
           
           if($update){
               return redirect('user-plans')->with('success', 'User Plans Updated Successfully !');
           }else{
               return redirect('user-plans')->with('success', 'Failed to Update !');
           }
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }
    
    public function delete($id)
    {
        $user_plans   = UserPlan::find($id);
        if($user_plans){
            $user_plans->delete();
            return redirect('user-plans')->with('success', 'User Plans removed!');
        }else{
            return redirect('user-plans')->with('error', 'User Plans not found');
        }
    }
}
