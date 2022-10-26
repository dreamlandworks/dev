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
button#receipt_submit {
    margin-top: 28px;
}
</style>


<div class="content-wrapper">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-10">
                <div class="page-header-title">
                <div class="d-inline">
                        <h3 class=" rv-list-users">Transaction Details By Booking Id</h3>
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
                <!-- <div class="card-header">
                    <a href="#" class="btn btn-primary">Add +</a>
                </div> -->
                <form class="forms-sample" method="POST" action="{{ route('check-booking_id') }}">
                @csrf
                  <div class=row>
                    <div class="col-sm-3">
                      <label>Booking ID:</label>
                      <input type="text" class="form-control @error('booking_id') is-invalid @enderror" name="booking_id" id="booking_id">
                      <div class="help-block with-errors" ></div>
                      @error('booking_id')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="col-sm-2">
                      <button type="submit" id="receipt_submit" class="btn btn-primary">Get</button>
                    </div>
                  </div>
                </form>
                <div class="card-body">
                   <table id="km_dt" class="table table-bordered table-hover dataTable no-footer" >
                        <thead>
                            <tr>
                              <th>S.No</th>
                              <th>Date</th>
                              <th>Booking ID</th>
                              <th>Transaction Name</th>
                              <th>Amount</th>
                              <th>Order ID</th>
                              <th>Payment Type</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table_data"> 
                          @foreach($transaction_array as $value)
                            <tr>
                              <td>{{$loop->iteration}}</td>
                              <td>{{$value['date']}}</td>
                              <td>{{$value['booking_id']}}</td>
                              <td>{{$value['transaction_name']}}</td>
                              <td>{{$value['amount']}}</td>
                              <td>{{$value['order_id']}}</td>
                              <td>{{$value['payment_type']}}</td>
                              <td>{{$value['payment_status']}}</td>
                              <td><button data-href="{{ url('account/transaction-info',[$value['id']]) }}" class="txn_info btn btn-green">View</button></td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Add Modal-->
<div class="modal fade txn-modal" id="modalContactForm_userinfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">

 
</div>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script type="text/javascript">
  function filter_txn()
  {
    var booking_id='';

    booking_id=$('#booking_id').val();

    $.ajax({
      type:'GET',
      url:'/km_admin/account/bookingid-receipts-filter/'+booking_id+'',
      data:'{booking_id:'+booking_id+'}',
      success:function(data)
      {
        console.log(data);
        $('#table_data').html('');
        var new_tr='';
        if(data !='')
        {
          var i=0;
          $.each(data,function(key,value)
          {
            i++;
            new_tr+='<tr><td>'+i+'</td><td>'+value.date+'</td><td>'+value.booking_id+'</td><td>'+value.transaction_name+'</td><td>'+value.amount+'</td><td>'+value.order_id+'</td><td>'+value.payment_status+'</td></tr>';
          });
          $('#table_data').html(new_tr);
        }
        else
        {
          $('#table_data').html('<tr><td colspan=6 style="text-align:center;">No Records Found.</td></tr>')
        }
        
      }
    });
  }
</script>

@push('autocomp-khushbu')
<script>
$(document).on('click', 'button.txn_info', function() {
         
         $('div.txn-modal').load($(this).data('href'), function() {
             $(this).modal('show');
            
 });
 });

</script>
@endpush

@endsection
