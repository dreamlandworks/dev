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
function get_search_results($keyword_id,$city)
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
    $builder->where('keywords_id',$keyword_id);
    $builder->where('city.city',$city);
    $builder->where('sp_activated',3);
    $builder->where('online_status_id',1);
    $result = $builder->get()->getResultArray();
    //echo "<br> str ".$this->db->getLastQuery();exit;
    $count = $builder->countAllResults();
            
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
    $count = $builder->countAllResults();
            
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
    $count = $builder->countAllResults();
            
    if($count > 0) {
        return $result; 
    }
    else {
        return 'failure'; 
    }
}
//--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------


}
