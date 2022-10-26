<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BidPacks;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class BidsController extends Controller
{
    //
    public function index()
    {
    	$bidpack_list=BidPacks::where('deleted_at',NULL)->get();
    	return view('bid-packs-list',compact('bidpack_list'));
    }
    public function create()
    {
    	return view('create-bid-pack');
    }
    public function edit($id)
    {
    	$edit_bid=BidPacks::where('deleted_at',NULL)->where('id',$id)->first();
    	return view('edit-bid-pack',compact('edit_bid'));
    }
    public function store(Request $request)
    {
    	$request->validate([
    		'package_name'   => 'required',
    		'bids'        => 'required',
    		'amount'      => 'required',
    		'validity'    => 'required'
    	]);

    	try
    	{
    		$bidpacks=new BidPacks;
    		$bidpacks->package_name=$request->package_name;
    		$bidpacks->bids=$request->bids;
    		$bidpacks->amount=$request->amount;
    		$bidpacks->validity=$request->validity;
    		$bidpacks->save();

    		if($bidpacks){
    			return redirect('account/list')->with('success','Bid packs created successfully !');
    		}
    		else{
    			return redirect()->back()->with('error','Failed to Create bid pack.');
    		}

    	}catch(\Exception $e){
    		$bug=$e->getMessage();
    		return redirect()->back()->with('error',$bug);
    	}
    }
    public function update(Request $request)
    {
    	$request->validate([
    		'package_name'   => 'required',
    		'bids'        => 'required',
    		'amount'      => 'required',
    		'validity'    => 'required'
    	]);

    	try
    	{
    		$bidpacks=BidPacks::find($request->id);
    		$bidpacks->package_name=$request->package_name;
    		$bidpacks->bids=$request->bids;
    		$bidpacks->amount=$request->amount;
    		$bidpacks->validity=$request->validity;
    		$bidpacks->save();

    		if($bidpacks){
    			return redirect('account/list')->with('success','Bid packs updated successfully !');
    		}
    		else{
    			return redirect()->back()->with('error','Failed to update bid pack.');
    		}

    	}catch(\Exception $e){
    		$bug=$e->getMessage();
    		return redirect()->back()->with('error',$bug);
    	}
    }
    public function delete($id)
    {
    	$delete_bidPacks=BidPacks::find($id);
    	$delete_bidPacks->deleted_at=Carbon::now();
    	$delete_bidPacks->save();

    	if($delete_bidPacks){
			return redirect('account/list')->with('success','Bid packs Deleted successfully !');
		}
		else{
			return redirect('account/list')->with('error','Failed to delete bid pack!');
		}
    }
}
