<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>

		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Dashtic - Bootstrap Webapp Responsive Dashboard Simple Admin Panel Premium HTML5 Template" name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
		<meta name="keywords" content="Admin, Admin Template, Dashboard, Responsive, Admin Dashboard, Bootstrap, Bootstrap 4, Clean, Backend, Jquery, Modern, Web App, Admin Panel, Ui, Premium Admin Templates, Flat, Admin Theme, Ui Kit, Bootstrap Admin, Responsive Admin, Application, Template, Admin Themes, Dashboard Template"/>

		<!-- Title -->
		<title>Dashtic - Bootstrap Webapp Responsive Dashboard Simple Admin Panel Premium HTML5 Template</title>

		<!--Favicon -->
		<link rel="icon" href="{{ asset('images/brand/favicon.ico') }}" type="image/x-icon"/>

		<!-- Bootstrap css -->
		<link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" />

		<!-- Style css -->
		<link href="{{ asset('css/style.css') }}" rel="stylesheet" />

		<!-- Dark css -->
		<link href="{{ asset('css/dark.css') }}" rel="stylesheet" />

		<!-- Skins css -->
		<link href="{{ asset('css/skins.css') }}" rel="stylesheet" />

		<!-- Animate css -->
		<link href="{{ asset('css/animated.css') }}" rel="stylesheet" />

		<!--Sidemenu css -->
        <link id="theme" href="{{ asset('css/sidemenu.css') }}" rel="stylesheet">

		<!-- P-scroll bar css-->
		<link href="{{ asset('plugins/p-scrollbar/p-scrollbar.css') }}" rel="stylesheet" />

		<!---Icons css-->
		<link href="{{ asset('plugins/web-fonts/icons.css') }}" rel="stylesheet" />
		<link href="{{ asset('plugins/web-fonts/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
		<link href="{{ asset('plugins/web-fonts/plugin.css') }}" rel="stylesheet" />

		<!---jvectormap css-->
		<link href="{{ asset('plugins/jvectormap/jqvmap.css') }}" rel="stylesheet" />

		<!-- Data table css -->
		<link href="{{ asset('plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />

		<!--Daterangepicker css-->
		<link href="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />

    <style>

        .ic_space {
            margin-right: 10px;
            font-size: 24px;
        }

.card.p-3.m-3-rv {
        overflow: scroll;
        width:1050px !importent;

}
div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.5em;
    display: inline-block;
    width: 136px;
    position: relative;
    /* right: 10%; */
}
span.input-group-text.mk_prepend {
    width: 36px;
    padding-left: 8px;
    font-size: 12px;
}
.col-sm-12.back_btn {
    margin-left: 700;
    /* margin: 30px; */
    margin-left: 800px;
    margin-bottom: 30px;
}
.container-fluid.container_rv.mk_container {
    padding-bottom: 30px;
}
.mk_nowrap{
  white-space: nowrap;
}
.mk_tbodynowrap{
      white-space: nowrap;
}
	</style>

	</head>
