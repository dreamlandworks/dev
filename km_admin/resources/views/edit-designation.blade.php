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
.sub_button{
    margin-left: 20px;
}
</style>

<div class="content-wrapper">
  <div class="container-fluid container_rv">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="heading">
                        <i class="icon fa fa-user"></i>
                        <h4>Edit Designation and Pay Details</h4>
                    </div>
                   
                    
                    <hr/>
                    @include('includes.message')
                    <div class="sp-div" id="sp-div">
                        <form class="forms-sample" method="POST" action="{{ route('create-designation') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                            @php
                                $multi_desg=explode(',',$edit_designation->designation);
                            @endphp
                            
                                <input type="hidden" id="designation_id" name="designation_id" value="{{$edit_designation->id}}">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="department">Department<span class="text-red">*</span></label>
                                            <input id="department" type="text" class="form-control @error('department') is-invalid @enderror" name="department" value="{{$edit_designation->department_name}}">
                                            <div class="help-block with-errors" ></div>
                                            @error('department')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="user_type">User Type<span class="text-red">* </span> (Related to department)</label>
                                            <select class="form-control @error('user_type') is-invalid @enderror" name="user_type">
                                                <option value="">---Select User Type---</option>
                                                <option value="Operation" @if($edit_designation->user_type=="Operation")selected @endif>Operations</option>
                                                <option value="Marketing" @if($edit_designation->user_type=="Marketing")selected @endif>Marketing</option>
                                                <option value="Support" @if($edit_designation->user_type=="Support")selected @endif>Support</option>
                                                <option value="HR" @if($edit_designation->user_type=="HR")selected @endif>HR</option>
                                                <option value="Account" @if($edit_designation->user_type=="Account")selected @endif>Account</option>
                                            </select>
                                            <div class="help-block with-errors" ></div>
                                            @error('user_type')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="pay">Pay<span class="text-red">*</span></label>
                                            <input id="pay" type="text" class="form-control @error('pay') is-invalid @enderror" name="pay" value="{{$edit_designation->pay}}">
                                            <div class="help-block with-errors" ></div>
                                            @error('pay')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="no_of_leave">No.Of Leave<span class="text-red">*</span></label>
                                            <input id="no_of_leave" type="text" class="form-control @error('no_of_leave') is-invalid @enderror" name="no_of_leave" value="{{$edit_designation->no_of_leave}}">
                                            <div class="help-block with-errors" ></div>
                                            @error('no_of_leave')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6" id="add_designation">
                                    
                                        <div class="form-group">
                                            <label for="designation">Designation<span class="text-red">*</span></label>
                                            @foreach($multi_desg as $all_desg)
                                                <input type="text" class="form-control @error('designation') is-invalid @enderror" name="designation[]" value="{{$all_desg}}" style="margin-bottom:15px;">
                                                <div class="help-block with-errors" ></div>
                                                @error('designation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            @endforeach
                                        </div>
                                    
                                </div>
                            </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary" onclick="designation_add()">Add More Designation</button>
                                        </div>
                                    </div>
                                </div>
                            <!-- <div class="col-sm-4">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary">Submit</button>
                                </div>
                            </div> --> 

                            <div class="form-actions">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <button type="submit" class="sub_button btn btn-primary">Submit</button>
                                </div>
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

<script>
function designation_add()
{
           $("#add_designation").append("<div class='form-group'><input  type='text' class='form-control @error('designation') is-invalid @enderror' name='designation[]'></div>");    
}

</script>

