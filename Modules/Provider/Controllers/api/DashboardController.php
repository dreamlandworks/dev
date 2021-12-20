<?php

namespace Modules\Provider\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;

class DashboardController extends ResourceController
{

	//------------------------------------------------------GET SP Dashboard ---------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	/**
	 * Get the SP Dashboard
	 * 
	 * This function can be used to get the list of 
	 * SP.
	 * <code>
	 * get_leaderboard_list();
	 * @param key
	 * </code>
	 */
	public function get_sp_dasboard_list()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json) || !array_key_exists('sp_id',$json) || !array_key_exists('city_id',$json)) {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
		else {
		    $key = md5($json['key']); //Dld0F54x99UeL8nZkByWC0BwUEi4aF4O
		    $apiconfig = new \Config\ApiConfig();
		    
    		$api_key = $apiconfig->provider_key;
    		
    		if($key == $api_key) {
    		    $misc_model = new MiscModel();
    		    
    		    $sp_id = $json['sp_id'];
    		    $bookings_completed = 0;
    		    $earnings = 0;
    		    $commission = 0;
    		    $sp_rank = 0;
        		$sp_rating = 0;
        		$sp_points = 0;
        		$competitor_rank = 0;
        		$competitor_name = "";
        		$arr_sp_ratings = array();
    		    
    		    //Get Total Booking Count
        		$total_bookings = $misc_model->get_sp_booking_count($sp_id);
        		
        		//Get Total Completed Bookings
        		$arr_bookings_completed = $misc_model->get_sp_booking_completed($sp_id);
        		if($arr_bookings_completed != 'failure') {
        		    $bookings_completed = $arr_bookings_completed['booking_completed'];
        		    $earnings = $arr_bookings_completed['amount'];
        		}
        		
        		//Get Total Bids Count
        		$total_bids = $misc_model->get_sp_bids_count($sp_id);
        		
        		//Get Total Bids Awarded
        		$bids_awarded = $misc_model->get_sp_bids_awarded($sp_id);
        		
        		$res = $misc_model->get_leaderboard_details($json['city_id'],$sp_id);
        		if($res != 'failure') {
        		    foreach($res as $key => $rdata) {
        		        if($sp_id == $rdata["id"]) {
    		                $sp_rank = ($key + 1);
    		                $sp_points = $rdata["points_count"];
            		    }
            		    else {
    		                $arr_sp_ratings[$key]["fname"] = $rdata["fname"];
            		        $arr_sp_ratings[$key]["lname"] = $rdata["lname"];
            		        $arr_sp_ratings[$key]["profession"] = $rdata["profession"];
            		        $arr_sp_ratings[$key]["profile_pic"] = $rdata["profile_pic"];
                            $arr_sp_ratings[$key]["points_count"] = $rdata["points_count"];
            		        $arr_sp_ratings[$key]["rank"] = ($key + 1);
            		        $arr_sp_ratings[$key]["rating"] = 0;
        		            $arr_sp_ratings[$key]["total_people"] = 0;
            		        
            		        $arr_sp[$rdata['id']] = $rdata['id'];
            		        $arr_sp_key[$rdata['id']] = $key;
    		            }
        		    }
        		}
        		
        		if(array_key_exists(($sp_rank-1),$arr_sp_ratings)) {
        		    $competitor_rank = $arr_sp_ratings[$sp_rank-1]["rank"];
        		    $competitor_name = $arr_sp_ratings[$sp_rank-1]["fname"]." ".$arr_sp_ratings[$sp_rank-1]["lname"];
        		}
        		
        		$arr_sp[$json['sp_id']] = $json['sp_id'];
        		
        		//Get reviews
        		$arr_reviews = $misc_model->get_sp_review_data($arr_sp);
        		if($arr_reviews != 'failure') {
        		    foreach($arr_reviews as $rev_data) {
        		        $sp_rating = $rev_data['sum_average_review']/$rev_data['total_people'];
        		    }
        		}
    		    
    		    return $this->respond([
    				"status" => 200,
    				"message" => "Success",
    				"total_bookings" => $total_bookings,
    				"bookings_completed" => $bookings_completed,
    				"earnings" => $earnings,
    				"total_bids" => $total_bids,
    				"bids_awarded" => $bids_awarded,
    				"sp_rank" => $sp_rank,
    				"sp_rating" => $sp_rating,
    				"sp_points" => $sp_points,
    				"competitor_rank" => $competitor_rank,
    				"competitor_name" => $competitor_name,
    				"commission" => $commission,
    			]);
    		}
    		else {
    		    return $this->respond([
        				'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
        			]);
    		}
		}
	}


	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
	
	
}
