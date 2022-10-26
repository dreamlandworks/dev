@extends('layouts.master')
@section('title', 'User')
@section('content')

<style>
    .heading {
    display: flex;
    justify-content: left;
    align-items: center;
    position: relative;
    top: -12px;
}
.heading h4 {
    margin: 12px 0 0 12px;
}
.title {
    text-align: center;
}
.title h4 {
    margin: 0;
    padding: 0;
    color: #aaa;
    text-transform: capitalize;
}
.container_rv {
    background-color: #fff;
    /*width: 50% !important;*/
    /*height: 100% !important;*/
    margin: 50px auto;
    border: 2px solid #fff;
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
    border-radius: 5px;
}
.container_rv .left {
    float: left;
    /*width: 50%;*/
    /*height: 100% !important;*/
    box-sizing: border-box;
}
.container_rv .right {
    float: right;
    margin-top: 30px;
    /*width: 50%;*/
    /*height: 100% !important;*/
    margin: 10px auto;
     background-color: red; 
}
.container_rv .right button {
    text-align: center;
}
.formBox {
    /*width: 80%;*/
    margin: 30px 15px;
    box-sizing: border-box;
    border-radius: 0px 0px 0px 0px;
}
.formBox input {
    width: 100%;
    margin-bottom: 20px;
    border-radius: 0px 0px 0px 0px;
}
.formBox input[type="text"] {
    border: none;
    border-bottom: 1px solid #aaa;
    outline: none;
    height: 30px;
    border-radius: 0px 0px 0px 0px;
}
.formBox input[type="text"]:focus {
    border-bottom: 1px solid #505fc7;
    box-shadow: none;
    border-radius: 0px 0px 0px 0px;
}

.formBox label {
    margin-top: 20px;
    margin-bottom: 20px;
}
.right .formBox {
    width: 80%;
    margin: 30px 15px;
    box-sizing: border-box;
}
.right .formBox .picture {
    background-color: #505fc7;
    width: 300px;
    height: 150px;
    border: 1px solid #eee;
    box-shadow: 0 15px 30px #505fc7;
    border-radius: 5px;
    margin-bottom: 20px;
}
.icon {
    width: 50px;
    height: 50px;
    background-color:#505fc7;
    color: #fff;
    font-size: 25px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 4px;
}
.form-select:focus {
    border: 1px solid #dc3545 !important;
    box-shadow: none !important;
    color: #dc3545;
}
.form-select option:hover {
    background-color: #505fc7;
}
button.btn.btn-danger.rv-submit {
    background-color: #505fc7!important;
    border-color: #505fc7 !important;
}
.btn-custom {
    width: 126px;
    height: 36px;
    background-color: #505fc7;
    color: #fff;
    font-size: 1rem;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 25px;
    padding: 10px 10px;
    border: none;
}
button.btn.btn-danger.rv-submit:hover {
    border-color: #576482!important;
    background-color: #576482!important;
}
button#sp-submit {
    margin-top: 28px;
}
.custom-control.custom-switch.mk {
    margin-left: 50px;
    margin-top: 37px;
}
</style>

<div class="content-wrapper">
    <div class="container-fluid container_rv">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="heading">
                <i class="icon fa fa-user"></i>
                <h4>Edit Keywords</h4>
            </div>

            <form class="forms-sample" method="POST" action="{{ url('keyword/update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$keywords->id}}">

                <div class="row">
                    
                <div class="col-sm-4">
                    <div class="form-group">
                        <label for="keyword">Keyword<span class="text-red">*</span></label>
                            <input id="keyword" type="text" class="form-control @error('keyword') is-invalid @enderror" name="keyword" value="{{$keywords->keyword}}">
                            <div class="help-block with-errors" ></div>
                            @error('keyword')
                                <span class="invalid-keyword" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>                            
                </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="profession">Profession<span class="text-red">*</span></label>
                            <select class="form-control" id="exampleSelect" name="profession">
                                @foreach($professions as $profession)
                                <option value="{{$profession->id}}" {{$keywords->profession_id == $profession->id ? 'selected' : ''}}>{{$profession->name}}</option>
                                @endforeach
                            </select> 
                                <div class="help-block with-errors" ></div>
                                @error('profession')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>                            
                    </div>
                  
                    <div class="col-sm-4">
                        <div class="form-group">
                        <div class="custom-control custom-switch mk">
                        <input type="checkbox" class="custom-control-input" id="customSwitches" name="status" value="on" {{$keywords->status == 'Active' ? 'checked':'Inactive'}}>
                        <label class="custom-control-label" for="customSwitches">Status</label>
                        </div>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" id="sp-submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div> 
                </div>
            </form>

        </div>

                
            </div>
</div>

@endsection

