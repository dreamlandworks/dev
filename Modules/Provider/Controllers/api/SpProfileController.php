<?php

namespace Modules\Provider\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\CommonModel;
use Modules\Provider\Models\ServiceProviderModel;

helper('Modules\User\custom');

class SpProfileController extends ResourceController
{


    //--------------------------------------------------GET SP Professional details STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to show sp Professional details
     * 
     * Call to this function outputs sp Professional details
     * @param int $id
     * @return [JSON]
     */
    public function get_sp_details()
	{
		$json = $this->request->getVar();
		if(!array_key_exists('key',$json) || !array_key_exists('sp_id',$json)) {
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
    		    $common = new CommonModel();
    		    $sp = new ServiceProviderModel();
    		    
        		$sp_dtails = $sp->get_sp_activation_details($json['sp_id']);
        
        		if ($res != 'failure') {
        			return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $sp_dtails
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No details"
        			]);
        		}
    		}
    		else {
    		    return $this->respond([
        				'status' => 403,
                        'message' => 'Access Denied ! Authentication Failed'
        			]);
    		}
		}
	}
    //--------------------------------------------------GET USER DETAILS ENDS------------------------------------------------------------

}
