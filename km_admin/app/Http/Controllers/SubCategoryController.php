<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;

class SubCategoryController extends Controller
{
    public function get_sub_cat()
    {
        $mk = 'assign';
        $sub_category = SubCategory::with('categoryDetails')->where('category_id','=',0)->get();
        return view('sub-categories',['sub_categories'=> $sub_category,'mk'=>$mk]);
    }
    public function index()
    {
        $mk = '';
        $sub_category = SubCategory::with('categoryDetails')->where('category_id','!=',0)->get();
        return view('sub-categories',['sub_categories'=> $sub_category,'mk'=>$mk]);
    }
    public function create()
    {

        try
        {
            $category = Category::all();
            return view('create-sub-category',['categories'=>$category]);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);

        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'sub_name' => 'required',

            ]);
        try
        {
            $image = $request->file('image');
                $new_name=rand('000000','111111').'.'.$image->extension();
                $image->move(public_path().'/images/subcategories/',$new_name);

                $sub_category = new SubCategory;
                $sub_category->sub_name = $request->sub_name;
                $sub_category->category_id = $request->category;
                $sub_category->image = $new_name;
                if($request->status == 'on')
                {
                    $sub_category->status = 'Active';
                }else{
                    $sub_category->status = 'Inactive';
                }
                $sub_category->save();

            if($sub_category){
                return redirect('sub-categories')->with('success', 'Category Create Successfully !');
            }else{
                return redirect('sub-categories')->with('error', 'Failed to create Category ! Try again.');
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
            $categories = Category::all();
            $subcategories  = SubCategory::find($id);
            return view('edit-sub-category',compact('subcategories','categories'));

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

            $sub_category  = SubCategory::where('id',$request->id)->first();
            if($request->hasFile('image')){
                $image = $request->file('image');
                        $new_name=rand('000000','111111').'.'.$image->extension();
                        $image->move(public_path().'/images/subcategories/',$new_name);
                        $sub_category = SubCategory::find($request->id);
                        $update = $sub_category->update([
                        'image' =>$new_name,
                ]);
            }

            $sub_category->sub_name = $request->sub_name;
            $sub_category->category_id = $request->category;
            if($request->status == 'on')
            {
                $sub_category->status = 'Active';
            }else{
                $sub_category->status = 'Inactive';
            }
            $sub_category->save();
            if($sub_category){
                return redirect('sub-categories')->with('success', 'Sub-Category updated succesfully!');

            }else{
                return redirect('sub-categories')->with('success', 'Sub-Category  updated Failed!');
            }

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);

        }
    }

    public function delete($id)
    {
        $sub_category   = SubCategory::find($id);
        if($sub_category){
            $sub_category->delete();
            return redirect('sub-categories')->with('success', 'Sub Category removed!');
        }else{
            return redirect('sub-categories')->with('error', 'Sub Category not found');
        }
    }

    public function sub_cat(Request $request)
    {
        $sub_cat = SubCategory::where('id',$request->id)->first();
        $category = Category::where('id',$sub_cat->category_id)->first();
        return $category;
    }
    public function modal_sub_cat(Request $request)
    {
        $sub_cat = SubCategory::where('id',$request->id)->first();
        $category = Category::where('id',$sub_cat->category_id)->first();
        return $category;
    }

}
