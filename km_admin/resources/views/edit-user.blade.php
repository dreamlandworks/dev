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
</style>

<div class="content-wrapper">
    <div class="container-fluid container_rv">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="heading">
                        <i class="icon fa fa-user"></i>
                        <h4>Edit User</h4>
                    </div>
                     <form class="forms-sample" method="POST" action="{{ url('user/update') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$userDetails->id}}">

                    <div class="row">

                        <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="formBox">

                            <div class="form-group">
                            <input class="form-control @error('fname') is-invalid @enderror" type="text"  name="fname" value="{{$userDetails->fname}}" placeholder="First Name">
                            <div class="help-block with-errors" ></div>

                                @error('fname')
                                    <span class="invalid-fname" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                            <input class="form-control @error('lname') is-invalid @enderror" type="text" name="lname" value="{{$userDetails->lname}}" placeholder="Last Name">
                             <div class="help-block with-errors" ></div>

                                @error('lname')
                                    <span class="invalid-lname" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                            <input class="form-control @error('mobile') is-invalid @enderror" type="text" name="mobile" value="{{$userDetails->mobile}}" placeholder="Mobile">
                                <div class="help-block with-errors" ></div>

                                @error('mobile')
                                    <span class="invalid-mobile" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" value="{{$user->email}}" placeholder="Email">
                             <div class="help-block with-errors" ></div>

                                @error('email')
                                    <span class="invalid-email" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!--<select class="form-control" name="referral_id" aria-label="Default select example">-->
                            <!--    @foreach($userData as $userDatas)-->
                            <!--    <option value="{{$userDatas->id}}">{{$userDatas->fname}}</option>-->
                            <!--    @endforeach-->
                            <!--</select>-->

                            <input name="DOB" type="date" value="{{$userDetails->dob}}" style=" height: 100%; width: 100%; border: none;  border-bottom: 1px solid#b7afaf;  outline: none; outline-color: initial; outline-style: none; outline-width: initial; color: #605858;">
                            <div class="form-group">
                            <input class="form-control @error('password') is-invalid @enderror" type="password"name="password" placeholder="password ">
                            <input class="form-control" type="password"name="password_confirmation" placeholder="Retype password ">
                            <div class="help-block with-errors" ></div>

                                @error('password')
                                    <span class="invalid-password" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-danger rv-submit">Submit</button>

                    </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="formBox">

                            <select class="form-control" name="gender" aria-label="Default select example">
                                <option>Choose Gender</option>
                                <option value="male" {{$userDetails->gender == 'male' ? 'selected':''}}>Male</option>
                                <option value="female"  {{$userDetails->gender == 'female' ? 'selected':''}}>Female</option>
                            </select>

                            <div class="holder border border-sm shadow shadow-lg mt-5  mr-2 bg-light col-lg-8 col-md-8 col-sm-12"  >
                            @if($userDetails->profile_pic)
                                <img id="imgPreview" src="{{asset('images/user_profile')}}/{{$userDetails->profile_pic}}" alt="pic"style="height:150px; width:200px;" class="img-fluid" />
                            @else
                                <img id="imgPreview" src="{{asset('images/user_profile/dummy.png')}}" alt="pic"style="height:150px; width:200px;" class="img-fluid" />
                            @endif
                      </div>
                            <label>Profile Pic</label>
                            <input type="file" name="profile_pic"
                            id="photo" class="form-control" />

                    </div>
                        </div>
                    </div>
                </form>
            </div>

            </div>
</div>
 <script src=
                "https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js">
                        </script>
                        <script>
                            $(document).ready(()=>{
                    $('#photo').change(function(){
                        const file = this.files[0];
                        console.log(file);
                        if (file){
                        let reader = new FileReader();
                        reader.onload = function(event){
                            console.log(event.target.result);
                            $('#imgPreview').css({'height':'150px','width':'200px'});
                            $('#imgPreview').attr('src', event.target.result);
                        }
                        reader.readAsDataURL(file);
                        }

                    });
                });

        </script>


@endsection
