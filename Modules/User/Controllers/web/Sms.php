<?php

namespace Modules\User\web;

use App\Controllers\BaseController;

use CodeIgniter\RESTful\ResourceController;
use Modules\User\Models\SmsTemplateModel;
use Modules\User\Models\TempUserModel;
use Modules\User\Models\UsersModel;

class Sms extends BaseController
{
	public function index()
	{
		$sms_model = new SMSTemplateModel();
		$res = $sms_model->findAll();
		return $res;
	}

	/**
	 * Return the SMS Template Details by ID/ Name
	 *
	 * @return mixed
	 */
	public function show($name = null)
	{
		$sms_model = new SMSTemplateModel();

		if (is_numeric($name)) {
			$res = $sms_model->show_by_id($name);
		} elseif (is_string($name)) {
			$res = $sms_model->show_by_name($name);
		}

		if ($res != null) {
			return $res;
			
		} else {
			return "Enter Valid Name of SMS Template";
		}
	}

	/**
	 * Create a new resource object, from "posted" parameters
	 *
	 * @return mixed
	 */
	//Required array with fields->pe_id,header_id,template_id,name,content,var=(no of var objects in content)
	//Example of json: -
	// {
	// 	"pe_id": "1201160830805420000",
	// 	"header_id": "STRNGO",
	// 	"template_id": "1207161466020972398",
	// 	"name": "search_temp",
	// 	"content": "Dear {#var#}\r\nWe have noticed that you searched for {#var1#} but not proceeded further. If you need any support, we are available on call/sms/whatsapp/skype/Viber/line on {#var2#}",
	// 	"var": "3"
	// }

	public function create()
	{
		$sms_model = new SMSTemplateModel();

		$pe_id = $this->input->post('pe_id');
		$header_id = $this->input->post('header_id');
		$template_id = $this->input->post('template_id');
		$sender = $this->input->post('sender');
		$name = $this->input->post('name');
		$content = $this->input->post('content');
		$var = $this->input->post('var');

		$array = [
			"pe_id" => $pe_id,
			"header_id" => $header_id,
			"template_id" => $template_id,
			"sender" => $sender,
			"name" => $name,
			"content" => $content,
			"var" => $var
		];

		$res = $sms_model->add_sms($array);

		if ($res == null) {
			return "Please check the input";
		} else {
			return $res;
		}
	}

	//function to send SMS
	//call from other functions to send sms
	public function sendSms($data)
	{

		$sms_model = new SmsTemplateModel();

		$res = $sms_model->sms_api_url($data['name'], $data['mobile'], $data['dat']);

		return $res;
	}

	//Function to create OTP and save during registration
	public function reg_sms()
	{
		$new = new TempUserModel();

		$fname = $this->input->post('fname');
		$lname = $this->input->post('lname');
		$phone = $this->input->post('phone');

		$otp = random_int(1000, 9999);

		$array = [
			"fname" => $fname,
			"lname" => $lname,
			"mobile" => $phone,
			"otp" => $otp
		];

		$res = $new->add_temp_user($array);

		if ($res == null) {
			$res = null;
		} else {
			$data = [
				"name" => "Register_OTP",
				"mobile" => $phone,
				"dat" => [
					"var1" => $fname,
					"var2" => $otp
				]
			];

			if (($res = $this->sendSms($data)) != null) {

				return "success";
									
			} else {

				return $res;
					
			}
		}
	}

	public function forgot_sms($mobile){

		$new = new UsersModel();
		if(($new->search_email($mobile)) ==0 ){
			$name = "User";
			$otp = random_int(1000, 9999);

			$data = [
				"name" => "Register_OTP",
				"mobile" => $mobile,
				"dat" => [
					"var1" => $name,
					"var2" => $otp
				]
			];

			if (($res = $this->sendSms($data)) != null) {

				return "success";
									
			} else {

				return $res;
					
			}
		}
	}


}
