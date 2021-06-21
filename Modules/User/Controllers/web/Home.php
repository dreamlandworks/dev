<?php

namespace Modules\User\Controllers\web;

use App\Controllers\BaseController;

class Home extends BaseController
{
	public function index()
	{
		return view('Modules\User\Views\index');
	}
}
