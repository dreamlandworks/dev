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
                <h4>Edit Ticket</h4>
            </div>     
            <hr/> @include('includes.message')
            <div class="sp-div" id="sp-div">
                <form class="forms-sample" method="POST" action="{{ route('edit-ticket') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$edit_ticket->id}}">
                    <div class="row ">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="assign_person">Assign Person<span class="text-red">*</span></label>
                                <select name="assign_person" id="assign_person" class="form-control @error('assign_person') is-invalid @enderror">
                                    <option value=""> ---Select---</option>
                                    @foreach($employee as $person)
                                    <option value="{{$person->id}}" @if($edit_ticket->assign_person == $person->id)selected @endif>{{$person->name}} -- {{$person->designations}}</option>
                                    @endforeach
                                </select>
                                <div class="help-block with-errors" ></div>
                                @error('assign_person')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="priority">Priority<span class="text-red">*</span></label>
                                <select id="priority" class="form-control @error('priority') is-invalid @enderror" name="priority" aria-label="Default select example">
                                    <option value=''>Choose </option>
                                    <option value='Low' @if($edit_ticket->priority=="Low")selected  @endif >Low</option>
                                    <option value='Moderate' @if($edit_ticket->priority=="Moderate")selected  @endif >Moderate</option>
                                    <option value='High' @if($edit_ticket->priority=="High")selected  @endif >High</option>
                                    <option value='Urgent' @if($edit_ticket->priority=="Urgent")selected  @endif >Urgent</option>
                                </select>
                                
                                <div class="help-block with-errors" ></div>
                                @error('priority')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <input type="hidden" name="created_date" id="created_date" value="{{$edit_ticket->created_date}}">
                                
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="created_by">Created By<span class="text-red">*</span></label>
                                <input type="text" name="created_by" id="created_by" class="form-control @error('created_by') is-invalid @enderror" value="{{$edit_ticket->created_by}}" readonly>
                                <div class="help-block with-errors" ></div>
                                @error('created_by')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="description">Description<span class="text-red">*</span></label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{$edit_ticket->description}}</textarea>
                                <div class="help-block with-errors" ></div>
                                @error('description')
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
