<?php

namespace Modules\User\Models;

use CodeIgniter\Model;

include(ROOTPATH . 'vendor/paytm/paytmchecksum/PaytmChecksum.php');

use Paytmchecksum;

class PaytmModel extends Model
{

    //---------------------------------------------------------GET RESCHEDULE INFO----------------------------------------------------------
    //-----------------------------------------------------------***************------------------------------------------------------------    

    function gettxn($order_id, $amount, $user_id)
    {

        // $mid = 'APrhhJ49874327306737'; //Demo
        $mid = 'vruhtJ06924265556375'; //Production
        // $m_key = 'tO9EPtyq#fgdNilU'; //Demo
        $m_key = 'ZUYV#XVaPsHvYuLq'; //production

        // $call_back = "https://securegw-stage.paytm.in/theia/paytmCallback?ORDER_ID=" . $order_id; //Demo
        $call_back = "https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=".$order_id; //Production
        $paytmParams = array();
        // $local = new PaytmChecksum;

        $paytmParams["body"] = array(
            "requestType"   => "Payment",
            "mid"           => $mid, 
            // "websiteName"   => "WEBSTAGING", 
            "websiteName"   => "DEFAULT",
            "orderId"       => $order_id,
            "callbackUrl"   => $call_back,
            "txnAmount"     => array(
                "value"     => $amount,
                "currency"  => "INR",
            ),
            "userInfo"      => array(
                "custId"    => $user_id,
            ),
        );

        // print_r($paytmParams);
        // exit;

        /*
* Generate checksum by parameters we have in body
* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
*/
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $m_key);

        $paytmParams["head"] = array(
            "signature"    => $checksum,
            "channelId" => "WAP"
        );

        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        /* for Staging */
        // $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=" . $mid . "&orderId=" . $order_id;

        /* for Production */
        $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=".$mid."&orderId=".$order_id;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $response = curl_exec($ch);
        return $response;
    }

    function verify_txn($order_id)
    {

        // $mid = 'APrhhJ49874327306737'; //Demo
        $mid = 'vruhtJ06924265556375'; //Production
        // $m_key = 'tO9EPtyq#fgdNilU'; //Demo
        $m_key = 'ZUYV#XVaPsHvYuLq'; //production


        /* initialize an array */
        $paytmParams = array();

        /* body parameters */
        $paytmParams["body"] = array(

            /* Find your MID in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys */
            "mid" => $mid,

            /* Enter your order id which needs to be check status for */
            "orderId" => $order_id,
        );

        /**
         * Generate checksum by parameters we have in body
         * Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
         */
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $m_key);

        /* head parameters */
        $paytmParams["head"] = array(

            /* put generated checksum value here */
            "signature"    => $checksum
        );

        /* prepare JSON string for request */
        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        /* for Staging */
        // $url = "https://securegw-stage.paytm.in/v3/order/status";

        /* for Production */
        $url = "https://securegw.paytm.in/v3/order/status";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);
        
        return $response;
    }

   
   
    function processTransaction($order_id,$txn_token)
    {
        $paytmParams = array();

        // $mid = 'APrhhJ49874327306737'; //Demo
        $mid = 'vruhtJ06924265556375'; //Production
        // $m_key = 'tO9EPtyq#fgdNilU'; //Demo
        $m_key = 'ZUYV#XVaPsHvYuLq'; //production
        //$call_back = base_url()."/user/verify_txn/$order_id";
        // $call_back = "https://securegw-stage.paytm.in/theia/paytmCallback?ORDER_ID=" . $order_id; //Demo
        $call_back = "https://securegw.paytm.in/theia/paytmCallback?ORDER_ID=".$order_id; //Production
        $paytmParams = array();
        // $local = new PaytmChecksum;


        $paytmParams["body"] = array(
            "requestType" => "NATIVE",
            "mid"         => $mid,
            "orderId"     => $order_id,
            "paymentMode" => "UPI_INTENT",
            "payerAccount"    => "9989522372@paytm"
        );

        $paytmParams["head"] = array(
            "txnToken"    => $txn_token,
            "channelId" => 'WAP',
        );

        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        /* for Staging */
        // $url = "https://securegw-stage.paytm.in/theia/api/v1/processTransaction?mid".$mid."&orderId=".$order_id;

        /* for Production */
        $url = "https://securegw.paytm.in/theia/api/v1/processTransaction?mid=".$mid."&orderId=".$order_id;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $response = curl_exec($ch);
        // print_r($response);
        return $response;
    }
}
