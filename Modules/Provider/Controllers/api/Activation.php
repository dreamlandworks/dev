<?php

namespace Modules\Provider\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use Modules\Provider\Models\ActivationModel;

class Activation extends ResourceController
{
	function sp_activation()
	{

		$con = new ActivationModel();

		//Get JSON Data to variables
		$data = $this->request->getJson();
		$users_id = $data->id;
		$profession = $data->profession;
		$qualification = $data->qualification;
		$experience = $data->experience;
		$about = $data->about;
		$key = $data->keywords;

		//Get Profession Id by Profession
		$p = $con->get_profession($profession);
		$p_id = '';

		if ($p != null) {
			$p_id = $p['id'];
		}

		//Get Qualification ID by Qualification
		$q = $con->get_qual_id($qualification);
		$q_id = '';

		if ($q != null) {
			$q_id = $q['id'];
		}

		//Get Qualification ID by Qualification
		$exp = $con->get_exp_id($experience);
		$exp_id = '';

		if ($exp != null) {
			$exp_id = $exp['id'];
		}

		$load = [
			'users_id' => $users_id,
			'profession_id' => $p_id,
			'qual_id' => $q_id,
			'exp_id' => $exp_id,
			'about_me' => $about
		];

		//Add data into sp_det table
		if (($con->add_sp_det($load)) != null) {
			//Add Keywords in sp_skill tables
			if (($con->add_sp_skill($users_id, $key)) != null) {
				//Add Other functionality

				
			} else {
				return $this->respond([
					"status" => 400,
					"message" => "Failed to add data in sp_skill table"
				]);
			}
		} else {
			return $this->respond([
				"status" => 400,
				"message" => "Failed to add data in sp_det table"
			]);
		}
	}
}
