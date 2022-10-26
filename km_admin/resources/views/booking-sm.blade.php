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
.modal-content.mk_content {
    width: 700px;
}
.md-form.mb-5.mk_modal {
    margin-left: 10px;
}
</style>


<div class="content-wrapper">
    <div id="rescheduleMsg"></div>
    @if(!empty($message))
    @if($message=="qaz")
    <div class="col-md-12">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          No one accepted the booking.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="fa fa-times" aria-hidden="true"></i>
          </button>
        </div>
        </div>
    @endif

    @if($message=="wsx")
    <div class="col-md-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          Some sp has accepted the booking.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="fa fa-times" aria-hidden="true"></i>
          </button>
        </div>
        </div>
    @endif

  @endif
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-10">
                <div class="page-header-title">
                <div class="d-inline">
                        <h3 class=" rv-list-users">Single Move Booking</h3>
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
                    <a href="{{url('booking-sm/create')}}" class="btn btn-primary">Add +</a>
                   </div>
                <div class="card-body">
                   <table id="km_dt" class="table table-bordered table-hover dataTable no-footer">
                        <thead class="mk_nowrap">
                            <tr>
                                <th>BookingId</th>
                                <th>UserId</th>
                                <th>First Name</th>
                                <th>Scheduled Date</th>
                                <th>Started At</th>
                                <th>Completed At</th>
                                <th>Amount</th>
                                <th>SGST</th>
                                <th>CGST</th>
                                <th>Sp Name</th>
                                <th>Action</th>

                            </tr>
                        </thead>

                        <tbody class="mk_tbodynowrap">
                            @foreach ($bookings as $booking)
                              <tr>
                                <td>{{$booking->id}}</td>
                                <td>{{$booking->users_id}}</td>
                                <td>{{$booking->userdetail ? $booking->userdetail->fname : ''}}</td>
                                <td>{{$booking->scheduled_date}}</td>
                                <td>{{$booking->started_at}}</td>
                                <td>{{$booking->completed_at}}</td>
                                <td>{{$booking->amount}}</td>
                                <td>{{$booking->sgst}}</td>
                                <td>{{$booking->cgst}}</td>
                                <td>{{$booking->spdetail ? $booking->spdetail->fname : ''}}</td>
                                <td>
                                <button id="reschedule_btn"  type="button" class="btn btn-primary btn-sm" onclick="bookingschedule({{$booking->id}})">Rescheduled</button>&nbsp;&nbsp;&nbsp;
                                <button data-href="" type="button" class="btn btn-danger btn-sm SmBookinginfo">Cancel</button>

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


<!--Add Time Slot-->
<div class="modal fade" id="sm_booking_resch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content mk_content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Rescheduled Booking</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body mx-6">
            <div class="row">

          <div class="md-form mb-5 mk_modal">
            <input type="text" id="booking_id" class="form-control validate" name="booking_id" value="" readonly>
            <label data-error="wrong" data-success="right" for="form34">Booking Id</label>
          </div>
          <div class="md-form mb-5 mk_modal">
            <input type="text" id="scheduled_date" class="form-control validate" name="scheduled_date" readonly>
            <label data-error="wrong" data-success="right" for="form34">Scheduled Date</label>
          </div>
          <div class="md-form mb-5 mk_modal">
            <input type="text" id="scheduled_time" class="form-control validate" name="scheduled_time" readonly>
            <input type="hidden" id="scheduled_time_id" name="scheduled_time_id">
            <input type="hidden" id="sp_id" name="sp_id">
            <label data-error="wrong" data-success="right" for="form34">Scheduled Time</label>
          </div>
          <div class="md-form mb-5 mk_modal">
            <div id="rescheduled_date_error"></div>
            <input type="date" id="rescheduled_date" class="form-control validate" name="rescheduled_date">
            <label data-error="wrong" data-success="right" for="form34">Rescheduled Date</label>
            @error('rescheduled_date')
                <span class="invalid-rescheduled_date" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="md-form mb-5 mk_modal">
            <div id="rescheduled_time_error"></div>
            <select class="form-control validate" id="rescheduled_time" name="rescheduled_time" aria-label="Default select example">
                    <option value="">Select Time</option>
            </select>
            <label data-error="wrong" data-success="right" for="form34">Rescheduled Time</label>
          </div>
        </div>
        </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" id="re-schedule" type="button" onclick="re_schedule()">Submit</button>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->
    @push('autocomp-khushbu')

       
    @endpush

