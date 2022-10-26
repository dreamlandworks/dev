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
    margin-left: -14px;
}
.col-lg-12.col-md-12.col-sm-12.mk_container {
    margin-bottom: 50px;
}
</style>

<div class="content-wrapper">

              <div class="container-fluid container_rv">
                <div class="col-lg-12 col-md-12 col-sm-12 mk_container">
                    <div class="heading">
                        <i class="icon fa fa-user"></i>
                        <h4>Post a Job</h4>
                    </div>
                   <div class="row">
                        <div class="col-sm-2">
                            <input id="lbs_search" class="form-control" type="text" placeholder="Search" aria-label="Search" name="mobile">
                            <div id="mobile_search"></div>
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" id="get-user" class="btn btn-primary" onclick="getUser()">GET</button>
                        </div>

                        <div class="col-sm-8">
                        <table class="table table-bordered table-hover dataTable no-footer">
                        <thead>
                            <tr>
                               <th>First Name</th>
                               <th>Last Name</th>
                               <th>Mobile</th>
                               <!-- <th>Action</th>  -->
                            </tr>
                        </thead>
                        <tbody>
                            
                            <tr>
                            <td><span id="fname"></span></td>
                            <td><span id="lname"></span></td>
                            <td><span id="mobile"></span></td>
                            <!-- <td><span id="approved"></span></td> -->
                            </tr>
                            <tr id="no_recored"></tr>
                        </tbody>
                        </table>
                        </div>
                    </div>
                    
                    <hr/>
                    <div class="sp-div" id="sp-div" style="display:none">
                        <form class="forms-sample" method="POST" action="{{ route('create-cb-job') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" id="user_fname" name="fname" value=""/>
                                <input type="hidden" id ="user_lname" name="lname" value=""/>
                                <input type="hidden" id="user_approved_id" name="approve_id" value=""/>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="scheduled_date">Date of service<span class="text-red">*</span></label>
                                            <input id="scheduled_date" type="date" class="form-control @error('scheduled_date') is-invalid @enderror" name="scheduled_date" value="">
                                            <div class="help-block with-errors" ></div>
                                            @error('scheduled_date')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="skill">Skills/Keywords<span class="text-red">*</span></label>
                                        <div class="input-group-append">
                                            <input id="tags" type="text" class="typeahead form-control @error('skill') is-invalid @enderror" name="skill" value="">
                                            <!-- <input id="tags" name="skill" size="50"> -->
                                            <input id="skill_id" type="hidden" value="{{$skill_keys}}">
                                            <div class="help-block with-errors" ></div>
                                            @error('skill')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="lang">Language<span class="text-red">*</span></label>
                                        <div class="input-group-append">
                                            <input id="tag_lang" type="text" class="form-control @error('lang') is-invalid @enderror" name="lang" value="">
                                            <input id="lang_id"  type="hidden" value="{{$languages}}">
                                            <div class="help-block with-errors" ></div>
                                            @error('lang')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="title">Title<span class="text-red">*</span></label>
                                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="">
                                            <div class="help-block with-errors" ></div>
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="estimate_time">Estimate Time<span class="text-red">*</span></label>
                                            <input id="estimate_time" type="text" class="form-control @error('estimate_time') is-invalid @enderror" name="estimate_time" value="">
                                            <div class="help-block with-errors" ></div>
                                            @error('estimate_time')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="estimate_type">Estimate Type<span class="text-red">*</span></label>
                                            <select class="form-control" id="estimate_type" name="estimate_type" aria-label="Default select example">
                                                <option value=''>-- Select --</option>
                                                @foreach($estimate_type as $estimatetype)
                                                    <option value="{{$estimatetype->id}}">{{$estimatetype->name}}</option>
                                                @endforeach
                                            </select>
                                        <div class="help-block with-errors" ></div>
                                            @error('hours')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                </div>
  
                                <div class="col-sm-3">
                                    <div class="form-group time-slot">
                                            <label for="strat_time">Start Time<span class="text-red">*</span></label>
                                            <select class="form-control" id="strat_time" name="strat_time" aria-label="Default select example">
                                                @foreach($time_slots as $time_slot)
                                                    <option value="{{$time_slot->id}}">{{$time_slot->from}}</option>
                                                @endforeach
                                            </select>
                                            <div class="help-block with-errors" ></div>
                                            @error('strat_time')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="bid_period">Bid Period<span class="text-red">*</span></label>
                                        <select id="bid_period" class="form-control" name="bid_period" aria-label="Default select example">
                                        <option>Choose Your Bid Peroid</option>
                                        <option value=1>1 Days</option>
                                        <option value=3>3 Days</option>
                                        <option value=7>7 Days</option>
                                        </select>
                                    </div>
                                </div>                         
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="bid">Bid<span class="text-red">*</span></label>
                                        <select id="bid" class="form-control" name="bid" aria-label="Default select example">
                                        <option>Choose Your Bid</option>
                                        <option value="per hour">Per Hour</option>
                                        <option value="per day">Per Day</option>
                                        <option value="per job">Per Job</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="bid_range">Select Bid range<span class="text-red">*</span></label>
                                        <select id="bid_range" class="form-control" name="bid_range" aria-label="Default select example">
                                        <option>Choose Your Bid Range</option>
                                        @foreach($bid_range as $bidrange)
                                            <option value={{$bidrange->bid_range_id}}>{{$bidrange->range_slots}}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="attachment">Attachment<span class="text-red">*</span></label>
                                            <input id="attachment" type="file" class="form-control @error('attachment') is-invalid @enderror" name="attachment" value="">
                                            <div class="help-block with-errors" ></div>
                                            @error('attachment')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="description">Description<span class="text-red">*</span></label>
                                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"></textarea>
                                            <div class="help-block with-errors" ></div>
                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                    </div>
                                </div>
                    
                            
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <button type="button" id ="get_sp_info" class="btn btn-primary"  onclick="sInfo()">Submit</button>
                                </div>
                            </div>    
                    
                                <!-- <div class="col-md-12">
                                    <div class="form-group">
                                        <button type="submit" id="sp-submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div> --> 
                            </div>
                            <div class="row" id="sp_id" style="display: block">
                        
                    </div> 
                        </form>
                    </div>
                    

                </div>

                        
                    </div>
            </div>
        

