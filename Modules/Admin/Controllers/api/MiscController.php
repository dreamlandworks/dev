<?php

namespace Modules\Admin\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\CommonModel;

class MiscController extends ResourceController
{

public function delete_user(){
	$json = $this->request->getJSON();
	
	$model = new CommonModel;
	if(!array_key_exists('id',$json)||!array_key_exists('key',$json)){
		return $this->respond([
        				'status' => 403,
                        'message' => 'Invalid Parameters'
        		]);
    		}
            else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();
		
		
    		    $api_key = $apiconfig->user_key;
				
				$data = array(
				['login_activity','user_id'],
				['leader_board','sp_id'],
				['complaints','users_id'],
				['address','users_id'],
				['bid_det','users_id'],
				['alert_details','users_id'],
				['offer_used','users_id'],
				['referral','user_id'],
				['search_results','users_id'],
				['sp_det','users_id'],
				['sp_busy_slot','users_id'],
				['sp_location','users_id'],
				['sp_profession','users_id'],
				['sp_review','user_id'],
				['sp_skill','users_id'],
				['sp_subs_plan','users_id'],
				['subs_plan','users_id'],
				['sp_verify','users_id'],
				['suggestion','users_id'],
				['tariff','users_id'],
				['transaction','users_id'],
				['user_bank_details','users_id'],
				['user_lang_list','users_id'],
				['user_review','sp_id'],
				['user_temp_address','users_id'],
				['user_time_slot','users_id'],
				['video_watch','users_id'],
				['wallet_balance','users_id'],
				['user_details','id'],
				['users','id']
				);
				
				
				if($key == $api_key) {
					
					foreach($data as $det){
							$i = 0;
							
							if($i<count($det)){
									$model->delete_records_dynamically($det[$i], $det[$i+1], $json->id);
									$i++;
							}
							
					}
					
					}else{
						return $this->respond([
							'status' => 403,
                            'message' => 'Access Denied ! Authentication Failed'
            			]);
					}
				
			return $this->respond([
							'status' => 200,
                            'message' => 'Successfully deleted'
            			]);	
	}
}



}