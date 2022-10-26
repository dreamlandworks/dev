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
input[type="radio"], input[type="checkbox"] {
    box-sizing: border-box;
    padding: 0;
    height: 18px;
}
</style>

<div class="content-wrapper">

    <div class="container-fluid container_rv">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="heading">
                <i class="icon fa fa-user"></i>
                <h4>Create User Plans</h4>
            </div>

            <form class="forms-sample" method="POST" action="{{ route('create-user-plan') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name">Name<span class="text-red">*</span></label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="">
                                <div class="help-block with-errors" ></div>
                                @error('name')
                                    <span class="invalid-name" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>                            
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="amount">Amount<span class="text-red">*</span></label>
                                <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="">
                                <div class="help-block with-errors" ></div>
                                @error('amount')
                                    <span class="invalid-amount" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>                            
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="period">Period<span class="text-red">*</span></label>
                                <input id="period" type="text" class="form-control @error('period') is-invalid @enderror" name="period" value="">
                                <div class="help-block with-errors" ></div>
                                @error('period')
                                    <span class="invalid-period" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>                            
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="premium_tag">Premium Tag<span class="text-red">*</span></label>
                                <select class="form-control" id="exampleSelect" name="premium_tag">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>  
                                <div class="help-block with-errors" ></div>
                                @error('premium_tag')
                                    <span class="invalid-premium_tag" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>                            
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="posts_per_month">Posts Per Month<span class="text-red">*</span></label>
                                <input id="posts_per_month" type="text" class="form-control @error('posts_per_month') is-invalid @enderror" name="posts_per_month" value="">
                                <div class="help-block with-errors" ></div>
                                @error('posts_per_month')
                                    <span class="invalid-posts_per_month" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>                            
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="proposals_per_post">Proposals Per Post<span class="text-red">*</span></label>
                                <input id="proposals_per_post" type="text" class="form-control @error('proposals_per_post') is-invalid @enderror" name="proposals_per_post" value="">
                                <div class="help-block with-errors" ></div>
                                @error('proposals_per_post')
                                    <span class="invalid-proposals_per_post" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>                            
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="customer_support">Customer Support<span class="text-red">*</span></label>
                                <select class="form-control" id="exampleSelect" name="customer_support">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>  
                                <div class="help-block with-errors" ></div>
                                @error('customer_support')
                                    <span class="invalid-customer_support" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>                            
                    </div>
                    
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label for="desc">Description<span class="text-red">*</span></label>
                            <textarea class="form-control" rows="3" name="desc"></textarea>
                                <div class="help-block with-errors" ></div>
                                @error('desc')
                                    <span class="invalid-desc" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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

    @push('autocomp-khushbu')
    
    
    @endpush

@endsection

