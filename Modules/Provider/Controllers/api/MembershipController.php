<?php

namespace Modules\Provider\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;

helper('Modules\User\custom');

class MembershipController extends ResourceController
{

	//---------------------------------------------------------Membership Payments-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function membership_payments()
	{
		if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {
            //getting JSON data from API
            $json = $this->request->getJSON();
            /*echo "<pre>";
            print_r($json);
            echo "</pre>";
            exit;*/
            
            if(!array_key_exists('plan_id',$json) || !array_key_exists('period',$json) 
                || !array_key_exists('date',$json) || !array_key_exists('amount',$json) 
                || !array_key_exists('reference_id',$json) || !array_key_exists('payment_status',$json) 
                || !array_key_exists('sp_id',$json) || !array_key_exists('key',$json)
                            ) {
    		    return $this->respond([
        				'status' => 403,
                        'message' => 'Invalid Parameters'
        		]);
    		}
            else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();
		
    		    $api_key = $apiconfig->provider_key;
    		    
    		    if($key == $api_key) {
    		        $common = new CommonModel();
    		        
    		        //Insert into Transaction table
    		        $arr_transaction = array(
        		          'name_id' => 11, //Membership
                          'date' => $json->date,
                          'amount' => $json->amount,
                          'type_id' => 1, //Receipt/Credit
                          'users_id' => $json->sp_id,
                          'method_id' => 1, //Online Payment
                          'reference_id' => $json->reference_id,
                          'booking_id' => 1,
                          'payment_status' => $json->payment_status, //'Success', 'Failure'
                    );
                    $transaction_id = $common->insert_records_dynamically('transaction', $arr_transaction);
                    
                    if($transaction_id > 0) { //Insert into sp_subs_plan
                        if($json->payment_status == 'Success') {
                            //Check if the record exists
    		                $arr_subs_plan_details = $common->get_details_dynamically('sp_subs_plan', 'users_id', $json->sp_id);
                            if($arr_subs_plan_details == "failure") {
                                $arr_membership_payments_ins = array(
                                      'users_id' => $json->sp_id,
                                      'date' => $json->date,
                    		          'plans_id' => $json->plan_id,
                    		          'start_date' => $json->date,
                    		          'end_date' => date('Y-m-d H:i:s', strtotime($json->date . " +".$json->period." days")),
                                      'transaction_id' => $transaction_id, 
                                );
                                //Insert into sp_subs_plan
                                $common->insert_records_dynamically('sp_subs_plan', $arr_membership_payments_ins);
                            }
                            else {
                                $arr_membership_payments_upd = array(
                                      'date' => $json->date,
                    		          'plans_id' => $json->plan_id,
                    		          'start_date' => $json->date,
                    		          'end_date' => date('Y-m-d H:i:s', strtotime($json->date . " +".$json->period." days")),
                                      'transaction_id' => $transaction_id, 
                                );
                                //Update sp_subs_plan
                                $common->update_records_dynamically('sp_subs_plan', $arr_membership_payments_upd, 'users_id', $json->sp_id);
                            }
                        }
                        
        		        return $this->respond([
            			    "transaction_id" => $transaction_id,
            				"status" => 200,
            				"message" => "Success",
            			]);
                    }
            		else {
            		    return $this->respond([
        					"status" => 404,
        					"message" => "Failed to Activate Membership"
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
	}
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
}
