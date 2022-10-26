<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionName;
use App\Models\UserDetails;
use App\Models\TransactionMethod;
use App\Models\TransactionType;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    //
    public function view_receipt()
    {
        $transaction_array=array();
        return view('view-receipt',compact('transaction_array'));
    }
    
    public function get_receipt(Request $request)
    {
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required'

        ]);
        if(strtotime($request->from_date) > strtotime($request->to_date))
        {
            return redirect()->back()->with('error',"To date must be greater than from date.");
        }
    	$transaction_array=array();
    	
		if(!empty($request->from_date) || !empty($request->to_date))
    	{
    		if(empty($request->to_date))
    		{
    			$request->to_date=date('Y-m-d');
    		}
            $receipt=Transaction::where('type_id',1)->whereBetween('date',[$request->from_date,$request->to_date])->orderBy('id','DESC')->limit(15)->get();

    		//$receipt=$receipt->whereBetween('date',[$request->from_date,$request->to_date]);
    	}
    	foreach($receipt as $key=>$value)
    	{
    		$transaction_name=TransactionName::where('id',$value->name_id)->first();
            
            $transaction_array[$key]['id']=$value->id;
    		$transaction_array[$key]['date']=$value->date;
    		$transaction_array[$key]['transaction_name']=$transaction_name->name;
    		$transaction_array[$key]['amount']=$value->amount;
    		$transaction_array[$key]['order_id']=$value->order_id;
    		$transaction_array[$key]['payment_status']=$value->payment_status;

    	}
    	return view('view-receipt',compact('transaction_array'));
    }
    
    public function receipt_modal($txn_id)
    {
        $transaction_array=array();
        $receipt=Transaction::where('type_id',1)->where('id',$txn_id)->first();
        // foreach($receipt as $key=>$value)
        // {
        // }
            $transaction_name=TransactionName::where('id',$receipt->name_id)->first();
            $user_name=UserDetails::where('id',$receipt->users_id)->first();
            $transaction_method=TransactionMethod::where('id',$receipt->method_id)->first();

            $transaction_array['id']=$receipt->id;
            $transaction_array['date']=$receipt->date;
            $transaction_array['transaction_name']=$transaction_name->name;
            $transaction_array['amount']=$receipt->amount;
            $transaction_array['order_id']=$receipt->order_id;
            $transaction_array['payment_status']=$receipt->payment_status;
            $transaction_array['user_name']=$user_name->fname;
            if(isset($transaction_method->name))
            {
                $transaction_array['transaction_method']=$transaction_method->name;
            }
            else
            {
                $transaction_array['transaction_method']='';
            }
            $transaction_array['reference_id']=$receipt->reference_id;
            $transaction_array['booking_id']=$receipt->booking_id;
            $transaction_array['created_dts']=$receipt->created_dts;
            $transaction_array['txn_token']=$receipt->txn_token;
            $transaction_array['txnId']=$receipt->txnId;
            $transaction_array['bankTxnId']=$receipt->bankTxnId;
            $transaction_array['txnType']=$receipt->txnType;
            $transaction_array['gatewayName']=$receipt->gatewayName;
            $transaction_array['bankName']=$receipt->bankName;
            $transaction_array['paymentMode']=$receipt->paymentMode;
            $transaction_array['refundAmt']=$receipt->refundAmt;
            $transaction_array['authRefId']=$receipt->authRefId;

        return view('receipt-modal',compact('transaction_array'));
    }
    //// receipt by booking id

    public function bookingid_receipt()
    {
        $transaction_array=array();
        return view('bookingid-receipt',compact('transaction_array'));
    }

    public function bookingid_receipt_filter(Request $request)
    {
        $request->validate([
            'booking_id' => 'required'
        ]);
    	$transaction_array=array();
    	$receipt=Transaction::where('booking_id',$request->booking_id)->orderBy('id','DESC')->limit(15)->get();
    	foreach($receipt as $key=>$value)
    	{
    		$transaction_name=TransactionName::where('id',$value->name_id)->first();
    		$transaction_type=TransactionType::where('id',$value->type_id)->first();
            $transaction_array[$key]['id']=$value->id;
    		$transaction_array[$key]['date']=$value->date;
    		$transaction_array[$key]['booking_id']=$value->booking_id; 
    		$transaction_array[$key]['transaction_name']=$transaction_name->name;
    		$transaction_array[$key]['amount']=$value->amount;
    		$transaction_array[$key]['order_id']=$value->order_id;
    		$transaction_array[$key]['payment_type']=$transaction_type->name;
    		$transaction_array[$key]['payment_status']=$value->payment_status;
    	}
    	return view('bookingid-receipt',compact('transaction_array'));	
    }
    public function transaction_modal($txn_id)
    {
        $transaction_array=array();
        $receipt=Transaction::where('id',$txn_id)->first();
            $transaction_name=TransactionName::where('id',$receipt->name_id)->first();
            $user_name=UserDetails::where('id',$receipt->users_id)->first();
            $transaction_method=TransactionMethod::where('id',$receipt->method_id)->first();

            $transaction_array['id']=$receipt->id;
            $transaction_array['date']=$receipt->date;
            $transaction_array['transaction_name']=$transaction_name->name;
            $transaction_array['amount']=$receipt->amount;
            $transaction_array['order_id']=$receipt->order_id;
            $transaction_array['payment_status']=$receipt->payment_status;
            $transaction_array['user_name']=$user_name->fname;
            if(isset($transaction_method->name))
            {
                $transaction_array['transaction_method']=$transaction_method->name;
            }
            else
            {
                $transaction_array['transaction_method']='';
            }
            $transaction_array['reference_id']=$receipt->reference_id;
            $transaction_array['booking_id']=$receipt->booking_id;
            $transaction_array['created_dts']=$receipt->created_dts;
            $transaction_array['txn_token']=$receipt->txn_token;
            $transaction_array['txnId']=$receipt->txnId;
            $transaction_array['bankTxnId']=$receipt->bankTxnId;
            $transaction_array['txnType']=$receipt->txnType;
            $transaction_array['gatewayName']=$receipt->gatewayName;
            $transaction_array['bankName']=$receipt->bankName;
            $transaction_array['paymentMode']=$receipt->paymentMode;
            $transaction_array['refundAmt']=$receipt->refundAmt;
            $transaction_array['authRefId']=$receipt->authRefId;

        return view('transaction-modal',compact('transaction_array'));
    }
 /// payments
    public function payments()
    {
        $transaction_array=array();
        return view('payments',compact('transaction_array'));
    }
    public function get_payment(Request $request)
    {
        $request->validate([
            'from_date' => 'required',
            'to_date' => 'required'

        ]);
        if(strtotime($request->from_date) > strtotime($request->to_date))
        {
            return redirect()->back()->with('error',"To date must be greater than from date.");
        }
    	$transaction_array=array();
		$receipt=Transaction::where('type_id',2)->whereBetween('date',[$request->from_date,$request->to_date])->orderBy('id','DESC')->limit(15)->get();
    	
    	foreach($receipt as $key=>$value)
    	{
    		$transaction_name=TransactionName::where('id',$value->name_id)->first();
            $transaction_array[$key]['id']=$value->id;
    		$transaction_array[$key]['date']=$value->date;
    		$transaction_array[$key]['transaction_name']=$transaction_name->name;
    		$transaction_array[$key]['amount']=$value->amount;
    		$transaction_array[$key]['order_id']=$value->order_id;
    		$transaction_array[$key]['payment_status']=$value->payment_status;
    	}
    	return view('payments',compact('transaction_array'));
    }
    public function payment_modal($txn_id)
    {
        $transaction_array=array();
        $receipt=Transaction::where('type_id',2)->where('id',$txn_id)->first();
            $transaction_name=TransactionName::where('id',$receipt->name_id)->first();
            $user_name=UserDetails::where('id',$receipt->users_id)->first();
            $transaction_method=TransactionMethod::where('id',$receipt->method_id)->first();

            $transaction_array['id']=$receipt->id;
            $transaction_array['date']=$receipt->date;
            $transaction_array['transaction_name']=$transaction_name->name;
            $transaction_array['amount']=$receipt->amount;
            $transaction_array['order_id']=$receipt->order_id;
            $transaction_array['payment_status']=$receipt->payment_status;
            $transaction_array['user_name']=$user_name->fname;
            if(isset($transaction_method->name))
            {
                $transaction_array['transaction_method']=$transaction_method->name;
            }
            else
            {
                $transaction_array['transaction_method']='';
            }
            $transaction_array['reference_id']=$receipt->reference_id;
            $transaction_array['booking_id']=$receipt->booking_id;
            $transaction_array['created_dts']=$receipt->created_dts;
            $transaction_array['txn_token']=$receipt->txn_token;
            $transaction_array['txnId']=$receipt->txnId;
            $transaction_array['bankTxnId']=$receipt->bankTxnId;
            $transaction_array['txnType']=$receipt->txnType;
            $transaction_array['gatewayName']=$receipt->gatewayName;
            $transaction_array['bankName']=$receipt->bankName;
            $transaction_array['paymentMode']=$receipt->paymentMode;
            $transaction_array['refundAmt']=$receipt->refundAmt;
            $transaction_array['authRefId']=$receipt->authRefId;

        return view('payment-modal',compact('transaction_array'));
    }
}
