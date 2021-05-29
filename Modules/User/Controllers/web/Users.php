<?php

namespace Modules\User\web;

use App\Controllers\BaseController;

//Models required for registration
use Modules\User\Models\ZipcodeModel;
use Modules\User\Models\CityModel;
use Modules\User\Models\StateModel;
use Modules\User\Models\CountryModel;
use Modules\User\Models\AddressModel;
use Modules\User\Models\UserDetailsModel;
use Modules\User\Models\UsersModel;

use function PHPUnit\Framework\isEmpty;

class Users extends BaseController
{
	public function new_user()
    {
       
        //creating New Models
        $zip_model = new ZipcodeModel();
        $city_model = new CityModel();
        $state_model = new StateModel();
        $country_model = new CountryModel();
        $address_model = new AddressModel();
        $userdetails_model = new UserDetailsModel();
        $users_model = new UsersModel();

        //JSON Objects declared into variables
        $fname = $this->input->post('first_name');
        $lname = $this->input->post('last_name');
        $mobile = $this->input->post('mobile');
        $email = $this->input->post('email');
        $dob = $this->input->post('dob');
        $facebook_id = $this->input->post('facebook_id');
        $twitter_id = $this->input->post('twitter_id');
        $google_id = $this->input->post('google_id');
        $password = $this->input->post('password');
        $city = $this->input->post('city');
        $state = $this->input->post('state');
        $country = $this->input->post('country');
        $zip = $this->input->post('zip');
        $address = $this->input->post('address');
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');


        $re = $users_model->search_mobile($mobile);

        if ($re == 1) {

            $res = $users_model->search_email($email);

            if ($res == 1) {


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

                if (isEmpty($facebook_id)) {

                    if (isEmpty($google_id)) {

                        if (isEmpty($twitter_id)) {
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

                    $address_model->update_address_by_id($address_id,["users_id"=>$user_id]);

                    return $user_id;
                }
            } else {
                $message = "Email Address Already Exists";
                return $message;
            }
        } else {
            $message = "User Already Exists with this Mobile Number";
            return $message;
        }
    }


	public function show($id = null)
	{
		$data = new UsersModel();
		$user = $data->search_user($id);
		
        if($user != null){
        return $user;
	    }
    else{
            return "User Not Found";
        }
	}

}

