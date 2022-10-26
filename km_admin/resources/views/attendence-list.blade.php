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
                <div class="row">
                  <div class="col-sm-6">
                    <a href="{{url('/attendence/create')}}" class="btn btn-primary">Add +</a>
                  </div>
                  <div class="col-sm-6" style="text-align:right;">
                    <a href="{{url('/attendence/each-attendence')}}" style="text-align:right;" class="btn btn-primary">View Date-wise Attendence</a>
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
                              <th>Last Absent</th>
                              <th>Total Leave</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $s_no=1; ?>
                          @foreach($employee as $attendence)
                            <?php
                              $emp_det=DB::table('employee')->where('id',$attendence->id)->first();
                              foreach($emp_det as $employee_det)
                              {
                                  $emp_name=$emp_det->name;
                                  $department=$emp_det->department;
                                  $doc_path=$emp_det->document_path;
                                  $emp_photo=$emp_det->photo;
                                  $emp_id=$emp_det->employee_id;
                                  
                              }
                              $departmental_leave=DB::table('designation')->where('id',$department)->first();

                              $last_leave_date='';
                              $emp_att=DB::table('attendence')->where('emp_id',$attendence->id)->where('status','Absent')->where('date','like','%'.date('Y').'%')->orderBy('id','ASC')->get();
                              foreach($emp_att as $last_leave)
                              {
                                $current_date=date('Y-m-d');
                                $last_leave_date=$last_leave->date;
                                $datetime1 = date_create($current_date);
                                $datetime2 = date_create($last_leave_date);
                                $interval = date_diff($datetime1, $datetime2);
                              }

                             ?>
                            <tr>
                                <td>{{$s_no}}</td>
                                <td>{{$emp_id}}</td>
                                <td><img src="/{{$doc_path}}/{{$emp_photo}}" alt="Employee Photo" width="100px"></td>
                                <td>{{$emp_name}}</td>
                                <td> @if($last_leave_date) {{$interval->format('%y years %m months and %d days') . "\n";}} @endif </td>
                                <td>Alloted Leave: {{$departmental_leave->no_of_leave}} <br>
                                    Leave Taken : {{count($emp_att)}}<br>
                                    Remaining Leave: {{($departmental_leave->no_of_leave)-count($emp_att)}}
                                </td>
                                <td><a href="/km_admin/attendence/each-list/{{$attendence->id}}"><button type="button" class="btn btn-success btn-sm sp_approve">View</button></a></td>
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

@endsection
