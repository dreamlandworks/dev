<style>
.col-sm-3.mk {
    float: left;
    padding-top: 30px;
    padding-right: 14px;
}
</style>
<div class="modal-dialog modal-xl" role="document" style="max-width:1000px !important;">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold" id ="modalContactForm_userinfo">Transaction  information</h4>
        <button type="button" id="sp-modal-close" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body mx-3">
            <div class="container">
                <div class="row">

                  <div class="col-sm-5">
                        <p><b>Date:</b>&nbsp;&nbsp;&nbsp;&nbsp; {{$transaction_array['date']}}</p>
                        <p><b>Transaction name:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['transaction_name']}}</p>
                        <p><b>Amount:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['amount']}}</p>
                        <p><b>Order id:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['order_id']}}</p>
                        <p><b>Payment status:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['payment_status']}}</p>
                        <p><b>User name:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['user_name']}}</p>
                        <p><b>Transaction method:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['transaction_method']}}</p>
                        <p><b>Reference id:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['reference_id']}}</p>
                        <p><b>Booking id:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['booking_id']}}</p>
                    </div>
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-5">
                        
                        <p><b>Created date:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['created_dts']}}</p>
                        <p><b>Transaction Token:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['txn_token']}}</p>
                        <p><b>Transaction Id:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['txnId']}}</p>
                        <p><b>Bank Transaction Id:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['bankTxnId']}}</p>
                        <p><b>Transaction Type:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['txnType']}}</p>
                        <p><b>Gateway Name:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['gatewayName']}}</p>    
                        <p><b>Bank Name:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['bankName']}}</p>
                        <p><b>Payment Mode:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['paymentMode']}}</p>
                        <p><b>Refund Amount:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['refundAmt']}}</p>
                        <p><b>Auth Ref Id:</b>&nbsp;&nbsp;&nbsp;&nbsp;{{$transaction_array['authRefId']}}</p>
                        
                    </div>

                </div>
            </div>
        </div>
      
    </div>
  </div>