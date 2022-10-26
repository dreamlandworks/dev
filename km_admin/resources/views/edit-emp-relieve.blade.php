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
                <h4>Edit Employee Relieve</h4>
            </div>     
            <hr/> @include('includes.message')
            <div class="sp-div" id="sp-div">
                <form class="forms-sample" method="POST" action="{{ route('update-relieve') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row ">
                        <div class="portlet-title">
                            <div class="caption">
                                <h3>Employee Info</h3>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <input type="hidden" name="emp_relieve_id" id="emp_relieve_id" value="{{$employee_relieve->id}}">
                    <div class="row ">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="employee_name">Employee Name<span class="text-red">*</span></label>
                                <select class="form-control @error('employee_name') is-invalid @enderror" name="employee_name" id="employee_name" onchange="getEmpDetail();">
                                    <option value="">Select Employee name</option>
                                    @foreach($employee_detail as $value)
                                        <option value="{{$value->id}}" @if($employee_relieve->employee_name==$value->id) selected @endif>{{$value->name}}</option>
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
                                <input type="text" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" id="employee_id" value="{{$employee_relieve->employee_id}}" readonly>
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
                                    <option value={{$desg_value->id}} @if($employee_relieve->department==$desg_value->id) selected @endif >{{$desg_value->department_name}} </option>
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
                                @if($employee_relieve->designation) 
                                    <option value='{{$employee_relieve->designation}}' selected>{{$employee_relieve->designation}}</option> 
                                @endif
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
                                <input id="joining_date" type="date" class="form-control @error('joining_date') is-invalid @enderror" id="joining_date" name="joining_date" value="{{$employee_relieve->joining_date}}" readonly>
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
                                <label for="date_of_relieving">Date of Relieving<span class="text-red">*</span></label>
                                <input id="date_of_relieving" type="date" class="form-control @error('date_of_relieving') is-invalid @enderror" name="date_of_relieving" value="{{$employee_relieve->date_of_relieving}}">
                                <div class="help-block with-errors" ></div>
                                @error('date_of_relieving')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="resignation_letter">Resignation Letter<span class="text-red"></span></label>
                                <input id="resignation_letter" type="file" class="form-control @error('resignation_letter') is-invalid @enderror" name="resignation_letter" onchange='doc_preview("resignation_letter")'>
                                <div class="help-block with-errors" ></div>
                                @error('resignation_letter')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <button type="button" style="border: 0px;margin-top: 10px;" onclick="showDocument('resignation_letter','/employee/relieve/{{$employee_relieve->resignation_letter}}')">
                                    <div id="resignation_letterField">
                                        <embed id="resignation_letterPreview" src="/km_admin/employee/relieve/{{$employee_relieve->resignation_letter}}" alt="pic"style="height:150px; width:250px; margin-top: 10px;" class="img-fluid" />
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="portlet-title">
                            <div class="caption">
                                <h3>Reasons for Relieving</h3>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row ">
                        <div class="col-sm-12">
                            <label for="content">Relieve Content<span class="text-red">*</span></label>
                            <textarea class="form-control" id="relieve_content" name="relieve_content">{{$employee_relieve->relieve_content}}</textarea>
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

<!-- Adding scripts to use bootstrap -->
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity=
"sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"> -->
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

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script> -->
<script type="text/javascript">
    CKEDITOR.replace('relieve_content');
</script>
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
                url:'/km_admin/relieve/getEmployeeDetail',
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
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->

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
    <script>
        function doc_preview(doc_field)
        {  
          var att_files = document.getElementById(doc_field);
          const file = att_files.files[0];

          let reader = new FileReader();
          reader.readAsDataURL(file);
          reader.onload = () => {
            let json = JSON.stringify({ dataURL: reader.result });
            // View the file
            let fileURL = JSON.parse(json).dataURL;
            $('#'+doc_field+'Field').empty();

            // View the original file
            let originalFileURL = URL.createObjectURL(file);
            $('#'+doc_field+'Field').append('<embed id="'+doc_field+'Preview" src='+fileURL+' style="margin-top: 10px" width="250px"/>')
            .onload(() => {
              URL.revokeObjectURL(originalFileURL);
            });
          };
        }
</script>
@endsection


