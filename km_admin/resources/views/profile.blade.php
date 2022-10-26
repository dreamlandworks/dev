
@extends('layouts.master')
@section('title', 'Dashboard')
@section('content')

<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title">Profile</h4>
	</div>
	
</div>
<!--End Page header-->

<!--Row-->
<div class="row">
	<div class="col-md-6">
		<div class="card box-widget widget-user">
			<div class="widget-user-image mx-auto mt-5 text-center">
				<img alt="User Avatar" class="rounded-circle" src="{{ asset('images/user_profile/') }}/{{$userDetails->profile_pic}}" style="width: 150px;">
			</div>
			<div class="card-body text-center">
				<div class="pro-user">
					<h4 class="pro-user-username text-dark mb-1 font-weight-bold">{{$userDetails->fname }} </h4>
					<h6 class="pro-user-desc text-muted">{{$userDetails->fname }} {{$userDetails->lname}}</h6>
					
				</div>
			</div>
			 
		</div>
		<div class="card p-3 m-3-rv"> 
			<div class="card-body"> 
				<h4 class="card-title">Personal Details</h4> 
				<div class="table-responsive"> 
					<table class="table mb-0"> 
						<tbody>
							<tr>
								<td class="py-2 px-2"> 
									<span class="font-weight-semibold w-50">Name </span> 
								</td>
								<td class="py-2 px-2">{{$userDetails->fname }} {{$userDetails->lname}}</td>
							</tr>
							<tr>
								<td class="py-2 px-2"> 
									<span class="font-weight-semibold w-50">Gender </span> 
								</td>
								<td class="py-2 px-2">{{$userDetails->gender}}</td>
							</tr>
							<tr>
								<td class="py-2 px-2"> 
									<span class="font-weight-semibold w-50">Date of Birth </span> 
								</td>
								<td class="py-2 px-2">{{$userDetails->dob}}</td>
							</tr>
							<tr>
								<td class="py-2 px-2"> 
									<span class="font-weight-semibold w-50">Email </span> 
								</td>
								<td class="py-2 px-2">{{ $user->email}}</td>
							</tr>
							<tr>
								<td class="py-2 px-2"> 
									<span class="font-weight-semibold w-50">Phone </span> 
								</td>
								<td class="py-2 px-2">{{$userDetails->mobile}}</td>
							</tr> 
						</tbody>
					</table> 
				</div> 
			</div> 
		</div> 
	</div>

	<div class="col-md-6">
		<div class="card p-3 m-3-rv"> 
			<div class="card-body">
				@include('includes.message') 
				<h4 class="card-title">Edit Details</h4> 
				<form class="forms-control" method="POST" action="{{ route('edit-profile')}}">
                    @csrf
                    <div class="row">
                        <input type="hidden" id="id" name="id" value="{{$user->id}}">
                        <input type="hidden" id="users_id" name="users_id" value="{{$user->users_id}}">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="fname">First Name<span class="text-red">*</span></label>
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{$userDetails->fname }}">
                                <div class="help-block with-errors" ></div>
                                @error('fname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="lname">Last Name<span class="text-red"></span></label>
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{$userDetails->lname}}">
                                <div class="help-block with-errors" ></div>
                                @error('lname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="gender">Gender<span class="text-red">*</span></label>
                                    <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender">
                                    	<option value="">---Select---</option>
                                    	<option value="male" @if($userDetails->gender=='male')selected @endif >Male</option>
                                    	<option value="female" @if($userDetails->gender=='female')selected @endif >Female</option>
                                    	<option value="other" @if($userDetails->gender=='other')selected @endif >Other</option>
                                    </select>
                                    <div class="help-block with-errors" ></div>
                                    @error('gender')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="date_of_birth">Date Of Birth<span class="text-red">*</span></label>
                                    <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{$userDetails->dob}}">
                                    <div class="help-block with-errors" ></div>
                                    @error('date_of_birth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                        </div>
                    
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="email">Email<span class="text-red">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email}}">
                                <div class="help-block with-errors" ></div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="mobile">Phone<span class="text-red">*</span></label>
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ $userDetails->mobile}}">
                                <div class="help-block with-errors" ></div>
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="password">Password<span class="text-red"></span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="">
                                <div class="help-block with-errors" ></div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <button type="submit" class="sub_button btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>   
            	</form>
			</div> 

		</div> 
	</div>
</div>
					
@endsection

