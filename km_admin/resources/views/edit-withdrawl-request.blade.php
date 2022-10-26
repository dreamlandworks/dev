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
                <h4>Edit Withdrawl Request</h4>
            </div>     
            <hr/> @include('includes.message')
            <div class="row">
                <div class="col-sm-6">
                    <span> <b>Requested ID:</b> {{$id}}</span>
                </div>
            </div>
            <br>
            <div class="row" id="u_id">
                <div class="col-sm-3">
                    
                    <input id="txnID_search" class="form-control" type="text" placeholder="Search Transaction ID" aria-label="Search" name="txnID" value=" @if(isset($transaction_det->id)){{$transaction_det->id}} @endif">
                    <label>Transaction Id<span class="text-red">*</span></label>
                    <div id="txnID_msg">
                    @error('transaction_id')
                        <span style="color:red;" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                     </div>
                </div>
                <div class="col-sm-2">
                    <button type="button" id="gettxn_id" class="btn btn-primary" onclick="getTxnID()">GET</button>
                </div>
                <div class="col-sm-7" id="spuser">
                    <table class="table table-bordered table-hover dataTable no-footer" >
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody id="txn_table">
                            @if(isset($transaction_det->id))
                            <tr>
                                <td>{{$transaction_det->id}}</td>
                                <td>{{$transaction_det->date}}</td>
                                <td>{{$transaction_det->amount}}</td>
                                <td>{{$transaction_det->payment_status}}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="sp-div" id="sp-div">
                <form class="forms-sample" method="POST" action="{{ route('edit-withdrawl') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{$id}}">
                    <div class="row ">
                        <input type="hidden" name="transaction_id" id="transaction_id" value="@if(isset($transaction_det->id)){{$transaction_det->id}} @endif">
                        <!-- <div class="col-sm-4">
                            <div class="form-group">
                                <label for="transaction_id">Transaction ID<span class="text-red">*</span></label>
                                <input type="text" name="transaction_id" id="transaction_id" class="form-control @error('transaction_id') is-invalid @enderror" value="{{$editrequest->transaction_id}}">
                                <div class="help-block with-errors" ></div>
                                @error('transaction_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> -->
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="credited_on">Credited on<span class="text-red">*</span></label>
                                <input type="date" name="credited_on" id="credited_on" class="form-control @error('credited_on') is-invalid @enderror" value="@if(isset($transaction_det->id)){{date('Y-m-d',strtotime($editrequest->created_on))}}@endif">
                                <div class="help-block with-errors" ></div>
                                @error('credited_on')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="status">Status<span class="text-red">*</span></label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="">----Select----</option>
                                    <option value="Success" @if(isset($transaction_det->id)) @if(($transaction_det->payment_status)=="Success")
                                    selected @endif
                                     @endif >Success</option>
                                    <option value="Failure" @if(isset($transaction_det->id)) @if(($transaction_det->payment_status)=="Failure")
                                    selected @endif
                                     @endif >Failure</option> 
                                </select>
                                <div class="help-block with-errors" ></div>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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

<script>
function getTxnID()
{ 
    if(($('#txnID_search').val())=='')
    {
        $('#txnID_msg').html('<span style="color:red">Please enter transaction id.</span>');
        return;
    }
    else
    {
        $('#txnID_msg').html('');
    } 

    $.ajax({
        type: "GET",
        url: "/km_admin/account/gettxnDetails",
        data: {"txn_id":$("#txnID_search").val()},
        success: function(data)
        {
            console.log(data);

            if(data=='')
            {
                $('#txnID_msg').html('<span style="color:red">Incorrect transaction id.</span>');
                $('#txn_table').html('<tr><td colspan=4 style="text-align:center;">No Records Found</td></tr>');
            }
            else
            {
                $('#txn_table').html('<tr><td>'+data.id+'</td><td>'+data.date+'</td><td>'+data.amount+'</td><td>'+data.payment_status+'</td></tr>');
                $('#transaction_id').val(data.id);
            }
        }
        });
}
    
</script>

@endsection