<?php
$user = auth()->user();
?>
	<body class="app sidebar-mini light-mode default-sidebar">

		<!---Global-loader-->
		<div id="global-loader" >
			<img src="{{ asset('images/svgs/loader.svg') }}" alt="loader">
		</div>
		<div class="page">
			<div class="page-main">

				<!--aside open-->
				<div class="app-sidebar app-sidebar2">
					<div class="app-sidebar__logo">
						<a class="header-brand" href="index.html">
							<img src="{{ asset('images/brand/logo.png') }}" class="header-brand-img desktop-lgo" alt="Dashtic logo">
							<img src="{{ asset('images/brand/logo1.png') }}" class="header-brand-img dark-logo" alt="Dashtic logo">
							<img src="{{ asset('images/brand/favicon.png') }}" class="header-brand-img mobile-logo" alt="Dashtic logo">
							<img src="{{ asset('images/brand/favicon1.png') }}" class="header-brand-img darkmobile-logo" alt="Dashtic logo">
						</a>
					</div>
				</div>
				<aside class="app-sidebar app-sidebar3">
					<div class="app-sidebar__user">
						<div class="dropdown user-pro-body text-center">
							<div class="user-pic">
								<img src="{{ asset('images/users/16.jpg') }}" alt="user-img" class="avatar-xl rounded-circle mb-1">
							</div>
							<div class="user-info">
								<h5 class=" mb-1 font-weight-bold">Admin</h5>
								<span class="text-muted app-sidebar__user-name text-sm">Software Developer</span>
							</div>
						</div>
					</div>
					<ul class="side-menu">
						<li class="slide">
							<!--<a class="side-menu__item"  data-toggle="slide" href="{{ url('dashboard')}}">-->
							<a class="side-menu__item" href="{{ url('dashboard')}}">
							<!--<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>-->

							<i class="fa fa-home ic_space" aria-hidden="true"></i>

							<span class="side-menu__label">Dashboard</span>
							<i class="angle fa fa-angle-right"></i>
							</a>
							<!--<ul class="slide-menu">-->
							<!--	<li><a class="slide-item"  href="{{ url('dashboard')}}"><span>Dashboard 01</span></a></li>-->

							<!--</ul>-->
						</li>
						@if($user->user_type=="Super Admin")
                        <li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#">

							<i class="fa fa-user-circle ic_space" aria-hidden="true"></i>


							<span class="side-menu__label">Administrator</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="{{url('users')}}" class="slide-item">Users</a></li>
								<li><a href="{{url('user/create')}}" class="slide-item"> Add User</a></li>
								<li><a href="{{ url('role/create') }}" class="slide-item">Roles</a></li>
								<li><a href="{{ url('permission/create') }}" class="slide-item">Permission</a></li>
							</ul>
						</li>
                        @endif
						@if($user->user_type=="Super Admin")
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fa fa-rocket ic_space" aria-hidden="true"></i>
							<span class="side-menu__label">Service Provider</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
							<li><a href="{{url('Approve-sps')}}" class="slide-item">Approve Provider</a></li>
								<li><a href="{{url('sps')}}" class="slide-item">Service Providers</a></li>
								<li><a href="{{url('sp/create')}}" class="slide-item"> Add Service Provider</a></li>
							</ul>
						</li>
						@endif
						@if(($user->user_type=="Super Admin") ||($user->user_type=="Operation"))
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fa fa-ticket ic_space" aria-hidden="true"></i>
							<span class="side-menu__label">Single Move Booking</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
							<li><a href="{{url('booking-sm/create')}}" class="slide-item">Create Booking</a></li>
							<li><a href="{{url('booking-sm')}}" class="slide-item">Booking List</a></li>		
							<li><a href="{{url('job-post-sm/create')}}" class="slide-item">Create Job Post</a></li>
							<li><a href="{{url('job-post-sm')}}" class="slide-item">Job Post List</a></li>
							</ul>
						</li>
						@endif
						@if(($user->user_type=="Super Admin") ||($user->user_type=="Operation"))
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fa fa-ticket ic_space" aria-hidden="true"></i>
							<span class="side-menu__label">Blue Collor Booking</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
							<li><a href="{{url('booking-cb/create')}}" class="slide-item">Create Booking</a></li>
							<li><a href="{{url('booking-cb')}}" class="slide-item">Booking List</a></li>
								<li><a href="{{url('job-post-cb/create')}}" class="slide-item">Create Job Post</a></li>
							<li><a href="{{url('job-post-cb')}}" class="slide-item">Job Post List</a></li>
							</ul>
						</li>
						@endif
						@if(($user->user_type=="Super Admin") ||($user->user_type=="HR"))
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fa fa-user ic_space" aria-hidden="true"></i>
							<span class="side-menu__label">HR Management</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li>
									<a href="{{url('/employee/create')}}" class="slide-item">Create New Employee</a>
								</li>
								<li>
									<a href="{{url('/employee/list')}}" class="slide-item">Employee List</a>
								</li>
								<li>
									<a href="{{url('/hr/create-designation')}}" class="slide-item">Create Designation & PayDetails</a>
								</li>
								<li>
									<a href="{{url('/hr')}}" class="slide-item">Designation & Pay Details List</a>
								</li>
								<!--<li>-->
								<!--	<a href="{{url('/employee/list')}}" class="slide-item">View Employee Performance Statistics</a>-->
								<!--</li>-->
								<li>
									<a href="{{url('/attendence/list')}}" class="slide-item">View Employee Attendance
