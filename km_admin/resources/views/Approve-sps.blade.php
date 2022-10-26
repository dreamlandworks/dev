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

<div class="content-wrapper">
    <div id="spapproval"></div>
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="page-header-title">
                    <div class="d-inline">
                        <h3 class=" rv-list-users">SP List Before Approval</h3>
                    </div>
                </div>
            </div>
            <!--<div class="col-lg-2">-->
            <!--    <nav class="breadcrumb-container" aria-label="breadcrumb">-->
            <!--        <ol class="breadcrumb">-->
            <!--            <li class="breadcrumb-item">-->
            <!--             <span class="teax-vr-dashbord"><a href="{{url('dashboard')}}"><i class="ik ik-home"></i>Dashboard</a></span>-->
            <!--            </li>-->
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
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>UserId</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Info & Approve/Reject</th>
                            </tr>
                        </thead>
                        @foreach($service_providers as $service_provider)
                        <tr>
                            {{-- <td>{{$loop->iteration}}</td>
                            <td><span class="users_id">{{$service_provider->users_id}}</span></td>
                            <td>{{$service_provider->userinfo ? $service_provider->userinfo->fname : ''}}</td>
                            <td>{{$service_provider->userinfo ? $service_provider->userinfo->lname : ''}}</td>
                            <td>{{$service_provider->userinfo ? $service_provider->userinfo->mobile : ''}}</td>
                            <td>{{$service_provider->useremail ? $service_provider->useremail->email : ''}}</td> --}}
                            <td>{{$loop->iteration}}</td>
                            <td><span class="users_id">{{$service_provider->users_id}}</span></td>
                            <td>{{$service_provider->userdetail->fname}}</td>
                            <td>{{$service_provider->userdetail->lname}}</td>
                            <td>{{$service_provider->userdetail->mobile}}</td>
                            <td>{{$service_provider->email}}</td>

                            <td style="display:inline-flex">
                                <button data-href="{{ url('sp-userinfo',[$service_provider->users_id]) }}" class="userinfo" style="background:white;border:none"><i class="fa fa-eye text-primary text-center" style="font-size:18px;"></i></button>&nbsp;&nbsp;&nbsp;
                                <button type="button" class="btn btn-success btn-sm sp_approve">APPROVE</button>&nbsp;&nbsp;&nbsp;
                                <button type="button"  class="btn btn-danger btn-sm sp_reject">REJECT</button>
                            </td>
                        </tr>
                        @endforeach
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

<!--Add Modal-->
<div class="modal fade sp-user-modal" id="modalContactForm_userinfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">

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

<!-- reject Model -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 400px;">
        <div class="modal-content">
            <div class="modal-footer" style="padding:1px;">
                <button type="button" data-dismiss="modal" style="border: 0px;">
                    <i class="fa fa-times" aria-hidden='true'></i>
                </button>
            </div>
            <!-- Add image inside the body of modal -->
            <div class="modal-body" id="doc_show">
                <input type="hidden" name="rejectsp_id" id="rejectsp_id" value="">
                <label>Are you sure to reject this service provider?</label><br>
                <button type="button" class="btn btn-danger btn-sm" onclick="rejectSp();">Yes</button>&nbsp;&nbsp;&nbsp;
                <button type="button"  class="btn btn-success btn-sm" onclick="closerejectmodel();">No</button>
            </div>
        </div>
    </div>
</div>

<!-- end model -->
@push('autocomp-khushbu')
<script>
function showDocument(doc_url)
{
    var new_doc=$('#idPreview').attr('src');
   console.log(new_doc);
    $('#model_image').attr('src',new_doc);
    $('#exampleModal').modal('show');
}
</script>

<script>

$(document).on('click', 'button.userinfo', function() {

         $('div.sp-user-modal').load($(this).data('href'), function() {
             $(this).modal('show');

 });
 });

</script>
<script>
    $("#km_dt").on('click','.sp_approve',function(){
       var currentRow = $(this).closest("tr");
         var col1 = currentRow.find(".users_id").html();
          //console.log(col1);

        $.ajax({
            type: "GET",
            url: "sp-approve",
            data: { "users_id": col1,"_token": "{{ csrf_token() }}",},
            success:function(data){
                var msg='<div class="col-md-12">';
                msg+='<div class="alert alert-success alert-dismissible fade show" role="alert">';
                msg+='Service provider approved successfully.';
                msg+='<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                msg+='<i class="fa fa-times" aria-hidden="true"></i>';
                msg+='</button>';
                msg+='</div>';
                msg+='</div>';
                document.getElementById('spapproval').innerHTML=msg;
                $(window).scrollTop(0,0);
                setTimeout(() => {
                    location.reload();
                }, 1000);
        }});
   });
</script>
<script>

    function closerejectmodel()
    {
        $('#rejectModal').modal('hide');
    }
    $("#km_dt").on('click','.sp_reject',function(){
       var currentRow = $(this).closest("tr");
         var col1 = currentRow.find(".users_id").html();
        //  console.log(col1);
        $('#rejectsp_id').val(col1);
        $('#rejectModal').modal('show');
        // $.ajax({
        //     type: "GET",
        //     url: "sp-reject",
        //     data: { "users_id": col1,"_token": "{{ csrf_token() }}",},
        //     success:function(data){
        //         var msg='<div class="col-md-12">';
        //         msg+='<div class="alert alert-success alert-dismissible fade show" role="alert">';
        //         msg+='Service provider rejected.';
        //         msg+='<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        //         msg+='<i class="fa fa-times" aria-hidden="true"></i>';
        //         msg+='</button>';
        //         msg+='</div>';
        //         msg+='</div>';
        //         document.getElementById('spapproval').innerHTML=msg;
        //         $(window).scrollTop(0,0);
        // }});

   });

   function rejectSp()
   {
    var col1=$('#rejectsp_id').val();
    $.ajax({
            type: "GET",
            url: "sp-reject",
            data: { "users_id": col1,"_token": "{{ csrf_token() }}",},
            success:function(data){
                $('#rejectModal').modal('hide');
                var msg='<div class="col-md-12">';
                msg+='<div class="alert alert-success alert-dismissible fade show" role="alert">';
                msg+='Service provider rejected.';
                msg+='<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                msg+='<i class="fa fa-times" aria-hidden="true"></i>';
                msg+='</button>';
                msg+='</div>';
                msg+='</div>';
                document.getElementById('spapproval').innerHTML=msg;
                $(window).scrollTop(0,0);

                setTimeout(() => {
                    location.reload();
                }, 1000);
        }});
   }
</script>
@endpush
@endsection
