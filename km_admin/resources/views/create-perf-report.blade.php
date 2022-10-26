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
                <h4>Create Employee performance</h4>
            </div>     
            <hr/>
            <div class="sp-div" id="sp-div">
                <form class="forms-sample" method="POST" action="{{ route('performance-report') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row ">
                        <div class="portlet-title">
                            <div class="caption">
                                <h3>Employee Info</h3>
                            </div>
                        </div>
                    </div>
                    <hr>@include('includes.message')
                    <div class="row ">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="employee_name">Employee Name<span class="text-red">*</span></label>
                                <select class="form-control @error('employee_name') is-invalid @enderror" name="employee_name" id="employee_name" onchange="getEmpDetail();">
                                    <option value="">Select Employee name</option>
                                    @foreach($employee_detail as $value)
                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                    @endforeach
                                </select>
                                <div class="help-block with-errors" ></div>
                                @error('employee_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="employee_id">Employee ID<span class="text-red">*</span></label>
                                <input type="text" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" id="employee_id" readonly>
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
                                <label for="department">Department<span class="text-red">*</span></label>
                                <select id="department" class="form-control @error('department') is-invalid @enderror" name="department" aria-label="Default select example" readonly>
                                <option value=''>Choose </option>
                                @foreach($department as $desg_value)
                                    <option value={{$desg_value->id}}>{{$desg_value->department_name}} </option>
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
                                <select id="designation" class="form-control @error('designation') is-invalid @enderror" name="designation" aria-label="Default select example" readonly>
                                <option value=''>Choose </option> 
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
                                <label for="joining_date">Joining Date<span class="text-red">*</span></label>
                                <input id="joining_date" type="date" class="form-control @error('joining_date') is-invalid @enderror" id="joining_date" name="joining_date" value="" readonly>
                                <div class="help-block with-errors" ></div>
                                @error('joining_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="period_from">Period From<span class="text-red">*</span></label>
                                <input id="period_from" type="date" class="form-control @error('period_from') is-invalid @enderror" id="period_from" name="period_from" value="">
                                <div class="help-block with-errors" ></div>
                                @error('period_from')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="period_to">Period To<span class="text-red">*</span></label>
                                <input id="period_to" type="date" class="form-control @error('period_to') is-invalid @enderror" id="period_to" name="period_to" value="">
                                <div class="help-block with-errors" ></div>
                                @error('period_to')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="reviewer_name">Reviewer Name<span class="text-red">*</span></label>
                                <input id="reviewer_name" type="text" class="form-control @error('reviewer_name') is-invalid @enderror" name="reviewer_name" value="">
                                <div class="help-block with-errors" ></div>
                                @error('reviewer_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="date_of_review">Date of review<span class="text-red">*</span></label>
                                <input id="date_of_review" type="date" class="form-control @error('date_of_review') is-invalid @enderror" name="date_of_review" value="">
                                <div class="help-block with-errors" ></div>
                                @error('date_of_review')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <label for="preformance_in_brief">Performance in brief<span class="text-red">*</span></label>
                                <textarea id="preformance_in_brief" class="form-control @error('preformance_in_brief') is-invalid @enderror" name="preformance_in_brief"></textarea>
                                <div class="help-block with-errors" ></div>
                                @error('preformance_in_brief')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="portlet-title">
                            <div class="caption">
                                <h3>Behaviours</h3>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-bordered no-footer">
                        <thead>
                            <tr>
                                <th>Quality</th>
                                <th>Unsatisfactory</th>
                                <th>Satisfactory</th>
                                <th>Good</th>
                                <th>Excellent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Work to full potential</td>
                                <td><input type="radio" name="work_feedback" value="Unsatisfactory"></td>
                                <td><input type="radio" name="work_feedback" value="Satisfactory"></td>
                                <td><input type="radio" name="work_feedback" value="Good"></td>
                                <td><input type="radio" name="work_feedback" value="Excellent"></td>
                            </tr>
                            <tr>
                                <td>Communication</td>
                                <td><input type="radio" name="communication_feedback" value="Unsatisfactory"></td>
                                <td><input type="radio" name="communication_feedback" value="Satisfactory"></td>
                                <td><input type="radio" name="communication_feedback" value="Good"></td>
                                <td><input type="radio" name="communication_feedback" value="Excellent"></td>
                            </tr>
                            <tr>
                                <td>Productivity</td>
                                <td><input type="radio" name="productive_feedback" value="Unsatisfactory"></td>
                                <td><input type="radio" name="productive_feedback" value="Satisfactory"></td>
                                <td><input type="radio" name="productive_feedback" value="Good"></td>
                                <td><input type="radio" name="productive_feedback" value="Excellent"></td>
                            </tr>
                            <tr>
                                <td>Punctuality</td>
                                <td><input type="radio" name="punctuality_feedback" value="Unsatisfactory"></td>
                                <td><input type="radio" name="punctuality_feedback" value="Satisfactory"></td>
                                <td><input type="radio" name="punctuality_feedback" value="Good"></td>
                                <td><input type="radio" name="punctuality_feedback" value="Excellent"></td>
                            </tr>
                            <tr>
                                <td>Attendence</td>
                                <td><input type="radio" name="attendence_feedback" value="Unsatisfactory"></td>
                                <td><input type="radio" name="attendence_feedback" value="Satisfactory"></td>
                                <td><input type="radio" name="attendence_feedback" value="Good"></td>
                                <td><input type="radio" name="attendence_feedback" value="Excellent"></td>
                            </tr>
                            <tr>
                                <td>Technical Skills</td>
                                <td><input type="radio" name="tech_skill_feedback" value="Unsatisfactory"></td>
                                <td><input type="radio" name="tech_skill_feedback" value="Satisfactory"></td>
                                <td><input type="radio" name="tech_skill_feedback" value="Good"></td>
                                <td><input type="radio" name="tech_skill_feedback" value="Excellent"></td>
                            </tr>
                        </tbody>
                    </table>
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

@push('autocomp-khushbu')


<!--MultiSelect-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
         <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<!--Multiselect-->

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">


    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

@endpush

<script>

function getdesignation(designation_id)
{
    console.log(designation_id);
    $.ajax({
        type:'POST',
        url:'/employee/filterDesignation',
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
</script>

<script>
    function getEmpDetail()
    {
        empId=$('#employee_name').val();
        if(empId!='')
        {
            $.ajax({
                type:'GET',
                url:'/km_admin/performance/getEmployeeDetail',
                data:{'emp_id':empId,'_token': '{{csrf_token()}}'},
                success:function(data)
                {
                    $('#department').empty();
                    $('#designation').empty();

                    $('#employee_id').val(data.employee_id);
                    $('#department').append(data.empDepartment);
                    $('#designation').append(data.empDesignation);
                    $('#joining_date').val(data.joining_date);
                }
            });
        }
        else
        {
            $('#employee_id').val('');
            $('#department').empty();
            $('#designation').empty();
            $('#joining_date').val('');
        }
    }
</script>

@endsection


