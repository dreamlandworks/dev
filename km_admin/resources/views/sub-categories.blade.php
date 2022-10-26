@extends('layouts.master')
@section('title', 'User')
@section('content')


<style>
    .switch {
      position: relative;
      display: inline-block;
      width: 90px;
      height: 34px;
    }

    .switch input {display:none;}

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ca2222;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2ab934;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(55px);
      -ms-transform: translateX(55px);
      transform: translateX(55px);
    }
    .on
    {
      display: none;
    }

    .on, .off
    {
      color: white;
      position: absolute;
      transform: translate(-50%,-50%);
      top: 50%;
      left: 50%;
      font-size: 10px;
      font-family: Verdana, sans-serif;
    }

    input:checked+ .slider .on
    {display: block;}

    input:checked + .slider .off
    {display: none;}
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;}
      table.dataTable thead th, table.dataTable thead td {
    padding: 10px 18px;
    border-bottom: 1px solid #fff;
}
table.dataTable.no-footer {
    border-bottom: 1px solid #dee2e6;
}
table.dataTable.no-footer {
    border-bottom: 1px solid #e6e9ed !important;
}
span.teax-vr-dashbord {
    font-size: 17px;
    position: relative;
    top: 11px;
    left: 29px;
}
h3.rv-list-users {
    position: relative;
    right: 18px;
}
.btn.btn-primary.mk {
    margin-left: 704px;
}
</style>


<div class="content-wrapper">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-10">
                <div class="page-header-title">
                <div class="d-inline">
                        <h3 class=" rv-list-users">Sub Category List</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <nav class="breadcrumb-container" aria-label="breadcrumb">
                    <ol class="breadcrumb">

                      </ol>
                </nav>
            </div>
        </div>
    </div>
    <div>
        @include('includes.message')
        <div class="col-md-12">
            <div class="card p-3 m-3-rv">
                <div class="card-header">
                    <a href="{{url('sub-category/create')}}" class="btn btn-primary">Add +</a>
                    @if ($mk == 'assign')
                    @else
                        <div class="btn btn-primary mk">
                            <a href="{{url('sub-cat')}}" style="color:white;">Assign Category</a>
                        </div>
                    @endif
                   </div>

                <div class="card-body">
                   <table id="km_dt" class="table table-bordered table-hover dataTable no-footer" >
                        <thead>
                            <tr>
                                <th>Sub Name</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @foreach($sub_categories as $sub_category)
                        <tr>
                            <td>{{$sub_category->sub_name}}</td>
                            <td>{{$sub_category->categoryDetails ? $sub_category->categoryDetails->category : '0'}}</td>
                            <td>{{$sub_category->status}}</td>
                            <td><img src="{{asset('images/subcategories')}}/{{$sub_category->image}}" height="60px" width="60px"/></td>
                            <td><a href="sub-category/{{$sub_category->id}}"><i class="fa fa-pencil-square-o text-green"></i></a>&nbsp;&nbsp;&nbsp;
                                        <a href="sub-category/delete/{{$sub_category->id}}"><i class="fa fa-trash text-red"></i></a></td>
                        </tr>
                        @endforeach
                        <tbody>

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