</a>
								</li>
								<li>
									<a href="{{url('/attendence/create')}}" class="slide-item"> Add Employee Attendance
</a>
								</li>
								<li>
									<a href="{{url('/performance/create')}}" class="slide-item">Create Employee Performance Report</a>
								</li>
								<li>
									<a href="{{url('/performance/list')}}" class="slide-item">View Employee Performance Report</a>
								</li>
								<!--<li>-->
								<!--	<a href="{{url('/relieve/create')}}" class="slide-item">Relieve Employee</a>-->
								<!--</li>-->
								<li>
									<a href="{{url('/relieve/list')}}" class="slide-item">Relieve Employee List</a>
								</li>
								<li>
									<a href="{{url('/relieve/create')}}" class="slide-item">Create Employee Relieve </a>
								</li>
							</ul>
						</li>
						@endif
						@if(($user->user_type=="Super Admin") ||($user->user_type=="Marketing"))
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fa fa-building ic_space" aria-hidden="true"></i>
							<span class="side-menu__label">Marketing Management</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
							<li><a href="{{url('marketing-plan/create')}}" class="slide-item">Create Marketing Plan</a></li>
							<li><a href="{{url('marketing-plans')}}" class="slide-item">View Marketing Plan</a></li>
							<li><a href="{{url('marketing-statistics')}}" class="slide-item">View Marketing Statistics</a></li>
							<li><a href="{{url('marketing-statistics/create')}}" class="slide-item">Create Marketing Statistics</a></li>
                            <li><a href="{{url('lead/create')}}" class="slide-item">Create Leads</a></li>
                            <li><a href="{{url('leads-list')}}" class="slide-item">View list of Leads</a></li>
							<!--<li><a href="{{url('module-list/create')}}" class="slide-item">Create Module List</a></li>-->
       <!--                     <li><a href="{{url('module-lists')}}" class="slide-item">View Module List</a></li>-->
							</ul>
						</li>
						@endif
						@if(($user->user_type=="Super Admin") ||($user->user_type=="Account"))
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fa fa-calculator ic_space" aria-hidden="true"></i>
							<span class="side-menu__label">Account Management</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
							<li><a href="{{url('account/receipts')}}" class="slide-item">View Receipts</a></li>
							<li><a href="{{url('account/bookingid-receipts')}}" class="slide-item">View Details by BookingId</a></li>
							<li><a href="{{url('account/payments')}}" class="slide-item">View Payments</a></li>
							<li><a href="{{url('account/create-withdrawl')}}" class="slide-item">Create Withdrawl Request</a></li>
							<li><a href="{{url('account/approve-withdrawl')}}" class="slide-item">View Withdrawl Request</a></li>
							<li><a href="{{url('account/approved-withdrawl')}}" class="slide-item">Approved Withdrawl Request</a></li>
							<li><a href="{{url('account/create-bid')}}" class="slide-item">Create/Edit New Bid Packs</a></li>
                            <li><a href="{{url('account/list')}}" class="slide-item">View Bid Packs</a></li>
							</ul>
						</li>
						@endif
						@if(($user->user_type=="Super Admin") ||($user->user_type=="Support"))
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fa fa-support ic_space" aria-hidden="true"></i>
							<span class="side-menu__label">Support Management</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
								<li><a href="{{url('support/create')}}" class="slide-item">Create Ticket </a></li>
								<li><a href="{{url('support/list')}}" class="slide-item">View Ticket</a></li>
							</ul>
						</li>
						@endif
						@if($user->user_type=="Super Admin")
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fa fa-user-secret ic_space" aria-hidden="true"></i>
							<span class="side-menu__label">User Plan</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
							<li><a href="{{url('user-plan/create')}}" class="slide-item">Create User Plan</a></li>
							<li><a href="{{url('user-plans')}}" class="slide-item">Plan List</a></li>
							
							</ul>
						</li>
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fa fa-user-secret ic_space" aria-hidden="true"></i>
							<span class="side-menu__label">SP Plan</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
							<li><a href="{{url('sp-plan/create')}}" class="slide-item">Create SP Plan</a></li>
							<li><a href="{{url('sp-plans')}}" class="slide-item">Plan List</a></li>
							
							</ul>
						</li>
						
						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="#">
							<i class="fa fa-snowflake-o ic_space" aria-hidden="true"></i>
							<span class="side-menu__label">General</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu">
							<li><a href="{{url('category/create')}}" class="slide-item">Create Categeory</a></li>
							<li><a href="{{url('categories')}}" class="slide-item">Categeory List</a></li></ul>
							<ul class="slide-menu">
							<li><a href="{{url('sub-category/create')}}" class="slide-item">Create Sub Categeory</a></li>
							<li><a href="{{url('sub-categories')}}" class="slide-item">Sub Categeory List</a></li></ul>
							<ul class="slide-menu">
							<li><a href="{{url('prof/create')}}" class="slide-item">Create Profession</a></li>
							<li><a href="{{url('professions')}}" class="slide-item">Profession List</a></li>
							</ul>
							<ul class="slide-menu">
							<li><a href="{{url('qual/create')}}" class="slide-item">Create Qualification</a></li>
							<li><a href="{{url('qualifications')}}" class="slide-item">Qualification List</a></li>
							</ul>
							<ul class="slide-menu">
							<li><a href="{{url('keyword/create')}}" class="slide-item">Create Keywords</a></li>
							<li><a href="{{url('keywords')}}" class="slide-item">Keywords List</a></li>
							</ul>
						</li>
						@endif
					</ul>
				</aside>
				<!--aside closed-->

                <div class="app-content main-content">
					<div class="side-app">

						<!--app header-->
						<div class="app-header header top-header">
							<div class="container-fluid">
								<div class="d-flex">
									<a class="header-brand" href="index.html">
										<img src="{{ asset('images/brand/logo.png') }}" class="header-brand-img desktop-lgo" alt="Dashtic logo">
										<img src="{{ asset('images/brand/logo1.png') }}" class="header-brand-img dark-logo" alt="Dashtic logo">
										<img src="{{ asset('images/brand/favicon.png') }}" class="header-brand-img mobile-logo" alt="Dashtic logo">
										<img src="{{ asset('images/brand/favicon1.png') }}" class="header-brand-img darkmobile-logo" alt="Dashtic logo">
									</a>
									<div class="dropdown side-nav">
										<div class="app-sidebar__toggle" data-toggle="sidebar">
											<a class="open-toggle" href="#">
												<svg class="header-icon mt-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
											</a>
											<a class="close-toggle" href="#">
												<svg class="header-icon mt-1" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41z"/></svg>
											</a>
										</div>
									</div>

									<div class="d-flex order-lg-2 ml-auto">
										<a href="#" data-toggle="search" class="nav-link nav-link-lg d-md-none navsearch">
											<svg class="header-icon search-icon" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
												<path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
											</svg>
										</a>
										<div class="mt-1">
											<form class="form-inline">
												<div class="search-element">
													<input type="search" class="form-control header-search" placeholder="Search…" aria-label="Search" tabindex="1">
													<button class="btn btn-primary-color" type="submit">
														<svg class="header-icon search-icon" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
															<path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
														</svg>
													</button>
												</div>
											</form>
										</div><!-- SEARCH -->
										<div class="dropdown   header-fullscreen pl-5" >
											<a  class="nav-link icon full-screen-link p-0"  id="fullscreen-button">
												<svg class="header-icon" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><path d="M7,14 L5,14 L5,19 L10,19 L10,17 L7,17 L7,14 Z M5,10 L7,10 L7,7 L10,7 L10,5 L5,5 L5,10 Z M17,17 L14,17 L14,19 L19,19 L19,14 L17,14 L17,17 Z M14,5 L14,7 L17,7 L17,10 L19,10 L19,5 L14,5 Z"></path></svg>
											</a>
										</div>
										<div class="dropdown header-notify pl-4">
											<a class="nav-link icon p-0" data-toggle="dropdown">
												<svg class="header-icon" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false"><path opacity=".3" d="M12 6.5c-2.49 0-4 2.02-4 4.5v6h8v-6c0-2.48-1.51-4.5-4-4.5z"></path><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-11c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2v-5zm-2 6H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6zM7.58 4.08L6.15 2.65C3.75 4.48 2.17 7.3 2.03 10.5h2a8.445 8.445 0 013.55-6.42zm12.39 6.42h2c-.15-3.2-1.73-6.02-4.12-7.85l-1.42 1.43a8.495 8.495 0 013.54 6.42z"></path></svg>
												<span class="pulse "></span>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow  animated">
												<a href="#" class="dropdown-item d-flex pb-3">
													<svg class="header-icon mr-4" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
														<path d="M15 11V4H4v8.17l.59-.58.58-.59H6z" opacity=".3"/><path d="M21 6h-2v9H6v2c0 .55.45 1 1 1h11l4 4V7c0-.55-.45-1-1-1zm-5 7c.55 0 1-.45 1-1V3c0-.55-.45-1-1-1H3c-.55 0-1 .45-1 1v14l4-4h10zM4.59 11.59l-.59.58V4h11v7H5.17l-.58.59z"/></svg>
													<div>
														<div class="font-weight-bold">Message Sent.</div>
														<div class="small text-muted">3 hours ago</div>
													</div>
												</a>
												<a href="#" class="dropdown-item d-flex pb-3">
													<svg class="header-icon mr-4" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
														<path d="M0 0h24v24H0V0z" fill="none"/><path d="M15.55 11l2.76-5H6.16l2.37 5z" opacity=".3"/><path d="M15.55 13c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.37-.66-.11-1.48-.87-1.48H5.21l-.94-2H1v2h2l3.6 7.59-1.35 2.44C4.52 15.37 5.48 17 7 17h12v-2H7l1.1-2h7.45zM6.16 6h12.15l-2.76 5H8.53L6.16 6zM7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-.9-2-2-2z"/></svg>
													<div>
														<div class="font-weight-bold"> Order Placed</div>
														<div class="small text-muted">5  hour ago</div>
													</div>
												</a>
												<a href="#" class="dropdown-item d-flex pb-3">
													<svg class="header-icon mr-4" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
														<path d="M5 8h14V6H5z" opacity=".3"/><path d="M7 11h2v2H7zm12-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2zm-4 3h2v2h-2zm-4 0h2v2h-2z"/>
													</svg>
													<div>
														<div class="font-weight-bold"> Event Started</div>
														<div class="small text-muted">45 mintues ago</div>
													</div>
												</a>
												<a href="#" class="dropdown-item d-flex pb-3">
													<svg class="header-icon mr-4" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
														<path d="M0 0h24v24H0V0z" fill="none"/><path d="M18 13h5v7h-5z" opacity=".3"/><path d="M23 11.01L18 11c-.55 0-1 .45-1 1v9c0 .55.45 1 1 1h5c.55 0 1-.45 1-1v-9c0-.55-.45-.99-1-.99zM23 20h-5v-7h5v7zM2 4h18v5h2V4c0-1.11-.9-2-2-2H2C.89 2 0 2.89 0 4v12c0 1.1.89 2 2 2h7v2H7v2h8v-2h-2v-2h2v-2H2V4zm9 2l-.97 3H7l2.47 1.76-.94 2.91 2.47-1.8 2.47 1.8-.94-2.91L15 9h-3.03z"/></svg>
													<div>
														<div class="font-weight-bold">Your Admin lanuched</div>
														<div class="small text-muted">1 daya ago</div>
													</div>
												</a>
												<div class=" text-center p-2 border-top">
													<a href="#" class="">View All Notifications</a>
												</div>
											</div>
										</div>
										<div class="dropdown profile-dropdown">
											<a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
												<span>
													<img src="{{ asset('images/users/16.jpg') }}" alt="img" class="avatar avatar-md brround">
												</span>
											</a>
											<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow animated">
												<div class="text-center">
													<a href="#" class="dropdown-item text-center user pb-0 font-weight-bold">Admin</a>
													<span class="text-center user-semi-title">Software Developer</span>
													<div class="dropdown-divider"></div>
												</div>
												<a class="dropdown-item d-flex" href="{{url('profile')}}">
													<svg class="header-icon mr-3" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
														<path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 16c-2.69 0-5.77 1.28-6 2h12c-.2-.71-3.3-2-6-2z" opacity=".3"/><circle cx="12" cy="8" opacity=".3" r="2"/><path d="M12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H6zm6-6c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"/>
													</svg>
													<div class="mt-1">Profile</div>
												</a>

												<a class="dropdown-item d-flex" href="{{url('logout')}}">
													<svg class="header-icon mr-3" x="1008" y="1248" viewBox="0 0 24 24"  height="100%" width="100%" preserveAspectRatio="xMidYMid meet" focusable="false">
														<path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none"/><path d="M6 20h12V10H6v10zm2-6h3v-3h2v3h3v2h-3v3h-2v-3H8v-2z" opacity=".3"/><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM8.9 6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2H8.9V6zM18 20H6V10h12v10zm-7-1h2v-3h3v-2h-3v-3h-2v3H8v2h3z"/>
													</svg>
													<div class="mt-1">Sign Out</div>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--/app header-->
						

