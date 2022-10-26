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
    /* right: 18px; */
    margin-left: 16px;
}
</style>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">                  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<div class="content-wrapper">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-10">
                <div class="page-header-title">
                <div class="d-inline">
                        <h3 class=" rv-list-users">Leads List</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">

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
                    <a href="{{url('lead/create')}}" class="btn btn-primary">Add +</a>
                   </div>
                <div class="card-body">
                   <table id="km_dt" class="table table-bordered table-hover dataTable no-footer" >
                        <thead class="mk_nowrap">
                            <tr>
                                <th>S.No</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>City</th>
                                <th>Occupation</th>
                                <th>Qualification</th>
                                <th>Hobbies</th>
                                <th>Connect with</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody class="mk_tbodynowrap">
                            @foreach ($leads as $lead)
                            <?php
                                $edit_qualification=json_decode($lead->qualification);
                                $added_qual='';
                                
                                foreach($qualification as $all_qualification)
                                {
                                    foreach($edit_qualification as $key=>$value)
                                    {
                                        if($value==$all_qualification->id)
                                        {
                                            $added_qual.=$all_qualification->qualification.',';
                                        }
                                    }
                                    
                                }
                                
                            ?>
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$lead->fname}}</td>
                                <td>{{$lead->lname}}</td>
                                <td>{{$lead->email}}</td>
                                <td>{{$lead->mobile}}</td>
                                <td>{{$lead->city}}</td>
                                <td>{{$lead->occupation}}</td>
                                <td>{{trim($added_qual,',')}}</td>
                                <td>{{$lead->hobbies}}</td>
                                <td>
                                    <i class="fa fa-phone-square text-green" style="font-size:24px;"></i>
                                    <i class="fa fa-envelope-square text-green" style="font-size:24px;"></i>
                                    <i class="fas fa-sms text-green" style="font-size:24px;"></i>
                                    <i class="fa fa-whatsapp text-green" style="font-size:24px;"></i>
                                    
                                </td>
                                <td>
                                    <a href="lead/{{$lead->id}}"><i class="fa fa-pencil-square-o text-green"></i></a>&nbsp;&nbsp;&nbsp;
                                        <a href="lead/delete/{{$lead->id}}"><i class="fa fa-trash text-red"></i></a>
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