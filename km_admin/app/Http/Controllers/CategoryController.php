<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {      
        $category = Category::all();
        return view('categories',['categories'=> $category]);
    }
    public function create()
    {

        try
        { 
            return view('create-category');    

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);

        }
    }
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            ]);
        try
        {

            $image = $request->file('image');
                $new_name=rand('000000','111111').'.'.$image->extension();
                $image->move(public_path().'/images/category/',$new_name);
            if($request->status == 'on')
            {
                $category = new Category;
                $category->category = $request->category;
                $category->image = $new_name;
                $category->status = 'Active';
                $category->save();
            }else{
                $category = new Category;
                $category->category = $request->category;
                $category->image = $new_name;
                $category->status = 'Inactive';
                $category->save();
            }
               
            
            if($category){
                return redirect('categories')->with('success', 'Category Create Successfully !');
            }else{
                return redirect('categories')->with('error', 'Failed to create Category ! Try again.');
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
            $categories  = Category::find($id);
            return view('edit-category',compact('categories'));

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
            
            $category  = Category::find($request->id);

            if($request->hasFile('image')){
                $image = $request->file('image');
                        $new_name=rand('000000','111111').'.'.$image->extension();
                        $image->move(public_path().'/images/category/',$new_name);
                        $category = Category::find($request->id);
                        $update = $category->update([
                        'image' =>$new_name,
                ]);
            }
            if($request->status == 'on')
            {
                $update = $category->update([
                    'category' => $request->category,
                    'status' => 'Active'
                ]);
            }else{
                $update = $category->update([
                    'category' => $request->category,
                    'status' => 'Inactive',
                ]);
            }
            if($update){
                return redirect('categories')->with('success', 'Category updated succesfully!');

            }else{
                return redirect('categories')->with('success', 'Category updated succesfully!');
            }
           
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }
    
    public function delete($id)
    {
        $category   = Category::find($id);
        if($category){
            $category->delete();
            return redirect('categories')->with('success', 'Category removed!');
        }else{
            return redirect('categories')->with('error', 'Category not found');
        }
    }
}
