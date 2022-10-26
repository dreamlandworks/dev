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
.mk_nowrap{
  white-space: nowrap;  
}
.mk_tbodynowrap{
      white-space: nowrap;  
}
</style>


<div class="content-wrapper">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                <div class="d-inline">
                        <h3 class=" rv-list-users">Activated Provider</h3>
                    </div>
                </div>
            </div>
            <!--<div class="col-lg-2">-->
            <!--    <nav class="breadcrumb-container" aria-label="breadcrumb">-->
            <!--        <ol class="breadcrumb">-->
                        <!-- <li class="breadcrumb-item">
            <!--             <span class="teax-vr-dashbord"><a href="{{url('dashboard')}}"><i class="ik ik-home"></i>Dashboard</a></span>-->
            <!--            </li> -->
            <!--          </ol>-->
            <!--    </nav>-->
            <!--</div>-->
        </div>
    </div>
    <div>
        @include('includes.message')
        <div class="col-md-12">
            <div class="card p-3 m-3-rv">
                <div class="card-header">
                    <a href="{{url('sp/create')}}" class="btn btn-primary">Add +</a>
                   </div>
                <div class="card-body">
                   <table id="km_dt" class="table table-bordered table-hover dataTable no-footer" >
                        <thead class="mk_nowrap">
                            <tr>
                                <th>SN</th>
                                <th>UserId</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Country</th>
                                <th>Points</th>
                                <th>Raiting</th>
                                <th>Booking</th>
                                <th>Action</th>
                                
                            </tr>
                        </thead>
                        
                        <tbody  class="mk_tbodynowrap">
                            @foreach($service_providers as $service_provider)                       
                        <?php $id = DB::table('user_details')->where('id',$service_provider->users_id)->first(); ?>
                        @if($id)
                        <?php $data = DB::table('address')
                                ->join('city', 'address.city_id', '=', 'city.id')
                                ->join('state', 'city.state_id', '=', 'state.id')
                                ->join('country','state.country_id', '=', 'country.id')
                                ->where('address.users_id', '=', $service_provider->users_id)
                                ->first();
                          ?>
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$id->id}}</td>
                            <td>{{$id->fname}}</td>
                            <td>{{$id->lname}}</td>    
                            <td>{{$id->mobile}}</td>
                            <td>{{$service_provider->email}}</td>
                            <td>{{$data ? $data->city : ''}}</td>
                            <td>{{$data ? $data->state : ''}}</td>
                            <td>{{$data ? $data->country : ''}}</td>
                            <td>{{$id->points_count}}</td>
                            <td></td>
                            <td></td>
                            <td>
                                <a href="sp/profile/{{$service_provider->users_id}}"><i class="fa fa-user ic_space text-green"></i></a>
                                <a href="sp/{{$service_provider->users_id}}"><i class="fa fa-pencil-square-o text-green"></i></a>&nbsp;&nbsp;&nbsp;
                                <a href="sp/delete/{{$service_provider->id}}"><i class="fa fa-trash text-red"></i></a>
                            </td>
                        </tr>
                        @endif
                        

                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
