<?php



namespace Modules\User\Controllers\api;



use CodeIgniter\RESTful\ResourceController;

include(ROOTPATH . 'vendor/paytm/paytmchecksum/PaytmChecksum.php');



use DateTime;

use PaytmChecksum;



// use PaytmChecksum;





class PaytmController extends ResourceController

{



    public function gettxn()

    {



        if ($this->request->getMethod() != 'post') {



            $this->respond([

                "status" => 405,

                "message" => "Method Not Allowed"

            ]);

        } else {



            $json = $this->request->getJSON();



            if (

                !array_key_exists('order_id', $json) || !array_key_exists('amount', $json) || !array_key_exists('user_id', $json) || !array_key_exists('key', $json)

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



                    $mid = 'APrhhJ49874327306737'; //vruhtJ06924265556375

                    $m_key = 'tO9EPtyq#fgdNilU'; //ZUYV#XVaPsHvYuLq

                    

                    $paytmParams = array();

                    // $local = new PaytmChecksum;



                    $paytmParams["body"] = array(

                        "requestType"   => "Payment",

                        "mid"           => $mid, //

                        "websiteName"   => "WEBSTAGING", //DEFAULT

                        "orderId"       => $json->order_id,

                        "callbackUrl"   => "https://dev.satrango.com/gettxn",

                        "txnAmount"     => array(

                            "value"     => $json->amount,

                            "currency"  => "INR",

                        ),

                        "userInfo"      => array(

                            "custId"    => $json->user_id,

                        ),

                    );



                    /*

* Generate checksum by parameters we have in body

* Find your Merchant Key in your Paytm Dashboard at https://dashboard.paytm.com/next/apikeys 

*/

                    $checksum = PaytmChecksum::generateSignature(json_encode($paytmParams["body"], JSON_UNESCAPED_SLASHES), $m_key);



                    $paytmParams["head"] = array(

                        "signature"    => $checksum

                    );



                     $post_data = json_encode($paytmParams, JSON_UNESCAPED_SLASHES);



                    /* for Staging */

                    $url = "https://securegw-stage.paytm.in/theia/api/v1/initiateTransaction?mid=".$mid."&orderId=".$json->order_id;



                    /* for Production */

                    // $url = "https://securegw.paytm.in/theia/api/v1/initiateTransaction?".$mid."&orderId=".$json->order_id;



                    $ch = curl_init($url);

                    curl_setopt($ch, CURLOPT_POST, 1);

                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

                    $response = curl_exec($ch);

                    print_r($response);

                    exit;



                    return $this->respond([

                        'status' => 200,

                        'message' => $response

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

}

