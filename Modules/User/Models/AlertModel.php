<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

class AlertModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'alert_details';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = true;
    protected $allowedFields        = [
        "id", "alert_id", "sub_id", "reference_id", "created_on", "status", "users_id", "sp_id"
    ];

    //---------------------------------------------------------CREATE ALERTS STARTS---------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    

    /**
     * Creates Alert Record
     * 
     * @param mixed $array
     * Fields required in the array are
     * "alert_id", "created_on","status","alert_sub","reference_id","users_id","sp_id"
     * 
     * @return int|null -> Returns ID of the created record
     */
    public function create_record($array)
    {

        if ($this->insert($array)) {
            $res = $this->getInsertID();
            return $res;
        } else {
            return null;
        }
    }

    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------


    //---------------------------------------------------------CREATE SUB ALERTS STARTS-----------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    
    /**
     * Create Sub Alerts based on Alert Type
     * 
     * Required array should contain 'description','alert_id','action'
     * @param mixed $array
     * 
     * @return int|null -> Created Alert Subdetails ID
     */
    function create_alert_sub($array)
    {

        $builder = $this->db->table('alert_sub');
        $builder->insert($array);

        if (($query = $this->db->insertID()) != null) {
            return $query;
        } else {
            return null;
        }
    }
    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------



    //--------------------------------------------------------GET UNREAD ALERTS STARTS---------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    

    public function unread_alerts($id, $type)
    {

        $builder = $this->db->table('alert_details');
        $builder->select('alert_details.id,alert.alert_type,description,alert_details.created_on,booking_id,alert_id,action,category_id,
		                    post_job_id,bid_id,bid_sp_id,reschedule_user_id,reschedule_id');
        $builder->join('alert', 'alert_details.alert_id = alert.id');
        //$builder->join('alert_sub', 'alert_details.sub_id = alert_sub.id');
        $builder->where('users_id', $id);
        $builder->where('status', 1);
        $builder->where('action', $type);
        $query = $builder->get();

        $res = $query->getResultArray();

        if ($res != null) {
            return $res;
        } else {
            return null;
        }
    }


    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------


    //--------------------------------------------------------UPDATE ALERT STATUS STARTS---------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    

    /**
     * Function to update alerts
     * 
     * Send type = '1' for User and '2' for SP
     * @param mixed $id
     * @param mixed $type
     * @param mixed $last_id
     * 
     * @return [type]
     */
    public function update_alert($id, $type, $last_id)
    {

        $array = [
            'status' => 1,
            'updated_on' => date('Y-m-s H:i:s')
        ];

        //$builder = $this->db->table($table);
        $builder = $this->db->table(($type == 1 ? 'alert_regular_user' : 'alert_regular_sp'));
        $builder->where('user_id', $id);
        $builder->where('status', 2);
        $builder->where('id <', $last_id + 1);
        $query = $builder->update($array);

        //echo "<br> str ".$this->db->getLastQuery();exit;
        if ($query) {
            return "Success";
        } else {
            return "Fail";
        }
    }

    //--------------------------------------------------------GET REGULAR ALERTS USER STARTS---------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    

    /**
     * Gets all alerts pertaining to user and SP
     * send type = '1' for User Regular Alerts, '2' for User Action Alerts, '3' for SP Regular Alerts, '4' for SP Action Alerts
     * @param mixed $id
     * @param mixed $type
     * 
     * @return [type]
     */
    public function all_alerts($id, $type)

    {
        // switch($type){
        //     case 1:
        //         $table = 'alert_regular_user';
        //         break;
        //     case 2:
        //         $table = 'alert_action_user';
        //         break;
        //     case 3:
        //         $table = 'alert_regular_sp';
        //         break;
        //     case 4:
        //         $table = 'alert_action_sp';
        //         break;

        // }

        if ($type == 1) {

            $builder = $this->db->table('alert_regular_user');
            $builder->select('alert_regular_user.*,user_details.profile_pic');
            $builder->join('user_details','user_details.id = alert_regular_user.profile_pic_id');
            $builder->where('user_id', $id);
            $builder->where('status', 2);

        }elseif($type == 2){
         
            $builder = $this->db->table('alert_action_user');
            $builder->select('alert_action_user.*,re_schedule.req_raised_by_id,booking.category_id,booking.sp_id,bid_det.id as bid_id,bid_det.users_id as bid_user_id, user_details.profile_pic');
            $builder->join('re_schedule', 're_schedule.reschedule_id = alert_action_user.reschedule_id', 'left');
            $builder->join('booking', 'booking.id = alert_action_user.booking_id', 'left');
            $builder->join('bid_det', 'bid_det.post_job_id = alert_action_user.post_id', 'left');
            $builder->join('user_details','user_details.id = alert_action_user.profile_pic_id');
            $builder->where('user_id', $id);
            $builder->where('status', 2);
            // echo "<br> str ".$this->db->getLastQuery();exit;
            
        }elseif($type == 3){

            $builder = $this->db->table('alert_regular_sp');
            $builder->select('alert_regular_sp.*, user_details.profile_pic');
            $builder->join('user_details','user_details.id = alert_regular_sp.profile_pic_id');
            $builder->where('user_id', $id);
            $builder->where('status', 2);

        }elseif($type == 4){

            $builder = $this->db->table('alert_action_sp');
            $builder->select('alert_action_sp.*,re_schedule.req_raised_by_id,booking.category_id,booking.users_id,bid_det.id as bid_id,bid_det.users_id as bid_user_id, user_details.profile_pic');
            $builder->join('re_schedule', 're_schedule.reschedule_id = alert_action_sp.reschedule_id', 'left');
            $builder->join('booking', 'booking.id = alert_action_sp.booking_id', 'left');
            $builder->join('bid_det', 'bid_det.post_job_id = alert_action_sp.post_id', 'left');
            $builder->join('user_details','user_details.id = alert_action_sp.profile_pic_id');
            $builder->where('user_id', $id);
            $builder->where('status', 2);
            // echo "<br> str ".$this->db->getLastQuery();exit;
        }

        $builder->orderBy('created_on','DESC');
        $query = $builder->get();

        $res = $query->getResultArray();
        // echo "<br> str ".$this->db->getLastQuery();exit;


        if ($res != null) {
            return $res;
        } else {
            return 'failure';
        }
    }


    //--------------------------------------------------------------FUNCTION ENDS-----------------------------------------------------------

    public function get_action_alert($type_id, $user_id, $status_code_id, $user_type, $booking_id = Null, $post_id = Null)
    {

        //$user_type == 1 for User && 2 for SP 
        if ($user_type == 1) {
            $builder = $this->db->table('alert_action_user');
            $builder->select('alert_action_user.*,re_schedule.reschedule_id,re_schedule.req_raised_by_id,booking.category_id,bid_det.id as bid_id,bid_det.users_id as bid_user_id');
            $builder->join('re_schedule', 're_schedule.booking_id = alert_action_user.booking_id', 'left');
            $builder->join('booking', 'booking.id = alert_action_user.booking_id', 'left');
            $builder->join('bid_det', 'bid_det.post_job_id = alert_action_user.post_id', 'left');
        } elseif ($user_type == 2) {
            $builder = $this->db->table('alert_action_sp');
            $builder->select('alert_action_sp.*,re_schedule.reschedule_id,re_schedule.req_raised_by_id,booking.category_id,bid_det.id as bid_id,bid_det.users_id as bid_user_id');
            $builder->join('re_schedule', 're_schedule.booking_id = alert_action_sp.booking_id', 'left');
            $builder->join('booking', 'booking.id = alert_action_sp.booking_id', 'left');
            $builder->join('bid_det', 'bid_det.post_job_id = alert_action_sp.post_id', 'left');
        }

        $where = [
            'booking_id' => $booking_id,
            'type_id' => $type_id,
            'post_id' => $post_id,
            'user_id' => $user_id,
            'status_code_id' => $status_code_id
        ];

        $builder->where($where);
        $query = $builder->get->getResultArray();

        if ($query != null) {
            return $query;
        } else {
            return null;
        }
    }
}
