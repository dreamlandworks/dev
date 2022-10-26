<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\listProfession;
use App\Models\skill;
use App\Models\SubCategory;

class KeywordController extends Controller
{
    public function index()
    {
        $mk = '';
        $keyword = skill::with('professionDetails')->where('profession_id','!=',0)->get();
        return view('keywords',['keywords'=> $keyword,'mk'=>$mk]);
    }
    public function assign_permission()
    {
        $mk = 'assign';
        $keyword = skill::with('professionDetails')->where('profession_id','=',0)->get();
        return view('keywords',['keywords'=> $keyword,'mk'=>$mk]);
    }
    public function create()
    {

        try
        {
            $profession = listProfession::all();
            return view('create-keyword',['professions'=>$profession]);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);

        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'keyword' => 'required',

            ]);
        try
        {
                $keyword = new skill;
                $keyword->keyword = $request->keyword;
                $keyword->profession_id = $request->profession;
                if($request->status == 'on')
                    {
                        $keyword->status = 'Active';
                    } else{
                        $keyword->status = 'Inactive';
                    }
                $keyword->save();

            if($keyword){
                return redirect('keywords')->with('success', 'Keyword Create Successfully !');
            }else{
                return redirect('keywords')->with('error', 'Failed to create Keyword ! Try again.');
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
            $professions = listProfession::all();
            $keywords  = skill::find($id);
            return view('edit-keyword',compact('professions','keywords'));

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            // dd($bug);
            return redirect()->back()->with('error', $bug);
        }
    }

    public function update(Request $request)
    {

        // update user info
         $request->validate([
            'id'       => 'required',
        ]);

        try{

            $keyword  = skill::where('id',$request->id)->first();
            $keyword->keyword = $request->keyword;
            $keyword->profession_id = $request->profession;
            if($request->status == 'on')
                {
                    $keyword->status = 'Active';
                } else{
                    $keyword->status = 'Inactive';
                }
            $keyword->save();

            if($keyword){
                return redirect('keywords')->with('success', 'Keyword updated succesfully!');

            }else{
                return redirect('keywords')->with('success', 'Keyword  updated Failed!');
            }

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function delete($id)
    {
        $keyword   = skill::find($id);
        if($keyword){
            $keyword->delete();
            return redirect('keywords')->with('success', 'Keyword removed!');
        }else{
            return redirect('keywords')->with('error', 'Keyword not found');
        }
    }

    public function sub_cat(Request $request)
    {

        $sub_cat = SubCategory::where('id',$request->id)->first();
        $category = Category::where('id',$sub_cat->category_id)->first();
        return $category;
    }
}
