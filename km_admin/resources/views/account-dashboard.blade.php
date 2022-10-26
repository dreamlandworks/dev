
@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')

	                <!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title">Accounts Dashboard</h4>
							</div>
							<!-- <div class="page-rightheader ml-auto d-lg-flex d-none">
								<div class="ml-5 mb-0">
									<a class="btn btn-white date-range-btn" href="#" id="daterange-btn">
										<svg class="header-icon2 mr-3" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
											<path d="M5 8h14V6H5z" opacity=".3"/><path d="M7 11h2v2H7zm12-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-4 3h2v2h-2zm-4 0h2v2h-2z"/>
										</svg> <span>Select Date
										<i class="fa fa-caret-down"></i></span>
									</a>
								</div>
							</div> -->
						</div>
						<!--End Page header-->

						<!--Row-->
						<div class="row">
							<div class="col-xl-9 col-md-12 col-lg-12">
								<div class="row">
									<div class="col-xl-4 col-lg-4 col-md-12">
										<div class="card">
											<div class="card-body">
												
												<p class=" mb-1 ">Today Income</p>
												<h2 class="mb-1 font-weight-bold">&#x20b9; {{$today_income}}</h2>
												
											</div>
										</div>
									</div>

									<div class="col-xl-4 col-lg-4 col-md-12">
										<div class="card">
											<div class="card-body">
												
												<p class=" mb-1 ">Today Expenditure</p>
												<h2 class="mb-1 font-weight-bold">&#x20b9; {{$today_expenditure}}</h2>
												
											</div>
										</div>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-12">
										<div class="card">
											<div class="card-body">
												
												<p class=" mb-1 ">Total Income</p>
												<h2 class="mb-1 font-weight-bold">&#x20b9; {{$total_income}}</h2>
												
											</div>
										</div>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-12">
										<div class="card">
											<div class="card-body">
												
												<p class=" mb-1 ">Total Expenditure</p>
												<h2 class="mb-1 font-weight-bold">&#x20b9; {{$total_expenditure}}</h2>
												
											</div>
										</div>
									</div>

								
								<div class="col-xl-4 col-lg-4 col-md-12">
									<div class="card">
										<div class="card-body">
											
											<p class=" mb-1 ">Withdraw Request</p>
											<h2 class="mb-1 font-weight-bold">{{$pending_withdraw}}
											/{{$completed_withdraw}}</h2>
											
										</div>
									</div>
								</div>
								<div class="col-xl-4 col-lg-4 col-md-12">
									<div class="card">
										<div class="card-body">
											
											<p class=" mb-1 ">Rejected Request</p>
											<h2 class="mb-1 font-weight-bold">{{$rejected_withdraw}}</h2>
											
										</div>
									</div>
								</div>
							</div>
						</div>

						</div>
						
						<div class="row">
							<div class="col-md-6">
								<canvas id="myChart1" style="width:100%; "></canvas>
							</div>
							<div class="col-md-6">
								<canvas id="myChart2" style="width:100%; "></canvas>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-6">
								<p class=" mb-1 "><h3>Forcast</h3></p>
								 	<table class="table table-bordered table-hover dataTable no-footer">
										<thead>
											<tr>
												<th></th>
												<th>This Month</th>
												<th>Next month</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Income</td>
												<td>{{$this_month_income}}</td>
												<td>{{$this_month_income+($this_month_income*20)/100}}</td>
											</tr>
											<tr>
												<td>Expenditure</td>
												<td>{{$this_month_expenditure}}</td>
												<td>{{$this_month_expenditure+($this_month_expenditure*20)/100}}</td>
											</tr>
										</tbody> 
									</table>
							</div>
						</div>

					</div>
				</div><!-- end app-content-->
			</div>
            
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
 

<!-- Inxome  performance      -->

<script>
var xValues = ["Booking", "Subscription","Misc"];
var yValues = [{{$booking_income}}, {{$subscription_income}}, {{$misc_income}}];
var barColors = ["red", "green","blue"];

new Chart("myChart1", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Income Summery"
    }
  }
});
</script>

<script>
var xValues = ["Booking", "Subscription", "Misc"];
var yValues = [{{$booking_expenditure}}, {{$subscription_expenditure}}, {{$misc_expenditure}}];
var barColors = ["red", "green","blue","orange","brown"];

new Chart("myChart2", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      backgroundColor: barColors,
      data: yValues
    }]
  },
  options: {
    legend: {display: false},
    title: {
      display: true,
      text: "Expenditure Summery"
    }
  }
});
</script>
@endsection

