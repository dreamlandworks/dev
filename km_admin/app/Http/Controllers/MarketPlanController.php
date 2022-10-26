<?php

namespace App\Http\Controllers;

use App\Models\MarketPlan;
use App\Models\ModuleList;
use App\Models\MarketStatistics;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class MarketPlanController extends Controller
{
    public function index()
    {
        $marketing_plan = MarketPlan::where('deleted_at',null)->get();
        return view('marketing-plans',["marketing_plans"=>$marketing_plan]);
    }

    public function create()
    {
        try
        {
            //$module_list = ModuleList::where('deleted_at',null)->get();
            return view('create-market-plan');

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);

        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'name_of_ad_campaign' => 'required',
            'period'              => 'required',
            'campaign_type'       => 'required',
            'target_age_group'    => 'required',
            'gender'              => 'required',
            'date_of_start'       => 'required',
            'targeted_user_group' => 'required',
            'budget_estimated'    => 'required'
            ]);
        try
        {
            $marketing_plan = new MarketPlan();
            $marketing_plan->name_of_ad_campaign = $request->name_of_ad_campaign;
            $marketing_plan->period = $request->period;
            $marketing_plan->campaign_type  = $request->campaign_type;
            $marketing_plan->target_age_group = $request->target_age_group;
            $marketing_plan->gender = $request->gender;
            $marketing_plan->date_of_start = $request->date_of_start;
            $marketing_plan->targeted_user_group = $request->targeted_user_group;
            $marketing_plan->status = $request->status;
            
            $random_no=rand('000000','111111');
            $marketing_plan->document_path = '/marketing/document/';
            if($request->hasFile('attachment'))
            {
                $file=$request->file('attachment');
                $file_name='marketing'.$random_no.'.'.$file->extension();
                $file->move(public_path().'/marketing/document/',$file_name);
                $marketing_plan->attachment=$file_name;    
            }
            $marketing_plan->budget_estimated = $request->budget_estimated;
            $marketing_plan->content = $request->content;
            $marketing_plan->save();

            if($marketing_plan){
                return redirect('marketing-plans')->with('success', 'Market Plan Create Successfully !');
            }else{
                return redirect()->back()->with('error', 'Failed to create Market Plan ! Try again.');
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
            $marketing_plans  = MarketPlan::find($id);
            return view('edit-marketingPlan',compact('marketing_plans'));

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
        try{
            $update_marketing_plans = MarketPlan::find($request->id);
            $update_marketing_plans->name_of_ad_campaign = $request->name_of_ad_campaign;
            $update_marketing_plans->period = $request->period;
            $update_marketing_plans->campaign_type = $request->campaign_type;
            $update_marketing_plans->target_age_group = $request->target_age_group;
            $update_marketing_plans->gender = $request->gender;
            $update_marketing_plans->date_of_start = $request->date_of_start;
            $update_marketing_plans->targeted_user_group = $request->targeted_user_group;
            $update_marketing_plans->status = $request->status;
            
            $random_no=rand('000000','111111');
            if($request->hasFile('attachment'))
            {
                $file=$request->file('attachment');
                $file_name='marketing'.$random_no.'.'.$file->extension();
                $file->move(public_path().'/marketing/document/',$file_name);
                $update_marketing_plans->attachment=$file_name;    
            }
            $update_marketing_plans->budget_estimated = $request->budget_estimated;
            $update_marketing_plans->content = $request->content;
            $update_marketing_plans->save();

            if($update_marketing_plans){
                return redirect('marketing-plans')->with('success', 'Marketing Plan updated succesfully!');

            }else{
                return redirect()->back()->with('error', 'Failed to Update Market Plan !');
            }
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }

    }

    public function delete($id)
    {
        $date = Carbon::now();
        $marketing_plans   = MarketPlan::find($id)->update(['deleted_at'=>$date]);
        if($marketing_plans){
            return redirect('marketing-plans')->with('success', 'Marketing Plan removed!');
        }else{
            return redirect('marketing-plans')->with('error', 'Marketing Plan not found');
        }
    }
    
    ////Marketing statistics
    
    public function statistics_index()
    {
        $statistics_list=MarketStatistics::where('deleted_at',NULL)->get();
        return view('market-statistics-list',compact('statistics_list'));
    }
    public function statistics_create()
    {
        return view('create-market-statistics');
    }
    public function statistics_edit($id)
    {
        $edit_stastics=MarketStatistics::where('id',$id)->where('deleted_at',NULL)->first();
        return view('edit-market-statistics',compact('edit_stastics'));
    }
    public function store_statistics(Request $request)
    {
        $request->validate([
            'name_of_campaign' =>'required',
            'leads_generated' =>'required',
            'leads_converted' =>'required',
            'projected_budget' =>'required',
            'expenditure_till_date' =>'required',
            'cac'  => 'required'
            ]);
            try
            {
                $marketStatistics=new MarketStatistics;
                $marketStatistics->name_of_campaign=$request->name_of_campaign;
                $marketStatistics->ends_in=$request->ends_in;
                $marketStatistics->leads_generated=$request->leads_generated;
                $marketStatistics->leads_converted=$request->leads_converted;
                $marketStatistics->projected_budget=$request->projected_budget;
                $marketStatistics->expenditure_till_date=$request->expenditure_till_date;
                $marketStatistics->cac=$request->cac;
                $marketStatistics->save();
                
                if($marketStatistics)
                {
                    return redirect('marketing-statistics')->with('success','Marketing statistics created successfully!');

                }else{
                    return redirect()->back()->with('error', 'Failed to create Market statistics !');
                }
                
            }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
            }
    }
    public function update_statistics(Request $request)
    {
        $request->validate([
            'name_of_campaign' =>'required',
            'leads_generated' =>'required',
            'leads_converted' =>'required',
            'projected_budget' =>'required',
            'expenditure_till_date' =>'required',
            'cac'  => 'required'
            ]);
            try
            {
                $marketStatistics=MarketStatistics::find($request->id);
                $marketStatistics->name_of_campaign=$request->name_of_campaign;
                $marketStatistics->ends_in=$request->ends_in;
                $marketStatistics->leads_generated=$request->leads_generated;
                $marketStatistics->leads_converted=$request->leads_converted;
                $marketStatistics->projected_budget=$request->projected_budget;
                $marketStatistics->expenditure_till_date=$request->expenditure_till_date;
                $marketStatistics->cac=$request->cac;
                $marketStatistics->save();
                
                if($marketStatistics)
                {
                    return redirect('marketing-statistics')->with('success','Marketing statistics updated successfully!');

                }else{
                    return redirect()->back()->with('error', 'Failed to Update Market statistics !');
                }
                
            }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
            }
    }
    public function delete_statistics($id)
    {
        $delete_statistics=MarketStatistics::find($id);
        $delete_statistics->deleted_at=Carbon::now();
        $delete_statistics->save();
        if($delete_statistics)
        {
            return redirect('marketing-statistics')->with('success','Marketing statistics deleted successfully!');

        }else{
            return redirect()->back()->with('error', 'Failed to delete Market statistics !');
        }
    }
}