<?php 
$options='';
foreach($time_slots as $time_slot){
                
    $options .= '<option value="'.$time_slot->from.'">'.$time_slot->from.'</option>';
                
} 
// dd($options);

?>

@push('autocomp-khushbu')


<!--MultiSelect-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
         <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<!--Multiselect-->

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="/resources/demos/style.css">
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

    <script>
    function day(){
        if($("#km-select").val() == "everyDay")
        {
            // $('#allDay').removeAttr('style');
            $('#allDay').show();
            $('#weakDay').hide();

            var data =  Array.from(document.getElementById("e2").options).filter(option => option.selected).map(option => option.value);
            var options='{!! $options !!}';
            console.log(data);
            console.log(options);

            $('.time-slot').html('');
            $('.end-time-slot').html('');
           
            $.each(data, function(index,loopvalue){
                    $('.time-slot').append('<input type="hidden" value="'+loopvalue+'" id="st_time" name="st_time[]"/>')
                    $('.end-time-slot').append('<input type="hidden" value="'+loopvalue+'" id="en_time" name="en_time[]"/>')
                });
                $('.time-slot').append('<label for="strat_time">From<span class="text-red">*</span></label><select  class="form-control" name="start_time[]" aria-label="Default select example">'+ options+'</select>');
                $('.end-time-slot').append('<label for="end_time">To<span class="text-red">*</span></label><select  class="form-control" name="end_time[]" aria-label="Default select example">'+ options+'</select>');

        }if($("#km-select").val() == "weakDay")
        {
            $('#weakDay').removeAttr('style');
            $('#weakDay').show();
            $('#allDay').hide();
        }
    }

    </script>
 <!--Multi Select -->
 <script type="text/javascript">

        // var daysArray = [];
        function day_slot()
        {
          var data =  Array.from(document.getElementById("e1").options).filter(option => option.selected).map(option => option.value);


            var len = [];
            var options='{!! $options !!}';
            len = (data.length);
            console.log(options);
            $('.time-slot').html('');
            $('.end-time-slot').html('');

                $.each(data, function(index,loopvalue){
                    $('.time-slot').append('<input type="hidden" value="'+loopvalue+'" id="st_time" name="st_time[]"/><label for="strat_time">From<span class="text-red">*</span></label><select  class="form-control" name="start_time[]" aria-label="Default select example">'+ options+'</select>');
                    $('.end-time-slot').append('<input type="hidden" value="'+loopvalue+'" id="en_time" name="en_time[]"/><label for="end_time">To<span class="text-red">*</span></label><select  class="form-control" name="end_time[]" aria-label="Default select example">'+ options+'</select>');

                });
        };
    </script>
 
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
					this.value = terms.join( ", " );
					return false;
				}
			});
	} );
     
	</script>

    <script>
    $( function() {

        var availableTags1 = JSON.parse($("#lang_id").val());
		function split( val ) {
			return val.split( /,\s*/ );
		}
		function extractLast( term ) {
			return split( term ).pop();
		}

		$( "#tag_lang" )
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
						availableTags1, extractLast( request.term ) ) );
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
					this.value = terms.join( ", " );
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
                $('#user_lname').val(data.fname);
                $('#user_approved_id').val(data.id);
                // $('#no_record').val(data.no_record);
                if((data.id)==undefined)
                {
                    $('#mobile_search').html('<span style="color:red">Please enter registered mobile no.</span>');
                    $('#fname').html('');
                    $('#lname').html('');
                    $('#mobile').html('');
                    $('#sp-div').attr('style','display:none');
                    return;
                }
                else
                {
                    $('#mobile_search').html('');
                }
                $('#sp-div').removeAttr('style');
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


    <script type="text/javascript">
        function initGeolocation()
        {
            if( navigator.geolocation )
            {
            // Call getCurrentPosition with success and failure callbacks
            navigator.geolocation.getCurrentPosition( success, fail );
            }
            else
            {
            alert("Sorry, your browser does not support geolocation services.");
            }
        }

        function success(position)
        {

            document.getElementById('long').value = position.coords.longitude;
            document.getElementById('latt').value = position.coords.latitude;
        }

        function fail()
        {
            // Could not obtain location
        }

    </script>

    <script>
     function sInfo()
     {
         var fd = new FormData();
        var att_files = document.getElementById("attachment");
        var file = att_files.files[0];
         fd.append("attachment",file);
         fd.append("u_id",$("#user_approved_id").val());
         fd.append("u_fname",$("#user_fname").val());
         fd.append("l_name",$("#user_lname").val());
         fd.append("estimate_time",$("#estimate_time").val());
         fd.append("estimate_type",$("#estimate_type").val());
         fd.append("title",$("#title").val());
         fd.append("description",$("#description").val());
         fd.append("strat_time",$("#strat_time").val());
         fd.append("bid_period",$("#bid_period").val());
         fd.append("bid",$("#bid").val());
         fd.append("bid_range",$("#bid_range").val());
         fd.append("attachment",$("#attachment").val());
         fd.append("scheduled_date",$("#scheduled_date").val());
         fd.append("keyword",$("#tags").val());
         fd.append("_token", "{{csrf_token()}}");
         
         $.ajax({
                 type: "POST",
                 url: "create",
                 contentType: false,
                 processData: false,
                 data: fd,
                 success:function(data){

                    console.log(data);
                    if(data=="success") 
                    {
                        window.location=window.location.origin+"/km_admin/job-post-cb/qd/wsx";
                        
                    }
                    else
                    {
                        window.location=window.location.origin+"/km_admin/job-post-cb/qd/qaz";   
                    }
                     //timerfn(data,1,"sp_checking");
                     // $("#sp_mk").val(sp_id)
         }});

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
                window.location=window.location.origin+"/km_admin/job-post-cb/qd/wsx";
                
            }
            if(data=="failed") 
            {
                document.getElementById('global-loader').style.display='none';
                console.log(data);
                window.location=window.location.origin+"/km_admin/job-post-cb/qd/qaz";
                //timerfn(current_booking_id,2,'failed');    
            }

        }
    });

}
</script>

    <script>
        function s_move()
        {

                $("#addr_mk").show();
                $("#sp_id").show();
                $("#u_id").hide();
                $("#f_id").hide();
                $("#sp-submit").show();

        }
    </script>

@endpush

@endsection

