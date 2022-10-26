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
            <div class="col-lg-10">
                <div class="page-header-title">
                <div class="d-inline">
                        <h3 class=" rv-list-users">Blue Collor Job Post View</h3>
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
                    <a href="{{url('job-post-cb')}}" class="btn btn-primary">Back</a>
                   </div>
                <div class="card-body">
                   <table class="table table-bordered table-hover dataTable no-footer" >
                        

                        <tbody class="mk_tbodynowrap">
                            @foreach($post_jobs as $post_job)
                                <tr><td colspan=4 style="text-align:center;"><h4>Post Job Details</h4></td></tr>
                                <tr>
                                    <td width="5px"><b>Booking Id : </b></td>
                                    <td width="100px">{{$post_job->booking_id}}</td>
                                    <td width="5px"><b>User Plan Id : </b></td>
                                    <td width="10px">{{$post_job->user_plan_id}}</td>
                                </tr>
                                <tr>
                                    <td><b>Status : </b></td>
                                    <td>{{$post_job->BookingStatusCode->name}}</td>
                                    <td><b>Bids Period : </b></td>
                                    <td>{{$post_job->bids_period}}</td>
                                </tr>
                                <tr>
                                    <td><b>Title : </b></td>
                                    <td>{{$post_job->title}}</td>
                                    <td><b>Bid Per : </b></td>
                                    <td>{{$post_job->EstimateType->name}}</td>
                                </tr>
                                <tr>
                                    <td><b>Bid Range Id : </b></td>
                                    <td>{{$post_job->BidRange->name}}</td>
                                    <td><b>Created Details : </b></td>
                                    <td>{{$post_job->created_dts}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <table class="table table-bordered table-hover dataTable no-footer" >
                        <tbody class="mk_tbodynowrap">
                            <tr><td colspan=9 style="text-align:center;"><h4>Post Job Bid Details</h4></td></tr>
                                <tr>
                                    <td><b>Sr No</b></td>
                                    <td><b>Users</b></td>
                                    <td><b>Amount</b></td>
                                    <td><b>Estimate Type</b></td>
                                    <td><b>Estimate Time</b></td>
                                    <td><b>Proposal</b></td>
                                    <td><b>Bid Type</b></td>
                                    <td><b>Bid Status</b></td>
                                    <td><b>Action</b></td>
                                    
                                </tr>
                            @foreach($each_bid_det as $post_job_bid)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$post_job_bid['users_name']}}</td>
                                    <td>{{$post_job_bid['amount']}}</td>
                                    <td>{{$post_job_bid['estimate_type']}}</td>
                                    <td>{{$post_job_bid['esimate_time']}}</td>
                                    <td>{{$post_job_bid['proposal']}}</td>
                                    <td>@if($post_job_bid['bid_type']==0)Open @endif  @if($post_job_bid['bid_type']==1)Sealed @endif </td>
                                    <td>{{$post_job_bid['bid_status']}}</td>
                                    <td>
                                        <a href="/km_admin/job-post-cb/view-cb-post/award/{{$post_job['id']}}"><button type="button" class="btn btn-success">Award</button></a>
                                        <a href="/km_admin/job-post-cb/view-cb-post/reject/{{$post_job['id']}}"><button type="button" class="btn btn-danger">Reject</button></a>
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
