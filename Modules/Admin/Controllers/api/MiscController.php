<?php

namespace Modules\Admin\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\CommonModel;
use Modules\Admin\Models\CronModel;
use Modules\Admin\Models\MiscModel;
use Modules\Users\Models\MiscModel as AnotherModel;
use DateTime;

class MiscController extends ResourceController
{

    public function delete_user()
    {
        $json = $this->request->getJSON();

        $model = new CommonModel;
        if (!property_exists($json, 'id') || !property_exists($json, 'key')) {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL
            $apiconfig = new \Config\ApiConfig();


            $api_key = $apiconfig->user_key;

            $data = array(
                ['login_activity', 'user_id'],
                ['leader_board', 'sp_id'],
                ['complaints', 'users_id'],
                ['address', 'users_id'],
                ['bid_det', 'users_id'],
                ['alert_details', 'users_id'],
                ['offer_used', 'users_id'],
                ['referral', 'user_id'],
                ['search_results', 'users_id'],
                ['sp_det', 'users_id'],
                ['sp_busy_slot', 'users_id'],
                ['sp_location', 'users_id'],
                ['sp_profession', 'users_id'],
                ['sp_review', 'user_id'],
                ['sp_skill', 'users_id'],
                ['sp_subs_plan', 'users_id'],
                ['subs_plan', 'users_id'],
                ['sp_verify', 'users_id'],
                ['suggestion', 'users_id'],
                ['tariff', 'users_id'],
                ['transaction', 'users_id'],
                ['user_bank_details', 'users_id'],
                ['user_lang_list', 'users_id'],
                ['user_review', 'sp_id'],
                ['user_temp_address', 'users_id'],
                ['user_time_slot', 'users_id'],
                ['video_watch', 'users_id'],
                ['wallet_balance', 'users_id'],
                ['user_details', 'id'],
                ['users', 'id']
            );


            if ($key == $api_key) {

                foreach ($data as $det) {
                    $i = 0;

                    if ($i < count($det)) {
                        $model->delete_records_dynamically($det[$i], $det[$i + 1], $json->id);
                        $i++;
                    }
                }
            } else {
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


    public function hourly_cron()
    {
        //Dependencies
        $cron = new CronModel();
        $common = new CommonModel();
        $misc = new MiscModel();
        $user_misc = new AnotherModel();

        // -----------------------------------------Cron Job 1 start ----------------------------------------------
        //Removal of Lien Amount and add to SP wallet
        $data = $cron->get_lien_details();

        if ($data != 'failure') {
            foreach ($data as $dat) {

                //Make entry in to wallet for sp payment
                //Check if the wallet is created
                $arr_wallet_details = $common->get_details_dynamically('wallet_balance', 'users_id', $dat['user_id']);

                // print_r($arr_wallet_details);
                // exit;

                if ($arr_wallet_details != 'failure') {
                    //Get total amount and blocked amount
                    $wallet_amount = $arr_wallet_details[0]['amount'] + $dat['amount'];
                    $wallet_amount_blocked = $arr_wallet_details[0]['amount_blocked'] - $dat['amount'];

                    $arr_update_wallet_data = array(
                        'amount' => $wallet_amount,
                        'amount_blocked' => $wallet_amount_blocked
                    );
                    $common->update_records_dynamically('wallet_balance', $arr_update_wallet_data, 'users_id', $json->users_id);
                } else {
                    $arr_wallet_data = array(
                        'users_id' => $dat['user_id'],
                        'amount' => $dat['amount'],
                        'amount_blocked' => '0'
                    );
                    $common->insert_records_dynamically('wallet_balance', $arr_wallet_data);
                }
            }
        }

        // -----------------------------------------Cron Job 1 Finish ----------------------------------------------

        // -----------------------------------------Cron Job 2 start ----------------------------------------------
        //Change status of Bookings expired
        $res = $misc->get_expired_bookings();

        if ($res != 'failure') {
            foreach ($res as $r) {
                //update status to expired
                $misc->update_expired_bookings($r['id']);

                $booking_data = $user_misc->booking_with_time_slot($r['id']);
                $users_id = $booking_data[0]['users_id'];
                $sp_id = $booking_data[0]['sp_id'];

                $booking_amount = $booking_data[0]['amount'];
                $tot_amount = $booking_data[0]['amount'] + $booking_data[0]['cgst'] + $booking_data[0]['sgst'];


                //Cancellation Charges for SP Wallet
                $ch = $misc->get_cancellation_charges();
                $cancellation_charges = $ch[0]['amount'];

                //Update Booking Table with New Amounts
                $arr = [
                    'amount' => 0,
                    'sgst' => 0,
                    'cgst' => 0,
                    'status_id' => 28
                ];

                $common->update_records_dynamically('booking', $arr, 'id', $r['id']);

                //Update Cancel Booking Table with Cancel Status 25 (Cancelled by SP)

                $arr1 = [
                    'booking_id' => $r['id'],
                    'reasons' => "SP Not started booking hence expired",
                    'cancelled_by' => $r['sp_id'],
                    'status_id' => 25
                ];

                $common->insert_records_dynamically('cancel_booking', $arr1);

                //Effect Charges to SP Wallet

                $wall = $common->get_details_dynamically('wallet_balance', 'users_id', $r['sp_id']);

                if ($wall != 'failure') {

                    $arr2 = [
                        'sp_id' => $r['sp_id'],
                        'amount' => $cancellation_charges,
                        'booking_id' => $r['id']
                    ];

                    $common->insert_records_dynamically('wallet_debts', $arr2);
                } else {

                    $arr3 = [

                        'amount' => $wall[0]['amount'] - $cancellation_charges
                    ];

                    $common->update_records_dynamically('wallet_balance', $arr3, 'users_id', $r['sp_id']);
                }


                //Refund of Amount to User Wallet

                $wall = $common->get_details_dynamically('wallet_balance', 'users_id', $r['users_id']);

                if ($wall != 'failure') {

                    $arr4 = [
                        'users_id' => $r['users_id'],
                        'amount' => $tot_amount,
                        'amount_blocked' => 0
                    ];

                    $common->insert_records_dynamically('wallet_balance', $arr4);
                } else {

                    $arr5 = [

                        'amount' => $wall[0]['amount'] + $tot_amount,
                        'amount_blocked' => $wall[0]['amount_blocked'] - $tot_amount
                    ];

                    $common->update_records_dynamically('wallet_balance', $arr5, 'users_id', $r['users_id']);
                }

                //Create Entries for Transaction Table      
                $date = date('Y-m-d');
                $arr6 = [
                    [
                        'name_id' => 4,
                        'date' => $date,
                        'amount' => $cancellation_charges,
                        'type_id' => 2,
                        'users_id' => $r['sp_id'],
                        'method_id' => 2,
                        'reference_id' => "W-" . rand(1, 99999),
                        'booking_id' => $r['id'],
                        'payment_status' => "Success",
                        'created_dts' => $date
                    ],
                    [
                        'name_id' => 8,
                        'date' => date('Y-m-d'),
                        'amount' => $tot_amount,
                        'type_id' => 1,
                        'users_id' => $r['users_id'],
                        'method_id' => 2,
                        'reference_id' => "W-" . rand(1, 99999),
                        'booking_id' => $r['id'],
                        'payment_status' => "Success",
                        'created_dts' => $date
                    ]
                ];

                $tra_id = $common->batch_insert_records_dynamically('transaction', $arr6);

                //Update Company Account

                $arr7 = [
                    'platform_fees' => 0,
                    'user_plan_subs' => 0,
                    'sp_plan_subs' => 0,
                    'cancellation_charges' => $cancellation_charges,
                    'receipt_date' => $date,
                    'transaction_id' => $tra_id
                ];

                $common->insert_records_dynamically('company_account', $arr7);

                //Regular Alert to User        

                //Insert into alert_regular_sp
                $arr_alerts = array(
                    'type_id' => 1,
                    'description' => "We are sorry!. Your booking ID:" . $r['id'] . " is expired",
                    'user_id' => $r['sp_id'],
                    'profile_pic_id' => $r['sp_id'],
                    'status' => 2,
                    'created_on' => $date,
                    'updated_on' => $date
                );

                $common->insert_records_dynamically('alert_regular_sp', $arr_alerts);

                //Insert into alert_regular_user
                $arr_alerts1 = array(
                    'type_id' => 1,
                    'description' => "We are sorry!. Your booking ID:" . $r['id'] . "has been expired",
                    'user_id' => $r['users_id'],
                    'profile_pic_id' => $r['users_id'],
                    'status' => 2,
                    'created_on' => $date,
                    'updated_on' => $date
                );

                $common->insert_records_dynamically('alert_regular_user', $arr_alerts1);
            }
        }

        // -----------------------------------------Cron Job 2 Finish ----------------------------------------------

        // -----------------------------------------Cron Job 3 start ----------------------------------------------
        //Dues to be deducted from SP Wallet
        $ded = $common->get_table_details_dynamically('wallet_debts');

        if ($ded != 'failure') {

            foreach ($ded as $d) {

                $data = $misc->get_sp_wallet($d['sp_id']);

                if ($data != 'failure' && $data[0]['amount'] >= $d['amount']) {

                    $arr = [
                        'amount' => $data[0]['amount'] - $d['amount'],
                    ];

                    $common->update_records_dynamically('wallet_balance', $arr, 'users_id', $d['sp_id']);

                    $common->delete_records_dynamically('wallet_debts', 'sp_id', $d['sp_id']);
                }
            }
        }

        // -----------------------------------------Cron Job 3 Finish ----------------------------------------------

    }

    public function daily_cron()
    {
        //Dependencies
        $cron = new CronModel();
        $common = new CommonModel();
        $date = date('Y-m-d H:i:s');


        // -----------------------------------------Cron Job 1 start ----------------------------------------------
        //Create Membership Expiry Alert User
        $data = $cron->get_user_plan_det(1);

        if ($data != 'failure') {
            foreach ($data as $dat) {
                $end = date('Y-m-d', $dat['end_date']);
                $remind = date('Y-m-d', strtotime("tomorrow"));

                if ($remind <= $end) {
                    //Insert into alert_action_user
                    $arr_alerts = [
                        'type_id' => 4,
                        'description' => "Your Premium plan is going to expire on " . $dat['end_date'] . ". Click to renew now",
                        'user_id' => $dat['users_id'],
                        'profile_pic_id' => 'Null',
                        'status' => 2, //unread
                        'created_on' => $date,
                        'api' => 'user/membership_payments_txn_user',
                        'accept_text' => 'Renew Now',
                        'reject_text' => 'Hide',
                        'accept_response' => "",
                        'reject_response' => "",
                        'updated_on' => $date,
                        'booking_id' => "",
                        'post_id' => 'Null',
                        'reschedule_id' => "",
                        'status_code_id' => 9,
                        'created_on' => $date,
                        'expiry' => date('Y-m-d H:i:s', strtotime("+1 Month"))
                    ];
                    $common->insert_records_dynamically('alert_action_user', $arr_alerts);
                }
            }
        }

        // -----------------------------------------Cron Job 1 Finish ----------------------------------------------

        // -----------------------------------------Cron Job 2 start ----------------------------------------------
        //Create Membership Expiry Alert SP
        $data = $cron->get_user_plan_det(2);

        if ($data != 'failure') {
            foreach ($data as $dat) {
                $end = date('Y-m-d', $dat['end_date']);
                $remind = date('Y-m-d', strtotime("tomorrow"));

                if ($remind <= $end) {
                    //Insert into alert_action_user
                    $arr_alerts = [
                        'type_id' => 4,
                        'description' => "Your Premium plan is going to expire on " . $dat['end_date'] . ". Click to renew now",
                        'user_id' => $dat['users_id'],
                        'profile_pic' => 'Null',
                        'status' => 2, //unread
                        'created_on' => $date,
                        'api' => 'user/membership_payments_txn_user',
                        'accept_text' => 'Renew Now',
                        'reject_text' => 'Hide',
                        'accept_response' => "",
                        'reject_response' => "",
                        'updated_on' => $date,
                        'booking_id' => "",
                        'post_id' => 'Null',
                        'reschedule_id' => "",
                        'status_code_id' => 9,
                        'created_on' => $date
                    ];
                    $common->insert_records_dynamically('alert_action_sp', $arr_alerts);
                }
            }
        }

        // -----------------------------------------Cron Job 2 Finish ----------------------------------------------
    }


    function five_minute_cron()
    {

        // -----------------------------------------Cron Job 1 start ----------------------------------------------
        //Change status of Job Posts expired
        $misc = new MiscModel();

        $misc->update_expired_posts();
        // -----------------------------------------Cron Job 1 Finish ----------------------------------------------

        // -----------------------------------------Cron Job 2 start ----------------------------------------------
        //Change status of Reschedule Requests expired
        $misc->update_expired_reschedule_requests();
        // -----------------------------------------Cron Job 2 Finish ----------------------------------------------

    }

    function fifteen_minute_cron()
    {

        $misc = new MiscModel();

        // -----------------------------------------Cron Job 1 start ----------------------------------------------
        //Change status of Actionable Alerts expired
        $misc->update_expired_alerts_sp();
        // -----------------------------------------Cron Job 1 Finish ----------------------------------------------

        // -----------------------------------------Cron Job 2 start ----------------------------------------------
        //Change status of Actionable Alerts expired
        $misc->update_expired_alerts_user();
        // -----------------------------------------Cron Job 2 Finish ----------------------------------------------

    }
}
