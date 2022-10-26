
@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')

	                <!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title">Support Dashboard</h4>
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
												
												<p class=" mb-1 ">Pending Ticket</p>
												<h2 class="mb-1 font-weight-bold">{{$pending_ticket}}</h2>
												
											</div>
										</div>
									</div>

									<div class="col-xl-4 col-lg-4 col-md-12">
										<div class="card">
											<div class="card-body">
												<p class=" mb-1 ">Inprogress Ticket</p>
												<h2 class="mb-1 font-weight-bold">{{$inprogress_ticket}}</h2>
											</div>
										</div>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-12">
										<div class="card">
											<div class="card-body">
												<p class=" mb-1 ">Resolved Ticket</p>
												<h2 class="mb-1 font-weight-bold">{{$resolved_ticket}}</h2>
											</div>
										</div>
									</div>
									<div class="col-xl-4 col-lg-4 col-md-12">
										<div class="card">
											<div class="card-body">
												<p class=" mb-1 ">Overdue Ticket</p>
												<h2 class="mb-1 font-weight-bold">{{$overdue_ticket}}</h2>
												
											</div>
										</div>
									</div>
								</div>
								
								<div class="card p-3 m-3-rv">
									<h3 class=" rv-list-users">Overdue Ticket</h3>
									<table id="km_dt" class="table table-bordered table-hover dataTable no-footer" >
				                        <thead>
				                            <tr>
				                                <th>Sr.No.</th>
				                                <th>Description</th>
				                                <th>Assigned Person</th>
				                                <th>Status</th>
				                                <th>Created Date</th>
				                                <th>Priority</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                        	@foreach($overdue_ticket_list as $ticket_value)
				                            <tr>
			                                    <td>{{$loop->iteration}}</td>
			                                    <td>{{$ticket_value->description}}</td>
			                                    <td>{{$ticket_value->assign_person}}</td>
			                                    <td>{{$ticket_value->present_status}}</td>
			                                    <td>{{$ticket_value->created_date}}</td>
			                                    <td>{{$ticket_value->priority}}</td>
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

