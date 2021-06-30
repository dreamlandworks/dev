<?php

namespace Modules\User\Controllers\web;

use App\Controllers\BaseController;
use Modules\User\Models\UserDetailsModel;
use Modules\User\Models\UsersModel;

class Login extends BaseController
{
	// User Login Function 
	public function login()
	{

		$type = $this->request->getVar('type');
		$id = $this->request->getVar('mobile');
		$pass = $this->request->getVar('password');

		if ($type == null || !isset($type)) {
			$type = "login";
		}

		$log = new UsersModel();
		$var = $log->login_user($id, $type, $pass);

		if ($var != null) {
			log_message('info', $var['id']);

			$res = new UserDetailsModel;
			$user = $res->user_details_by_id($var['id']);
			$name = $user['fname'] . " " . $user['lname'];

			$data = [
				'id' => $var['id'],
				'name' => $name,
				'type' => $type
			];

			session()->set($data);
			if ($type == 'google' || $type == 'login') {
				return "success";
			}
			return redirect('/');
		} else {

			$error = "Looks like you don't have account. Create yours for free!";
			session()->setFlashdata('error', $error);
			return "fail";
			log_message('error', "User Not Found");
		}
	}

	function logout()
	{
		
		$type = $this->request->getVar('type');


		session()->destroy();

			return "success";
		

		return redirect('/');
	}
}
