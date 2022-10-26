<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SpPlan;

class SpPlanController extends Controller
{
    public function index()
    {      
        $sp_plans = SpPlan::get();
        return view('sp-plans',['sp_plans'=> $sp_plans]);
    }
    public function create()
    {

        try
        { 
            return view('create-sp-plan');    

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
            'platform_fee_per_booking' => 'required',
            'bids_per_month' => 'required',
            'sealed_bids_per_month' => 'required',
            'customer_support' => 'required',
            'desc' => 'required'
            ]);
            
        try
        {
            $sp_plans = SpPlan::create([
                'name' => $request->name,
                'description' => $request->desc,
                'amount' => $request->amount,
                'period' => $request->period,
                'premium_tag' => $request->premium_tag,
                'platform_fee_per_booking' => $request->platform_fee_per_booking,
                'bids_per_month' => $request->bids_per_month,
                'sealed_bids_per_month' => $request->sealed_bids_per_month,
                'customer_support' =>$request->customer_support,
                ]);
            
            if($sp_plans){
                return redirect('sp-plans')->with('success', 'SP Plans Created Successfully !');
            }else{
                return redirect('sp-plans')->with('error', 'Failed to create SP Plans ! Try again.');
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
            $sp_plans  = SpPlan::find($id);
            return view('edit-sp-plans',compact('sp_plans'));

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
            $sp_plans = SpPlan::where('id',$request->id)->first();
            $update = $user_plans->update([
                 'name' => $request->name,
                'description' => $request->desc,
                'amount' => $request->amount,
                'period' => $request->period,
                'premium_tag' => $request->premium_tag,
                'platform_fee_per_booking' => $request->platform_fee_per_booking,
                'bids_per_month' => $request->bids_per_month,
                'sealed_bids_per_month' => $request->sealed_bids_per_month,
                'customer_support' =>$request->customer_support,
            ]); 
                
           
           if($update){
               return redirect('sp-plans')->with('success', 'SP Plans Updated Successfully !');
           }else{
               return redirect('sp-plans')->with('success', 'Failed to Update !');
           }
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }
    
    public function delete($id)
    {
        $sp_plans   = SpPlan::find($id);
        if($sp_plans){
            $sp_plans->delete();
            return redirect('sp-plans')->with('success', 'SP Plans removed!');
        }else{
            return redirect('sp-plans')->with('error', 'SP Plans not found');
        }
    }
}
