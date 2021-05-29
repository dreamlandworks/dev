<?php

namespace Modules\User\web;

use App\Controllers\BaseController;
use Modules\User\Models\UsersModel;

class Login extends BaseController
{
	// User Login Function 
	public function login()
	{
		$type = $this->input->post('type');
		$id = $this->input->post('username');
		$pass = $this->input->post('password');

		$log = new UsersModel();
		$var = $log->login_user($id, $type, $pass);

		if ($var != null) {
			return $var['id'];
	
		} else {
			return "User Not Found";
			
		}	
			}
}
