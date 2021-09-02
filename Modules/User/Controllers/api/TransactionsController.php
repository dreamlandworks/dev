<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Config\Mimes;

use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;

use function PHPUnit\Framework\isEmpty;

helper('Modules\User\custom');

class TransactionsController extends ResourceController
{

    //-----------------------------------------------Transaction History STARTS----------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to List User Transaction History
     * 
     * Call to this function will List User Transactions
     */
    public function get_transaction_history()
    {
        $validate_key = $this->request->getVar('key');
        $users_id = $this->request->getVar('users_id');
        
		if($validate_key == "" || $users_id == "") {
		    return $this->respond([
    				'status' => 403,
                    'message' => 'Invalid Parameters'
    		]);
		}
        else {
            $key = md5($validate_key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
            $apiconfig = new \Config\ApiConfig();
	
		    $api_key = $apiconfig->user_key;
		    
		    if($key == $api_key) {
		        $misc_model = new MiscModel();
		        
                //Get users transactions details
                $arr_transaction_history = $misc_model->get_user_transaction_history($users_id);
                
                if ($arr_transaction_history != 'failure') {
                    return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				"data" => $arr_transaction_history,
        			]);
        		} else {
        			return $this->respond([
        				"status" => 200,
        				"message" => "No Data to Show",
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

    //-----------------------------------------------SEARCH RESULT ENDS------------------------------------------------------------

}
