<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ticket;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\UserDetails;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;

class SupportController extends Controller
{
    //
    public function index()
    {
    	$list_array=Ticket::join('employee','ticket.assign_person','=','employee.id')
        ->where('ticket.deleted_at',NULL)->get(['ticket.id','employee.name','ticket.description','ticket.created_date','ticket.priority','employee.department']);
        $view_ticket=array();
        foreach ($list_array as $key => $value) {
           $department=Designation::where('id',$value->department)->first();
           $view_ticket[$key]['id']=$value->id;
           $view_ticket[$key]['name']=$value->name;
           $view_ticket[$key]['description']=$value->description;
           $view_ticket[$key]['priority']=$value->priority;
           $view_ticket[$key]['created_date']=$value->created_date;
           $view_ticket[$key]['department']=$department->department_name;

        }
    	return view('ticket-list',compact('view_ticket'));
    }
    public function create()
    {
        $logged_user_id=auth()->user();
        $username=User::join('user_details','users.users_id','=','user_details.id')
        ->where('users.id',$logged_user_id->id)->first();

        $employee=Employee::join('designation','employee.department','=','designation.id')->where('user_type','Support')->orWhere('user_type','Account')->orWhere('user_type','Operation')->get(['employee.id','employee.name','designation.department_name as designations']);
    	return view('create-ticket',compact('employee','username'));
    }
    public function edit($id)
    {
        $logged_user_id=auth()->user();
        $username=User::join('user_details','users.users_id','=','user_details.id')
        ->where('users.id',$logged_user_id->id)->first();

        $employee=Employee::join('designation','employee.department','=','designation.id')->where('user_type','Support')->orWhere('user_type','Account')->orWhere('user_type','Operation')->get(['employee.id','employee.name','designation.department_name as designations']);
    	$edit_ticket=Ticket::where('deleted_at',NULL)->where('id',$id)->first();
    	return view('edit-ticket',compact('edit_ticket','employee','username'));
    }
    public function store(Request $request)
    {
    	$request->validate([
    		'assign_person'  => 'required',
    		'priority'  => 'required',
    		'description'  => 'required'

    	]);

    	try
    	{
    		$ticket=new Ticket();
    		$ticket->assign_person=$request->assign_person;
    		$ticket->priority=$request->priority;
    		$ticket->created_date=$request->created_date;
    		$ticket->created_by=$request->created_by;
    		$ticket->description=$request->description;
    		$ticket->save();

    		if($ticket)
    		{
    			return redirect('support/list')->with('success','Ticket created successfully!');
    		}
    		else
    		{
    			return redirect()->back()->with('error','Failed to create Ticket!');
    		}
    	}catch(\Exceptio $e)
    	{
    		$bug=$e->getMessage();
    		return redirect()->back()->with('error',$bug);
    	}
    }
    public function update(Request $request)
    {
    	$request->validate([
    		'assign_person'  => 'required',
    		'priority'  => 'required',
    		'description'  => 'required'

    	]);

    	try
    	{
    		$ticket=Ticket::find($request->id);
    		$ticket->assign_person=$request->assign_person;
    		$ticket->priority=$request->priority;
    		$ticket->created_date=$request->created_date;
    		$ticket->created_by=$request->created_by;
    		$ticket->description=$request->description;
    		$ticket->save();

    		if($ticket)
    		{
    			return redirect('support/list')->with('success','Ticket updated successfully!');
    		}
    		else
    		{
    			return redirect()->back()->with('error','Failed to update Ticket!');
    		}
    	}catch(\Exceptio $e)
    	{
    		$bug=$e->getMessage();
    		return redirect()->back()->with('error',$bug);
    	}
    }
    public function delete($id)
    {
    	$ticket=Ticket::find($id);
    	$ticket->deleted_at=Carbon::now();
    	$ticket->save();
    	if($ticket)
		{
			return redirect('support/list')->with('success','Ticket deleted successfully!');
		}
		else
		{
			return redirect()->back()->with('error','Failed to delete Ticket!');
		}
    }
}
