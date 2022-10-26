
@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')

	                

<div class="container-fluid main-container"> 
	<!--Page header--> 
	<div class="page-header"> 
		<div class="page-leftheader"> 
			<h4 class="page-title">Dashboard</h4> 
		</div> 
		<!-- <div class="page-rightheader ms-auto d-lg-flex d-none"> 
			<div class="ms-5 mb-0"> 
				<a class="btn btn-white date-range-btn" href="javascript:void(0)" id="daterange-btn"> 
					<svg class="header-icon2 me-3" x="1008" y="1248" viewBox="0 0 24 24" height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"> 
						<path d="M5 8h14V6H5z" opacity=".3"></path>
						<path d="M7 11h2v2H7zm12-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-4 3h2v2h-2zm-4 0h2v2h-2z"></path> 
					</svg> 
					<span>Select Date <i class="fa fa-caret-down"></i></span> 
				</a> 
			</div> 
		</div>  -->
	</div> 
	<!--End Page header--> 
	<!--Row--> 
	<div class="row"> 
		<div class="col-xl-4 col-md-12"> <div class="card expenses-card overflow-hidden"> 
			<div class="card-body"> 
				<div class="feature"> 
					<i class="fa fa-university feature-icon"></i> 
					<h1 class="font-weight-bold mb-0 mt-4">&#x20b9; {{$total_income}} </h1> 
					<p class="text-muted fs-18 mb-0">Total Income</p>
				</div> 
			</div> 
			<div class="chart-wrapper"> 
				<div class="chart-container">
					<canvas id="expense" class="overflow-hidden" width="334" height="185" style="display: block; box-sizing: border-box; height: 185px; width: 334px;">
					</canvas>
				</div> 
			</div> 
		</div> 
	</div> 
	<div class="col-xl-8 col-md-12"> 
		<div class="card"> 
			<div class="card-body"> 
				<div class="row"> 
					<div class="col-12 col-sm d-flex mb-4 mb-sm-0"> 
						<i class="mdi mdi-account-multiple-outline card-custom-icon icon-dropshadow-secondary text-secondary fs-60" style="color: #009d00 !important;"></i> 
						<div class="mt-5"> 
							<h6>Total Employee</h6> 
							<h3 class="mb-0 font-weight-bold">{{$total_employee}}</h3> 
						</div> 
					</div> 
					<div class="col-12 col-sm d-flex mb-4 mb-sm-0">
						<a href="/attendence/each-attendence"> 
							<i class="mdi mdi-account-multiple-outline card-custom-icon icon-dropshadow-secondary text-secondary fs-60" style="color: #009d00 !important;"></i>
							<div class="mt-5"> 
								<h6>Today Present Employee</h6> 
								<h3 class="mb-0 font-weight-bold">{{$present_employee}}</h3> 
							</div> </a>
						</div> 
						<div class="col-12 col-sm d-flex">
							<a href="/attendence/each-attendence"> 
								<i class="mdi mdi-account-multiple-outline card-custom-icon icon-dropshadow-secondary text-secondary fs-60"></i>
								<div class="mt-5"> 
									<h6>Today Absent Employee</h6> 
									<h3 class="mb-0 font-weight-bold">{{$absent_employee}}</h3> 
								</div> 
							</a>
						</div> 
					</div> 
				</div> 
			</div> 
			<div class="row"> 
				<div class="col-xl-4 col-lg-4 col-md-12"> 
					<div class="card"> 
						<div class="card-body"> 
							<p class="mb-1">Total Expenditure</p>
							<h2 class="mb-1 font-weight-bold">&#x20b9; {{$total_expenditure}}</h2> 
						</div> 
					</div> 
				</div> 
				<div class="col-xl-4 col-lg-4 col-md-12"> 
					<div class="card"> 
						<div class="card-body"> 
							<p class="mb-1">Today Income</p>
							<h2 class="mb-1 font-weight-bold">&#x20b9; {{$today_income}}</h2> 
						</div> 
					</div> 
				</div> 
				<div class="col-xl-4 col-lg-4 col-md-12"> 
					<div class="card"> 
						<div class="card-body"> 
							<p class="mb-1">Today Expenditure</p>
							<h2 class="mb-1 font-weight-bold">&#x20b9; {{$today_expenditure}}</h2> 
						</div> 
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

							

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<script>
var xValues = ["Total single Booking", "Total blue collor"];
var yValues = [{{$total_single_booking}}, {{$total_blue_collor_booking}} ];
var barColors = ["red", "green"];

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
      text: "Booking Summery"
    }
  }
});
</script>


<script>
var xValues = ["Total Income", "Total Expenditure", "Today Income","Today Expenditure"];
var yValues = [{{$total_income}}, {{$total_expenditure}}, {{$today_income}},{{$today_expenditure}}];
var barColors = ["red", "green","blue","orange"];

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
      text: "Income/Expenditure Summery"
    }
  }
});
</script>

            @endsection

