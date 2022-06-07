<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class MiscModel extends Model
{


    //---------------------------------------------------GET SP BOOKINGS COUNT STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------
    function get_sp_booking_count($id)
    {
        $builder = $this->db->table('booking');
        $builder->select('COUNT(status_id) AS bookings_count,status_id');
        $builder->where('sp_id', $id);
        $builder->groupBy('status_id');
        $result = $builder->get()->getResultArray();

        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    //---------------------------------------------------GET SP BIDS COUNT STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------
    function get_sp_bids_count($id)
    {
        $builder = $this->db->table('bid_det');
        $builder->select('COUNT(status_id) AS bids_count,status_id');
        $builder->where('users_id', $id);
        $builder->groupBy('status_id');
        $result = $builder->get()->getResultArray();

        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    //---------------------------------------------------ADD PROFESSION STARTS-----------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function add_profession($name)
    {
        $builder = $this->db->table('list_profession');
        $builder->insert(['name' => $name]);
        $query = $this->db->insertID();

        if ($query != null) {
            return $query;
        } else {
            return null;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------
    //---------------------------------------------------GET Users STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    function get_users_list()
    {

        $builder = $this->db->table('user_details');
        $builder->select('user_details.*, users.id, users.email,users.active');
        $builder->join('users', 'users.users_id = user_details.id');
        //$builder->where('online_status_id',1);
        $result = $builder->get()->getResultArray();
        $builder->orderBy('id', 'DESC');
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    function get_users($id)
    {

        $builder = $this->db->table('user_details');
        $builder->select('user_details.*,users.email,users.active,users.reason_for_ban,referral.referred_by');
        $builder->join('users', 'users.users_id = user_details.id', 'left');
        $builder->join('referral', 'referral.id = user_details.referral_id', 'left');
        $builder->where('users.users_id', $id);
        $result = $builder->get()->getRowArray();
        $builder->orderBy('id', 'DESC');
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    public function showAllCategories()
    {
        $builder = $this->db->table('category');
        $builder->select('*');
        $result = $builder->get()->getResultArray();
        //$builder->orderBy('id','DESC');
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    public function getCategory($id)
    {
        $builder = $this->db->table('category');
        $builder->select('*');
        $builder->where('id', $id);
        $result = $builder->get()->getRow();
        //$query = $this->db->getLastQuery();
        //echo (string)$query;
        if ($result) {
            return $result;
        } else {
            return 'failure';
        }
    }

    public function updateCategories($id, $data)
    {
        $builder = $this->db->table('category');
        $builder->where('id', $id);
        return $builder->update($data);
    }

    public function deleteCategories($id)
    {
        $builder = $this->db->table('category');
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function showAllSubCategories()
    {
        $builder = $this->db->table('subcategories');
        $builder->select('subcategories.*,category.category');
        $builder->join('category', 'category.id = subcategories.category_id');
        $builder->orderBy('subcategories.id', 'DESC');
        $result = $builder->get()->getResultArray();

        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    public function updateSubCategories($id, $data)
    {
        $builder = $this->db->table('subcategories');
        $builder->where('id', $id);
        return $builder->update($data);
    }

    public function getSubCategory($id)
    {
        $builder = $this->db->table('subcategories');
        $builder->select('subcategories.*,category.category');
        $builder->where('subcategories.id', $id);
        $builder->join('category', 'category.id = subcategories.category_id');
        $result = $builder->get()->getRow();
        //$query = $this->db->getLastQuery();
        //echo (string)$query;
        if ($result) {
            return $result;
        } else {
            return 'failure';
        }
    }

    public function deleteSubCategories($id)
    {
        $builder = $this->db->table('subcategories');
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function showAllKeywords()
    {
        $builder = $this->db->table('keywords');
        $builder->select('keywords.*,list_profession.name');
        $builder->join('list_profession', 'list_profession.id = keywords.profession_id');
        $builder->orderBy('keywords.id', 'DESC');
        $result = $builder->get()->getResultArray();

        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    public function  getprofession()
    {
        $builder = $this->db->table('list_profession');
        $builder->select('*');
        $result = $builder->get()->getResultArray();
        //$builder->orderBy('id','DESC');
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    function add_keyword($keyword, $profession_id)
    {
        $builder = $this->db->table('keywords');

        $arrray = [
            "keyword" => $keyword,
            "profession_id" => $profession_id
        ];

        $builder->insert($arrray);
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $query = $this->db->insertID();

        if ($query != null) {
            return $query;
        } else {
            return null;
        }
    }

    public function updateKeyword($id, $data)
    {
        $builder = $this->db->table('keywords');
        $builder->where('id', $id);
        return $builder->update($data);
    }

    public function getKeywords($id)
    {
        $builder = $this->db->table('keywords');
        $builder->select('keywords.*,list_profession.name');
        $builder->where('keywords.id', $id);
        $builder->join('list_profession', 'list_profession.id = keywords.profession_id');
        $result = $builder->get()->getRow();
        //$query = $this->db->getLastQuery();
        //echo (string)$query;
        if ($result) {
            return $result;
        } else {
            return 'failure';
        }
    }
    public function deleteKeyword($id)
    {
        $builder = $this->db->table('keywords');
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function showAllLanguages()
    {
        $builder = $this->db->table('language');
        $builder->select('*');
        $builder->orderBy('id', 'DESC');
        $result = $builder->get()->getResultArray();

        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    function add_language($language_name)
    {
        $builder = $this->db->table('language');

        $arrray = [
            "name" => $language_name
        ];

        $builder->insert($arrray);
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $query = $this->db->insertID();

        if ($query != null) {
            return $query;
        } else {
            return null;
        }
    }
    public function updateLanguage($id, $data)
    {
        $builder = $this->db->table('language');
        $builder->where('id', $id);
        return $builder->update($data);
    }


    public function deleteLanguage($id)
    {
        $builder = $this->db->table('language');
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function showAllProfessions()
    {
        $builder = $this->db->table('list_profession');
        $builder->select('list_profession.*,category.category,subcategories.sub_name');
        $builder->join('category', 'category.id = list_profession.category_id', 'left');
        $builder->join('subcategories', 'subcategories.id = list_profession.subcategory_id', 'left');
        $builder->orderBy('list_profession.id', 'DESC');
        $result = $builder->get()->getResultArray();

        //echo "<br> str ".$this->db->getLastQuery();
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    function add_professions($name, $category_id, $subcategory_id)
    {
        $builder = $this->db->table('list_profession');

        $arrray = [
            "name" => $name,
            "category_id" => $category_id,
            "subcategory_id" => $subcategory_id
        ];

        $builder->insert($arrray);
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $query = $this->db->insertID();

        if ($query != null) {
            return $query;
        } else {
            return null;
        }
    }
    public function updateProfession($id, $data)
    {
        $builder = $this->db->table('list_profession');
        $builder->where('id', $id);
        return $builder->update($data);
    }


    public function deleteProfession($id)
    {
        $builder = $this->db->table('list_profession');
        $builder->where('id', $id);
        return $builder->delete();
    }
    public function showAllQualifications()
    {
        $builder = $this->db->table('sp_qual');
        $builder->select('*');
        $builder->orderBy('id', 'DESC');
        $result = $builder->get()->getResultArray();

        //echo "<br> str ".$this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    function add_qualification($qualification)
    {
        $builder = $this->db->table('sp_qual');

        $arrray = [
            "qualification" => $qualification
        ];

        $builder->insert($arrray);
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $query = $this->db->insertID();

        if ($query != null) {
            return $query;
        } else {
            return null;
        }
    }

    public function updateQualification($id, $data)
    {
        $builder = $this->db->table('sp_qual');
        $builder->where('id', $id);
        return $builder->update($data);
    }

    public function deleteQualification($id)
    {
        $builder = $this->db->table('sp_qual');
        $builder->where('id', $id);
        return $builder->delete();
    }

    /*********************************** BEGIN Cancellation Charges ***********************************/

    public function showAllCancellationCharges()
    {
        $builder = $this->db->table('tax_cancel_charges');
        $builder->select('*');
        $builder->orderBy('id', 'DESC');
        $result = $builder->get()->getResultArray();

        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    public function deleteCancellationCharges($id)
    {
        $builder = $this->db->table('tax_cancel_charges');
        $builder->where('id', $id);
        return $builder->delete();
    }

    public function add_cancellationCharges($data)
    {
        $builder = $this->db->table('tax_cancel_charges');

        $arrray = [
            "name" => $data['cancellationCharges_name'],
            "percentage" => $data['cancellationCharges_percentage'],
            "amount" => $data['cancellationCharges_amount'],
            "description" => $data['cancellationCharges_description']
        ];

        $builder->insert($arrray);
        //echo "<br> str ".$this->db->getLastQuery();exit;
        $query = $this->db->insertID();

        if ($query != null) {
            return $query;
        } else {
            return null;
        }
    }

    public function getCancellationCharges($id)
    {
        $builder = $this->db->table('tax_cancel_charges');
        $builder->select('*');
        $builder->where('id', $id);
        $result = $builder->get()->getRow();

        if ($result) {
            return $result;
        } else {
            return 'failure';
        }
    }


    public function updateCancellationCharges($id, $data)
    {
        $builder = $this->db->table('tax_cancel_charges');
        $builder->where('id', $id);
        return $builder->update($data);
    }

    /*********************************** END Cancellation Charges ***********************************/


    /*********************************** BEGIN List Bookings ***********************************/

    public function showAllBookings()
    {
        $builder = $this->db->table('booking');

        $builder->select('booking.id as booking_id,booking.amount, booking.scheduled_date, time_slot.from as booking_time, booking.reschedule_status_id, category.category, booking_status_code.name as booking_status');
        $builder->join('category', 'category.id = booking.category_id', 'left');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id', 'left');
        $builder->join('booking_status_code', 'booking_status_code.id = booking.status_id', 'left');

        $builder->orderBy('booking.id', 'DESC');

        $result = $builder->get()->getResultArray();

        //echo "<br> str ".$this->db->getLastQuery();
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }


    public function getBookingStatusCount()
    {
        $arrStatus = array("Pending", "In Progress", "Completed");

        $builder = $this->db->table('booking');

        $builder->select('count(booking.id) as booking_count');
        $builder->join('booking_status_code', 'booking_status_code.id = booking.status_id', 'inner');

        $builder->whereIn('booking_status_code.name', $arrStatus);

        $builder->groupBy('booking.status_id');

        $result = $builder->get()->getResultArray();

        //echo "<br> str ".$this->db->getLastQuery();
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    public function deleteBooking($id)
    {
        $builder = $this->db->table('booking');
        $builder->where('id', $id);
        return $builder->delete();
    }


    public function showBookingByID($id)
    {
        $builder = $this->db->table('booking');

        $builder->select('booking.id as booking_id,booking.amount, booking.scheduled_date, time_slot.from as booking_time, booking.reschedule_status_id, category.category, booking_status_code.name as booking_status');
        $builder->join('category', 'category.id = booking.category_id', 'left');
        $builder->join('time_slot', 'time_slot.id = booking.time_slot_id', 'left');
        $builder->join('booking_status_code', 'booking_status_code.id = booking.status_id', 'left');

        $builder->where('booking.id', $id);

        $result = $builder->get()->getResultArray();

        //echo "<br> str ".$this->db->getLastQuery();
        $count = count($result);

        if ($count > 0) {
            return $result[0];
        } else {
            return 'failure';
        }
    }


    public function showAllTimeSlots()
    {
        $builder = $this->db->table('time_slot');

        $builder->select('from');

        $result = $builder->get()->getResultArray();

        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }

    public function showAllUsers()
    {
        $builder = $this->db->table('user_details');

        $builder->select('id as user_id, fname, lname');

        $builder->orderBy('id', 'DESC');

        $result = $builder->get()->getResultArray();

        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }


    /*********************************** END List Bookings ***********************************/

    //------------------------------- GET SP LIST TO BE APPROVED FOR ADMIN PANEL--------------------------------------------------------

    public function get_sp_not_approved()
    {

        $builder = $this->db->table('user_details');
        $builder->select('user_details.*, users.email,city.city,country.country,state.state');
        $builder->join('users', 'users.users_id = user_details.id', 'left');
        $builder->join('address', 'address.users_id = user_details.id', 'left');
        $builder->join('city', 'city.id = address.city_id', 'left');
        $builder->join('state', 'state.id = address.state_id', 'left');
        $builder->join('country', 'country.id = address.country_id', 'left');
        $builder->groupBy('user_details.id');
        $builder->where('users.sp_activated', 2);

        $result = $builder->get()->getResultArray();

        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }



    //------------------------------- FUNCTION ENDS HERE --------------------------------------------------------

    //------------------------------- GET SP LIST FOR ADMIN PANEL---------------------------------------------------------------

    public function get_sp_list()
    {

        $builder = $this->db->table('user_details');
        $builder->select('user_details.*, users.email,city.city,country.country,state.state,AVG(user_review.average_review) as review');
        $builder->join('users', 'users.users_id = user_details.id', 'left');
        $builder->join('address', 'address.users_id = user_details.id', 'left');
        $builder->join('city', 'city.id = address.city_id', 'left');
        $builder->join('state', 'state.id = address.state_id', 'left');
        $builder->join('country', 'country.id = address.country_id', 'left');
        $builder->join('user_review', 'user_review.sp_id = user_details.id', 'left');
        $builder->where('users.sp_activated', 3);
        $builder->groupBy('user_details.id');


        // $result = $builder->get()->getResultArray();
        $result = $builder->get()->getResult();

        // echo $this->db->getLastQuery();exit;
        $count = count($result);

        if ($count > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
    // get dat of single sp as row
    public function get_sp_details($id)
    {
        $builder = $this->db->table('user_details');
        $builder->select('user_details.*, address.*,users.email,city.city,country.country,state.state,AVG(user_review.average_review) as review');
        $builder->join('users', 'users.users_id = user_details.id', 'left');
        $builder->join('address', 'address.users_id = user_details.id', 'left');
        $builder->join('city', 'city.id = address.city_id', 'left');
        $builder->join('state', 'state.id = address.state_id', 'left');
        $builder->join('country', 'country.id = address.country_id', 'left');
        $builder->join('user_review', 'user_review.sp_id = user_details.id', 'left');
        $builder->where('user_details.id', $id);
        $builder->groupBy('user_details.id');
        return $result = $builder->get()->getRow();
    }

    //update sp details
    function update_sp_details($id, $fname, $lname, $mob, $email, $city, $state, $country)
    {
        $usersData = array(
            'email' => $email,
        );
        $this->db->table('users')->where('id', $id)->update($usersData);
        // update user_detail table
        $userDetai = array(
            'fname' => $fname,
            'lname' => $lname,
            'mobile' => $mob,
        );
        $this->db->table('user_details')->where('users_id', $id)->update($userDetai);
        // uopdate address table
        $address = array(
            'city_id' => $city,
            'state_id' => $state,
            'country_id' => $country,
        );
        // $this->db->table('address')->where('users_id', $id)->update($address);

        // return $builder->update($data);
    }

    function getCountryList()
    {
        return $this->db->table('country')->get()->getResult();
    }

    function getStateList($countryId)
    {
        return $this->db->table('state')->where('country_id', $countryId)->get()->getResult();
    }

    function getCityList($stateId)
    {
        return $this->db->table('city')->where('state_id', $stateId)->get()->getResult();
    }


    function update_expired_posts()
    {
        $query = "UPDATE post_job 
                  INNER JOIN booking ON booking.id = post_job.booking_id
                  INNER JOIN time_slot ON time_slot.id = booking.time_slot_id
                  SET post_job.status_id = 28
                  WHERE post_job.status_id = 26 AND CONCAT(booking.scheduled_date,' ',time_slot.from) < NOW()";

        $this->db->query($query);
    }


    function get_expired_bookings(){

        $builder = $this->db->table('booking');
        $builder -> select('*');
        $builder-> join('time_slot', 'time_slot.id = booking.time_slot_id');
        $builder-> where("DATE_ADD(CONCAT(booking.scheduled_date,' ',time_slot.from),INTERVAL 1 HOUR) < NOW() AND status_id = 9");
        $result = $builder->get()->getResultArray();

        if(count($result) > 0){
            return $result;
        }else{
            return 'failure';
        }


    }


    function update_expired_bookings($booking_id)
    {
        $query = "UPDATE booking 
                  SET status_id = 28
                  WHERE booking_id =".$booking_id;

        $this->db->query($query);
    }


    function update_expired_reschedule_requests(){

        $query = "UPDATE re_schedule 
                  INNER JOIN time_slot ON time_slot.id = re_schedule.rescheduled_time_slot_id
                  SET status_id = 28
                  WHERE re_schedule.status_id = 10 AND CONCAT(re_schedule.rescheduled_date,' ',time_slot.from) <= NOW()";

        $this->db->query($query);

    }


    function update_expired_alerts_sp(){
       
       $query = "UPDATE alert_action_sp 
                  SET status = 1
                  WHERE expiry <= NOW() AND status = 2 AND type_id = 9"; 

        $this->db->query($query);
    }


    function update_expired_alerts_user(){
       
        $query = "UPDATE alert_action_user 
                   SET status = 1
                   WHERE expiry <= NOW() AND status = 2 AND type_id = 9"; 
 
         $this->db->query($query);
     }

     function get_cancellation_charges(){
        $builder = $this->db->table('tax_cancel_charges');
        $builder->select('*');
        $builder->where('id',6);

        $result = $builder->get()->getResultArray();

        if(count($result) > 0){
            return $result;
        }else{
            return 'failure';
        }

     }

     function get_sp_wallet($sp_id){
       
        $builder = $this->db->table('wallet_balance');
         $builder->select('*');
         $builder->where('users_id',$sp_id);
         $result = $builder->get()->getResultArray();

         if(count($result) > 0){
            return $result;
         }else{
             return 'failure';
         }
     }

}