@push('datatable-khushbu')
<script type="text/javascript">
		jQuery(document).ready(function() {
				$('#km_dt').DataTable( {
				lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
				language: {
					processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
				},
				scroller: {
					loadingIndicator: false,

				},
				pagingType: "full_numbers",
				dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",

				buttons: [
					{
						extend: 'copy',
						className: 'btn-sm btn-info',
						title: 'School',
						header: false,
						footer: true,
						exportOptions: {
							// columns: ':visible'
						}
					},
					{
						extend: 'csv',
						className: 'btn-sm btn-success',
						title: 'School',
						header: false,
						footer: true,
						exportOptions: {
							// columns: ':visible'
						}
					},
					{
						extend: 'excel',
						className: 'btn-sm btn-danger',
						title: 'School',
						header: false,
						footer: true,
						exportOptions: {
							// columns: ':visible',
						}
					},
					{
						extend: 'pdf',
						className: 'btn-sm btn-primary',
						title: 'School',
						pageSize: 'A2',
						header: false,
						footer: true,
						exportOptions: {
							// columns: ':visible'
						}
					},
					{
						extend: 'print',
						className: 'btn-sm btn-dark',
						title: 'School',
						pageSize: 'A2',
						header: true,
						footer: false,
						orientation: 'landscape',
						exportOptions: {
							// columns: ':visible',
							stripHtml: false
						}
					}
				],

				});
		} );

</script>
@endpush
