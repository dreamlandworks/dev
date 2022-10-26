<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\skill;
use App\Models\daySlot;
use App\Models\spExp;
use App\Models\listProfession;
use App\Models\spQualification;
use App\Models\Language;
use App\Models\timeSlot;
use App\Models\SPDetail;
use App\Models\SPProfession;
use App\Models\SPSkill;
use App\Models\UserLangList;
use App\Models\UserTimeSlot;
use App\Models\UserDetails;
use App\Models\User;
use App\Models\Booking;
use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\EstimateType;
use App\Models\BidRange;
use App\Models\BidDetail;
use App\Models\BookingStatusCode;
use App\Models\PostJob;
use App\Models\SingleMove;
use App\Models\Attachment;
use App\Models\Zipcode;
use App\Models\Transaction;
use App\Models\PostReqKeywords;
use App\Models\PostReqLanguage;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class JobController extends Controller
{
    //
    public function index()
    {      
        $query=PostJob::orderBy('id');
        $query= $query->whereHas('BookingDetails', function($query) {
                $query->where('category_id',1);
            })->get();
        $post_jobs = $query;
        return view('jobPost-sm',compact('post_jobs'));
    }
    public function indexMsg($msg)
    {      
        $query=PostJob::orderBy('id');
        $query= $query->whereHas('BookingDetails', function($query) {
                $query->where('category_id',1);
            })->get();
        $post_jobs = $query;
        return view('jobPost-sm',['message'=>$msg,'post_jobs'=>$post_jobs]);
    }
    public function view_sm_post($booking_id)
    {      
        $query=PostJob::where('booking_id',$booking_id)->orderBy('id');
        $query= $query->whereHas('BookingDetails', function($query) {
                $query->where('category_id',1);
            })->get();
        $post_jobs = $query;
        foreach($post_jobs as $bid_det)
        {
            $bid_detail=BidDetail::where('post_job_id',$bid_det->id)->get();
        }
        $each_bid_det=array();
        foreach($bid_detail as $key=>$bid_value)
        {
            $user_name=UserDetails::where('id',$bid_value->users_id)->first();
            $estimate_type=EstimateType::where('id',$bid_value->estimate_type_id)->first();
            $bid_status=BookingStatusCode::where('id',$bid_value->status_id)->first();
            
            $each_bid_det[$key]['id']=$bid_value->id;
            if(isset($user_name['fname']))
            {
                $each_bid_det[$key]['users_name']=$user_name['fname'].' '.$user_name['lname'];
            }
            else
            {
                $each_bid_det[$key]['users_name']='';
            }
            $each_bid_det[$key]['amount']=$bid_value->amount;
            $each_bid_det[$key]['estimate_type']=$estimate_type['name'];
            $each_bid_det[$key]['esimate_time']=$bid_value->esimate_time;
            $each_bid_det[$key]['proposal']=$bid_value->proposal;
            $each_bid_det[$key]['bid_type']=$bid_value->bid_type;
            $each_bid_det[$key]['bid_status']=$bid_status['name'];
        }
        
        return view('view-jobPost-sm',compact('post_jobs','each_bid_det'));
    }
    public function award_bid($bid_id)
    {
        try
        {
            $award_bid=BidDetail::where('post_job_id',$bid_id)->first();
            $award_bid->status_id=27;
            $award_bid->save();
            
            if($award_bid)
            {
                return redirect('/job-post-sm')->with('success','Bid awarded successfully!');
            }
            else
            {
                return redirect()->back()->with('error','Failed to award bid.');
            }
            
            
            
        }catch(\Exception $e)
        {
            $bug=$e->getMessage();
            return redirect()->back()->with('error',$bug);
        }
    }
    public function reject_bid($bid_id)
    {
        try
        {
            $award_bid=BidDetail::where('post_job_id',$bid_id)->first();
            $award_bid->status_id=29;
            $award_bid->save();
            
            if($award_bid)
            {
                return redirect('/job-post-sm')->with('success','Bid rejected successfully!');
            }
            else
            {
                return redirect()->back()->with('error','Failed to reject bid.');
            }
            
            
            
        }catch(\Exception $e)
        {
            $bug=$e->getMessage();
            return redirect()->back()->with('error',$bug);
        }
    }
    public function create()
    {
    	try
        {
            $sp_exp = spExp::all();
            $sp_quali = spQualification::all();
            $sp_profession = listProfession::all();
            $skill_key = skill::pluck('keyword');
            $language = Language::pluck('name');
            $day_slot = daySlot::get();
            $time_slot = timeSlot::get();
            $estimate_type = EstimateType::get();
            $bid_range = BidRange::get();
            return view('create-job-post',['sp_exps'=>$sp_exp,'sp_quali'=>$sp_quali,'sp_professions'=>$sp_profession,'skill_keys'=>$skill_key,'languages'=>$language,'day_slots'=>$day_slot,'time_slots'=>$time_slot,'estimate_type'=>$estimate_type,'bid_range'=>$bid_range]);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }

    public function store(Request $request)
    {
        $user_approved_id = (int)$request->u_id;
        // return $request;
        $request->validate([
            // 'description' => 'required',
            // 'attachment' => 'required',
            // 'lattitude' => 'required',
            // 'longitude' => 'required',


            ]);

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
            $booking->time_slot_id   = $request->strat_time;
            $booking->scheduled_date = $request->scheduled_date;
            $booking->attachment_count = 1;
            $booking->status_id  = 26;
            $booking->profession_id = 1;
            $booking->estimate_time = $request->estimate_time;
            $booking->estimate_type_id   = $request->estimate_type;
            $booking->save();

            $bookingid=$booking->id;

            $postJob=new PostJob;
            $postJob->booking_id =$bookingid;
            $postJob->user_plan_id=0;
            $postJob->status_id =26;
            $postJob->bids_period=$request->bid_period;
            $postJob->title=$request->title;
            $postJob->bid_per=$request->estimate_type;
            $postJob->bid_range_id=$request->bid_range;
            $postJob->save();

            $exploaded_skill = explode(',',$request->keyword);
            $exploaded_skill = array_filter($exploaded_skill);
            foreach ($exploaded_skill as $key => $value)
            {
                $skill_id=skill::where('keyword',trim($value))->first();

                $postKeywords=new PostReqKeywords;
                $postKeywords->post_job_id=$postJob->id;
                $postKeywords->keywords_id=$skill_id->id;
                $postKeywords->save();
                
            }

            $exploaded=explode(',',$request->language);
            $exploaded=array_filter($exploaded);
            foreach ( $exploaded as $key => $value) {
                $language_id=Language::where('name',trim($value))->first();

                $postLanguage=new PostReqLanguage;
                $postLanguage->post_job_id=$postJob->id;
                $postLanguage->language_id=$language_id->id;
                $postLanguage->save();
            }
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
            $single_move->job_description = $request->description;
            $single_move->save();

            return "success";

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

        // $distance = 100;
        // $earthRadius = 6371;
        // $lat1 = $request->lattitude;
        // $lon1 = $request->longitude;
        // $bearing = deg2rad(0);

        // $lat2 = asin(sin($lat1) * cos($distance / $earthRadius) + cos($lat1) * sin($distance / $earthRadius) * cos($bearing));
        // $lon2 = $lon1 + atan2(sin($bearing) * sin($distance / $earthRadius) * cos($lat1), cos($distance / $earthRadius) - sin($lat1) * sin($lat2));

        // $lat2 = rad2deg($lat2);
        // $lon2 = rad2deg($lon2);


        $loc = DB::select("SELECT * FROM keywords
       JOIN sp_skill ON sp_skill.keywords_id = keywords.id
       JOIN user_details ON user_details.id = sp_skill.users_id
       JOIN sp_location ON sp_location.users_id = sp_skill.users_id
       WHERE MATCH(keyword)
       AGAINST('".$request->keyword." Developer Near Me' IN NATURAL LANGUAGE MODE)
       AND sp_location.latitude BETWEEN '16.4094313' AND '16.6094313'
       AND sp_location.longitude BETWEEN '80.5706109' AND '80.7706109'
       GROUP BY sp_skill.users_id");

        return $loc;

    }
}
