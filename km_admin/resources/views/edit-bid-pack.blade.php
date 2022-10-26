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
                <h4>Edit Bid Packs</h4>
            </div>     
            <hr/> @include('includes.message')
            <div class="sp-div" id="sp-div">
                <form class="forms-sample" method="POST" action="{{ route('update-bid') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$edit_bid->id}}">
                    <hr>
                    <div class="row ">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="package_name">Package Name<span class="text-red">*</span></label>
                                <input type="text" name="package_name" id="package_name" class="form-control @error('package_name') is-invalid @enderror" value="{{$edit_bid->package_name}}">
                                <div class="help-block with-errors" ></div>
                                @error('package_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="bids">Bids<span class="text-red">*</span></label>
                                <input type="text" name="bids" id="bids" class="form-control @error('bids') is-invalid @enderror" value="{{$edit_bid->bids}}">
                                <div class="help-block with-errors"></div>
                                @error('bids')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="amount">Amount<span class="text-red">*</span></label>
                                <input type="text" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{$edit_bid->amount}}">
                                <div class="help-block with-errors" ></div>
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="validity">Validity <span class="text-red">*</span></label>
                                <select id="validity" class="form-control @error('validity') is-invalid @enderror" name="validity" aria-label="Default select example">
                                    <option value=''>Choose </option>
                                    <option value='1 Week' @if($edit_bid->validity=='1 Week')selected @endif>1 Week</option>
                                    <option value='2 Weeks' @if($edit_bid->validity=='2 Weeks')selected @endif>2 Weeks</option>
                                    <option value='3 Weeks' @if($edit_bid->validity=='3 Weeks')selected @endif>3 Weeks</option>
                                    <option value='1 Month' @if($edit_bid->validity=='1 Month')selected @endif>1 Month</option>
                                    <option value='2 Months' @if($edit_bid->validity=='2 Months')selected @endif>2 Months</option>
                                    <option value='3 Months' @if($edit_bid->validity=='3 Months')selected @endif>3 Months</option>
                                    <option value='6 Months' @if($edit_bid->validity=='6 Months')selected @endif>6 Months</option>
                                    <option value='No Validity' @if($edit_bid->validity=='No Validity')selected @endif>No Validity</option>
                                </select>
                                <div class="help-block with-errors" ></div>
                                @error('validity')
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
@endsection
