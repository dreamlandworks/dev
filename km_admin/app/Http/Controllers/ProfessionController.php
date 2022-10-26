<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\listProfession;
use App\Models\spQualification;
use App\Models\skill;
use App\Models\Language;
use App\Models\timeSlot;
use App\Models\SubCategory;

class ProfessionController extends Controller
{
    public function store_pro(Request $request)
    {
        try
        {
            $profession = new listProfession;
            $profession->name = $request->name;
            $profession->subcategory_id = $request->sub_name;
            $profession->category_id = $request->category;
            $profession->save();
            if($profession){
                return 1;
            }else{
                return 2;
            }
        }catch (\Exception $e) {
             $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }
    public function store_qua(Request $request)
    {
        try
        {
            $qualification = new spQualification;
            $qualification->qualification = $request->qualification;
            $qualification->save();
            if($qualification){
                return 1;
            }else{
                return 2;
            }
        }catch (\Exception $e) {
             $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }
    public function store_skill(Request $request)
    {
        try
        {
            $skill = new skill;
            $skill->keyword = $request->keyword;
            $skill->profession_id = $request->profession;
            $skill->status = $request->status;
            $skill->save();
            if(!empty($request->status))
            {
                $skill->status = 'InActive';
            }else{
                $skill->status = 'Active';
            }
            $skill->save();
            if($skill){
                return 1;
            }else{
                return 2;
            }
        }catch (\Exception $e) {
            return $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }
    public function store_lang(Request $request)
    {
        try
        {
            $lang = new Language;
            $lang->name = $request->language;
            $lang->save();

            if($lang){
                return 1;
            }else{
                return 2;
            }

        }catch (\Exception $e) {
            return $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
    public function store_slot(Request $request)
    {
        try
        {
            $slot = new timeSlot;
            $slot->from = $request->from;
            $slot->save();
            if($slot){
                return 1;
            }else{
                return 2;
            }
        }catch (\Exception $e) {
             $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function get_prof()
    {
        $mk = 'assign';
        $profession = listProfession::with('subcategoryDetails')->where('subcategory_id','=',0)->where('category_id','=',0)->get();
        return view('professions',['professions'=>$profession,'mk'=>$mk]);
    }

    public function index()
    {
        $mk = '';
        // $sub_category = SubCategory::all();
        $profession = listProfession::with('subcategoryDetails')->where('subcategory_id','!=',0)->where('category_id','!=',0)->get();
        return view('professions',['professions'=>$profession,'mk'=>$mk]);
    }
    public function create_profession()
    {

        try
        {
            $sub_category = SubCategory::all();
            return view('profession-create',['sub_categories'=>$sub_category]);

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

            ]);
        try
        {
                $profession = new listProfession;
                $profession->name = $request->name;
                $profession->subcategory_id = $request->subcategory_id;
                $profession->category_id = $request->category_id;
                $profession->save();

            if($profession){
                return redirect('professions')->with('success', 'Profession Create Successfully !');
            }else{
                return redirect('professions')->with('error', 'Failed to create Profession ! Try again.');
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
            $sub_categories = SubCategory::all();
            $professions  = listProfession::find($id);
            return view('edit-profession',compact('sub_categories','professions'));

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

            $profession = listProfession::where('id',$request->id)->first();
            $profession->name = $request->name;
            $profession->subcategory_id = $request->subcategory_id;
            $profession->category_id = $request->category_id;
            $profession->save();

            if($profession){
                return redirect('professions')->with('success', 'Profession updated succesfully!');
            }else{
                return redirect('professions')->with('success', 'Profession updated Failed!');
            }

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);

        }
    }
    public function delete($id)
    {
        $profession   = listProfession::find($id);
        if($profession){
            $profession->delete();
            return redirect('professions')->with('success', 'Profession removed!');
        }else{
            return redirect('professions')->with('error', 'Profession not found');
        }
    }


}
