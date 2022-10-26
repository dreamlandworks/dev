@extends('layouts.master')
@section('title', 'User')
@section('content')


<style>
    .switch {
      position: relative;
      display: inline-block;
      width: 90px;
      height: 34px;
    }

    .switch input {display:none;}

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ca2222;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2ab934;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(55px);
      -ms-transform: translateX(55px);
      transform: translateX(55px);
    }
    .on
    {
      display: none;
    }

    .on, .off
    {
      color: white;
      position: absolute;
      transform: translate(-50%,-50%);
      top: 50%;
      left: 50%;
      font-size: 10px;
      font-family: Verdana, sans-serif;
    }

    input:checked+ .slider .on
    {display: block;}

    input:checked + .slider .off
    {display: none;}
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;}
      table.dataTable thead th, table.dataTable thead td {
    padding: 10px 18px;
    border-bottom: 1px solid #fff;
}
table.dataTable.no-footer {
    border-bottom: 1px solid #dee2e6;
}
table.dataTable.no-footer {
    border-bottom: 1px solid #e6e9ed !important;
}
span.teax-vr-dashbord {
    font-size: 17px;
    position: relative;
    top: 11px;
    left: 29px;
}
h3.rv-list-users {
    position: relative;
    right: 18px;
}
</style>


<div class="content-wrapper">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-10">
                <div class="page-header-title">
                <div class="d-inline">
                        <h3 class=" rv-list-users">Employee Attendence List</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <!-- <li class="breadcrumb-item">
                         <span class="teax-vr-dashbord"><a href="{{url('dashboard')}}"><i class="ik ik-home"></i>Dashboard</a></span>
                        </li> -->
                      </ol>
                </nav>
            </div>
        </div>
    </div>
    <div>
        @include('includes.message')
        <div class="col-md-12">
            <div class="card p-3 m-3-rv">
                <div class="card-header">
                    <a href="{{url('/attendence/list')}}" class="btn btn-primary">Back</a>
                </div>
                <div class="row">
                  <div class="col-sm-3">
                      <label for="employee_id">Select Month</label>
                      <input id="find_date" type="month" class="form-control" name="find_date" onchange='filter_list()'>
                  </div>  
                </div>
                <div class="card-body">
                   <table id="km_dt" class="table table-bordered table-hover dataTable no-footer" >
                        <thead>
                            <tr>
                              <th>Employee Id</th>
                              <th>Image</th>
                              <th>Date</th>
                              <th>Status</th>
                              <th>Type of Leave</th>
                              <th>Reason</th>
                            </tr>
                        </thead>
                        <tbody id="employee_att">
                          @foreach($employee_attendence as $attendence)
                            <?php
                              $emp_det=DB::table('employee')->where('id',$attendence->emp_id)->first();
                             ?>
                            <tr>
                                <td>{{$emp_det->employee_id}}</td>
                                <td><img src="/km_admin/{{$emp_det->document_path}}/{{$emp_det->photo}}" alt="Employee Photo" width="100px"></td>
                                <td>{{$attendence->date}}</td>
                                <td>{{$attendence->status}} </td>
                                <td>{{$attendence->type_of_leave}}</td>
                                <td>{{$attendence->reason}}</td>
                            </tr>
                            @endforeach
                          
                        </tbody>
                    </table>
                    <input type="hidden" id="emp_id" name="emp_id" value="{{$emp_det->employee_id}}">
                    <input type="hidden" id="emp_image" name="emp_image" value="/km_admin/{{$emp_det->document_path}}/{{$emp_det->photo}}">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>
function filter_list()
{
  $.ajax({
    type:"GET",
    url:"{{$attendence->emp_id}}/filter-list",
    data:{ "select_date": $("#find_date").val(),"emp_id":{{$attendence->emp_id}} },
    success:function(response ){
      $("#employee_att").empty();
      if((response.length)>0)
      { 
        $.each(response,function(key,value){
          var leave='';
          var reason='';
          if(value.type_of_leave!=null)
          {
            leave=value.type_of_leave;
          }

          if(value.reason!=null)
          {
            reason=value.reason;
          }
          $("#employee_att").append('<tr><td>'+$('#emp_id').val()+'</td><td><img src='+$('#emp_image').val()+' alt="Employee Photo" width="100px"></td><td>'+value.date+'</td><td>'+value.status+'</td><td>'+leave+'</td><td>'+reason+'</td></tr>');
        });
      }
      else
      {
        $("#employee_att").append('<tr><td colspan=6 style="text-align:center;">No records found</td></tr>');
      }
    }
  });
}
</script>
