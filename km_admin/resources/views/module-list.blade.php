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
.mk_nowrap th{
    white-space: nowrap;
}

</style>


<div class="content-wrapper">
    <div class="page-header">
        <div class="row align-items-end">
            <div class="col-lg-10">
                <div class="page-header-title">
                <div class="d-inline">
                    <h3 class=" rv-list-users">Marketing Plans</h3>
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
                    <a href="{{url('module-list/create')}}" class="btn btn-primary">Add +</a>
                   </div>
                <div class="card-body">
                   <table id="km_dt" class="table table-bordered table-hover dataTable no-footer">
                        <thead class="mk_nowrap">
                            <tr>
                                <th>SN</th>
                                <th>Module List</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($module_lists as $module_list)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$module_list->list_of_module}}</td>
                                <td>
                                    <a href="module-list/{{$module_list->id}}"><i class="fa fa-pencil-square-o text-green"></i></a>&nbsp;&nbsp;&nbsp;
                                    <a href="module-list/delete/{{$module_list->id}}" class="button delete-confirm"><i class="fa fa-trash text-red"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
    @push('mk')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        @if(app()->getLocale()=='ar')
        
           $('.delete-confirm').on('click', function (event) {
                        event.preventDefault();
                        const url = $(this).attr('href');
                        swal({
                            title: 'هل أنت متأكد?',
                            text: 'هذا السجل وتفاصيله سيتم حذفها نهائيا',
                            icon: 'warning',
                            buttons: ["Cancel", "Yes!"],
                        }).then(function(value) {
                            if (value) {
                                window.location.href = url;
                            }
                        }); 
            });
            @elseif(app()->getLocale()=='en')
        
                $('.delete-confirm').on('click', function (event) {
                event.preventDefault();
                const url = $(this).attr('href');
                    swal({
                        title: 'Are you sure?',
                        text: 'This record and it`s details will be permanantly deleted!',
                        icon: 'warning',
                        buttons: ["Cancel", "Yes!"],
                    }).then(function(value) {
                    if (value) {
                        window.location.href = url;
                    }
                    });
                });
                
            @endif 
    </script> 
    @endpush

@endsection
