@extends('layouts.master')
@section('title', 'User')
@section('content')

<style>
    .heading {
    display: flex;
    justify-content: left;
    align-items: center;
    position: relative;
    top: -12px;
}
.heading h4 {
    margin: 12px 0 0 12px;
}
.title {
    text-align: center;
}
.title h4 {
    margin: 0;
    padding: 0;
    color: #aaa;
    text-transform: capitalize;
}
.container_rv {
    background-color: #fff;
    /*width: 50% !important;*/
    /*height: 100% !important;*/
    margin: 50px auto;
    border: 2px solid #fff;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
    border-radius: 5px;
}
.container_rv .left {
    float: left;
    /*width: 50%;*/
    /*height: 100% !important;*/
    box-sizing: border-box;
}
.container_rv .right {
    float: right;
    margin-top: 30px;
    /*width: 50%;*/
    /*height: 100% !important;*/
    margin: 10px auto;
     background-color: red; 
}
.container_rv .right button {
    text-align: center;
}
.formBox {
    /*width: 80%;*/
    margin: 30px 15px;
    box-sizing: border-box;
    border-radius: 0px 0px 0px 0px;
}
.formBox input {
    width: 100%;
    margin-bottom: 20px;
    border-radius: 0px 0px 0px 0px;
}
.formBox input[type="text"] {
    border: none;
    border-bottom: 1px solid #aaa;
    outline: none;
    height: 30px;
    border-radius: 0px 0px 0px 0px;
}
.formBox input[type="text"]:focus {
    border-bottom: 1px solid #505fc7;
    box-shadow: none;
    border-radius: 0px 0px 0px 0px;
}

.formBox label {
    margin-top: 20px;
    margin-bottom: 20px;
}
.right .formBox {
    width: 80%;
    margin: 30px 15px;
    box-sizing: border-box;
}
.right .formBox .picture {
    background-color: #505fc7;
    width: 300px;
    height: 150px;
    border: 1px solid #eee;
    box-shadow: 0 15px 30px #505fc7;
    border-radius: 5px;
    margin-bottom: 20px;
}
.icon {
    width: 50px;
    height: 50px;
    background-color:#505fc7;
    color: #fff;
    font-size: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 4px;
}
.form-select:focus {
    border: 1px solid #dc3545 !important;
    box-shadow: none !important;
    color: #dc3545;
}
.form-select option:hover {
    background-color: #505fc7;
}
button.btn.btn-danger.rv-submit {
    background-color: #505fc7!important;
    border-color: #505fc7 !important;
}
.btn-custom {
    width: 126px;
    height: 36px;
    background-color: #505fc7;
    color: #fff;
    font-size: 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 25px;
    padding: 10px 10px;
    border: none;
}
button.btn.btn-danger.rv-submit:hover {
    border-color: #576482!important;
    background-color: #576482!important;
}
button#sp-submit {
    margin-top: 28px;
}
button#btn_mk {
    background: none;
    border: none;
}
div#u_id {
    padding-bottom: 40px;
}
input[type="radio"]{
   appearance: none;
   border: 1px solid #d3d3d3;
   width: 30px;
   height: 30px;
   content: none;
   outline: none;
   margin: 0;
   box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
}

input[type="radio"]:checked {
  appearance: none;
  outline: none;
  padding: 0;
  content: none;
  border: none;
}

input[type="radio"]:checked::before{
  position: absolute;
  color: green !important;
  content: "\00A0\2713\00A0" !important;
  border: 1px solid #d3d3d3;
  font-weight: bolder;
  font-size: 21px;
}
</style>

