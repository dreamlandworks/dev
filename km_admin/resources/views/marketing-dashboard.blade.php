
@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')

	                <!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title">Marketing Dashboard</h4>
							</div>
							<div class="page-rightheader ml-auto d-lg-flex d-none">
								<div class="ml-5 mb-0">
									<a class="btn btn-white date-range-btn" href="#" id="daterange-btn">
										<svg class="header-icon2 mr-3" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
											<path d="M5 8h14V6H5z" opacity=".3"/><path d="M7 11h2v2H7zm12-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-4 3h2v2h-2zm-4 0h2v2h-2z"/>
										</svg> <span>Select Date
										<i class="fa fa-caret-down"></i></span>
									</a>
								</div>
							</div>
						</div>
						<!--End Page header-->

						<!--Row-->
						<div class="row">
							<div class="col-xl-9 col-md-12 col-lg-12">
								<div class="row">
									<div class="col-xl-4 col-lg-4 col-md-12">
										<div class="card">
											<div class="card-body">
												
												<p class=" mb-1 ">Ad Campaign</p>
												<h2 class="mb-1 font-weight-bold">{{$campaign}}</h2>
												
											</div>
										</div>
									</div>

									<div class="col-xl-4 col-lg-4 col-md-12">
										<div class="card">
											<div class="card-body">
												
												<p class=" mb-1 ">Total Leads</p>
												<h2 class="mb-1 font-weight-bold">{{$leads}}</h2>
												
											</div>
										</div>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-12">
										<div class="card">
											<div class="card-body">
												
												<p class=" mb-1 ">Leads Today</p>
												<h2 class="mb-1 font-weight-bold">{{$today_leads}}</h2>
												
											</div>
										</div>
									</div>
								</div>
								

							</div>

						</div>
						<div class="row">
							<div class="col-md-6">
								<div id="leads_range" style="width:100%; height:300px;"></div>
							</div>
							<div class="col-md-6">
								<div id="myChart1" style="width:100%; height:300px;"></div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<canvas id="myChart2" style="width:100%; "></canvas>
							</div>
							<div class="col-md-6">
								<canvas id="myChart3" style="width:100%; "></canvas>
							</div>
						</div>
					</div>
				</div><!-- end app-content-->
			</div>
            
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<!-- Line chart -->
<script>
google.charts.load('current',{packages:['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
// Set Data
var data = google.visualization.arrayToDataTable([
  ['date', 'No.of Leads'],
  [50,7],[60,8],[70,8],[80,9],[90,9],
  [100,9],[110,10],[120,11],
  [130,14],[140,14],[150,15]
]);
// Set Options
var options = {
  title: 'New Leads Range',
  hAxis: {title: 'date'},
  vAxis: {title: 'No.of leads'},
  legend: 'none'
};
// Draw
var chart = new google.visualization.LineChart(document.getElementById('leads_range'));
chart.draw(data, options);
}
</script>

<!-- Pie chart -->

<script>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
var data = google.visualization.arrayToDataTable([
  ['Contry', 'Mhl'],
  ['A',54.8],
  ['B',48.6],
  ['C',44.4],
  ['D',23.9],
  ['E',14.5]
]);

var options = {
  title:'Leads Conversion'
};

var chart = new google.visualization.PieChart(document.getElementById('myChart1'));
  chart.draw(data, options);
}
</script>  

<!-- Campaign performance      -->

<script>
var xValues = ["A", "B", "C", "D", "E"];
var yValues = [55, 49, 44, 24, 15];
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
      text: "Campaign Performance"
    }
  }
});
</script>

<script>
var xValues = ["A", "B", "C", "D", "E"];
var yValues = [55, 49, 44, 24, 15];
var barColors = ["red", "green","blue","orange","brown"];

new Chart("myChart3", {
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
      text: "Campaign Performance"
    }
  }
});
</script>
@endsection

