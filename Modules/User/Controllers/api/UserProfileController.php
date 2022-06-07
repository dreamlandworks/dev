<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\User\Models\UsersModel;
use Modules\User\Models\UserDetailsModel;
use Modules\User\Models\AddressModel;
use Modules\User\Models\ReferralModel;
use Modules\Provider\Models\CommonModel;
use Modules\User\Models\MiscModel;

helper('Modules\User\custom');

class UserProfileController extends ResourceController
{


    //--------------------------------------------------GET USER DETAILS STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to show user profile details
     * 
     * Call to this function outputs user details
     * @param int $id
     * @return [JSON]
     */
    public function show_user()
    {
        $json = $this->request->getJSON();
        if (!property_exists($json, 'id') || !property_exists($json, 'city') || !property_exists($json, 'key')) {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            ///$id = $this->request->getJsonVar('id');
            $id = $json->id;
            $con = new UsersModel();
            $con1 = new UserDetailsModel();
            $con2 = new AddressModel();
            $con3 = new ReferralModel();
            $misc_model = new MiscModel();


            //$data = $this->request->getJSON();
            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL


            //Hardcoded Strings
            $maps_key = "AIzaSyBPxm7IE8OmXYUok1ABQoiNX-_bRmELSCs";
            $fcm_key = "AAAAKN1BReU:APA91bGKiUADwwYmrfdxBEKhxle_k7axC4nGQYMDVAU-w3fJ09vDaWNoUfum3KCXr5bJKNcUE2bxtt30_ID6DF1vWHUfBu7grfoc_ncZi13HrKM73Np4POKUrT1ng-FAlK_T7ZQf-kPc";

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {
                //Check whether User Exists or Not
                if (($user = $con->search_user($id)) != null) {

                    $email = $user['email'];
                    $sp_activated = $user['sp_activated'];
                    $fcm_token = $user['fcm_token'];
                    $activation_code = $user['activation_code'];

                    //Get User Details
                    if (($res = $con1->user_details_by_id($id)) != 0) {
                        $fname = $res['fname'];
                        $lname = $res['lname'];
                        $mobile = $res['mobile'];
                        $gender = $res['gender'];
                        $dob = $res['dob'];
                        $profile_pic = (is_null($res['profile_pic']) ? "" : $res['profile_pic']);
                        $ref_id = $res['referral_id'];
                    } else {
                        return $this->respond([
                            "status" => 400,
                            "message" => "Failed to Retrieve User Details"
                        ]);
                    }

                    //Get Address Details

                    if (!is_null($add = $con2->get_by_user_id($id,$json->city))) {
                        $address = $add;
                    } else {
                        $address = array();
                    }

                    //Get Referral ID

                    if (!is_null($ref = $con3->get_details($ref_id))) {
                        $referral_id = $ref['referral_id'];
                    } else {
                        $referral_id = "";
                    }

                    //Get Sub category of SP
                    $arr_subcategory = array();
                    $arr_sp_cat = $misc_model->get_sp_prof_cat($id);
                    if ($arr_sp_cat != 'failure') {
                        foreach ($arr_sp_cat as $skey => $sval) {
                            $arr_subcategory[$skey]['id'] = $sval['subcategory_id'];
                        }
                    }

                    $array = [
                        "fname" => $fname,
                        "lname" => $lname,
                        "mobile" => $mobile,
                        "gender" => $gender,
                        "email_id" => $email,
                        "dob" => $dob,
                        "profile_pic" => $profile_pic,
                        "referral_id" => $referral_id,
                        "address" => $address,
                        "sp_activated" => $sp_activated,
                        "fcm_token" => $fcm_token,
                        "activation_code" => $activation_code,
                        "subcategories" => $arr_subcategory,
                        "maps_key" => $maps_key,
                        "fcm_key" => $fcm_key
                    ];

                    return $this->respond([
                        "status" => 200,
                        "message" => "Success",
                        "data" => $array
                    ]);
                } else {
                    return $this->respond([
                        "status" => 400,
                        "message" => "User doesnt exist"
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

    //--------------------------------------------------GET USER DETAILS ENDS------------------------------------------------------------




    //--------------------------------------------------UPDATE USER PROFILE STARTS------------------------------------------------------------
    //-----------------------------------------------****************************----------------------------------------------------------

    /**
     * Function to update User Profile
     * 
     * JSON data is passed into this function to update user profile using
     * @method POST with 
     * @param mixed $user_id, @param string $fname, @param string $lname,
     * @param mixed $email, @param mixed $dob, @param string $image [Base64 encoded]  
     * @return [JSON] Success|Fail
     */
    public function update_profile()
    {

        $json = $this->request->getJSON();
        if (
            !property_exists($json, 'user_id') || !property_exists($json, 'fname') || !property_exists($json, 'lname') || !property_exists($json, 'email')
            || !property_exists($json, 'dob') || !property_exists($json, 'image') || !property_exists($json, 'gender') || !property_exists($json, 'key')
        ) {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $con = new UsersModel();
            $con1 = new UserDetailsModel();
            $common = new CommonModel();

            //$data = $this->request->getJSON();
            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;

            if ($key == $api_key) {

                $id = $json->user_id;
                $fname = $json->fname;
                $lname = $json->lname;
                $email = $json->email;
                $dob = $json->dob;
                $gender = $json->gender;
                $file = $json->image;
                $image = '';
                if (!is_null($file)) {

                   //$image = generateImage($file);
                   $image = generateS3Object("images",$file,"png"); 
                
                    $array = [
                        "fname" =>  $fname,
                        "lname" =>  $lname,
                        "dob" =>  $dob,
                        "gender" =>  $gender,
                        "profile_pic" =>  $image
                    ];
                } else {

                    $array = [
                        "fname" =>  $fname,
                        "lname" =>  $lname,
                        "dob" =>  $dob,
                        "gender" =>  $gender,
                    ];
                }

                if (($res = $con->update_email($id, $email)) != 0) {

                    $users_id = $res;

                    $date = date('Y-m-s H:i:s');

                    if (!is_null($con1->update_user_details($users_id, $array))) {

                        if ($image != "") {

                            //Insert into alert_details table
                            $arr_alerts = array(
                                'type_id' => 4,
                                'user_id' => $id,
                                'profile_pic_id' => $id,
                                'description' => 'You have succesfully updated your profile picture on' . $date,
                                'status' => 2,
                                'created_on' => $date,
                                'updated_on' => $date
                            );

                            $common->insert_records_dynamically('alert_regular_user', $arr_alerts);
                        } else {
                            //Insert into alert_details table
                           
                            $arr_alerts = array(
                                'type_id' => 4,
                                'user_id' => $id,
                                'profile_pic_id' => $id,
                                'description' => 'You have succesfully updated your profile on' . $date,
                                'status' => 2,
                                'created_on' => $date,
                                'updated_on' => $date
                            );

                            $common->insert_records_dynamically('alert_regular_user', $arr_alerts);
                        }



                        return $this->respond([
                            "status" => 200,
                            "message" =>  "Successfully Updated",
                            "image" => $image
                        ]);
                    } else {

                        return $this->respond([
                            "status" => 400,
                            "message" =>  "Failed to Update"
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


    //--------------------------------------------------UPDATE USER PROFILE ENDS------------------------------------------------------------


    //--------------------------------------------------DELETE USER ADDRESS START------------------------------------------------------------

    public function delete_address()
    {

        $json = $this->request->getJSON();
        if (!property_exists($json, 'id') || !property_exists($json,'key')) {
            return $this->respond([
                'status' => 403,
                'message' => 'Invalid Parameters'
            ]);
        } else {
            $id = $this->request->getJsonVar('id');
            $key = md5($json->key); //BbJOTPWmcOaAJdnvCda74vDFtiJQCSYL

            $apiconfig = new \Config\ApiConfig();

            $api_key = $apiconfig->user_key;
            $con = new AddressModel();
            if ($key == $api_key) {

                $id = $json->id;
                if ($con->delete_address($id) != 0) {
                    return $this->respond([
                        "status" => 200,
                        "message" =>  "Successfully Deleted"
                    ]);
                } else {
                    return $this->respond([
                        "status" => 400,
                        "message" =>  "Failed to delete"
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
//--------------------------------------------------DELETE USER ADDRESS END------------------------------------------------------------