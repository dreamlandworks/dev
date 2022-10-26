<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserDetails;
use DB;
use Carbon\Carbon;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::all();
        // $userDetails = UserDetails::get();
        $user_detail = User::with('userdetail')->get();
        return view('users',['users'=>$user,'user_details'=>$user_detail]);
    }

    public function create()
    {
        try
        {
            $userDetails = UserDetails::all();
            return view('create-user',["userDetail"=>$userDetails]);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }

    public function store(Request $request)
    {
          // create user
           $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'mobile' => 'required|digits:10',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|string'

            ]);
                $currentTime = Carbon::now();

        try
        {
            // store user information

                // \DB::connection()->enableQueryLog();
            $new_name='';
            if($request->hasFile('profile_pic'))
            {
                $image = $request->file('profile_pic');
                $new_name=rand('000000','111111').'.'.$image->extension();
                $image->move(public_path().'/images/user_profile/',$new_name);
            }
            $user = UserDetails::create([
                    'fname' => $request->fname,
                    'lname' => $request->lname,
                    'mobile' => $request->mobile,
                    'dob' => $request->DOB,
                    'gender' => $request->gender,
                    'profile_pic' => $new_name,
                    'registered_on' => $currentTime,
                    'referral_id' => 0,
                ]);



            $info = User::create([
                    'userid' => $request->mobile,
                    'password' => Hash::make($request->password),
                    'email' => $request->email,
                    'users_id' => $user->id
                ]);


                //  $queries = \DB::getQueryLog();
                //  dd($queries);
            if($info){

                // $info->syncRoles($request->role_id);

                return redirect('users')->with('success', 'New user created!');
            }else{
                return redirect('users')->with('error', 'Failed to create new user! Try again.');
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
            $userDetails  = UserDetails::find($id);
            $user = User::where('users_id',$userDetails->id)->first();
            $userData = UserDetails::all();

            //  $userRole = $user->getRoleNames();
            // if($userRole){
            //     $userRole=$userRole[0];
            // }else{
            //     $userRole=null;
            // }

            return view('edit-user',compact('userDetails','userData','user'));

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
            'fname'     => 'required | string ',
            'lname'     => 'required | string ',
        ]);

         if($request->hasFile('profile_pic')){
                $image = $request->file('profile_pic');
                        $new_name=rand('000000','111111').'.'.$image->extension();
                        $image->move(public_path().'/images/user_profile/',$new_name);
                        $user = UserDetails::find($request->id);
                        $update = $user->update([
                        'profile_pic' =>$new_name,
                ]);
            }


        try{

            $currentTime = Carbon::now();
            $userDetails  = UserDetails::find($request->id);

            $update = $userDetails->update([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'dob' => $request->DOB,
                'gender' => $request->gender,
                'registered_on' => $currentTime,
            ]);

           $user_info = User::where('users_id',$userDetails->id)->first()->id;
            $user = User::find($user_info);

          // update password if user input a new password

            if(isset($request->password)){
                $update = $user->update([
                    'password' => Hash::make($request->password)
                ]);
            }
            // $user->syncRoles($request->role_id);
            return redirect('users')->with('success', 'User information updated succesfully!');

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }

    public function delete($id)
    {
        $user   = User::find($id);
        if($user){
            $user->delete();
            return redirect('users')->with('success', 'User removed!');
        }else{
            return redirect('users')->with('error', 'User not found');
        }
    }


}