<div class="content-wrapper">
    <div class="container-fluid container_rv">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="heading">
                <i class="icon fa fa-user"></i>
                <h4>Create Withdrawl Request</h4>
            </div>     
            <hr/> @include('includes.message')
            <div class="sp-div" id="sp-div">
                <form class="forms-sample" method="POST" action="{{ route('create-withdrawl') }}">
                    @csrf
                    
                    <div class="row ">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="user_id">User ID<span class="text-red">*</span></label>
                                <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" onchange="walletBalance()">
                                    <option value="">Select</option>
                                    @foreach($user_id as $value)
                                    <option value="{{$value->users_id}}"> {{$value->users_id}}</option>
                                   @endforeach
                                </select>
                                <div class="help-block with-errors" ></div>
                                @error('user_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="wallet_balance">Wallet Balance<span class="text-red">*</span></label>
                                <input type="text" name="wallet_balance" id="wallet_balance" class="form-control @error('wallet_balance') is-invalid @enderror">
                                <div class="help-block with-errors" ></div>
                                @error('wallet_balance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="amount">Amount<span class="text-red">*</span></label>
                                <input type="text" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror">
                                <div class="help-block with-errors" ></div>
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="bank_account">To Bank Account<span class="text-red">*</span></label>
                                <div class="input-group-append">
                                    <select class="form-control @error('bank_account') is-invalid @enderror" id="bank_account" name="bank_account">
                                        <option value=""> Select</option>
                                        
                                        
                                       
                                    </select> 
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <a href="" data-toggle="modal" data-target="#modalContactForm"><span class="text-red">+</span></a>
                                    </span>
                                    <div class="help-block with-errors" ></div>
                                    @error('bank_account')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                
                            </div>
                        </div>

                    </div>
                    
                    <div class="form-actions">
                        <div class="row" style="margin-top:10px;">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>            
                </form>
            </div>
        </div>                
    </div>
</div>

<!-- Model -->

<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true" data-backdrop="none">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Add Bank Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-6">
        <div class="md-form mb-2">
          <input type="text" id="bank_name" class="form-control validate" name="bank_name">
          <label data-error="wrong" data-success="right" for="form34">Bank name</label>
        </div>
        <div class="md-form mb-2">
          <input type="text" id="account_no" class="form-control validate" name="account_no">
          <label data-error="wrong" data-success="right" for="form34">Account No.</label>
        </div>
        <div class="md-form mb-2">
            <input type="text" id="ifsc_code" class="form-control validate" name="ifsc_code">
        <label data-error="wrong" data-success="right" for="form34">IFSC Code</label>
        </div>
        <div class="md-form mb-2">
          <input type="text" id="branch" class="form-control validate" name="branch">
          <label data-error="wrong" data-success="right" for="form34">Branch</label>
        </div>
        <div class="md-form mb-2">
          <input type="text" id="micr" class="form-control validate" name="micr">
          <label data-error="wrong" data-success="right" for="form34">MICR</label>
        </div>
        <div class="md-form mb-2">
          <input type="text" id="city" class="form-control validate" name="city">
          <label data-error="wrong" data-success="right" for="form34">City</label>
        </div>
        <div class="md-form mb-2">
          <input type="text" id="district" class="form-control validate" name="district">
          <label data-error="wrong" data-success="right" for="form34">District</label>
        </div>
        <div class="md-form mb-2">
          <input type="text" id="state" class="form-control validate" name="state">
          <label data-error="wrong" data-success="right" for="form34">State</label>
        </div>
        <div class="md-form mb-5">
            <input type="text" id="bank_address" class="form-control validate" name="bank_address">
            <label data-error="wrong" data-success="right" for="form34">Bank Address</label>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" id="submit-btn" type="button" onclick="submit_form()">Submit</button>
      </div>
    </div>
  </div>
</div>

<!-- End Model -->
<script>
function submit_form()
{
    $.ajax({
        type: "POST",
        url: "/km_admin/account/create-bank",
        data: { 
            //"id": $("submit-btn").val(),
            "user_id": $("#user_id").val(),
            "bank_name":$("#bank_name").val(),
            "account_no":$("#account_no").val(),
            "ifsc_code":$("#ifsc_code").val(),
            "branch":$("#branch").val(),
            "micr":$("#micr").val(),
            "city":$("#city").val(),
            "district": $("#district").val(),
            "state": $('#state').val(),
            "bank_address": $('#bank_address').val(),
            "_token": "{{csrf_token()}}"
        },
        success:function(data){
            console.log(data);
            if(data==1){
                $('#modalContactForm').hide();
                $('.modal-backdrop').remove();
            }          
    }});
}
</script>

<script>
function walletBalance()
{ 
    $('#wallet_balance').val('');
    $.ajax({
        type: "GET",
        url: "/km_admin/account/wallet-balance",
        data: {"user_id":$("#user_id").val()},
        success: function(data)
        {
            $('#bank_account').empty();
            //$('#wallet_balance').val(data.amount);
            var balance=(data.balance);
            $('#wallet_balance').val(balance.amount);

            var ubd=(data.userbankdet);
            $('#bank_account').append('<option value='+ubd.account_no+'>'+ubd.account_no+' ');
        }
        });
}
    
</script>

@endsection

