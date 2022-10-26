<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Booking;
use App\Models\Attachment;
use App\Models\BlueCollor;
use App\Models\Transaction;
use App\Models\skill;
use App\Models\timeSlot;
use App\Models\SingleReschedule;
use App\Models\BookingStatus;
use Carbon\Carbon;

use DB;

class CBBookingController extends Controller
{
    public function index()
    {
        $cbooking = Booking::with('userdetail')->where('sp_id','!=',0)->where('category_id',2)->get();
        return view('booking-cb',["cbookings"=>$cbooking]);
    }
    public function indexMsg($msg)
    {  
        $cbooking = Booking::with('userdetail')->where('sp_id','!=',0)->where('category_id',2)->get();
        return view('booking-cb',['message'=>$msg,"cbookings"=>$cbooking]);
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
            return view('create-cb-booking',["skill_key"=>$skill_key,'time_slots'=>$time_slot]);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }
    public function store(Request $request)
    {
        $user_approved_id = (int)$request->u_id;
        $currentTime=Carbon::now();
        $otp=rand(0000,1111);

        $request->validate([
            'work_description' => 'required',
            'attachment' => 'required',
            'strat_time' => 'required',
            'scheduled_date' => 'required',

            ]);
        try
        {

            $booking = new Booking;
            $booking->users_id = $user_approved_id;
            $booking->sp_id = 0;
            $booking->category_id = 2;
            $booking->time_slot_id = $request->strat_time;
            $booking->scheduled_date = $request->scheduled_date;
            $booking->started_at = '0000-00-00 00:00:00';
            $booking->completed_at = '0000-00-00 00:00:00';
            $booking->created_on = $currentTime;
            $booking->reschedule_id = 0;
            $booking->reschedule_status_id =0;
            $booking->otp =$otp;
            $booking->attachment_count = 1;
            $booking->status_id = 3;
            $booking->estimate_time = 1;
            $booking->estimate_type_id = 1;
            $booking->proposal = 'Null';

            $booking->save();

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

            $blueCollor=new BlueCollor;
            $blueCollor->booking_id = $booking->id;
            $blueCollor->job_description = $request->work_description;
            $blueCollor->save();
            
            $loc = \DB::select("SELECT * FROM keywords
            JOIN sp_skill ON sp_skill.keywords_id = keywords.id
            JOIN user_details ON user_details.id = sp_skill.users_id
            JOIN sp_location ON sp_location.users_id = sp_skill.users_id
            WHERE MATCH(keyword)
            AGAINST('".$request->keyword." Developer Near Me' IN NATURAL LANGUAGE MODE)
            AND sp_location.latitude BETWEEN '16.4094313' AND '16.6094313'
            AND sp_location.longitude BETWEEN '80.5706109' AND '80.7706109'
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
            if(($sp_id>0) && (($request->sp_update)!='success'))
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

        // $distance = 100;
        // $earthRadius = 6371;
        // $lat1 = $request->lattitude;
        // $lon1 = $request->longitude;
        // $bearing = deg2rad(0);

        // $lat2 = asin(sin($lat1) * cos($distance / $earthRadius) + cos($lat1) * sin($distance / $earthRadius) * cos($bearing));
        // $lon2 = $lon1 + atan2(sin($bearing) * sin($distance / $earthRadius) * cos($lat1), cos($distance / $earthRadius) - sin($lat1) * sin($lat2));

        // $lat2 = rad2deg($lat2);
        // $lon2 = rad2deg($lon2);


        $skills = DB::select("SELECT * FROM keywords
        JOIN sp_skill ON sp_skill.keywords_id = keywords.id
        JOIN user_details ON user_details.id = sp_skill.users_id
        WHERE MATCH(keyword)
        AGAINST('".$request->keyword." Developer Near Me' IN NATURAL LANGUAGE MODE)
        GROUP BY sp_skill.users_id");

        return $skills;

    }

}
