<?php

namespace Modules\Admin\Controllers\web;

use \Config\Services\session;

use Modules\Provider\Models\CommonModel;
use Modules\Admin\Models\MiscModel;
use Modules\User\Models\ZipcodeModel;
use Modules\User\Models\CityModel;
use Modules\User\Models\StateModel;
use Modules\User\Models\CountryModel;
use Modules\User\Models\AddressModel;
use Modules\User\Models\AlertModel;
use Modules\User\Models\ReferralModel;
use Modules\User\Models\UserDetailsModel;
use Modules\User\Models\UsersModel;
use Modules\User\Models\TempUserModel;

use Modules\User\Models\SmsTemplateModel;

use App\Controllers\BaseController;
use DateTime;

class Users extends BaseController
{


    //---------------------------------------------------------Dashboard-------------------------------------------------
    //-------------------------------------------------------------**************** -----------------------------------------------------

    // Function to load create user form
    public function create_user()
    {
        return view('Modules\Admin\Views\users\createNewUser');
    }


    //Function to get list of users
    public function list_users()
    {
        $misc_model = new MiscModel();

        //Get users list
        $arr_users =  $misc_model->get_users_list();

        foreach ($arr_users as $key => $val) {

              $data[$key]['id'] = $val['id'];
              $data[$key]['fname'] = $val['fname'];
              $data[$key]['lname'] = $val['lname'];
              $data[$key]['mobile'] = $val['mobile'];
              $data[$key]['dob'] = $val['dob'];
              $data[$key]['gender'] = $val['gender'];
              $data[$key]['profile_pic'] = $val['profile_pic'];
              $data[$key]['reg_status'] = $val['reg_status'];
              $data[$key]['registered_on'] = $val['registered_on'];
              $data[$key]['referral_id'] = $val['referral_id'];
              $data[$key]['points_count'] = $val['points_count'];
              $data[$key]['email'] = $val['email']; 
              $data[$key]['status'] = $val['active']; 

            $today = new DateTime('now');
            $start = new DateTime($val['registered_on']);


            $abs_diff = $today->diff($start)->format("%a");
            $data[$key]['days'] = $abs_diff." days"; 

        }

        $dat['arr_users'] = $data;

        // echo "<pre>";
        // print_r($dat['arr_users']);
        // echo "</pre>";
        // exit;

        return view('Modules\Admin\Views\users\listUsers', $dat);
    }

    
    // Edit User Function 

    public function edit_users($id)
    {
        $misc_model = new MiscModel();
        $data['users'] = $misc_model->get_users($id);
        return view('Modules\Admin\Views\users\editUsers', $data);
    }

    
    // Function to submit data for user creation
    
