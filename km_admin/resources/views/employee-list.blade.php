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
                        <h3 class=" rv-list-users">Employee List</h3>
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
                    <a href="{{url('/employee/create')}}" class="btn btn-primary">Add +</a>
                   </div>
                <div class="card-body">
                   <table id="km_dt" class="table table-bordered table-hover dataTable no-footer" >
                        <thead>
                            <tr>
                                <th>Sr.No.</th>
                                <th>Employee Id</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Dept/Designation</th>
                                <th>At Work</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>
                        </thead>

                        <tbody>
                          @php
                            $counter=0;
                          @endphp
                          @foreach($employee_detail as $employee)
                            @php
                               $counter++;
                               $departmentname=''; 
                               $current_date=date('y-m-d');
                               $joining_date=$employee->date_of_joining;
                               $datetime1 = date_create($current_date);
                               $datetime2 = date_create($joining_date);
                                
                               $interval = date_diff($datetime1, $datetime2); 
                               foreach($department_name as $each_dept)
                               {
                                  if(($employee->department)==($each_dept->id))
                                  {
                                      $departmentname='Department: '.$each_dept->department_name;
                                  }
                               }
                               $emp_designation='Designation: '.$employee->designation;
                            @endphp
                            <tr>
                                  <td>{{$counter}}</td>
                                  <td>{{$employee->employee_id}}</td>
                                  <td><img src="/km_admin/{{$employee->document_path}}/{{$employee->photo}}" alt="Employee Photo" width="100px"></td>
                                  <td>{{$employee->name}}</td>
                                  <td>{{$departmentname}}<br>{{$emp_designation}}</td>
                                  <td>{{$interval->format('%y years %m months and %d days') . "\n";}}</td>
                                  <td> @if($employee->status=='on') <span class="badge badge-success">active</span> @else <span class="badge badge-danger">Deactive</span> @endif </td>
                                  <td>
                                    <a href="/km_admin/employee/{{$employee->id}}"><i class="fa fa-pencil-square-o text-green"></i></a>&nbsp;&nbsp;&nbsp;
                                    <a href="delete/{{$employee->id}}"><i class="fa fa-trash text-red"></i></a>
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection