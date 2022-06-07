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
                    
                    foreach ($arr_transaction_history as $key => $value){
                        
                        $arr[$key]['date'] = $arr_transaction_history[$key]['date'];
                        $arr[$key]['amount'] = floatval($arr_transaction_history[$key]['amount']);
                        $arr[$key]['reference_id'] = $arr_transaction_history[$key]['reference_id'];
                        $arr[$key]['booking_id'] = $arr_transaction_history[$key]['booking_id'];
                        $arr[$key]['payment_status'] = $arr_transaction_history[$key]['payment_status'];
                        $arr[$key]['transaction_name'] = $arr_transaction_history[$key]['transaction_name'];
                        $arr[$key]['transaction_method'] = $arr_transaction_history[$key]['transaction_method'];
                        $arr[$key]['transaction_type'] = $arr_transaction_history[$key]['transaction_type'];
                      
                    }

                    return $this->respond([
        				"status" => 200,
        				"message" => "Success",
        				// "data" => $arr_transaction_history,
                        "data" => $arr,
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

    //-----------------------------------------------Save User UPI Detail for Easy Checkout------------------------------------------------------------
    public function save_user_upi(){
       // get jason variable by post method
        $json = $this->request->getJSON();
        // check for all values 
        if (!property_exists($json, 'key') || !property_exists($json, 'user_id') || !property_exists($json, 'upi_id')) {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;
            //json data
            $users_id =  $json->user_id;
            $upi_id =  $json->upi_id;


            if ($key == $api_key) {
            
                $misc_model = new MiscModel();
                
                $saveStatus = $misc_model->saveUserUpiDetails($users_id, $upi_id);
                if( $saveStatus== true){
                    return $this->respond([
                        "status" => 200,
                        "message" => "User UPI Added for Quick Checkout",
                    ]);
                }else{
                    return $this->respond([
                        "status" => 200,
                        "message" => "Somthing Went Wrong!",
                    ]);
                }

            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }

    //-----------------------------------------------End Save User UPI Detail for Easy Checkout------------------------------------------------------------
    
    //-----------------------------------------------Get User UPI Detail for Easy Checkout------------------------------------------------------------
    public function get_user_upi()
    {
     
        $json = $this->request->getJSON();
        // check for all values 
        if (!property_exists($json, 'key') || !property_exists($json, 'user_id')) {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;
            //json data
            $users_id =  $json->user_id;

            if ($key == $api_key) {

                $misc_model = new MiscModel();

                $userUpiData = $misc_model->getUserUpiDetails($users_id);
               
                if ($userUpiData != 'failure') {
              
                    return $this->respond([
                        "status" => 200,
                        "message" => "User UPI Ids",
                        "data"=> $userUpiData,
                    ]);
                } else {
                    return $this->respond([
                        "status" => 200,
                        "message" => "No Data to Show",
                    ]);
                }
            } else {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Access Denied ! Authentication Failed'
                ]);
            }
        }
    }

}