    public function create_user_submit()
    {
        $session = \Config\Services::session();

        /*echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		exit;*/

        //creating New Models

        $users_model = new UsersModel();
        $common = new CommonModel();
        $userdetails_model = new UserDetailsModel();

        //JSON Objects declared into variables
        $fname = $this->request->getVar('fname');
        $lname = $this->request->getVar('lname');
        $mobile = $this->request->getVar('mobile');
        $email = $this->request->getVar('email');
        $dob = $this->request->getVar('dob');
        $gender = $this->request->getVar('gender');
        $password = "password";
        $referral_id = $this->request->getVar('referral_id');

        $image = '';

        $img = $this->request->getFile('profile_pic');

        //echo $img->getName();
        if ($img->getName()) {
            if (!$img->hasMoved()) {
                $newName = $img->getRandomName();
                $img->move('./images/user_profile', $newName);
                $image = '/images/user_profile/' . $newName;
            }
        }

        if (empty($referral_id)) {
            $referral_id = "NoRef";
        }

        $validate_user_result = $users_model->search_by_email_mobile($email, $mobile);

        $existing_mobile = "";
        $existing_email = "";

        if ($validate_user_result != 'failure') {
            $existing_mobile = $validate_user_result->userid;
            $existing_email = $validate_user_result->email;
        }


        if (($existing_email != $email) && ($existing_mobile != $mobile)) {

            $reg_status = 1;

            $data1 = [

                'fname' => $fname,
                'lname' => $lname,
                'mobile' => $mobile,
                'dob' => $dob,
                'gender' => strtolower($gender),
                'reg_status' => $reg_status,
                'profile_pic' => $image
            ];

            $users_id = $common->insert_records_dynamically('user_details', $data1);

            $data2 = [

                'userid' => $mobile,
                'password' => $password,
                'email' => $email,
                'sp_activated' => 1,
                'users_id' => $users_id,
                'activation_code' => 4

            ];

            $user_id = $common->insert_records_dynamically('users', $data2);

            if ($user_id) {

                $bb = $this->create_ref($fname, $mobile, $referral_id, $user_id);
                $dd = $userdetails_model->update_user_details($users_id, ['referral_id' => $bb['id']]);

                //if ($aa != 0 && $bb != null && $cc != 0 && $dd != null && $ale > 0) {
                if ($bb != null && $dd != null) {

                    //Send SMS
                    $sms_model = new SmsTemplateModel();

                    $data = [
                        "name" => "reg_thanks",
                        "mobile" => $mobile,
                        "dat" => [
                            "var" => $fname,
                        ]
                    ];

                    $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);

                    //echo "1";exit;

                    $session->setFlashData('success', 'User Successfully Created with User ID' . $user_id);

                    return redirect('ct/listUsers');
                } else {
                    $session->setFlashData('error', 'There is problem with address or referral_id');
                    return redirect('ct/createNewUser');
                }
            } else {
                $session->setFlashData('error', 'Unable to Create User');
                return redirect('ct/createNewUser');
            }
        } else {

            $session->setFlashData('error', 'User Already Exists with this Mobile Number or Email');
            //return redirect()->to(site_url('/ct/createNewUser'));

            return redirect('ct/createNewUser');
        }
    }



     //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

    //-------------------------------------------------------------CREATE REF---------------------------------------------------------
    public function create_ref($fname, $mobile, $referred_by, $user_id)
    {
        //output -> referral_id (first four letters of fname + first four numbers of mobile) for uniqueness
        //		 -> referred_by (referral id of person referred)
        // 		 -> User_id for user
        $db = new ReferralModel();
        //$referral_id = substr($fname, 0, 4) . substr($mobile, 0, 4);
        $referral_id = $mobile;
        $data = [
            "referral_id" => $referral_id,
            "referred_by" => $referred_by,
            "user_id" => $user_id
        ];

        if (($res = $db->creat_ref($data)) != 0) {
            return $res;
        } else {
            return null;
        }
    }

     //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

    //-------------------------------------------------------------DELETE TEMP---------------------------------------------------------
    public function delete_temp($mobile = null)
    {
        $new = new TempUserModel();
        $res = $new->delete_temp($mobile);
        if ($res != 0) {
            return $res;
        } else {
            return 0;
        }
    }

     //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

    //-------------------------------------------------------------EDIT USER SUBMIT---------------------------------------------------------
    public function edit_user_submit()
    {
        $session = \Config\Services::session();

        $common = new CommonModel();
        //Get Data
        $id = $this->request->getVar('id');
        $fname = $this->request->getVar('fname');
        $lname = $this->request->getVar('lname');
        $mobile = $this->request->getVar('mobile');
        $email = $this->request->getVar('email');
        $dob = $this->request->getVar('dob');
        $gender = $this->request->getVar('gender');
        $active = $this->request->getVar('active');
        $reason = $this->request->getVar('reason');
        
        $img = $this->request->getFile('profile_pic');

        //echo $img->getName();
        if ($img->getName()) {
            if (!$img->hasMoved()) {
                $newName = $img->getRandomName();
                $img->move('./images/user_profile', $newName);
                $image = '/images/user_profile/' . $newName;

                $data = [
                    'fname' => $fname,
                    'lname' => $lname,
                    'mobile' => $mobile,
                    'dob'  => $dob,
                    'gender' => $gender,
                    'profile_pic' => $image
                ];
            }
        }else{
            
            $data = [
                'fname' => $fname,
                'lname' => $lname,
                'mobile' => $mobile,
                'dob'  => $dob,
                'gender' => $gender                
            ];
            
        }
        

        $data1 = [
            'userid' => $mobile,
            'email' => $email,
            'active' => $active,
            'reason_for_ban' => ($reason != "" ? $reason : Null),
        ];

        $common->update_records_dynamically('user_details', $data, 'id', $id);
        $common->update_records_dynamically('users', $data1, 'id', $id);

        $session->setFlashData('success', 'User Successfully Updated');
        return redirect('ct/listUsers');
    }
    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

    //-------------------------------------------------------------DELETE USER---------------------------------------------------------
    public function delete_user($id)
    {

        $model = new CommonModel;

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

        $session = session();

        foreach ($data as $det) {
            $i = 0;

            if ($i < count($det)) {
                $model->delete_records_dynamically($det[$i], $det[$i + 1], $id);
                $i++;
            }
        }

        $session->setFlashData('success', 'User Successfully Deleted');
        return redirect('ct/listUsers');
    }



    //-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------

}
