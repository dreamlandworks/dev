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
    @if(!empty($message))
    @if($message=="qaz")
    <div class="col-md-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          Blue collor Job Post creation failed.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="fa fa-times" aria-hidden="true"></i>
          </button>
        </div>
        </div>
    @endif

    @if($message=="wsx")
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Blue collor Job Post created successfully.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="fa fa-times" aria-hidden="true"></i>
          </button>
        </div>
        </div>
    @endif

  @endif
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h3 class=" rv-list-users">Blue Collor Job Post</h3>
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
                    <a href="{{url('job-post-cb/create')}}" class="btn btn-primary">Add +</a>
                   </div>
                <div class="card-body">
                   <table id="km_dt" class="table table-bordered table-hover dataTable no-footer" >
                        <thead class="mk_nowrap">
                            <tr>
                                <th>Booking Id</th>
                                <th>User Plan Id</th>
                                <th>Status</th>
                                <th>Bids Period</th>
                                <th>Title</th>
                                <th>Bid Per</th>
                                <th>Bid Range Id</th>
                                <th>Created Details</th>
                                <th>Action</th>

                            </tr>
                        </thead>

                        <tbody class="mk_tbodynowrap">
                            @foreach($post_jobs as $post_job)
                                <tr>
                                    <td>{{$post_job->booking_id}}</td>
                                    <td>{{$post_job->user_plan_id}}</td>
                                    <td>{{$post_job->BookingStatusCode->name}}</td>
                                    <td>{{$post_job->bids_period}}</td>
                                    <td>{{$post_job->title}}</td>
                                    <td>{{$post_job->EstimateType->name}}</td>
                                    <td>{{$post_job->BidRange->name}}</td>
                                    <td>{{$post_job->created_dts}}</td>
                                    <td><a href="/km_admin/job-post-cb/view-cb-post/{{$post_job->booking_id}}"><button type="button" class="btn btn-success">View</button></a></td>
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
