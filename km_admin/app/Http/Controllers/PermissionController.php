<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables,Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;


class PermissionController extends Controller
{
    public function index()
    {
        try{
            $roles = Role::pluck('name','id');

            return view('permission', compact('roles'));
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }

    public function create()
    {
        try
        {
            $role = Role::all();
            $permission = Permission::all();
            return view('create-permission',["roles"=>$role,"permissions"=>$permission]);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }

    public function store(Request $request)
    {
         $request->validate([
            'permission' => 'required'
        ]);

        try{
            $permission = Permission::create(['name' => $request->permission]);
            $permission->syncRoles($request->roles);

            if($permission){
                return redirect('permission/create')->with('success', 'Permission created succesfully!');
            }else{
                return redirect('permission/create')->with('error', 'Failed to create permission! Try again.');
            }
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }



    public function update(Request $request)
    {

        // update permission table
        $permission = Permission::find($request->id);
        $permission->name = $request->name;
        $permission->save();

        return $permission;
    }


    public function delete($id)
    {
        $permission   = Permission::find($id);
        if($permission){
            $delete = $permission->delete();
            $perm   = $permission->roles()->delete();

            return redirect('permission')->with('success', 'Permission deleted!');
        }else{
            return redirect('404');
        }
    }

}
