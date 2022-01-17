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

use Modules\User\Models\SmsTemplateModel;

use App\Controllers\BaseController;

class Users extends BaseController
{
    
    
    //---------------------------------------------------------Dashboard-------------------------------------------------
	//-------------------------------------------------------------**************** -----------------------------------------------------

	public function create_user()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\users\createNewUser');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function list_users()
	{
		$misc_model = new MiscModel();
		
		//Get users list
		$arr_users =  $misc_model->get_users_list(); 
		/*echo "<pre>";
		print_r($arr_users);
		echo "</pre>";
		exit;*/
		$data['arr_users'] = $arr_users;
		
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\users\listUsers',$data);
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function edit_users()
	{
		echo view('\Modules\Admin\Views\_layout\header');
		echo view('\Modules\Admin\Views\_layout\sidebar'); 
		echo view('\Modules\Admin\Views\users\editUsers');
		echo view('\Modules\Admin\Views\_layout\footer');
	}
	
	public function create_user_submit()
	{
		$session = \Config\Services::session();
		
		/*echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		exit;*/
		
        //creating New Models
        $zip_model = new ZipcodeModel();
        $city_model = new CityModel();
        $state_model = new StateModel();
        $country_model = new CountryModel();
        $address_model = new AddressModel();
        $userdetails_model = new UserDetailsModel();
        $users_model = new UsersModel();
        $alert_model = new AlertModel();
        $common = new CommonModel();
    
        //JSON Objects declared into variables
        $fname = $this->request->getVar('fname');
        $lname = $this->request->getVar('lname');
        $mobile = $this->request->getVar('mobile');
        $email = $this->request->getVar('email');
        $dob = $this->request->getVar('dob');
        $gender = $this->request->getVar('gender');
        $password = $this->request->getVar('password');
        $city = $this->request->getVar('city');
        $state = $this->request->getVar('state');
        $country = $this->request->getVar('country');
        $zip = $this->request->getVar('postal_code');
        $address = $this->request->getVar('address');
        $referral_id = $this->request->getVar('referral_id');

        if (empty($referral_id)) {
            $referral_id = "NoRef";
        }
        
        $validate_user_result = $users_model->search_by_email_mobile($email,$mobile);
        //echo "<br> str ".$users_model->getLastQuery();exit;
        
        $existing_mobile = "";
        $existing_email = "";
        
        if($validate_user_result != 'failure') {
            $existing_mobile = $validate_user_result->userid;
            $existing_email = $validate_user_result->email;
        }
        
        /*echo "<pre>";
        print_r($validate_user_result);
        echo "</pre>";*/
        /*exit;*/
        //$re = $users_model->search_mobile($mobile);

        if ($existing_mobile != $mobile) {

            if ($existing_email != $email) {
                $country_id = $country_model->search_by_country($country);
                if ($country_id == 0) {
                    $country_id = $country_model->create_country($country);
                }
                $state_id = $state_model->search_by_state($state);
                if ($state_id == 0) {
                    $state_id = $state_model->create_state($state, $country_id);
                }  
                $city_id = $city_model->search_by_city($city);
                if ($city_id == 0) {
                    $city_id = $city_model->create_city($city, $state_id);
                } 
                $zip_id = $zip_model->search_by_zipcode($zip);
                if ($zip_id == 0) {
                    $zip_id = $zip_model->create_zip($zip, $city_id);
                }    
                
                //name,flatno,apartment_name,landmark will be added later 
                //after observing the realtime data from google api

                $data = [
                    'name' => "",
                    'flat' => "",
                    'apartment' => "",
                    'landmark' => "",
                    'locality' => $address,
                    'city_id' => $city_id,
                    'state_id' => $state_id,
                    'country_id' => $country_id,
                    'zipcode_id' => $zip_id
                    
                ];

                $address_id = $address_model->create_address_default($data);
                $reg_status = 3;

                $data1 = [

                    'fname' => $fname,
                    'lname' => $lname,
                    'mobile' => $mobile,
                    'dob' => $dob,
                    'gender'=>strtolower($gender),
                    'reg_status' => $reg_status,
                ];

                $users_id = $userdetails_model->create_user_details($data1);

                $data2 = [
                    'mobile' => $mobile,
                    'password' => $password,
                    'email' => $email,
                    'users_id' => $users_id
                ];

                $user_id = $users_model->create_user_default($data2);

                if ($user_id) {

                    $aa = $address_model->update_address_by_id($address_id, ["users_id" => $user_id]);
                    $bb = $this->create_ref($fname, $mobile, $referral_id, $user_id);
                    $cc = $this->delete_temp($mobile);
                    $dd = $userdetails_model->update_user_details($users_id, ['referral_id' => $bb['id']]);
                    
                    if ($aa != 0 && $bb != null && $cc != 0 && $dd != null && $ale > 0) {
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
            			
            			echo "1";exit;
            			
            			$session->setFlashdata('success', 'User Successfully Created');
            			
            			return redirect('/listUsers');
                    } else {
                        echo "2";exit;
                        $session->setFlashdata('error', 'There is problem with address or referral_id');
                        return redirect('/createNewUser');
                    }
                }
            } else {
                echo "3";exit;
                $session->setFlashdata('error', 'Email Address Already Exists');
                return redirect('/createNewUser');
            }
        } else {
            echo "4";exit;
            $session->setFlashdata('error', 'User Already Exists with this Mobile Number');
            //return redirect()->to(site_url('/ct/createNewUser'));
            
            return redirect('/createNewUser');
        }
	}
	//-------------------------------------------------------------FUNCTION ENDS---------------------------------------------------------
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
}
