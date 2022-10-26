@extends('layouts.master')
@section('title', 'User')
@section('content')

<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3 m-3-rv ">
                <div class="card-header">
                    <h3>Add Permission</h3>
                </div>
                <div class="card-body">
                    <form class="forms-sample" method="POST" action="{{ route('create-permission') }}" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="permission">Permission<span class="text-red">*</span></label>
                                    <input id="permission" type="text" class="form-control @error('permission') is-invalid @enderror" name="permission" value="" placeholder="permission" required>
                                    <div class="help-block with-errors"></div>

                                    @error('permission')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>
                            <!--<div class="col-sm-6">-->
                            <!--    <div class="form-group">-->
                            <!--        <label for="school">Assign Role<span class="text-red">*</span></label>-->
                            <!--        <select class="browser-default custom-select" name="">-->
                            <!--            @foreach ($roles as $role )-->
                            <!--            <option value="{{$role->name}}">{{$role->name}}</option>-->
                            <!--            @endforeach-->
                            <!--        </select>-->
                            <!--    </div>-->
                            <!--</div>-->

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
            <div  class="card p-3 m-3-rv ">
                <div class="card-header">

                   </div>
                <div class="card-body">

                   <table id="km_dt" class="table">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Permission</th>
                                <th>Assign Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           @foreach($permissions as $permission)
                                <tr>

                                    <td>{{$loop->iteration}}</td>
                                    <td><span class="right badge badge-dark">{{$permission->name}}</span></td>
                                    <td><span class="right badge badge-success">{{ str_replace(['[',']','"'],'',$permission->getRoleNames())}}</span></td>
                                    <td><a href="delete/{{$permission->id}}"><i class="fas fa-trash text-red"></i></a></td>
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

