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
                  <div class="col-sm-6" style="text-align: right;">
                      <h5 id="total_present">Total Present : {{$present_employee}}</h5>
                  </div>
                  <div class="col-sm-6">
                      <h5 id="total_absent">Total Absent :{{$absent_employee}}</h5>
                  </div>
                </div>

                <div class="row">
                  <div class="col-sm-3">
                    <h5 id="attendence_date">Date: {{ date('Y-m-d')}} </h5>
                      <label for="employee_id">Select Date</label>
                      <input id="find_date" type="date" class="form-control" name="find_date" value="{{ date('Y-m-d')}}" onchange="filter_list()">
                  </div>  
                </div>
                
                
                <div class="card-body">
                   <table id="km_dt" class="table table-bordered table-hover dataTable no-footer" >
                        <thead>
                            <tr>
                              <th>S.No</th>
                              <th>Employee Id</th>
                              <th>Image</th>
                              <th>Name</th>
                              <th>Date</th>
                              <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="employee_att">
                          <?php $s_no=1; ?>
                          @foreach($employee_attendence as $attendence)
                            <?php
                              $emp_det=DB::table('employee')->where('id',$attendence->emp_id)->first();
                             ?>
                            <tr>
                                <td>{{$s_no}}</td>
                                <td>{{$emp_det->employee_id}}</td>
                                <td><img src="/{{$emp_det->document_path}}/{{$emp_det->photo}}" alt="Employee Photo" width="100px"></td>
                                <td>{{$emp_det->name}}</td>
                                <td>{{$attendence->date}}</td>
                                <td><b>{{$attendence->status}}</b> </td>
                            </tr>
                            <?php $s_no++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>
function filter_list()
{
  $('#attendence_date').html('Date: '+$('#find_date').val());
  $.ajax({
    type:"GET",
    url:"each-attendence/filter",
    data:{ "select_date": $("#find_date").val() },
    success:function(response ){
      console.log(response.employee_attendence);
      $('#total_present').html('Total Present : '+response.present_employee);
      $('#total_absent').html('Total Absent : '+response.absent_employee);
       $("#employee_att").empty();
      var att_det =response.employee_attendence_detail;
      if((att_det.length)>0)
      { 
        var counting=0;
        
        $.each(att_det,function(key,value){
          var leave='';
          var reason='';
          counting++;
          
          $("#employee_att").append('<tr><td>'+ counting +'</td> <td>'+value.employee_id+'</td><td><img src="/'+value.document_path+'/'+value.photo+'" alt="Employee Photo" width="100px"></td><td>'+value.name+'</td><td>'+value.date+'</td><td><b>'+value.status+'</b></td></tr>');
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
@endsection

