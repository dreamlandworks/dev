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
</style>

<div class="content-wrapper">
    <div class="container-fluid container_rv">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="heading">
                <i class="icon fa fa-user"></i>
                <h4>Edit Service Provider</h4>
            </div>            
            <div class="row">                     
            </div>
            <div class="sp-div" id="sp-div">
                <form class="forms-sample" method="POST" action="{{  url('sp/update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="users_id" value="{{$sp->users_id}}">
                    <div class="row">
                        <input type="hidden" id="user_fname" name="mobile" value=""/>
                        <input type="hidden" id ="user_lname" name="email" value=""/>
                    <input type="hidden" id="user_approved_id" name="approve_id" value=""/>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleSelect">Profession<span class="text-red">*</span></label>
                                <div class="input-group-append">
                                    <select class="form-control" id="exampleSelect" name="profession">
                                        <option>Please Select Profession</option>
                                        @foreach($sp_professions as $sp_profession)
                                        <option value="{{$sp_profession->id}}" {{$sp->profession_id == $sp_profession->id ? 'selected':''}}>{{$sp_profession->name}}</option>
                                        @endforeach
                                    </select> 
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <a href="" data-toggle="modal" data-target="#modalContactForm"><span class="text-red">+</span></a>
                                    </span>
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleSelect">Qualification<span class="text-red">*</span></label>
                                <div class="input-group-append">
                                    <select class="form-control" id="exampleSelect" name="qualification">
                                    <option>Please Select Qualification</option>
                                        @foreach($sp_quali as $sp_qua)
                                            <option value="{{$sp_qua->id}}" {{$sp->qual_id == $sp_qua->id ? 'selected':''}}>{{$sp_qua->qualification}}</option>
                                        @endforeach
                                    </select>
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <a href="" data-toggle="modal" data-target="#modalContactForm_Q"><span class="text-red">+</span></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="exampleSelect">Experience<span class="text-red">*</span></label>
                                <select class="form-control" id="exampleSelect" name="sp_exp">
                                <option>Please Select Experience</option>
                                    @foreach($sp_exps as $sp_exp)
                                        <option value="{{$sp_exp->id}}" {{$sp->exp_id == $sp_exp->id ? 'selected':''}}>{{$sp_exp->exp}}</option>
                                    @endforeach
                                
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="skill">Skills/Keyboards<span class="text-red">*</span></label>
                                <div class="input-group-append">
                                    <input id="tags" type="text" class="typeahead form-control @error('skill') is-invalid @enderror" name="skill" value="{{$saved_skill}}">
                                    <!-- <input id="tags" name="skill" size="50"> -->
                                    <input id="skill_id" type="hidden" value="{{$skill_keys}}">
                                    <div class="help-block with-errors" ></div>
                                    @error('skill')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <a href="" data-toggle="modal" data-target="#modalContactForm_skill"><span class="text-red">+</span></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="lang">Language<span class="text-red">*</span></label>
                                <div class="input-group-append">
                                    <input id="tag_lang" type="text" class="form-control @error('lang') is-invalid @enderror" name="lang" value="{{$saved_language}}">
                                    <input id="lang_id"  type="hidden" value="{{$languages}}">
                                    <div class="help-block with-errors" ></div>
                                    @error('lang')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span class="input-group-text" id="inputGroupPrepend">
                                        <a href="" data-toggle="modal" data-target="#modalContactForm_lang"><span class="text-red">+</span></a>
                                    </span>
                                </div>

                            </div>
                            
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="about_us">About Us<span class="text-red">*</span></label>
                                    <input id="about_us" type="text" class="form-control @error('about_us') is-invalid @enderror" name="about_us" value="{{$sp->about_me}}">
                                    <div class="help-block with-errors" ></div>
                                    @error('about_us')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="about_us">Gender<span class="text-red">*</span></label>
                                <select class="form-control" name="gender" aria-label="Default select example">
                                     <option value="male" {{$sp->gender == 'male' ? 'selected':''}}>Male</option>
                                    <option value="female" {{$sp->gender == 'female' ? 'selected':''}}>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="per_hour">Per Hour<span class="text-red">*</span></label>
                                    <div class="input-group-prepend">
                                            <span class="input-group-text mk_prepend">
                                                <span class="text-red">RS</span>
                                            </span>
                                        <input id="per_hour" type="text" class="form-control @error('per_hour') is-invalid @enderror" name="per_hour" value="{{$UserTimeSlot->per_hour}}">
                                    </div>
                                    <div class="help-block with-errors" ></div>
                                    @error('per_hour')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="per_day">Per Day<span class="text-red">*</span></label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text mk_prepend">
                                            <span class="text-red">RS</span>
                                        </span>
                                        <input id="per_day" type="text" class="form-control @error('per_day') is-invalid @enderror" name="per_day" value="{{$UserTimeSlot->per_day}}">
                                    </div>
                                    <div class="help-block with-errors" ></div>
                                    @error('per_day')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="min_charge">Min Charge<span class="text-red">*</span></label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text mk_prepend">
                                            <span class="text-red">RS</span>
                                        </span>
                                        <input id="min_charge" type="text" class="form-control @error('min_charge') is-invalid @enderror" name="min_charge" value="{{$UserTimeSlot->min_charges}}">
                                    </div>
                                    <div class="help-block with-errors" ></div>
                                    @error('min_charge')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="extra_charge">Extra Charge<span class="text-red">*</span></label>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text mk_prepend">
                                            <span class="text-red">RS</span>
                                        </span>
                                        <input id="extra_charge" type="text" class="form-control @error('extra_charge') is-invalid @enderror" name="extra_charge" value="{{$UserTimeSlot->extra_charge}}">
                                    </div>
                                    <div class="help-block with-errors" ></div>
                                    @error('extra_charge')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="availability">Availability<span class="text-red">*</span></label>
                                <select id="km-select" class="form-control" name="availability" aria-label="Default select example" >
                                <option>Choose Your Availability Day</option>
                                <option value="everyDay" {{$sp->availability_day == 'everyDay' ? 'selected' : ''}}>Every Day</option>
                                <option value="weakDay" {{$sp->availability_day == 'weakDay' ? 'selected' : ''}}>Week Day</option>
                                <option value="weakDay" {{$sp->availability_day == 'weakEnd' ? 'selected' : ''}}>Week End</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="IDProof">ID Proof<span class="text-red">*</span></label>
                                    <input id="photo" type="file" class="form-control @error('IDProof') is-invalid @enderror" name="IDProof" value="">
                                    <div class="help-block with-errors" ></div>
                                    @error('IDProof')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        @if($spVerify->id_card)
                        <div class="col-sm-3"  >
                            <img id="imgPreview" src="{{asset('images/id_proof')}}/{{$spVerify->id_card}}" alt="pic"style="height:150px; width:200px;" class="img-fluid" />
                        </div>
                        @else
                        <div class="col-sm-3"  >
                            <img id="imgPreview" src="{{asset('images/user_profile/dummy.png')}}" alt="pic"style="height:150px; width:200px;" class="img-fluid" />
                        </div>
                        @endif
                       
                        <div id="allDay" class="col-sm-3" style=" @if(($sp->availability_day)=='everyDay')display:block @else display:none @endif ">
                            <div class="form-group">
                                <label for="choose_day">Choose Day<span class="text-red">*</span></label>
                                <select id="e2" class="form-control selectpicker" name="choose_day[]" multiple data-live-search="true" onchange="all_slot()">
                                    @foreach($day_slots as $day_slot)
                                        <option id="day_st2" value="{{$day_slot->id}} " selected>{{$day_slot->day}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id ="weakDay" class="col-sm-3" style=" @if(($sp->availability_day)=='weakDay')display:block @else display:none @endif ">
                            <div class="form-group">
                                <label for="choose_day">Choose Day<span class="text-red">*</span></label>
                                <select id="e1" class="form-control selectpicker" name="choose_day[]" multiple data-live-search="true" onchange="day_slot()">
                                    @foreach($day_slots as $day_slot)
                                        @php
                                        $selected='';
                                        foreach($user_time_slot as $savedDayslot)
                                        {
                                            if(($savedDayslot->day_slot)==($day_slot->id))
                                            {
                                                $selected="selected";
                                            }
                                        }
                                        @endphp
                                        <option id="day_st" value="{{$day_slot->id}}" {{$selected}}>{{$day_slot->day}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group time-slot">
                                @php
                                    $counter=0;
                                @endphp
                                @foreach($user_time_slot as $savedTimeslot)
                                    @php
                                        if(($sp->availability_day)!='everyDay')
                                        {
                                            $counter=0;  
                                        }
                                    @endphp
                                <input type="hidden" value="{{$savedTimeslot->day_slot}}" id="st_time" name="st_time[]"/>
                                    @if($counter==0)
                                    <label for="start_time">From<span class="text-red">*</span></label>
                                    <select class="form-control" name="start_time[]" aria-label="Default select example">
                                        @foreach($time_slots as $time_slot)
                                            <option value="{{$time_slot->from}}" @if(($savedTimeslot->time_slot_from)==($time_slot->from))selected @endif >{{$time_slot->from}}</option>
                                        @endforeach
                                    </select>
                                    @php
                                        $counter++;
                                    @endphp
                                    @endif
                                @endforeach
                                    <div class="help-block with-errors" ></div>
                                    @error('strat_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                    

                        <div class="col-sm-2">
                            <div class="form-group end-time-slot">
                                @php
                                    $counter=0;
                                @endphp
                                @foreach($user_time_slot as $savedTimeslot)
                                    @php
                                        if(($sp->availability_day)!='everyDay')
                                        {
                                            $counter=0;  
                                        }
                                    @endphp
                                <input type="hidden" value="{{$savedTimeslot->day_slot}}" id="en_time" name="en_time[]"/>
                                @if($counter==0)
                                 <label for="end_time">To<span class="text-red">*</span></label>
                                    <select class="form-control" name="end_time[]" aria-label="Default select example">
                                        @foreach($time_slots as $time_slot)
                                            <option value="{{$time_slot->from}}" @if(($savedTimeslot->time_slot_to)==($time_slot->from))selected @endif>{{$time_slot->from}}</option>
                                        @endforeach
                                    </select>
                                    @php
                                        $counter++;
                                    @endphp
                                    @endif
                                @endforeach
                                    <div class="help-block with-errors" ></div>
                                    @error('end_time')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                
                            </div>
                            <!-- <div class="input-group-append">
                                <span class="input-group-text" id="inputGroupPrepend">
                                    <a href="" data-toggle="modal" data-target="#modalContactForm_slot"><span class="text-red">+</span></a>
                                </span><span style="margin-left:10px;">Add More Slot</span>
                            </div> -->
                                    
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" id="sp-submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div> 
                    </div>
                </form>
            </div>
        </div>          
    </div>
</div>

<!-- Modal -->
<!-- Add Profession Modal -->

<div class="modal fade" id="modalContactForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true" data-backdrop="none">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Add Profession</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-4">
          <input type="text" id="name" class="form-control validate" name="name">
          <label data-error="wrong" data-success="right" for="form34">Profession name</label>
        </div>
        <div class="md-form mb-5">
            <select class="form-control" id="category" name="category">
                @foreach(DB::table('category')->get() as $cat)
                    <option value="{{$cat->id}}">{{$cat->category}}</option>
                @endforeach
            </select>
            <label data-error="wrong" data-success="right" for="form34">Category</label>
        </div>
        <div class="md-form mb-2">
            <select class="form-control" id="subcategory" name="sub_name">
                @foreach(DB::table('subcategories')->get() as $sb_cat)
                    <option value="{{$sb_cat->id}}">{{$sb_cat->sub_name}}</option>
                @endforeach
            </select>
        <label data-error="wrong" data-success="right" for="form34">SubCategory</label>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" id="submit-btn" type="button" onclick="submit_form()">Submit</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Qualification Modal -->

<div class="modal fade" id="modalContactForm_Q" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Add Qualification</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <input type="text" id="qualification" class="form-control validate" name="qualification">
          <label data-error="wrong" data-success="right" for="form34">Qualification</label>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" id="submit-qua" type="button" onclick="submit_qua()">Submit</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Skill/Keywords Modal -->
<div class="modal fade" id="modalContactForm_skill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Add Skills/Keyword</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <input type="text" id="keyword" class="form-control validate" name="keyword">
          <label data-error="wrong" data-success="right" for="form34">Skills/Keyword</label>
        </div>
        <div class="md-form mb-2">
            <select class="form-control" id="profession" name="profession">
            <option>Choose Your Profession</option>
                @foreach(DB::table('list_profession')->get() as $profession)
                    <option value="{{$profession->id}}">{{$profession->name}}</option>
                @endforeach
            </select>
            <label data-error="wrong" data-success="right" for="form34">Profession</label>
        </div>
        <div class="md-form mb-2">
            <div class="custom-control custom-switch ml-5">
            <input type="checkbox" class="custom-control-input" id="customSwitches" name="status">
            <label class="custom-control-label" for="customSwitches">Status</label>
            </div>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" id="submit-skill" type="button" onclick="submit_skill()">Submit</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Language Modal -->

<div class="modal fade" id="modalContactForm_lang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Add Language</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <input type="text" id="language" class="form-control validate" name="language">
          <label data-error="wrong" data-success="right" for="form34">Language</label>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" id="submit-lang" type="button" onclick="submit_lang()">Submit</button>
      </div>
    </div>
  </div>
</div>

<!--Add Time Slot-->
<div class="modal fade" id="modalContactForm_slot" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Add Time Slot</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <input type="time" id="from" class="form-control validate" name="from">
          <label data-error="wrong" data-success="right" for="form34">Time Slot</label>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" id="submit-slot" type="button" onclick="submit_slot()">Submit</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->


<?php 
$options='';
foreach($time_slots as $time_slot){
                
    $options .= '<option value="'.$time_slot->from.'">'.$time_slot->from.'</option>';
                
} 
// dd($options);

//$day_slots
?>

@push('autocomp-khushbu')
<script>
function submit_form()
{
    $.ajax({
        type: "POST",
        url: "profession/create",
        data: { "id": $("submit-btn").val(),"name":$("#name").val(),"sub_name": $("#subcategory").val(),"category": $('#category').val(), "_token": "{{ csrf_token() }}",},
        success:function(data){
            if(data==1){
                $('#modalContactForm').hide();
                $('.modal-backdrop').remove();
            }          
    }});
}
</script>

<script>
    function submit_qua()
    {
        $.ajax({
                type: "POST",
                url: "qualification/create",
                data: { "id": $("submit-qua").val(),"qualification":$("#qualification").val(), "_token": "{{ csrf_token() }}",},
                success:function(data){
                    if(data==1){
                        $('#modalContactForm_Q').hide();
                        $('.modal-backdrop').remove();
                    }          
            }});
    }
</script>

<script>
    function submit_skill()
    {
        $.ajax({
                type: "POST",
                url: "skill/create",
                data: { "id": $("submit-skill").val(),"keyword":$("#keyword").val(),"profession":$("#profession").val(),"status":$("#customSwitches").val(), "_token": "{{ csrf_token() }}",},
                success:function(data){
                    if(data==1){
                        $('#modalContactForm_skill').hide();
                        $('.modal-backdrop').remove();
                    }          
            }});
    }
</script>
<script>
    function submit_lang()
    {
        $.ajax({
                type: "POST",
                url: "language/create",
                data: { "id": $("submit-lang").val(),"language":$("#language").val(),"_token": "{{ csrf_token() }}",},
                success:function(data){
                    if(data==1){
                        $('#modalContactForm_lang').hide();
                        $('.modal-backdrop').remove();
                    }          
            }});
    }
</script>
<script>
function submit_slot()
{
    $.ajax({
            type: "POST",
            url: "slot/create",
            data: { "id": $("submit-slot").val(),"from":$("#from").val(),"_token": "{{ csrf_token() }}",},
            success:function(data){
                if(data==1){
                    $('#modalContactForm_slot').hide();
                    $('.modal-backdrop').remove();
                }          
        }});
}
</script>

<!--MultiSelect-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
         <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<!--Multiselect-->

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="/resources/demos/style.css">
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    <script>
    function day(){
        if($("#km-select").val() == "everyDay")
        {
            // $('#allDay').removeAttr('style');
            $('#allDay').show();
            $('#weakDay').hide();

            var data =  Array.from(document.getElementById("e2").options).filter(option => option.selected).map(option => option.value);
            var options='{!! $options !!}';
            console.log(data);
            console.log(options);

            $('.time-slot').html('');
            $('.end-time-slot').html('');
           
            $.each(data, function(index,loopvalue){
                    $('.time-slot').append('<input type="hidden" value="'+loopvalue+'" id="st_time" name="st_time[]"/>')
                    $('.end-time-slot').append('<input type="hidden" value="'+loopvalue+'" id="en_time" name="en_time[]"/>')
                });
                $('.time-slot').append('<label for="start_time">From<span class="text-red">*</span></label><select  class="form-control" name="start_time[]" aria-label="Default select example">'+ options+'</select>');
                $('.end-time-slot').append('<label for="end_time">To<span class="text-red">*</span></label><select  class="form-control" name="end_time[]" aria-label="Default select example">'+ options+'</select>');

        }if($("#km-select").val() == "weakDay")
        {
            $('#weakDay').removeAttr('style');
            $('#weakDay').show();
            $('#allDay').hide();
        }
    }
var departmentSelect=setTimeout(settOnchange,1500);
function settOnchange()
{
    $('#km-select').attr('onchange','day()');
}
    </script>
 <!--Multi Select -->
 <script type="text/javascript">

        
        function day_slot()
        {
          var data =  Array.from(document.getElementById("e1").options).filter(option => option.selected).map(option => option.value);
            
            //console.log(data);
            var len = [];
            var options='{!! $options !!}';
            len = (data.length);
            //console.log(options);
            $('.time-slot').html('');
            $('.end-time-slot').html('');

                $.each(data, function(index,loopvalue){
                    $('.time-slot').append('<input type="hidden" value="'+loopvalue+'" id="st_time" name="st_time[]"/><label for="start_time">From<span class="text-red">*</span></label><select  class="form-control" name="start_time[]" aria-label="Default select example">'+ options+'</select>');
                    $('.end-time-slot').append('<input type="hidden" value="'+loopvalue+'" id="en_time" name="en_time[]"/><label for="end_time">To<span class="text-red">*</span></label><select  class="form-control" name="end_time[]" aria-label="Default select example">'+ options+'</select>');

                });
        };
    </script>
 
    <script>
	$( function() {
        var availableTags = JSON.parse($("#skill_id").val());
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#tags" )
			// don't navigate away from the field on tab when selecting an item
			.on( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).autocomplete( "instance" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						availableTags, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					return false;
				}
			});
	} );
	</script>

    <script>
    $( function() {

        var availableTags1 = JSON.parse($("#lang_id").val());
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#tag_lang" )
			// don't navigate away from the field on tab when selecting an item
			.on( "keydown", function( event ) {
				if ( event.keyCode === $.ui.keyCode.TAB &&
						$( this ).autocomplete( "instance" ).menu.active ) {
					event.preventDefault();
				}
			})
			.autocomplete({
				minLength: 0,
				source: function( request, response ) {
					// delegate back to autocomplete, but extract the last term
					response( $.ui.autocomplete.filter(
						availableTags1, extractLast( request.term ) ) );
				},
				focus: function() {
					// prevent value inserted on focus
					return false;
				},
				select: function( event, ui ) {
					var terms = split( this.value );
					// remove the current input
					terms.pop();
					// add the selected item
					terms.push( ui.item.value );
					// add placeholder to get the comma-and-space at the end
					terms.push( "" );
					this.value = terms.join( ", " );
					return false;
				}
			});
	} );
    </script>

    <script>
        function getUser()
        {
            $.ajax({
            type: "GET",
            url: "user-detail",
            data: { "id": $("#get-user").val(),"mobile":$("#lbs_search").val(),},
            success:function(data){
                $('#fname').html(data.fname);
                $('#lname').html(data.lname);
                $('#mobile').html(data.mobile);
                $('#user_fname').val(data.fname);
                $('#user_lname').val(data.fname);
                $('#user_approved_id').val(data.id);
                // $('#no_record').val(data.no_record);
                $('#sp-div').removeAttr('style');
            }});

        }
       
    </script>
    
    
    <script>
        $(document).ready(()=>{
            $('#photo').change(function(){
                const file = this.files[0];
                console.log(file);
                if (file){
                let reader = new FileReader();
                reader.onload = function(event){
                    console.log(event.target.result);
                    $('#imgPreview').css({'height':'150px','width':'200px'});
                    $('#imgPreview').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
                }
    
            });
        });
    
    </script>
        

@endpush

@endsection

