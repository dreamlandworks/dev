<?php

namespace Modules\Admin\Models;

use CodeIgniter\Model;

class CronModel extends Model
{
    public function get_lien_details()
    {

        $builder = $this->db->table('lien_table');
        $builder->select('*');
        $builder->where('lien_end <', date('Y-m-d H:i:s'));
        $result = $builder->get()->getResultArray();

        if (count($result) > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }


    public function get_user_plan_det($type)
    {

        if ($type = 1) { //users
        
            $builder = $this->db->table('subs_plan');
            $builder->select('user_plans.name as plan_name, users_id, max(end_date) as end_date');
            $builder->join('user_plans', 'user_plans.id = subs_plan.plans_id');
        
        } elseif ($type = 2) { //SP
        
            $builder = $this->db->table('sp_subs_plan');
            $builder->select('sp_plans.name as plan_name, users_id, max(end_date) as end_date');
            $builder->join('sp_plans', 'sp_plans.id = sp_subs_plan.plans_id');
        }

        $builder->groupBy('users_id');
        $result = $builder->get()->getResultArray();

        if (count($result) > 0) {
            return $result;
        } else {
            return 'failure';
        }
    }
}
