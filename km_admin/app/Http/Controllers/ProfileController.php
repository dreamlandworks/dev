<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\UserDetails;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    //
    public function create()
    {
    	$user = auth()->user();
    	$userDetails=UserDetails::where('id',$user->users_id)->first();
    	return view('profile',compact('user','userDetails'));
    }
    public function edit_profile(Request $request)
    {
    	$request->validate([
    		'fname' => 'required',
    		'gender' => 'required',
    		'date_of_birth' => 'required',
    		'email'              =>[
                    'required',
                    'email',
                    'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/',
                    Rule::unique('users')->ignore($request->id)
                ],
    		'mobile'             =>[
                    'required',
                    'digits:10',
                    'numeric',
                    Rule::unique('user_details')->ignore($request->users_id)
                ]
    	]);

    	try
        {
	    	$table_user=User::find($request->id);
	    	$table_user->email=$request->email;
	    	if(isset($request->password))
	    	{
	    		$table_user->password=Hash::make($request->password);
	    	}
	    	$table_user->save();

	    	$table_userDetail=UserDetails::find($request->users_id);
	    	$table_userDetail->fname=$request->fname;
	    	$table_userDetail->lname=$request->lname;
	    	$table_userDetail->mobile=$request->mobile;
	    	$table_userDetail->dob=$request->date_of_birth;
	    	$table_userDetail->gender=$request->gender;
	    	$table_userDetail->save();  

	    	if($table_userDetail)
	    	{
	    		return redirect('profile')->with('success','Profile updated Successfully! ');
	    	}
	    	else
	    	{
	    		return redirect()->back()->with('error','Failed to update.' );
	    	}
	    	
	    }catch(\Exception $e)
	    {
	    	$bug=$e-getMessage();
	    	return redirect()->back()->with('error',$bug);
	    }
    }
}
