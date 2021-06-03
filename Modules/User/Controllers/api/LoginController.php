<?php

namespace Modules\User\Controllers\api;

use CodeIgniter\RESTful\ResourceController;
use Modules\User\Models\UsersModel;

class LoginController extends ResourceController
{
	// User Login Function 
	public function login()
	{
		$json = $this->request->getJSON();
		$type = $json->type;
		$id = $json->username;
		$pass = $json->password;

		$log = new UsersModel();
		$var = $log->login_user($id, $type, $pass);

		if ($var != null) {
			return $this->respond( [
				"status" => 200,
				"message" => "User Exists",
				"user id" => $var['id']
			]);

		} else {
			return $this->respond([
				"status" => 404,
				"message" => "User Not Found"
			]);
		}	
			}
}
