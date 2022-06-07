<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;
use Modules\User\Models\PaytmModel;

helper('Modules\User\custom');

class MembershipController extends ResourceController
{

    //---------------------------------------------------------Membership Payments for User-------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------
    public function membership_payments_txn_user()
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

            if (
                !property_exists($json, 'amount') || !property_exists($json, 'user_id')
                || !property_exists($json, 'key')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $paytm = new PaytmModel();
                    $date = date('Y-m-d H:i:s');

                    //Get New Plan Order ID
                    $order_id = "PLNU_" . date('Ymd_his_U');

                    //Get Paytm TXNNo for the Booking
                    $result = $paytm->gettxn($order_id, $json->amount, $json->user_id);
                    $result = json_decode($result, true);

                    // echo "<pre>";
                    // print_r($result);
                    // echo "</pre>";
                    // exit;


                    return $this->respond([
                        "order_id" => $order_id,
                        "txn_id" => (!isset($result['body']['txnToken']) ? "" : $result['body']['txnToken']),
                        "amount" => $json->amount,
                        "status" => 200,
                        "message" => "Success",
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


    //---------------------------------------------------------Membership Payments for User-------------------------------------------------
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

            if (
                !property_exists($json, 'plan_id') || !property_exists($json,'period')
                || !property_exists($json,'date') || !property_exists($json,'amount') || !property_exists($json,'w_amount')
                || !property_exists($json,'order_id')
                || !property_exists($json,'users_id') || !property_exists($json,'key')
            ) {
                return $this->respond([
                    'status' => 403,
                    'message' => 'Invalid Parameters'
                ]);
            } else {
                $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
                $apiconfig = new \Config\ApiConfig();

                $api_key = $apiconfig->user_key;

                if ($key == $api_key) {
                    $common = new CommonModel();
                    $paytm = new PaytmModel();
                    $date = date('Y-m-d H:i:s');

                    $result = $paytm->verify_txn($json->order_id);
                    $result = json_decode($result, true);

                    if ($json->amount != 0) {
                        $payment_status = ($result['body']['resultInfo']['resultStatus'] == 'TXN_FAILURE' ? "TXN_FAILURE" : "TXN_SUCCESS");
                    } else {
                        $payment_status = "TXN_SUCCESS";
                    }


                    $arr_transaction = array();

                    if ($json->amount != 0 && $result['body']['resultInfo']['resultStatus'] == 'TXN_FAILURE') {

                        $arr_transaction['payment_status'] = $result['body']['resultInfo']['resultStatus'];
                        $arr_transaction['txnId'] = $result['body']['txnId'];
                    } elseif ($json->amount != 0 && $result['body']['resultInfo']['resultStatus'] == 'TXN_SUCCESS') {

                        $arr_transaction['payment_status'] = $result['body']['resultInfo']['resultStatus'];
                        $arr_transaction['txnId'] = $result['body']['txnId'];
                        $arr_transaction["bankTxnId"] =  $result['body']['bankTxnId'];
                        $arr_transaction["txnType"] = $result['body']['txnType'];
                        $arr_transaction["gatewayName"] =  $result['body']['gatewayName'];
                        $arr_transaction["bankName"] = (property_exists('bankName', $result['body']) ? $result['body']['bankName'] : "");
                        $arr_transaction["paymentMode"] = $result['body']['paymentMode'];
                        $arr_transaction["refundAmt"] = $result['body']['refundAmt'];
                    }

                    if ($json->w_amount == 0) {

                        //Insert into Transaction table
                        $arr_transaction['name_id'] = 2; //Booking Amount
                        $arr_transaction['date'] = $json->date;
                        $arr_transaction['amount'] = $json->amount;
                        $arr_transaction['type_id'] = 1; //Receipt/Credit
                        $arr_transaction['users_id'] = $json->users_id;
                        $arr_transaction['method_id'] = 1; //Online Payment
                        $arr_transaction['booking_id'] = '0';
                        $arr_transaction['order_id'] = $json->order_id;


                        $transaction_id = $common->insert_records_dynamically('transaction', $arr_transaction);
                    } elseif ($json->w_amount != 0 && $json->amount == 0) {

                        //Insert into Transaction table
                        $arr_transaction1 = array(
                            'name_id' => 2, //Booking Amount
                            'date' => $json->date,
                            'amount' => $json->w_amount,
                            'type_id' => 1, //Receipt/Credit
                            'users_id' => $json->users_id,
                            'method_id' => 2, //Wallet Transfer
                            'reference_id' => "W-" . rand(1, 999999),
                            'booking_id' => '0',
                            'order_id' => $json->order_id,
                            'payment_status' => $payment_status,
                            'created_dts' => date('Y-m-d H:i:s')
                        );
                        $transaction_id = $common->insert_records_dynamically('transaction', $arr_transaction1);
                    } elseif ($json->w_amount != 0 && $json->amount != 0) {

                        //Insert into Transaction table

                        //Wallet Transfer Entry
                        $arr_transaction1 = array(
                            'name_id' => 2, //Booking Amount
                            'date' => $json->date,
                            'amount' => $json->w_amount,
                            'type_id' => 1, //Receipt/Credit
                            'users_id' => $json->users_id,
                            'method_id' => 2, //Wallet Transfer
                            'reference_id' => "W-" . rand(1, 999999),
                            'booking_id' => '0',
                            'order_id' => $json->order_id,
                            'payment_status' => $payment_status, //'Success', 'Failure'
                            'created_dts' => date('Y-m-d H:i:s')
                        );
                        $transaction_id1 = $common->insert_records_dynamically('transaction', $arr_transaction1);


                        //Bank Transfer Entry

                        $arr_transaction['name_id'] = 2; //Booking Amount
                        $arr_transaction['date'] = $json->date;
                        $arr_transaction['amount'] = $json->amount;
                        $arr_transaction['type_id'] = 1; //Receipt/Credit
                        $arr_transaction['users_id'] = $json->users_id;
                        $arr_transaction['method_id'] = 1; //Online Payment
                        $arr_transaction['booking_id'] = '0';
                        $arr_transaction['order_id'] = $json->order_id;

                        $transaction_id = $common->insert_records_dynamically('transaction', $arr_transaction);
                    }

                    if ($transaction_id > 0) { //Insert into subs_plan

                        //Check if the record exists
                        $end_date = date('Y-m-d H:i:s', strtotime($json->date . " +" . $json->period . " days"));
                        
                        $arr_membership_payments_ins = array(
                                'users_id' => $json->users_id,
                                'date' => $json->date,
                                'plans_id' => $json->plan_id,
                                'start_date' => $json->date,
                                'end_date' => $end_date,
                                'transaction_id' => $transaction_id,
                                'txn_status' => $payment_status
                            );
                            //Insert into subs_plan
                            $common->insert_records_dynamically('subs_plan', $arr_membership_payments_ins);
                        

                        if ($payment_status == 'TXN_SUCCESS') {

                            //Insert into alert_regular_users table

                            $arr_alerts = array(
                                'type_id' => 4,
                                'description' => "Your new plan is activated successfully and valid till " . $end_date,
                                'user_id' => $json->users_id,
                                'profile_pic_id' => $json->users_id,
                                'status' => 2,
                                'created_on' => $json->date,
                                'updated_on' => $json->date
                            );

                            $common->insert_records_dynamically('alert_regular_user', $arr_alerts);


                            return $this->respond([
                                "transaction_id" => $transaction_id,
                                "status" => 200,
                                "message" => "Success",
                            ]);
                        } elseif ($payment_status == "TXN_FAILURE") {

                            //Insert into alert_regular_users table

                            $arr_alerts = array(
                                'type_id' => 4,
                                'description' => "Your plan not activated due to transaction failure ",
                                'user_id' => $json->users_id,
                                'profile_pic_id' => $json->users_id,
                                'status' => 2,
                                'created_on' => $json->date,
                                'updated_on' => $json->date
                            );

                            $common->insert_records_dynamically('alert_regular_user', $arr_alerts);

                            return $this->respond([
                                "status" => 404,
                                "message" => "Failed to Activate Membership"
                            ]);

                        }
                       
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
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
}
