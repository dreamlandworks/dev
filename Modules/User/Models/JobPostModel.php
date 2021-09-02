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
    $builder->join('user_details', 'user_details.id = booking.sp_id','LEFT');
    $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
    $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
    $builder->join('single_move', 'single_move.booking_id = booking.id');
    $builder->join('address', 'address.id = single_move.address_id');
    $builder->join('country', 'country.id = address.country_id','LEFT');
    $builder->join('state', 'state.id = address.state_id','LEFT');
    $builder->join('city', 'city.id = address.city_id','LEFT');
    $builder->join('zipcode', 'zipcode.id = address.zipcode_id','LEFT');
    $builder->where('booking.users_id',$users_id);
    $builder->where('booking.category_id',1);
    $result = $builder->get()->getResultArray();
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
    $builder->join('user_details', 'user_details.id = booking.sp_id','LEFT');
    $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
    $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
    $builder->join('blue_collar', 'blue_collar.booking_id = booking.id');
    $builder->where('booking.users_id',$users_id);
    $builder->where('booking.category_id',2);
    $result = $builder->get()->getResultArray();
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
    $builder->join('user_details', 'user_details.id = booking.sp_id','LEFT');
    $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
    $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
    $builder->join('multi_move', 'multi_move.booking_id = booking.id');
    $builder->join('address', 'address.id = multi_move.address_id');
    $builder->join('country', 'country.id = address.country_id','LEFT');
    $builder->join('state', 'state.id = address.state_id','LEFT');
    $builder->join('city', 'city.id = address.city_id','LEFT');
    $builder->join('zipcode', 'zipcode.id = address.zipcode_id','LEFT');
    $builder->where('booking.users_id',$users_id);
    $builder->where('booking.category_id',3);
    $result = $builder->get()->getResultArray();
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
//---------------------------------------------------GET Job Post Bid Details STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_job_post_bid_details($users_id,$post_job_id = 0)
{

    $builder = $this->db->table('bid_det');
    $builder->select('bid_det.*');
    $builder->join('post_job', 'post_job.id = bid_det.post_job_id');  
    $builder->join('booking', 'booking.id = post_job.booking_id'); 
    $builder->where('booking.users_id',$users_id);
    if($post_job_id > 0) {
        $builder->where('bid_det.post_job_id',$post_job_id);
    }
    $result = $builder->get()->getResultArray();
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
//---------------------------------------------------GET Job Post Details STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_job_post_details($booking_id,$post_job_id,$users_id)
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
    $builder->where('booking.id',$booking_id);
    $builder->where('post_job.id',$post_job_id);
    $builder->where('booking.users_id',$users_id);
    $result = $builder->get()->getResultArray();
    //echo "<br> str ".$this->db->getLastQuery();exit;    
    $count = count($result);
        
    if($count > 0) {
        return $result[0]; 
    }
    else {
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
    $builder->where('post_job_id',$post_job_id);
    $result = $builder->get()->getResultArray();
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
//---------------------------------------------------GET Job post language STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_job_post_language($post_job_id)
{

    $builder = $this->db->table('post_req_lang');
    $builder->select('post_req_lang.language_id,name');
    $builder->join('language', 'language.id = post_req_lang.language_id');  
    $builder->where('post_job_id',$post_job_id);
    $result = $builder->get()->getResultArray();
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
//---------------------------------------------------GET Job Post Bid Details by post id STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_job_post_bid_details_by_jobpost_id($post_job_id)
{

    $builder = $this->db->table('bid_det');
    $builder->select('bid_det.*,estimate_type.name,user_details.fname,user_details.lname,user_details.mobile,fcm_token,profile_pic,sp_det.about_me');
    $builder->join('estimate_type', 'estimate_type.id = bid_det.estimate_type_id');
    $builder->join('user_details', 'user_details.id = bid_det.users_id');
    $builder->join('users', 'users.users_id = bid_det.users_id');
    $builder->join('sp_det', 'sp_det.users_id = bid_det.users_id AND sp_det.users_id = user_details.id');
    $builder->where('bid_det.post_job_id',$post_job_id);
    $result = $builder->get()->getResultArray();
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
//---------------------------------------------------GET Job Post Bid Data-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_bid_details($bid_id,$sp_id)
{

    $builder = $this->db->table('bid_det');
    $builder->select('bid_det.*,estimate_type.name,user_details.fname,user_details.lname,user_details.mobile,fcm_token,profile_pic,gender,
    ,sp_det.about_me,qualification,list_profession.name as profession,exp');
    $builder->join('estimate_type', 'estimate_type.id = bid_det.estimate_type_id');
    $builder->join('user_details', 'user_details.id = bid_det.users_id');
    $builder->join('users', 'users.users_id = bid_det.users_id');
    $builder->join('sp_det', 'sp_det.users_id = bid_det.users_id AND sp_det.users_id = user_details.id');
    $builder->join('sp_qual', 'sp_qual.id = sp_det.qual_id');
    $builder->join('list_profession', 'list_profession.id = sp_det.profession_id');
    $builder->join('sp_exp', 'sp_exp.id = sp_det.exp_id');
    //$builder->join('user_lang_list', 'user_lang_list.users_id = bid_det.users_id');
    //$builder->join('language', 'language.id = user_lang_list.language_id');
    $builder->where('bid_det.id',$bid_id);
    $builder->where('bid_det.users_id',$sp_id);
    $result = $builder->get()->getResultArray();
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
//---------------------------------------------------GET Bid Attachemnts STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_bid_attachment_details($bid_id)
{

    $builder = $this->db->table('post_attach');
    $builder->where('post_attach.bid_id',$bid_id);
    $result = $builder->get()->getResultArray();
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
//---------------------------------------------------GET SP jobs completed STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_sp_jobs_completed_count($sp_id)
{
    $builder = $this->db->table('booking');
    $builder->select('count(booking.id) as jobs_completed');
    $builder->join('post_job', 'post_job.booking_id = booking.id');
    $builder->where('booking.sp_id',$sp_id);
    $builder->where('completed_at != ','0000-00-00 00:00:00');
    $builder->where('started_at != ','0000-00-00 00:00:00');
    $builder->where('post_job.status_id',27); //Awarded
    $result = $builder->get()->getResultArray();
    //echo "<br> str ".$this->db->getLastQuery();exit;
    $count = count($result);
            
    if($count > 0) {
        return $result[0]['jobs_completed']; 
    }
    else {
        return 'failure'; 
    }
}
//--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
//---------------------------------------------------GET SP jobs completed by job post id STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_sp_jobs_completed_count_by_jobpost_id($post_job_id)
{
    $builder = $this->db->table('bid_det');
    $builder->select('bid_det.users_id,count(booking.id) as jobs_completed');
    $builder->join('post_job', 'post_job.id = bid_det.post_job_id');
    $builder->join('booking', 'booking.id = post_job.booking_id');
    $builder->where('post_job_id',$post_job_id);
    $builder->where('completed_at != ','0000-00-00 00:00:00');
    $builder->where('started_at != ','0000-00-00 00:00:00');
    $builder->where('post_job.status_id',27); //Awarded
    $builder->groupBy('bid_det.users_id');
    $result = $builder->get()->getResultArray();
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
}
