<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Models\spExp;
use App\Models\spQualification;
use App\Models\listProfession;
use App\Models\skill;
use App\Models\daySlot;
use App\Models\Language;
use App\Models\timeSlot;
use App\Models\SPDetail;
use App\Models\SPProfession;
use App\Models\SPSkill;
use App\Models\Tariff;
use App\Models\UserLangList;
use App\Models\UserTimeSlot;
use App\Models\UserDetails;
use App\Models\User;
use App\Models\SPVerify;
use App\Models\Address;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\Booking;
use App\Models\PostJob;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SPController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get_keyword(Request $request)
    {
        $data = Skill::where("keyword","LIKE","%{$request->skill}%")->pluck('keyword');
                return response()->json($data);
    }

    public function get_user(Request $request)
    {
        $user_detl = UserDetails::where('mobile',$request->mobile)->first();
        if($user_detl)
        {
           $sp = SPDetail::where('users_id',$user_detl->id)->first();
            if($sp)
            {
                return "Already_sp";
            }
            return $user_detl;
        }else{
            return "Not_registered";
        }
    }

    public function get_sp(Request $request)
    {
        $user = User::where('userid',$request->sp_mobile)->where('sp_activated',3)->first('userid');
        $user_detl = UserDetails::where('mobile',$user->userid)->first();
        if($user_detl){
            return $user_detl;
        }else{
            return "No Record Found !";
        }
    }

    //--List of SPs who are not approved by admin

    public function Approve_sp()
    {
        // $service_provider = SPDetail::with('userinfo')->whereHas('watingsp',function($query){
        //     $query->where('sp_activated',2);
        // })->get();

        $service_provider =User::with('userdetail')->where('sp_activated',2)->get();

//dd($service_provider);
        // $service_provider = DB::table('users')
        //                     ->join('user_details', 'user_details.id', '=', 'users.users_id')
        //                     ->select('*')
        //                     ->where('sp_activated',2)
        //                     ->get();

        return view('Approve-sps',['service_providers'=>$service_provider]);
    }



    public function sp_modal($users_id)
    {
        $userDetail = UserDetails::where('id',$users_id)->first();
        $user = User::where('users_id',$users_id)->first();
        $SPVerify = SPVerify::where('users_id',$users_id)->first();
        $SPSkills = SPSkill::where('users_id',$users_id)->pluck('keywords_id')->toArray();
        $skillArr =[];
        foreach ($SPSkills as $key => $value) {
            $skill_tmp= skill::find($value);
            if($skill_tmp){
                $skillArr[] = $skill_tmp->keyword;
            }
        }
        $skillArr = implode(',', $skillArr);

        $UserLangList = UserLangList::where('users_id',$users_id)->pluck('language_id')->toArray();
        $langArr =[];
        foreach ($UserLangList as $key => $value) {
            $lang= Language::find($value);
            if($lang){
                $langArr[] = $lang->name;
            }
        }
        $langArr = implode(',', $langArr);

        $address = DB::table('address')
        ->join('city', 'address.city_id', '=', 'city.id')
        ->join('state', 'city.state_id', '=', 'state.id')
        ->join('country','state.country_id', '=', 'country.id')
        ->where('address.users_id', '=', $users_id)
        ->get();

        $spDetail = DB::table('sp_det')
        ->join('list_profession', 'sp_det.profession_id', '=', 'list_profession.id')
        ->join('sp_qual', 'sp_det.qual_id', '=', 'sp_qual.id')
        ->join('sp_exp','sp_det.exp_id', '=', 'sp_exp.id')
        ->where('sp_det.users_id', '=', $users_id)
        ->get();

        return view('sp-modal',['userDetails'=>$userDetail,'users'=>$user,'spDetails'=>$spDetail,'SPVerifys'=>$SPVerify,'address'=>$address,'skills'=>$skillArr,'languages'=>$langArr]);

    }

    //-------------
    public function sp_approve(Request $request)
    {
        $user = User::where('users_id',$request->users_id)->update([
            'sp_activated' => 3
        ]);
        return 'success';
    }
    public function sp_reject(Request $request)
    {
        $user = User::where('users_id',$request->users_id)->update([
            'sp_activated' => 4
        ]);
        return 'success';
    }

    public function index()
    {

        $service_provider = DB::table('users')
        ->join('user_details', 'user_details.id', '=', 'users.users_id')
        ->join('sp_det', 'sp_det.users_id', '=', 'user_details.id')
        ->where('users.sp_activated', '=', 3)
        ->get();


    //    $service_provider = DB::select('SELECT * FROM users
    //         JOIN user_details on user_details.id = users.users_id
    //         JOIN sp_det on sp_det.users_id = user_details.id
    //         INNER JOIN address
    //         JOIN city on city.id = address.city_id
    //         JOIN state on state.id = city.state_id
    //         JOIN country on country.id = state.country_id

    //         WHERE users.sp_activated =3
    //         ');


        return view('sps',['service_providers'=>$service_provider]);
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
            return view('sp-create',['sp_exps'=>$sp_exp,'sp_quali'=>$sp_quali,'sp_professions'=>$sp_profession,'skill_keys'=>$skill_key,'languages'=>$language,'day_slots'=>$day_slot,'time_slots'=>$time_slot]);

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);

        }
    }

    public function store(Request $request)
    {
          // create user
          $request->validate([
            'profession' => 'required',
            'qualification' => 'required',
            'sp_exp' => 'required',
            'skill' => 'required',
            'lang' => 'required',
            'about_us' => 'required',
            'gender' => 'required',
            'per_hour' => 'required',
            'per_day' => 'required',
            'min_charge' => 'required',
            'extra_charge' =>'required',
            'st_time' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        try
        {

            $user_approved_id = (int)$request->approve_id;

            $sp = SPDetail::where('users_id',$user_approved_id)->first();
            if($sp){
                return redirect('sps')->with('error', 'This user is already service provider ! Try again.');
            }else{

            //Time Slot

            $stTime=[];

            foreach ($request->st_time as $key => $value) {
                if($request->availability == "everyDay")
                {
                    $stTime[$value] = [$request->start_time[0],$request->end_time[0]];
                    $time_slot = timeSlot::where('id',$request->start_time)->first()->id;

                    $user_time_slot = UserTimeSlot::create([
                        'users_id' => $user_approved_id,
                        'day_slot' => $value,
                        'time_slot_id' => $time_slot,
                        'time_slot_from' => $request->start_time[0],
                        'time_slot_to' => $request->end_time[0],
                        'availability_day' => $request->availability,
                    ]);
                }elseif ($request->availability == "weakDay") {
                    $stTime[$value] = [$request->start_time[$key],$request->end_time[$key]];
                    $time_slot = timeSlot::where('id',$request->start_time)->first()->id;
                    $user_time_slot = UserTimeSlot::create([
                        'users_id' => $user_approved_id,
                        'day_slot' => $value,
                        'time_slot_id' => $time_slot,
                        'time_slot_from' => $request->start_time[$key],
                        'time_slot_to' => $request->end_time[$key],
                        'availability_day' => $request->availability,
                    ]);
                }
            }

            // store user information

            $sp_details = SPDetail::create([
                'users_id' => $user_approved_id,
                'profession_id' => $request->profession,
                'qual_id' => $request->qualification,
                'exp_id' => $request->sp_exp,
                'about_me' => $request->about_us,
                'availability_day' => $request->availability,
            ]);

            $sp_profession = SPProfession::create([
                'users_id' => $user_approved_id,
                'profession_id' => $request->profession,
                'exp_id' => $request->sp_exp,
            ]);

            $exploaded_skill = explode(',',$request->skill);
            $exploaded_skill = array_filter($exploaded_skill);

            foreach ($exploaded_skill as $key => $value) {
                $skill_id=skill::where('keyword',trim($value))->first();
                    $sp_skill = SPSkill::create([
                        'users_id' => $user_approved_id,
                        'keywords_id' => $skill_id->id,
                        'profession_id' => $request->profession
                    ]);
            }

            $currentTime = Carbon::now();
            $exploaded=explode(',',$request->lang);
            $exploaded=array_filter($exploaded);
            foreach ( $exploaded as $key => $value) {
                $language_id=Language::where('name',trim($value))->first();

                $sp_lang = UserLangList::create([
                    'language_id' =>$language_id->id,
                    'users_id' => $user_approved_id,
                    'created_dts' => $currentTime->format('Y-m-d H:i:s')
                ]);
            }

            $tariff = Tariff::create([
                'users_id' => $user_approved_id,
                'profession_id' => $request->profession,
                'per_hour' => $request->per_hour,
                'per_day' => $request->per_day,
                'min_charges' => $request->min_charge,
                'extra_charge' => $request->extra_charge,
            ]);


                $IDProof = $request->file('IDProof');
                    $new_name=rand('000000','111111').'.'.$IDProof->extension();
                    $IDProof->move(public_path().'/images/id_proof/',$new_name);

                $id_card = SPVerify::create([
                    'users_id' => $user_approved_id,
                    'id_card' => $new_name,
                ]);

                    $user_info = User::where('users_id',$user_approved_id)->update([
                        'activation_code' => 1,
                    ]);

                if($sp_details){
                    return redirect('sps')->with('success', 'Service Provider Create Successfully !');
                }else{
                    return redirect('sps')->with('error', 'Failed to create service provider ! Try again.');
                }
            }

        }catch (\Exception $e) {
           return $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function edit($users_id)
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
            $saved_user_skill_id = SPSkill::where('users_id',$users_id)->get();
            $saved_skill='';
            foreach($saved_user_skill_id as $skill_id)
            {
                $savedskill_id=skill::where('id',$skill_id->keywords_id)->first();
                $saved_skill.=$savedskill_id->keyword.',';
            }
            $saved_user_lang_id=UserLangList::where('users_id',$users_id)->get();
            $saved_language='';
            foreach($saved_user_lang_id as $lang_id)
            {
                $savelang_id=Language::where('id',$lang_id->language_id)->first();
                $saved_language.=$savelang_id->name.',';
            }

            $sp  = SPDetail::where('users_id',$users_id)->first();
            $UserTimeSlot  = Tariff::where('users_id',$users_id)->first();
            $spVerify = SPVerify::where('users_id',$users_id)->first();
            $user_time_slot = UserTimeSlot::where('users_id',$users_id)->get();
            return view('edit-sp',['sp_exps'=>$sp_exp,'sp_quali'=>$sp_quali,'sp_professions'=>$sp_profession,'skill_keys'=>$skill_key,'languages'=>$language,'day_slots'=>$day_slot,'time_slots'=>$time_slot,"sp"=>$sp,"UserTimeSlot"=>$UserTimeSlot,'spVerify'=>$spVerify,'user_time_slot'=>$user_time_slot,'saved_language'=>$saved_language,'saved_skill'=>$saved_skill]);

        }catch (\Exception $e) {
            return $bug = $e->getMessage();
            // dd($bug);
            return redirect()->back()->with('error', $bug);
        }
    }

    public function update(Request $request)
    {

        // update user info
         $request->validate([
            'users_id'       => 'required',
        ]);
        try{
            //SP Detail Update
            $sPDetails  = SPDetail::where('users_id',$request->users_id)->update([
                'profession_id' => $request->profession,
                'qual_id' => $request->qualification,
                'exp_id' => $request->sp_exp,
                'availability_day' => $request->availability,

            ]);

            //SP Profession Update
            $SPProfession  = SPProfession::where('users_id',$request->users_id)->update([
                'profession_id' => $request->profession,
                'exp_id' => $request->sp_exp,
            ]);

            //SP Skill Update
            $SPSkill  = SPSkill::where('users_id',$request->users_id)->delete();
            $exploaded_skill = explode(',',$request->skill);
            $exploaded_skill = array_filter($exploaded_skill);
            foreach ($exploaded_skill as $key => $value) {
                $skill_id=skill::where('keyword',trim($value))->first();
                    $sp_skill = new SPSkill;
                    $sp_skill->users_id = $request->users_id;
                    $sp_skill->keywords_id =  $skill_id->id;
                    $sp_skill->profession_id = $request->profession;
                    $sp_skill->save();
            }

            //SP Language Update
            $UserLangList  = UserLangList::where('users_id',$request->users_id)->delete();
            $currentTime = Carbon::now();
            $exploaded=explode(',',$request->lang);
            $exploaded=array_filter($exploaded);
            foreach ( $exploaded as $key => $value) {
                $language_id=Language::where('name',trim($value))->first();
                $UserLangList = new UserLangList;
                $UserLangList->users_id = $request->users_id;
                $UserLangList->language_id = $language_id->id;
                $UserLangList->created_dts = $currentTime->format('Y-m-d H:i:s');
                $UserLangList->save();
            }

            //SP Tariff Update
            $Tariff  = Tariff::where('users_id',$request->users_id)->update([
                'profession_id' => $request->profession,
                'per_hour' => $request->per_hour,
                'per_day' => $request->per_day,
                'min_charges' => $request->min_charge,
                'extra_charge' => $request->extra_charge,
            ]);


                if($request->hasFile('IDProof')){
                $IDProof = $request->file('IDProof');
                        $new_name=rand('000000','111111').'.'.$IDProof->extension();
                        $IDProof->move(public_path().'/images/id_proof/',$new_name);
                        $sp_verify = SPVerify::where('users_id',$request->users_id)->first();
                        $sp_verify->id_card = $new_name;
                        $sp_verify->save();
                }

            $UserTimeSlot  = UserTimeSlot::where('users_id',$request->users_id)->delete();

            $stTime=[];
            foreach ($request->st_time as $key => $value) {
                if($request->availability == "everyDay")
                {
                    $stTime[$value] = [$request->start_time[0],$request->end_time[0]];
                    $time_slot = timeSlot::where('from',$request->start_time[0])->first();

                    $UserTimeSlot=new UserTimeSlot;
                    $UserTimeSlot->users_id=$request->users_id;
                    $UserTimeSlot->day_slot=$value;
                    $UserTimeSlot->time_slot_id=$time_slot->id;
                    $UserTimeSlot->time_slot_from=$request->start_time[0];
                    $UserTimeSlot->time_slot_to=$request->end_time[0];
                    $UserTimeSlot->availability_day=$request->availability;
                    $UserTimeSlot->save();

                    // $stTime[$value] = [$request->start_time[0],$request->end_time[0]];
                    // $time_slot = timeSlot::where('id',$request->start_time)->first()->id;
                    // $UserTimeSlot  = UserTimeSlot::where('users_id',$request->users_id)->update([
                    //     'users_id' => $request->users_id,
                    //     'day_slot' => $value,
                    //     'time_slot_id' => $time_slot,
                    //     'time_slot_from' => $request->start_time[0],
                    //     'time_slot_to' => $request->end_time[0],
                    //     'availability_day' => $request->availability,
                    // ]);

                }elseif ($request->availability == "weakDay") {

                    $stTime[$value] = [$request->start_time[$key],$request->end_time[$key]];
                    $time_slot = timeSlot::where('from',$request->start_time[$key])->first();

                    $UserTimeSlot=new UserTimeSlot;
                    $UserTimeSlot->users_id=$request->users_id;
                    $UserTimeSlot->day_slot=$value;
                    $UserTimeSlot->time_slot_id=$time_slot->id;
                    $UserTimeSlot->time_slot_from=$request->start_time[$key];
                    $UserTimeSlot->time_slot_to=$request->end_time[$key];
                    $UserTimeSlot->availability_day=$request->availability;
                    $UserTimeSlot->save();

                    // $stTime[$value] = [$request->start_time[$key],$request->end_time[$key]];
                    // $time_slot = timeSlot::where('id',$request->start_time)->first()->id;
                    // $UserTimeSlot  = UserTimeSlot::where('users_id',$request->users_id)->update([
                    //     'users_id' => $request->users_id,
                    //     'day_slot' => $value,
                    //     'time_slot_id' => $time_slot,
                    //     'time_slot_from' => $request->start_time[$key],
                    //     'time_slot_to' => $request->end_time[$key],
                    //     'availability_day' => $request->availability,

                    // ]);
                }
            }

            return redirect('sps')->with('success', 'service provider updated succesfully!');

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            //dd($bug);
            return redirect()->back()->with('error', $bug);

        }
    }

    //sp profile

    public function profile($users_id)
    {
        $userDetail = UserDetails::where('id',$users_id)->first();
        $user = User::where('users_id',$users_id)->first();
        $SPVerify = SPVerify::where('users_id',$users_id)->first();
        $SPSkills = SPSkill::where('users_id',$users_id)->pluck('keywords_id')->toArray();
        $skillArr =[];
        foreach ($SPSkills as $key => $value) {
            $skill_tmp= skill::find($value);
            if($skill_tmp){
                $skillArr[] = $skill_tmp->keyword;
            }
        }
        $skillArr = implode(',', $skillArr);

        $UserLangList = UserLangList::where('users_id',$users_id)->pluck('language_id')->toArray();
        $langArr =[];
        foreach ($UserLangList as $key => $value) {
            $lang= Language::find($value);
            if($lang){
                $langArr[] = $lang->name;
            }
        }
        $langArr = implode(',', $langArr);

        $address = DB::table('address')
        ->join('city', 'address.city_id', '=', 'city.id')
        ->join('state', 'city.state_id', '=', 'state.id')
        ->join('country','state.country_id', '=', 'country.id')
        ->where('address.users_id', '=', $users_id)
        ->get();

        $spDetail = DB::table('sp_det')
        ->join('list_profession', 'sp_det.profession_id', '=', 'list_profession.id')
        ->join('sp_qual', 'sp_det.qual_id', '=', 'sp_qual.id')
        ->join('sp_exp','sp_det.exp_id', '=', 'sp_exp.id')
        ->where('sp_det.users_id', '=', $users_id)
        ->get();

////bid
        $total_bid=DB::table('bid_det')
        ->where('status_id','=',40)
        ->where('users_id','=',$users_id)
        ->count();
        $total_bid_awarded=DB::table('bid_det')
        ->where('status_id','=',27)
        ->where('users_id','=',$users_id)
        ->count();
        $total_bid_pending=DB::table('bid_det')
        ->where('status_id','=',9)
        ->where('users_id','=',$users_id)
        ->count();

///end bid

        // $total_post=DB::table('post_job')
        // ->join('booking','post_job.booking_id','=','booking.id')
        // ->where('booking.users_id','=',$users_id)
        // ->count();

        // $total_inprogress_post=DB::table('post_job')
        // ->join('booking','post_job.booking_id','=','booking.id')
        // ->where('booking.users_id','=',$users_id)
        // ->where('post_job.status_id','=',13)
        // ->count();
        // $total_pending_post=DB::table('post_job')
        // ->join('booking','post_job.booking_id','=','booking.id')
        // ->where('booking.users_id','=',$users_id)
        // ->where('post_job.status_id','=',9)
        // ->count();
        // $total_rejected_post=DB::table('post_job')
        // ->join('booking','post_job.booking_id','=','booking.id')
        // ->where('booking.users_id','=',$users_id)
        // ->where('post_job.status_id','=',29)
        // ->count();
        // $total_notresponded_post=DB::table('post_job')
        // ->join('booking','post_job.booking_id','=','booking.id')
        // ->where('booking.users_id','=',$users_id)
        // ->where('post_job.status_id','=',6)
        // ->count();

        $total_booking=DB::table('booking')
        ->where('users_id','=',$users_id)
        ->count();
        $total_inprogress_booking=DB::table('booking')
        ->where('users_id','=',$users_id)
        ->where('status_id','=',13)
        ->count();
        $total_pending_booking=DB::table('booking')
        ->where('users_id','=',$users_id)
        ->where('status_id','=',9)
        ->count();
        $total_rejected_booking=DB::table('booking')
        ->where('users_id','=',$users_id)
        ->where('status_id','=',29)
        ->count();
        $total_notresponded_booking=DB::table('booking')
        ->where('users_id','=',$users_id)
        ->where('status_id','=',6)
        ->count();


        return view('sp-profile',[
            'userDetails'=>$userDetail,
            'users'=>$user,
            'spDetails'=>$spDetail,
            'SPVerifys'=>$SPVerify,
            'address'=>$address,
            'skills'=>$skillArr,
            'languages'=>$langArr,
            'total_bid'=>$total_bid,
            'total_bid_awarded'=>$total_bid_awarded,
            'total_bid_pending'=>$total_bid_pending,
            'total_booking'=>$total_booking,
            'total_inprogress_booking'=>$total_inprogress_booking,
            'total_pending_booking'=>$total_pending_booking,
            'total_rejected_booking'=>$total_rejected_booking,
            'total_notresponded_booking'=>$total_notresponded_booking]);
    }
}


