<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use DataTables,Auth;

class RoleController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the roles page
     *
     */

    public function index()
    {
        $role = Role::all();

        return view('roles');
    }
    public function create()
    {
        try
        {
            $permission = Permission::all();
            $role = Role::all();

            return view('create-role',['permissions'=>$permission,'roles'=>$role]);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }
    public function store(Request $request)
    {

    //   return $request->permissions;
    $request->validate([
            'role' => 'required'
        ]);

        try{

            $role = Role::create(['name' => $request->role]);

            if($role){

                if($request->permissions){

                    $role->syncPermissions($request->permissions);

                }


                return redirect('role/create')->with('success', 'Role created succesfully!');
            }else{
                return redirect('role/create')->with('error', 'Failed to create role! Try again.');
            }
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function edit($id)
    {
        try
        {
            $role  = Role::find($id);
            $permissions = Permission::all();
            return view('role-edit', compact('role','permissions'));

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function update(Request $request)
    {

        // update role
        $validator = Validator::make($request->all(), [
            'role' => 'required',
            'id'   => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        }
        try{

            $role = Role::find($request->id);

            $update = $role->update([
                          'name' => $request->role
                      ]);

            // Sync role permissions
            $role->syncPermissions($request->permissions);

            return redirect('role/create')->with('success', 'Role info updated succesfully!');
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }

    public function delete($id)
    {
        $role = Role::find($id);
        if($role){
           $delete = $role->delete();
            $perm   = $role->permissions()->delete();

            return redirect()->with('success','Roles removed !');
        }else{
            return redirect()->with('error','Roles not removed !');
        }
    }

}
