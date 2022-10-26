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

/*Add tag css*/
.tags-input-wrapper{
    background: transparent;
    padding: 10px;
    border-radius: 4px;
    max-width: 400px;
    border: 1px solid #ccc
}
.tags-input-wrapper input{
    border: none;
    background: transparent;
    outline: none;
    width: 140px;
    margin-left: 8px;
}
.tags-input-wrapper .tag{
    display: inline-block;
    background-color: #fa0e7e;
    color: white;
    border-radius: 40px;
    padding: 0px 3px 0px 7px;
    margin-right: 5px;
    margin-bottom:5px;
    box-shadow: 0 5px 15px -2px rgba(250 , 14 , 126 , .7)
}
.tags-input-wrapper .tag a {
    margin: 0 7px 3px;
    display: inline-block;
    cursor: pointer;
}
/*End CSS*/
</style>

<div class="content-wrapper">

    <div class="container-fluid container_rv">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="heading">
                <i class="icon fa fa-user"></i>
                <h4>Create Market Plan</h4>
            </div>

            <form class="forms-sample" method="POST" action="{{ route('create-marketing-plan') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name_of_ad_campaign">Name of Ad Campaign<span class="text-red">*</span></label>
                                <input id="name_of_ad_campaign" type="text" class="form-control @error('name_of_ad_campaign') is-invalid @enderror" name="name_of_ad_campaign" value="">
                                <div class="help-block with-errors" ></div>
                                @error('name_of_ad_campaign')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div> 
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="period">Period<span class="text-red">*</span></label>
                            <select name="period" class="form-control @error('period') is-invalid @enderror">
                                <option value="">---Select---</option>
                                <option value="1 Week">1 Week</option>
                                <option value="2 Weeks">2 Weeks</option>
                                <option value="3 Weeks">3 Weeks</option>
                                <option value="1 Month">1 Month</option>
                                <option value="2 Months">2 Months</option>
                                <option value="3 Months">3 Months</option>
                                <option value="6 Months">6 Months</option>
                            </select>
                                <div class="help-block with-errors" ></div>
                                @error('period')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="campaign_type">Campaign Type<span class="text-red">*</span></label>
                            <select name="campaign_type" class="form-control @error('campaign_type') is-invalid @enderror">
                                <option value="">---Select---</option>
                                <option value="SMS">SMS</option>
                                <option value="EMAIL">EMAIL</option>
                                <option value="WHATSAPP">WHATSAPP</option>
                                <option value="FACEBOOK">FACEBOOK</option>
                                <option value="INSTAGRAM">INSTAGRAM</option>
                                <option value="QUORA">QUORA</option>
                                <option value="TWITTER">TWITTER</option>
                                <option value="YOUTUBE">YOUTUBE</option>
                                <option value="OTHERS">OTHERS</option>
                            </select>
                            <div class="help-block with-errors" ></div>
                            @error('campaign_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="target_age_group">Target Age Group<span class="text-red">*</span></label>
                            <select name="target_age_group" class="form-control @error('target_age_group') is-invalid @enderror">
                                <option value="">---Select---</option>
                                <option value="Below 13">Below 13</option>
                                <option value="13 - 20">13 - 20</option>
                                <option value="21 - 30">21 - 30</option>
                                <option value="31 - 40">31 - 40</option>
                                <option value="41 - 50">41 - 50</option>
                                <option value="Above 50">Above 50</option>
                            </select>
                            <div class="help-block with-errors" ></div>
                            @error('target_age_group')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="gender">Gender <span class="text-red">*</span></label>
                            <select id="gender" name="gender" class="form-control @error('gender') is-invalid @enderror">
                                <option value="">---Select---</option>
                                <option value="MALE">MALE</option>
                                <option value="FEMALE">FEMALE</option>
                                <option value="ALL">ALL</option>
                            </select>
                            <div class="help-block with-errors" ></div>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="date_of_start">Date of Start<span class="text-red">*</span></label>
                            <input id="date_of_start" type="date" class="form-control @error('date_of_start') is-invalid @enderror" id="date_of_start" name="date_of_start" value="">
                                <div class="help-block with-errors" ></div>
                                @error('date_of_start')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div> 
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="targeted_user_group">Targeted User Group <span class="text-red">*</span></label>
                            <select id="targeted_user_group" name="targeted_user_group" class="form-control @error('targeted_user_group') is-invalid @enderror">
                                <option value="">---Select---</option>
                                <option value="User">User</option>
                                <option value="Service Provider">Service Provider</option>
                            </select>
                            <div class="help-block with-errors" ></div>
                            @error('targeted_user_group')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="budget_estimated">Budget Estimated<span class="text-red">*</span></label>
                                <input id="budget_estimated" type="text" class="form-control @error('budget_estimated') is-invalid @enderror" name="budget_estimated" value="">
                                <div class="help-block with-errors" ></div>
                                @error('budget_estimated')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="attachment">Attachments <span class="text-red"></span></label>
                            <input id="attachment" type="file" class="form-control @error('attachment') is-invalid @enderror" name="attachment" onchange='doc_preview("attachment")'>
                            <div class="help-block with-errors" ></div>
                            @error('attachment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div id="attachmentField">
                                <embed id="attachmentPreview" src="{{asset('images/user_profile/dummy.png')}}" alt="pic" style="height:150px; width:250px; margin-top: 10px;" class="img-fluid" />
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <div class="custom-control custom-switch mk">
                                <input type="checkbox" class="custom-control-input" id="customSwitches" name="status" value="on" checked>
                                <label class="custom-control-label" for="customSwitches">Status</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label for="content">Content<span class="text-red">*</span></label>
                        <textarea class="form-control" id="content" name="content"></textarea>
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

    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">-->
    <!--<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>-->

<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
    <!--<script src="https://code.jquery.com/jquery-3.6.0.js"></script>-->
    <!--<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>-->
<script type="text/javascript">
    CKEDITOR.replace('content');
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <!--Preview image-->
    
    <script>
        function doc_preview(doc_field)
        {  
          var att_files = document.getElementById(doc_field);
          const file = att_files.files[0];

          let reader = new FileReader();
          reader.readAsDataURL(file);
          reader.onload = () => {
            let json = JSON.stringify({ dataURL: reader.result });
            // View the file
            let fileURL = JSON.parse(json).dataURL;
            $('#'+doc_field+'Field').empty();

            // View the original file
            let originalFileURL = URL.createObjectURL(file);
            $('#'+doc_field+'Field').append('<embed id="'+doc_field+'Preview" src='+fileURL+' style="height:150px; width:250px; margin-top: 10px;"/>')
            .onload(() => {
              URL.revokeObjectURL(originalFileURL);
            });
          };
        }
</script>

@endpush

@endsection

