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

/*Tag Input CSS*/
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
/*End Tag CSS*/

</style>

<div class="content-wrapper">

    <div class="container-fluid container_rv">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="heading">
                <i class="icon fa fa-user"></i>
                <h4>Edit Market Plan</h4>
            </div>

            <form class="forms-sample" method="POST" action="{{ url('marketing-plan/update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$marketing_plans->id}}">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name_of_ad_campaign">Name of Ad Campaign<span class="text-red">*</span></label>
                                <input id="name_of_ad_campaign" type="text" class="form-control @error('name_of_ad_campaign') is-invalid @enderror" name="name_of_ad_campaign" value="{{$marketing_plans->name_of_ad_campaign}}">
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
                                <option value="1 Week" @if($marketing_plans->period=="1 Week")selected @endif >1 Week</option>
                                <option value="2 Weeks" @if($marketing_plans->period=="2 Weeks")selected @endif >2 Weeks</option>
                                <option value="3 Weeks" @if($marketing_plans->period=="3 Weeks")selected @endif >3 Weeks</option>
                                <option value="1 Month" @if($marketing_plans->period=="1 Month")selected @endif >1 Month</option>
                                <option value="2 Months" @if($marketing_plans->period=="2 Months")selected @endif >2 Months</option>
                                <option value="3 Months" @if($marketing_plans->period=="3 Months")selected @endif >3 Months</option>
                                <option value="6 Months" @if($marketing_plans->period=="6 Months")selected @endif >6 Months</option>
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
                                <option value="SMS" @if($marketing_plans->campaign_type=="SMS")selected @endif >SMS</option>
                                <option value="EMAIL" @if($marketing_plans->campaign_type=="EMAIL")selected @endif >EMAIL</option>
                                <option value="WHATSAPP" @if($marketing_plans->campaign_type=="WHATSAPP")selected @endif >WHATSAPP</option>
                                <option value="FACEBOOK" @if($marketing_plans->campaign_type=="FACEBOOK")selected @endif >FACEBOOK</option>
                                <option value="INSTAGRAM" @if($marketing_plans->campaign_type=="INSTAGRAM")selected @endif >INSTAGRAM</option>
                                <option value="QUORA" @if($marketing_plans->campaign_type=="QUORA")selected @endif >QUORA</option>
                                <option value="TWITTER" @if($marketing_plans->campaign_type=="TWITTER")selected @endif >TWITTER</option>
                                <option value="YOUTUBE" @if($marketing_plans->campaign_type=="YOUTUBE")selected @endif >YOUTUBE</option>
                                <option value="OTHERS" @if($marketing_plans->campaign_type=="OTHERS")selected @endif >OTHERS</option>
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
                                <option value="Below 13" @if($marketing_plans->target_age_group=="Below 13")selected @endif >Below 13</option>
                                <option value="13 - 20" @if($marketing_plans->target_age_group=="13 - 20")selected @endif >13 - 20</option>
                                <option value="21 - 30" @if($marketing_plans->target_age_group=="21 - 30")selected @endif >21 - 30</option>
                                <option value="31 - 40" @if($marketing_plans->target_age_group=="31 - 40")selected @endif >31 - 40</option>
                                <option value="41 - 50" @if($marketing_plans->target_age_group=="41 - 50")selected @endif >41 - 50</option>
                                <option value="Above 50" @if($marketing_plans->target_age_group=="Above 50")selected @endif >Above 50</option>
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
                                <option value="MALE" @if($marketing_plans->gender=="MALE")selected @endif >MALE</option>
                                <option value="FEMALE" @if($marketing_plans->gender=="FEMALE")selected @endif >FEMALE</option>
                                <option value="ALL" @if($marketing_plans->gender=="ALL")selected @endif >ALL</option>
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
                            <input id="date_of_start" type="date" class="form-control @error('date_of_start') is-invalid @enderror" id="date_of_start" name="date_of_start" value="{{$marketing_plans->date_of_start}}">
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
                                <option value="User" @if($marketing_plans->targeted_user_group=="User")selected @endif >User</option>
                                <option value="Service Provider" @if($marketing_plans->targeted_user_group=="Service Provider")selected @endif >Service Provider</option>
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
                                <input id="budget_estimated" type="text" class="form-control @error('budget_estimated') is-invalid @enderror" name="budget_estimated" value="{{$marketing_plans->budget_estimated}}">
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
                            <button type="button" style="border: 0px;margin-top: 10px;" onclick="showDocument('attachment','/km_admin/marketing/document/{{$marketing_plans->attachment}}')">
                                <div id="attachmentField">
                                    <embed id="attachmentPreview" src="/km_admin/marketing/document/{{$marketing_plans->attachment}}" alt="pic"style="height:150px; width:250px; margin-top: 10px;" class="img-fluid" />
                                </div>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                        <div class="custom-control custom-switch mk">
                        <input type="checkbox" class="custom-control-input" id="customSwitches" name="status" value="on" {{$marketing_plans->status == 'on' ? 'checked':''}}><label class="custom-control-label" for="customSwitches">Status</label>
                        </div>

                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label for="content">Content<span class="text-red">*</span></label>
                        <textarea class="form-control" id="content" name="content">{{$marketing_plans->content}}</textarea>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" id="sp-submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
            </div>
    </div>

<!-- Model -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 1100px;">
        <div class="modal-content">
            <div class="modal-footer" style="padding:1px;">
                <button type="button" data-dismiss="modal" style="border: 0px;">
                    <i class="fa fa-times" aria-hidden='true'></i>
                </button>
            </div>
            <!-- Add image inside the body of modal -->
            <div class="modal-body" id="doc_show">
                <embed id="model_image" src="" style="width:1050px; height:550px;"/>
                <!-- <iframe id="model_image" src="" style="width:1050px; height:500px;" frameborder="0"> </iframe> -->
            </div>  
        </div>
    </div>
