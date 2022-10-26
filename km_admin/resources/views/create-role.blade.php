@extends('layouts.master')
@section('title', 'User')
@section('content')

<div class="content-wrapper">

    <div class="row">

        <div class="col-md-12">
            <div class="card p-3 m-3-rv ">
                <div class="card-header">
                    <h3>Add Role</h3>
                </div>
                <div class="card-body">
                    <form class="forms-sample" method="POST" action="{{ route('create-role') }}" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="role">Role<span class="text-red">*</span></label>
                                    <input id="role" type="text" class="form-control @error('role') is-invalid @enderror" name="role" value="" placeholder="Role Name" required>
                                    <div class="help-block with-errors"></div>

                                    @error('role')
                                 <span class="invalid-role" role="alert">
                                     <strong>{{ $message }}</strong>
                                      </span>
                                    @enderror

                                  </div>

                            </div>
                          <div class="col-sm-6">
	                                <label for="exampleInputEmail3">Assign Permission </label>
                                	@foreach($permissions as $key => $permission)
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="item_checkbox" name="permissions[]" value="{{$permission->name}}">
                                                <span class="custom-control-label">
                                                {{$permission->name}}
                                                </span>
                                            </label>

                                    @endforeach
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @include('includes.message')
        <div class="col-md-12">
            <div class="card p-3 m-3-rv ">
                <div class="card-header">
                  </div>
                <div class="card-body table-responsive">
                   <table id="km_dt" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Role</th>
                                <th>Permission</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($roles as $role)
                            <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td><span class="right badge badge-dark">{{$role->name}}</span></td>
                            <td>
                                @foreach ($role->getPermissionNames() as $permission)
                                <span class="right badge badge-success m-1">{{ $permission }}</span>
                                @endforeach
                            </td>
                            <td><a href="{{$role->id}}"><i class="fa fa-pencil-square-o text-green"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="delete/{{$role->id}}"><i class="fa fa-trash text-red"></i></a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

