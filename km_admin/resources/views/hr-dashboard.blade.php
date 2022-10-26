
@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')

	                <!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title">HR Dashboard</h4>
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
							<div class="col-xl-12 col-md-12 col-lg-12">
								<div class="row">
									<div class="col-xl-3 col-lg-3 col-md-12">
										<div class="card">
											<div class="card-body">
												
												<p class=" mb-1 ">Total Employee</p>
												<h2 class="mb-1 font-weight-bold">{{$total_employee}}</h2>
												
											</div>
										</div>
									</div>

									<div class="col-xl-4 col-lg-4 col-md-12">
										<a href="/attendence/each-attendence">
											<div class="card">
												<div class="card-body">
													<p class=" mb-1 ">Employee Present Today</p>
													<h2 class="mb-1 font-weight-bold">{{$present_employee}}</h2>
												</div>
											</div>
										</a>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-12">
										<a href="/attendence/each-attendence">
											<div class="card">
												<div class="card-body">
													<p class=" mb-1 ">Employee Absent Today</p>
													<h2 class="mb-1 font-weight-bold">{{$absent_employee}}</h2>
												</div>
											</div>
										</a>
									</div>
									<!-- <div class="col-xl-4 col-lg-4 col-md-12">
										<div class="card">
											<div class="card-body">
												
												<p class=" mb-1 ">Pending Leave Request</p>
												<h2 class="mb-1 font-weight-bold">24</h2>
												
											</div>
										</div>
									</div> -->
								</div>
								
								<div class="card p-3 m-3-rv">
									<h3 class=" rv-list-users">Top Employees of Month</h3>
									<table class="table table-bordered table-hover dataTable no-footer" >
				                        <thead>
				                            <tr>
				                                <th>Sr.No.</th>
				                                <th>Photo</th>
				                                <th>Name</th>
				                                <th>Dept/Designation</th>
				                                <th>Performance</th>
				                                <th>Action</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                        	<?php
							                $final_value=(array_slice($top_performer,-3));
							                $a=array_reverse($final_value);
							                $i=1;
							                foreach($a as $maxperf)
								            {
								                foreach($employee_array as $topthree)
								                {
								                	if(strpos($topthree['created_at'],date('Y-m'))!==false)
								                	{
								                	if($topthree['id']==$temp_array[$maxperf])
								                	{
								                ?>
					                            <tr>
			                                    <td><?php echo $i++; ?></td>
			                                    <td><img src="/<?php echo $topthree['document_path'];?>/<?php echo $topthree['photo'];?>" alt="Employee Photo" width="70px"></td>
			                                    <td><?php echo $topthree['name'];?></td>
			                                    <td><?php echo $topthree['designation'];?></td>
			                                    <td>
			                                    	<div class="progress progress-sm mt-3 bg-success-transparent">
														<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: <?php echo $topthree['performance'];?>%">
														</div>
													</div>
			                                     <?php echo $topthree['performance'];?>%</td>
			                                    <td>
			                                    <a href="/employee/<?php echo $topthree['id'];?>"><span class="badge badge-success">Edit </span></a>
			                                    <a href="/relieve/list"><span class="badge badge-success">Relieve</span></a><br><br>
			                                    <a href="/performance/list"><span class="badge badge-success">View Performance</span></a>
				                                </td>
				                            </tr>
					                            <?php
					                            }
					                        	}
					                        	}
					                        	}
					                            ?>
				                            
				                        </tbody>
				                    </table>
				                </div>
								<div class="card p-3 m-3-rv">
									<h3 class=" rv-list-users">Employees List</h3>
									<table id="km_dt" class="table table-bordered table-hover dataTable no-footer" >
				                        <thead>
				                            <tr>
				                                <th>Sr.No.</th>
				                                <th>Photo</th>
				                                <th>Name</th>
				                                <th>Dept/Designation</th>
				                                <th>Performance</th>
				                                <th>Action</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                        	@foreach($employee_array as $value)
				                            <tr>
			                                    <td>{{$loop->iteration}}</td>
			                                    <td><img src="/{{$value['document_path']}}/{{$value['photo']}}" alt="Employee Photo" width="70px"></td>
			                                    <td>{{$value['name']}}</td>
			                                    <td>{{$value['designation']}}</td>
			                                    <td> 
			                                    @if($value['performance']!='Not Found')
			                                    {{$value['performance']}}%
			                                    	<div class="progress progress-sm mt-3 bg-success-transparent">
														<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: {{$value['performance']}}%">
														</div>
													</div>
												@else
			                                    {{$value['performance']}}
			                                    @endif
			                                	</td>
			                                    <td>
			                                    <a href="/employee/{{$value['id']}}"><span class="badge badge-success">Edit </span></a>
			                                    <a href="/relieve/list"><span class="badge badge-success">Relieve</span></a><br><br>
			                                    <a href="/performance/list"><span class="badge badge-success">View Performance</span></a>
				                                </td>
				                            </tr>
				                            @endforeach
				                        </tbody>
				                    </table>
				                </div>
							</div>
						</div>
						
					</div>
				</div><!-- end app-content-->
			</div>
@endsection

