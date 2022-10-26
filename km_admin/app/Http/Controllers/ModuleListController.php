<?php

namespace App\Http\Controllers;

use App\Models\ModuleList;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ModuleListController extends Controller
{
    public function index()
    {
        $module_list = ModuleList::where('deleted_at',null)->get();
        return view('module-list',["module_lists"=>$module_list]);
    }
    public function create()
    {
        try
        {
            return view('create-module-list');

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);

        }
    }
    public function store(Request $request)
    {
        $request->validate([
                'list_of_module' => 'required',
            ]);
        try
        {
            $module_list = new ModuleList();
            $module_list->list_of_module = $request->list_of_module;
            $module_list->save();

            if($module_list){
                return redirect('module-lists')->with('success', 'Module List Create Successfully !');
            }else{
                return redirect('module-lists')->with('error', 'Failed to create Module List ! Try again.');
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
            $module_lists  = ModuleList::find($id);
            return view('edit-module-list',compact('module_lists'));

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
            $module_lists = ModuleList::find($request->id);
            $module_lists->list_of_module = $request->list_of_module;
            $module_lists->save();
            if($module_lists){
                return redirect('module-lists')->with('success', 'Module Lists updated succesfully!');

            }else{
                return redirect('module-lists')->with('error', 'Failed to Update Module Lists !');
            }
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }

    }

    public function delete($id)
    {
        // $date = Carbon::now();
        // $module_lists   = ModuleList::find($id)->update(['deleted_at'=>$date]);
        // if($module_lists){
        //     return redirect('module-lists')->with('success', 'Module List removed!');
        // }else{
        //     return redirect('marketing-plans')->with('error', 'Module List not found');
        // }
    }
}
