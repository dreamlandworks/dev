<?php

namespace Modules\Provider\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;

class LeaderboardController extends ResourceController
{

    //------------------------------------------------------GET LIST OF SP Leaderboard ---------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    /**
     * Get the list of SP Leaderboard
     * 
     * This function can be used to get the list of 
     * SP.
     * <code>
     * get_leaderboard_list();
     * @param key
     * </code>
     */
    public function get_leaderboard_list()
    {
        $json = $this->request->getVar();
        if (!isset($json['key']) || !isset($json['city_id']) || !isset($json['sp_id'])) {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->provider_key;

            if ($key == $api_key) {
                $misc_model = new MiscModel();

                $arr_sp[$json['sp_id']] = $json['sp_id'];
                $arr_sp_key = array();

                $arr_ratings = array();
                $arr_sp_ratings = array();


                $res = $misc_model->get_leaderboard_details($json['city_id'], $json['sp_id']);
                if ($res != 'failure') {
                    foreach ($res as $key => $rdata) {

                        $rid[$key]['users_id'] = $rdata['users_id'];

                        if ($rid[$key]['users_id'] == $json['sp_id']) {

                            $arr_ratings[0]["fname"] = $rdata["fname"];
                            $arr_ratings[0]["lname"] = $rdata["lname"];
                            $arr_ratings[0]["profession"] = $rdata["profession"];
                            $arr_ratings[0]["profile_pic"] = $rdata["profile_pic"];
                            $arr_ratings[0]["points_count"] = $rdata["points_count"];
                            $arr_ratings[0]["rank"] = 0;
                            $arr_ratings[0]["rating"] = 0;
                            $arr_ratings[0]["total_people"] = 0;
                            $arr_ratings[0]['rank'] = ($key + 1);
                        } else {
                            $arr_sp_ratings[$key]["users_id"] = $rdata["users_id"];
                            $arr_sp_ratings[$key]["fname"] = $rdata["fname"];
                            $arr_sp_ratings[$key]["lname"] = $rdata["lname"];
                            $arr_sp_ratings[$key]["profession"] = $rdata["profession"];
                            $arr_sp_ratings[$key]["profile_pic"] = $rdata["profile_pic"];
                            $arr_sp_ratings[$key]["points_count"] = $rdata["points_count"];
                            $arr_sp_ratings[$key]["rank"] = ($key + 1);
                            $arr_sp_ratings[$key]["rating"] = 0;
                            $arr_sp_ratings[$key]["total_people"] = 0;

                            $arr_sp[$rdata['id']] = $rdata['users_id'];
                            $arr_sp_key[$rdata['id']] = $key;
                        }
                    }

                    //Get reviews
                    $arr_reviews = $misc_model->get_sp_review_data($arr_sp);
                    if ($arr_reviews != 'failure') {
                        foreach ($arr_reviews as $rev_data) {
                            $rating = $rev_data['sum_average_review'] / $rev_data['total_people'];
                            if ($rev_data['sp_id'] == $json['sp_id']) {
                                $arr_ratings[0]["rating"] = number_format($rating, 1, '.', '');
                                $arr_ratings[0]["total_people"] = $rev_data['total_people'];
                            }else{
                                $arr_sp_ratings[$key]["rating"] = number_format($rating, 1, '.', '');
                                $arr_sp_ratings[$key]["total_people"] = $rev_data['total_people'];
                            }
                        }
                    }

                    if ((count($arr_sp_ratings) > 0) || (count($arr_ratings) > 0)) {
                        return $this->respond([
                            "status" => 200,
                            "message" => "Success",
                            "sp_data" => (count($arr_ratings) > 0) ? $arr_ratings[0] : array(),
                            "data" => (count($arr_sp_ratings) > 0) ? $arr_sp_ratings : array(),
                        ]);
                    }


                    return $this->respond([
                        "status" => 200,
                        "sp_data" => $arr_ratings,
                        "other_data" => $arr_sp_ratings
                    ]);
                } else {
                    return $this->respond([
                        'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
                    ]);
                }
            }
        }
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------


}
