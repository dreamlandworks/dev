<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\User\Models\SmsTemplateModel;
use Modules\User\Models\TempUserModel;
use Modules\User\Models\UsersModel;


class SmsController extends ResourceController
{
	/**
	 * Return all SMS Templates Listed in the DB
	 *
	 * @return mixed
	 */
	public function index()
	{
		$sms_model = new SMSTemplateModel();
		$res = $sms_model->findAll();
		return $this->respond([
			"status" => 200,
			"message" => "Success",
			"data" => $res
		]);
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
			return $this->respond([
				"status" => 200,
				"message" => "Success",
				"data" => $res
			]);
		} else {
			return $this->respond([
				"status" => 400,
				"message" => "Enter Valid Name of SMS Template"
			]);
		}
	}

	
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

		$pe_id = $this->request->getVar('pe_id');
		$header_id = $this->request->getVar('header_id');
		$template_id = $this->request->getVar('template_id');
		$sender = $this->request->getVar('sender');
		$name = $this->request->getVar('name');
		$content = $this->request->getVar('content');
		$var = $this->request->getVar('var');

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
			return $this->respond([
				"status" => 400,
				"message" => "Please check the input"
			]);
		} else {
			return $this->respond([
				"status" => 200,
				"message" => "Successfully Inserted",
				"SMS ID" => $res
			]);
		}
	}

	//function to send SMS
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

		$json = $this->request->getJSON();

		$fname = $json->fname;
		$lname = $json->lname;
		$phone = $json->mobile;
		$ref_id = $json->ref;


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

				return $this->respond([
					"status" => 200,
					"message" => "OK",
					"response" => $res,
					"OTP" => $otp
				]);
			} else {

				return $this->respond([
					"status" => 404,
					"message" => "Not Successful",
					"response" => $res,
					"OTP" => "null"
				]);
			}
		}
	}
	//Function to generate and send SMS of Forgot Password OTP
	public function forgot_sms(){

		
		$mobile = $this->request->getJsonVar('mobile');
		
		$new = new UsersModel();
		if($new->search_mobile($mobile) != null ){

			$name = 'User';
			$otp = random_int(1000, 9999);

			$data = [
				"name" => "Forgot_OTP",
				"mobile" => $mobile,
				"dat" => [
					"var1" => $name,
					"var2" => $otp
				]
			];

			if (($res = $this->sendSms($data)) != null) {

				return $this->respond([
					"status" => 200,
					"message" => "OK",
					"response" => $res,
					"OTP" => $otp
				]);
			} else {

				return $this->respond([
					"status" => 404,
					"message" => "Not Successful",
					"response" => $res,
					"OTP" => "null"
				]);
			}
		}
		else{
		
			return $this->respond([
				"status" => 404,
				"message" => "User Not Found",
				]);
		}
	}

}
