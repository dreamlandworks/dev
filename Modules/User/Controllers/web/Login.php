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
		// $type = $this->input->post('type');
		// $id = $this->input->post('username');
		// $pass = $this->input->post('password');

		$type = $this->request->getVar('type');
		$id = $this->request->getVar('mobile');
		$pass = $this->request->getVar('password');

		if ($type == null || !isset($type)) {
			$type = "login";
		}

		$log = new UsersModel();
		$var = $log->login_user($id, $type, $pass);

		$session = session();

		if ($var != null) {
			log_message('info', $var['id']);

			$res = new UserDetailsModel;
			$user = $res->user_details_by_id($var['id']);
			$name = $user['fname'] . " " . $user['lname'];

			$session->setFlashdata('id', $var['id']);
			$session->setFlashdata('name', $name);

			return redirect('/');
		} else {

			$session->setFlashdata('error', "Looks like you don't have account. Create yours for free!");
			log_message('error', "User Not Found");
		}
	}

	function logout() {
			
			$session = session();
			$session->setFlashdata('id', "");
			$session->setFlashdata('name', "");

			return redirect('/');
	}
}
