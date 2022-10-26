<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\WalletBalance;
use App\Models\WithdrawRequest;
use App\Models\BankDetails;
use App\Models\UserBankDetails;
use App\Models\UserDetails;
use App\Models\Transaction;

use DB;
use Carbon\Carbon;

class WithdrawlRequest extends Controller
{
    //
    public function index()
    {
    	$withdrawlrequest=WithdrawRequest::where('status','Completed')->get();
    	return view('withdrawl-request',compact('withdrawlrequest'));
    }

    public function approve_withdrawl()
    {
    	$approverequest=WithdrawRequest::where('status','Pending')->get();
    	return view('approve-withdrawl-request',compact('approverequest'));
    }
    public function create()
    {
    	$user_id=User::get();
    	$bank_name=BankDetails::get();
    	return view('create-withdrawl-request',compact('user_id','bank_name'));
    }
    public function edit_request($id)
    {
    	$editrequest=WithdrawRequest::where('id',$id)->first();

    	$transaction_det='';
    	if(!empty($editrequest->transaction_id))
    	{
    		$transaction_det=Transaction::where('id',$editrequest->transaction_id)->first();
    	}
    	return view('edit-withdrawl-request',compact('editrequest','id','transaction_det'));
    }
    public function store(Request $request)
    {
    	$request->validate([
    		'user_id' => 'required',
    		'wallet_balance' => 'required',
    		'amount' => 'required',
    		'bank_account' => 'required'
    	]);
    	try
        {
        	$userbankdet=UserBankDetails::where('users_id',$request->user_id)->orderBy('ubd_id','DESC')->first();

	    	$withdrawlrequest=new WithdrawRequest;
	    	$withdrawlrequest->created_on  = Carbon::now();
	    	$withdrawlrequest->users_id    = $request->user_id;
	    	$withdrawlrequest->amount      = $request->amount;
	    	$withdrawlrequest->ubd_id    = $userbankdet->ubd_id;
	    	$withdrawlrequest->save();

	    	if($withdrawlrequest)
	    	{
	    		return redirect('account/create-withdrawl')->with('success','Withdrawl Request Created successfully!');
	    	}
	    	else
	    	{
	    		return redirect()->back()->with('error','Failed to Withdrawl Request Created!');
	    	}
	    }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);
        }		
    }

    public function store_bank(Request $request)
    { 
    	try
        {
	    	$save_bank_det = new BankDetails;
	    	$save_bank_det->ifsc_code    = $request->ifsc_code;
	    	$save_bank_det->micr         = $request->micr;
	    	$save_bank_det->bank         = $request->bank_name;
	    	$save_bank_det->branch       = $request->branch;
	    	$save_bank_det->bank_address = $request->bank_address;
	    	$save_bank_det->city         = $request->city;
	    	$save_bank_det->district     = $request->district;
	    	$save_bank_det->state        = $request->state;
	    	$save_bank_det->save();

     	 	$user_name=UserDetails::where('id',$request->user_id)->first();
	    	$user_bank_det=new UserBankDetails;
	    	$user_bank_det->users_id          = $request->user_id;
	    	$user_bank_det->account_name    = $user_name->fname;
	    	$user_bank_det->account_no      = $request->account_no;
	    	$user_bank_det->ifsc_code       = $request->ifsc_code;
	    	$user_bank_det->bank_details_id  = $save_bank_det->id;
	    	$user_bank_det->save();
			
	    	if($save_bank_det)
	    	{
	    		return 1;
	    	}
	    	else
	    	{
	    		return 2;
	    	}
		}catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);
        }

    }
    public function update_request(Request $request)
    {
    	$request->validate([
    		'transaction_id' => 'required',
    		'credited_on' => 'required',
    		'status' => 'required'
    	]);
    	try
        {
	    	$edittransaction=Transaction::find($request->transaction_id);
	    	$edittransaction->payment_status  = $request->status;
	    	$edittransaction->save();

	    	$editrequest=WithdrawRequest::find($request->id);
	    	$editrequest->created_on  = $request->credited_on;
	    	$editrequest->transaction_id    = $request->transaction_id;
	    	$editrequest->save();

	    	if($editrequest)
	    	{
	    		return redirect('account/approved-withdrawl')->with('success','Withdrawl Request Updated successfully!');
	    	}
	    	else
	    	{
	    		return redirect()->back()->with('error','Failed to Update Withdrawl Request!');
	    	}
	    }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);
        }		
    }

    public function wallet_balance(Request $request)
    {
    	$balance=WalletBalance::where('users_id',$request->user_id)->first();
    	$userbankdet=UserBankDetails::where('users_id',$request->user_id)->orderBy('ubd_id','DESC')->first();
    	return compact('balance','userbankdet');
    }

    public function approverequest($id)
    {
    	$approve=WithdrawRequest::find($id);
    	$approve->status="Completed";
    	$approve->save();

    	if($approve)
    	{
    		return redirect('account/approve-withdrawl')->with('success','Withdrawl Request Approved successfully!');
    	}
    	else
    	{
    		return redirect()->back()->with('error','Failed to Approve Withdrawl Request !');
    	}
    }

    public function rejectrequest($id)
    {
    	$approve=WithdrawRequest::find($id);
    	$approve->status="Rejected";
    	$approve->save();

    	if($approve)
    	{
    		return redirect('account/approve-withdrawl')->with('success','Withdrawl Request Rejected successfully!');
    	}
    	else
    	{
    		return redirect()->back()->with('error','Failed to Reject Withdrawl Request !');
    	}
    }
    
    public function get_txn_detail(Request $request)
    {
    	$getdetail=Transaction::where('id',$request->txn_id)->first();
    	return $getdetail;

    }
}