</div>

<!-- end model -->

@push('autocomp-khushbu')

<script src=
"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity=
"sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous">
    </script>
    <script src=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity=
"sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous">
    </script>
    

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
    <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>


<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
    
<script type="text/javascript">
    CKEDITOR.replace('content');
</script>


<script>
function showDocument(fieldName,doc_url)
{
    $('#doc_show').empty();
    var new_doc=$('#'+fieldName+'Field').html();
    $('#'+fieldName+'Field').html('');
    $('#doc_show').append(new_doc);
    $('#'+fieldName+'Preview').css({'height':'550px','width':'1050px'});
    $('#'+fieldName+'Field').html(new_doc);
    $('#exampleModal').modal('show');
}
</script>
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
            $('#'+doc_field+'Field').append('<embed id="'+doc_field+'Preview" src='+fileURL+' style="margin-top: 10px" width="250px"/>')
            .onload(() => {
              URL.revokeObjectURL(originalFileURL);
            });
          };
        }
</script>
    <script>
        $(document).ready(function(){

            var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
            removeItemButton: true,
            maxItemCount:5,
            searchResultLimit:5,
            renderChoiceLimit:5
            });
        });
    </script>

      <!--Add Tag-->
      <script>
        (function(){
        "use strict"
        // Plugin Constructor
        var TagsInput = function(opts){
            this.options = Object.assign(TagsInput.defaults , opts);
            this.init();
        }

        // Initialize the plugin
        TagsInput.prototype.init = function(opts){
            this.options = opts ? Object.assign(this.options, opts) : this.options;
            if(this.initialized)
                this.destroy();

            if(!(this.orignal_input = document.getElementById(this.options.selector)) ){
                console.error("tags-input couldn't find an element with the specified ID");
                return this;
            }

            this.arr = [];
            this.wrapper = document.createElement('div');
            this.input = document.createElement('input');
            init(this);
            initEvents(this);

            this.initialized =  true;
            return this;
        }

        // Add Tags
        TagsInput.prototype.addTag = function(string){

            if(this.anyErrors(string))
                return ;

            this.arr.push(string);
            var tagInput = this;

            var tag = document.createElement('span');
            tag.className = this.options.tagClass;
            tag.innerText = string;

            var closeIcon = document.createElement('a');
            closeIcon.innerHTML = '&times;';

            // delete the tag when icon is clicked
            closeIcon.addEventListener('click' , function(e){
                e.preventDefault();
                var tag = this.parentNode;

                for(var i =0 ;i < tagInput.wrapper.childNodes.length ; i++){
                    if(tagInput.wrapper.childNodes[i] == tag)
                        tagInput.deleteTag(tag , i);
                }
            })
            tag.appendChild(closeIcon);
            this.wrapper.insertBefore(tag , this.input);
            this.orignal_input.value = this.arr.join(',');
            return this;
        }

        // Delete Tags
        TagsInput.prototype.deleteTag = function(tag , i){
            tag.remove();
            this.arr.splice( i , 1);
            this.orignal_input.value =  this.arr.join(',');
            return this;
        }

        // Make sure input string have no error with the plugin
        TagsInput.prototype.anyErrors = function(string){
            if( this.options.max != null && this.arr.length >= this.options.max ){
                console.log('max tags limit reached');
                return true;
            }

            if(!this.options.duplicate && this.arr.indexOf(string) != -1 ){
                console.log('duplicate found " '+string+' " ')
                return true;
            }

            return false;
        }

        // Add tags programmatically
        TagsInput.prototype.addData = function(array){
            var plugin = this;

            array.forEach(function(string){
                plugin.addTag(string);
            })
            return this;
        }

        // Get the Input String
        TagsInput.prototype.getInputString = function(){
            return this.arr.join(',');
        }


        // destroy the plugin
        TagsInput.prototype.destroy = function(){
            this.orignal_input.removeAttribute('hidden');

            delete this.orignal_input;
            var self = this;

            Object.keys(this).forEach(function(key){
                if(self[key] instanceof HTMLElement)
                    self[key].remove();

                if(key != 'options')
                    delete self[key];
            });

            this.initialized = false;
        }

        // Private function to initialize the tag input plugin
        function init(tags){
            tags.wrapper.append(tags.input);
            tags.wrapper.classList.add(tags.options.wrapperClass);
            tags.orignal_input.setAttribute('hidden' , 'true');
            tags.orignal_input.parentNode.insertBefore(tags.wrapper , tags.orignal_input);
        }

        // initialize the Events
        function initEvents(tags){
            tags.wrapper.addEventListener('click' ,function(){
                tags.input.focus();
            });


        tags.input.addEventListener('keydown' , function(e){
            var str = tags.input.value.trim();

            if( !!(~[9 , 13 , 188].indexOf( e.keyCode ))  )
            {
                e.preventDefault();
                tags.input.value = "";
                if(str != "")
                    tags.addTag(str);
            }

        });
        }


        // Set All the Default Values
        TagsInput.defaults = {
            selector : '',
            wrapperClass : 'tags-input-wrapper',
            tagClass : 'tag',
            max : null,
            duplicate: false
        }

        window.TagsInput = TagsInput;

        })();

        var tagInput1 = new TagsInput({
                selector: 'tag-input1',
                duplicate : false,
                max : 1
            });
            // tagInput1.addData(['PHP' , 'JavaScript' , 'CSS'])
    </script>
    <!--End Tag-->


@endpush

@endsection

