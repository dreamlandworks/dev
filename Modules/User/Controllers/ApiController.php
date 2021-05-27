<?php

namespace Modules\User\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Modules\User\Models\AddressModel;
//Models required for registration
use Modules\User\Models\UsersModel;
use Modules\User\Models\SmsTemplateModel;


class ApiController extends ResourceController
{
	
	/**
	 * Return an array of resource objects, themselves in array format
	 *
	 * @return mixed
	 */
	public function index()
	{
		//
	}

	/**
	 * Return the properties of a resource object
	 *
	 * @return mixed
	 */
	
	public function sendSms()
	{
		$json = $this->request->getJSON();

		$res = new SmsTemplateModel();

		$array = [

			"pe_id"=>$json->pe_id,
			"header_id"=>$json->header_id,
			"template_id"=>$json->template_id,
			"name"=>$json->name,
			"content"=>$json->content,
			"var"=>$json->var

		];

		$result = $res->add_sms($array);

		return $this->respond([
			"status"=>200,
			"message"=>"Success",
			"sms_id"=>$result

		]);
		
	}
		
		
	}
		
