<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class MiscModel extends Model
{
//---------------------------------------------------CREATE LOGIN ACTIVITY LOG STARTS---------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
    function create_login_activity($id)
    {
    
        $builder = $this->db->table('login_activity');
        if($builder->insert(["user_id" => $id])){
            return 1;
        }else{
            return 0;
        }
    }
//--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------


//---------------------------------------------------GET LAST LOGIN ACTIVITY STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_login_activity($id)
{

    $builder = $this->db->table('login_activity');
    $builder->where(['user_id'=>$id]);
    $builder->orderBy('id','DESC');
    $query = $builder->get(1);

    if($query->getResult() != null){
        return $query->getResultArray();
    }else{
        return null;
    }
}
//--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

//---------------------------------------------------GET Search Results STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_search_results($keyword_id,$city,$current_lat,$current_lng)
{

    $builder = $this->db->table('sp_location');
    $builder->select('sp_location.*, user_details.*,sp_det.about_me,qualification,list_profession.name as profession,exp,
                      per_hour,per_day,min_charges,extra_charge,list_profession.category_id,list_profession.subcategory_id,fcm_token,
                      (3959 * acos (cos ( radians('.$current_lat.') ) * cos( radians( sp_location.latitude ) ) * cos( radians( sp_location.longitude ) - radians('.$current_lng.') )
                          + sin ( radians('.$current_lat.') ) * sin( radians( sp_location.latitude ) ) )) AS distance_miles');
    $builder->join('user_details', 'user_details.id = sp_location.users_id');
    $builder->join('users', 'users.users_id = user_details.id AND users.users_id = sp_location.users_id');
    $builder->join('sp_det', 'sp_det.users_id = sp_location.users_id AND sp_det.users_id = user_details.id');
    $builder->join('sp_skill', 'sp_skill.users_id = sp_location.users_id AND sp_skill.users_id = user_details.id');
    $builder->join('tariff', 'tariff.users_id = sp_location.users_id AND tariff.users_id = user_details.id');
    $builder->join('sp_qual', 'sp_qual.id = sp_det.qual_id');
    $builder->join('list_profession', 'list_profession.id = sp_det.profession_id');
    //$builder->join('subcategories', 'subcategories.id = list_profession.subcategory_id');
    $builder->join('sp_exp', 'sp_exp.id = sp_det.exp_id');
    $builder->join('city', 'city.id = sp_location.city');
    $builder->where('sp_location.id in (select max(id) from sp_location group by users_id)');
    if($keyword_id > 0) {
        $builder->where('keywords_id',$keyword_id);
    }
    $builder->where('city.city',$city);
    $builder->where('sp_activated',3);
    $builder->where('online_status_id',1);
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
            
    if($count > 0) {
        return $result; 
    }
    else {
        return 'failure'; 
    }
}

//--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
//---------------------------------------------------GET Search Results STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_search_results_by_city($city)
{

    $builder = $this->db->table('sp_location');
    $builder->select('sp_location.*, user_details.*,sp_det.about_me,qualification,list_profession.name as profession,exp,
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
    $builder->where('city.city',$city);
    $builder->where('sp_activated',3);
    $builder->where('online_status_id',1);
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
//---------------------------------------------------GET LAST LOGIN ACTIVITY STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_keywords_id($search_phrase_id,$subcat_id)
{

    $builder = $this->db->table('search_phrase');
    $builder->where(['id' => $search_phrase_id, 'subcategory_id' => $subcat_id]);
    $builder->orderBy('id','DESC');
    $query = $builder->get(1);

    if($query->getResult() != null){
        $result = $query->getResultArray();
        
        return $result[0]['keywords_id'];
    }else{
        //Create
        $data = array('phrase' => $search_phrase_id,'keywords_id' => 0,'subcategory_id' => $subcat_id);
        $builder->insert($data);
        
        return $this->db->insertID();
    }
}
//--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
function get_sp_preferred_time_slot($ar_sp_id)
{

    $builder = $this->db->table('user_time_slot');
    $builder->select('user_time_slot.*');
    $builder->whereIn('users_id',$ar_sp_id);
    $builder->orderBy('day_slot,time_slot_from', 'ASC');
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

function get_sp_blocked_time_slot($ar_sp_id)
{

    $builder = $this->db->table('sp_busy_slot');
    $builder->join('time_slot', 'time_slot.id = sp_busy_slot.time_slot_id');
    $builder->whereIn('users_id',$ar_sp_id);
    $builder->orderBy('date,time_slot_id', 'ASC');
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
//---------------------------------------------------GET Booking Details STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_booking_details($booking_id,$users_id)
{

    $builder = $this->db->table('booking');
    $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,fcm_token,
                    time_slot.from,estimate_type.name as estimate_type,extra_demand.amount as extra_demand_total_amount,material_advance,technician_charges,
                    expenditure_incurred,extra_demand.status as extra_demand_status,post_job.id as post_job_id');
    $builder->join('user_details', 'user_details.id = booking.users_id');
    $builder->join('users', 'users.users_id = booking.users_id');
    $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
    $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
    $builder->join('extra_demand', 'extra_demand.booking_id = booking.id','LEFT');
    $builder->join('post_job', 'post_job.booking_id = booking.id','LEFT');
    $builder->where('booking.id',$booking_id);
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
//---------------------------------------------------GET Attachemnts STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_attachment_details($booking_id)
{

    $builder = $this->db->table('attachments');
    $builder->where('attachments.booking_id',$booking_id);
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
//---------------------------------------------------GET Single move Booking Details STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_single_move_details($booking_id)
{

    $builder = $this->db->table('single_move');
    $builder->select('single_move.id,single_move.address_id,single_move.job_description,address.locality,address.latitude,address.longitude,city,state,country,zipcode');
    $builder->join('address', 'address.id = single_move.address_id');
    $builder->join('country', 'country.id = address.country_id');
    $builder->join('state', 'state.id = address.state_id');
    $builder->join('city', 'city.id = address.city_id');
    $builder->join('zipcode', 'zipcode.id = address.zipcode_id');
    $builder->where('single_move.booking_id',$booking_id);
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
//---------------------------------------------------GET Blue collar Booking Details STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_blue_collar_details($booking_id)
{

    $builder = $this->db->table('blue_collar');
    $builder->where('blue_collar.booking_id',$booking_id);
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
    $builder->where('multi_move.booking_id',$booking_id);
    $builder->orderBy('sequence_no', 'ASC');
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
    $builder->where('booking.users_id',$users_id);
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
            
    if($count > 0) {
        return $result; 
    }
    else {
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
            
    if($count > 0) {
        return $result; 
    }
    else {
        return 'failure'; 
    }
}
//---------------------------------------------------GET User Single Move Booking Details STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_user_single_move_booking_details($users_id = 0,$sp_id = 0)
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
    $builder->join('extra_demand', 'extra_demand.booking_id = booking.id','LEFT');
    $builder->join('transaction', 'transaction.booking_id = booking.id');
    $builder->where('payment_status','Success');
    $builder->where('name_id',2); //Booking Amount
    
    if($users_id > 0) {
        $builder->join('user_details', 'user_details.id = booking.sp_id','LEFT');
        $builder->where('booking.users_id',$users_id);
    }
    if($sp_id > 0) {
        $builder->join('user_details', 'user_details.id = booking.users_id','LEFT');
        $builder->where('booking.sp_id',$sp_id);
    }
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
function get_user_blue_collar_booking_details($users_id = 0,$sp_id = 0)
{

    $builder = $this->db->table('booking');
    $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,
                    time_slot.from,estimate_type.name as estimate_type,blue_collar.job_description,profile_pic,estimate_type.name as estimate_type,
                    extra_demand.amount as extra_demand_total_amount,material_advance,technician_charges,expenditure_incurred');
    $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
    $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
    $builder->join('blue_collar', 'blue_collar.booking_id = booking.id');
    $builder->join('extra_demand', 'extra_demand.booking_id = booking.id','LEFT');
    $builder->join('transaction', 'transaction.booking_id = booking.id');
    if($users_id > 0) {
        $builder->join('user_details', 'user_details.id = booking.sp_id','LEFT');
        $builder->where('booking.users_id',$users_id);
    }
    if($sp_id > 0) {
        $builder->join('user_details', 'user_details.id = booking.users_id','LEFT');
        $builder->where('booking.sp_id',$sp_id);
    }
    $builder->where('booking.category_id',2);
    $builder->where('payment_status','Success');
    $builder->where('name_id',2); //Booking Amount
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
//---------------------------------------------------GET User Multi Move Booking Details STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_user_multi_move_booking_details($users_id = 0,$sp_id = 0)
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
    $builder->join('extra_demand', 'extra_demand.booking_id = booking.id','LEFT');
    $builder->join('transaction', 'transaction.booking_id = booking.id');
    if($users_id > 0) {
        $builder->join('user_details', 'user_details.id = booking.sp_id','LEFT');
        $builder->where('booking.users_id',$users_id);
    }
    if($sp_id > 0) {
        $builder->join('user_details', 'user_details.id = booking.users_id','LEFT');
        $builder->where('booking.sp_id',$sp_id);
    }
    $builder->where('booking.category_id',3);
    $builder->where('name_id',2); //Booking Amount
    $builder->where('payment_status','Success');
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
//---------------------------------------------------GET User Transaction History STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_user_transaction_history($users_id)
{

    $builder = $this->db->table('transaction');
    $builder->select('date,amount,reference_id,booking_id,payment_status,transaction_name.name as transaction_name,
                        transaction_methods.name as transaction_method,transaction_type.name as transaction_type');
    $builder->join('transaction_name', 'transaction_name.id = transaction.name_id');  
    $builder->join('transaction_methods', 'transaction_methods.id = transaction.method_id');
    $builder->join('transaction_type', 'transaction_type.id = transaction.type_id');
    $builder->where('transaction.users_id',$users_id);
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
//---------------------------------------------------GET SP Skills STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_sp_skills($sp_id)
{

    $builder = $this->db->table('sp_skill');
    $builder->select('sp_skill.keywords_id,keyword');
    $builder->join('keywords', 'keywords.id = sp_skill.keywords_id');
    $builder->where('sp_skill.users_id',$sp_id);
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
//---------------------------------------------------GET SP Languages STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_sp_lang($sp_id)
{

    $builder = $this->db->table('user_lang_list');
    $builder->select('user_lang_list.language_id,name');
    $builder->join('language', 'language.id = user_lang_list.language_id');
    $builder->where('user_lang_list.users_id',$sp_id);
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
//---------------------------------------------------GET Offers list STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_offers_list($offer_type_id = 0)
{

    $builder = $this->db->table('offer');
    $builder->select('offer.*,offer_type.name as offer_type_name,value_type.name as value_type_name');
    $builder->join('offer_type', 'offer_type.id = offer.offer_type_id');
    $builder->join('value_type', 'value_type.id = offer.value_type_id');
    $builder->where('offer.offer_type_id',$offer_type_id);
    
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
//---------------------------------------------------GET Offers Selection list STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_offers_selection_list($users_id)
{

    $builder = $this->db->table('offer');
    $builder->select('offer.*,offer_type.name as offer_type_name,value_type.name as value_type_name');
    $builder->join('offer_type', 'offer_type.id = offer.offer_type_id');
    $builder->join('value_type', 'value_type.id = offer.value_type_id');
    $builder->join('offer_select_list', 'offer_select_list.offer_id = offer.id');
    $builder->where('offer.offer_type_id',4); //Selected list
    $builder->where('offer_select_list.users_id',$users_id);
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
//---------------------------------------------------GET Offers Location list STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_offers_location_list($location_type,$location_id)
{

    $builder = $this->db->table('offer');
    $builder->select('offer.*,offer_type.name as offer_type_name,value_type.name as value_type_name');
    $builder->join('offer_type', 'offer_type.id = offer.offer_type_id');
    $builder->join('value_type', 'value_type.id = offer.value_type_id');
    $builder->join('offer_location_list', 'offer_location_list.offer_id = offer.id');
    $builder->where('offer.offer_type_id',1); 
    $builder->where('offer_location_list.location_type_id',$location_type);
    $builder->where('offer_location_list.location_id',$location_id);
    
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
//---------------------------------------------------GET booking count STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_total_bookings($users_id)
{
    $builder = $this->db->table('booking');
    $builder->select('count(id) as total_bookings');
    $builder->where('users_id',$users_id);
    $builder->where('sp_id > 0');
    $result = $builder->get()->getResultArray();
    //echo "<br> str ".$this->db->getLastQuery();exit;
    $count = count($result);
    if($count > 0) {
        return $result[0]['total_bookings']; 
    }
    else {
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
    $builder->where('users_id',$users_id);
    $result = $builder->get()->getResultArray();
    //echo "<br> str ".$this->db->getLastQuery();exit;
    $count = count($result);
    if($count > 0) {
        return $result[0]['total_job_posts']; 
    }
    else {
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
    $builder->where('user_details.id',$users_id);
    $result = $builder->get()->getResultArray();
    //echo "<br> str ".$this->db->getLastQuery();exit;
    $count = count($result);
    if($count > 0) {
        return $result[0]['total_referrals']; 
    }
    else {
        return 0; 
    }
}
//--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
//---------------------------------------------------GET Booking Details STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_booking_work_summary($booking_id)
{

    $builder = $this->db->table('booking');
    $builder->select('booking.*, time_slot.from,estimate_type.name as estimate_type,extra_demand.amount as extra_demand_total_amount,material_advance,technician_charges,expenditure_incurred');
    $builder->join('time_slot', 'time_slot.id = booking.time_slot_id');
    $builder->join('estimate_type', 'estimate_type.id = booking.estimate_type_id');
    $builder->join('extra_demand', 'extra_demand.booking_id = booking.id','LEFT');
    $builder->join('transaction', 'transaction.booking_id = booking.id','LEFT');
    $builder->where('booking.id',$booking_id);
    $builder->where('payment_status','Success');
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
    $builder->where('transaction.booking_id',$booking_id);
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
//---------------------------------------------------GET Booking Status History STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_booking_status_list($booking_id)
{

    $builder = $this->db->table('booking_status');
    $builder->select('*');
    $builder->join('booking_status_code', 'booking_status_code.id = booking_status.status_id');  
    $builder->where('booking_id',$booking_id);
    $builder->orderBy('booking_status_id','ASC');
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
//---------------------------------------------------GET sp booking count STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_total_sp_bookings($sp_id)
{
    $builder = $this->db->table('booking');
    $builder->select('id,status_id');
    $builder->where('sp_id',$sp_id);
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
//---------------------------------------------------GET Total SP Reviews STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_sp_reviews_list($sp_id)
{

    $builder = $this->db->table('user_review');
    $builder->select('count(id) as total_review');
    $builder->where('sp_id',$sp_id);
    $result = $builder->get()->getResultArray();
    //echo "<br> str ".$this->db->getLastQuery();exit;    
    $count = count($result);
    if($count > 0) {
        return $result[0]['total_review']; 
    }
    else {
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
    $builder->where('user_review.sp_id',$sp_id);
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
//---------------------------------------------------GET user plan details STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_user_plan_details($users_id)
{
    $builder = $this->db->table('subs_plan');
    $builder->select('*');
    $builder->join('user_plans', 'user_plans.id = subs_plan.plans_id');
    $builder->where('users_id',$users_id);
    $builder->orderBy('subs_id', 'DESC');
    $builder->limit(1);
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
//---------------------------------------------------GET sp plan details STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_sp_plan_details($users_id)
{
    $builder = $this->db->table('sp_subs_plan');
    $builder->select('*');
    $builder->join('sp_plans', 'sp_plans.id = sp_subs_plan.plans_id');
    $builder->where('users_id',$users_id);
    $builder->orderBy('subs_id', 'DESC');
    $builder->limit(1);
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
//---------------------------------------------------GET complaints details STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_complaints_details($users_id)
{
    $builder = $this->db->table('complaints');
    $builder->select('complaints.*,complaint_status.action_taken,complaint_status.status,complaint_status.created_on as complaint_status_date,complaint_status.id as complaint_status_id');
    $builder->join('complaint_status', 'complaint_status.complaints_id = complaints.id',"LEFT");
    $builder->where('users_id',$users_id);
    $builder->where('complaints.id >',0);
    $builder->orderBy('complaints.id', 'DESC');
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
//---------------------------------------------------GET Request details STARTS-----------------------------------------------------
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_request_details($users_id)
{
    $builder = $this->db->table('withdraw_request');
    $builder->select('withdraw_request.*');
    $builder->join('transaction', 'transaction.id = withdraw_request.transaction_id');
    $builder->where('withdraw_request.users_id',$users_id);
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
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_user_name_by_booking($booking_id = 0, $users_id = 0)
{

    $builder = $this->db->table('booking');
    $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,fcm_token');
    $builder->join('user_details', 'user_details.id = booking.users_id');
    $builder->join('users', 'users.users_id = booking.users_id');
    if($booking_id > 0) {
        $builder->where('booking.id',$booking_id);
    }
    if($users_id > 0) {
        $builder->where('booking.users_id',$users_id);
    }
    
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
//-----------------------------------------------------------***************------------------------------------------------------------    
function get_sp_name_by_booking($booking_id = 0, $sp_id = 0)
{

    $builder = $this->db->table('booking');
    $builder->select('booking.*, user_details.fname,user_details.lname,user_details.mobile,fcm_token');
    $builder->join('user_details', 'user_details.id = booking.sp_id');
    $builder->join('users', 'users.users_id = booking.sp_id');
    if($booking_id > 0) {
        $builder->where('booking.id',$booking_id);
    }
    if($sp_id > 0) {
        $builder->where('booking.sp_id',$sp_id);
    }
    
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
}
