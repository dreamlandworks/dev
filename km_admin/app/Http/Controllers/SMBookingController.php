<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Address;
use App\Models\SingleMove;
use App\Models\skill;
use App\Models\SpLocation;
use App\Models\timeSlot;
use App\Models\Attachment;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Zipcode;
use App\Models\Transaction;
use App\Models\SingleReschedule;
use App\Models\BookingStatus;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class SMBookingController extends Controller
{
    public function index()
    {
        $booking = Booking::with('userdetail')->where('sp_id','!=',0)->where('category_id',1)->get();
        return view('booking-sm',["bookings"=>$booking]);
    }
    public function indexMsg($msg)
    {  
        $booking = Booking::with('userdetail')->where('sp_id','!=',0)->where('category_id',1)->get();
        return view('booking-sm',['message'=>$msg,'bookings'=>$booking]);
    }
    public function bookingschedule(Request $request)
    {
        $time_slot = timeSlot::get();
        $schedule=Booking::where('id',$request->booking_id)->first();
        if(!empty($schedule->time_slot_id))
        {
            $timeslot=timeslot::where('id',$schedule->time_slot_id)->first();
            $curr_timeslot=$timeslot->from;
        }
        else
        {
            $curr_timeslot='Not available';
        } 
        $curr_booking_id= $request->booking_id;
        $curr_timeslot_id=$schedule->time_slot_id;
        $curr_sp_id=$schedule->sp_id;
        if(!empty($schedule->scheduled_date))
        {
            $curr_schedule_date=$schedule->scheduled_date;
        }
        else
        {
            $curr_schedule_date='Not available';
        }
        return ['booking_id'=>$curr_booking_id,'schedule_date'=>$curr_schedule_date,'timeslot'=>$curr_timeslot,'timeslot_id'=>$curr_timeslot_id,'time_slot_data'=>$time_slot,'sp_id'=>$curr_sp_id];
    }

    public function re_schedule(Request $request)
    {
        $request->validate([
            'rescheduled_date'=>'required',
            'rescheduled_time'=>'required'
        ]);
        try
        {
            $reschedule=new SingleReschedule;
            $reschedule->booking_id=$request->booking_id;
            $reschedule->scheduled_date=$request->scheduled_date;
            $reschedule->scheduled_time_slot_id=$request->scheduled_time_id;
            $reschedule->rescheduled_date=$request->rescheduled_date;
            $reschedule->rescheduled_time_slot_id=$request->rescheduled_time;
            $reschedule->save();

            $bookingStatus=new BookingStatus;
            $bookingStatus->booking_id=$request->booking_id;
            $bookingStatus->status_id=10;
            $bookingStatus->sp_id=$request->sp_id;
            $bookingStatus->save();

            $update_schd=Booking::find($request->booking_id);
            $update_schd->reschedule_id =$reschedule->id ;
            $update_schd->reschedule_status_id =10;
            $update_schd->save();
            return "success";
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);
        }
    }
    public function create()
    {

        try
        {
            $skill_key = skill::pluck('keyword');
            $time_slot = timeSlot::get();
            return view('create-sm-booking',["skill_key"=>$skill_key,'time_slots'=>$time_slot]);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }
    public function store(Request $request)
    {
        $user_approved_id = (int)$request->u_id;

        $request->validate([
            'work_description' => 'required',
            'attachment' => 'required',
            'scheduled_date'=>'required',
            'keyword'=>'required',
            'strat_time'=>'required',
            'lattitude' => 'required',
            'longitude' => 'required',
            'state'=>'required',
            'address'=>'required',
            'postal_code'=>'required',
            'country'=>'required',
            'city'=>'required'

            ],
            [
                'strat_time.required'=>'Time slot field is required',
                'lattitude.required'=>'Please enter valid location in map.',
                'longitude.required'=>'Please enter valid location in map.',
                'state.required'=>'Please enter valid location in map.',
                'address.required'=>'Please enter valid location in map.',
                'postal_code.required'=>'Please enter valid location in map.',
                'country.required'=>'Please enter valid location in map.',
                'city.required'=>'Please enter valid location in map.'
            ]
        );

        $country_name=$request->country;
        $state_name=$request->state;
        $city_name=$request->city;

        if(!empty($request->postal_code))
        {
            $zipvalue=array();
            $current_zipcode_value=$request->postal_code;
            $check_zip=DB::table('zipcode')->where('zipcode',$current_zipcode_value)->get();
            foreach($check_zip as $zip_value)
            {
                array_push($zipvalue,$zip_value->zipcode);
            }
            if(!in_array($current_zipcode_value,$zipvalue))
            {
                $countryname=array();
                $countryid=array();
                $check_country=DB::table('country')->get();
                foreach($check_country as $country_value)
                {
                    $countryid[$country_value->country]=$country_value->id;
                    array_push($countryname,$country_value->country);
                }
                if(in_array($country_name,$countryname))
                {
                    $country_id=$countryid[$country_name];
                }
                else
                {
                    $new_country=DB::table('country')->insert(
                            ['country'=>$country_name]
                        );
                }

                $statename=array();
                $stateid=array();
                $check_state=DB::table('state')->get();
                $old_country=DB::table('country')->where('country',$country_name)->first();
                foreach($check_state as $state_value)
                {
                    $stateid[$state_value->state]=$state_value->id;
                    array_push($statename,$state_value->state);
                }
                if(in_array($state_name,$statename))
                {
                    $state_id=$stateid[$state_name];
                }
                else
                {
                    $new_state=DB::table('state')->insert(
                            ['state'=>$state_name,
                             'country_id'=>$old_country->id]
                        );
                }

                $cityname=array();
                $cityid=array();
                $check_city=DB::table('city')->get();
                $old_state=DB::table('state')->where('state',$state_name)->first();
                foreach($check_city as $city_value)
                {
                    $cityid[$city_value->city]=$city_value->id;
                    array_push($cityname,$city_value->city);
                }
                if(in_array($city_name,$cityname))
                {
                    $city_id=$cityid[$city_name];
                }
                else
                {
                    $new_city=DB::table('city')->insert(
                            ['city'=>$city_name,
                             'state_id'=>$old_state->id]
                        );
                }
                $old_city=DB::table('city')->where('city',$city_name)->first();
                $new_zipcode=DB::table('zipcode')->insert(
                            ['zipcode'=>$request->postal_code,
                             'city_id'=>$old_city->id]
                        );

                $current_zipcode_value=$request->postal_code;
                $current_zipcode=DB::table('zipcode')->where('zipcode',$current_zipcode_value)->first();
                $current_zipcode_id= $current_zipcode->id;
                $current_zipcode_id;
            }
            else
            {
                $current_zipcode_value=$request->postal_code;
                $current_zipcode=DB::table('zipcode')->where('zipcode',$current_zipcode_value)->first();
                $current_zipcode_id= $current_zipcode->id;
                $current_zipcode_id;
            }
        }

        try
        {
            $booking = new Booking;
            $booking->users_id = $user_approved_id;
            $booking->sp_id = 0;
            $booking->category_id = 1;
            $booking->time_slot_id = $request->strat_time;
            $booking->scheduled_date = $request->scheduled_date;
            $booking->save();

            $bookingid=$booking->id;

            if($request->hasFile('attachment'))
            {
                $attachment = new Attachment;
                $currentTime = Carbon::now();
                $image = $request->file('attachment');
                $new_name=rand('000000','111111').'.'.$image->extension();
                $image->move(public_path().'/images/attachments/',$new_name);
                $path = "images/attachments";
                $attachment->booking_id = $booking->id;
                $attachment->file_name = $new_name;
                $attachment->file_location = $path;
                $attachment->created_on = $currentTime;
                $attachment->save();
            }
            //return $attachment;

            $address = new Address;
            $address->latitude = $request->lattitude;
            $address->longitude = $request->longitude;
            $address->locality = $request->address;
            $address->users_id = $user_approved_id;

            $address->zipcode_id = $current_zipcode_id;
            $address->save();

            $single_move = new SingleMove;
            $single_move->booking_id = $booking->id;
            $single_move->address_id = $address->id;
            $single_move->job_description = $request->work_description;
            $single_move->save();

            $distance = 1000;
            $earthRadius = 6371;
            $lat1 = $request->lattitude;
            $lon1 = $request->longitude;
            $bearing = deg2rad(0);

            $lat2 = asin(sin($lat1) * cos($distance / $earthRadius) + cos($lat1) * sin($distance / $earthRadius) * cos($bearing));
            $lon2 = $lon1 + atan2(sin($bearing) * sin($distance / $earthRadius) * cos($lat1), cos($distance / $earthRadius) - sin($lat1) * sin($lat2));

            $lat2 = rad2deg($lat2);
            $lon2 = rad2deg($lon2);

            $loc = \DB::select("SELECT * FROM keywords
            JOIN sp_skill ON sp_skill.keywords_id = keywords.id
            JOIN user_details ON user_details.id = sp_skill.users_id
            JOIN sp_location ON sp_location.users_id = sp_skill.users_id
            WHERE MATCH(keyword)
            AGAINST('".$request->keyword." Developer Near Me' IN NATURAL LANGUAGE MODE)
            AND sp_location.latitude BETWEEN '".$lat1."' AND '".$lat2."'
            AND sp_location.longitude BETWEEN '".$lon1."' AND '".$lon2."'
            GROUP BY sp_skill.users_id");

            foreach ($loc as $key => $value) {

                // $data = User::where('users_id',$value->users_id)->update('fcm_token',$request->_token);

                 $response = Http::post('http://satrango.com/user/send_fcm', [
                    "to"=>"fI93GxXgSqa5VrfFVy3wDG:APA91bEMVTNidQfVlAyWT1U6SR84ducukum9u4V7v8X-7WJOU87Sv-fAejDb8nw6di6rd4r-byc5-xnczy7NGB3jrwf0Glg1DQuVhkHRhKKeVs5FqqRtL_3S4gbYLpr0h9OrK27Gsfp4",
                    "priority"=> "high",
                    "notification"=> ["title"=> "user"],
                    "text"=> ".$booking->id.|1|.$user_approved_id.|user",
                    "body"=> ".$booking->id.|1|.$user_approved_id.|user"
                ]);
            }

            return $booking->id;

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);
        }
    }

    public function store_txn(Request $request)
    {
        try
        {
            $check_sp=Booking::where('id',$request->booking_id)->first();
            //return $check_sp->sp_id;
            $sp_id=$check_sp->sp_id;
            if(($sp_id>0) && ($request->sp_update!='success'))
            {
                $add_txn=new Transaction;
                $add_txn->name_id=1;
                $add_txn->date=now();
                $add_txn->amount=500;
                $add_txn->type_id=1;
                $add_txn->users_id=$request->u_id;
                $add_txn->method_id=4;
                $add_txn->reference_id='SDDFD22333DXd';
                $add_txn->order_id='BKN_20220407_122448_1649314488';
                $add_txn->booking_id=$request->booking_id;
                $add_txn->payment_status='TXN_SUCCESS';
                $add_txn->save();
                return "success";
            }

            if($request->sp_update=='failed')
            {
                $add_txn=new Transaction;
                $add_txn->name_id=1;
                $add_txn->date=now();
                $add_txn->amount=0;
                $add_txn->type_id=0;
                $add_txn->users_id=$request->u_id;
                $add_txn->method_id=4;
                $add_txn->reference_id='Failed';
                $add_txn->order_id='Failed';
                $add_txn->booking_id=$request->booking_id;
                $add_txn->payment_status='Failed';
                $add_txn->save();
                return "failed";
            }
            if($request->sp_update=='sp_checking')
            {
                return $request->booking_id;
            }


        }catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return redirect()->back()->with('error', $bug);
        }
    }

    public function getspinfo(Request $request)
    {

        $distance = 1000;
        $earthRadius = 6371;
        $lat1 = $request->lattitude;
        $lon1 = $request->longitude;
        $bearing = deg2rad(0);

        $lat2 = asin(sin($lat1) * cos($distance / $earthRadius) + cos($lat1) * sin($distance / $earthRadius) * cos($bearing));
        $lon2 = $lon1 + atan2(sin($bearing) * sin($distance / $earthRadius) * cos($lat1), cos($distance / $earthRadius) - sin($lat1) * sin($lat2));

        $lat2 = rad2deg($lat2);
        $lon2 = rad2deg($lon2);


        $loc = DB::select("SELECT * FROM keywords
       JOIN sp_skill ON sp_skill.keywords_id = keywords.id
       JOIN user_details ON user_details.id = sp_skill.users_id
       JOIN sp_location ON sp_location.users_id = sp_skill.users_id
       WHERE MATCH(keyword)
       AGAINST('".$request->keyword." Developer Near Me' IN NATURAL LANGUAGE MODE)
       AND sp_location.latitude BETWEEN '".$lat1."' AND '".$lat2."'
       AND sp_location.longitude BETWEEN '".$lon1."' AND '".$lon2."'
       GROUP BY sp_skill.users_id");

        return $loc;

    }

}
