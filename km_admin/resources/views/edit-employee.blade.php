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
.custom-control.custom-switch.mk {
    margin-left: 50px;
    margin-top: 37px;
}
</style>
<div class="content-wrapper">
    <div class="container-fluid container_rv">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="heading">
                <i class="icon fa fa-user"></i>
                <h4>Edit Employee</h4>
            </div> 
            <hr/>@include('includes.message')
            <div class="sp-div" id="sp-div">
            <form class="forms-sample" method="POST" action="{{ route('edit-employee') }}" enctype="multipart/form-data">
                @csrf
                <div class="row ">
            <div class="col-md-12 col-sm-12">
                <div class="portlet box purple-wisteria">
                    <div class="portlet-title">
                        <div class="caption">
                            <h3><i class="fa fa-calendar"></i> Personal Details</h3>
                        </div>
                    </div>
                    <hr/>
                    <input type="hidden" name="id" value="{{$emp_det->id}}">
                    <div class="sp-div" id="sp-div">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="name">Name<span class="text-red">*</span></label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$emp_det->name}}">
                                    <div class="help-block with-errors" ></div>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="father_name">Father's Name<span class="text-red">*</span></label>
                                    <input id="father_name" type="text" class="form-control @error('father_name') is-invalid @enderror" name="father_name" value="{{$emp_det->father_name}}">
                                    <div class="help-block with-errors" ></div>
                                    @error('father_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="date_of_birth">Date of Birth<span class="text-red">*</span></label>
                                    <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{$emp_det->date_of_birth}}">
                                    <div class="help-block with-errors" ></div>
                                    @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="gender">Gender<span class="text-red">*</span></label>
                                    <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" aria-label="Default select example">
                                    <option value=''>Choose </option>
                                    <option @if($emp_det->gender=='male')selected @endif value='male'>Male </option>
                                    <option @if($emp_det->gender=='female')selected @endif value='female'>Female </option>
                                    <option @if($emp_det->gender=='others')selected @endif value='others'>Others </option>
                                    </select>
                                    <div class="help-block with-errors" ></div>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="mobile_no">Mobile No.<span class="text-red">*</span></label>
                                    <input id="mobile_no" type="number" class="form-control @error('mobile_no') is-invalid @enderror" name="mobile_no" value="{{$emp_det->mobile_no}}">
                                    <div class="help-block with-errors" ></div>
                                    @error('mobile_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="local_address">Local Address<span class="text-red">*</span></label>
                                    <textarea id="local_address" class="form-control @error('local_address') is-invalid @enderror" name="local_address">{{$emp_det->local_address}}</textarea>
                                    <div class="help-block with-errors" ></div>
                                    @error('local_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="permanent_address">Permanent Address<span class="text-red">*</span></label>
                                    <textarea id="permanent_address" class="form-control @error('permanent_address') is-invalid @enderror" name="permanent_address">{{$emp_det->permanent_address}}</textarea>
                                    <div class="help-block with-errors" ></div>
                                    @error('local_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3">
                            <div class="form-group">
                                <label for="photo">Photo<span class="text-red">*</span></label>
                                <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" onchange="doc_preview('photo')">
                                <div class="help-block with-errors" id="photo_error" ></div>
                                @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <button type="button" style="border: 0px;margin-top: 10px;" onclick="showDocument('photo','/km_admin/{{$emp_det->document_path}}/{{$emp_det->photo}}')">
                                    <div id="photoField">
                                        <img id="photoPreview" src="/km_admin/{{$emp_det->document_path}}/{{$emp_det->photo}}" style="margin-top: 10px" width="100px" alt="Employee Photo">
                                    </div>
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="custom-control custom-switch mk">
                                <input type="checkbox" class="custom-control-input" id="customSwitches" name="status" value="on" {{$emp_det->status == 'on' ? 'checked':''}}>
                                <label class="custom-control-label" for="customSwitches">Status</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="caption">
                        <h5>Account Login</h5>
                    </div>
                    <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="email">Email<span class="text-red">*</span></label>
                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$emp_det->email}}">
                            <div class="help-block with-errors" ></div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="password">Password<span class="text-red">*</span></label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="">
                            <div class="help-block with-errors" ></div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-actions"></div>   
            </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="portlet box red-sunglo">
                        <div class="portlet-title">
                            <div class="caption">
                                <h3><i class="fa fa-calendar"></i> Company Details</h3>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="employee_id">Employee ID<span class="text-red">*</span></label>
                                    <input id="employee_id" type="text" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" value="{{$emp_det->employee_id}}">
                                    <div class="help-block with-errors" ></div>
                                    @error('employee_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="date_of_joining">Date of Joining<span class="text-red">*</span></label>
                                    <input id="date_of_joining" type="date" class="form-control @error('date_of_joining') is-invalid @enderror" name="date_of_joining" value="{{$emp_det->date_of_joining}}">
                                    <div class="help-block with-errors" ></div>
                                    @error('date_of_joining')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="department">Department<span class="text-red">*</span></label>
                                    <select id="department" class="form-control @error('department') is-invalid @enderror" name="department" aria-label="Default select example">
                                    <option value=''>Choose </option>
                                    @foreach($department as $desg_value)
                                        <option @if($emp_det->department==$desg_value->id)selected @endif value={{$desg_value->id}}>{{$desg_value->department_name}} </option>
                                    @endforeach
                                    </select>
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
                                    <label for="designation">Designation<span class="text-red">*</span></label>
                                    <select id="designation" class="form-control @error('designation') is-invalid @enderror" name="designation" aria-label="Default select example">
                                    <option value=''>Choose </option>
                                    @if($emp_det->designation)<option value='{{$emp_det->designation}}' selected>{{$emp_det->designation}} </option> @endif
                                    
                                    </select>
                                    <div class="help-block with-errors" ></div>
                                    @error('designation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="joining_salery">Joining Salery<span class="text-red">*</span></label>
                                    <input id="joining_salery" type="text" class="form-control @error('joining_salery') is-invalid @enderror" name="joining_salery" value="{{$emp_det->joining_salery}}">
                                    <div class="help-block with-errors" ></div>
                                    @error('joining_salery')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-actions"></div>
                        <div class="portlet box red-sunglo">
                            <div class="portlet-title">
                                <div class="caption">
                                    <h3><i class="fa fa-calendar"></i>Bank Account Details</h3>
                                </div>
                            </div>
                            <hr/>
                            <div class="sp-div"> 
                                <div class="row"> 
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="account_holder_name">Account Holder Name<span class="text-red">*</span></label>
                                            <input id="account_holder_name" type="text" class="form-control @error('account_holder_name') is-invalid @enderror" name="account_holder_name" value="{{$emp_det->account_holder_name}}">
                                            <div class="help-block with-errors" ></div>
                                            @error('account_holder_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="account_number">Account Number<span class="text-red">*</span></label>
                                            <input id="account_number" type="text" class="form-control @error('account_number') is-invalid @enderror" name="account_number" value="{{$emp_det->account_number}}">
                                            <div class="help-block with-errors" ></div>
                                            @error('account_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="bank_name">Bank Name<span class="text-red">*</span></label>
                                            <input id="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{$emp_det->bank_name}}">
                                            <div class="help-block with-errors" ></div>
                                            @error('bank_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="ifsc_code">IFSC Code<span class="text-red">*</span></label>
                                            <input id="ifsc_code" type="text" class="form-control @error('ifsc_code') is-invalid @enderror" name="ifsc_code" value="{{$emp_det->ifsc_code}}">
                                            <div class="help-block with-errors" ></div>
                                            @error('ifsc_code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="pan_number">PAN Number<span class="text-red">*</span></label>
                                            <input id="pan_number" type="text" class="form-control @error('pan_number') is-invalid @enderror" name="pan_number" value="{{$emp_det->pan_number}}">
                                            <div class="help-block with-errors" ></div>
                                            @error('pan_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="branch">Branch<span class="text-red">*</span></label>
                                            <input id="branch" type="text" class="form-control @error('branch') is-invalid @enderror" name="branch" value="{{$emp_det->branch}}">
                                            <div class="help-block with-errors" ></div>
                                            @error('branch')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-actions"></div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-12 col-sm-12">
                                    <div class="portlet box purple-wisteria">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                <h3><i class="fa fa-calendar"></i>Documents</h3>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class='row'>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="resume">Resume<span class="text-red">*</span></label>
                                                    <input id="resume" type="file" class="form-control @error('resume') is-invalid @enderror" name="resume" onchange="doc_preview('resume')">
                                                    <div class="help-block with-errors" id="resume_error" ></div>
                                                    @error('resume')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <button type="button" style="border: 0px;margin-top: 10px;" onclick="showDocument('resume','/km_admin/{{$emp_det->document_path}}/{{$emp_det->resume}}')">
                                                        <div id="resumeField">
                                                            <embed id='resumePreview' src="/km_admin/{{$emp_det->document_path}}/{{$emp_det->resume}}" style="margin-top: 10px" width="100px"/>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="offer_letter">Offer Letter<span class="text-red">*</span></label>
                                                    <input id="offer_letter" type="file" class="form-control @error('offer_letter') is-invalid @enderror" name="offer_letter" onchange="doc_preview('offer_letter')">
                                                    <div class="help-block with-errors" id="offer_letter_error" ></div>
                                                    @error('offer_letter')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <button type="button" style="border: 0px;margin-top: 10px;" onclick="showDocument('offer_letter','/km_admin/{{$emp_det->document_path}}/{{$emp_det->offer_letter}}')">
                                                        <div id="offer_letterField">
                                                            <embed id='offer_letterPreview' src="/km_admin/{{$emp_det->document_path}}/{{$emp_det->offer_letter}}" style="margin-top: 10px" width="100px"/>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="joining_letter">Joining Letter<span class="text-red">*</span></label>
                                                    <input id="joining_letter" type="file" class="form-control @error('joining_letter') is-invalid @enderror" name="joining_letter" onchange="doc_preview('joining_letter')">
                                                    <div class="help-block with-errors" id="joining_letter_error" ></div>
                                                    @error('joining_letter')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <button type="button" style="border: 0px;margin-top: 10px;" onclick="showDocument('joining_letter','/km_admin/{{$emp_det->document_path}}/{{$emp_det->joining_letter}}')">
                                                        <div id="joining_letterField">
                                                            <embed id='joining_letterPreview' src="/km_admin/{{$emp_det->document_path}}/{{$emp_det->joining_letter}}" style="margin-top: 10px" width="100px"/>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="contract_and_agreement">Contract and Agreement<span class="text-red">*</span></label>
                                                    <input id="contract_and_agreement" type="file" class="form-control @error('contract_and_agreement') is-invalid @enderror" name="contract_and_agreement" onchange="doc_preview('contract_and_agreement')">
                                                    <div class="help-block with-errors" id="contract_and_agreement_error" ></div>
                                                    @error('contract_and_agreement')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <button type="button" style="border: 0px;margin-top: 10px;" onclick="showDocument('contract_and_agreement','/km_admin/{{$emp_det->document_path}}/{{$emp_det->contract_and_agreement}}')">
                                                        <div id="contract_and_agreementField">
                                                            <embed id='contract_and_agreementPreview' src="/km_admin/{{$emp_det->document_path}}/{{$emp_det->contract_and_agreement}}" style="margin-top: 10px" width="100px"/>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="id_proof">ID Proof<span class="text-red">*</span></label>
                                                    <input id="id_proof" type="file" class="form-control @error('id_proof') is-invalid @enderror" name="id_proof" onchange="doc_preview('id_proof')">
                                                    <div class="help-block with-errors" id="id_proof_error" ></div>
                                                    @error('id_proof')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <button type="button" style="border: 0px;margin-top: 10px;" onclick="showDocument('id_proof','/km_admin/{{$emp_det->document_path}}/{{$emp_det->id_proof}}')">
                                                        <div id="id_proofField">
                                                            <embed id='id_proofPreview' src="/km_admin/{{$emp_det->document_path}}/{{$emp_det->id_proof}}" width="100px" height="100px" style="margin-top:10px; "/>
                                                        </div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="clearfix"></div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
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
    </div>
</div>

<!-- Model -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-footer" style="padding:1px;">
                <button type="button" data-dismiss="modal" style="border: 0px;">
                    <i class="fa fa-times" aria-hidden='true'></i>
                </button>
            </div>
            <!-- Add image inside the body of modal -->
            <div class="modal-body" id="doc_show">
                <embed id="model_image" src="" style="width:1050px; height:550px;"/>
                <!-- <iframe id="model_image" src="" style="width:1050px; height:500px;" frameborder="0"> </iframe> -->
            </div>  
        </div>
    </div>
</div>

<!-- end model -->

@push('autocomp-khushbu')


    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

	<!--<script src="https://code.jquery.com/jquery-3.6.0.js"></script>-->
	<!--<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>-->

@endpush
<script>

function getdesignation(designation_id)
{
    console.log(designation_id);
    $.ajax({
        type:'POST',
        url:'/km_admin/employee/filterDesignation',
        data:{"designation_id":designation_id,"_token": "{{csrf_token()}}"},
        success:function(data){
            var desg_array = data.split(',');
            var designation_option="<option value=''>Choose</option>";
            $("#designation").empty();
            $.each(desg_array,function(key,value)
            { 
                //console.log(value);
                designation_option+="<option value='"+value+"'>"+value+"</option>";
            });
            $("#designation").append(designation_option);
        }
    });
    //designation
}

var departmentSelect=setTimeout(settOnchange,2000);
function settOnchange()
{
    $('#department').attr('onchange','getdesignation(this.value)');
}
</script>

<script>
function showDocument(fieldName,doc_url)
{
    $('#doc_show').empty();
    var new_doc=$('#'+fieldName+'Field').html();
    $('#'+fieldName+'Field').html('');
    $('#doc_show').append(new_doc);
    $('#'+fieldName+'Preview').css({'height':'550px','width':'1050px'});
    $('#'+fieldName+'Field').html(new_doc);
    $('#exampleModal').modal('show');
}
</script>

<!-- Adding scripts to use bootstrap -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity=
"sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous">
    </script>
    <script src=
"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity=
"sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous">
    </script>
    <script src=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity=
"sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous">
    </script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>

        function doc_preview(doc_field)
        {  
          var att_files = document.getElementById(doc_field);
          const file = att_files.files[0];

          let reader = new FileReader();
          reader.readAsDataURL(file);
          reader.onload = () => {
            let json = JSON.stringify({ dataURL: reader.result });
            let fileURL = JSON.parse(json).dataURL;
            $('#'+doc_field+'Field').empty();
            $('#doc_show').empty();
            $('#'+doc_field+'Button').attr('onclick','showDocument("'+doc_field+'","url")');

            let originalFileURL = URL.createObjectURL(file);
            $('#'+doc_field+'Field').append('<embed id="'+doc_field+'Preview" src='+fileURL+' style="margin-top: 10px" width="200px"/>').onload(() => {
              URL.revokeObjectURL(originalFileURL);
            });
          };
        }
    </script>
@endsection


