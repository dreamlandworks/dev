<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Config\Mimes;
//Models required for registration
use Modules\User\Models\ZipcodeModel;
use Modules\User\Models\CityModel;
use Modules\User\Models\StateModel;
use Modules\User\Models\CountryModel;
use Modules\User\Models\AddressModel;
use Modules\User\Models\TempUserModel;
use Modules\User\Models\UserDetailsModel;
use Modules\User\Models\UsersModel;

use function PHPUnit\Framework\isEmpty;

class UsersController extends ResourceController
{

    //Function to create New Users
    public function new_user()
    {

        if ($this->request->getMethod() != 'post') {

            $this->respond([
                "status" => 405,
                "message" => "Method Not Allowed"
            ]);
        } else {

            //creating New Models
            $zip_model = new ZipcodeModel();
            $city_model = new CityModel();
            $state_model = new StateModel();
            $country_model = new CountryModel();
            $address_model = new AddressModel();
            $userdetails_model = new UserDetailsModel();
            $users_model = new UsersModel();

            //getting JSON data from API
            $json = $this->request->getJSON();

            //JSON Objects declared into variables
            $fname = $json->first_name;
            $lname = $json->last_name;
            $mobile = $json->mobile_no;
            $email = $json->email_id;
            $dob = $json->dob;
            $facebook_id = $json->facebook_id;
            $twitter_id = $json->twitter_id;
            $google_id = $json->google_id;
            $password = $json->password;
            $city = $json->city;
            $state = $json->state;
            $country = $json->country;
            $zip = $json->postal_code;
            $address = $json->address;
            $latitude = $json->user_lat;
            $longitude = $json->user_long;
            $referral_id = $json->referral_id;

            if (empty($referral_id)) {
                $referral_id = "NoRef";
            }

            $re = $users_model->search_mobile($mobile);

            if ($re == null) {

                $res = $users_model->search_email($email);

                if ($res == null) {


                    //clause to check whether zip code exists

                    $zip_id = $zip_model->search_by_zipcode($zip);

                    if ($zip_id == 0) {

                        $city_id = $city_model->search_by_city($city);

                        if ($city_id == 0) {

                            $state_id = $state_model->search_by_state($state);

                            if ($state_id == 0) {

                                $country_id = $country_model->search_by_country($country);

                                if ($country_id == 0) {

                                    $country_id = $country_model->create_country($country);
                                } else {

                                    $state_id = $state_model->create_state($state, $country_id);
                                }
                            } else {
                                $city_id = $city_model->create_city($city, $state_id);
                            }
                        } else {
                            $zip_id = $zip_model->create_zip($zip, $city_id);
                        }
                    }

                    //name,flatno,apartment_name,landmark will be added later 
                    //after observing the realtime data from google api

                    $data = [
                        'name' => "",
                        'flat' => "",
                        'apartment' => "",
                        'landmark' => "",
                        'locality' => $address,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'pin_code' => $zip_id
                    ];

                    $address_id = $address_model->create_address($data);

                    if (empty($facebook_id)) {

                        if (empty($google_id)) {

                            if (empty($twitter_id)) {
                                $reg_status = 1;
                            } else {
                                $reg_status = 4;
                            }
                        } else {
                            $reg_status = 2;
                        }
                    } else {
                        $reg_status = 3;
                    }

                    $data1 = [

                        'fname' => $fname,
                        'lname' => $lname,
                        'mobile' => $mobile,
                        'dob' => $dob,
                        'reg_status' => $reg_status,
                    ];

                    $users_id = $userdetails_model->create_user_details($data1);

                    $data2 = [
                        'mobile' => $mobile,
                        'password' => $password,
                        'email' => $email,
                        'facebook_id' => $facebook_id,
                        'twitter_id' => $twitter_id,
                        'users_id' => $users_id
                    ];

                    $user_id = $users_model->create_user($data2);

                    if ($user_id) {

                        $aa = $address_model->update_address_by_id($address_id, ["users_id" => $user_id]);
                        $bb = $this->create_ref($fname, $mobile, $referral_id, $user_id);
                        $cc = $this->delete_temp($mobile);

                        if ($aa != 0 && $bb === "Success" && $cc != 0) {

                            return $this->respond([
                                "status" => 201,
                                "message" => "User Successfully Created",
                                "userId" => $user_id
                            ]);
                        } else {

                            return $this->respond([
                                "status" => 404,
                                "message" => "There is problem with address or referral_id"
                            ]);
                        }
                    }
                } else {
                    $message = "Email Address Already Exists";
                    return $this->respond([
                        "status" => 409,
                        "message" => $message
                    ]);
                }
            } else {
                $message = "User Already Exists with this Mobile Number";
                return $this->respond([
                    "status" => 409,
                    "message" => $message
                ]);
            }
        }
    }

    //Function to show user details

    public function show($id = null)
    {
        $data = new UsersModel();
        $user = $data->search_user($id);

        if ($user != null) {
            return $this->respond([
                "status" => 200,
                "message" => "Success",
                "data" => $user
            ]);
        } else {
            return $this->respond([
                "status" => 404,
                "message" => "User Not Found"
            ]);
        }
    }

    //Function to create referral ID
    public function create_ref($fname, $mobile, $referred_by, $user_id)
    {
        //output -> referral_id (first four letters of fname + first four numbers of mobile) for uniqueness
        //		 -> referred_by (referral id of person referred)
        // 		 -> User_id for user
        $db = \Config\Database::connect();
        $referral_id = substr($fname, 0, 4) . substr($mobile, 0, 4);

        $data = [
            "referral_id" => $referral_id,
            "referred_by" => $referred_by,
            "user_id" => $user_id
        ];

        $builder = $db->table('referral');
        if ($builder->insert($data)) {
            return "Success";
        } else {
            return "Fail";
        }
    }

    public function delete_temp($mobile = null)
    {
        $new = new TempUserModel();
        $res = $new->delete_temp($mobile);
        if ($res != 0) {
            return $res;
        }
        else{
            return 0;
        }
        
    }

    public function update_pass(){
        
        $new = new UsersModel();
        
        $id = $this->request->getJsonVar("id");
        $pass = $this->request->getJsonVar("password");

        $res = $new->update_pass($id,$pass);

        if($res !=0 ){
            return $this->respond([
                "status" => 200,
                "Message"=> "Success"
            ]);
        }
        else{
            return $this->respond([
                "status"=> 404,
                "Message" => "Not able to update Password"
            ]);
        }

    }
}
