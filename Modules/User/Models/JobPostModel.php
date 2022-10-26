<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class JobPostModel extends Model
{

    //---------------------------------------------------GET User Single Move Job Post Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_user_single_move_job_post_details($users_id)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*,booking.id as booking_id, post_job.*,post_job.id as post_job_id,booking_status_code.name as status,bid_range.name as bid_range_name,range_slots,
                    user_details.fname,user_details.lname,user_details.mobile,
                    time_slot.from,estimate_type.name as estimate_type,single_move.job_description,address.locality,address.latitude,
                    address.longitude,city,state,country,zipcode,profile_pic');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        $builder->join('bid_range', 'bid_range.bid_range_id = post_job.bid_range_id');
        $builder->join('booking_status_code', 'booking_status_code.id = post_job.status_id');
        $builder->join('user_details', 'user_details.id = booking.sp_id', 'LEFT');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->join('single_move', 'single_move.booking_id = booking.id');
        $builder->join('address', 'address.id = single_move.address_id');
        $builder->join('country', 'country.id = address.country_id', 'LEFT');
        $builder->join('state', 'state.id = address.state_id', 'LEFT');
        $builder->join('city', 'city.id = address.city_id', 'LEFT');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id', 'LEFT');
        $builder->where('booking.users_id', $users_id);
        $builder->where('booking.category_id', 1);
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
    function get_user_blue_collar_job_post_details($users_id)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*,booking.id as booking_id, post_job.*,post_job.id as post_job_id,booking_status_code.name as status,bid_range.name as bid_range_name,range_slots,
                    user_details.fname,user_details.lname,user_details.mobile,
                    time_slot.from,estimate_type.name as estimate_type,blue_collar.job_description,profile_pic');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        $builder->join('bid_range', 'bid_range.bid_range_id = post_job.bid_range_id');
        $builder->join('booking_status_code', 'booking_status_code.id = post_job.status_id');
        $builder->join('user_details', 'user_details.id = booking.sp_id', 'LEFT');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->join('blue_collar', 'blue_collar.booking_id = booking.id');
        $builder->where('booking.users_id', $users_id);
        $builder->where('booking.category_id', 2);
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
    //---------------------------------------------------GET User Multi Move Job Post Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_user_multi_move_job_post_details($users_id)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*,booking.id as booking_id, post_job.*,post_job.id as post_job_id,booking_status_code.name as status,bid_range.name as bid_range_name,range_slots,
                    user_details.fname,user_details.lname,user_details.mobile,
                    time_slot.from,estimate_type.name as estimate_type,multi_move.sequence_no,job_description,weight_type,address.locality,address.latitude,
                    address.longitude,city,state,country,zipcode,profile_pic');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        $builder->join('bid_range', 'bid_range.bid_range_id = post_job.bid_range_id');
        $builder->join('booking_status_code', 'booking_status_code.id = post_job.status_id');
        $builder->join('user_details', 'user_details.id = booking.sp_id', 'LEFT');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->join('multi_move', 'multi_move.booking_id = booking.id');
        $builder->join('address', 'address.id = multi_move.address_id');
        $builder->join('country', 'country.id = address.country_id', 'LEFT');
        $builder->join('state', 'state.id = address.state_id', 'LEFT');
        $builder->join('city', 'city.id = address.city_id', 'LEFT');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id', 'LEFT');
        $builder->where('booking.users_id', $users_id);
        $builder->where('booking.category_id', 3);
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
    //---------------------------------------------------GET Job Post Bid Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_bid_details($users_id, $post_job_id = 0)
    {

        $builder = $this->db->table('bid_det');
        $builder->select('bid_det.*');
        $builder->join('post_job', 'post_job.id = bid_det.post_job_id');
        $builder->join('booking', 'booking.id = post_job.booking_id');
        $builder->where('booking.users_id', $users_id);
        if ($post_job_id > 0) {
            $builder->where('bid_det.post_job_id', $post_job_id);
        }
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
    //---------------------------------------------------GET Job Post Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_details($booking_id, $post_job_id, $users_id)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, post_job.*,post_job.id as post_job_id,booking_status_code.name as status,bid_range.name as bid_range_name,range_slots,
                    user_details.fname,user_details.lname,user_details.mobile,fcm_token,
                    time_slot.from,estimate_type.name as estimate_type');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        $builder->join('bid_range', 'bid_range.bid_range_id = post_job.bid_range_id');
        $builder->join('booking_status_code', 'booking_status_code.id = post_job.status_id');
        $builder->join('user_details', 'user_details.id = booking.users_id');
        $builder->join('users', 'users.users_id = booking.users_id');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->where('booking.id', $booking_id);
        $builder->where('post_job.id', $post_job_id);
        // $builder->where('booking.users_id', $users_id);
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
    //---------------------------------------------------GET Job post keywords STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_keywords($post_job_id)
    {

        $builder = $this->db->table('post_req_keyword');
        $builder->select('post_req_keyword.keywords_id,keyword');
        $builder->join('keywords', 'keywords.id = post_req_keyword.keywords_id');
        $builder->where('post_job_id', $post_job_id);
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
    //---------------------------------------------------GET Job post language STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_language($post_job_id)
    {

        $builder = $this->db->table('post_req_lang');
        $builder->select('post_req_lang.language_id,name');
        $builder->join('language', 'language.id = post_req_lang.language_id');
        $builder->where('post_job_id', $post_job_id);
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
    //---------------------------------------------------GET Job Post Bid Details by post id STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_bid_details_by_jobpost_id($post_job_id)
    {

        $builder = $this->db->table('bid_det');
        $builder->select('bid_det.*,booking_status_code.name as status, estimate_type.name,user_details.fname,user_details.lname,
                            user_details.mobile,fcm_token,profile_pic,sp_det.about_me,booking.users_id as posted_by_id');
        $builder->join('estimate_type', 'estimate_type.id = bid_det.estimate_type_id');
        $builder->join('user_details', 'user_details.id = bid_det.users_id');
        $builder->join('users', 'users.users_id = bid_det.users_id');
        $builder->join('sp_det', 'sp_det.users_id = bid_det.users_id AND sp_det.users_id = user_details.id');
        $builder->join('booking_status_code', 'booking_status_code.id = bid_det.status_id');
        $builder->join('post_job', 'post_job.id = bid_det.post_job_id');
        $builder->join('booking', 'booking.id = post_job.booking_id');
        $builder->where('bid_det.post_job_id', $post_job_id);
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
    //---------------------------------------------------GET Job Post Bid Data-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_bid_details($bid_id, $sp_id)
    {

        $builder = $this->db->table('bid_det');
        $builder->select('bid_det.*,estimate_type.name as estimate_type,user_details.fname,user_details.lname,user_details.mobile,fcm_token,profile_pic,gender,
    ,sp_det.about_me,qualification,GROUP_CONCAT( DISTINCT list_profession.name) as profession, exp, post_job.title, GROUP_CONCAT( DISTINCT language.name)as name, 
    CONCAT(city.city,", ",state.state) as sp_address');
        $builder->join('post_job', 'post_job.id = bid_det.post_job_id');
        $builder->join('post_req_keyword', 'post_req_keyword.post_job_id = post_job.id');
        $builder->join('keywords', 'keywords.id = post_req_keyword.keywords_id');
        $builder->join('estimate_type', 'estimate_type.id = bid_det.estimate_type_id');
        $builder->join('user_details', 'user_details.id = bid_det.users_id');
        $builder->join('users', 'users.users_id = bid_det.users_id');
        $builder->join('sp_det', 'sp_det.users_id = bid_det.users_id AND sp_det.users_id = user_details.id');
        $builder->join('sp_qual', 'sp_qual.id = sp_det.qual_id');
        $builder->join('sp_profession', 'sp_profession.users_id = bid_det.users_id');
        $builder->join('list_profession', 'list_profession.id = sp_profession.profession_id AND list_profession.id = keywords.profession_id');
        $builder->join('sp_exp', 'sp_exp.id = sp_profession.exp_id');
        $builder->join('user_lang_list', 'user_lang_list.users_id = bid_det.users_id');
        $builder->join('language', 'language.id = user_lang_list.language_id');
        $builder->join('sp_location', 'sp_location.users_id = bid_det.users_id');
        $builder->join('city', 'city.id = sp_location.city');
        $builder->join('state', 'state.id = sp_location.state');
        $builder->join('country', 'country.id = sp_location.country');
        $builder->where('bid_det.id', $bid_id);
        $builder->where('bid_det.users_id', $sp_id);
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
    //---------------------------------------------------GET Bid Attachemnts STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_bid_attachment_details($bid_id)
    {

        $builder = $this->db->table('post_attach');
        $builder->where('post_attach.bid_id', $bid_id);
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
    //---------------------------------------------------GET SP jobs completed STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_jobs_completed_count($sp_id)
    {
        $builder = $this->db->table('booking');
        $builder->select('count(booking.id) as jobs_completed');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        $builder->where('booking.sp_id', $sp_id);
        $builder->where('completed_at != ', '0000-00-00 00:00:00');
        $builder->where('started_at != ', '0000-00-00 00:00:00');
        $builder->where('post_job.status_id', 27); //Awarded
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result[0]['jobs_completed'];
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET SP jobs completed by job post id STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_jobs_completed_count_by_jobpost_id($post_job_id)
    {
        $builder = $this->db->table('bid_det');
        $builder->select('bid_det.users_id,count(booking.id) as jobs_completed,title');
        $builder->join('post_job', 'post_job.id = bid_det.post_job_id');
        $builder->join('booking', 'booking.id = post_job.booking_id');
        $builder->where('post_job_id', $post_job_id);
        $builder->where('completed_at != ', '0000-00-00 00:00:00');
        $builder->where('started_at != ', '0000-00-00 00:00:00');
        $builder->where('post_job.status_id', 27); //Awarded
        $builder->groupBy('bid_det.users_id');
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
    //---------------------------------------------------GET Discussion Details by post id STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_discussion_details_by_jobpost_id($post_job_id)
    {

        $builder = $this->db->table('discussion_tbl');
        $builder->select('discussion_tbl.* ,user_details.fname,user_details.lname,user_details.mobile,,profile_pic,file_name');
        $builder->join('user_details', 'user_details.id = discussion_tbl.users_id');
        $builder->join('post_attach_disc_chat', 'post_attach_disc_chat.disc_id = discussion_tbl.id', 'LEFT');
        $builder->where('discussion_tbl.post_job_id', $post_job_id);
        $builder->orderBy('discussion_tbl.id');
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
    //---------------------------------------------------GET Discussion like count STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_discussion_like_count($discussion_tbl_id)
    {
        $builder = $this->db->table('disc_like');
        $builder->select('count(disc_like.disc_like_id) as like_count');
        $builder->where('discussion_tbl_id', $discussion_tbl_id);
        $result = $builder->get()->getResultArray();
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result[0]['like_count'];
        } else {
            return 0;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Job Post Bid Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_goals_installments_list($post_job_id)
    {

        $builder = $this->db->table('installment_det');
        $builder->select('installment_det.*,description, booking_status_code.name as status, inst_status_id as status_id');
        $builder->join('goals', 'goals.goal_id = installment_det.goal_id');
        $builder->join('booking_status_code', 'booking_status_code.id = installment_det.inst_status_id');
        $builder->whereIn('installment_det.inst_status_id', ['32','33','34','35','36']);
        $builder->where('installment_det.post_job_id', $post_job_id);
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
    //---------------------------------------------------GET Job Post Bid Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_goals_installments_requested_list($post_job_id)
    {

        $builder = $this->db->table('installment_det');
        $builder->select('installment_det.*');
        $builder->join('goals', 'goals.goal_id = installment_det.goal_id');
        // $builder->where('installment_det.inst_paid_status', 'Paid');
        $builder->where('installment_det.post_job_id', $post_job_id);
        $builder->where('installment_det.inst_status_id', 33); //Request Installment
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
    //---------------------------------------------------GET SP jobs completed by sp id STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_jobs_completed_count_by_sp_id($sp_id)
    {
        $builder = $this->db->table('bid_det');
        $builder->select('bid_det.users_id,count(booking.id) as jobs_completed');
        $builder->join('post_job', 'post_job.id = bid_det.post_job_id');
        $builder->join('booking', 'booking.id = post_job.booking_id');
        $builder->where('bid_det.users_id', $sp_id);
        $builder->where('completed_at != ', '0000-00-00 00:00:00');
        $builder->where('started_at != ', '0000-00-00 00:00:00');
        $builder->where('post_job.status_id', 27); //Awarded
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
    //---------------------------------------------------GET Job Post Details by sp id STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_details_by_sp_id($sp_id, $category_id)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, post_job.*,post_job.id as post_job_id,booking_status_code.name as status,bid_range.name as bid_range_name,range_slots,
                    user_details.fname,user_details.lname,user_details.mobile,fcm_token,
                    time_slot.from,estimate_type.name as estimate_type,booking.id as booking_id,profile_pic,booking.users_id as booking_user_id');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        $builder->join('bid_range', 'bid_range.bid_range_id = post_job.bid_range_id');
        $builder->join('booking_status_code', 'booking_status_code.id = post_job.status_id');
        $builder->join('user_details', 'user_details.id = booking.users_id');
        $builder->join('users', 'users.users_id = booking.users_id');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        if ($category_id == 1) { //Single Move
            $builder->select('single_move.job_description,single_move.id as single_move_id,single_move.address_id,address.locality,address.latitude,address.longitude,city,state,country,zipcode');
            $builder->join('single_move', 'single_move.booking_id = booking.id');
            $builder->join('address', 'address.id = single_move.address_id');
            $builder->join('country', 'country.id = address.country_id', 'LEFT');
            $builder->join('state', 'state.id = address.state_id', 'LEFT');
            $builder->join('city', 'city.id = address.city_id', 'LEFT');
            $builder->join('zipcode', 'zipcode.id = address.zipcode_id', 'LEFT');
        }
        if ($category_id == 2) { //Blue Collar
            $builder->select('blue_collar.id as blue_collar_id,blue_collar.job_description');
            $builder->join('blue_collar', 'blue_collar.booking_id = booking.id');
        }
        $builder->where('booking.category_id', $category_id);
        $builder->where('post_job.id in(SELECT distinct post_job_id FROM bid_det where users_id = ' . $sp_id . ')');
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
    //---------------------------------------------------GET SP Data-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_details($sp_id)
    {

        $builder = $this->db->table('sp_det');
        $builder->select('user_details.fname,user_details.lname,user_details.mobile,fcm_token,profile_pic,gender,
    ,sp_det.about_me,qualification,list_profession.name as profession,exp,GROUP_CONCAT( DISTINCT category_id) as category_id');
        $builder->join('user_details', 'user_details.id = sp_det.users_id');
        $builder->join('users', 'users.users_id = sp_det.users_id');
        $builder->join('sp_qual', 'sp_qual.id = sp_det.qual_id');
        $builder->join('sp_profession', 'sp_profession.users_id = sp_det.users_id');
        $builder->join('list_profession', 'list_profession.id = sp_profession.profession_id');
        $builder->join('sp_exp', 'sp_exp.id = sp_profession.exp_id');
        //$builder->join('user_lang_list', 'user_lang_list.users_id = bid_det.users_id');
        //$builder->join('language', 'language.id = user_lang_list.language_id');
        $builder->where('sp_det.users_id', $sp_id);
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
    //---------------------------------------------------GET Job Post Bid Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_bid_details_by_sp_id($sp_id)
    {

        $builder = $this->db->table('bid_det');
        $builder->select('bid_det.*');
        $builder->join('post_job', 'post_job.id = bid_det.post_job_id');
        $builder->join('booking', 'booking.id = post_job.booking_id');
        $builder->where('post_job_id in(SELECT distinct post_job_id FROM bid_det where users_id = ' . $sp_id . ')');

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
    //---------------------------------------------------GET Multi move Booking Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_multi_move_details($sp_id)
    {
        $builder = $this->db->table('booking');
        $builder->select('multi_move.booking_id,post_job.id as post_job_id,multi_move.id,multi_move.address_id,multi_move.sequence_no,job_description,weight_type,
    address.locality,address.latitude,address.longitude,city,state,country,zipcode');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        $builder->join('multi_move', 'multi_move.booking_id = booking.id');
        $builder->join('address', 'address.id = multi_move.address_id');
        $builder->join('country', 'country.id = address.country_id');
        $builder->join('state', 'state.id = address.state_id');
        $builder->join('city', 'city.id = address.city_id');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id');
        $builder->where('post_job.id in(SELECT distinct post_job_id FROM bid_det where users_id = ' . $sp_id . ')');
        $builder->orderBy('multi_move.booking_id,sequence_no', 'ASC');
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
    //---------------------------------------------------GET Job Post List Single Move STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_list_single_move($sp_id, $category_id, $arr_sp_keywords_id, $sp_city, $sp_latitude, $sp_longitude)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, post_job.*,post_job.id as post_job_id,booking_status_code.name as status,bid_range.name as bid_range_name,range_slots,
                    user_details.fname,user_details.lname,user_details.mobile,fcm_token,
                    time_slot.from,estimate_type.name as estimate_type,booking.id as booking_id,profile_pic,booking.users_id as booking_user_id,
                    DATE_ADD(post_job.created_dts, INTERVAL bids_period DAY) as bid_end_date, single_move.job_description,single_move.id as single_move_id,single_move.address_id,address.locality,
                    address.latitude,address.longitude,city,state,country,zipcode,,
                    (3959 * acos (cos ( radians(' . $sp_latitude . ') ) * cos( radians( address.latitude ) ) * cos( radians( address.longitude ) - radians(' . $sp_longitude . ') )
                    + sin ( radians(' . $sp_latitude . ') ) * sin( radians( address.latitude ) ) )) AS distance_miles');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        $builder->join('bid_range', 'bid_range.bid_range_id = post_job.bid_range_id');
        $builder->join('booking_status_code', 'booking_status_code.id = post_job.status_id');
        $builder->join('user_details', 'user_details.id = booking.users_id');
        $builder->join('users', 'users.users_id = booking.users_id');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->join('post_req_keyword', 'post_req_keyword.post_job_id = post_job.id');
        $builder->join('single_move', 'single_move.booking_id = booking.id');
        $builder->join('address', 'address.id = single_move.address_id');
        $builder->join('country', 'country.id = address.country_id', 'LEFT');
        $builder->join('state', 'state.id = address.state_id', 'LEFT');
        $builder->join('city', 'city.id = address.city_id', 'LEFT');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id', 'LEFT');
        $builder->where('address.city_id', $sp_city);

        $builder->where('booking.sp_id', 0);
        $builder->where('booking.category_id', $category_id);
        $builder->where('DATE_ADD(post_job.created_dts, INTERVAL bids_period DAY) > NOW()');
        $builder->where('post_job.id not in(SELECT distinct post_job_id FROM bid_det where users_id = ' . $sp_id . ')');
        $builder->whereIn('keywords_id', $arr_sp_keywords_id);
        $builder->groupBy('booking.id');

        $result = $builder->get()->getResultArray();
        // echo "<br> str " . $this->db->getLastQuery();
        // exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    //---------------------------------------------------GET Job Post List Blue Collar STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_list_blue_collar($sp_id, $category_id, $arr_sp_keywords_id)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, post_job.*,post_job.id as post_job_id,booking_status_code.name as status,bid_range.name as bid_range_name,range_slots,
                    user_details.fname,user_details.lname,user_details.mobile,fcm_token,
                    time_slot.from,estimate_type.name as estimate_type,booking.id as booking_id,profile_pic,booking.users_id as booking_user_id,
                    DATE_ADD(post_job.created_dts, INTERVAL bids_period DAY) as bid_end_date, blue_collar.id as blue_collar_id,blue_collar.job_description');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        $builder->join('bid_range', 'bid_range.bid_range_id = post_job.bid_range_id');
        $builder->join('booking_status_code', 'booking_status_code.id = post_job.status_id');
        $builder->join('user_details', 'user_details.id = booking.users_id');
        $builder->join('users', 'users.users_id = booking.users_id');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->join('post_req_keyword', 'post_req_keyword.post_job_id = post_job.id');
        $builder->join('blue_collar', 'blue_collar.booking_id = booking.id');
        $builder->where('booking.sp_id', 0);
        $builder->where('booking.category_id', $category_id);
        $builder->where('DATE_ADD(post_job.created_dts, INTERVAL bids_period DAY) > NOW()');
        $builder->where('post_job.id not in(SELECT distinct post_job_id FROM bid_det where users_id = ' . $sp_id . ')');
        $builder->whereIn('keywords_id', $arr_sp_keywords_id);
        $builder->groupBy('booking.id');

        $result = $builder->get()->getResultArray();
        // echo "<br> str " . $this->db->getLastQuery(); exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    //---------------------------------------------------GET Job Post List Multi Move STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_list_multi_move($sp_id, $category_id, $arr_sp_keywords_id, $sp_city, $sp_latitude, $sp_longitude)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, post_job.*,post_job.id as post_job_id,booking_status_code.name as status,bid_range.name as bid_range_name,range_slots,
                    user_details.fname,user_details.lname,user_details.mobile,fcm_token,
                    time_slot.from,estimate_type.name as estimate_type,booking.id as booking_id,profile_pic,booking.users_id as booking_user_id,
                    DATE_ADD(post_job.created_dts, INTERVAL bids_period DAY) as bid_end_date, multi_move.job_description,multi_move.id as multi_move_id,multi_move.address_id,address.locality,
                    address.latitude,address.longitude,city,state,country,zipcode,
                    (3959 * acos (cos ( radians(' . $sp_latitude . ') ) * cos( radians( address.latitude ) ) * cos( radians( address.longitude ) - radians(' . $sp_longitude . ') )
                    + sin ( radians(' . $sp_latitude . ') ) * sin( radians( address.latitude ) ) )) AS distance_miles');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        $builder->join('bid_range', 'bid_range.bid_range_id = post_job.bid_range_id');
        $builder->join('booking_status_code', 'booking_status_code.id = post_job.status_id');
        $builder->join('user_details', 'user_details.id = booking.users_id');
        $builder->join('users', 'users.users_id = booking.users_id');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->join('post_req_keyword', 'post_req_keyword.post_job_id = post_job.id');
        $builder->join('multi_move', 'multi_move.booking_id = booking.id');
        $builder->join('address', 'address.id = multi_move.address_id');
        $builder->join('country', 'country.id = address.country_id', 'LEFT');
        $builder->join('state', 'state.id = address.state_id', 'LEFT');
        $builder->join('city', 'city.id = address.city_id', 'LEFT');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id', 'LEFT');
        $builder->where('address.city_id', $sp_city);
        $builder->groupBy('multi_move.booking_id');
        $builder->orderBy('multi_move.sequence_no');
        $builder->where('booking.sp_id', 0);
        $builder->where('booking.category_id', $category_id);
        $builder->where('DATE_ADD(post_job.created_dts, INTERVAL bids_period DAY) > NOW()');
        $builder->where('post_job.id not in(SELECT distinct post_job_id FROM bid_det where users_id = ' . $sp_id . ')');
        $builder->whereIn('keywords_id', $arr_sp_keywords_id);
        $builder->groupBy('booking.id');

        $result = $builder->get()->getResultArray();
        // echo "<br> str " . $this->db->getLastQuery();
        exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    //---------------------------------------------------GET Job Post List All STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_list($sp_id, $category_id, $arr_sp_keywords_id, $sp_city, $sp_latitude, $sp_longitude)
    {

        $builder = $this->db->table('booking');
    $builder->select('booking.*, post_job.*,post_job.id as post_job_id,booking_status_code.name as status,bid_range.name as bid_range_name,range_slots,
                    user_details.fname,user_details.lname,user_details.mobile,fcm_token,
                    time_slot.from,estimate_type.name as estimate_type,booking.id as booking_id,profile_pic,booking.users_id as booking_user_id,
                    DATE_ADD(post_job.created_dts, INTERVAL bids_period DAY) as bid_end_date');
    $builder->join('post_job', 'post_job.booking_id = booking.id');  
    $builder->join('bid_range', 'bid_range.bid_range_id = post_job.bid_range_id');  
    $builder->join('booking_status_code', 'booking_status_code.id = post_job.status_id');  
    $builder->join('user_details', 'user_details.id = booking.users_id');
    $builder->join('users', 'users.users_id = booking.users_id');
    $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
    $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
    $builder->join('post_req_keyword', 'post_req_keyword.post_job_id = post_job.id');
    if($category_id == 1) { //Single Move
        $builder->select('single_move.job_description,single_move.id as single_move_id,single_move.address_id,address.locality,
                            address.latitude,address.longitude,city,state,country,zipcode,,
                            (3959 * acos (cos ( radians('.$sp_latitude.') ) * cos( radians( address.latitude ) ) * cos( radians( address.longitude ) - radians('.$sp_longitude.') )
                            + sin ( radians('.$sp_latitude.') ) * sin( radians( address.latitude ) ) )) AS distance_miles');
        $builder->join('single_move', 'single_move.booking_id = booking.id');
        $builder->join('address', 'address.id = single_move.address_id');
        $builder->join('country', 'country.id = address.country_id','LEFT');
        $builder->join('state', 'state.id = address.state_id','LEFT');
        $builder->join('city', 'city.id = address.city_id','LEFT');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id','LEFT');
        $builder->where('address.city_id',$sp_city);
    }
    if($category_id == 2) { //Blue Collar
        $builder->select('blue_collar.id as blue_collar_id,blue_collar.job_description');
        $builder->join('blue_collar', 'blue_collar.booking_id = booking.id');
        
    }
    if($category_id == 3) { //Multi Move
        $builder->select('multi_move.job_description,multi_move.id as multi_move_id,multi_move.address_id,address.locality,
                            address.latitude,address.longitude,city,state,country,zipcode,,
                            (3959 * acos (cos ( radians('.$sp_latitude.') ) * cos( radians( address.latitude ) ) * cos( radians( address.longitude ) - radians('.$sp_longitude.') )
                            + sin ( radians('.$sp_latitude.') ) * sin( radians( address.latitude ) ) )) AS distance_miles');
        $builder->join('multi_move', 'multi_move.booking_id = booking.id');
        $builder->join('address', 'address.id = multi_move.address_id');
        $builder->join('country', 'country.id = address.country_id','LEFT');
        $builder->join('state', 'state.id = address.state_id','LEFT');
        $builder->join('city', 'city.id = address.city_id','LEFT');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id','LEFT');
        $builder->where('address.city_id',$sp_city);
        $builder->groupBy('multi_move.booking_id');
        $builder->orderBy('multi_move.sequence_no');
        
    }
    $builder->where('booking.sp_id',0);
    $builder->where('booking.category_id',$category_id);
    $builder->where('DATE_ADD(post_job.created_dts, INTERVAL bids_period DAY) > NOW()');
    $builder->where('post_job.id not in(SELECT distinct post_job_id FROM bid_det where users_id = '.$sp_id.')');
    $builder->whereIn('keywords_id', $arr_sp_keywords_id);
    $builder->groupBy('booking.id');
    
    // $result = $builder->get()->getResultArray();
    $result = $builder->get()->getResult();
    //echo "<br> str ".$this->db->getLastQuery();exit;    
    $count = count($result);
        
    if($count > 0) {
        return $result; 
    }
    else {
        return 'failure'; 
    }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    //---------------------------------------------------GET Bulk Job Post Bid Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_bid_details_by_category($sp_id, $category_id)
    {

        $builder = $this->db->table('bid_det');
        $builder->select('bid_det.*');
        $builder->join('post_job', 'post_job.id = bid_det.post_job_id');
        $builder->join('booking', 'booking.id = post_job.booking_id');
        $builder->where('booking.sp_id', 0);
        $builder->where('booking.category_id', $category_id);
        $builder->where('DATE_ADD(post_job.created_dts, INTERVAL bids_period DAY) > NOW()');
        $builder->where('post_job.id not in(SELECT distinct post_job_id FROM bid_det where users_id = ' . $sp_id . ')');
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
    //---------------------------------------------------GET SP Data with location-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_location_details($sp_id)
    {

        $builder = $this->db->table('sp_det');
        $builder->select('user_details.fname,user_details.lname,user_details.mobile,fcm_token,profile_pic,gender,
                        ,sp_det.about_me,qualification,exp,GROUP_CONCAT(DISTINCT category_id) as category_id,GROUP_CONCAT(distinct subcategory_id) as subcategory_id,
                        city,sp_location.latitude,sp_location.longitude,GROUP_CONCAT(keywords_id) as keywords_id
                        ,GROUP_CONCAT(distinct list_profession.name) as profession,GROUP_CONCAT(distinct list_profession.id) as profession_id');
        $builder->join('user_details', 'user_details.id = sp_det.users_id');
        $builder->join('users', 'users.users_id = sp_det.users_id');
        $builder->join('sp_qual', 'sp_qual.id = sp_det.qual_id');
        $builder->join('sp_location', 'sp_location.users_id = sp_det.users_id');
        $builder->join('sp_skill', 'sp_skill.users_id = sp_det.users_id');
        $builder->join('sp_profession', 'sp_profession.users_id = sp_location.users_id AND sp_profession.profession_id = sp_skill.profession_id');
        $builder->join('list_profession', 'list_profession.id = sp_profession.profession_id');
        $builder->join('sp_exp', 'sp_exp.id = sp_profession.exp_id');
        $builder->where('sp_location.id in (select max(id) from sp_location where users_id = ' . $sp_id . ' group by users_id)');
        $builder->where('sp_det.users_id', $sp_id);
        $builder->groupBy('sp_skill.users_id,sp_profession.users_id');

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
    //---------------------------------------------------GET Multi move Booking Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_multi_move_details_by_category($category_id, $sp_id)
    {
        $builder = $this->db->table('booking');
        $builder->select('multi_move.booking_id,post_job.id as post_job_id,multi_move.id,multi_move.address_id,multi_move.sequence_no,job_description,weight_type,
    address.locality,address.latitude,address.longitude,city,state,country,zipcode');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        $builder->join('multi_move', 'multi_move.booking_id = booking.id');
        $builder->join('address', 'address.id = multi_move.address_id');
        $builder->join('country', 'country.id = address.country_id');
        $builder->join('state', 'state.id = address.state_id');
        $builder->join('city', 'city.id = address.city_id');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id');
        $builder->where('booking.category_id', $category_id);
        $builder->where('DATE_ADD(post_job.created_dts, INTERVAL bids_period DAY) > NOW()');
        $builder->where('post_job.id not in(SELECT distinct post_job_id FROM bid_det where users_id = ' . $sp_id . ')');
        $builder->orderBy('multi_move.booking_id,sequence_no', 'ASC');
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
    //---------------------------------------------------GET Job Post Bid Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_bids_report_by_sp_id($sp_id)
    {

        $builder = $this->db->table('bid_det');
        $builder->select('bid_det.*');
        $builder->join('post_job', 'post_job.id = bid_det.post_job_id');
        $builder->join('booking', 'booking.id = post_job.booking_id');
        $builder->where('bid_det.users_id', $sp_id);

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
    //---------------------------------------------------GET Job Post List STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_new_post_list($sp_id, $category_id, $arr_sp_profession_id, $arr_sp_keywords_id, $sp_city, $sp_latitude, $sp_longitude)
    {

        $builder = $this->db->table('booking');
        $builder->select('booking.*, post_job.*,post_job.id as post_job_id,booking_status_code.name as status,bid_range.name as bid_range_name,range_slots,
                    user_details.fname,user_details.lname,user_details.mobile,fcm_token,
                    time_slot.from,estimate_type.name as estimate_type,booking.id as booking_id,profile_pic,booking.users_id as booking_user_id,
                    DATE_ADD(post_job.created_dts, INTERVAL bids_period DAY) as bid_end_date');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        $builder->join('bid_range', 'bid_range.bid_range_id = post_job.bid_range_id');
        $builder->join('booking_status_code', 'booking_status_code.id = post_job.status_id');
        $builder->join('user_details', 'user_details.id = booking.users_id');
        $builder->join('users', 'users.users_id = booking.users_id');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
        $builder->join('post_req_keyword', 'post_req_keyword.post_job_id = post_job.id');
        $builder->join('keywords', 'keywords.id = post_req_keyword.keywords_id');
        if ($category_id == 1) { //Single Move
            $builder->select('single_move.job_description,single_move.id as single_move_id,single_move.address_id,address.locality,
                            address.latitude,address.longitude,city,state,country,zipcode,,
                            (3959 * acos (cos ( radians(' . $sp_latitude . ') ) * cos( radians( address.latitude ) ) * cos( radians( address.longitude ) - radians(' . $sp_longitude . ') )
                            + sin ( radians(' . $sp_latitude . ') ) * sin( radians( address.latitude ) ) )) AS distance_miles');
            $builder->join('single_move', 'single_move.booking_id = booking.id');
            $builder->join('address', 'address.id = single_move.address_id');
            $builder->join('country', 'country.id = address.country_id', 'LEFT');
            $builder->join('state', 'state.id = address.state_id', 'LEFT');
            $builder->join('city', 'city.id = address.city_id', 'LEFT');
            $builder->join('zipcode', 'zipcode.id = address.zipcode_id', 'LEFT');
            $builder->where('address.city_id', $sp_city);
        }
        if ($category_id == 2) { //Blue Collar
            $builder->select('blue_collar.id as blue_collar_id,blue_collar.job_description');
            $builder->join('blue_collar', 'blue_collar.booking_id = booking.id');
        }
        if ($category_id == 3) { //Multi Move
            $builder->select('multi_move.job_description,multi_move.id as multi_move_id,multi_move.address_id,address.locality,
                            address.latitude,address.longitude,city,state,country,zipcode,,
                            (3959 * acos (cos ( radians(' . $sp_latitude . ') ) * cos( radians( address.latitude ) ) * cos( radians( address.longitude ) - radians(' . $sp_longitude . ') )
                            + sin ( radians(' . $sp_latitude . ') ) * sin( radians( address.latitude ) ) )) AS distance_miles');
            $builder->join('multi_move', 'multi_move.booking_id = booking.id');
            $builder->join('address', 'address.id = multi_move.address_id');
            $builder->join('country', 'country.id = address.country_id', 'LEFT');
            $builder->join('state', 'state.id = address.state_id', 'LEFT');
            $builder->join('city', 'city.id = address.city_id', 'LEFT');
            $builder->join('zipcode', 'zipcode.id = address.zipcode_id', 'LEFT');
            $builder->where('address.city_id', $sp_city);
            $builder->groupBy('multi_move.booking_id');
            $builder->orderBy('multi_move.sequence_no');
        }
        $builder->where('booking.sp_id', 0);
        $builder->whereIn('keywords.profession_id', $arr_sp_profession_id);
        $builder->where('DATE_ADD(post_job.created_dts, INTERVAL bids_period DAY) > NOW()');
        $builder->where('post_job.id not in(SELECT distinct post_job_id FROM bid_det where users_id = ' . $sp_id . ')');
        $builder->whereIn('keywords_id', $arr_sp_keywords_id);
        $builder->where('booking.category_id', $category_id);
        $builder->groupBy('booking.id');

        $result = $builder->get()->getResultArray();
        // echo "<br> str-- ".$this->db->getLastQuery();exit;    
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
    function get_job_post_multi_move_details_by_profession($arr_sp_profession_id, $sp_id)
    {
        $builder = $this->db->table('booking');
        $builder->select('multi_move.booking_id,post_job.id as post_job_id,multi_move.id,multi_move.address_id,multi_move.sequence_no,job_description,weight_type,
    address.locality,address.latitude,address.longitude,city,state,country,zipcode');
        $builder->join('post_job', 'post_job.booking_id = booking.id');
        $builder->join('multi_move', 'multi_move.booking_id = booking.id');
        $builder->join('address', 'address.id = multi_move.address_id');
        $builder->join('country', 'country.id = address.country_id');
        $builder->join('state', 'state.id = address.state_id');
        $builder->join('city', 'city.id = address.city_id');
        $builder->join('zipcode', 'zipcode.id = address.zipcode_id');
        $builder->join('post_req_keyword', 'post_req_keyword.post_job_id = post_job.id');
        $builder->join('keywords', 'keywords.id = post_req_keyword.keywords_id');
        $builder->whereIn('keywords.profession_id', $arr_sp_profession_id);
        $builder->where('DATE_ADD(post_job.created_dts, INTERVAL bids_period DAY) > NOW()');
        $builder->where('post_job.id not in(SELECT distinct post_job_id FROM bid_det where users_id = ' . $sp_id . ')');
        $builder->orderBy('multi_move.booking_id,sequence_no', 'ASC');
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
    //---------------------------------------------------GET Job Post Bid Details STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_job_post_bid_details_by_profession($sp_id, $arr_sp_profession_id)
    {

        $builder = $this->db->table('bid_det');
        $builder->select('bid_det.*');
        $builder->join('post_job', 'post_job.id = bid_det.post_job_id');
        $builder->join('booking', 'booking.id = post_job.booking_id');
        $builder->join('post_req_keyword', 'post_req_keyword.post_job_id = post_job.id');
        $builder->join('keywords', 'keywords.id = post_req_keyword.keywords_id');
        $builder->whereIn('keywords.profession_id', $arr_sp_profession_id);
        $builder->where('booking.sp_id', 0);
        $builder->where('DATE_ADD(post_job.created_dts, INTERVAL bids_period DAY) > NOW()');
        $builder->where('post_job.id not in(SELECT distinct post_job_id FROM bid_det where users_id = ' . $sp_id . ')');
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

    //-----------------------------------------------------------**Get User Details by Discussion Table ID***------------------------------------------------------------    
    function get_user_by_discussion_table($discussion_tbl_id)
    {

        $builder = $this->db->table('discussion_tbl');
        $builder->select('discussion_tbl.*, user_details.*');
        $builder->join('user_details', 'user_details.id = discussion_tbl.users_id');
        $builder->where('discussion_tbl.id', $discussion_tbl_id);

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
    //---------------------------------------------------GET SP NAME WHOSE BID IS AWARDED STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_sp_details_bid_awarded($post_job_id)
    {
        $builder = $this->db->table('bid_det');
        $builder->select('bid_det.*,user_details.*');
        $builder->join('user_details', 'user_details.id = bid_det.users_id');
        $builder->where('post_job_id', $post_job_id);
        $builder->where('status_id', 27);
        $result = $builder->get()->getRowArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;
        
        if(!is_null($result) && count($result) > 0) {
            return $result; 
        }
        else {
            return 'failure'; 
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    //---------------------------------------------------GET USER WALLET BALANCE BY POST JOB ID-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_user_wallet_balance_by_post_id($post_job_id)
    {
        $builder = $this->db->table('post_job');
        $builder->select('booking.users_id,wallet_balance.amount,wallet_balance.amount_blocked');
        $builder->join('booking', 'booking.id = post_job.booking_id');
        $builder->join('wallet_balance', 'wallet_balance.users_id = booking.users_id');
        $builder->where('post_job.id', $post_job_id);
        $result = $builder->get()->getRowArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;
        
        if(!is_null($result) && count($result) > 0) {
            return $result; 
        }
        else {
            return 'failure'; 
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

}
