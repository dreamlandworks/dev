@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')

<div class="container-fluid main-container"> 
	<!--Page header--> 
	<div class="page-header"> 
		<div class="page-leftheader"> 
			<h4 class="page-title"> Service provider Profile</h4> 
		</div>  
	</div> 
	<!--End Page header--> 
	<div class="main-proifle"> 
		<div class="row"> 
			<div class="col-lg-7"> 
				<div class="box-widget widget-user"> 
					<div class="widget-user-image d-sm-flex"> 
						<img alt="User Avatar" class="rounded-circle border p-0" src="@if($userDetails && $userDetails != '[]'){{asset('images/user_profile')}}/{{$userDetails->profile_pic}}@endif"> 
						<div class="ms-sm-4 mt-4"> 
							<h4 class="pro-user-username mb-3 font-weight-bold">@if($userDetails && $userDetails != '[]')  {{$userDetails->fname}} @endif
								<i class="fa fa-check-circle text-success"></i>
							</h4> 
							
							<div class="d-flex mb-1"> 
									<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none">
									</path>
									<path d="M20 8l-8 5-8-5v10h16zm0-2H4l8 4.99z" opacity=".3"></path>
									<path d="M4 20h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2zM20 6l-8 4.99L4 6h16zM4 8l8 5 8-5v10H4V8z"></path>
								</svg> 
								<div class="h6 mb-0 ms-3 mt-1">@if($users && $users != '') {{$users->email}} @endif </div> </div> 
								<div class="d-flex"> 
									<svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
										<path d="M0 0h24v24H0V0z" fill="none"></path>
										<path d="M15.2 18.21c1.21.41 2.48.67 3.8.76v-1.5c-.88-.07-1.75-.22-2.6-.45l-1.2 1.19zM6.54 5h-1.5c.09 1.32.35 2.59.75 3.79l1.2-1.21c-.24-.83-.39-1.7-.45-2.58zM14 8h5V5h-5z" opacity=".3"></path><path d="M20 15.5c-1.25 0-2.45-.2-3.57-.57-.1-.03-.21-.05-.31-.05-.26 0-.51.1-.71.29l-2.2 2.2c-2.83-1.44-5.15-3.75-6.59-6.58l2.2-2.21c.28-.27.36-.66.25-1.01C8.7 6.45 8.5 5.25 8.5 4c0-.55-.45-1-1-1H4c-.55 0-1 .45-1 1 0 9.39 7.61 17 17 17 .55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1zM5.03 5h1.5c.07.88.22 1.75.46 2.59L5.79 8.8c-.41-1.21-.67-2.48-.76-3.8zM19 18.97c-1.32-.09-2.6-.35-3.8-.76l1.2-1.2c.85.24 1.72.39 2.6.45v1.51zM12 3v10l3-3h6V3h-9zm7 5h-5V5h5v3z">
										</path>
									</svg> 
										<div class="h6 mb-0 ms-3 mt-1">@if($users && $users != '') {{$userDetails->mobile}} @endif</div> 
									</div> 
								</div> 
							</div> 
						</div> 
					</div> 
				</div>  
				<!-- /.profile-cover --> 
			</div> 

			<!-- Row --> 
			<div class="row"> 
				<div class="col-xl-6 col-lg-6 col-md-6"> 
					<div class="border-0"> 
						<div class="tab-content"> 
							<div class="tab-pane active" id="tab-7"> 
								<div class="card"> 
									<div class="card-body"> 
										<h5 class="font-weight-bold">Booking</h5> 

										<div class="col-lg-12 col-md-auto"> 
											<div class="mt-5"> 
												<div class="main-profile-contact-list row"> 
													<div class="media col-sm-4 col-md-6 col-xl-4"> 
														<div class="media-icon bg-light text-primary me-3 mt-1"> 
															<i class="fa fa-sticky-note-o fs-18"></i> 
														</div> 
														<div class="media-body"> 
															<small class="text-muted">Total Booking </small> 
															<div class="font-weight-bold fs-25"> {{$total_booking}} </div> 
														</div> 
													</div> 
													<div class="media col-sm-4 col-md-6 col-xl-4"> 
														<div class="media-icon bg-light text-primary me-3 mt-1"> 
															<i class="fa fa-sticky-note-o fs-18"></i> 
														</div> 
														<div class="media-body"> 
															<small class="text-muted">In progress Booking</small> 
															<div class="font-weight-bold fs-25"> {{$total_inprogress_booking}} </div> 
														</div> 
													</div>
													<div class="media col-sm-4 col-md-12 col-xl-4"> 
														<div class="media-icon bg-light text-primary me-3 mt-1"> <i class="fa fa-sticky-note-o fs-18"></i> 
														</div> 
														<div class="media-body"> 
															<small class="text-muted">Pending Booking</small> 
															<div class="font-weight-bold fs-25"> {{$total_pending_booking}} </div> 
														</div> 
													</div> 
													<div class="media col-sm-4 col-md-12 col-xl-4"> 
														<div class="media-icon bg-light text-primary me-3 mt-1"> <i class="fa fa-sticky-note-o fs-18"></i> 
														</div> 
														<div class="media-body"> 
															<small class="text-muted">Rejected Booking</small> 
															<div class="font-weight-bold fs-25"> {{$total_rejected_booking}} </div> 
														</div> 
													</div> 
													<div class="media col-sm-4 col-md-12 col-xl-4"> 
														<div class="media-icon bg-light text-primary me-3 mt-1"> <i class="fa fa-sticky-note-o fs-18"></i> 
														</div> 
														<div class="media-body"> 
															<small class="text-muted">Not responded Booking</small> 
															<div class="font-weight-bold fs-25"> {{$total_notresponded_booking}} </div> 
														</div> 
													</div>
												</div> 
											</div> 
										</div>

									</div> 
								</div> 
							</div> 
						</div> 
						
					</div> 
				</div> 

				<!-- Bid -->

				<div class="col-xl-6 col-lg-6 col-md-6"> 
					<div class="border-0"> 
						<div class="tab-content"> 
							<div class="tab-pane active" id="tab-7"> 
								<div class="card"> 
									<div class="card-body"> 
										<h5 class="font-weight-bold">Post Job</h5> 

										<div class="col-lg-12 col-md-auto"> 
											<div class="mt-5"> 
												<div class="main-profile-contact-list row"> 
													<div class="media col-sm-4 col-md-6 col-xl-4"> 
														<div class="media-icon bg-light text-primary me-3 mt-1"> 
															<i class="fa fa-sticky-note-o fs-18"></i> 
														</div> 
														<div class="media-body"> 
															<small class="text-muted">Bid submitted </small> 
															<div class="font-weight-bold fs-25"> {{$total_bid}} </div> 
														</div> 
													</div> 
													<div class="media col-sm-4 col-md-6 col-xl-4"> 
														<div class="media-icon bg-light text-primary me-3 mt-1"> 
															<i class="fa fa-sticky-note-o fs-18"></i> 
														</div> 
														<div class="media-body"> 
															<small class="text-muted">Bid Awarded Booking</small> 
															<div class="font-weight-bold fs-25"> {{$total_bid_awarded}} </div> 
														</div> 
													</div>
													<div class="media col-sm-4 col-md-12 col-xl-4"> 
														<div class="media-icon bg-light text-primary me-3 mt-1"> <i class="fa fa-sticky-note-o fs-18"></i> 
														</div> 
														<div class="media-body"> 
															<small class="text-muted">Bid Pending</small> 
															<div class="font-weight-bold fs-25"> {{$total_bid_pending}} </div> 
														</div> 
													</div> 
												</div> 
											</div> 
										</div>


									</div> 
								</div> 
							</div> 
						</div> 
						
					</div> 
				</div> 
				<!-- End bid -->


			</div> 

			<!-- Row --> 
			<div class="row"> 
				<div class="col-xl-12 col-lg-12 col-md-12"> 
					<div class="border-0"> 
						<div class="tab-content"> 
							<div class="tab-pane active" id="tab-7"> 
								<div class="card"> 
									<div class="card-body"> 
										<h5 class="font-weight-bold">About me</h5> 
										<div class="main-profile-bio mb-0"> 
											<p> @if($spDetails && $spDetails != '[]') {{ucfirst($spDetails[0]->about_me)}} @endif
											</p>
										</div> 
									</div> 
									<div class="card-body border-top"> 
										<h5 class="font-weight-bold">Skills</h5>
										@php
											$all_skills=explode(',',$skills);
											foreach($all_skills as $value)
											{
												@endphp
												<a class="btn btn-sm btn-white mt-1" href="javascript:void(0)">{{ucfirst($value)}}</a>
												@php
											}
										@endphp
									</div>
									<div class="card-body border-top"> 
										<h5 class="font-weight-bold">Profession</h5>
											<a class="btn btn-sm btn-white mt-1" href="javascript:void(0)"> @if($spDetails && $spDetails != '[]') {{$spDetails[0]->name}} @endif</a>
									</div>
									<div class="card-body border-top"> 
										<h5 class="font-weight-bold">Qualification</h5>
											<a class="btn btn-sm btn-white mt-1" href="javascript:void(0)"> @if($spDetails && $spDetails != '[]') {{ucfirst($spDetails[0]->qualification)}} @endif </a>
									</div>
									 
									<!-- <div class="card-body border-top"> 
										<h5 class="font-weight-bold">Contact</h5> 
										<div class="main-profile-contact-list d-lg-flex"> 
											<div class="media me-4"> 
												<div class="media-icon bg-primary-transpa
											rent text-primary me-3 mt-1"> <i class="fa fa-phone"></i> </div> 
											<div class="media-body"> 
												<small class="text-muted">Mobile</small> 
												<div class="font-weight-bold"> +245 354 654 
												</div> 
											</div> 
										</div> 
										<div class="media me-4"> 
											<div class="media-icon bg-warning-transparent text-warning me-3 mt-1"> <i class="fa fa-slack"></i> </div> 
											<div class="media-body"> 
												<small class="text-muted">Stack</small> 
												<div class="font-weight-bold"> @spruko.com </div> 
											</div> 
										</div> 
										<div class="media"> 
											<div class="media-icon bg-info-transparent text-info me-3 mt-1"> <i class="fa fa-map"></i> 
											</div> 
											<div class="media-body"> 
												<small class="text-muted">Current Address</small> 
												<div class="font-weight-bold"> San Francisco, USA </div> 
											</div> 
										</div> 
									</div> --> 
									<!-- main-profile-contact-list --> 
								</div> 
							</div> 
						</div> 
						
					</div> 
				</div> 
			</div> 
		</div> 
	</div>
</div>

@endsection