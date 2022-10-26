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
    padding-bottom: 40px;
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
button#btn_mk {
    background: none;
    border: none;
}
div#u_id {
    padding-bottom: 40px;
}
button#getspinfo {
    margin-top: 20px;
}
button#get_sp_info {
    margin-top: 20px;
    margin-left: -39px;
}
</style>
<div class="content-wrapper">
    <div class="container-fluid container_rv">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="heading">
                <i class="icon fa fa-user"></i>
                <h4>Create Single Move Booking</h4>
            </div>

            <div class="row" id="u_id">
                <div class="col-sm-2">
                    <input id="lbs_search" class="form-control" type="text" placeholder="Search User" aria-label="Search" name="mobile">
                    <div id="mobile_search"></div>
                </div>
                <div class="col-sm-2">
                    <button type="submit" id="get-user" class="btn btn-primary" onclick="getUser()">GET</button>
                </div>

                    <div class="col-sm-8" id="spuser">
                    <table class="table table-bordered table-hover dataTable no-footer" >
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Mobile</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                        <td><span id="fname"></span></td>
                        <td><span id="lname"></span></td>
                        <td><span id="mobile"></span></td>
                        </tr>
                    </tbody>
                    </table>
                    </div>

            </div>
            <button type='button' id="back" class="btn btn-primary" style ="display: none;">BACK</button>

            <form id="form" class="forms-sample" method="POST" action="{{ route('create-booking-sm') }}" enctype="multipart/form-data">
                @csrf


                <div class="row" id="addr_mk" style="display: none">
                    <div class="col-sm-12 back_btn">
                        <button type='button' class="btn btn-primary" onclick='s_back()'>BACK</button>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="latitude">Latitude<span class="text-red">*</span></label>
                            <input id="lat" type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude"  style="color:red" value="" readonly>
                            <div class="help-block with-errors" id="lattitude_error"></div>

                            @error('latitude')
                                <span class="invalid-latitude" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="longitude">Longitude<span class="text-red">*</span></label>
                                <input id="lon" type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude"  style="color:red" value="" readonly>
                                <div class="help-block with-errors" id="longitude_error"></div>

                                @error('longitude')
                                    <span class="invalid-longitude" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="state">State<span class="text-red">*</span></label>
                                <input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state"  style="color:red" value="" readonly>
                                <div class="help-block with-errors" id="state_error"></div>

                                @error('state')
                                    <span class="invalid-state" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class = "col-sm-3">
                        <div class="form-group">
                            <label for="address">Full Address<span class="text-red">*</span></label>
                            <input id="location" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="" readonly>
                            <div class="help-block with-errors" id="address_error"></div>
                            @error('address')
                                <span class="invalid-address" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="postal_code">Zip Code<span class="text-red">*</span></label>
                                <input id="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" name="postal_code"  style="color:red" value="" readonly>
                                <div class="help-block with-errors" id="postal_code_error"></div>

                                @error('postal_code')
                                    <span class="invalid-postal_code" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="country">Country<span class="text-red">*</span></label>
                                <input id="country" type="text" class="form-control @error('country') is-invalid @enderror" name="country"  style="color:red" value="" readonly>
                                <div class="help-block with-errors" id="country_error"></div>

                                @error('country')
                                    <span class="invalid-country" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="city">City<span class="text-red">*</span></label>
                                <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city"  style="color:red" value="" readonly>
                                <div class="help-block with-errors" id="city_error"></div>

                                @error('city')
                                    <span class="invalid-city" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="skill">Skills/Keyword<span class="text-red">*</span></label>
                        <input id="tags" type="text" class="typeahead form-control @error('skill') is-invalid @enderror" name="skill" value="">
                        <div class="help-block with-errors" id="keyword_error"></div>
                        </div>
                    </div>
                    <input id="skill_id" type="hidden" value="{{$skill_key}}">

                    <input id="searchInput" class="controls searchInput" type="text" placeholder="Enter full location" style="height:30px;width:300px;text-align:center;margin-top:10px;">

                        <!-- Google map -->
                        <div id="map" style="height:300px;width:1060px; "></div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <button type="button" id="getspinfo" class="btn btn-primary" onclick="getSPinfo()">GET</button>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <button type="button" id ="get_sp_info" class="btn btn-primary"  onclick="sInfo()">Send FCM</button>
                        </div>
                    </div>
                </div>

                <div class="row" id="sp_id" style="display: none">
                    <div class="col-sm-8" id="sp">
                        <table class="table table-bordered table-hover dataTable no-footer" >
                        <thead>
                            <tr>
                                <th>SP ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Mobile</th>
                            </tr>
                        </thead>
                        <tbody id="sp_u">

                        </tbody>
                        </table>
                    </div>
                </div>


                <div class="row" id ="f_id">

                    <input type="hidden" id="user_fname" name="fname" value=""/>
                    <input type="hidden" id ="user_lname" name="lname" value=""/>
                    <input type="hidden" id="user_approved_id" name="approve_id" value=""/>

                    <input type="hidden" id="sp_mk" name="sp_id" value=""/>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="work_description">Work Description<span class="text-red">*</span></label>
                                <input id="work_description" type="text" class="form-control @error('work_description') is-invalid @enderror" name="work_description" value="">
                                <div class="help-block with-errors" id="work_description_error"></div>
                                @error('work_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="scheduled_date">Scheduled Date<span class="text-red">*</span></label>
                                <input id="scheduled_date" type="date" class="form-control @error('scheduled_date') is-invalid @enderror" name="scheduled_date" value="">
                                <div class="help-block with-errors" id="scheduled_date_error" ></div>
                                @error('scheduled_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group time-slot">
                            <label for="time_slot">Time Slot<span class="text-red">*</span></label>
                            <select class="form-control" id="strat_time" name="strat_time" aria-label="Default select example">
                                @foreach($time_slots as $time_slot)
                                    <option value="{{$time_slot->id}}">{{$time_slot->from}}</option>
                                @endforeach
                            </select>
                            <div class="help-block with-errors" id="strat_time_error" ></div>
                            @error('strat_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="attachment">Attachment<span class="text-red">*</span></label>
                                <input id="attachment" type="file" class="form-control @error('attachment') is-invalid @enderror" name="attachment" value="">
                                <div class="help-block with-errors" id="attachment_error" ></div>
                                @error('attachment')
                                    <span class="invalid-attachment" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        </div>
                    </div>
                   
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="button" id="sp-next" class="btn btn-primary" onclick="s_move()">Next</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>

</div>
</div></div>

@push('autocomp-khushbu')

    <script>
        function getUser()
        {
            $.ajax({
            type: "GET",
            url: "user-detail",
            data: { "id": $("#get-user").val(),"mobile":$("#lbs_search").val(),},
            success:function(data){
                $('#fname').html(data.fname);
                $('#lname').html(data.lname);
                $('#mobile').html(data.mobile);
                $('#user_fname').val(data.fname);
                $('#user_lname').val(data.lname);
                $('#user_approved_id').val(data.id);
                if((data.id)==undefined)
                {
                    $('#mobile_search').html('<span style="color:red">Please enter registered mobile no.</span>');
                    $('#fname').html('');
                    $('#lname').html('');
                    $('#mobile').html('');
                    return;
                }
                else
                {
                    $('#mobile_search').html('');
                } 
                $('#spuser').removeAttr('style');
            }});

        }
    </script>

    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -33.8688, lng: 151.2195},
            zoom: 13
            });
            var input = document.getElementById('searchInput');
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });

            autocomplete.addListener('place_changed', function() {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                marker.setIcon(({
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                infowindow.open(map, marker);

                // Location details
                for (var i = 0; i < place.address_components.length; i++) {
                    if(place.address_components[i].types[0] == 'postal_code'){
                        document.getElementById('postal_code').value = place.address_components[i].long_name;
                    }

                    if(place.address_components[i].types[0] == 'country'){
                        document.getElementById('country').value = place.address_components[i].long_name;
                    }
                    if(place.address_components[i].types[0] == 'administrative_area_level_1'){
                        document.getElementById('state').value = place.address_components[i].long_name;
                    }
                    if(place.address_components[i].types[0] == 'administrative_area_level_2'){
                        document.getElementById('city').value = place.address_components[i].long_name;
                    }
                }
                document.getElementById('location').value = place.formatted_address;
                document.getElementById('lat').value = place.geometry.location.lat();
                document.getElementById('lon').value = place.geometry.location.lng();
            });
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyAVQbT0QIOsM1zO4h48Ahgkv2iyF5py9VE&callback=initMap" async defer></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    <script>
        $( function() {
            var availableTags = JSON.parse($("#skill_id").val());
            function split( val ) {
                return val.split( /,\s*/ );
            }
            function extractLast( term ) {
                return split( term ).pop();
            }

            $( "#tags" )
                // don't navigate away from the field on tab when selecting an item
                .on( "keydown", function( event ) {
                    if ( event.keyCode === $.ui.keyCode.TAB &&
                            $( this ).autocomplete( "instance" ).menu.active ) {
                        event.preventDefault();
                    }
                })
                .autocomplete({
                    minLength: 0,
                    source: function( request, response ) {
                        // delegate back to autocomplete, but extract the last term
                        response( $.ui.autocomplete.filter(
                            availableTags, extractLast( request.term ) ) );
                    },
                    focus: function() {
                        // prevent value inserted on focus
                        return false;
                    },
                    select: function( event, ui ) {
                        var terms = split( this.value );
                        // remove the current input
                        terms.pop();
                        // add the selected item
                        terms.push( ui.item.value );
                        // add placeholder to get the comma-and-space at the end
                        terms.push( "" );
                        this.value = terms.join( "" );
                        return false;
                    }
                });
        } );
    </script>
    <script>
        function getSPinfo()
        {
            $("#sp_u").empty();

            $.ajax({
            type: "GET",
            url: "getSPInfo",
            data: { "keyword":$("#tags").val(),"lattitude":$("#lat").val(),"longitude":$("#lon").val(),},
            success:function(data){
                // console.log(data);
                $.each( data, function( key, value ) {
                    console.log(value);
                    $("#sp_u").append('<tr><td>'+value.users_id+'</td><td>'+value.fname+'</td><td>'+value.lname+'</td><td>'+value.mobile+'</td></tr>');

                    // <td><button id="btn_mk" value="'+value.users_id+'" onclick = btn_mk('+value.users_id+')><i class="fa fa-eye text-primary text-center" style="font-size:18px;"></i></button></td>
                });
            }});
        }
    </script>
 <script>



     function sInfo()
     {
        document.getElementById('global-loader').style.display='block';
         
        var fd = new FormData();
        var att_files = document.getElementById("attachment");
        var file = att_files.files[0];
        if((att_files.value)=='')
        {
            file='';
        }
        fd.append("attachment",file);
        fd.append("u_id",$("#user_approved_id").val());
        fd.append("u_fname",$("#user_fname").val());
        fd.append("l_name",$("#user_lname").val());
        fd.append("work_description",$("#work_description").val());
        fd.append("strat_time",$("#strat_time").val());
        fd.append("scheduled_date",$("#scheduled_date").val());
        fd.append("keyword",$("#tags").val());
        fd.append("lattitude",$("#lat").val());
        fd.append("longitude",$("#lon").val());
        fd.append("state",$('#state').val());
        fd.append("postal_code",$('#postal_code').val());
        fd.append("country",$('#country').val());
        fd.append("city",$('#city').val());
        fd.append("address",$("#location").val());
        fd.append("_token","{{csrf_token()}}");
        
         $.ajax({
                type: "POST",
                url: "create",
                contentType: false,
                processData: false,
                data: fd,
                success:function(data){

                    console.log(data);
                    timerfn(data,1,"sp_checking");
                     // $("#sp_mk").val(sp_id)
                },
                 error:function(request, status,error)
                 {
                    document.getElementById('global-loader').style.display='none';
                    $(window).scrollTop(0,0);
                    $.each(request,function(index,value){
                        if(index=="responseJSON")
                        {
                            var arr = value.errors;
                            console.log(arr);
                            $.each(arr, function(index_new, value_new)
                            {
                                //console.log(index_new);
                                document.getElementById(index_new+'_error').innerHTML=value_new[0];
                                document.getElementById(index_new+'_error').style.color="red";
                            });
                        }
                    });
                 }
             
         });

     }
</script>

<script>
var myInterval='';
var myTimer='';
function timerfn(booking_id,counter,spcheck)
{    
    if(counter==1)
    {
        updationfailed(booking_id);
        //document.getElementById('global-loader').style.display='block';
        myInterval = setInterval(bookingTxn,3000,booking_id,spcheck); 
    }          
    if(spcheck=='success')
    {
        stopInterval();
        stopTimer();
    }
    if(spcheck=='failed')
    {   
        bookingTxn(booking_id,'failed');
        stopInterval();
    }
}
function stopInterval() {
   clearInterval(myInterval);
}
function stopTimer() {
   clearTimeout(myTimer);
}
function updationfailed(old_id)
{
    setTimeout(timerfn,9000,old_id,2,'failed');
}

function bookingTxn(current_booking_id,checking)
{
    $.ajax({
        type:"POST",
        url:"transaction",
        data:{'u_id':$("#user_approved_id").val(),"booking_id":current_booking_id,"sp_update":checking,"_token": "{{csrf_token()}}"},
        success:function(data)
        {
            if(data==current_booking_id)
            {     
                //timerfn(data,2,'sp_checking');
                console.log(data);  
            }
            if(data=="success") 
            {
                document.getElementById('global-loader').style.display='none';
                console.log(data);
                timerfn(current_booking_id,2,'success');
                window.location=window.location.origin+"/km_admin/booking-sm/qd/wsx";
                
            }
            if(data=="failed") 
            {
                document.getElementById('global-loader').style.display='none';
                console.log(data);
                window.location=window.location.origin+"/km_admin/booking-sm/qd/qaz";
                //timerfn(current_booking_id,2,'failed');
                
            }

        }
    });

}
</script>

    <script>
        function s_move()
        {
            if(($('#user_approved_id').val())=='')
            {
                $('#mobile_search').html('<span style="color:red">Please enter registered mobile no.</span>');
                return;
            }
            else
            {
                $('#mobile_search').html('');
            } 
            $("#addr_mk").show();
            $("#sp_id").show();
            $("#u_id").hide();
            $("#f_id").hide();
            $("#sp-submit").show();

        }
    </script>
    
    <script>
        function s_back()
        {
            $("#addr_mk").hide();
            $("#sp_id").hide();
            $("#u_id").show();
            $("#f_id").show();
            $("#sp-submit").hide();
        }
    </script>

    {{-- <script>
        function btn_mk(sp_id)
        {
            $('#u_id').removeAttr('style');
            $('#f_id').removeAttr('style');
            $("#addr_mk").hide();
            $("#sp_id").hide();

            $.ajax({
            type: "POST",
            url: "create",
            data: { "sp_id":$("#btn_mk").val(),"_token": "{{csrf_token()}}"},
            success:function(data){
                $("#sp_mk").val(sp_id)
            }});
        }
    </script> --}}

@endpush

@endsection

