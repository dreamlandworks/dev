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
</style>
<div class="content-wrapper">
    <div class="container-fluid container_rv">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="heading">
                <i class="icon fa fa-user"></i>
                <h4>Create Employee Attendence</h4>
            </div>     
            <hr/>@include('includes.message')
            <div class="sp-div" id="sp-div">
                <form class="forms-sample" method="POST" action="{{ route('create-attendence') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-3">
                            <h5 id="attendence_date">Date: {{ date('Y-m-d')}} </h5>
                            <input id="today_date" type="date" class="form-control" name="today_date" value="{{ date('Y-m-d')}}" onchange="att_date()">
                        </div>  
                    </div>
                    <hr>
                    <div class="row ">
                        <div class="col-sm-2">
                            <label for="employee_id">Employee ID<span class="text-red"></span></label>
                        </div>
                        <div class="col-sm-2">
                            <label for="name">Name<span class="text-red"></span></label>
                        </div>
                        <div class="col-sm-2">
                            <label for="status">Status<span class="text-red"></span></label>
                        </div>
                        <div class="col-sm-3">
                            <label for="type of leave" id='leave_label' style="display:none;">Type of Leave<span class="text-red"></span></label>
                        </div>
                        <div class="col-sm-3">
                            <label for="reason" id='reason_label' style="display:none;">Reason<span class="text-red"></span></label>
                        </div>
                    </div>
                    @php
                        $counter=0;
                    @endphp
                    @foreach($employee_detail as $each_emp)
                    <input type="hidden" name="id[]" value="{{$each_emp->id}}">
                        <div class="row ">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="employee_id[]" value="{{$each_emp->employee_id}}" readonly>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" value="{{$each_emp->name}}" readonly>
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div class="form-group">
                                    <label><input type="radio" name="status_{{$counter}}" value="Present" checked onclick="leaveReason('Present',{{$counter}})">Present</label>
                                    <label><input type="radio" name="status_{{$counter}}" value="Absent"onclick="leaveReason('Absent',{{$counter}})">Absent</label>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input  type="text" id="type_of_leave_{{$counter}}" class="form-control" name="type_of_leave[]" value="" style="display:none;">
                                    <div class="help-block with-errors" ></div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="reason_{{$counter}}" name="reason[]" value="" style="display:none;">
                                </div>
                            </div>
                        </div>
                        @php
                            $counter++;
                        @endphp
                    @endforeach
                    <div class="form-actions">
                        <div class="row">
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
<script type="text/javascript">
    function leaveReason(status,rowId)
    {
        console.log(status);
        if(status=="Absent")
        {
            $('#type_of_leave_'+rowId).attr('style','display:block');
            $('#reason_'+rowId).attr('style','display:block');
            $('#leave_label').show();
            $('#reason_label').show();
        }
        else
        {
            $('#type_of_leave_'+rowId).attr('style','display:none');
            $('#reason_'+rowId).attr('style','display:none');
        }
    }
    function att_date()
    {
        $('#attendence_date').html('Date: '+$('#today_date').val());
    }
</script>


