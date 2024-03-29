<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class MiscModel extends Model
{

    //---------------------------------------------------------GET RESCHEDULE INFO----------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    

    function reschedule_data($id, $type)
    {

        // $type = 1 for User and 2 for SP

        $builder = $this->db->table('re_schedule');
        $builder->select('*');
        if ($type == 1) {
            $builder->join('alert_action_user', 'alert_action_user.reschedule_id = re_schedule.reschedule_id');
        } else {
            $builder->join('alert_action_sp', 'alert_action_sp.reschedule_id = re_schedule.reschedule_id');
        }
        $builder->join('time_slot', 'time_slot.id = re_schedule.rescheduled_time_slot_id');
        $builder->where('re_schedule.reschedule_id', $id);
        $query = $builder->get();
        // echo "<br> str ".$this->db->getLastQuery();exit;
        if ($query->getResult() != null) {
            return $query->getResultArray();
        } else {
            return 'failure';
        }
    }


    //---------------------------------------------------------GET USER BASIC INFO---------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function user_info($id)
    {

        $builder = $this->db->table('user_details');
        $builder->select('*');
        $builder->join('users', 'users.id = user_details.id');
        $builder->where('user_details.id', $id);
        $query = $builder->get(1);

        // echo "<br> str ".$this->db->getLastQuery();exit;

        if ($query->getResult() != null) {
            return $query->getResultArray();
        } else {
            return null;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------



    //---------------------------------------------------CREATE LOGIN ACTIVITY LOG STARTS---------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function create_login_activity($id)
    {

        $builder = $this->db->table('login_activity');
        if ($builder->insert(["user_id" => $id])) {
            return 1;
        } else {
            return 0;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------


    //---------------------------------------------------GET LAST LOGIN ACTIVITY STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_login_activity($id)
    {

        $builder = $this->db->table('login_activity');
        $builder->where(['user_id' => $id]);
        $builder->orderBy('id', 'DESC');
        $query = $builder->get(1);

        if ($query->getResult() != null) {
            return $query->getResultArray();
        } else {
            return null;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------


    function booking_with_time_slot($booking_id)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*,time_slot.from');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->where(['booking.id' => $booking_id]);
        $query = $builder->get(1);
        
        if ($query->getResult() != null) {
            return $query->getResultArray();
        } else {
            return null;
        }
    }
    
    //---------------------------------------------------GET Search Results STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_search_results($keyword_id, $city, $current_lat, $current_lng, $users_id, $cat)
    {

        $builder = $this->db->table('sp_location');
        $builder->select('sp_location.*, user_details.*,sp_det.about_me,qualification,list_profession.id as profession_id,list_profession.name as profession,exp,GROUP_CONCAT(distinct language.name) as "languages_known", 
                      per_hour,per_day,min_charges,extra_charge,list_profession.category_id,list_profession.subcategory_id,fcm_token,
                      (3959 * acos (cos ( radians(' . $current_lat . ') ) * cos( radians( sp_location.latitude ) ) * cos( radians( sp_location.longitude ) - radians(' . $current_lng . ') )
                          + sin ( radians(' . $current_lat . ') ) * sin( radians( sp_location.latitude ) ) )) AS distance_miles');
        $builder->join('user_details', 'user_details.id = sp_location.users_id');
        $builder->join('users', 'users.users_id = user_details.id AND users.users_id = sp_location.users_id');
        $builder->join('sp_det', 'sp_det.users_id = sp_location.users_id AND sp_det.users_id = user_details.id');
        $builder->join('sp_skill', 'sp_skill.users_id = sp_location.users_id AND sp_skill.users_id = user_details.id');
        $builder->join('sp_qual', 'sp_qual.id = sp_det.qual_id');
        $builder->join('sp_profession', 'sp_profession.users_id = sp_location.users_id AND sp_profession.profession_id = sp_skill.profession_id');
        $builder->join('list_profession', 'list_profession.id = sp_profession.profession_id');
        $builder->join('tariff', 'tariff.users_id = sp_location.users_id AND tariff.users_id = user_details.id AND tariff.profession_id = sp_profession.profession_id');
        //$builder->join('subcategories', 'subcategories.id = list_profession.subcategory_id');
        $builder->join('sp_exp', 'sp_exp.id = sp_profession.exp_id');
        $builder->join('city', 'city.id = sp_location.city');
        $builder->join('user_lang_list', 'user_lang_list.users_id = sp_location.users_id');
        $builder->join('language', 'language.id = user_lang_list.language_id');
        $builder->where('sp_location.id in (select max(id) from sp_location where users_id != ' . $users_id . ' group by users_id)');
        $builder->where('users.online_status_id', 1);
        // if ($keyword_id > 0) {
        //     $builder->where('keywords_id', $keyword_id);
            
        // } else { //pick using subcat id
        //     $builder->where('list_profession.subcategory_id', $subcat_id);
        // }
        if(is_array($keyword_id)){
            $builder->whereIn('keywords_id', $keyword_id);
        }else{
            $builder->where('keywords_id', $keyword_id);
        }
        
        
        if($cat == 1){
                $builder->where("sp_location.latitude BETWEEN '".$current_lat-0.2."' AND '".$current_lat+0.2."'");
                $builder->where("sp_location.longitude BETWEEN '".$current_lng-0.2."' AND '".$current_lng+0.2."'");
            }
        
        $builder->where('sp_activated', 3);
        $builder->where('online_status_id', 1);
        $builder->groupBy("sp_location.users_id");
        $builder->orderBy("distance_miles", "ASC");
        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
      
    
//---------------------------------------------------GET Search Results STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_search_results_by_sp_id($current_lat, $current_lng, $profession_id, $sp_id, $cat)
    {

        $builder = $this->db->table('sp_location');
        $builder->select('sp_location.*, user_details.*,sp_det.about_me,qualification,list_profession.id as profession_id,list_profession.name as profession,exp,GROUP_CONCAT(distinct language.name) as "languages_known", 
                      per_hour,per_day,min_charges,extra_charge,list_profession.category_id,list_profession.subcategory_id,fcm_token,
                      (3959 * acos (cos ( radians(' . $current_lat . ') ) * cos( radians( sp_location.latitude ) ) * cos( radians( sp_location.longitude ) - radians(' . $current_lng . ') )
                          + sin ( radians(' . $current_lat . ') ) * sin( radians( sp_location.latitude ) ) )) AS distance_miles');
        $builder->join('user_details', 'user_details.id = sp_location.users_id');
        $builder->join('users', 'users.users_id = user_details.id AND users.users_id = sp_location.users_id');
        $builder->join('sp_det', 'sp_det.users_id = sp_location.users_id AND sp_det.users_id = user_details.id');
        $builder->join('sp_skill', 'sp_skill.users_id = sp_location.users_id AND sp_skill.users_id = user_details.id');
        $builder->join('sp_qual', 'sp_qual.id = sp_det.qual_id');
        $builder->join('sp_profession', 'sp_profession.users_id = sp_location.users_id AND sp_profession.profession_id = sp_skill.profession_id');
        $builder->join('list_profession', 'list_profession.id = sp_profession.profession_id');
        $builder->join('tariff', 'tariff.users_id = sp_location.users_id AND tariff.users_id = user_details.id AND tariff.profession_id = sp_profession.profession_id');
        //$builder->join('subcategories', 'subcategories.id = list_profession.subcategory_id');
        $builder->join('sp_exp', 'sp_exp.id = sp_profession.exp_id');
        $builder->join('city', 'city.id = sp_location.city');
        $builder->join('user_lang_list', 'user_lang_list.users_id = sp_location.users_id');
        $builder->join('language', 'language.id = user_lang_list.language_id');
        $builder->where('sp_location.id in (select max(id) from sp_location where users_id = ' . $sp_id . ' group by users_id)');
        $builder->where('users.online_status_id', 1);
        // if ($keyword_id > 0) {
        //     $builder->where('keywords_id', $keyword_id);
            
        // } else { //pick using subcat id
        //     $builder->where('list_profession.subcategory_id', $subcat_id);
        // }
        $builder->where('sp_profession.profession_id', $profession_id);
        
        // if($cat == 1){
        //         $builder->where("sp_location.latitude BETWEEN '".$current_lat-0.2."' AND '".$current_lat+0.2."'");
        //         $builder->where("sp_location.longitude BETWEEN '".$current_lng-0.2."' AND '".$current_lng+0.2."'");
        //     }
        
        $builder->where('sp_activated', 3);
        $builder->groupBy("sp_location.users_id");
        $builder->orderBy("distance_miles", "ASC");
        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
      

    //Get Keywords ID by search String

    function get_keyword_by_search_string($search_string)
    {
        $builder = $this->db->table('keywords');
        $builder->select('keywords.keyword,GROUP_CONCAT(DISTINCT keywords.id) AS id,GROUP_CONCAT(DISTINCT list_profession.subcategory_id) 
                            AS subcategory_id,GROUP_CONCAT(DISTINCT list_profession.category_id) AS category_id');
        $builder->join('list_profession','list_profession.id = keywords.profession_id');
        $builder->join('subcategories','subcategories.id = list_profession.subcategory_id');
        $builder->where("MATCH(keyword) AGAINST ('".$search_string."' IN NATURAL LANGUAGE MODE) OR 
        MATCH(list_profession.name) AGAINST ('".$search_string."' IN NATURAL LANGUAGE MODE) OR
        MATCH(subcategories.sub_name) AGAINST ('".$search_string."' IN NATURAL LANGUAGE MODE)");

        $builder->groupBy('list_profession.category_id');
        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    //Function Ends here       
    
      
    //Get Keywords ID by subcat_id

    function get_keyword_by_subcat_id($subcat_id)
    {
        $builder = $this->db->table('keywords');
        $builder->select('GROUP_CONCAT(DISTINCT keywords.keyword) as keyword,GROUP_CONCAT(DISTINCT keywords.id) AS id,GROUP_CONCAT(DISTINCT list_profession.subcategory_id) 
                            AS subcategory_id,GROUP_CONCAT(DISTINCT list_profession.category_id) AS category_id');
        $builder->join('list_profession','list_profession.id = keywords.profession_id');
        $builder->where("list_profession.subcategory_id",$subcat_id);
        $builder->groupBy('list_profession.category_id');
        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //Function to search Address by user ID
    //Returns address if available or else '0' if not available
    public function get_temp_address_by_user_id($id)
    {
        $builder = $this->db->table('user_temp_address');
        $builder->select('user_temp_address.id,user_temp_address.name,user_temp_address.flat_no,user_temp_address.apartment_name,
						user_temp_address.landmark,user_temp_address.locality,zipcode.zipcode,city.city,
						state.state,country.country');
        $builder->join('zipcode', 'user_temp_address.zipcode_id=zipcode.id');
        $builder->join('city', 'zipcode.city_id=city.id');
        $builder->join('state', 'city.state_id=state.id');
        $builder->join('country', 'state.country_id=country.id');
        $builder->where('users_id', $id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Search Results STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_search_results_by_city($city)
    {

        $builder = $this->db->table('sp_location');
        $builder->select('sp_location.*, user_details.*,users.online_status_id,sp_det.about_me,qualification,list_profession.name as profession,exp,
                      per_hour,per_day,min_charges,extra_charge');
        $builder->join('user_details', 'user_details.id = sp_location.users_id');
        $builder->join('users', 'users.users_id = user_details.id AND users.users_id = sp_location.users_id');
        $builder->join('sp_det', 'sp_det.users_id = sp_location.users_id AND sp_det.users_id = user_details.id');
        $builder->join('sp_skill', 'sp_skill.users_id = sp_location.users_id AND sp_skill.users_id = user_details.id');
        $builder->join('tariff', 'tariff.users_id = sp_location.users_id AND tariff.users_id = user_details.id');
        $builder->join('sp_qual', 'sp_qual.id = sp_det.qual_id');
        $builder->join('list_profession', 'list_profession.id = sp_det.profession_id');
        $builder->join('sp_exp', 'sp_exp.id = sp_det.exp_id');
        $builder->join('city', 'city.id = sp_location.city');
        $builder->where('sp_location.id in (select max(id) from sp_location group by users_id)');
        $builder->where('city.city', $city);
        $builder->where('sp_activated', 3);
        $builder->whereIn('online_status_id', [1, 2]);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET LAST LOGIN ACTIVITY STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_keywords_id($search_phrase_id, $subcat_id = 0)
    {
        $builder = $this->db->table('search_phrase');
        if ($search_phrase_id > 0) {
            $builder->where(['id' => $search_phrase_id]);
        } else {
            $builder->where(['phrase' => $search_phrase_id]);
        }

        if ($subcat_id > 0) {
            $builder->where(['subcategory_id' => $subcat_id]);
        }

        $builder->orderBy('id', 'DESC');
        $query = $builder->get(1);
        //echo "<br> str ".$this->db->getLastQuery();exit;
        if ($query->getResult() != null) {
            $result = $query->getResultArray();

            return $result[0]['keywords_id'];
        } else {
            //Create
            $data = array('phrase' => $search_phrase_id, 'keywords_id' => 0, 'subcategory_id' => $subcat_id);
            $builder->insert($data);

            //return $this->db->insertID();
            return 0;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    function get_sp_preferred_time_slot($ar_sp_id)
    {

        $builder = $this->db->table('user_time_slot');
        $builder->select('*');
        // $builder->select('users_id,time_slot_id,min(time_slot_from) as time_slot_from, max(time_slot_from) as time_slot_to,day_slot');
        if(is_array($ar_sp_id)){
            $builder->whereIn('users_id', $ar_sp_id);
        }else{
            $builder->where('users_id', $ar_sp_id);
        }
        
        // $builder->groupBy("users_id,day_slot");
        $builder->orderBy('users_id,day_slot,time_slot_from', 'ASC');
        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

 //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    function get_sp_blocked_time_slot($ar_sp_id)
    {

        $builder = $this->db->table('sp_busy_slot');
        $builder->join('time_slot', 'time_slot.id = sp_busy_slot.time_slot_id');
        if(is_array($ar_sp_id)){
            $builder->whereIn('users_id', $ar_sp_id);
        }else{
            $builder->where('users_id', $ar_sp_id);
        }
        $builder->where('date >=', date('Y-m-d'));
        $builder->orderBy('users_id,date,time_slot_id', 'ASC');
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    function get_sp_languages($ar_sp_id)
    {

        $builder = $this->db->table('user_lang_list');
        $builder->join('language', 'language.id = user_lang_list.language_id');
        $builder->whereIn('users_id', $ar_sp_id);
        $builder->orderBy('users_id,name', 'ASC');
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //---------------------------------------------------GET Booking Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_booking_details($booking_id, $users_id)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,user_details.profile_pic,fcm_token,
                    time_slot.from,estimate_type.name as estimate_type,SUM(extra_demand.amount) as extra_demand_total_amount,SUM(material_advance) as material_advance,
                    SUM(technician_charges) as technician_charges,SUM(expenditure_incurred) as expenditure_incurred,extra_demand.status as extra_demand_status,post_job.id as post_job_id, list_profession.name as profession');
        $builder->join('user_details', 'user_details.id = booking.users_id');
        $builder->join('users', 'users.users_id = booking.users_id');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->join('extra_demand', 'extra_demand.booking_id = booking.id', 'LEFT');
        $builder->join('post_job', 'post_job.booking_id = booking.id', 'LEFT');
        $builder->join('list_profession', 'list_profession.id = booking.profession_id', 'LEFT');
        $builder->where('booking.id', $booking_id);
        $builder->where('booking.users_id', $users_id);
        $builder->groupBy('booking.id');
        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result[0];
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Attachemnts STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_attachment_details($booking_id)
    {

        $builder = $this->db->table('attachments');
        $builder->where('attachments.booking_id', $booking_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Single move Booking Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_single_move_details($booking_id)
    {

        $builder = $this->db->table('single_move');
        $builder->select('single_move.id,single_move.address_id,single_move.job_description,address.locality,address.latitude,address.longitude,city,state,country,zipcode');
        $builder->join('address', 'address.id = single_move.address_id');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id');
        $builder->join('city', 'city.id = zipcode.city_id');
        $builder->join('state', 'state.id = city.state_id');
        $builder->join('country', 'country.id = state.country_id');
        $builder->where('single_move.booking_id', $booking_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Blue collar Booking Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_blue_collar_details($booking_id)
    {

        $builder = $this->db->table('blue_collar');
        $builder->where('booking_id', $booking_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Multi move Booking Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_multi_move_details($booking_id)
    {

        $builder = $this->db->table('multi_move');
        $builder->select('multi_move.id,multi_move.address_id,multi_move.sequence_no,job_description,weight_type,address.locality,address.latitude,address.longitude,city,state,country,zipcode');
        $builder->join('address', 'address.id = multi_move.address_id');
        $builder->join('country', 'country.id = address.country_id');
        $builder->join('state', 'state.id = address.state_id');
        $builder->join('city', 'city.id = address.city_id');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id');
        $builder->where('multi_move.booking_id', $booking_id);
        $builder->orderBy('sequence_no', 'ASC');
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET User Booking Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_user_booking_details($users_id)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,fcm_token,
                    time_slot.from,estimate_type.name as estimate_type');
        $builder->join('user_details', 'user_details.id = booking.sp_id');
        $builder->join('users', 'users.users_id = user_details.id');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->where('booking.users_id', $users_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //Function to get all Address 
    //Returns address if available or else '0' if not available
    public function get_all_addresses()
    {
        $builder = $this->db->table('address');
        $builder->select('address.id,address.name,address.flat_no,address.apartment_name,address.landmark,IF(address.locality IS NULL,"",address.locality) AS locality,zipcode.zipcode,
	                    latitude,longitude,city.city,state.state,country.country');
        $builder->join('zipcode', 'address.zipcode_id=zipcode.id');
        $builder->join('city', 'zipcode.city_id=city.id');
        $builder->join('state', 'city.state_id=state.id');
        $builder->join('country', 'state.country_id=country.id');
        $builder->groupBy("locality,latitude,longitude,address.city_id,address.zipcode_id");
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Search Results STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_search_phrase()
    {

        $builder = $this->db->table('search_phrase');
        $builder->select('search_phrase.*,subcategories.category_id');
        $builder->join('subcategories', 'subcategories.id = search_phrase.subcategory_id');
        $builder->orderBy('search_phrase.id', 'ASC');
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //---------------------------------------------------GET User Single Move Booking Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_user_single_move_booking_details($users_id = 0, $sp_id = 0)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*,user_details.fname,user_details.lname,user_details.mobile,
                    time_slot.from,estimate_type.name as estimate_type,single_move.job_description,address.locality,address.latitude,
                    address.longitude,city,state,country,zipcode,profile_pic,estimate_type.name as estimate_type,extra_demand.amount as extra_demand_total_amount,
                    material_advance,technician_charges,expenditure_incurred,fcm_token,(STR_TO_DATE(CONCAT(booking.scheduled_date, " ", time_slot.from), "%Y-%m-%d %H:%i:%s")) AS dateTime');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->join('single_move', 'single_move.booking_id = booking.id');
        $builder->join('address', 'address.id = single_move.address_id');
        $builder->join('country', 'country.id = address.country_id');
        $builder->join('state', 'state.id = address.state_id');
        $builder->join('city', 'city.id = address.city_id');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id');
        $builder->join('extra_demand', 'extra_demand.booking_id = booking.id', 'LEFT');
        $builder->join('transaction', 'transaction.booking_id = booking.id');
        $builder->whereIn('payment_status', ['Success','TXN_SUCCESS']);
        $builder->whereIn('name_id', [2,12]); //Booking Amount

        if ($users_id > 0) {
            $builder->join('user_details', 'user_details.id = booking.sp_id', 'LEFT');
            $builder->join('users', 'users.users_id = user_details.id', 'LEFT');
            $builder->where('booking.users_id', $users_id);
        }
        if ($sp_id > 0) {
            $builder->join('user_details', 'user_details.id = booking.users_id', 'LEFT');
            $builder->join('users', 'users.users_id = user_details.id', 'LEFT');
            $builder->where('booking.sp_id', $sp_id);
        }

        $builder->where('booking.category_id', 1);
        $builder->groupBy("transaction.booking_id");
        // $builder->groupBy('booking.id');
        $builder->orderBy('booking.completed_at', 'DESC');
        $builder->orderBy('dateTime', 'DESC');
        $builder->orderBy('created_on', 'DESC');

        // $builder->orderBy('booking.scheduled_date', 'DESC');
        // $builder->orderBy('booking.time_slot_id', 'ASC');

        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET User Blue Collar Booking Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_user_blue_collar_booking_details($users_id = 0, $sp_id = 0)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,
                    time_slot.from,estimate_type.name as estimate_type,blue_collar.job_description,profile_pic,estimate_type.name as estimate_type,
                    extra_demand.amount as extra_demand_total_amount,material_advance,technician_charges,expenditure_incurred,fcm_token');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->join('blue_collar', 'blue_collar.booking_id = booking.id');
        $builder->join('extra_demand', 'extra_demand.booking_id = booking.id', 'LEFT');
        $builder->join('transaction', 'transaction.booking_id = booking.id');
        if ($users_id > 0) {
            $builder->join('user_details', 'user_details.id = booking.sp_id', 'LEFT');
            $builder->join('users', 'users.users_id = user_details.id', 'LEFT');
            $builder->where('booking.users_id', $users_id);
        }
        if ($sp_id > 0) {
            $builder->join('user_details', 'user_details.id = booking.users_id', 'LEFT');
            $builder->join('users', 'users.users_id = user_details.id', 'LEFT');
            $builder->where('booking.sp_id', $sp_id);
        }
        $builder->where('booking.category_id', 2);
        $builder->whereIn('payment_status', ['Success','TXN_SUCCESS']);
        $builder->whereIn('name_id', [2,12]); //Booking Amount
        $builder->groupBy('booking.id');
        $builder->orderBy('booking.completed_at', 'DESC');
        $builder->orderBy('booking.scheduled_date', 'DESC');
        $builder->orderBy('booking.time_slot_id', 'ASC');

        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET User Multi Move Booking Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_user_multi_move_booking_details($users_id = 0, $sp_id = 0)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,
                    time_slot.from,estimate_type.name as estimate_type,multi_move.sequence_no,job_description,weight_type,address.locality,address.latitude,
                    address.longitude,city,state,country,zipcode,profile_pic,estimate_type.name as estimate_type,
                    extra_demand.amount as extra_demand_total_amount,material_advance,technician_charges,expenditure_incurred,fcm_token');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->join('multi_move', 'multi_move.booking_id = booking.id');
        $builder->join('address', 'address.id = multi_move.address_id');
        $builder->join('country', 'country.id = address.country_id');
        $builder->join('state', 'state.id = address.state_id');
        $builder->join('city', 'city.id = address.city_id');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id');
        $builder->join('extra_demand', 'extra_demand.booking_id = booking.id', 'LEFT');
        $builder->join('transaction', 'transaction.booking_id = booking.id');
        if ($users_id > 0) {
            $builder->join('user_details', 'user_details.id = booking.sp_id', 'LEFT');
            $builder->join('users', 'users.users_id = user_details.id', 'LEFT');
            $builder->where('booking.users_id', $users_id);
        }
        if ($sp_id > 0) {
            $builder->join('user_details', 'user_details.id = booking.users_id', 'LEFT');
            $builder->join('users', 'users.users_id = user_details.id', 'LEFT');
            $builder->where('booking.sp_id', $sp_id);
        }
        $builder->where('booking.category_id', 3);
        $builder->where('name_id', 2); //Booking Amount
        $builder->where('payment_status', 'Success');
        $builder->groupBy('booking.id');
        $builder->orderBy('booking.completed_at', 'DESC');
        $builder->orderBy('booking.scheduled_date', 'DESC');
        $builder->orderBy('booking.time_slot_id', 'ASC');

        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET User Transaction History STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_user_transaction_history($users_id)
    {

        $builder = $this->db->table('transaction');
        $builder->select('transaction.created_dts as dated,date,amount,reference_id,booking_id,payment_status,transaction_name.name as transaction_name,
                        transaction_methods.name as transaction_method,transaction_type.name as transaction_type');
        $builder->join('transaction_name', 'transaction_name.id = transaction.name_id');
        $builder->join('transaction_methods', 'transaction_methods.id = transaction.method_id');
        $builder->join('transaction_type', 'transaction_type.id = transaction.type_id');
        $builder->where('transaction.users_id', $users_id);
        $builder->orderBy('transaction.created_dts', 'DESC');
        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    // save user upi details
    function saveUserUpiDetails($users_id, $upi_id)
    {
        $data = array(
            'userId' => $users_id,
            'upi' => $upi_id,
        );
        $this->db->table('user_upi')->insert($data);
        return true;
    }
    // get list of user upi
    function getUserUpiDetails($users_id)
    {
        $result = $this->db->table('user_upi')->where('userId', $users_id)->get()->getResult();
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET SP Skills STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_skills($sp_id)
    {

        $builder = $this->db->table('sp_skill');
        $builder->select('sp_skill.keywords_id,keyword');
        $builder->join('keywords', 'keywords.id = sp_skill.keywords_id');
        $builder->where('sp_skill.users_id', $sp_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET SP Languages STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_lang($sp_id)
    {

        $builder = $this->db->table('user_lang_list');
        $builder->select('user_lang_list.language_id,name');
        $builder->join('language', 'language.id = user_lang_list.language_id');
        $builder->where('user_lang_list.users_id', $sp_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Offers list STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_offers_list($offer_type_id = 0, $sort_type = "")
    {

        $builder = $this->db->table('offer');
        $builder->select('offer.*,offer_type.name as offer_type_name,value_type.name as value_type_name');
        $builder->join('offer_type', 'offer_type.id = offer.offer_type_id');
        $builder->join('value_type', 'value_type.id = offer.value_type_id');
        $builder->where('offer.offer_type_id', $offer_type_id);
        if ($sort_type == "latest") {
            $builder->orderBy('created_dts', 'DESC');
        }
        if ($sort_type == "expiry") {
            $builder->where('valid_till >=', date('Y-m-d'));
            $builder->orderBy('valid_till', 'ASC');
        }

        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Offers Selection list STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_offers_selection_list($users_id, $sort_type = "")
    {

        $builder = $this->db->table('offer');
        $builder->select('offer.*,offer_type.name as offer_type_name,value_type.name as value_type_name');
        $builder->join('offer_type', 'offer_type.id = offer.offer_type_id');
        $builder->join('value_type', 'value_type.id = offer.value_type_id');
        $builder->join('offer_select_list', 'offer_select_list.offer_id = offer.id');
        $builder->where('offer.offer_type_id', 4); //Selected list
        $builder->where('offer_select_list.users_id', $users_id);
        if ($sort_type == "latest") {
            $builder->orderBy('created_dts', 'DESC');
        }
        if ($sort_type == "expiry") {
            $builder->where('valid_till >=', date('Y-m-d'));
            $builder->orderBy('valid_till', 'ASC');
        }
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Offers Location list STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_offers_location_list($location_type, $location_id, $sort_type = "")
    {

        $builder = $this->db->table('offer');
        $builder->select('offer.*,offer_type.name as offer_type_name,value_type.name as value_type_name');
        $builder->join('offer_type', 'offer_type.id = offer.offer_type_id');
        $builder->join('value_type', 'value_type.id = offer.value_type_id');
        $builder->join('offer_location_list', 'offer_location_list.offer_id = offer.id');
        $builder->where('offer.offer_type_id', 1);
        $builder->where('offer_location_list.location_type_id', $location_type);
        $builder->where('offer_location_list.location_id', $location_id);
        if ($sort_type == "latest") {
            $builder->orderBy('created_dts', 'DESC');
        }
        if ($sort_type == "expiry") {
            $builder->where('valid_till >=', date('Y-m-d'));
            $builder->orderBy('valid_till', 'ASC');
        }

        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET booking count STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_total_bookings($users_id)
    {
        $builder = $this->db->table('booking');
        $builder->select('count(id) as total_bookings');
        $builder->where('users_id', $users_id);
        $builder->where('sp_id > 0');
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);
        if ($count > 0) {
            return $result[0]['total_bookings'];
        } else {
            return 0;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET post job count STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_total_job_posts($users_id)
    {
        $builder = $this->db->table('post_job');
        $builder->select('count(post_job.id) as total_job_posts');
        $builder->join('booking', 'booking.id = post_job.booking_id');
        $builder->where('users_id', $users_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);
        if ($count > 0) {
            return $result[0]['total_job_posts'];
        } else {
            return 0;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Referrals count STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_total_referrals($users_id)
    {
        $builder = $this->db->table('referral');
        $builder->select('count(referral.id) as total_referrals');
        $builder->join('user_details', 'user_details.mobile = referral.referred_by');
        $builder->where('user_details.id', $users_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);
        if ($count > 0) {
            return $result[0]['total_referrals'];
        } else {
            return 0;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Booking Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_booking_work_summary($booking_id, $extra_demand)
    {

        if ($extra_demand == 1) {

            $builder = $this->db->table('booking');
            $builder->select('booking.*, wallet_balance.amount as w_balance, time_slot.from,estimate_type.name as estimate_type,extra_demand.amount as extra_demand_total_amount,extra_demand.status as extra_status,material_advance,technician_charges,expenditure_incurred');
            $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
            $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
            $builder->join('extra_demand', 'extra_demand.booking_id = booking.id', 'LEFT');
            $builder->join('transaction', 'transaction.booking_id = booking.id', 'LEFT');
            $builder->join('wallet_balance', 'wallet_balance.users_id = booking.users_id', 'LEFT');
            $builder->where('booking.id', $booking_id);
            $builder->whereIn('payment_status', ['Success','TXN_SUCCESS']);
            $builder->groupBy('booking.id');
            $result = $builder->get()->getResultArray();
            // echo "<br> str ".$this->db->getLastQuery();exit;    
            $count = count($result);

            if ($count > 0) {
                return $result[0];
            } else {
                return 'failure';
            }
        } elseif ($extra_demand == 0) {

            $builder = $this->db->table('booking');
            $builder->select('booking.*, time_slot.from,estimate_type.name as estimate_type, wallet_balance.amount as w_balance');
            $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
            $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
            $builder->join('transaction', 'transaction.booking_id = booking.id', 'LEFT');
            $builder->join('wallet_balance', 'wallet_balance.users_id = booking.users_id', 'LEFT');
            $builder->where('booking.id', $booking_id);
            $builder->whereIn('payment_status', ['Success','TXN_SUCCESS']);
            $builder->groupBy('booking.id');
            $result = $builder->get()->getResultArray();
            //echo "<br> str ".$this->db->getLastQuery();exit;    
            $count = count($result);

            if ($count > 0) {
                return $result[0];
            } else {
                return 'failure';
            }
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Booking Transaction History STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_booking_transaction_history($booking_id)
    {

        $builder = $this->db->table('transaction');
        $builder->select('date,amount,reference_id,booking_id,payment_status,transaction_name.name as transaction_name,
                        transaction_methods.name as transaction_method,transaction_type.name as transaction_type');
        $builder->join('transaction_name', 'transaction_name.id = transaction.name_id');
        $builder->join('transaction_methods', 'transaction_methods.id = transaction.method_id');
        $builder->join('transaction_type', 'transaction_type.id = transaction.type_id');
        $builder->where('transaction.booking_id', $booking_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Booking Status History STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_booking_status_list($booking_id)
    {

        $builder = $this->db->table('booking_status');
        $builder->select('*');
        $builder->join('booking_status_code', 'booking_status_code.id = booking_status.status_id');
        $builder->where('booking_id', $booking_id);
        $builder->WhereIn('status_id', [13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 37, 38, 39, 42]);
        // $builder->WhereIn('status_id', [13, 22, 23, 37, 38, 39]);
        $builder->orderBy('booking_status_id', 'ASC');
        // $builder->groupBy('status_id');
        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET sp booking count STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_total_sp_bookings($sp_id)
    {
        $builder = $this->db->table('booking');
        $builder->select('id,status_id');
        $builder->where('sp_id', $sp_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);
        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Total SP Reviews STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_reviews_list($sp_id)
    {

        $builder = $this->db->table('user_review');
        $builder->select('count(id) as total_review');
        $builder->where('sp_id', $sp_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);
        if ($count > 0) {
            return $result[0]['total_review'];
        } else {
            return 0;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET SP Reviews details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_reviews_details($sp_id)
    {
        $builder = $this->db->table('user_review');
        $builder->select('user_review.*,user_details.fname,user_details.lname,user_details.mobile,user_details.profile_pic');
        $builder->join('booking', 'booking.id = user_review.booking_id');
        $builder->join('user_details', 'user_details.id = booking.users_id');
        $builder->where('user_review.sp_id', $sp_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET user plan details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_user_plan_details($users_id)
    {
        $builder = $this->db->table('subs_plan');
        $builder->select('*');
        $builder->join('user_plans', 'user_plans.id = subs_plan.plans_id');
        $builder->where('users_id', $users_id);
        $builder->orderBy('subs_id', 'DESC');
        $builder->limit(1);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result[0];
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET sp plan details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_plan_details($users_id)
    {
        $builder = $this->db->table('sp_subs_plan');
        $builder->select('*');
        $builder->join('sp_plans', 'sp_plans.id = sp_subs_plan.plans_id');
        $builder->where('users_id', $users_id);
        $builder->orderBy('subs_id', 'DESC');
        $builder->limit(1);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result[0];
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET complaints details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_complaints_details($users_id)
    {
        $builder = $this->db->table('complaints');
        $builder->select('complaints.*,complaint_status.action_taken,complaint_status.status,complaint_status.created_on as complaint_status_date,
                        complaint_status.id as complaint_status_id,assigned_to');
        $builder->join('complaint_status', 'complaint_status.complaints_id = complaints.id', "LEFT");
        $builder->where('users_id', $users_id);
        $builder->where('complaints.id >', 0);
        $builder->orderBy('complaints.id', 'DESC');
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Request details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_request_details($users_id)
    {
        $builder = $this->db->table('withdraw_request');
        $builder->select('withdraw_request.*');
        $builder->join('transaction', 'transaction.id = withdraw_request.transaction_id');
        $builder->where('withdraw_request.users_id', $users_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_user_name_by_booking($booking_id = 0, $users_id = 0)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,user_details.profile_pic,fcm_token,post_job.title,points_count');
        $builder->join('user_details', 'user_details.id = booking.users_id');
        $builder->join('users', 'users.users_id = booking.users_id');
        $builder->join('post_job', 'post_job.booking_id = booking.id', 'LEFT');
        if ($booking_id > 0) {
            $builder->where('booking.id', $booking_id);
        }
        if ($users_id > 0) {
            $builder->where('booking.users_id', $users_id);
        }

        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result[0];
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_name_by_booking($booking_id = 0, $sp_id = 0)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,user_details.profile_pic,fcm_token,post_job.title,points_count');
        $builder->join('user_details', 'user_details.id = booking.sp_id');
        $builder->join('users', 'users.users_id = booking.sp_id');
        $builder->join('post_job', 'post_job.booking_id = booking.id', 'LEFT');
        if ($booking_id > 0) {
            $builder->where('booking.id', $booking_id);
        }
        if ($sp_id > 0) {
            $builder->where('users.users_id', $sp_id);
        }

        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result[0];
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_name_when_booking_sp_id_not_there($booking_id = 0, $sp_id = 0)
    {

        $builder = $this->db->table('users');
        $builder->select('users.fcm_token, booking.*, user_details.fname,user_details.lname,user_details.mobile,user_details.profile_pic,fcm_token,post_job.title,points_count');
        $builder->join('user_details', 'user_details.id = users.id');
        $builder->join('booking', 'booking.id = booking.sp_id');
        $builder->join('post_job', 'post_job.booking_id = booking.id', 'LEFT');
        if ($booking_id > 0) {
            $builder->where('booking.id', $booking_id);
        }
        if ($sp_id > 0) {
            $builder->where('users.users_id', $sp_id);
        }

        $result = $builder->get()->getResultArray();
        echo "<br> str " . $this->db->getLastQuery();
        exit;
        $count = count($result);

        if ($count > 0) {
            return $result[0];
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_user_name_by_post($post_job_id = 0, $users_id = 0)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,fcm_token,post_job.title');
        $builder->join('user_details', 'user_details.id = booking.users_id');
        $builder->join('users', 'users.users_id = booking.users_id');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        if ($post_job_id > 0) {
            $builder->where('post_job.id', $post_job_id);
        }
        if ($users_id > 0) {
            $builder->where('booking.users_id', $users_id);
        }

        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result[0];
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_name_by_post($post_job_id = 0, $sp_id = 0)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,fcm_token,post_job.title');
        $builder->join('user_details', 'user_details.id = booking.sp_id');
        $builder->join('users', 'users.users_id = booking.sp_id');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        if ($post_job_id > 0) {
            $builder->where('post_job.id', $post_job_id);
        }
        if ($sp_id > 0) {
            $builder->where('booking.sp_id', $sp_id);
        }

        $result = $builder->get()->getResultArray();
        echo "<br> str " . $this->db->getLastQuery();
        exit;
        $count = count($result);

        if ($count > 0) {
            return $result[0];
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //Function to check duplicate Address by user ID
    public function get_address_by_user_id($id, $locality, $latitude, $longitude, $city_id, $state_id, $country_id, $zipcode_id)
    {
        $builder = $this->db->table('address');
        $builder->select('*');
        $builder->where('locality', $locality);
        $builder->where('latitude', $latitude);
        $builder->where('longitude', $longitude);
        $builder->where('zipcode_id', $zipcode_id);
        $builder->where('city_id', $city_id);
        $builder->where('state_id', $state_id);
        $builder->where('country_id', $country_id);
        $builder->where('users_id', $id);
        $builder->limit(1);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_bank_details($users_id, $account_no)
    {
        $builder = $this->db->table('user_bank_details');
        $builder->select('*');
        $builder->where('users_id', $users_id);
        //$builder->where('account_name',$account_name);
        $builder->where('account_no', $account_no);
        //$builder->where('ifsc_code',$ifsc_code);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_keywords($keyword,$profession_id)
    {
        $builder = $this->db->table('keywords');
        $builder->select('*');
        $builder->where('keyword', $keyword);
        $builder->where('profession_id',$profession_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    //---------------------------------------------------GET Training Videos STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_training_videos($arr_subcategories_id)
    {

        $builder = $this->db->table('list_video');
        $builder->select('video_categories.name,description,list_video.*');
        $builder->join('video_categories', 'video_categories.id = list_video.video_categories_id');
        $builder->where('subcategories_id', 0);
        if (count($arr_subcategories_id) > 0) {
            $builder->orWhereIn('subcategories_id', $arr_subcategories_id);
        }
        $builder->orderBy("list_video.id", "DESC");
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------Get video watch STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_watched_videos($sp_id, $video_id = 0)
    {

        $builder = $this->db->table('video_watch');
        $builder->select('video_watch.*,video_categories.name,description,list_video.*');
        $builder->join('list_video', 'list_video.id = video_watch.list_videos_id');
        $builder->join('video_categories', 'video_categories.id = list_video.video_categories_id');
        $builder->where('users_id', $sp_id);
        if ($video_id > 0) {
            $builder->where('list_videos_id', $video_id);
        }
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET SP Profession category STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_prof_cat($sp_id)
    {

        $builder = $this->db->table('list_profession');
        $builder->select('list_profession.*');
        $builder->join('sp_profession', 'sp_profession.profession_id = list_profession.id');
        $builder->where('sp_profession.users_id', $sp_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    function get_sp_keywords($ar_sp_id)
    {

        $builder = $this->db->table('sp_skill');
        $builder->select('users_id, GROUP_CONCAT(distinct keyword) as keywords');
        $builder->join('keywords', 'keywords.id = sp_skill.keywords_id');
        if(is_array($ar_sp_id)){
            $builder->whereIn('users_id', $ar_sp_id);
        }else{
            $builder->where('users_id', $ar_sp_id);
        }
        
        $builder->groupBy("sp_skill.users_id");
        $builder->orderBy('users_id', 'ASC');
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }



    function get_sp_preferred_day_time_slot($sp_id)
    {

        $builder = $this->db->table('user_time_slot');
        $builder->select('users_id,time_slot_id,min(time_slot_from) as time_slot_from, max(time_slot_from) time_slot_to,day_slot');
        $builder->where('users_id', $sp_id);
        $builder->groupBy("day_slot");
        $builder->orderBy('day_slot', 'ASC');
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //---------------------------------------------------GET Leaderboard details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_leaderboard_details($city, $sp_id)
    {

        $sp_details = $this->get_sp_location_profession($sp_id);

        if ($sp_details != 'failure') {
            foreach ($sp_details as $key => $dat) {
                $sp_city[$key] = $dat['city'];
                $sp_profession[$key] = $dat['id'];
            }
        } else {
            $sp_profession = ['0', '0'];
        }

        $builder = $this->db->table('sp_location');
        $builder->select('sp_location.*,user_details.fname,user_details.lname,GROUP_CONCAT(DISTINCT list_profession.name) as profession,user_details.profile_pic,user_details.points_count');
        $builder->join('sp_profession', 'sp_profession.users_id = sp_location.users_id');
        $builder->join('list_profession', 'list_profession.id = sp_profession.profession_id');
        $builder->join('user_details', 'user_details.id = sp_profession.users_id');
        $builder->join('users', 'users.id = sp_profession.users_id');
        // $builder->whereIn('sp_location.city', $sp_city);
        $builder->where('sp_location.city', $city);
        $builder->whereIn('sp_profession.profession_id', $sp_profession);
        $builder->where('sp_activated', 3);
        $builder->groupBy("sp_location.users_id");
        $builder->orderBy("points_count", "DESC");
        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;

        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_leaderboard_details($sp_id)
    {

        $sp_details = $this->get_sp_location_profession($sp_id);

        if ($sp_details != 'failure') {
            foreach ($sp_details as $key => $dat) {
                $sp_city[$key] = $dat['city'];
                $sp_profession[$key] = $dat['id'];
            }
        } else {
            $sp_profession = 0;
        }

        $builder = $this->db->table('sp_location');
        $builder->select('sp_location.*,user_details.fname,user_details.lname,GROUP_CONCAT(DISTINCT list_profession.name) as profession,user_details.profile_pic,user_details.points_count');
        $builder->join('sp_profession', 'sp_profession.users_id = sp_location.users_id');
        $builder->join('list_profession', 'list_profession.id = sp_profession.profession_id');
        $builder->join('user_details', 'user_details.id = sp_profession.users_id');
        $builder->join('users', 'users.id = sp_profession.users_id');
        $builder->whereIn('sp_location.city', $sp_city);
        $builder->whereIn('sp_profession.profession_id', $sp_profession);
        $builder->where('sp_activated', 3);
        $builder->groupBy("sp_location.users_id");
        $builder->orderBy("points_count", "DESC");
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;

        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    //-----------------------------------------------------------GET SP PROFESSION AND LOCATION ------------------------------------------------------------    
    public function get_sp_location_profession($sp_id)
    {

        $builder = $this->db->table('sp_location');
        $builder->select('sp_location.city,list_profession.name,list_profession.id');
        $builder->join('sp_profession', 'sp_profession.users_id = sp_location.users_id');
        $builder->join('list_profession', 'list_profession.id = sp_profession.profession_id');
        $builder->where('sp_location.users_id', $sp_id);
        $builder->groupBy('list_profession.name');
        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery(); Exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_review_data($arr_sp_id)
    {

        $builder = $this->db->table('user_review');
        $builder->select('sum(average_review) as sum_average_review,count(id) as total_people,sp_id,AVG(professionalism) as avg_professionalism, 
        AVG(skill) as avg_skill, 
        AVG(behaviour) as avg_behaviour, 
        AVG(satisfaction) as avg_satisfaction');
        
        if(is_array($arr_sp_id)){
            $builder->whereIn('sp_id', $arr_sp_id);
        }else{
            $builder->where('sp_id', $arr_sp_id);
        }
        
        $builder->groupBy("sp_id");
        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_booking_count($sp_id)
    {

        $arr = [
            8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 31, 32, 33, 34, 35, 36, 37, 38, 39, 41
        ];

        $builder = $this->db->table('booking');
        $builder->select('count(id) as booking_count');
        $builder->where('sp_id', $sp_id);
        // $builder->where('status_id >=', 9);
        // $builder->where('status_id <=', 25);
        $builder->whereIn('status_id', $arr);
        $builder->groupBy("sp_id");
        $result = $builder->get()->getResultArray();
        //  echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result[0]['booking_count'];
        } else {
            return 0;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_booking_completed($sp_id)
    {

        $builder = $this->db->table('booking');
        $builder->select('count(id) as booking_completed,sum(amount) as amount');
        $builder->where('sp_id', $sp_id);
        $builder->whereIn('status_id', [22, 23]);
        $builder->groupBy("sp_id");
        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result[0];
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_bids_count($sp_id)
    {

        $builder = $this->db->table('bid_det');
        $builder->select('count(id) as bids_count');
        $builder->where('users_id', $sp_id);
        $builder->groupBy("users_id");
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result[0]['bids_count'];
        } else {
            return 0;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_bids_awarded($sp_id)
    {

        $builder = $this->db->table('bid_det');
        $builder->select('count(id) as bids_awarded');
        $builder->where('users_id', $sp_id);
        $builder->where('status_id', 27); //Awarded
        $builder->groupBy("users_id");
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result[0]['bids_awarded'];
        } else {
            return 0;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET User Single Move Booking Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_user_upcoming_single_move_booking_details($users_id = 0, $sp_id = 0)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,
                    time_slot.from,estimate_type.name as estimate_type,single_move.job_description,address.locality,address.latitude,
                    address.longitude,city,state,country,zipcode,profile_pic,estimate_type.name as estimate_type,extra_demand.amount as extra_demand_total_amount,
                    material_advance,technician_charges,expenditure_incurred');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->join('single_move', 'single_move.booking_id = booking.id');
        $builder->join('address', 'address.id = single_move.address_id');
        $builder->join('country', 'country.id = address.country_id');
        $builder->join('state', 'state.id = address.state_id');
        $builder->join('city', 'city.id = address.city_id');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id');
        $builder->join('extra_demand', 'extra_demand.booking_id = booking.id', 'LEFT');
        $builder->join('transaction', 'transaction.booking_id = booking.id');
        $builder->where('payment_status', 'Success');
        $builder->where('name_id', 2); //Booking Amount
        $builder->where('started_at', '0000-00-00 00:00:00');
        $builder->where('completed_at', '0000-00-00 00:00:00');
        $builder->where('scheduled_date > ', date('Y-m-d'));

        if ($sp_id > 0) {
            $builder->join('user_details', 'user_details.id = booking.users_id', 'LEFT');
            $builder->where('booking.sp_id', $sp_id);
        }
        $builder->where('booking.category_id', 1);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET User Blue Collar Booking Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_user_upcoming_blue_collar_booking_details($users_id = 0, $sp_id = 0)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,
                    time_slot.from,estimate_type.name as estimate_type,blue_collar.job_description,profile_pic,estimate_type.name as estimate_type,
                    extra_demand.amount as extra_demand_total_amount,material_advance,technician_charges,expenditure_incurred');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->join('blue_collar', 'blue_collar.booking_id = booking.id');
        $builder->join('extra_demand', 'extra_demand.booking_id = booking.id', 'LEFT');
        $builder->join('transaction', 'transaction.booking_id = booking.id');
        if ($sp_id > 0) {
            $builder->join('user_details', 'user_details.id = booking.users_id', 'LEFT');
            $builder->where('booking.sp_id', $sp_id);
            $builder->where('started_at', '0000-00-00 00:00:00');
            $builder->where('completed_at', '0000-00-00 00:00:00');
            $builder->where('scheduled_date > ', date('Y-m-d H:i:s'));
        }
        $builder->where('booking.category_id', 2);
        $builder->where('payment_status', 'Success');
        $builder->where('name_id', 2); //Booking Amount
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET User Multi Move Booking Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_user_upcoming_multi_move_booking_details($users_id = 0, $sp_id = 0)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,
                    time_slot.from,estimate_type.name as estimate_type,multi_move.sequence_no,job_description,weight_type,address.locality,address.latitude,
                    address.longitude,city,state,country,zipcode,profile_pic,estimate_type.name as estimate_type,
                    extra_demand.amount as extra_demand_total_amount,material_advance,technician_charges,expenditure_incurred');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->join('multi_move', 'multi_move.booking_id = booking.id');
        $builder->join('address', 'address.id = multi_move.address_id');
        $builder->join('country', 'country.id = address.country_id');
        $builder->join('state', 'state.id = address.state_id');
        $builder->join('city', 'city.id = address.city_id');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id');
        $builder->join('extra_demand', 'extra_demand.booking_id = booking.id', 'LEFT');
        $builder->join('transaction', 'transaction.booking_id = booking.id');
        if ($sp_id > 0) {
            $builder->join('user_details', 'user_details.id = booking.users_id', 'LEFT');
            $builder->where('booking.sp_id', $sp_id);
            $builder->where('started_at', '0000-00-00 00:00:00');
            $builder->where('completed_at', '0000-00-00 00:00:00');
            $builder->where('scheduled_date > ', date('Y-m-d H:i:s'));
        }
        $builder->where('booking.category_id', 3);
        $builder->where('name_id', 2); //Booking Amount
        $builder->where('payment_status', 'Success');
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;    
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
   
   
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    function get_sp_search_ranking_details($city_id, $keyword_id = 0, $subcat_id = 0)
    {

        $builder = $this->db->table('sp_location');
        $builder->select('sp_location.*, user_details.*,city.city,users.online_status_id,GROUP_CONCAT(list_profession.name) as profession');
        $builder->join('user_details', 'user_details.id = sp_location.users_id');
        $builder->join('users', 'users.users_id = user_details.id AND users.users_id = sp_location.users_id');
        $builder->join('sp_profession', 'sp_profession.users_id = sp_location.users_id');
        $builder->join('list_profession', 'list_profession.id = sp_profession.profession_id');
        $builder->join('city', 'city.id = sp_location.city');
        $builder->join('sp_skill', 'sp_skill.users_id = sp_location.users_id AND sp_skill.users_id = user_details.id');
        $builder->where('sp_location.id in (select max(id) from sp_location group by users_id)');
        $builder->where('city.id', $city_id);
        $builder->where('sp_activated', 3);
        $builder->where('points_count >', 0);
        // if ($keyword_id > 0) {
            $builder->whereIn('keywords_id', $keyword_id);
        // } else { //pick using subcat id
        //     $builder->where('list_profession.subcategory_id', $subcat_id);
        // }
        $builder->groupBy("sp_location.users_id");
        $builder->orderBy("points_count", "DESC");
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //-----------------------------------------------------------***************------------------------------------------------------------ 

     //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
     function get_sp_search_ranking_details_by_profession($city_id, $profession_id)
     {
 
         $builder = $this->db->table('sp_location');
         $builder->select('sp_location.*, user_details.*,city.city,users.online_status_id,GROUP_CONCAT(list_profession.name) as profession');
         $builder->join('user_details', 'user_details.id = sp_location.users_id');
         $builder->join('users', 'users.users_id = user_details.id AND users.users_id = sp_location.users_id');
         $builder->join('sp_profession', 'sp_profession.users_id = sp_location.users_id');
         $builder->join('list_profession', 'list_profession.id = sp_profession.profession_id');
         $builder->join('city', 'city.id = sp_location.city');
         $builder->join('sp_skill', 'sp_skill.users_id = sp_location.users_id AND sp_skill.users_id = user_details.id');
         $builder->where('sp_location.id in (select max(id) from sp_location group by users_id)');
         $builder->where('city.id', $city_id);
         $builder->where('sp_activated', 3);
         $builder->where('points_count >', 0);
         // if ($keyword_id > 0) {
         $builder->where('sp_profession.profession_id', $profession_id);
         // } else { //pick using subcat id
         //     $builder->where('list_profession.subcategory_id', $subcat_id);
         // }
         $builder->groupBy("sp_location.users_id");
         $builder->orderBy("points_count", "DESC");
         $result = $builder->get()->getResultArray();
        //  echo "<br> str ".$this->db->getLastQuery();exit;
         $count = count($result);
 
         if ($count > 0) {
             return $result;
         } else {
             return 'failure';
         }
     }
     //-----------------------------------------------------------***************------------------------------------------------------------ 

    function get_successful_transactions($booking_id)
    {

        $builder = $this->db->table('transaction');
        $builder->select('*');
        $builder->where('booking_id', $booking_id);
        $builder->where('payment_status', 'Success');
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result[0];
        } else {
            return 'failure';
        }
    }

    //-----------------------------------------------------------***************------------------------------------------------------------    

    function get_temp_address($lat,$long,$user_id){

        $builder = $this->db->table('user_temp_address');
        $builder->select('*');
        $builder->where('users_id',$user_id);
        $builder->where('latitude',$lat);
        $builder->where('longitude',$long);
        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result[0];
        } else {
            return 'failure';
        }
    }
    
    //-----------------------------------------------------------***************------------------------------------------------------------    

    function get_sp_jobs_booking_completed($arr_sp_id)
    {

        $builder = $this->db->table('booking');
        $builder->select('count(booking.id) as jobs_count,sp_id');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        if(is_array($arr_sp_id)){
            $builder->whereIn('sp_id', $arr_sp_id);
        }else{
            $builder->where('sp_id', $arr_sp_id);
        }        
        $builder->where('completed_at != "0000-00-00 00:00:00"');
        $builder->groupBy("sp_id");
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------


    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_tariff($sp_id, $category_id)
    {

        $builder = $this->db->table('tariff');
        $builder->select('*');
        $builder->join('list_profession', 'list_profession.id = tariff.profession_id');
        $builder->where('category_id', $category_id);
        $builder->where('users_id', $sp_id);

        $result = $builder->get()->getResultArray();
        //echo "".$this->db->getLastQuery();exit;

        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    //---------------------------------------------------Get User Details by booking_id STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    

    public function get_user_details_by_booking_id($booking_id)
    {

        $builder = $this->db->table('booking');
        $builder->select('*');
        $builder->join('user_details', 'user_details.id = booking.users_id');
        $builder->where('booking.id', $booking_id);

        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------


    //---------------------------------------------------Get SP Details by booking_id STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    

    public function get_sp_details_by_booking_id($booking_id)
    {

        $builder = $this->db->table('booking');
        $builder->select('*');
        $builder->join('user_details', 'user_details.id = booking.sp_id');
        $builder->where('booking.id', $booking_id);

        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    //---------------------------------------------------Get Commission by User ID-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    

    public function get_commission($user_id,$str_date = Null,$end_date=Null)
    {

        $where = ['users_id' => $user_id, 'method_id' => 3, 'type_id' => 1, 'name_id' => 13];
        $builder = $this->db->table('transaction');
        $builder->select('sum(amount) as amount');
        $builder->where($where);
        if($str_date != Null && $end_date != Null){
        $builder->where("date BETWEEN '".$str_date."' AND '".$end_date."'");    
        }
        $builder->groupBy('users_id');

        $result = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;

        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }


    //---------------------------------------------------Check Whether Post is Eligible to submit by User-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------------------------    

    public function check_post_and_user($user_id, $post_job_id)
    {

        $where = "(post_job_id = $post_job_id AND users_id = $user_id) OR (post_job_id = $post_job_id AND post_job.status_id != 26)";
        $builder = $this->db->table('bid_det');
        $builder->select('COUNT("bid_det.id") as count');
        $builder->join('post_job', 'post_job.id = bid_det.post_job_id');
        $builder->where($where);

        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;

        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    //---------------------------------------------------Mark Other Bids Not Approved on Award of Job-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------------------------    

    public function mark_other_bids_expired($booking_id, $bid_id)
    {

        $sql = "UPDATE bid_det 
        INNER JOIN  
        post_job  
        ON post_job.id = bid_det.post_job_id
        SET bid_det.status_id = 43
        WHERE post_job.booking_id = $booking_id AND bid_det.id != $bid_id";

        $this->db->query($sql);
        // echo "<br> str ".$this->db->getLastQuery();exit;

    }

    //---------------------------------------------------View Attachments with Status-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------------------------ 
    public function get_attachments($booking_id, $user_id, $sp_id){

        $builder = $this->db->table('attachments');
        $builder->select('attachments.*,booking_status_code.name as file_status');
        $builder->join('booking_status_code', 'booking_status_code.id = attachments.status_id');
        $builder->where('booking_id',$booking_id);
        $builder->whereIn('created_by',[$user_id,$sp_id]);
        $builder->orderBy('created_on','ASC');

        $res = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;

        if(isset($res) && count($res) > 0){
            return $res;
        }else{
            return 'failure';
        }

    }


    //---------------------------------------------------View cities of user----------------------------------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------------------------ 
    public function get_cities_by_user($user_id){

        $builder = $this->db->table('sp_location');
        $builder->select('city.id,city.city,sp_location.state as state_id');
        $builder->join('city', 'city.id = sp_location.city');
        $builder->where('users_id',$user_id);
        $builder->groupBy('sp_location.city');
        
        $res = $builder->get()->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;

        if(isset($res) && count($res) > 0){
            return $res;
        }else{
            return 'failure';
        }

    }    


    

    
}
