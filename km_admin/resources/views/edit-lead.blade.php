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

/*Add hobbies css*/
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
/*End hobbies CSS*/
</style>

<div class="content-wrapper">

    <div class="container-fluid container_rv">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="heading">
                <i class="icon fa fa-user"></i>
                <h4>Edit Lead</h4>
            </div>

            <form class="forms-sample" method="POST" action="{{ url('lead/update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{$leads->id}}">

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="fname">First Name<span class="text-red">*</span></label>
                                <input id="fname" type="text" class="form-control @error('fname') is-invalid @enderror" name="fname" value="{{$leads->fname}}">
                                <div class="help-block with-errors" ></div>
                                @error('fname')
                                    <span class="invalid-fname" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="lname">Last Name<span class="text-red">*</span></label>
                                <input id="lname" type="text" class="form-control @error('lname') is-invalid @enderror" name="lname" value="{{$leads->lname}}">
                                <div class="help-block with-errors" ></div>
                                @error('lname')
                                    <span class="invalid-lname" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="email">Email<span class="text-red">*</span></label>
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$leads->email}}">
                                <div class="help-block with-errors" ></div>
                                @error('email')
                                    <span class="invalid-email" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="mobile">Mobile<span class="text-red">*</span></label>
                                <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{$leads->mobile}}">
                                <div class="help-block with-errors" ></div>
                                @error('mobile')
                                    <span class="invalid-mobile" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="city">City<span class="text-red">*</span></label>
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{$leads->city}}">
                                <div class="help-block with-errors" ></div>
                                @error('city')
                                    <span class="invalid-city" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="gender">Gender<span class="text-red">*</span></label>
                            <select class="form-control" name="gender">
                                <option>--Select--</option>
                                <option value="male" @if($leads->gender=='male')selected @endif >Male</option>
                                <option value="female" @if($leads->gender=='female')selected @endif >Female</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="age_group">Age Group<span class="text-red">*</span></label>
                            <select name="age_group" class="form-control @error('age_group') is-invalid @enderror">
                                <option value="">---Select---</option>
                                <option value="Below 13"@if($leads->age_group=='Below 13')selected @endif >Below 13</option>
                                <option value="13 - 20"@if($leads->age_group=='13 - 20')selected @endif >13 - 20</option>
                                <option value="21 - 30"@if($leads->age_group=='21 - 30')selected @endif >21 - 30</option>
                                <option value="31 - 40"@if($leads->age_group=='31 - 40')selected @endif >31 - 40</option>
                                <option value="41 - 50"@if($leads->age_group=='41 - 50')selected @endif >41 - 50</option>
                                <option value="Above 50"@if($leads->age_group=='Above 50')selected @endif >Above 50</option>
                            </select>
                            <div class="help-block with-errors" ></div>
                            @error('target_age_group')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="occupation">Occupation<span class="text-red">*</span></label>
                                <input id="occupation" type="text" class="form-control @error('occupation') is-invalid @enderror" name="occupation" value="{{$leads->occupation}}">
                                <div class="help-block with-errors" ></div>
                                @error('occupation')
                                    <span class="invalid-occupation" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <?php $leads_qual = json_decode($leads->qualification); ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="qualification">Qualification<span class="text-red">*</span></label>
                            <select id="choices-multiple-remove-button" placeholder="Enter Your Qualification"   name="qualification[]" multiple>
                                @foreach ($qualifications as $qualification)
                                <option value="{{$qualification->id}}" {{in_array($qualification->id,$leads_qual) ? 'selected' : ''}}>{{$qualification->qualification}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                   @php
                        $a=$leads->hobbies;
                        $b=(explode(',',$a));
                        $hobbies='';
                        foreach($b as $new_value)
                        {
                            $hobbies.="'".$new_value."'".' , ';
                        }
                        $hobbies=trim($hobbies,',');
                    @endphp
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="hobbies">Hobbies<span class="text-red">*</span></label>
                            <input type="text" class="form-control @error('hobbies') is-invalid @enderror" id="hobbies" name="hobbies" placeholder="Add Hobbies....." value="">
                            <div class="help-block with-errors" ></div>
                            @error('hobbies')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

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

    @push('autocomp-khushbu')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
        <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>

        <script>
            $(document).ready(function(){

                var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
                removeItemButton: true,
                maxItemCount:null,
                searchResultLimit:null,
                renderChoiceLimit:null
                });
            });
        </script>

        <!--Add Hobbies-->
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
                    selector: 'hobbies',
                    duplicate : false,
                    max : null
                });
                
                tagInput1.addData([<?php echo $hobbies; ?>])
        </script>
        <!--End Hobbies-->


    @endpush

@endsection

