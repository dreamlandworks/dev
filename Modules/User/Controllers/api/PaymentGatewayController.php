<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;

// require_once("PaytmChecksum.php");

use DateTime;
// use PaytmChecksum;

helper('Modules\User\custom');

class BookingController extends ResourceController
{

    public function gettxn()
    {

        require_once("PaytmChecksum.php");

        $paytmParams = array();

        $paytmParams["body"] = array(
            "requestType"   => "Payment",
            "mid"           => "APrhhJ49874327306737",
            "websiteName"   => "https://dev.satrango.com",
            "orderId"       => "SMID-00012",
            "callbackUrl"   => "https://dev.satrango.com/gatewayResponse",
            "txnAmount"     => array(
                "value"     => "1.00",
                "currency"  => "INR",
            ),
            "userInfo"      => array(
                "custId"    => "CUST_001",
            ),
        );

        /*
* Generate checksum by parameters we have in body
* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 
*/
        $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), "tO9EPtyq#fgdNilU");

        $paytmParams["head"] = array(
            "signature"    => $checksum
        );

        $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);

        /* for Staging */
        $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=APrhhJ49874327306737&orderId=SMID-00012";

        /* for Production */
        // $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?mid=YOUR_MID_HERE&orderId=ORDERID_98765";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        $response = curl_exec($ch);
        print_r($response);
    }

    public function gatewayResponse(){
        
    }
}