@endsection

<script src="https://ajax.googleapis.com/ajax/libs/cesiumjs/1.78/Build/Cesium/Cesium.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  // bid_detail

function bookingschedule(old_booking_id)
{
    $('#rescheduled_date').val('');
    $('#rescheduled_time').val('');
    document.getElementById('rescheduled_date_error').innerHTML='';
    document.getElementById('rescheduled_time_error').innerHTML='';
  $.ajax({
            type: "POST",
            url: "sm-bookingRecshedule",
            data: { 
              "booking_id":old_booking_id,
              "_token": "{{ csrf_token() }}"},
            success:function(data){
            document.getElementById('booking_id').value=data.booking_id;
            document.getElementById('scheduled_date').value=data.schedule_date;
            document.getElementById('scheduled_time').value=data.timeslot;
            document.getElementById('scheduled_time_id').value=data.timeslot_id;
            document.getElementById('sp_id').value=data.sp_id;
              
            $.each(data.time_slot_data,function(index,loopvalue)
            {
               $('#rescheduled_time').append('<option value="'+loopvalue.id+'">'+loopvalue.from+'</option>');
            });
            $('#sm_booking_resch').modal('show');        
        }});
}
 
</script>

<script>
function re_schedule()
{
    $.ajax({
            type: "POST",
            url: "sm/re-schedule",
            data: { 
              "booking_id":$("#booking_id").val(),
              "scheduled_date":$("#scheduled_date").val(),
              //"scheduled_time":$("#scheduled_time").val(),
              "scheduled_time_id":$("#scheduled_time_id").val(),
              "rescheduled_date":$("#rescheduled_date").val(),
              "rescheduled_time":$("#rescheduled_time").val(),
              "sp_id":$("#sp_id").val(),
              "_token": "{{ csrf_token() }}"},
            success:function(data){
              $('#sm_booking_resch').modal('hide');
              console.log(data);
              if(data=="success") 
              {
                  var msg='<div class="col-md-12">';
                  msg+='<div class="alert alert-success alert-dismissible fade show" role="alert">';
                  msg+='Single booking has been successfully rescheduled.';
                  msg+='<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                  msg+='<i class="fa fa-times" aria-hidden="true"></i>';
                  msg+='</button>';
                  msg+='</div>';
                  msg+='</div>';
                  document.getElementById('rescheduleMsg').innerHTML=msg;
                  $(window).scrollTop(0,0);
              }
              else
              {
                  var msg='<div class="col-md-12">';
                  msg+='<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                  msg+='Failed to rescheduled.';
                  msg+='<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                  msg+='<i class="fa fa-times" aria-hidden="true"></i>';
                  msg+='</button>';
                  msg+='</div>';
                  msg+='</div>';
                  document.getElementById('rescheduleMsg').innerHTML=msg;
                  $(window).scrollTop(0,0);
              }
            },
            error:function(request,status,error)
            {
              $.each(request,function(index,value){
                  if(index=="responseJSON")
                  {
                      var arr = value.errors;
                      //console.log(arr);
                      $.each(arr, function(index_new, value_new)
                      {
                          document.getElementById(index_new+'_error').innerHTML=value_new[0];
                          document.getElementById(index_new+'_error').style.color="red";
                      });
                  }
              });
            }
        
    });
}
</script>
