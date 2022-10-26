@extends('layouts.master')
@section('title', 'Role')
@section('content')


<div class="content-wrapper">

    <div class="row">

        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h3>Role</h3>
                </div>
                <div class="card-body">
                    <form class="forms-sample" method="POST" action="{{ url('role/update') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$role->id}}">

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="role">Role<span class="text-red">*</span></label>
                                    <input id="role" type="text" class="form-control @error('role') is-invalid @enderror" name="role" value="{{$role->name}}" placeholder="Role Name" required>
                                    <div class="help-block with-errors"></div>

                                    @error('role')
                                        <span class="invalid-role" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>

                            </div>
                            <div class="col-sm-6">
	                                <label for="exampleInputEmail3">Assign Permission</label>
                                	@foreach($permissions as  $key => $permission)
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="item_checkbox" name="permissions[]" value="{{$permission->id}}" @foreach ($role->permissions as $give_role)
                                                @if ($give_role->id == $permission->id)
                                                    checked
                                                @endif
                                            @endforeach
                                                >
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
</div>

@endsection
